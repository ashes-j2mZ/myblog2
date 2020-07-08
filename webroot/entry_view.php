<!-- last edited 2020年7月8日 水曜日 11:22 -->
<?php
    require_once '../common.php';

    use classes\controllers\EntryController;
    use classes\controllers\LoginController;

    // retrieve entry to view if not set
    if (!isset($_SESSION['targetEntry'])) {
        EntryController::viewEntry();
    }
    $author = $_SESSION['targetEntry']->showAuthor();
    $date = $_SESSION['targetEntry']->last_updated->format('F jS, Y');
    $is_author = ( LoginController::checkLogin() && ($_SESSION['loginUserModel']->login_id == $author->login_id ) );

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title><?php echo $entry->entry_title . ' - My Blog'; ?></title>
        <link rel="stylesheet" type="text/css" href="forms/form.css">
    </head>
    <body>
        <h1><a href="<?php echo BLOG_TOP; ?>">My Blog</a></h1>
        <div class="element_wrap">
            <h2><?php echo $_SESSION['targetEntry']->entry_title; ?></h2>
            <p><?php echo 'by ' . $author->display_name . ' on ' . $date; ?></p>
        </div>
        <div class="element_wrap">
            <p><?php echo nl2br($_SESSION['targetEntry']->entry_content); ?></p>
        </div>
        <?php if ($is_author) : ?>
            <p>Edit or remove your post from here.</p><br>
            <form action="entry_edit.php" method="post">
                <div class="element_wrap">
                    <button type="submit" value="btn_edit">Edit post</button>
                    <input type="hidden" name="entry_id" value="<?php echo $_SESSION['targetEntry']->entry_id; ?>">
                </div>
            </form>
            <form action="entry_delete.php" method="post">
                <div class="element_wrap">
                    <button type="submit" value="btn_delete">Remove post</button>
                    <input type="hidden" name="entry_id" value="<?php echo $_SESSION['targetEntry']->entry_id; ?>">
                </div>
            </form>
        <?php endif ?>
    </body>
</html>
