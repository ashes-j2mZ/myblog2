<?php
    function autoloader($name)
    {
        $arrToken = explode('\\', $name);
        $arrToken[0] = '/classes';
        $filename = BASE_DIR . implode("/", $arrToken) . '.class.php';
        if (file_exists($filename)) {
            require_once($filename);
        }
    }
 ?>
