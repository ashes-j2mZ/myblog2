<?php
    // last edited

    /**
    * utility class for myblog2.
    */

    namespace classes\common;

    class Utility
    {

        public static function sanitize ($data)
        {
            $sanitized = array();
            foreach ( $data as $key => $value ) {
                $sanitized[$key] = htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' );
            }
            return $sanitized;
        }

    }

 ?>
