<!-- last edited 2020年7月3日 金曜日 10:46 -->
<?php
    require_once '../common.php';

    // use classes\common\Database;
    // use classes\common\Search;
    use classes\controllers\LoginController;
    use classes\controllers\EntryController;
    // use classes\models\Entry;

    $username = null;

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
        <p>Welcome to My Blog<?php echo !is_null($username) ? ', ' . $username : ''; ?>! Check out the latest entries by users here.</p>

            <table border="1" align="center">
                <tr>
                    <caption>New entries</caption>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Last updated</th>
                </tr>
                    <?php foreach ($latest as $value) {
                        $author = $value['author'];
                        $id = $value['entry']->entry_id;
                        $title = $value['entry']->entry_title;
                        $date = substr($value['entry']->last_updated, 0, 10);
                        echo '<tr>';
                        echo '<td><a href="entry.php?entry_id=' . $id . '">' . $title . '</a></td>';
                        echo '<td>' . $author . '</td>';
                        echo '<td>' . $date . '</td>';
                        echo '</tr>';
                    } ?>
            </table>

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
