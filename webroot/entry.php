<!-- last edited 2020年7月3日 金曜日 10:46 -->
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
            <div class="element_wrap">
                <p>Edit or remove your post from here.</p>
            </div>
        <?php endif ?>
    </body>
</html>
