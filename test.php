<?php

    require_once 'common.php';

    use classes\common\Database;
    use classes\dao\UserDao;

    Database::transaction();
    $user = UserDao::findUser('joyotu.mazumder');

    var_dump($user->showPrimaryKey());

 ?>
