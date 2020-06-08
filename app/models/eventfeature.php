<?php

use System\config;
use System\database\query;

/**
 * event_feature class
 */
class EventFeature extends Base
{
    public static $table = 'marquee_feature_xref';

    /**
     * Retrieves an event_feature by ID
     *
     * @param int $id event_feature ID
     *
     * @return \event_feature
     * @throws \Exception
     */
    public static function id($id)
    {
        return static::get('id', $id);

    }

    /**
     * Retrieves all event_features
     *
     * @param string     $row event_feature row name to compare in
     * @param string|int $val event_feature value to compare to
     *
     * @return \stdClass
     * @throws \Exception
     */
    private static function get()
    {
        return Base::table('marquee_feature_xref');

        // return Base::table('marquee_feature')->fetch([Base::table('posts.*')]);

    }


}
