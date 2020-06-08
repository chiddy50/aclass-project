<?php

use System\config;
use System\database\query;


/**
 * Loops through all event_marquees
 *
 * @return array
 */
function event_marquees()
{
    return EventMarquee::get();
}
