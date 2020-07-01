<!-- last edited 2020年6月22日 月曜日 12:01 -->
<?php
    require_once '../common.php';

    // use classes\common\Database;
    // use classes\common\Search;
    use classes\controllers\LoginController;
    // use classes\models\Entry;

    $username = null;

    if ( LoginController::checkLogin() ) {
        $username = LoginController::getLoginUser()->getDisplayName();
    }

    // // set search parameters
    // $order = array(
    //     'order' => 'last_updated',
    //     'direction' => 'DESC'
    // );
    // $limit = 10;
    // // retrieve latest entries using search parameters
    // Database::transaction();
    // $latest = Search::find('entry', null, $order, $limit);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>My Blog: Home</title>
        <link rel="stylesheet" type="text/css" href="forms/form.css">
    </head>
    <body>
        <h1><a href="<?php echo BLOG_TOP; ?>">My Blog</a></h1>
        <p>Welcome to My Blog<?php echo !is_null($username) ? ', ' . $username : ''; ?>! Check out the latest entries by users.</p>
        <!-- 最新エントリ10件を表示 -->
        <?php if ( LoginController::checkLogin() ) : ?>
            <p>Not <?php echo $username . "?" ?><br>Sign in to your account from <a href="login.php">here</a>.</p>
            <a href="new_post.php"><button type="button" name="btn_submit">New blog post</button></a>
            <a href="logout.php"><button type="button" name="btn_logout">Sign out</button></a>
        <?php else : ?>
            <p>Please login or register from here.</p>
            <a href="login.php"><button type="button" name="btn_login" autofocus="true">Sign in</button></a>
            <a href="registration.php"><button type="button" name="btn_register">Registration</button></a>
        <?php endif ?>
    </body>
</html>
