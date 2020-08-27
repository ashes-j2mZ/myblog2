<?php
    // last edited 2020年7月7日 火曜日 14:55

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
            'entry_id' => '',
            'draft_id' => '',
            'entry_title' => '',
            'entry_content' => '',
            'last_updated' => ''
        );

        public function __construct($args = self::DEFAULT, $pub = self::DEFAULT)
        {
            parent::__construct($args, $pub);
        }

        /**
         * retrieve this draft's author
         * @return User $author
         */
        public function showAuthor()
        {
            $login_id = preg_replace('/((-\d{6}-\d{4})(-ed|-nd))$/', '', $this->draft_id);
            // retrieve user information associated with this entry
            $author = UserDao::findUser($login_id);
            // show user's display name
            return is_null($author) ? 'Unknown author' : $author;
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
