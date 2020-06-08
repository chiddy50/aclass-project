<?php

use System\config;
use System\database\query;

/**
 * marquee_reservation class
 */
class MarqueeReservation extends Base
{
    public static $table = 'marquee_reservation';

    /**
     * Retrieves an marquee_reservation by ID
     *
     * @param int $id marquee_reservation ID
     *
     * @return \marquee_reservation
     * @throws \Exception
     */
    public static function id($id)
    {
        return static::get('id', $id);

    }

    /**
     * Retrieves all marquee_reservations
     *
     * @param string     $row marquee_reservation row name to compare in
     * @param string|int $val marquee_reservation value to compare to
     *
     * @return \stdClass
     * @throws \Exception
     */
    private static function get()
    {
        return Base::table('marquee_reservation');

        // return Base::table('marquee_reservation')->fetch([Base::table('posts.*')]);

    }

    /**
     * Paginates marquee_reservation results
     *
     * @param int $page    page offset
     * @param int $perpage page limit
     *
     * @return \Paginator
     * @throws \ErrorException
     * @throws \Exception
     */
    public static function paginate($page = 1, $perpage = 10)
    {
        $query   = Query::table(static::table());
        $count   = $query->count();
        $results = $query->take($perpage)->skip(($page - 1) * $perpage)->sort('name')->get();

        return new Paginator($results, $count, $page, $perpage, Uri::to('admin/marquee-reservation'));
    }




}
