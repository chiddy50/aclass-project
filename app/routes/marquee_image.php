<?php

use System\config;
use System\input;
use System\route;
use System\view;
use Verot\Upload\Upload;

Route::collection(['before' => 'auth,csrf'], function () {

    /**
     * List all marquee_image
     */
    Route::get([
        'admin/marquee-image',
        'admin/marquee-image/(:num)'
    ], function ($page = 1) {
        $vars['marquee_images'] = MarqueeImage::paginate($page, Config::get('admin.posts_per_page'));

        return View::create('marquee_image/index', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    /**
     * Add Marquee Image
     */
    Route::get('admin/marquee-image/add', function () {
        $vars['token'] = Csrf::token();
        $vars['event_marquees'] = EventMarquee::get();
        // extended fields
        $vars['fields'] = Extend::fields('marquee_image');

        return View::create('marquee_image/add', $vars)
        ->partial('header', 'partials/header')
        ->partial('footer', 'partials/footer');
    });

    Route::post('admin/marquee-image/add', function () {
        $input = Input::get(['event_marquee', 'img_name', 'is_banner']);

        $handle = new Upload($_FILES['img_name']);
        
        header('Content-type: ' . $handle->file_src_mime);
        if ($handle->uploaded and $handle->file_is_image) {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            function generate_string($input, $strength = 16) {
                $input_length = strlen($input);
                $random_string = '';
                for($i = 0; $i < $strength; $i++) {
                    $random_character = $input[mt_rand(0, $input_length - 1)];
                    $random_string .= $random_character;
                }
                return $random_string;
            }
            $img_name = generate_string($permitted_chars, 40);
            $ext = $handle->image_src_type;

            //Rename image
            $handle->file_new_name_body   = $img_name;
            $handle->image_resize         = true;
            // $handle->image_x              = 100;
            // $handle->image_y              = true;

            // uploads the file
            $handle->process(UPLOAD_DIR);
            if($handle->processed){
                echo 'Sucsessfully uploaded '.$handle->file_new_name_body;

                //Deletes the uploaded file from its temporary location
                $handle->clean();
            }else{
                echo 'error : ' . $handle->error;
            }
        }

        $input['img_name'] = $img_name.'.'.$ext;

        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('name')
                  ->is_max(3, __('marquee_image.name_missing'));
        $validator->check('icon')
                  ->is_max(3, __('marquee_image.icon_missing'));

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/marquee-image/add');
        }

        $event_marquee = MarqueeImage::create($input);

        Extend::process('marquee_image', $event_marquee->id);
        Notify::success("Your new marquee image was created");

        return Response::redirect('admin/marquee-image');
    });


    /**
     * Edit Marquee Image
     */
    Route::get('admin/marquee-image/edit/(:num)', function ($id) {
        $vars['token']    = Csrf::token();
        $vars['marquee_image'] = MarqueeImage::find($id);
        $vars['event_marquees'] = EventMarquee::get();
        // extended fields
        $vars['fields'] = Extend::fields('marquee_image', $id);

        return View::create('marquee_image/edit', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/marquee-image/edit/(:num)', function ($id) {
        $input = Input::get(['event_marquee', 'img_name', 'is_banner']);

        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('img_name')
                  ->is_max(3, __('event_marquee.img_name_missing'));

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/marquee-image/edit/' . $id);
        }
        
        MarqueeImage::update($id, $input);
        Extend::process('marquee_image', $id);
        Notify::success("Your marquee image has been updated");

        return Response::redirect('admin/marquee-image/edit/' . $id);
    });

    /**
     * Delete Marquee Image
     */
    Route::get('admin/marquee-image/delete/(:num)', function ($id) {

        // delete selected
        MarqueeImage::find($id)->delete();

        Notify::success("Your marquee image has been deleted");

        return Response::redirect('admin/marquee-image');
    });


});


