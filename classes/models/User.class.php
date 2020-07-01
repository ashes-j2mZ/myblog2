<?php
    // last edited 2020年6月22日 月曜日 13:11
    namespace classes\models;

    use classes\dao\UserDao;

    /**
    * User class for My Blog.
    */
    final class User extends ObjModel
    {

        public function __construct($args, $pub = null)
        {
            $pub = array( 'login_id', 'user_passwd', 'register_date', 'del_flag' );
            parent::__construct($args, $pub);
        }

        /**
        * find user by login ID
        * @param string $id
        * @return classes\models\Users
        */
        public function findUser($id)
        {
            $dao = UserDao::getDao($id);
            return ( isset($dao[0]) ) ? $this->setProperty( reset($dao) ) : null;
        }

        /**
        * check whether password matches
        * @param type $password
        * @return bool
        */
        public function checkPassword($password)
        {
            $hash = $this->getUserPasswd();
            return password_verify($password, $hash);
        }

    }

?>
