<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/20
 * Time: 下午10:08
 */

include_once '../connect.php';

if($_POST['movieId']){

    $movieId = $_POST['movieId'];

    $delMovie = "DELETE FROM `movies` WHERE `id` = ?;";
    $stmt = $pdo->prepare($delMovie);
    $stmt->execute(array($movieId));
    header("Location:../index.php");
    exit();

}elseif ($_POST['actorId']){

    $actorId = $_POST['actorId'];

    $delActor = "DELETE FROM `actors` WHERE `id` = ?;";
    $stmt = $pdo->prepare($delActor);
    $stmt->execute(array($actorId));
    header("Location:../alist.php");
    exit();
}