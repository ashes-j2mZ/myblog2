<?php
    // last edited

    // start session
    session_start();

    if ( isset($_SESSION['login_id']) ) {
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

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
     <head>
         <meta charset="utf-8">
         <title>My Blog: Sign Out</title>
     </head>
     <body>
         <h1><a href="my_blog_home.php">My Blog</a></h1>
         <p>Signed out from your account.</p>
         <a href="my_blog_home.php"><button type="button" name="btn_top">My Blog Top</button></a>
     </body>
 </html>
