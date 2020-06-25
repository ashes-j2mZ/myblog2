<!-- last edited 2020年6月22日 月曜日 12:01 -->
<?php
  require_once '../common.php';

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
    <p>Welcome to My Blog! Check out the latest entries by users.</p>
    <!-- 最新エントリ10件を表示 -->
    <p>Please login or register from here.</p>
    <a href="login.php"><button type="button" name="btn_login" autofocus="true">Log in</button></a>
    <a href="registration.php"><button type="button" name="btn_register" autofocus="true">Registration</button></a>
  </body>
</html>
