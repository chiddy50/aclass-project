<?php

use System\config;
use System\database\query;
use System\input;
use System\route;
use System\view;

Route::collection(['before' => 'auth'], function () {

    /**
     * List Metadata
     */
    Route::get('admin/extend/metadata', function () {
        $vars = [
            'token' => Csrf::token(),
            'meta' => Config::get('meta')
        ];
        
        return View::create('extend/metadata/edit', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    /**
     * Update Metadata
     */
    Route::post('admin/extend/metadata', function () {
        $input = Input::get([
            'sitename',
            'description',
            'custom_email',
            'custom_address',
            'custom_phone',
            'custom_location_iframe',
            'custom_facebook',
            'custom_twitter',
            'custom_instagram',
        ]);

        if(strlen($input['custom_location_iframe']) > 0)
        {
            $src = preg_match('/<iframe src="(.+)">/', $input['custom_location_iframe'], $match);
            if(count($match) > 0)
            {
                $src = $match[1];
                $locationTpl = '<iframe class="width-100 height-100 border-none radius-10" src="%s" allowfullscreen></iframe>';
                $input['custom_location_iframe'] = sprintf($locationTpl, $src);
            }
        }
        
        foreach ($input as $key => $value) {
            $input[$key] = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('sitename')
                  ->is_max(3, __('metadata.sitename_missing'));

        $validator->check('description')
                  ->is_max(3, __('metadata.sitedescription_missing'));

        $validator->check('phone1')
                  ->is_regex('#^[0-9]+$#',
                      __('metadata.missing_posts_per_page', 'Please enter a phone number'));

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/extend/metadata');
        }

        // convert double quotes so we dont break html
        $input['sitename']    = e($input['sitename'], ENT_COMPAT);
        $input['description'] = e($input['description'], ENT_COMPAT);

        foreach ($input as $key => $v) {
            $v = is_null($v) ? 0 : $v;

            Query::table(Base::table('meta'))
                 ->where('key', '=', $key)
                 ->update(['value' => $v]);
        }

        Notify::success(__('metadata.updated'));

        return Response::redirect('admin/extend/metadata');
    });
});
