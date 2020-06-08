<?php

use System\config;
use System\database\query;

/**
 * marquee_feature class
 */
class MarqueeFeature extends Base
{
    public static $table = 'marquee_feature';

    /**
     * Retrieves an marquee_feature by ID
     *
     * @param int $id marquee_feature ID
     *
     * @return \marquee_feature
     * @throws \Exception
     */
    public static function id($id)
    {
        return static::get('id', $id);

    }

    /**
     * Retrieves all marquee_features
     *
     * @param string     $row marquee_feature row name to compare in
     * @param string|int $val marquee_feature value to compare to
     *
     * @return \stdClass
     * @throws \Exception
     */
    private static function get()
    {
        return Base::table('marquee_feature');

        // return Base::table('marquee_feature')->fetch([Base::table('posts.*')]);

    }

    /**
     * Paginates marquee_feature results
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

        return new Paginator($results, $count, $page, $perpage, Uri::to('admin/marquee-feature'));
    }


}
