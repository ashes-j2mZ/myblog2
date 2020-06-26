<?php
    // last edited

    require_once '../common.php';

    use classes\controllers\LoginController;

    // start session
    session_start();
    LoginController::logout();

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
     <head>
         <meta charset="utf-8">
         <title>My Blog: Sign Out</title>
     </head>
     <body>
         <p>Signed out from your account.</p>
         <a href="<?php echo BLOG_TOP; ?>"><button type="button" name="btn_top">My Blog Top</button></a>
     </body>
 </html>
