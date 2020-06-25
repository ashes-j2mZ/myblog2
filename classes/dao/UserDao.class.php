<?php
    // last edited 2020年6月22日 月曜日 12:01
    namespace classes\dao;

    use classes\common\Database;
    use classes\model\User;

    /**
     * User DAO class
     */
    class UserDao
    {

        /**
         * get array from login ID
         */
        public static function getDao($intLoginId, $intDelFlag = null)
        {
            $sql = "SELECT ";
            $sql .= "login_id";
            $sql .= ", user_passwd";
            $sql .= ", display_name";
            $sql .= ", del_flag";
            $sql .= "FROM users_table";
            $sql .= "WHERE login_id = :loginId ";

            $arr = array();
            $arr[':loginId'] = $intLoginId;
            if (!is_null($intDelFlag) && in_array($intDelFlag, array(0, 1))) {
                $sql .= "AND del_flag = :delFlag ";
                $arr[':delFlag'] = $intDelFlag;
            }

            return Database::select($sql, $arr);
        }

        /**
         * update user information
         * @param User $user
         * @return bool
         */
        public static function save(User $user)
        {
            $sql = "UPDATE ";
            $sql .= "'users_table' ";
            $sql .= "SET ";
            $sql .= "user_passwd = :password";
            $sql .= ",  token = :token";
            $sql .= ",  display_name = :displayName";
            $sql .= ", del_flag = :delFlag";
            $sql .= "WHERE login_id = :loginId";

            $arr = array();
            $arr[':loginId'] = $user->getLoginId();
            $arr[':password'] = $user->getUserPasswd();
            $arr[':token'] = $user->getToken();
            $arr[':displayName'] = $user->getDisplayName();
            $arr[':delFlag'] = $user->getDelFlag();

            return Database::update($sql, $arr);
        }

        /**
        * create new user information
        * @return int
        */
        public static function insert(User $user)
        {
            $sql = "INSERT INTO ";
            $sql .= "users_table ";
            $sql .= "(";
            $sql .= "login_id";
            $sql .= ", user_passwd";
            $sql .= ",  token";
            $sql .= ",  display_name";
            $sql .= ", del_flag";
            $sql .= ") VALUES (";
            $sql .= "NULL ";
            $sql .= ", :password";
            $sql .= ", :token";
            $sql .= ", :displayName";
            $sql .= ", :delFlag";
            $sql .= ")";

            $arr = array();
            $arr[':password'] = $user->getUserPasswd();
            $arr[':token'] = $user->getToken();
            $arr[':displayName'] = $user->getDisplayName();
            $arr[':delFlag'] = $user->getDelFlag();

            return Database::insert($sql, $arr);
        }

    }

 ?>
