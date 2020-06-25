<?php
    // last edited 2020年6月24日 水曜日 10:31

    /**
    * development mode
    */
    define('DEVELOPMENT', 1);

    /**
    * production mode
    */
    define('PRODUCTION', 2);

    /**
    * root directory
    */
    define('BASE_DIR', __DIR__);

    /**
    * path to webroot for redirection
    */
    define('REDIRECT_PATH', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));

    /**
    * path to top page for redirection
    */
    define('BLOG_TOP', REDIRECT_PATH . '/index.php');

 ?>
