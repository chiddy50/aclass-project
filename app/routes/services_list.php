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
        'admin/services-list',
        'admin/services-list/(:num)'
    ], function ($page = 1) {
        $vars['services_list'] = ServicesList::paginate($page, Config::get('admin.posts_per_page'));

        return View::create('services_list/index', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    /**
     * Add Service
     */
    Route::get('admin/services-list/add', function () {
        $vars['token'] = Csrf::token();

        // extended fields
        $vars['fields'] = Extend::fields('service');

        return View::create('services_list/add', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/services-list/add', function () {
        $input = Input::get(['service']);

        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('service')
                  ->is_max(3, 'Service is missing');

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/services-list/add');
        }

        $service = ServicesList::create($input);

        Extend::process('service', $service->id);
        Notify::success("Your new service was created");

        return Response::redirect('admin/services-list');
    });


    /**
     * Edit service
     */
    Route::get('admin/services-list/edit/(:num)', function ($id) {
        $vars['token']    = Csrf::token();
        $vars['service'] = ServicesList::find($id);

        // extended fields
        $vars['fields'] = Extend::fields('service', $id);

        return View::create('services_list/edit', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/services-list/edit/(:num)', function ($id) {
        $input = Input::get(['service']);

        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('service')
                  ->is_max(3, 'Service is missing');

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/services-list/edit/' . $id);
        }



        ServicesList::update($id, $input);
        Extend::process('service', $id);
        Notify::success('Service has been updated');

        return Response::redirect('admin/services-list/edit/' . $id);
    });

    /**
     * Delete Marquee Feature
     */
    Route::get('admin/services-list/delete/(:num)', function ($id) {
        $total = ServicesList::count();

        // if ($total == 1) {
        //     Notify::error("You must have at least one marquee feature");

        //     return Response::redirect('admin/services-list/edit/' . $id);
        // }

        // delete selected
        ServicesList::find($id)->delete();

        Notify::success("Your service has been deleted");

        return Response::redirect('admin/services-list');
    });
});


