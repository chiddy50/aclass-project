<?php

/****************************
 * Theme functions for services
 ****************************/

use System\config;

/**
 * Loops through all services
 *
 * @return array
 */
function services(){

    return Service::get();

}

function services_list(){

    return ServicesList::sort('id')->get();
}

// function event_marquees()
// {
//     return EventMarquee::get();
// }
