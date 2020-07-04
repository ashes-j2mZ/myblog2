<?php
    // last edited 2020年7月4日 土曜日 17:41

    namespace classes\models;

    use classes\dao\EntryDao;
    use classes\dao\UserDao;

    /**
     * blog entry model class
     * @since 2020/06/26
     */
    final class Entry extends ObjModel
    {

        private const DEFAULT = array(
            'user_id' => '',
            'entry_id' => '',
            'entry_title' => '',
            'entry_content' => '',
        );

        public function __construct($args = self::DEFAULT)
        {
            parent::__construct($args);
        }

        /**
        * retrieve this entry's author
        * @return User
        */
        public function showAuthor()
        {
            $login_id = mb_substr($this->entry_id, 0, -12);
            // retrieve user information associated with this entry
            $user = UserDao::findUser($login_id);
            // show user's display name
            return is_null($user) ? 'Unknown author' : $user;
        }

        /**
        * retrieve primary key of this entry's author
        * @return int
        */
        public function showPrimaryKey()
        {
            return EntryDao::getPrimaryKey($this);
        }

    }

 ?>
