<?php
    // last edited 2020年7月2日 木曜日 13:43

    namespace classes\dao;

    use classes\models\User;

    /**
     * User DAO class
     */
    class UserDao extends Dao
    {

        private const TABLE_NAME = 'user';

        /**
         * get user information from login ID or primary ID in user table
         * @param string $login_id
         * @return User $user
         */
        public static function findUser($id)
        {
            $search = array(
                'type' => 'login_id',
                'value' => $id
            );

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
        * @return int
        */
        public static function createUser(array $regist_data)
        {
            return parent::create(self::TABLE_NAME, $regist_data);
        }

    }

 ?>
