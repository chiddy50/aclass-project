<?php

use System\config;
use System\database\query;

/**
 * services_list class
 */
class ServicesList extends Base
{
    public static $table = 'services_list';

    /**
     * Retrieves an services_list by ID
     *
     * @param int $id services_list ID
     *
     * @return \services_list
     * @throws \Exception
     */
    public static function id($id)
    {
        return static::get('id', $id);

    }

    /**
     * Retrieves all services_lists
     *
     * @param string     $row services_list row name to compare in
     * @param string|int $val services_list value to compare to
     *
     * @return \stdClass
     * @throws \Exception
     */
    private static function get()
    {
        return Base::table('services_list');

        // return Base::table('event_marquee')->fetch([Base::table('posts.*')]);

    }

    /**
     * Paginates services_list results
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
        $results = $query->take($perpage)->skip(($page - 1) * $perpage)->sort('service')->get();

        return new Paginator($results, $count, $page, $perpage, Uri::to('admin/services-list'));
    }


}
