<?php
    // last edited 2020年6月22日 月曜日 14:46
    require_once 'config.php';
    // require_once BASE_DIR . '/vendor/autoload.php';

    // rewrite to PRODUCTION in production environment
    define('MODE', DEVELOPMENT);

    // display errors when in development environment
    if (MODE === DEVELOPMENT) {
        ini_set('display_errors', true);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', false);
    }

    require_once 'autoload.php';
    spl_autoload_register('autoloader');

    session_start();

 ?>
