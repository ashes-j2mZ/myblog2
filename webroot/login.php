<!-- last edited 2020年6月24日 水曜日 11:34 -->
<?php

    require_once '../common.php';

    use classes\common\Database;
    use classes\common\Utility;
    use classes\controllers\LoginController;

    // initialize variables
    $err_msg = null;
    $sanitized = null;

    // sign in
    if (!empty($_POST)) {
        $sanitized = Utility::sanitize($_POST);
    }
    try {
        LoginController::login();
    } catch (\Exception $e) {
        $err_msg = $e->getMessage();
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
        <h1><a href="<?php echo BLOG_TOP; ?>">My Blog</a></h1>
        <h2>Sign in to My Blog</h2>
        <?php echo is_null($err_msg) ? '' : '<p>' . $err_msg . '</p>'; ?>
        <form action="" method="post">
            <div class="element_wrap">
                <label for="login_id">Login ID<label>
                    <input type="text" name="login_id" value="<?php echo !empty($sanitized) ? $sanitized['login_id'] : ""; ?>">
            </div>
            <div class="element_wrap">
                <label for="user_passwd">Password<label>
                    <input type="password" name="user_passwd" value="">
            </div>
            <button type="submit" value="btn_signin">Sign in</button>
        </form>

    </body>
</html>
