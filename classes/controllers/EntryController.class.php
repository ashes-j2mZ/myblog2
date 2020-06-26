<?php
    // last edited
    namespace classes\controllers;

    use classes\common\Database;
    use classes\models\User;

    /**
     * controller for adding blog entries
     */
    class EntryController
    {

        /**
         * takes sanitized input from entry form and saves to entry table
         * @return array $errors
         */
        public static function postEntry($data)
        {
            
        }

        /**
         * validates input from entry form and returns error messages if any
         * @return array $errors
         */
        public static function validate($data)
        {
            $errors = array();

            // validate entry title
            if ( !empty($data['entry_title']) ) { // emtpy title
                $errors[] = 'Please enter a title for your blog entry.';
            }

            // validate entry content
            if ( !empty($data['entry_content']) ) { // empty entry
                $errors[] = 'Cannot post an empty blog entry.';
            } elseif ( mb_strlen($data['entry_content']) < 30 ) { // entry length too short
                $errors[] = 'Your entry must be at least 30 characters long.';
            }

            return $errors;
        }

    }



 ?>
