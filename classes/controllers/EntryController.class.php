<?php
    // last edited 2020年7月4日 土曜日 17:41

    namespace classes\controllers;

    use classes\common\Database;
    use classes\common\Utility;
    use classes\dao\DraftDao;
    use classes\dao\EntryDao;
    use classes\models\Draft;
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
            $login_user = $_SESSION['loginUserModel'];
            // add user information to input data
            $entry_data['user_id'] = $login_user->showPrimaryKey();
            $entry_data['entry_id'] = $login_user->login_id . '-' . date('ymd-Hi');
            $stripped = Utility::removeButtonInput($entry_data);
            // begin transaction
            Database::transaction();
            // insert data into entry table
            EntryDao::createEntry($stripped);
            // commit transaction
            Database::commit();
        }

        /**
         * find and display blog entry with given entry ID
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

        /**
         * find and display latest blog entries from entire site or by a given user
         * @param string $user_id
         * @return array $entries
         */
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

        // -------------------------methods pertaining to drafts ---------------------------------------
        /**
         * finds and displays blog entry with given draft ID
         * @return Draft $draft
         */
        public static function viewDraft()
        {
            // check if draft ID has been submitted via GET
            if ( isset($_GET['draft_id']) && is_string($_GET['draft_id']) ) {
                // begin transaction
                Database::transaction();
                // check if draft exists
                $draft = DraftDao::findDraft($_GET['entry_id']);
                if ( !is_null($draft) ) {
                    // commit transaction and return retrieved draft
                    Database::commit();
                    return $draft;
                } else {
                    // commit transaction
                    Database::commit();
                }
            }
        }

        /**
         * retrieve all drafts matching a given user ID separated into new drafts and edit drafts
         * @param array $user_id
         * @return mixed
         */
        public static function showDrafts($user_id)
        {
            // begin transaction
            Database::transaction();
            // retrieve information from draft table
            $drafts = DraftDao::findUserDrafts($user_id);
            // commit transaction
            Database::commit();

            // return error message if no drafts available
            if ($drafts === false) {
                return 'You currently have no saved drafts.';
            } else {
                // initialize array to contain retrieved entries
                $new_drafts = array();
                $edit_drafts = array();
                foreach ($drafts as $value) {
                    if ($value->entry_id == null) { // draft not associated with existing entry
                        $new_drafts[] = $value;
                    } else { // draft contains edits to existing entry
                        $edit_drafts[] = $value;
                    }
                }
                // $new_drafts = array_filter($drafts, function($v) { return $v->entry_id == null;});
                // reset($drafts);
                // $edit_drafts = array_filter($drafts, function($v) { return $v->entry_id !== null;});
                return array($new_drafts, $edit_drafts);
            }
        }

        /**
         * saves currently input data as draft
         * @param array $input_data
         * @return void
         */
        public static function saveDraft($input_data)
        {
            // remove button input from input data
            $stripped = Utility::removeButtonInput($input_data);
            // begin transaction
            Database::transaction();
            // if editing existing draft, update using input data and save updated draft into session
            if ( isset($_SESSION['targetDraft']) ) {
                $_SESSION['targetDraft'] = DraftDao::updateDraft($_SESSION['targetDraft'], $stripped);
                // commit transaction
                Database::commit();
            } else { // create new draft using input data and save created draft into session
                // add user ID from session into input data array
                $stripped['user_id'] = $_SESSION['loginUserModel']->showPrimaryKey();
                // if draft based on edits to an existing entry, then add its ID to input data array
                if ( isset( $_SESSION['targetEntry']) ) {
                    $stripped['entry_id'] = $_SESSION['targetEntry']->showPrimaryKey();
                    $stripped['draft_id'] = $_SESSION['loginUserModel']->login_id . '-' . date('ymd-Hi') . '-ed';
                } else {
                    $stripped['draft_id'] = $_SESSION['loginUserModel']->login_id . '-' . date('ymd-Hi') . '-nd';
                }
                // create new draft and save into session
                $_SESSION['targetDraft'] = DraftDao::createDraft($stripped);
                // commit transaction
                Database::commit();
            }
        }

        /**
        * discards draft set in session from database
        * @return void
        */
        public static function discardDraft()
        {
            // initialize variables needed for removal
            $delete = array('del_flag' => 1);
            // begin transaction
            Database::transaction();
            // flag entry for removal
            DraftDao::updateDraft($_SESSION['targetDraft'], $delete);
            // remove entry from database
            DraftDao::deleteDraft();
            // commit transaction
            Database::commit();
        }

    }



 ?>
