<?php

use System\config;
use System\database\query;
use System\input;
use System\route;
use System\uri;
use System\view;
use Verot\Upload\Upload;

Route::collection(['before' => 'auth,csrf,install_exists'], function () {

    /**
     * List Pages
     */
    Route::get([
        'admin/pages',
        'admin/pages/(:num)'
    ], function ($page = 1) {
        $perpage = Config::get('admin.posts_per_page');
        $total   = Page::where(Base::table('pages.parent'), '=', '0')->count();
        $url     = Uri::to('admin/pages');
        $pages   = Page::sort('title')
                       ->where(Base::table('pages.parent'), '=', '0')
                       ->take($perpage)
                       ->skip(($page - 1) * $perpage)
                       ->get();

        $pagination = new Paginator($pages, $total, $page, $perpage, $url);

        $vars['pages']  = $pagination;
        $vars['status'] = 'all';

        return View::create('pages/index', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    /**
     * List pages by status and paginate through them
     */
    Route::get([
        'admin/pages/status/(:any)',
        'admin/pages/status/(:any)/(:num)'
        ], function ($status, $page = 1) {
        $query   = Page::where('status', '=', $status);
        $perpage = Config::get('admin.posts_per_page');
        $total   = $query->count();
        $url     = Uri::to('admin/pages/status');
        $pages   = $query->sort('title')
                         ->take($perpage)
                         ->skip(($page - 1) * $perpage)
                         ->get();

        $pagination = new Paginator($pages, $total, $page, $perpage, $url);

        $vars['pages']  = $pagination;
        $vars['status'] = $status;

        return View::create('pages/index', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    /**
     * Edit Page
     */
    Route::get('admin/pages/edit/(:num)', function ($id) {
        $vars['token'] = Csrf::token();
        $vars['page'] = Page::find($id);
        $vars['fontawesome'] = fontawesome_options();

        $vars['statuses'] = [
            'published' => __('global.published'),
            'draft'     => __('global.draft'),
        ];

        return View::create('pages/edit', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/pages/edit/(:num)', function ($id) {
        $input = Input::get([
            'parent',
            'name',
            'title',
            'slug',
            'markdown',
            'status',
            'redirect',
            'icon',
        ]);

        $input['show_in_menu'] = 1;
        $input['parent'] = 0;

        // Upload image
        $handle = new Upload($_FILES['image']);
        $page = Page::find($id);
        $filename = '';
        
        if (strlen($_FILES['image']['name']) > 0 
            && $handle->uploaded 
            && $handle->file_is_image
            && is_null($page) == false) {

            $path = UPLOAD_DIR . DS . $page->image;
            if($page->image && file_exists($path))
                unlink($path);
                    
            $img_name = Helpers::generate_filename();
            $ext = $handle->image_src_type;

            //Rename image
            $handle->file_new_name_body = $img_name;
            $handle->image_resize  = true;
            $handle->image_x = 960;
            $handle->image_y = 1080;
            $handle->image_ratio_crop = true;
            // $handle->image_ratio = true;

            // uploads the file
            $handle->process(UPLOAD_DIR);
            if($handle->processed) {
                $handle->clean();
                $filename = $img_name.'.'.$ext;
            }
            else {
                Notify::error($handle->error);
                $filename = '';
            }
        }

        $input['image'] = $filename;
        
        // if there is no slug try and create one from the title
        if (empty($input['slug'])) {
            $input['slug'] = $input['title'];
        }

        // convert to ascii
        $input['slug'] = slug($input['slug']);

        // an array of items that we shouldn't encode - they're no XSS threat
        $dont_encode = ['markdown'];

        foreach ($input as $key => &$value) {
            if (in_array($key, $dont_encode)) {
                continue;
            }

            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->add('duplicate', function ($str) use ($id) {
            return Page::where('slug', '=', $str)
                       ->where('id', '<>', $id)
                       ->count() == 0;
        });

        $validator->check('title')
                  ->is_max(3, __('pages.title_missing'));

        $validator->check('slug')
                  ->is_max(3, __('pages.slug_missing'))
                  ->is_duplicate(__('pages.slug_duplicate'))
                  ->not_regex('#^[0-9_-]+$#', __('pages.slug_invalid'));

        if ($input['redirect']) {
            $validator->check('redirect')
                      ->is_url(__('pages.redirect_missing'));
        }

        if ($errors = $validator->errors()) {
            Input::flash();

            Notify::error($errors);
        }

        if (empty($input['name'])) {
            $input['name'] = $input['title'];
        }

        // encode title
        $input['title']        = e($input['title'], ENT_COMPAT);
        $input['show_in_menu'] = is_null($input['show_in_menu']) || empty($input['show_in_menu']) ? 0 : 1;
        $input['html']         = parse($input['markdown']);

        Page::update($id, $input);

        Notify::success(__('pages.updated'));

        return Response::redirect('admin/pages/edit/' . $page->id);
    });

    /*
        Add Page
    */
    Route::get('admin/pages/add', function () {
        $vars['token']     = Csrf::token();
        $vars['fontawesome'] = fontawesome_options();

        $vars['statuses'] = [
            'published' => __('global.published'),
            'draft'     => __('global.draft'),
        ];

        return View::create('pages/add', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/pages/add', function () {
        $input = Input::get([
            'name',
            'title',
            'slug',
            'markdown',
            'status',
            'redirect',
            'pagetype',
            'icon',
        ]);

        $input['show_in_menu'] = 1;
        $input['parent'] = 0;


        // Upload image
        $handle = new Upload($_FILES['image']);
        $filename = '';
        if ($handle->uploaded and $handle->file_is_image) {
            
            $img_name = Helpers::generate_filename();
            $ext = $handle->image_src_type;

            //Rename image
            $handle->file_new_name_body   = $img_name;
            $handle->image_resize         = true;
            $handle->image_x              = 960;
            $handle->image_y              = 1080;

            // uploads the file
            $handle->process(UPLOAD_DIR);
            if($handle->processed) {
                //Deletes the uploaded file from its temporary location
                $handle->clean();
                $filename = $img_name.'.'.$ext;
            } else {
                Notify::error($handle->error);
                $filename = '';
            }
        }

        $input['image'] = $filename;

        //Upload End

        // if there is no slug try and create one from the title
        if (empty($input['slug'])) {
            $input['slug'] = $input['title'];
        }

        // convert to ascii
        $input['slug'] = slug($input['slug']);

        // an array of items that we shouldn't encode - they're no XSS threat
        $dont_encode = ['markdown'];

        foreach ($input as $key => &$value) {
            if (in_array($key, $dont_encode)) {
                continue;
            }

            $value = eq($value);
        }

        $validator = new Validator($input);

        $validator->add('duplicate', function ($str) {
            return Page::where('slug', '=', $str)->count() == 0;
        });

        $validator->check('title')
                  ->is_max(3, __('pages.title_missing'));

        $validator->check('slug')
                  ->is_max(3, __('pages.slug_missing'))
                  ->is_duplicate(__('pages.slug_duplicate'))
                  ->not_regex('#^[0-9_-]+$#', __('pages.slug_invalid'));

        if ($input['redirect']) {
            $validator->check('redirect')
                      ->is_url(__('pages.redirect_missing'));
        }

        if ($errors = $validator->errors()) {
            Input::flash();

            Notify::error($errors);
        }


        if (empty($input['name'])) {
            $input['name'] = $input['title'];
        }

        $input['show_in_menu'] = is_null($input['show_in_menu']) || empty($input['show_in_menu']) ? 0 : 1;
        $input['html']         = parse($input['markdown']);

        $page = Page::create($input);
        $id   = $page->id;

        Extend::process('page', $id);

        Notify::success(__('pages.created'));
    });

    /**
     * Delete Page
     */
    Route::get('admin/pages/delete/(:num)', function ($id) {
        if (
            (Page::count() > 1) &&
            (Page::home()->id != $id) &&
            (Page::posts()->id != $id) &&
            (count(Page::find($id)
                       ->children()) == 0)
        ) {
            Page::find($id)->delete();

            Query::table(Base::table('page_meta'))
                 ->where('page', '=', $id)
                 ->delete();

            Notify::success(__('pages.deleted'));
        } else {
            Notify::error('Unable to delete page. The target must not be a parent, home or posts page, or you must have at least 1 page.');
        }

        return Response::redirect('admin/pages');
    });
});
