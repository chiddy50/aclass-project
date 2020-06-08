<?php

use System\route;
use System\database\query;

Route::get('/', function () {

    Registry::set('token', Csrf::token());
    $pages = Page::where('status', '=', 'published')->get();
    Registry::set('pages', $pages);

    $sliders = Query::table(SliderImages::table())->get();
    $slider_images = array_map(function($item) {
        return '/' . SLIDER_DIR . '/' . $item->image_name;
    }, $sliders);
    $vars['slider_images'] = implode('|', $slider_images);

    return new Template('home', $vars);
});

Route::post('contact', function () {
    return Response::json([
        'msg' => 'cannot send mail in demo version',
    ]);
});

Route::get('(:all)', function () {
    return  Response::error(404);
});

Route::post('(:all)', function () {
    return Response::json([
        'msg' => 'page not found',
    ], 404);;
});
