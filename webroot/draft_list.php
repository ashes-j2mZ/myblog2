<!-- last edited 2020年7月7日 火曜日 14:55 -->
<?php
    require_once '../common.php';

    use classes\controllers\EntryController;
    use classes\controllers\LoginController;

    // retrieve user ID from previous input
    $draft_user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    // redirect to top page if not logged in or if drafts don't belong to currently logged in user
    if ( !LoginController::checkLogin() || ( $draft_user_id !== $_SESSION['loginUserModel']->showPrimaryKey() ) ) {
        header('Location: ' . BLOG_TOP);
    }

    // initialize variables
    $new_drafts = null;
    $edit_drafts = null;
    $new_count = 0;
    $edit_count = 0;
    $user_drafts = EntryController::showDrafts($draft_user_id);
    if ( is_array($user_drafts) ) {
        $new_drafts = $user_drafts[0];
        $edit_drafts = $user_drafts[1];
        $new_count = ( count($new_drafts) <= 10 ) ? count($new_drafts) : 10;
        $edit_count = ( count($edit_drafts) <= 10 ) ? count($edit_drafts) : 10;
    }
    $username = explode(' ', $_SESSION['loginUserModel']->display_name)[0];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title><?php echo $username . '\'s drafts - My Blog'; ?></title>
        <link rel="stylesheet" type="text/css" href="forms/form.css">
    </head>
    <body>
        <h1><a href="<?php echo BLOG_TOP; ?>">My Blog</a></h1>
        <h2>Your drafts</h2>
        <br>
        <?php if ( is_string($user_drafts) ) : ?>
            <p><?php echo $user_drafts; ?></p>
        <?php else : ?>
            <!-- show tables containing drafts -->
            <table border="1" align="center">
                <tr>
                    <caption>New drafts</caption>
                    <th>Draft no.</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Last updated</th>
                </tr>
                <?php for ($i=0; $i < $new_count; $i++) {
                    $draft_id = $new_drafts[$i]->draft_id;
                    $title = is_null($new_drafts[$i]->entry_title) ? '(No title yet)' : $new_drafts[$i]->entry_title;
                    $content = is_null($new_drafts[$i]->entry_content) ? '(No body yet)' : mb_substr($new_drafts[$i]->entry_content, 0, 20) . '...';
                    $date = $new_drafts[$i]->last_updated->format('Y/m/d');
                    echo '<tr>';
                    echo '<td>' . ($i + 1) . '</td>';
                    echo '<td><a href="draft_view.php?draft_id=' . $draft_id . '">' . $title . '</a></td>';
                    echo '<td style="text-align: left">' . $content . '</td>';
                    echo '<td>' . $date . '</td>';
                    echo '</tr>';
                } ?>
            </table>
            <br>
            <table border="1" align="center">
                <tr>
                    <caption>Edit drafts</caption>
                    <th>Draft no.</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Last updated</th>
                </tr>
                <?php for ($i=0; $i < $edit_count; $i++) {
                    $draft_id = $edit_drafts[$i]->draft_id;
                    $title = is_null($edit_drafts[$i]->entry_title) ? '(No title yet)' : $edit_drafts[$i]->entry_title;
                    $content = is_null($edit_drafts[$i]->entry_content) ? '(No body yet)' : mb_substr($edit_drafts[$i]->entry_content, 0, 20) . '...';
                    $date = $edit_drafts[$i]->last_updated->format('Y/m/d');
                    echo '<tr>';
                    echo '<td>' . ($i + 1) . '</td>';
                    echo '<td><a href="draft_view.php?draft_id=' . $draft_id . '">' . $title . '</a></td>';
                    echo '<td style="text-align: left">' . $content . '</td>';
                    echo '<td>' . $date . '</td>';
                    echo '</tr>';
                } ?>
            </table>
        <?php endif ?>
        <br><br>
        <a href="user.php?id=<?php echo $_SESSION['loginUserModel']->showPrimaryKey(); ?>"><button type="button" name="btn_return" autofocus="true">Return to user page</button></a>
    </body>
</html>
