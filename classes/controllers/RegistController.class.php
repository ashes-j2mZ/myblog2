<?php
    // last edited

    namespace classes\controllers;

    use classes\common\Database;
    use classes\common\Utility;
    use classes\models\User;

    /**
     * User registration controller class.
     * @since 2020/06/24
     */
    final class RegistController
    {

        /**
         * user registration
         * @param array $data
         * @return void
         */
        public static function registration($data)
        {
            $msg = null;
            try {
                // begin transaction
                Database::transaction();
                // insert information into user table
                $sql = "INSERT INTO users_table (login_id, user_passwd, display_name) VALUES (:login_id, :user_passwd, :display_name)";
                $arr = array( ':login_id' => $data['login_id'],
                            ':user_passwd' => password_hash($data['user_passwd'], PASSWORD_BCRYPT),
                            ':display_name' => $data['display_name'] );
                Database::insert($sql, $arr);
                // commit transaction
                Database::commit();
            } catch (PDOException $e) {
                $msg = $e->getMessage();
            }
        }
        /**
         * validates user input from form and displays any errors
         * @param array $data
         * @return array $errors
         */
        public static function validate($data)
        {
            $errors = array();

            // validate login ID
            if ( empty($data['login_id']) ) { // empty
                $errors[] = "A login ID is required to register.";
            } elseif ( mb_strlen($data['login_id']) < 6 || mb_strlen($data['login_id']) > 16 ) { // invalid length
                $errors[] = "Your login ID must be between 6 and 16 characters long.";
            }  else { // ID already exists
                try {
                    $sql = "SELECT * FROM users_table WHERE login_id = :login_id ";
                    $loginUser = Database::select( $sql, array(':login_id' => $data['login_id']) );
                    // check whether ID exists
                    if ( !empty($loginUser) ) {
                        $errors[] = "A user with this login ID already exists.";
                    }
                } catch (\PDOException $e) {
                    $errors[] = "An error occurred while trying to connect to the database.";
                }
            }

            // validate user name
            if ( empty($data['display_name']) ) { // empty
                $errors[] = "A user name is required to register.";
            } elseif ( mb_strlen($data['display_name']) < 6 || mb_strlen($data['display_name']) > 30 ) { // invalid length
                $errors[] = "Your user name must be between 5 and 30 characters long.";
            }

            // validate password
            if ( empty($data['user_passwd']) ) { // empty
                $errors[] = "A password is required to register.";
            } elseif ( mb_strlen($data['user_passwd']) < 6 || mb_strlen($data['user_passwd']) > 16 ) { // invalid length
                $errors[] = "Your password must be between 6 and 16 characters long.";
            }

            // validate password (verification)
            if ( empty($data['passwd_verify']) ) { // empty
                $errors[] = "Please enter your password twice for verification.";
            } elseif ( $data['passwd_verify'] != $data['user_passwd'] ) { // passwords don't match
                $errors[] = "Your passwords do not match.";
            }

            return $errors;
        }

        /**
         * masks part of password in confirmation screen
         * @param string $password
         * @return string $masked
         */
         public static function maskPassword($password)
         {
             $masked = mb_substr($password, 0, 2, "UTF-8") . str_repeat("*", mb_strlen($password, "UTF-8") - 3) . mb_substr($password, -1, 1, "UTF-8");
             return $masked;
         }
    }

 ?>