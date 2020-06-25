<!-- last edited 2020年6月24日 水曜日 11:34 -->
<?php

    require_once '../common.php';

    use classes\common\Database;

    // initialize variables
    $msg = null;
    $login_id = null;
    $password = null;

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

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>My Blog: Sign In</title>
        <link rel="stylesheet" type="text/css" href="forms/form.css">
    </head>

    <body>
        <h1><a href="my_blog_home.php">My Blog</a></h1>
        <h2>Sign in to My Blog</h2>
        <form action="" method="post">
            <div class="element_wrap">
                <label for="login_id">Login ID<label>
                    <input type="text" name="login_id" value="<?php echo ( !empty($login_id) ) ? $login_id : '' ; ?>">
            </div>
            <div class="element_wrap">
                <label for="user_passwd">Password<label>
                    <input type="password" name="user_passwd" value="">
            </div>
            <p><?php echo $msg; ?></p>
            <button type="submit" value="btn_signin">Sign in</button>
        </form>

    </body>
</html>
