<?php
// last edited 2020年6月22日 月曜日 12:01
  namespace classes\controllers;

  use classes\common\Database;
  use classes\common\ExceptionCode;
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
        // retrieve and sanitize input from login form
        if ( filter_input_array(INPUT_POST) ) {
            $login_id = filter_input(INPUT_POST, 'login_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'user_passwd', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // begin transaction
            Database::transaction();
            // find user by login ID
            $loginUser = new User();
            // check whether user with given login ID exists
            if( $loginUser->findUser($login_id) == null ) {
                $msg = nl2br("A user with this login ID does not exist.\n" . 'Try again or register from <a href="registration.php">here</a>.');
            } else {
                // check whether password matches
                if ( $loginUser->checkPassword($password) ) {
                    // commit transaction
                    Database::commit();
                    // prevent session fixation attacks
                    session_regenerate_id(true);
                    // save user information from database into session
                    $_SESSION[self::LOGIN_USER] = $loginUser;
                    // foreach ($loginUser as $key => $value) {
                    //     $_SESSION[$key] = $value;
                    // }

                    // return to top page
                    header('Location: ' . BLOG_TOP);
                } else {
                    // commit transaction
                    Database::commit();
                    throw new InvalidErrorException(ExceptionCode::INVALID_LOGIN_FAIL);
                }
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

       return is_object($user);
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
          if ( isset($_SESSION['loginUserModel']) ) {
              // clear all session variables
              $_SESSION = array();
              // delete session cookies
              if (ini_get("session.use_cookies")) {
                  $params = session_get_cookie_params();
                  setcookie(session_name(), '', time() - 42000,
                      $params["path"], $params["domain"],
                      $params["secure"], $params["httponly"]
                  );
              }
              //Destroy session
              session_destroy();
          } else {
              // redirect to top page
              header('Location: ' . BLOG_TOP);
          }
      }

  }

 ?>
