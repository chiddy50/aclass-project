<?php

use System\config;
use System\database\query;

/**
 * service class
 */
class Service extends Base
{
    public static $table = 'service';

    /**
     * Retrieves an service by ID
     *
     * @param int $id service ID
     *
     * @return \service
     * @throws \Exception
     */
    public static function id($id)
    {
        return static::get('id', $id);

    }

    /**
     * Retrieves all services
     *
     * @param string     $row service row name to compare in
     * @param string|int $val service value to compare to
     *
     * @return \stdClass
     * @throws \Exception
     */
    private static function get()
    {
        return Base::table('service');

        // return Base::table('event_marquee')->fetch([Base::table('posts.*')]);

    }

    /**
     * Paginates service results
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
        $results = $query->take($perpage)->skip(($page - 1) * $perpage)->sort('title')->get();

        return new Paginator($results, $count, $page, $perpage, Uri::to('admin/services'));
    }


}
