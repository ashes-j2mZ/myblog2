<?php
    // last edited 2020年7月3日 金曜日 16:45

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

    /**
    * path to entry page for redirection
    */
    define('BLOG_ENTRY', REDIRECT_PATH . '/entry_view.php?entry_id=');

 ?>
