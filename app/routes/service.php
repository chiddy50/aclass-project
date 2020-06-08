<?php

use System\config;
use System\input;
use System\route;
use System\view;

Route::collection(['before' => 'auth,csrf'], function () {

    /**
     * List all service
     */
    Route::get([
        'admin/services',
        'admin/services/(:num)'
    ], function ($page = 1) {
        $vars['services'] = Service::paginate($page, Config::get('admin.posts_per_page'));

        return View::create('service/index', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    /**
     * Add Service
     */
    Route::get('admin/services/add', function () {
        $vars['token'] = Csrf::token();

        // extended fields
        $vars['fields'] = Extend::fields('service');
        $vars['fontawesome'] = fontawesome_options();

        return View::create('service/add', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/services/add', function () {
        $input = Input::get(['title', 'description', 'icon']);

        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('title')
                  ->is_max(3, __('service.title_missing'));
        $validator->check('icon')
                  ->is_max(3, __('service.icon_missing'));

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/services/add');
        }

        $service = Service::create($input);

        Extend::process('service', $service->id);
        Notify::success("Your new service was created");

        return Response::redirect('admin/services');
    });


    /**
     * Edit service
     */
    Route::get('admin/services/edit/(:num)', function ($id) {
        $vars['token']    = Csrf::token();
        $vars['service'] = Service::find($id);
        $vars['fontawesome'] = fontawesome_options();

        // extended fields
        $vars['fields'] = Extend::fields('service', $id);

        return View::create('service/edit', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/services/edit/(:num)', function ($id) {
        $input = Input::get(['title', 'description', 'icon']);

        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('title')
                  ->is_max(3, __('service.title_missing'));

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/services/edit/' . $id);
        }



        Service::update($id, $input);
        Extend::process('service', $id);
        Notify::success(__('service.updated'));

        return Response::redirect('admin/services/edit/' . $id);
    });

    /**
     * Delete Marquee Feature
     */
    Route::get('admin/services/delete/(:num)', function ($id) {
        $total = Service::count();

        // if ($total == 1) {
        //     Notify::error("You must have at least one marquee feature");

        //     return Response::redirect('admin/services/edit/' . $id);
        // }

        // delete selected
        Service::find($id)->delete();

        Notify::success("Your service has been deleted");

        return Response::redirect('admin/services');
    });
});


