<?php
    // last edited 2020年7月2日 木曜日 16:55
    namespace classes\models;

    use classes\dao\UserDao;

    /**
    * User class for My Blog.
    */
    final class User extends ObjModel
    {

        private const DEFAULT = array(
            'user_id' => '',
            'login_id' => '',
            'user_passwd' => '',
            'display_name' => '',
            'register_date' => '',
            'del_flag' => 0
        );

        public function __construct($args = self::DEFAULT, $pub = null)
        {
            $pub = array( 'login_id', 'user_passwd', 'register_date', 'del_flag' );
            parent::__construct($args, $pub);
        }

        /**
        * check whether password matches
        * @param type $password
        * @return bool
        */
        public function checkPassword($password)
        {
            $hash = $this->user_passwd;
            return password_verify($password, $hash);
        }

    }

?>
