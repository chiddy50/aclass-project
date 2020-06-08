<?php

use System\config;
use System\uri;

/**
 * translates a line of text
 *
 * @param string $line line to translate
 * @param string[] ...,  variables to replace
 *
 * @return mixed|string
 */
function __($line)
{
    $args = array_slice(func_get_args(), 1);

    return Language::line($line, null, $args);
}

/**
 * Checks whether the current request is on the admin panel
 *
 * @return bool
 * @throws \ErrorException
 * @throws \OverflowException
 */
function is_admin()
{
    // Exact URI or trailing slash after 'admin'.
    return Uri::current() === 'admin' || strpos(Uri::current(), 'admin/') === 0;
}

/**
 * Checks whether Anchor is installed
 *
 * @return bool
 */
function is_installed()
{
    return Config::get('db') !== null or Config::get('database') !== null;
}

/**
 * Creates a slug from a string
 *
 * @param string $string    string to slugify
 * @param string $separator separator character
 *
 * @return null|string|string[]
 */
function slug($string, $separator = '-')
{
    $accents_regex = '~&([a-zA-Z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
    $special_cases = [
        '&' => 'and'
    ];
    $string        = mb_strtolower(trim($string), 'UTF-8');
    $string        = str_replace(array_keys($special_cases), array_values($special_cases), $string);
    $string        = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
    $string        = preg_replace("/[^a-zA-Z0-9]/u", "$separator", $string);
    $string        = preg_replace("/[$separator]+/u", "$separator", $string);
    $string        = trim($string, '-');

    return $string;
}

/**
 * parses a string, optionally using markdown
 *
 * @param string $str      string to parse
 * @param bool   $markdown whether to use markdown
 *
 * @return mixed|string parsed string
 */
function parse($str, $markdown = true)
{
    // process tags
    $pattern = '/[\{\{]{1}([a-z]+)[\}\}]{1}/i';

    if (preg_match_all($pattern, $str, $matches)) {
        list($search, $replace) = $matches;

        foreach ($replace as $index => $key) {
            $replace[$index] = Config::meta($key);
        }

        $str = str_replace($search, $replace, $str);
    }

    //  Parse Markdown as well?
    if ($markdown === true) {
        $md  = new Parsedown();
        $str = $md->text($str);
    }

    return $str;
}

/**
 * Calculate a user-readable file size
 *
 * @param int $size original size in byte
 *
 * @return string user-readable file size
 */
function readable_size($size)
{
    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

    return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

/**
 * copies a filesystem tree recursively (aka. "cp -R")
 *
 * @param string $src source path
 * @param string $dst destination path
 *
 * @return void
 */
function recurse_copy($src, $dst)
{
    $dir = opendir($src);

    @mkdir($dst);

    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . DS . $file)) {
                recurse_copy($src . DS . $file, $dst . DS . $file);
            } else {
                copy($src . DS . $file, $dst . DS . $file);
            }
        }
    }

    closedir($dir);
}

/**
 * deletes a filesystem tree recursively (aka. "rm -rf") by deleting all
 * individual files and folders within it
 *
 * @param string $dir directory to remove
 *
 * @return bool whether the
 */
function delTree($dir)
{
    $files = array_diff(scandir($dir), ['.', '..']);

    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }

    return rmdir($dir);
}


function fontawesome_options()
{
    // commented items not seen as useful
    return [
        // 'fa-align-left' => '&#xf036;',
        // 'fa-align-right' => '&#xf038;',
        // 'fa-amazon' => '&#xf270;',
        'fa-ambulance' => '&#xf0f9;',
        // 'fa-anchor' => '&#xf13d;',
        // 'fa-android' => '&#xf17b;',
        'fa-angellist' => '&#xf209;',
        // 'fa-angle-double-down' => '&#xf103;',
        // 'fa-angle-double-left' => '&#xf100;',
        // 'fa-angle-double-right' => '&#xf101;',
        // 'fa-angle-double-up' => '&#xf102;',
        // 'fa-angle-left' => '&#xf104;',
        // 'fa-angle-right' => '&#xf105;',
        // 'fa-angle-up' => '&#xf106;',
        'fa-apple' => '&#xf179;',
        'fa-archive' => '&#xf187;',
        'fa-area-chart' => '&#xf1fe;',
        // 'fa-arrow-circle-down' => '&#xf0ab;',
        // 'fa-arrow-circle-left' => '&#xf0a8;',
        // 'fa-arrow-circle-o-down' => '&#xf01a;',
        // 'fa-arrow-circle-o-left' => '&#xf190;',
        // 'fa-arrow-circle-o-right' => '&#xf18e;',
        // 'fa-arrow-circle-o-up' => '&#xf01b;',
        // 'fa-arrow-circle-right' => '&#xf0a9;',
        // 'fa-arrow-circle-up' => '&#xf0aa;',
        // 'fa-arrow-down' => '&#xf063;',
        // 'fa-arrow-left' => '&#xf060;',
        // 'fa-arrow-right' => '&#xf061;',
        // 'fa-arrow-up' => '&#xf062;',
        // 'fa-arrows' => '&#xf047;',
        // 'fa-arrows-alt' => '&#xf0b2;',
        // 'fa-arrows-h' => '&#xf07e;',
        // 'fa-arrows-v' => '&#xf07d;',
        'fa-asterisk' => '&#xf069;',
        'fa-at' => '&#xf1fa;',
        'fa-automobile' => '&#xf1b9;',
        // 'fa-backward' => '&#xf04a;',
        'fa-balance-scale' => '&#xf24e;',
        // 'fa-ban' => '&#xf05e;',
        'fa-bank' => '&#xf19c;',
        // 'fa-bar-chart' => '&#xf080;',
        // 'fa-bar-chart-o' => '&#xf080;',
        'fa-battery-full' => '&#xf240;',
        'fa-beer' => '&#xf0fc;',
        // 'fa-behance' => '&#xf1b4;',
        // 'fa-behance-square' => '&#xf1b5;',
        'fa-bell' => '&#xf0f3;',
        'fa-bell-o' => '&#xf0a2;',
        'fa-bell-slash' => '&#xf1f6;',
        'fa-bell-slash-o' => '&#xf1f7;',
        'fa-bicycle' => '&#xf206;',
        'fa-binoculars' => '&#xf1e5;',
        'fa-birthday-cake' => '&#xf1fd;',
        // 'fa-bitbucket' => '&#xf171;',
        // 'fa-bitbucket-square' => '&#xf172;',
        // 'fa-bitcoin' => '&#xf15a;',
        'fa-black-tie' => '&#xf27e;',
        // 'fa-bold' => '&#xf032;',
        'fa-bolt' => '&#xf0e7;',
        'fa-bomb' => '&#xf1e2;',
        'fa-book' => '&#xf02d;',
        'fa-bookmark' => '&#xf02e;',
        'fa-bookmark-o' => '&#xf097;',
        'fa-briefcase' => '&#xf0b1;',
        'fa-btc' => '&#xf15a;',
        // 'fa-bug' => '&#xf188;',
        'fa-building' => '&#xf1ad;',
        'fa-building-o' => '&#xf0f7;',
        'fa-bullhorn' => '&#xf0a1;',
        'fa-bullseye' => '&#xf140;',
        'fa-bus' => '&#xf207;',
        'fa-cab' => '&#xf1ba;',
        'fa-calendar' => '&#xf073;',
        'fa-camera' => '&#xf030;',
        'fa-car' => '&#xf1b9;',
        // 'fa-caret-up' => '&#xf0d8;',
        // 'fa-cart-plus' => '&#xf217;',
        'fa-cc' => '&#xf20a;',
        'fa-cc-amex' => '&#xf1f3;',
        // 'fa-cc-jcb' => '&#xf24b;',
        // 'fa-cc-paypal' => '&#xf1f4;',
        // 'fa-cc-stripe' => '&#xf1f5;',
        // 'fa-cc-visa' => '&#xf1f0;',
        'fa-chain' => '&#xf0c1;',
        'fa-check' => '&#xf00c;',
        // 'fa-chevron-left' => '&#xf053;',
        // 'fa-chevron-right' => '&#xf054;',
        // 'fa-chevron-up' => '&#xf077;',
        'fa-child' => '&#xf1ae;',
        // 'fa-chrome' => '&#xf268;',
        'fa-circle' => '&#xf111;',
        'fa-circle-o' => '&#xf10c;',
        'fa-circle-o-notch' => '&#xf1ce;',
        'fa-circle-thin' => '&#xf1db;',
        // 'fa-clipboard' => '&#xf0ea;',
        'fa-clock-o' => '&#xf017;',
        // 'fa-clone' => '&#xf24d;',
        // 'fa-close' => '&#xf00d;',
        // 'fa-cloud' => '&#xf0c2;',
        // 'fa-cloud-download' => '&#xf0ed;',
        // 'fa-cloud-upload' => '&#xf0ee;',
        'fa-cny' => '&#xf157;',
        // 'fa-code' => '&#xf121;',
        // 'fa-code-fork' => '&#xf126;',
        // 'fa-codepen' => '&#xf1cb;',
        'fa-coffee' => '&#xf0f4;',
        'fa-cog' => '&#xf013;',
        'fa-cogs' => '&#xf085;',
        'fa-columns' => '&#xf0db;',
        'fa-comment' => '&#xf075;',
        'fa-comment-o' => '&#xf0e5;',
        // 'fa-commenting' => '&#xf27a;',
        // 'fa-commenting-o' => '&#xf27b;',
        // 'fa-comments' => '&#xf086;',
        // 'fa-comments-o' => '&#xf0e6;',
        'fa-compass' => '&#xf14e;',
        // 'fa-compress' => '&#xf066;',
        // 'fa-connectdevelop' => '&#xf20e;',
        'fa-contao' => '&#xf26d;',
        'fa-copy' => '&#xf0c5;',
        'fa-copyright' => '&#xf1f9;',
        // 'fa-creative-commons' => '&#xf25e;',
        'fa-credit-card' => '&#xf09d;',
        // 'fa-crop' => '&#xf125;',
        // 'fa-crosshairs' => '&#xf05b;',
        // 'fa-css3' => '&#xf13c;',
        'fa-cube' => '&#xf1b2;',
        'fa-cubes' => '&#xf1b3;',
        // 'fa-cut' => '&#xf0c4;',
        'fa-cutlery' => '&#xf0f5;',
        // 'fa-dashboard' => '&#xf0e4;',
        'fa-dashcube' => '&#xf210;',
        'fa-database' => '&#xf1c0;',
        'fa-dedent' => '&#xf03b;',
        'fa-delicious' => '&#xf1a5;',
        'fa-desktop' => '&#xf108;',
        // 'fa-deviantart' => '&#xf1bd;',
        'fa-diamond' => '&#xf219;',
        // 'fa-digg' => '&#xf1a6;',
        'fa-dollar' => '&#xf155;',
        // 'fa-download' => '&#xf019;',
        // 'fa-dribbble' => '&#xf17d;',
        // 'fa-dropbox' => '&#xf16b;',
        // 'fa-drupal' => '&#xf1a9;',
        // 'fa-edit' => '&#xf044;',
        // 'fa-eject' => '&#xf052;',
        'fa-ellipsis-h' => '&#xf141;',
        'fa-ellipsis-v' => '&#xf142;',
        // 'fa-empire' => '&#xf1d1;',
        'fa-envelope' => '&#xf0e0;',
        'fa-envelope-o' => '&#xf003;',
        'fa-eur' => '&#xf153;',
        'fa-euro' => '&#xf153;',
        'fa-exchange' => '&#xf0ec;',
        // 'fa-exclamation' => '&#xf12a;',
        // 'fa-exclamation-circle' => '&#xf06a;',
        // 'fa-exclamation-triangle' => '&#xf071;',
        'fa-expand' => '&#xf065;',
        'fa-expeditedssl' => '&#xf23e;',
        'fa-external-link' => '&#xf08e;',
        'fa-external-link-square' => '&#xf14c;',
        'fa-eye' => '&#xf06e;',
        // 'fa-eye-slash' => '&#xf070;',
        // 'fa-eyedropper' => '&#xf1fb;',
        // 'fa-facebook' => '&#xf09a;',
        // 'fa-facebook-f' => '&#xf09a;',
        // 'fa-facebook-official' => '&#xf230;',
        // 'fa-facebook-square' => '&#xf082;',
        'fa-fast-backward' => '&#xf049;',
        'fa-fast-forward' => '&#xf050;',
        'fa-fax' => '&#xf1ac;',
        'fa-feed' => '&#xf09e;',
        'fa-female' => '&#xf182;',
        'fa-fighter-jet' => '&#xf0fb;',
        // 'fa-file' => '&#xf15b;',
        // 'fa-file-archive-o' => '&#xf1c6;',
        // 'fa-file-audio-o' => '&#xf1c7;',
        // 'fa-file-code-o' => '&#xf1c9;',
        // 'fa-file-excel-o' => '&#xf1c3;',
        // 'fa-file-image-o' => '&#xf1c5;',
        // 'fa-file-movie-o' => '&#xf1c8;',
        // 'fa-file-o' => '&#xf016;',
        // 'fa-file-pdf-o' => '&#xf1c1;',
        // 'fa-file-photo-o' => '&#xf1c5;',
        // 'fa-file-picture-o' => '&#xf1c5;',
        // 'fa-file-powerpoint-o' => '&#xf1c4;',
        // 'fa-file-sound-o' => '&#xf1c7;',
        // 'fa-file-text' => '&#xf15c;',
        // 'fa-file-text-o' => '&#xf0f6;',
        // 'fa-file-video-o' => '&#xf1c8;',
        // 'fa-file-word-o' => '&#xf1c2;',
        // 'fa-file-zip-o' => '&#xf1c6;',
        // 'fa-files-o' => '&#xf0c5;',
        'fa-film' => '&#xf008;',
        'fa-filter' => '&#xf0b0;',
        'fa-fire' => '&#xf06d;',
        'fa-fire-extinguisher' => '&#xf134;',
        'fa-firefox' => '&#xf269;',
        'fa-flag' => '&#xf024;',
        'fa-flag-checkered' => '&#xf11e;',
        'fa-flag-o' => '&#xf11d;',
        'fa-flash' => '&#xf0e7;',
        'fa-flask' => '&#xf0c3;',
        // 'fa-flickr' => '&#xf16e;',
        'fa-floppy-o' => '&#xf0c7;',
        'fa-folder' => '&#xf07b;',
        'fa-folder-o' => '&#xf114;',
        'fa-folder-open' => '&#xf07c;',
        'fa-folder-open-o' => '&#xf115;',
        'fa-font' => '&#xf031;',
        // 'fa-fonticons' => '&#xf280;',
        'fa-forumbee' => '&#xf211;',
        'fa-forward' => '&#xf04e;',
        // 'fa-foursquare' => '&#xf180;',
        'fa-frown-o' => '&#xf119;',
        'fa-futbol-o' => '&#xf1e3;',
        'fa-gamepad' => '&#xf11b;',
        'fa-gavel' => '&#xf0e3;',
        'fa-gbp' => '&#xf154;',
        'fa-ge' => '&#xf1d1;',
        'fa-gear' => '&#xf013;',
        'fa-gears' => '&#xf085;',
        'fa-genderless' => '&#xf22d;',
        'fa-get-pocket' => '&#xf265;',
        'fa-gg' => '&#xf260;',
        'fa-gg-circle' => '&#xf261;',
        'fa-gift' => '&#xf06b;',
        'fa-git' => '&#xf1d3;',
        'fa-git-square' => '&#xf1d2;',
        'fa-github' => '&#xf09b;',
        'fa-github-alt' => '&#xf113;',
        'fa-github-square' => '&#xf092;',
        'fa-gittip' => '&#xf184;',
        'fa-glass' => '&#xf000;',
        'fa-globe' => '&#xf0ac;',
        'fa-google' => '&#xf1a0;',
        'fa-google-plus' => '&#xf0d5;',
        'fa-google-plus-square' => '&#xf0d4;',
        'fa-google-wallet' => '&#xf1ee;',
        'fa-graduation-cap' => '&#xf19d;',
        'fa-gratipay' => '&#xf184;',
        'fa-group' => '&#xf0c0;',
        'fa-h-square' => '&#xf0fd;',
        'fa-hacker-news' => '&#xf1d4;',
        // 'fa-hand-grab-o' => '&#xf255;',
        // 'fa-hand-lizard-o' => '&#xf258;',
        // 'fa-hand-o-down' => '&#xf0a7;',
        // 'fa-hand-o-left' => '&#xf0a5;',
        // 'fa-hand-o-right' => '&#xf0a4;',
        // 'fa-hand-o-up' => '&#xf0a6;',
        // 'fa-hand-paper-o' => '&#xf256;',
        // 'fa-hand-peace-o' => '&#xf25b;',
        // 'fa-hand-pointer-o' => '&#xf25a;',
        // 'fa-hand-rock-o' => '&#xf255;',
        // 'fa-hand-scissors-o' => '&#xf257;',
        // 'fa-hand-spock-o' => '&#xf259;',
        // 'fa-hand-stop-o' => '&#xf256;',
        // 'fa-hdd-o' => '&#xf0a0;',
        'fa-header' => '&#xf1dc;',
        'fa-headphones' => '&#xf025;',
        'fa-heart' => '&#xf004;',
        'fa-heart-o' => '&#xf08a;',
        'fa-heartbeat' => '&#xf21e;',
        'fa-history' => '&#xf1da;',
        'fa-home' => '&#xf015;',
        'fa-hospital-o' => '&#xf0f8;',
        'fa-hotel' => '&#xf236;',
        'fa-hourglass' => '&#xf254;',
        // 'fa-hourglass-1' => '&#xf251;',
        // 'fa-hourglass-2' => '&#xf252;',
        // 'fa-hourglass-3' => '&#xf253;',
        // 'fa-hourglass-end' => '&#xf253;',
        // 'fa-hourglass-half' => '&#xf252;',
        // 'fa-hourglass-o' => '&#xf250;',
        // 'fa-hourglass-start' => '&#xf251;',
        'fa-houzz' => '&#xf27c;',
        // 'fa-html5' => '&#xf13b;',
        'fa-i-cursor' => '&#xf246;',
        'fa-ils' => '&#xf20b;',
        'fa-image' => '&#xf03e;',
        'fa-inbox' => '&#xf01c;',
        'fa-indent' => '&#xf03c;',
        'fa-industry' => '&#xf275;',
        'fa-info' => '&#xf129;',
        'fa-info-circle' => '&#xf05a;',
        'fa-inr' => '&#xf156;',
        'fa-instagram' => '&#xf16d;',
        'fa-institution' => '&#xf19c;',
        // 'fa-internet-explorer' => '&#xf26b;',
        'fa-intersex' => '&#xf224;',
        'fa-ioxhost' => '&#xf208;',
        // 'fa-italic' => '&#xf033;',
        // 'fa-joomla' => '&#xf1aa;',
        'fa-jpy' => '&#xf157;',
        'fa-jsfiddle' => '&#xf1cc;',
        'fa-key' => '&#xf084;',
        'fa-keyboard-o' => '&#xf11c;',
        'fa-krw' => '&#xf159;',
        'fa-language' => '&#xf1ab;',
        'fa-laptop' => '&#xf109;',
        'fa-lastfm' => '&#xf202;',
        'fa-lastfm-square' => '&#xf203;',
        'fa-leaf' => '&#xf06c;',
        'fa-leanpub' => '&#xf212;',
        'fa-legal' => '&#xf0e3;',
        'fa-lemon-o' => '&#xf094;',
        'fa-level-down' => '&#xf149;',
        'fa-level-up' => '&#xf148;',
        'fa-life-bouy' => '&#xf1cd;',
        'fa-life-buoy' => '&#xf1cd;',
        'fa-life-ring' => '&#xf1cd;',
        'fa-life-saver' => '&#xf1cd;',
        'fa-lightbulb-o' => '&#xf0eb;',
        'fa-line-chart' => '&#xf201;',
        'fa-link' => '&#xf0c1;',
        'fa-linkedin' => '&#xf0e1;',
        'fa-linkedin-square' => '&#xf08c;',
        // 'fa-linux' => '&#xf17c;',
        'fa-list' => '&#xf03a;',
        // 'fa-list-alt' => '&#xf022;',
        // 'fa-list-ol' => '&#xf0cb;',
        // 'fa-list-ul' => '&#xf0ca;',
        'fa-location-arrow' => '&#xf124;',
        'fa-lock' => '&#xf023;',
        // 'fa-long-arrow-down' => '&#xf175;',
        // 'fa-long-arrow-left' => '&#xf177;',
        // 'fa-long-arrow-right' => '&#xf178;',
        // 'fa-long-arrow-up' => '&#xf176;',
        'fa-magic' => '&#xf0d0;',
        'fa-magnet' => '&#xf076;',
        'fa-mars-stroke-v' => '&#xf22a;',
        'fa-maxcdn' => '&#xf136;',
        'fa-meanpath' => '&#xf20c;',
        // 'fa-medium' => '&#xf23a;',
        // 'fa-medkit' => '&#xf0fa;',
        'fa-meh-o' => '&#xf11a;',
        // 'fa-mercury' => '&#xf223;',
        'fa-microphone' => '&#xf130;',
        'fa-mobile' => '&#xf10b;',
        // 'fa-motorcycle' => '&#xf21c;',
        // 'fa-mouse-pointer' => '&#xf245;',
        'fa-music' => '&#xf001;',
        'fa-navicon' => '&#xf0c9;',
        'fa-neuter' => '&#xf22c;',
        'fa-newspaper-o' => '&#xf1ea;',
        // 'fa-opencart' => '&#xf23d;',
        // 'fa-openid' => '&#xf19b;',
        // 'fa-opera' => '&#xf26a;',
        'fa-outdent' => '&#xf03b;',
        'fa-pagelines' => '&#xf18c;',
        'fa-paper-plane-o' => '&#xf1d9;',
        'fa-paperclip' => '&#xf0c6;',
        'fa-paragraph' => '&#xf1dd;',
        'fa-paste' => '&#xf0ea;',
        // 'fa-pause' => '&#xf04c;',
        'fa-paw' => '&#xf1b0;',
        // 'fa-paypal' => '&#xf1ed;',
        'fa-pencil' => '&#xf040;',
        'fa-pencil-square-o' => '&#xf044;',
        'fa-phone' => '&#xf095;',
        'fa-photo' => '&#xf03e;',
        'fa-picture-o' => '&#xf03e;',
        'fa-pie-chart' => '&#xf200;',
        'fa-pied-piper' => '&#xf1a7;',
        'fa-pied-piper-alt' => '&#xf1a8;',
        // 'fa-pinterest' => '&#xf0d2;',
        // 'fa-pinterest-p' => '&#xf231;',
        // 'fa-pinterest-square' => '&#xf0d3;',
        'fa-plane' => '&#xf072;',
        // 'fa-play' => '&#xf04b;',
        // 'fa-play-circle' => '&#xf144;',
        // 'fa-play-circle-o' => '&#xf01d;',
        'fa-plug' => '&#xf1e6;',
        'fa-plus' => '&#xf067;',
        'fa-plus-circle' => '&#xf055;',
        'fa-plus-square' => '&#xf0fe;',
        'fa-plus-square-o' => '&#xf196;',
        // 'fa-power-off' => '&#xf011;',
        'fa-print' => '&#xf02f;',
        'fa-puzzle-piece' => '&#xf12e;',
        'fa-qq' => '&#xf1d6;',
        // 'fa-qrcode' => '&#xf029;',
        'fa-question' => '&#xf128;',
        'fa-question-circle' => '&#xf059;',
        'fa-quote-left' => '&#xf10d;',
        'fa-quote-right' => '&#xf10e;',
        'fa-ra' => '&#xf1d0;',
        'fa-random' => '&#xf074;',
        // 'fa-rebel' => '&#xf1d0;',
        // 'fa-recycle' => '&#xf1b8;',
        // 'fa-reddit' => '&#xf1a1;',
        // 'fa-reddit-square' => '&#xf1a2;',
        'fa-refresh' => '&#xf021;',
        'fa-registered' => '&#xf25d;',
        'fa-remove' => '&#xf00d;',
        'fa-renren' => '&#xf18b;',
        'fa-reorder' => '&#xf0c9;',
        'fa-repeat' => '&#xf01e;',
        // 'fa-reply' => '&#xf112;',
        // 'fa-reply-all' => '&#xf122;',
        // 'fa-retweet' => '&#xf079;',
        'fa-rmb' => '&#xf157;',
        'fa-road' => '&#xf018;',
        'fa-rocket' => '&#xf135;',
        // 'fa-rotate-left' => '&#xf0e2;',
        // 'fa-rotate-right' => '&#xf01e;',
        'fa-rouble' => '&#xf158;',
        // 'fa-rss' => '&#xf09e;',
        // 'fa-rss-square' => '&#xf143;',
        'fa-rub' => '&#xf158;',
        'fa-ruble' => '&#xf158;',
        'fa-rupee' => '&#xf156;',
        // 'fa-safari' => '&#xf267;',
        'fa-sliders' => '&#xf1de;',
        'fa-slideshare' => '&#xf1e7;',
        'fa-smile-o' => '&#xf118;',
        // 'fa-sort-asc' => '&#xf0de;',
        // 'fa-sort-desc' => '&#xf0dd;',
        // 'fa-sort-down' => '&#xf0dd;',
        'fa-spinner' => '&#xf110;',
        'fa-spoon' => '&#xf1b1;',
        // 'fa-spotify' => '&#xf1bc;',
        'fa-square' => '&#xf0c8;',
        'fa-square-o' => '&#xf096;',
        'fa-star' => '&#xf005;',
        'fa-star-half' => '&#xf089;',
        'fa-stop' => '&#xf04d;',
        'fa-subscript' => '&#xf12c;',
        'fa-tablet' => '&#xf10a;',
        'fa-tachometer' => '&#xf0e4;',
        'fa-tag' => '&#xf02b;',
        'fa-tags' => '&#xf02c;',
    ];
}
