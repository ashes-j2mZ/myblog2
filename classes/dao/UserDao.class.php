<?php
    // last edited 2020年7月4日 土曜日 17:41

    namespace classes\dao;

    use classes\models\User;

    /**
     * User DAO class
     */
    final class UserDao extends Dao
    {

        private const TABLE_NAME = 'user';

        /**
         * get user information from login ID or primary ID in user table
         * @param string $login_id
         * @return User $user
         */
        public static function findUser($id)
        {
            if ( is_int($id) ) {
                $search = array(
                    'type' => parent::PRIMARY_KEY,
                    'value' => $id
                );
            } else {
                $search = array(
                    'type' => 'login_id',
                    'value' => $id
                );
            }

            $result = parent::find(self::TABLE_NAME, $search);
            return isset($result[0]) ? new User( reset($result) ) : null;
        }

        /**
         * update user information
         * @param User $user
         * @param array $edit_data
         * @return bool
         */
        public static function editUserInfo(User $user, $edit_data)
        {
            $limit = array('login_id' => $user->user_id);

            return parent::update(self::TABLE_NAME, $edit_data, $limit);
        }

        /**
         * create new user information
         * @param array $regist_data
         * @return int
         */
        public static function createUser(array $regist_data)
        {
            return parent::create(self::TABLE_NAME, $regist_data);
        }

        /**
         * find primary key associated with given user
         * @param User $user
         * @return int
         */
        public static function getPrimaryKey(User $user)
        {
            $search = array(
                'type' => 'login_id',
                'value' => $user->login_id
            );
            $result = parent::getKey(parent::PRIMARY_KEY, self::TABLE_NAME, $search);
            return (int)reset($result);
        }

        /**
        * find password associated with given user
        * @param User $user
        * @return string
        */
        public static function getPassword(User $user)
        {
            $search = array(
                'type' => 'login_id',
                'value' => $user->login_id
            );
            $result = parent::getKey('user_passwd', self::TABLE_NAME, $search);
            return reset($result);
        }

    }

 ?>
