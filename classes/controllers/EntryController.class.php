<?php
    // last edited 2020年6月29日 月曜日 13:47
    namespace classes\controllers;

    use classes\common\Database;
    use classes\models\Entry;
    use classes\models\User;

    /**
     * controller for adding blog entries
     * @since 2020/06/26
     */
    class EntryController
    {

        /**
         * takes sanitized input from entry form and saves to entry table
         * @param array $data
         * @return void
         */
        public static function postEntry($data)
        {
            // create new entry model for posting
            $entry = new Entry();
            // retrieve user information from session
            $loginUser = $_SESSION['loginUserModel'];
            $entry->setUserId($loginUser->getUserId())
                     ->setEntryId( $loginUser->getLoginId() . '-' . date('ymd-Hi') )
                     ->setEntryTitle($data['entry_title'])
                     ->setEntryContent($data['entry_content']);
            // begin transaction
            Database::transaction();
            // insert data into entry table
            $entry->create();
            // commit transaction
            Database::commit();
        }

        /**
         * finds and displays blog entry with given entry ID
         * @param string $entry_id
         * @return void
         */
        public static function showEntry($entry_id)
        {
            $entry_array = EntryDao::getDao($entry_id)[0];
            return isset($entry_array) ? $entry_array : null;
        }

        /**
         * updates blog entry with entry ID
         * @param string $entry_id
         * @param array $data
         * @return void
         */
        public static function editEntry($entry_id, $data)
        {
            // begin transaction
            Database::transaction();
            // find entry to be edited
            $entry = new Entry();
            $entry = $entry->findEntry($entry_id);
            if ( $entry !== null ) {
                // update entry information
                $entry->setEntryTitle($data['entry_title'])
                         ->setEntryContent($data['entry_content']);
                $entry->save();
                // commit transaction
                Database::commit();
            }

        }

        /**
         * validates input from entry form and returns error messages if any
         * @return array $errors
         */
        public static function validate($data)
        {
            $errors = array();

            // validate entry title
            if ( empty($data['entry_title']) ) { // emtpy title
                $errors[] = 'Please enter a title for your blog entry.';
            }

            // validate entry content
            if ( empty($data['entry_content']) ) { // empty entry
                $errors[] = 'Cannot post an empty blog entry.';
            } elseif ( mb_strlen($data['entry_content']) < 30 ) { // entry length too short
                $errors[] = 'Your entry must be at least 30 characters long.';
            }

            return $errors;
        }

    }



 ?>
