<?php

use League\Glide\ServerFactory;
use System\config;
use System\database\query;
use System\input;
use System\route;
use System\uri;
use System\view;
use Verot\Upload\Upload;

Route::collection(['before' => 'auth', 'csrf'], function () {

    /**
     * List all event_marquee
     */
    Route::get([
        'admin/event-marquee',
        'admin/event-marquee/(:num)'
        ], function ($page = 1) {
        $vars['event_marquees'] = EventMarquee::paginate($page, Config::get('admin.posts_per_page'));

        return View::create('event_marquee/index', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    /**
     * Add Event Marquee
     */
    Route::get('admin/event-marquee/add', function () {
        $vars['token'] = Csrf::token();

        // extended fields
        $vars['fields'] = Extend::fields('event_marquee');

        return View::create('event_marquee/add', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/event-marquee/add', function () {
        $input = Input::get(['title', 'description', 'banquet_capacity', 'theatre_capacity', 'status']);

        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('title')
                  ->is_max(3, __('event_marquee.title_missing'));

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/event-marquee/add');
        }

        $event_marquee = EventMarquee::create($input);

        Extend::process('event_marquee', $event_marquee->id);
        Notify::success(__('event_marquee.created'));

        return Response::redirect('admin/event-marquee');
    });

    /**
     * Edit Event Marquee
     */
    Route::get('admin/event-marquee/edit/(:num)', function ($id) {
        //generate Csrf token
        $vars['token']    = Csrf::token();

        //get single EventMarquee by id
        $single_marquee = EventMarquee::find($id);
        $vars['event_marquee'] = $single_marquee;


        $vars['selected_features'] = array_map(function($item) {
            return $item->feature_id;
        }, $single_marquee->features());

        $vars['features'] = Query::table(MarqueeFeature::table())->get();

        // extended fields
        $vars['fields'] = Extend::fields('event_marquee', $id);
        $images = Query::table(MarqueeImage::table())
                    ->where('event_marquee', '=', $id)
                    ->get();
        $mockFiles = array();

        foreach($images as $image)
        {
            $fullPath = PATH . UPLOAD_DIR . DS . $image->img_name;
            if(file_exists($fullPath)) {
                $item = new stdClass();
                $item->name = $image->img_name;
                $item->size = filesize($fullPath);
                $item->path = DS . UPLOAD_DIR . DS . $image->img_name;
                $item->id = $image->id;
                $item->banner = $image->is_banner;
                $mockFiles[] = $item;
            }
        }
        $vars['marquee_images'] = json_encode($mockFiles);

        $marquee_features = Query::table(MarqueeFeature::table())->get();
        $vars['marquee_features'] = $marquee_features;



        return View::create('event_marquee/edit', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/event-marquee/edit/(:num)', function ($id) {
        $input = Input::get(['title', 'description', 'banquet_capacity', 'theatre_capacity', 'status']);

        $features = $_POST['feature'] ?? [];

        $query = Query::table(EventFeature::table())->where('marquee_id', '=', $id);
        if ($query->count()) {
            foreach($query->get() as $feature){
                //Resets all features
                EventFeature::find($feature->id)->delete();
            }
        }

        if (count($features) > 0) {
            //Add features
            foreach ($features as $feature) {
                $feature_input['feature_id'] = $feature;
                $feature_input['marquee_id'] = $id;
                $marquee_feature_xref = EventFeature::create($feature_input);
            }
        }


        foreach ($input as $key => &$value) {
            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->check('title')
                  ->is_max(3, __('event_marquee.title_missing'));

        if ($errors = $validator->errors()) {
            Input::flash();
            Notify::error($errors);

            return Response::redirect('admin/event-marquee/edit/' . $id);
        }


        EventMarquee::update($id, $input);
        Extend::process('event_marquee', $id);
        Notify::success(__('event_marquee.updated'));

        return Response::redirect('admin/event-marquee/edit/' . $id);
    });

    //upload Image
    Route::post('admin/event-marquee/upload/(:num)', function ($id) {
        $input = Input::get(['event_marquee']);
        $input['is_banner'] = Input::get('is_banner', 0);
        $marquee_banner_state = Query::table(MarqueeImage::table())
                    ->where('event_marquee', '=', $id)
                    ->where('is_banner', '=', 1)->get();

        $normal_image = new Upload($_FILES['file']);
        $thumbnail_img = new Upload($_FILES['file']);

        $status = false;

        if ($normal_image->uploaded and $normal_image->file_is_image and $thumbnail_img->uploaded and $thumbnail_img->file_is_image) {

            $img_name = Helpers::generate_filename(21);
            $ext = $normal_image->image_src_type;

            //set normal image properties
            $normal_image->file_new_name_body   = $img_name;
            $normal_image->image_resize         = true;
            $normal_image->image_ratio = true;
            $thumbnail_img->image_ratio_crop = true;
            $normal_image->image_x              = 1000;
            $normal_image->image_y              = 1000;

            //set thumbnail image properties
            $thumbnail_img->file_new_name_body   = 'thumb_' . $img_name;
            $thumbnail_img->image_resize         = true;
            $thumbnail_img->image_ratio_crop = true;
            $thumbnail_img->image_ratio = true;
            $thumbnail_img->image_x              = 400;
            $thumbnail_img->image_y              = 400;

            // uploads both images
            $normal_image->process(PATH . UPLOAD_DIR);
            $thumbnail_img->process(PATH . THUMBNAIL_DIR);

            if($normal_image->processed and $thumbnail_img->processed) {
                $normal_image->clean();
                $thumbnail_img->clean();
                $status = true;
            }

            $input['img_name'] = $img_name.'.'.$ext;
            $input['thumbnail_img'] = 'thumb_'.$img_name.'.'.$ext;
        }

        $event_image = MarqueeImage::create($input);
        if (!$marquee_banner_state) {
            $img_id = $event_image->id;
            MarqueeImage::update($img_id, ['is_banner'=> 1]);
        }

        return Response::json([
            'status' => $status,
            'image' => $event_image
        ]);
    });

    //Mark image as banner
    Route::post('admin/event-marquee/is-banner', function () {
        $name = $_POST['name'];
        // $test = EventMarquee::marqueeWithImage();
        // dd($test);
        $marquee = Query::table(MarqueeImage::table())
                    ->where('img_name', '=', $name)
                    ->take(1)
                    ->get();
        $is_banner = $marquee[0]->is_banner;
        $id = $marquee[0]->id;
        $state = null;
        if (!$is_banner) {
            MarqueeImage::update($id, ['is_banner'=> 1]);
            $state = true;
        }else{
            MarqueeImage::update($id, ['is_banner'=> 0]);
            $state = false;
        }

        return Response::json([
            'status' => true,
            'state' => $state
        ]);
    });

    //delete image
    Route::post('admin/event-marquee/delete-image', function () {
        $name = $_POST['name'];
        $marquee = Query::table(MarqueeImage::table())
                    ->where('img_name', '=', $name)
                    ->take(1)
                    ->get();
        $id = $marquee[0]->id;
        $status = true;

        //delete normal image from upload folder
        if (!unlink(PATH . UPLOAD_DIR. DS .$name)) {
            $status = false;
        }
        //delete thumbnail image from thumbnail upload folder
        if (!unlink(PATH . THUMBNAIL_DIR. DS .'thumb_'.$name)) {
            $status = false;
        }
        MarqueeImage::find($id)->delete();

        return Response::json([
            'status' => $status
        ]);
    });

    /**
     * Delete Event Marquee
     */
    Route::get('admin/event-marquee/delete/(:num)', function ($id) {
        $total = EventMarquee::count();

        if ($total == 1) {
            Notify::error(__('event_marquee.delete_error'));

            return Response::redirect('admin/event-marquee/edit/' . $id);
        }

        // move posts
        $event_marquee = EventMarquee::where('id', '<>', $id)->fetch();

        // delete selected
        EventMarquee::find($id)->delete();

        Notify::success(__('event_marquee.deleted'));

        return Response::redirect('admin/event-marquee');
    });

    Route::post('admin/event-marquee/get-images', function(){
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $status = false;
        $query = Query::table(MarqueeImage::table())
                    ->where('event_marquee', '=', $id);
        $images = $query->get();
        $count = $query->count();
        $count > 0 ? true : false;
        // dd($images);

        return Response::json([
            'status' => $images
        ]);
    });
});


