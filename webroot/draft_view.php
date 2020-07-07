<!-- last edited 2020年7月7日 火曜日 09:56 -->
<?php
    require_once '../common.php';

    use classes\controllers\EntryController;
    use classes\controllers\LoginController;

    // retrieve draft to view and its assocated
    $_SESSION['targetDraft'] = EntryController::viewDraft();

    if ( is_null($_SESSION['targetDraft']) ) {
        // redirect to top page
        header('Location: ' . BLOG_TOP);
    } else {
        $author = $_SESSION['targetDraft']->showAuthor();
        // redirect to top page if not logged in or if drafts don't belong to currently logged in user
        if ( !LoginController::checkLogin() || ( $author->login_id !== $_SESSION['loginUserModel']->login_id) ) {
            header('Location: ' . BLOG_TOP);
        }
        $title = is_null($_SESSION['targetDraft']->entry_title) ? '(untitled draft)' : $_SESSION['targetDraft']->entry_title;
        $body = is_null($_SESSION['targetDraft']->entry_content) ? '(empty body)' : $_SESSION['targetDraft']->entry_content;
        $date = substr($_SESSION['targetDraft']->last_updated, 0, 10);
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title><?php echo explode(' ', $author->display_name)[0] . '\'s draft - My Blog'; ?></title>
        <link rel="stylesheet" type="text/css" href="forms/form.css">
    </head>
    <body>
        <h1><a href="<?php echo BLOG_TOP; ?>">My Blog</a></h1>
        <div class="element_wrap">
            <h2><?php echo $title; ?></h2>
            <p><?php echo 'Last updated on ' . $date; ?></p>
        </div>
        <div class="element_wrap">
            <p><?php echo nl2br($body); ?></p>
        </div>
        <p>Edit or discard your draft from here.</p><br>
        <?php if ($_SESSION['targetDraft']->entry_id == null) : ?>
        <form action="entry_edit.php" method="get">
        <?php endif ?>
            <div class="element_wrap">
                <button type="submit" value="btn_edit">Edit post</button>
                <input type="hidden" name="entry_id" value="<?php echo $entry->entry_id; ?>">
            </div>
        </form>
        <form action="entry_delete.php" method="get">
            <div class="element_wrap">
                <button type="submit" value="btn_delete">Remove post</button>
                <input type="hidden" name="entry_id" value="<?php echo $entry->entry_id; ?>">
            </div>
            </form>
    </body>
</html>
