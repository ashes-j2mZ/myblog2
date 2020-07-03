<?php
    // last edited 2020年7月3日 金曜日 16:02

    namespace classes\controllers;

    use classes\common\Database;
    use classes\common\Utility;
    use classes\dao\EntryDao;
    use classes\models\Entry;

    /**
     * controller for adding and manipulating blog entries
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
         * @return Entry $entry
         */
        public static function viewEntry()
        {
            // check if entry ID has been submitted via GET
            if ( isset($_GET['entry_id']) && is_string($_GET['entry_id']) ) {
                // begin transaction
                Database::transaction();
                // check if entry exists
                $entry = EntryDao::findEntry($_GET['entry_id']);
                if ( !is_null($entry) ) {
                    // commit transaction and return retrieved entry
                    Database::commit();
                    return $entry;
                } else {
                    // commit transaction
                    Database::commit();
                }
            }
        }

        public static function showLatest($user_id = null)
        {
            // set search parameters
            $param = is_null($user_id) ? null :
            array(
                'type' => 'user_id',
                'value' => $user_id
            );
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
         * updates blog entry set in session
         * @param array $edit_data
         * @return void
         */
        public static function updateEntry($edit_data)
        {
            if ( isset($_SESSION['targetEntry']) && ($_SESSION['targetEntry'] instanceof Entry) ) {
                // remove button input
                $stripped = Utility::removeButtonInput($edit_data);
                // begin transaction
                Database::transaction();
                EntryDao::editEntry($_SESSION['targetEntry'], $stripped);
                // commit transaction
                Database::commit();
            }

        }

        /**
        * removes blog entry set in session from database
        * @return void
        */
        public static function removeEntry()
        {
            // initialize variables needed for removal
            $delete = array('del_flag' => 1);
            // begin transaction
            Database::transaction();
            // flag entry for removal
            EntryDao::editEntry($_SESSION['targetEntry'], $delete);
            // remove entry from database
            EntryDao::deleteEntry();
            // commit transaction
            Database::commit();
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
