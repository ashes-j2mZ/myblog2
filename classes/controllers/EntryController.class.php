<?php
    // last edited 2020年7月2日 木曜日 16:07

    namespace classes\controllers;

    use classes\common\Database;
    use classes\common\Utility;
    use classes\dao\EntryDao;
    use classes\models\Entry;

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
        public static function postEntry($entry_data)
        {
            // retrieve user information from session
            $loginUser = $_SESSION['loginUserModel'];
            // add user information to input data
            $entry_data['user_id'] = $loginUser->user_id;
            $entry_data['entry_id'] = $loginUser->login_id . '-' . date('ymd-Hi');
            $stripped = Utility::removeButtonInput($entry_data);
            // begin transaction
            Database::transaction();
            // insert data into entry table
            EntryDao::createEntry($stripped);
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

        public static function showLatest()
        {
            // set search parameters
            $param = null;
            $order = array(
                'parameter' => 'last_updated',
                'direction' => 'DESC'
            );
            $limit = 10;

            // begin transaction
            Database::transaction();
            // retrieve information from entry table
            $latest = EntryDao::find('entry', $param, $order, $limit);
            // commit transaction
            Database::commit();

            // initialize array to contain retrieved entries
            $entries = array();
            foreach ($latest as $value) {
                // create entry model using retrieved results
                $entry = new Entry($value);
                // retrieve entry author
                $author = $entry->showAuthor();
                // add to array
                $entries[] = array('entry' => $entry, 'author' => $author);
            }
            return $entries;
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
