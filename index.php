<?php

define('DS', DIRECTORY_SEPARATOR);
define('ENV', getenv('APP_ENV'));
define('VERSION', '0.12.7');
define('MIGRATION_NUMBER', 220);

define('PATH', __DIR__ . DS);
define('APP', PATH . 'app' . DS);
define('SYS', PATH . 'system' . DS);
define('EXT', '.php');

define('UPLOAD_DIR', 'uploads');
define('THUMBNAIL_DIR', 'uploads/thumbnails');
define('SLIDER_DIR', 'uploads/sliders');

/** @noinspection PhpIncludeInspection */
require APP . 'composer_check' . EXT;
/** @noinspection PhpIncludeInspection */
require SYS . 'start' . EXT;
