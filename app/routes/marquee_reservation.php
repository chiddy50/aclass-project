
<?php

use System\config;
use System\input;
use System\route;
use System\view;
use System\database\query;

Route::collection(['before' => 'auth,csrf'], function () {

    /**
     * List all marquee_reservation
     */
    Route::get([
        'admin/marquee-reservation',
        'admin/marquee-reservation/(:num)'
    ], function ($page = 1) {
        $vars['marquee_reservations'] = MarqueeReservation::paginate($page, Config::get('admin.posts_per_page'));

        // Test
        $reservations = MarqueeReservation::get();
        $vars['event_marquees'] = $reservations;
        $events_id = [];
        foreach ($reservations as $key => $value) {
            $events_id[] = $value->event_marquee;
        }
        $vars['events_id'] = $events_id;
        // $x = EventMarquee::test($events_id);
        //

        return View::create('marquee_reservation/index', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    /**
     * Add Marquee Feature
     */
    Route::get('admin/marquee-reservation/add', function () {
        $vars['token'] = Csrf::token();
        $vars['event_marquees'] = EventMarquee::get();
        // extended fields
        $vars['fields'] = Extend::fields('marquee_reservation');

        return View::create('marquee_reservation/add', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/marquee-reservation/add', function () {

        $input = [];
        $numberExists = true;
        $unavailable = true;
        $input['name'] = $_POST['name'];
        $input['email'] = $_POST['email'];
        $input['telephone'] = $_POST['telephone'];
        $input['reservation_date'] = $_POST['reservation_date'];
        $input['event_marquee'] = $_POST['event_marquee'];

        $query2 = Query::table(MarqueeReservation::table())
        ->where('reservation_date', '=', $input['reservation_date'])
        ->where('event_marquee', '=', $input['event_marquee']);

        $reference_no = random_int(1000000, 9999999);

        $query = Query::table(MarqueeReservation::table())->where('reference_no', '=', $reference_no);

        if (!$query->count() && !$query2->count()) {
            $numberExists = false;
            $unavailable = false;
            $input['reference_no'] = $reference_no;
            $event_marquee = MarqueeReservation::create($input);
        }

        return Response::json([
            'reference_no' => $reference_no,
            'exists' => $numberExists,
            'unavailable' => $unavailable
        ]);
    });

    /**
     * Edit Marquee Reservation
     */
    Route::get('admin/marquee-reservation/edit/(:num)', function ($id) {
        $vars['token']    = Csrf::token();
        $vars['marquee_reservation'] = MarqueeReservation::find($id);
        $vars['event_marquees'] = EventMarquee::get();
        // extended fields
        $vars['fields'] = Extend::fields('marquee_reservation', $id);

        return View::create('marquee_reservation/edit', $vars)
                   ->partial('header', 'partials/header')
                   ->partial('footer', 'partials/footer');
    });

    Route::post('admin/marquee-reservation/edit/(:num)', function ($id) {
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

            return Response::redirect('admin/marquee-reservation/edit/' . $id);
        }



        MarqueeReservation::update($id, $input);
        Extend::process('marquee_reservation', $id);
        Notify::success("Your marquee feature has been updated");

        return Response::redirect('admin/marquee-reservation/edit/' . $id);
    });

    /**
     * Delete Marquee Feature
     */
    Route::get('admin/marquee-reservation/delete/(:num)', function ($id) {

        // delete selected
        MarqueeReservation::find($id)->delete();

        Notify::success("Your marquee feature has been deleted");

        return Response::redirect('admin/marquee-reservation');
    });
});


