<?php
    // last edited 2020年6月22日 月曜日 13:11
    namespace classes\models;

    use classes\dao\UserDao;

    /**
     * User model base class
     */
    class UserBase
    {

        private $login_id = null;
        private $user_passwd = null;
        private $token = null;
        private $display_name = null;
        private $register_date = null;
        private $del_flag = null;

        /**
        * set instance properties
        * @param array $arrDao
        * @return classes\models\User
        */
        protected function setProperty(array $arrDao)
        {
            $this->setLoginId($arrDao['login_id'])
            ->setDisplayName($arrDao['display_name'])
            ->setUserPasswd($arrDao['user_passwd'])
            ->setToken($arrDao['token'])
            ->setDelFlag($arrDao['del_flag']);
            return $this;
        }

        /**
        * save changes
        * @return bool
        */
        public function save()
        {
            return UserDao::save($this);
        }

        /**
        * create
        * @return bool
        */
        public function create()
        {
            return UserDao::insert($this);
        }

        // setter functions
        public function setLoginId($login_id)
        {
            $this->login_id = $login_id;
            return $this;
        }
        public function setUserPasswd($user_passwd)
        {
            $this->user_passwd = $user_passwd;
            return $this;
        }
        public function setToken($token)
        {
            $this->token = $token;
            return $this;
        }
        public function setDisplayName($display_name)
        {
            $this->display_name = $display_name;
            return $this;
        }
        public function setRegisterDate($register_date)
        {
            $this->register_date = $register_date;
            return $this;
        }
        public function setDelFlag($del_flag)
        {
            $this->del_flag = $del_flag;
            return $this;
        }

        // getter functions
        public function getLoginId()
        {
            return $this->login_id;
        }
        public function getUserPasswd($user_passwd)
        {
            return $this->user_passwd;
        }
        public function getToken($token)
        {
            return $this->token;
        }
        public function getDisplayName($display_name)
        {
            return $this->display_name;
        }
        public function getRegisterDate($register_date)
        {
            return $this->register_date;
        }
        public function getDelFlag($del_flag)
        {
            return $this->del_flag;
        }

    }

 ?>
