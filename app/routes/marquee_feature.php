<?php

use System\config;
use System\input;
use System\route;
use System\view;
use System\database\query;

Route::collection(['before' => 'auth,csrf'], function () {

    /**
     * List all marquee_feature
     */
    Route::get([
        'admin/marquee-feature',
        'admin/marquee-feature/(:num)'
    ], function ($page = 1) {
        $vars['marquee_features'] = MarqueeFeature::paginate($page, Config::get('admin.posts_per_page'));

        return View::create('marquee_feature/index', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    /**
     * Add Marquee Feature
     */
    Route::get('admin/marquee-feature/add', function () {
        $vars['token'] = Csrf::token();
        $vars['fontawesome'] = fontawesome_options();
       // extended fields
        $vars['fields'] = Extend::fields('marquee_feature');

        return View::create('marquee_feature/add', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/marquee-feature/add', function () {
        $input = Input::get(['icon', 'name']);

        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('name')
                  ->is_max(3, __('marquee_feature.name_missing'));
        $validator->check('icon')
                  ->is_max(3, __('marquee_feature.icon_missing'));

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/marquee-feature/add');
        }

        $marquee_feature = MarqueeFeature::create($input);

        Extend::process('marquee_feature', $marquee_feature->id);
        Notify::success("A marquee feature was added");

        return Response::redirect('admin/marquee-feature');
    });


    /**
     * Edit Marquee Feature
     */
    Route::get('admin/marquee-feature/edit/(:num)', function ($id) {
        $vars['token']    = Csrf::token();
        $vars['fontawesome'] = fontawesome_options();
        $vars['marquee_feature'] = MarqueeFeature::find($id);

        // extended fields
        $vars['fields'] = Extend::fields('marquee_feature', $id);

        return View::create('marquee_feature/edit', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/marquee-feature/edit/(:num)', function ($id) {
        $input = Input::get(['icon', 'name']);

        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('name')
                  ->is_max(3, __('event_marquee.name_missing'));

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/marquee-feature/edit/' . $id);
        }



        MarqueeFeature::update($id, $input);
        Extend::process('marquee_feature', $id);
        Notify::success("Your marquee feature has been updated");

        return Response::redirect('admin/marquee-feature/edit/' . $id);
    });

    /**
     * Delete Marquee Feature
     */
    Route::get('admin/marquee-feature/delete/(:num)', function ($id) {
        $total = MarqueeFeature::count();

        if ($total == 1) {
            Notify::error("You must have at least one marquee feature");

            return Response::redirect('admin/marquee-feature/edit/' . $id);
        }

        // delete selected
        MarqueeFeature::find($id)->delete();

        Notify::success("Your marquee feature has been deleted");

        return Response::redirect('admin/marquee-feature');
    });

});


