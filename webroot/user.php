<!-- last edited 2020年7月3日 金曜日 10:49 -->
<?php
    require_once '../common.php';

    use classes\controllers\EntryController;
    use classes\controllers\LoginController;
    use classes\dao\UserDao;

    $user = UserDao::findUser( filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) );
    $user_id = $user->showPrimaryKey();
    $display_name = $user->display_name;
    $latest = EntryController::showLatest($user_id);
    $is_login_user = ( LoginController::checkLogin() && ($_SESSION['loginUserModel']->showPrimaryKey() == $user_id ) );
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title><?php echo $display_name; ?>'s page - My Blog</title>
        <link rel="stylesheet" type="text/css" href="forms/form.css">
    </head>
    <body>
        <h1><a href="<?php echo BLOG_TOP; ?>">My Blog</a>: <?php echo $display_name; ?></h1>
        <p><?php echo $is_login_user ? 'Welcome to your user page, ' . explode(' ', $display_name)[0] . '.' : ''; ?></p><br>
        <table border="1" align="center">
            <tr>
                <caption><?php echo $is_login_user ? 'Your ' : explode(' ', $display_name)[0] . '\'s '; ?>latest entries</caption>
                <th>Title</th>
                <th>Preview</th>
                <th>Last updated</th>
            </tr>
                <?php foreach ($latest as $value) {
                    $id = $value['entry']->entry_id;
                    $title = $value['entry']->entry_title;
                    $preview = substr($value['entry']->entry_content, 0, 20) . '...';
                    $date = substr($value['entry']->last_updated, 0, 10);
                    echo '<tr>';
                    echo '<td><a href="entry_view.php?entry_id=' . $id . '">' . $title . '</a></td>';
                    echo '<td>' . $preview . '</td>';
                    echo '<td>' . $date . '</td>';
                    echo '</tr>';
                } ?>
        </table><br>
        <div class="element_wrap">
            <?php if ( $is_login_user ) : ?>
                <a href="entry_new.php"><button type="button" name="btn_submit">New blog post</button></a>
                <a href="logout.php"><button type="button" name="btn_logout">Sign out</button></a>
            <?php endif ?>
        </div>
    </body>
</html>
