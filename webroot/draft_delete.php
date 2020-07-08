<!-- last edited 2020年7月8日 水曜日 11:22 -->
<?php
    require_once '../common.php';

    use classes\controllers\EntryController;
    use classes\controllers\LoginController;

    // retrieve entry to view if not set
    if (!isset($_SESSION['targetDraft'])) {
        EntryController::viewDraft();
    }
    $login_user_id = LoginController::getLoginUser()->showPrimaryKey();

    // redirect to top page if not logged in or if entry doesn't belong to user currently logged in
    if ( !LoginController::checkLogin() || ( $login_user_id !== $_SESSION['targetDraft']->showAuthor()->showPrimaryKey() ) ) {
        header('Location: ' . BLOG_TOP);
    }

    // set text of title and body to display
    $title = ($_SESSION['targetDraft']->entry_title == '') ? '(empty title)' : $_SESSION['targetDraft']->entry_title;
    $body = ($_SESSION['targetDraft']->entry_content == '') ? '(empty body)' : $_SESSION['targetDraft']->entry_content;

    // Switch between registration, confirmation and completion pages using page flag.
    $page_flag = 0;
    if ( !empty($_POST['btn_confirm']) ) {
        // remove post
        EntryController::discardDraft();
        // move to completion page and unset input variables
        $page_flag = 1;
        unset($_POST);
        unset($_SESSION['targetDraft']);
    } elseif ( !empty($_POST['btn_back']) ) {
        // redirect to draft page
        header('Location: draft_view.php?draft_id=' . $_SESSION['targetDraft']->draft_id);
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="forms/form.css">
        <title>My Blog: Discard draft</title>
    </head>
    <body>
        <h1><a href="<?php echo BLOG_TOP; ?>">My Blog</a></h1>
        <?php if ($page_flag === 0): ?>
            <h2>Are you sure you want to discard the following draft?</h2>
            <div class="element_wrap">
                <label for="entry_title">Title</label>
                <p><?php echo $title; ?></p>
            </div>
            <div class="element_wrap">
                <label for="entry_content">Post</label>
                <p><?php echo $body; ?></p>
            </div>

            <form action="" method="post">
                <input type="submit" name="btn_back" value="Nope, keep this draft">
                <input type="submit" name="btn_confirm" value="Yep, discard this draft">
            </form>

        <?php elseif ($page_flag === 1): ?>
            <h2>Draft successfully discarded.<br>Return to top page or your user page.</h2>
            <a href="<?php echo BLOG_TOP; ?>"><button type="button" name="btn_top">My Blog Top</button></a>
            <a href="<?php echo 'user.php?id=' . $login_user_id; ?>"><button type="button" name="btn_top">Your user page</button></a>
        <?php endif ?>
    </body>
</html>
