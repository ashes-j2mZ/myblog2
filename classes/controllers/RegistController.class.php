<?php
    // last edited 2020年7月2日 木曜日 15:27

    namespace classes\controllers;

    use classes\common\Database;
    use classes\common\Utility;
    use classes\dao\UserDao;

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
        public static function registration($regist_data)
        {
            // encrypt password provided in registration data
            $regist_data['user_passwd'] = password_hash($regist_data['user_passwd'], PASSWORD_BCRYPT);
            // remove button input
            $stripped = Utility::removeButtonInput($regist_data);

            // begin transaction
            Database::transaction();
            // insert data into users table
            UserDao::createUser($stripped);
            Database::commit();
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
                if (UserDao::findUser($data['login_id']) !== null) {
                    $errors[] = "A user with this login ID already exists.";
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
         * @param type $password
         * @return string $masked
         */
         public static function maskPassword($password)
         {
             $masked = mb_substr($password, 0, 2, "UTF-8") . str_repeat("*", mb_strlen($password, "UTF-8") - 3) . mb_substr($password, -1, 1, "UTF-8");
             return $masked;
         }
    }

 ?>
