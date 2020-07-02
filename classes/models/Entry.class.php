<?php
    // last edited 2020年7月2日 木曜日 16:06

    namespace classes\models;

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
            'del_flag' => 0
        );

        public function __construct($args = self::DEFAULT, $pub = null)
        {
            $pub = array( 'entry_id', 'entry_title', 'entry_content', 'del_flag' );
            parent::__construct($args, $pub);
        }

        /**
        * retrieve name of this entry's author
        * @return string
        */
        public function showAuthor()
        {
            $login_id = mb_substr($this->entry_id, 0, -12);
            // retrieve user information associated with this entry
            $user = UserDao::findUser($login_id);
            // show user's display name
            return is_null($user) ? 'Unknown author' : $user->display_name;
        }

    }

 ?>
