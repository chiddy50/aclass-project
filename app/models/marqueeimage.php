<?php

use System\config;
use System\database\query;

/**
 * marquee_image class
 */
class MarqueeImage extends Base
{
    public static $table = 'marquee_image';

    /**
     * Retrieves an marquee_image by ID
     *
     * @param int $id marquee_image ID
     *
     * @return \marquee_image
     * @throws \Exception
     */
    public static function id($id)
    {
        return static::get('id', $id);

    }

    /**
     * Retrieves all marquee_images
     *
     * @param string     $row marquee_image row name to compare in
     * @param string|int $val marquee_image value to compare to
     *
     * @return \stdClass
     * @throws \Exception
     */
    private static function get()
    {
        return Base::table('marquee_image');

        // return Base::table('marquee_image')->fetch([Base::table('posts.*')]);

    }


    /**
     * Paginates marquee_image results
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
        $results = $query->take($perpage)->skip(($page - 1) * $perpage)->get();

        return new Paginator($results, $count, $page, $perpage, Uri::to('admin/marquee-image'));
    }

    /**
     * Paginates marquee_image results
     *
     * @param int $page    page offset
     * @param int $perpage page limit
     * @param int $id event_marquee
     *
     * @return \Paginator
     * @throws \ErrorException
     * @throws \Exception
     */
    public static function fetchImages($page = 1, $perpage = 10, $id){
        $query   = Query::table(static::table());
        $count   = $query->where('event_marquee', '=', $id)->count();
        $results = $query->take($perpage)->skip(($page - 1) * $perpage)->get();

        return new Paginator($results, $count, $page, $perpage, Uri::to('admin/event-marquee/images'));
    }

    public static function test($name)
    {
        return static::where('event_marquee', '=', $name)->fetch();
    }
}
