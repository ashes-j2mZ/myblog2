<?php
    // last edited

    /**
    * utility class for myblog2
    *@since 2020/06/25.
    */

    namespace classes\common;

    class Utility
    {

        /**
        * sanitize input data by escaping special characters
        * @param array $input
        * @return array $sanitized
        */
        public static function sanitize ($input)
        {
            $sanitized = array();
            foreach ( $input as $key => $value ) {
                $sanitized[$key] = htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' );
            }
            return $sanitized;
        }

        /**
        * remove buttons from input data before adding to database
        * @param array $input
        * @return array
        */
        public static function removeButtonInput($input)
        {
            foreach ($input as $key => $value) {
                if ( preg_match('/btn_(.+)/', $key) === 1 ) {
                    unset($input[$key]);
                }
            }
            return $input;
        }

    }

 ?>
