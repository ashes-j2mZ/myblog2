<!-- last edited 2020年7月8日 水曜日 11:22 -->
<?php
    require_once '../common.php';

    use classes\controllers\EntryController;
    use classes\controllers\LoginController;

    // retrieve draft to view and its assocated
    if (!isset($_SESSION['targetDraft'])) {
        EntryController::viewDraft();
    }
    $author = $_SESSION['targetDraft']->showAuthor();
    // redirect to top page if not logged in or if drafts don't belong to currently logged in user
    if ( !LoginController::checkLogin() || ( $author->login_id !== $_SESSION['loginUserModel']->login_id) ) {
        header('Location: ' . BLOG_TOP);
    }
    $title = is_null($_SESSION['targetDraft']->entry_title) ? '(untitled draft)' : $_SESSION['targetDraft']->entry_title;
    $body = is_null($_SESSION['targetDraft']->entry_content) ? '(empty body)' : $_SESSION['targetDraft']->entry_content;
    $date = $_SESSION['targetDraft']->last_updated->format('F jS, Y');

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
        <?php if ($_SESSION['targetDraft']->entry_id === null) : ?>
            <?php echo '<form action="entry_new.php" method="post">'; ?>
        <?php else : ?>
            <?php echo '<form action="entry_edit.php" method="post">'; ?>
        <?php endif ?>
            <div class="element_wrap">
                <button type="submit" value="btn_edit">Edit draft</button>
                <input type="hidden" name="draft_id" value="<?php echo $_SESSION['targetDraft']->draft_id; ?>">
                <input type="hidden" name="entry_id" value="<?php echo $_SESSION['targetDraft']->entry_id; ?>">
            </div>
        </form>
        <form action="draft_delete.php" method="post">
            <div class="element_wrap">
                <button type="submit" value="btn_delete">Discard draft</button>
                <input type="hidden" name="entry_id" value="<?php echo $_SESSION['targetDraft']->draft_id; ?>">
            </div>
        </form>
    </body>
</html>
