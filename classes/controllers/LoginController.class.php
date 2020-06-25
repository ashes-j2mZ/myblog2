<?php
// last edited 2020年6月22日 月曜日 12:01
  namespace classes\controllers;

  use classes\common\Database;
  use classes\common\ExcepionCode;
  use classes\common\InvalidErrorException;
  use classes\models\User;

  /**
   *
   */
  class LoginController
  {

    /**
    * name to be saved in session
    */
    const LOGIN_USER = 'loginUserModel';


    /**
     * log in using login id and password
     * @return void
     */
    public static function login()
    {
        // start session
        session_start();
        // retrieve and sanitize input from login form
        if ( filter_input_array(INPUT_POST) ) {
            $login_id = filter_input(INPUT_POST, 'login_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'user_passwd', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // check whether login ID exists in user database
            try {
                // begin transaction
                Database::transaction();

                // find user by login ID
                $sql = "SELECT * FROM users_table WHERE login_id = :login_id ";
                $loginUser = Database::select( $sql, array(':login_id' => $login_id) );
                if( empty($loginUser) ) {

                    $msg = nl2br("A user with this login ID does not exist.\n" . 'Try again or register from <a href="registration.php">here</a>.');
                } else {
                    // check whether password matches
                    if ( password_verify($password, $loginUser[0]['user_passwd']) ) {
                        // commit transaction
                        Database::commit();
                        // prevent session fixation attacks
                        session_regenerate_id(true);
                        // save user information from database into session
                        foreach ($loginUser[0] as $key => $value) {
                            $_SESSION[$key] = $value;
                        }
                        // return to top page
                        header('Location: ' . BLOG_TOP);
                    } else {
                        // commit transaction
                        Database::commit();
                        $msg = 'Incorrect login ID and/or password.';
                    }
                }
            } catch (\PDOException $e) {
                $msg = $e->getMessage();
            }
        }
      // // if input hasn't been submitted via POST, then stop
      // if (!filter_input_array(INPUT_POST)) {
      //   return;
      // }
      //
      //   // receive input from form
      //   $login_id = filter_input(INPUT_POST, 'Login ID');
      //   $password  = filter_input(INPUT_POST, 'Password');
      //
      //   // if either is empty, do nothing
      //   if($login_id == '' || $password == '') {
      //     return;
      //   }
      //
      //   // begin transaction
      //   Database::transaction();
      //
      //   // find user by login ID
      //   $user = new User();
      //   $user->findUser($login_id);
      //
      //   // check password
      //   if (!$user->checkPassword($password)) {
      //     Database::commit();
      //     throw new InvalidErrorException(ExceptionCode::INVALID_LOGIN_FAIL);
      //     }
      //
      //     // commit transaction
      //     Database::commit();
      //
      //     // prevent session fixation attacks
      //     session_regenerate_id(true);
      //
      //     // save to session
      //     $_SESSION[self::LOGIN_USER] = $user;
      //
      //     // redirect to home page for Users
      //     header(sprintf("location: %s"), self::TARGET_PAGE);
    }

    /**
     * check if logged in or not
     * @return bool
     */
     static public function checkLogin()
     {
       $user = (isset($_SESSION[self::LOGIN_USER])) ? $_SESSION[self::LOGIN_USER] : null;

       if (is_object($user) && $user->getLoginId() > 0) {
        return;
       }
       header('Location: /');
     }

     /**
      * get currently logged in user
      * @return User
      */
      static public function getLoginUser()
      {
        return $_SESSION[self::LOGIN_USER];
      }

     /**
      * log out
      * @return void
      */
      static public function logout()
      {
        $_SESSION = [];
        session_destroy();
        header('Location: /');
      }

  }

 ?>
