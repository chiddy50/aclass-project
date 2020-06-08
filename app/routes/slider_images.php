<?php
use System\config;
use System\input;
use System\route;
use System\view;
use Verot\Upload\Upload;
use System\database\query;


Route::collection(['before' => 'auth', 'csrf'], function () {



    /**
     * Add Slider Image
     */
    Route::get('admin/slider-images/add', function () {
        $vars['token'] = Csrf::token();
        $images = Query::table(SliderImages::table())->get();
        $mockFiles = array();

        foreach($images as $image)
        {
            $fullPath = PATH . SLIDER_DIR . DS . $image->image_name;
            if(file_exists($fullPath)) {
                $item = new stdClass();
                $item->name = $image->image_name;
                $item->size = filesize($fullPath);
                $item->path = DS . SLIDER_DIR . DS . 'thumb_' . $image->image_name;
                $item->id = $image->id;
                $mockFiles[] = $item;
            }
        }
        $vars['images'] = json_encode($mockFiles);

        // extended fields
        $vars['fields'] = Extend::fields('slider_images');


        return View::create('slider_images/add', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/slider-images/add', function () {
        $status = false;

        $uploaded_image = new Upload($_FILES['file']);
        $thumbnail = new Upload($_FILES['file']);

        //Upload Image
        if ($uploaded_image->uploaded and $uploaded_image->file_is_image) {
            $img_name = Helpers::generate_filename(21);
            $ext = $uploaded_image->image_src_type;

            //set image properties
            $uploaded_image->file_new_name_body   = $img_name;
            $uploaded_image->image_resize         = true;
            $uploaded_image->image_ratio = true;
            $uploaded_image->image_x              = 1366;
            $uploaded_image->image_y              = 768;

            $uploaded_image->process(PATH . SLIDER_DIR);

            $thumbnail->file_new_name_body = 'thumb_' . $img_name;
            $thumbnail->image_resize = true;
            $thumbnail->image_ratio = true;
            $thumbnail->image_x = 100;
            $thumbnail->image_y = 100;
            $thumbnail->process(PATH . SLIDER_DIR);
            
            if($uploaded_image->processed) {
                $uploaded_image->clean();
                $thumbnail->clean();
                $status = true;
            }
            
            $input['image_name'] = $img_name.'.'.$ext;
        }

        $slider_images = SliderImages::create($input);

        return Response::json([
            "status" => $status
        ]);
    });

    Route::post('admin/slider-images/delete', function () {
        $name = $_POST['name'];
        $marquee = Query::table(SliderImages::table())
                    ->where('image_name', '=', $name)
                    ->fetch();
                    // ->get();

        $id = $marquee->id;
        $status = true;

        //delete image from sliders folder
        if (!unlink(PATH . SLIDER_DIR. DS .$name)) {
            $status = false;
        }
        unlink(PATH . SLIDER_DIR. DS . 'thumb_' . $name);

        SliderImages::find($id)->delete();

        return Response::json([
            'status' => $status
        ]);
    });
});


