<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/20
 * Time: 下午10:08
 */

include_once '../connect.php';

if($_POST['movieId']){
#delete movie
    $movieId = $_POST['movieId'];
    $page = $_POST['pageDel'];

    $delMovie = "DELETE FROM `movies` WHERE `id` = ?;";
    $stmt = $pdo->prepare($delMovie);
    $stmt->execute(array($movieId));

    $delLikes = "DELETE FROM `likes` WHERE `movieId` = ?;";
    $stmt = $pdo->prepare($delLikes);
    $stmt->execute(array($movieId));

    $delRoles = "DELETE FROM `roles` WHERE `movieId` = ?;";
    $stmt = $pdo->prepare($delRoles);
    $stmt->execute(array($movieId));

    $userLikes = "DELETE FROM `userLike` WHERE `movieId` = ?;";
    $stmt = $pdo->prepare($userLikes);
    $stmt->execute(array($movieId));
    header("Location:../index.php?page=".$page);
    exit();

}elseif ($_POST['actorId']&&!$_POST['openId']){
#delete actor
    $actorId = $_POST['actorId'];
    $page = $_POST['pageDel'];

    $delActor = "DELETE FROM `actors` WHERE `id` = ?;";
    $stmt = $pdo->prepare($delActor);
    $stmt->execute(array($actorId));
    header("Location:../alist.php?page=".$page);

    exit();

}elseif ($_POST['actorId']&&$_POST['openId']){
#delete comment
    $actorId = $_POST['actorId'];
    $openId = $_POST['openId'];
    $page = $_POST['pageDel'];

    $delActor = "DELETE FROM `actorVote` WHERE `openId` = ? AND `actorId` = ?;";
    $stmt = $pdo->prepare($delActor);
    $stmt->execute(array($openId,$actorId));
    header("Location:../comment.php?page=".$page);
    exit();
}elseif ($_GET['delRole']){
    #delete roles
    $roleId = $_GET['delRole'];

    $delRoles = "DELETE FROM `roles` WHERE `id` = ?;";
    $stmt = $pdo->prepare($delRoles);
    $stmt->execute(array($roleId));

    $delRoles = "DELETE FROM `userVote` WHERE `roleId` = ?;";
    $stmt = $pdo->prepare($delRoles);
    $stmt->execute(array($roleId));

    $delRoles = "DELETE FROM `roleVotes` WHERE `roleId` = ?;";
    $stmt = $pdo->prepare($delRoles);
    $stmt->execute(array($roleId));

    $delRoles = "DELETE FROM `likes` WHERE `role` = ?;";
    $stmt = $pdo->prepare($delRoles);
    $stmt->execute(array($roleId));

    echo "已从该影片中删除此角色！";

}elseif ($_GET['movieId']&&$_GET['status']){
    #change status delet likes Or rolevotes

    $status = $_GET['status'];
    if($status=='未上映'){
        $status=0;
    }
    $movieId = $_GET['movieId'];

    $movieSql = 'UPDATE `movies` SET  `released` = ? WHERE `id` = ?';
    $stmt = $pdo->prepare($movieSql);
    $stmt->execute(array($status,$movieId));

    $roleId = $_GET['changeStatus'];
    $roleIds =json_decode($roleId);


    foreach ($roleIds as $roleId)
    {
        $delRoles = "DELETE FROM `roles` WHERE `id` = ?;";
        $stmt = $pdo->prepare($delRoles);
        $stmt->execute(array($roleId));

        $delRoles = "DELETE FROM `userVote` WHERE `roleId` = ?;";
        $stmt = $pdo->prepare($delRoles);
        $stmt->execute(array($roleId));

        $delRoles = "DELETE FROM `roleVotes` WHERE `roleId` = ?;";
        $stmt = $pdo->prepare($delRoles);
        $stmt->execute(array($roleId));

        $delRoles = "DELETE FROM `likes` WHERE `role` = ?;";
        $stmt = $pdo->prepare($delRoles);
        $stmt->execute(array($roleId));
    }

    echo "已清空角色的扮演者！";

}