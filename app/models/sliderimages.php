<?php

use System\config;
use System\database\query;

/**
 * slider_images class
 */
class SliderImages extends Base
{
    public static $table = 'slider_images';

    /**
     * Retrieves an slider_images by ID
     *
     * @param int $id slider_images ID
     *
     * @return \slider_images
     * @throws \Exception
     */
    public static function id($id)
    {
        return static::get('id', $id);

    }

    /**
     * Retrieves all slider_images
     *
     * @param string     $row slider_images row name to compare in
     * @param string|int $val slider_images value to compare to
     *
     * @return \stdClass
     * @throws \Exception
     */
    private static function get()
    {
        return Base::table('slider_images');

        // return Base::table('event_marquee')->fetch([Base::table('posts.*')]);

    }

    /**
     * Paginates slider_images results
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
        $results = $query->take($perpage)->skip(($page - 1) * $perpage)->sort('image_name')->get();

        return new Paginator($results, $count, $page, $perpage, Uri::to('admin/slider_images'));
    }


}
