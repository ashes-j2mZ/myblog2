<!-- last edited -->
<?php

    require_once '../common.php';

    use classes\common\Database;
    use classes\common\Utility;
    use classes\controllers\RegistController;

    // initialize variables
    $sanitized = array();
    $input_errors = array();
    $page_flag = 0;

    // sanitize input
    if (!empty($_POST)) {
        $sanitized = Utility::sanitize($_POST);
    }

    // Switch between registration, confirmation and completion pages using page flag.
    if (!empty($_POST['btn_confirm'])) {
        // Validate input before moving to confimation page.
        // Display errors if input inappropriate.
        $input_errors = RegistController::validate($sanitized);
        if ( empty($input_errors) ) { // move to confirmation page
            $page_flag = 1;
            // start session
            session_start();
            $_SESSION['page'] = true;
        }
    } elseif (!empty($_POST['btn_submit'])) { // move to completion page
        session_start();
        // if ( !empty($_SESSION['page']) && $_SESSION['page'] === true ) {
            // add information to database
            RegistController::registration($sanitized);
            // destroy session
            unset($_SESSION['page']);
            $page_flag = 2;
            unset($_POST);
            unset($sanitized);
            unset($input_errors);
        // }
    } else {
        $page_flag = 0;
    }

 ?>

 <!DOCTYPE html>
 <html lang="ja" dir="ltr">

     <head>
         <!-- Required meta tags -->
         <meta charset="utf-8">
         <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->

         <!-- Bootstrap CSS -->
         <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->

         <title>My Blog: User Registration</title>
         <link rel="stylesheet" type="text/css" href="forms/form.css">
     </head>

     <body>
         <br>
         <h1><a href="php <?php echo BLOG_TOP; ?>">My Blog</a></h1>
         <?php if ($page_flag === 1): ?>
             <h2>Register as My Blog user with the following information. Continue?</h2>
             <div class="element_wrap">
                 <label for="display_name">User name</label>
                 <p><?php echo $sanitized["display_name"]; ?></p>
             </div>
             <div class="element_wrap">
                 <label for="login_id">Login ID</label>
                 <p><?php echo $sanitized["login_id"]; ?></p>
             </div>
             <div class="element_wrap">
                 <label for="user_passwd">Password</label>
                 <p><?php echo RegistController::maskPassword($sanitized['user_passwd']); ?></p>
             </div>

             <form action="" method="post">
                 <input type="submit" name="btn_back" value="Return">
                 <input type="submit" name="btn_submit" value="Register">
                 <!-- 受け渡し用 -->
                 <input type="hidden" name="display_name" value="<?php echo $sanitized['display_name']; ?>">
                 <input type="hidden" name="login_id" value="<?php echo $sanitized['login_id']; ?>">
                 <input type="hidden" name="user_passwd" value="<?php echo $sanitized['user_passwd']; ?>">
             </form>

         <?php elseif ($page_flag === 2): ?>
             <h2>Successfully registered as user.<br>Return to top page or sign in.</h2>
             <a href="my_blog_home.php"><button type="button" name="btn_top">My Blog Top</button></a>
             <a href="login.php"><button type="button" name="btn_login">Sign in</button></a>

         <?php else: ?>
             <!-- Display input errors as list -->
             <?php if (!empty($input_errors)) : ?>
                 <ul class="error_list">
                     <?php foreach ($input_errors as $value) : ?>
                         <li><?php echo $value; ?></li>
                     <?php endforeach ?>
                 </ul>
             <?php endif ?>

             <h2>Enter the following to register as a My Blog user.</h2>
             <form method="post" action="" enctype="multipart/form-data">
                 <div class="element_wrap">
                     <label for="display_name">User name</label>
                     <input type="text" name="display_name" value="<?php echo !empty($sanitized['display_name']) ?  $sanitized['display_name'] : ''; ?>">
                 </div>

                 <div class="element_wrap">
                     <label for="login_id">Login ID</label>
                     <input type="text" name="login_id" value="<?php echo !empty($sanitized['login_id']) ?  $sanitized['login_id'] : ''; ?>">
                 </div>

                 <div class="element_wrap">
                     <label for="user_passwd">Password</label>
                     <input type="password" name="user_passwd" value="<?php echo !empty($sanitized['user_passwd']) ? $sanitized['user_passwd'] : ''; ?>">
                 </div>

                 <div class="element_wrap">
                     <label for="passwd_verify">Password (verify)</label>
                     <input type="password" name="passwd_verify" value="<?php echo !empty($sanitized['passwd_verify']) ? $sanitized['passwd_verify'] : ''; ?>">
                 </div>
                 <br>
                 <input type="submit" name="btn_confirm" value="Go to confirmation page">
             </form>
         <?php endif ?>

     </body>
 </html>
