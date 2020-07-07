<?php
    // last edited 2020年7月3日 金曜日 13:08

    namespace classes\models;

    use classes\dao\DraftDao;
    use classes\dao\UserDao;

    /**
     * entry draft model class
     * @since 2020/07/03
     */
    final class Draft extends ObjModel
    {

        private const DEFAULT = array(
            'draft_id' => '',
            'entry_title' => '',
            'entry_content' => '',
        );

        function __construct($args = self::DEFAULT)
        {
            parent::__construct($args);
        }

        /**
         * retrieve this draft's author
         * @return User
         */
        public function showAuthor()
        {
            $login_id = preg_replace('/((-\d{6}-\d{4})(-d|-nd))$/', '', $this->draft_id);
            // retrieve user information associated with this entry
            $user = UserDao::findUser($login_id);
            // show user's display name
            return is_null($user) ? 'Unknown author' : $user;
        }

        /**
         * retrieve primary key of this draft
         * @return int
         */
        public function showPrimaryKey()
        {
            return DraftDao::getPrimaryKey($this);
        }

    }


?>
