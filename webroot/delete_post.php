<!-- last edited 2020年7月3日 金曜日 16:58 -->
<?php
    require_once '../common.php';

    use classes\controllers\EntryController;
    use classes\controllers\LoginController;

    $_SESSION['targetEntry'] = EntryController::viewEntry();

    // redirect to top page if not logged in or if entry doesn't belong to user currently logged in
    if ( !LoginController::checkLogin() || (LoginController::getLoginUser()->user_id !== $_SESSION['targetEntry']->user_id) ) {
        header('Location: ' . BLOG_TOP);
    }

    // Switch between registration, confirmation and completion pages using page flag.
    $page_flag = 0;
    if ( !empty($_POST['btn_confirm']) ) {
        // remove post
        EntryController::removeEntry();
        // move to completion page and unset input variables
        $page_flag = 1;
        unset($_POST);
        unset($_SESSION['targetEntry']);
    } elseif ( !empty($_POST['btn_back']) ) {
        // redirect to entry page and unset session
        header('Location: ' . BLOG_ENTRY . $_SESSION['targetEntry']->entry_id);
        unset($_SESSION['targetEntry']);
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="forms/form.css">
        <title>My Blog: Remove entry</title>
    </head>
    <body>
        <h1><a href="<?php echo BLOG_TOP; ?>">My Blog</a></h1>
        <?php if ($page_flag === 0): ?>
            <h2>Are you sure you want to remove the followng entry from My Blog?</h2>
            <div class="element_wrap">
                <label for="entry_title">Title</label>
                <p><?php echo $_SESSION['targetEntry']->entry_title; ?></p>
            </div>
            <div class="element_wrap">
                <label for="entry_content">Post</label>
                <p><?php echo $_SESSION['targetEntry']->entry_content; ?></p>
            </div>

            <form action="" method="post">
                <input type="submit" name="btn_back" value="Nope, keep entry">
                <input type="submit" name="btn_confirm" value="Yep, remove entry">
            </form>

        <?php elseif ($page_flag === 1): ?>
            <h2>Entry successfully removed.<br>Return to top page or your user page.</h2>
            <a href="<?php echo BLOG_TOP; ?>"><button type="button" name="btn_top">My Blog Top</button></a>
            <a href="<?php echo 'user.php?user_id=' . LoginController::getLoginUser()->user_id; ?>"><button type="button" name="btn_top">Your user page</button></a>
        <?php endif ?>
    </body>
</html>