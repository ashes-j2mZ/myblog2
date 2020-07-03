<!-- last edited 2020年7月3日 金曜日 16:58 -->
<?php
    require_once '../common.php';

    use classes\common\Utility;
    use classes\controllers\EntryController;
    use classes\controllers\LoginController;

    // redirect to top page if not logged in
    if ( !LoginController::checkLogin() ) {
        header('Location: ' . BLOG_TOP);
    }

    // initialize variables
    $sanitized = array();
    $input_errors = array();
    $page_flag = 0;

    // sanitize input
    if (!empty($_POST)) {
        $sanitized = Utility::sanitize($_POST);
    }

    // Switch between registration, confirmation and completion pages using page flag.
    if (!empty($_POST['btn_confirm'])) {
        // Validate input before moving to confimation page.
        // Display errors if input inappropriate.
        $input_errors = EntryController::validate($sanitized);
        if ( empty($input_errors) ) { // move to confirmation page
            $page_flag = 1;
            $_SESSION['page'] = true;
        }
    } elseif (!empty($_POST['btn_submit'])) { // move to completion page
        if ( !empty($_SESSION['page']) && $_SESSION['page'] === true ) {
            // add information to database
            EntryController::postEntry($sanitized);
            // move to completion page and unset input variables
            $page_flag = 2;
            unset($_POST);
            unset($sanitized);
            unset($input_errors);
        }
    } else {
        $page_flag = 0;
    }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="forms/form.css">
        <title>My Blog: New blog entry</title>
    </head>
    <body>
        <h1><a href="<?php echo BLOG_TOP; ?>">My Blog</a></h1>
        <?php if ($page_flag === 1): ?>
            <h2>Post the following as a new blog entry. Continue?</h2>
            <div class="element_wrap">
                <label for="entry_title">Title</label>
                <p><?php echo $sanitized['entry_title']; ?></p>
            </div>
            <div class="element_wrap">
                <label for="entry_content">Post</label>
                <p><?php echo $sanitized['entry_content']; ?></p>
            </div>

            <form action="" method="post">
                <input type="submit" name="btn_back" value="Return to edit entry">
                <input type="submit" name="btn_submit" value="Post entry to My Blog">
                <!-- 受け渡し用 -->
                <input type="hidden" name="entry_title" value="<?php echo $sanitized['entry_title']; ?>">
                <input type="hidden" name="entry_content" value="<?php echo $sanitized['entry_content']; ?>">
            </form>

        <?php elseif ($page_flag === 2): ?>
            <h2>Entry successfully posted to My Blog.<br>Return to top page.</h2>
            <a href="<?php echo BLOG_TOP; ?>"><button type="button" name="btn_top">My Blog Top</button></a>

        <?php else: ?>
            <!-- Display input errors as list -->
            <?php if (!empty($input_errors)) : ?>
                <ul class="error_list">
                    <?php foreach ($input_errors as $value) : ?>
                        <li><?php echo $value; ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>

            <h2>Write your blog entry here.</h2>
            <form action="" method="post">
                <div class="element_wrap">
                    <label for="entry_title">Title</label>
                    <input type="text" name="entry_title" maxlength="50" placeholder="Enter a title for your new blog post..." value="<?php echo !empty($sanitized['entry_title']) ?  $sanitized['entry_title'] : ''; ?>">
                </div>
                <div class="element_wrap">
                    <label for="entry_content">Post</label>
                    <textarea name="entry_content" rows="10" cols="100" maxlength="5000" placeholder="Write your blog post here..."><?php echo !empty($sanitized['entry_content']) ?  $sanitized['entry_content'] : ''; ?></textarea>
                </div>
                <input type="submit" name="btn_confirm" value="Check post">
            </form>
        <?php endif ?>
    </body>
</html>
