<?php

use System\config;
use System\database\query;

/**
 * event_marquee class
 */
class EventMarquee extends Base
{
    public static $table = 'event_marquee';

    /**
     * Retrieves an event_marquee by ID
     *
     * @param int $id event_marquee ID
     *
     * @return \event_marquee
     * @throws \Exception
     */
    public static function id($id)
    {
        return static::get('id', $id);

    }

    /**
     * Retrieves all event_marquees
     *
     * @param string     $row event_marquee row name to compare in
     * @param string|int $val event_marquee value to compare to
     *
     * @return \stdClass
     * @throws \Exception
     */
    private static function get()
    {
        return Base::table('event_marquee');

        // return Base::table('event_marquee')->fetch([Base::table('posts.*')]);

    }

    /**
     * Paginates event_marquee results
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

        return new Paginator($results, $count, $page, $perpage, Uri::to('admin/event-marquee'));
    }

    public static function marqueeWithImage(){
        $query = EventMarquee::left_join(
            Base::table(MarqueeImage::$table),
            Base::table(MarqueeImage::$table . '.event_marquee'),
            '=',
            Base::table(EventMarquee::$table . '.id')
        )->where(Base::table(MarqueeImage::$table . '.is_banner'), '=', 1);

        return $query->get();
    }


    /**
     * return all features related to the event_marquee
     *
     * @return \stdClass
     * @throws \Exception
     */
    public function features()
    {
        $query = MarqueeFeature::left_join(
            Base::table(EventFeature::$table),
            Base::table(MarqueeFeature::$table . '.id'),
            '=',
            Base::table(EventFeature::$table . '.feature_id')
        )->where(Base::table(EventFeature::$table . '.marquee_id'), '=', $this->id);

        return $query->get();
    }

    /**
     * return all features related to the event_marquee
     *
     * @param int $id    marquee_id
     *
     * @return \stdClass
     * @throws \Exception
     */
    public static function choosenFeatures($id)
    {
        $query = static::left_join(
            Base::table(EventFeature::$table),
            Base::table(EventFeature::$table . '.marquee_id'),
            '=',
            Base::table(static::$table . '.id')
        )->where(Base::table(EventFeature::$table . '.marquee_id'), '=', $id);

        return $query->get();
    }

    private $bannerImage = null;

    public function bannerImage()
    {
        if(is_null($this->bannerImage))
        {
            $this->bannerImage = MarqueeImage::where('event_marquee', '=', $this->id)
            ->where('is_banner', '=', 1)
            ->fetch();
        }
        
        return $this->bannerImage;
    }

    public function images()
    {
        return MarqueeImage::where('event_marquee', '=', $this->id)->get();
    }
}
