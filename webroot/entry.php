<!-- last edited 2020年7月3日 金曜日 16:58 -->
<?php
    require_once '../common.php';

    use classes\controllers\EntryController;
    use classes\controllers\LoginController;

    // retrieve entry to view
    // $entry = EntryController::viewEntry();
    $entry = EntryController::viewEntry();
    if ( is_null($entry) ) {
        // redirect to top page
        header('Location: ' . BLOG_TOP);
    } else {
        $author = $entry->showAuthor();
        $date = substr($entry->last_updated, 0, 10);
    }

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
            <h2><?php echo $entry->entry_title; ?></h2>
            <p><?php echo 'by ' . $author . ' on ' . $date; ?></p>
        </div>
        <div class="element_wrap">
            <p><?php echo nl2br($entry->entry_content); ?></p>
        </div>
        <?php if ( LoginController::checkLogin() && ($_SESSION['loginUserModel']->user_id == $entry->user_id) ) : ?>
            <p>Edit or remove your post from here.</p><br>
            <form action="edit_post.php" method="get">
                <div class="element_wrap">
                    <button type="submit" value="btn_edit">Edit post</button>
                    <input type="hidden" name="entry_id" value="<?php echo $entry->entry_id; ?>">
                </div>
            </form>
            <form action="delete_post.php" method="get">
                <div class="element_wrap">
                    <button type="submit" value="btn_delete">Remove post</button>
                    <input type="hidden" name="entry_id" value="<?php echo $entry->entry_id; ?>">
                </div>
            </form>
        <?php endif ?>
    </body>
</html>
