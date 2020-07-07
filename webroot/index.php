<!-- last edited 2020年7月7日 火曜日 09:49 -->
<?php
    require_once '../common.php';

    use classes\controllers\LoginController;
    use classes\controllers\EntryController;

    // initialize variables and all session parameters other than login information
    $username = null;
    foreach ($_SESSION as $key => $value) {
        if ($key !== 'loginUserModel') {
            unset($_SESSION[$key]);
        }
    }

    if ( LoginController::checkLogin() ) {
        $username = LoginController::getLoginUser()->display_name;
    }

    $latest = EntryController::showLatest();

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
        <p>Welcome to My Blog<?php echo !is_null($username) ? ', ' . explode(' ', $username)[0] : ''; ?>! Check out the latest entries by users here.</p>

        <table border="1" align="center">
            <tr>
                <caption>New entries</caption>
                <th>Title</th>
                <th>Author</th>
                <th>Last updated</th>
            </tr>
                <?php foreach ($latest as $value) {
                    $entry_id = $value['entry']->entry_id;
                    $title = $value['entry']->entry_title;
                    $user_id = $value['author']->showPrimaryKey();
                    $author = $value['author']->display_name;
                    $date = substr($value['entry']->last_updated, 0, 10);
                    echo '<tr>';
                    echo '<td><a href="entry_view.php?entry_id=' . $entry_id . '">' . $title . '</a></td>';
                    echo '<td><a href="user.php?id=' . $user_id . '">' . $author . '</a></td>';
                    echo '<td>' . $date . '</td>';
                    echo '</tr>';
                } ?>
        </table><br>

        <div class="element_wrap">
            <?php if ( LoginController::checkLogin() ) : ?>
                <p>Not <?php echo explode(' ', $username)[0] . "?" ?><br>Sign in to your account from <a href="login.php">here</a>.</p><br>
                <a href="entry_new.php"><button type="button" name="btn_submit">New blog post</button></a>
                <a href="logout.php"><button type="button" name="btn_logout">Sign out</button></a>
            <?php else : ?>
                <p>Please login or register from here.</p>
                <a href="login.php"><button type="button" name="btn_login" autofocus="true">Sign in</button></a>
                <a href="registration.php"><button type="button" name="btn_register">Registration</button></a>
            <?php endif ?>
        </div>
    </body>
</html>
