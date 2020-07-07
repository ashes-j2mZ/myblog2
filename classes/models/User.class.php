<?php
    // last edited 2020年7月7日 火曜日 14:55
    namespace classes\models;

    use classes\dao\UserDao;

    /**
    * User class for My Blog.
    */
    final class User extends ObjModel
    {

        private const DEFAULT = array(
            'login_id' => '',
            'display_name' => '',
            'register_date' => ''
        );

        public function __construct($args = self::DEFAULT, $pub = self::DEFAULT)
        {
            parent::__construct($args, $pub);
        }

        /**
        * check whether password matches
        * @param type $password
        * @return bool
        */
        public function checkPassword($password)
        {
            $hash = $this->showPassword();
            return password_verify($password, $hash);
        }

        /**
        * retrieve primary key of this user
        * @return int
        */
        public function showPrimaryKey()
        {
            return UserDao::getPrimaryKey($this);
        }

        /**
        * retrieve this user's password
        * @return int
        */
        private function showPassword()
        {
            return UserDao::getPassword($this);
        }

    }

?>
