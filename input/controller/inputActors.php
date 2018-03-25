<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/19
 * Time: 上午12:06
 */
    include_once "../connect.php";
    include_once "imageUpload.php";

    $actorName = $_POST["actorName"];
    $birthday = $_POST["birthday"];
    $constellation = $_POST["constellation"];
    $birthplace = $_POST["birthplace"];
    $profession = $_POST["profession"];
    $actorDescription = $_POST["actorDescription"];
    $photoName = $_POST['photoName'];


    $actorsSql = 'INSERT INTO `actors` (`name`, `photo`, `description`, `birthday`, `constellation`, `birthplace`, `profession`) VALUES ( ?, ?, ?, ?, ?, ?, ?);';
    $stmt = $pdo->prepare($actorsSql);
    $stmt->execute(array($actorName,$photoName,$actorDescription,$birthday,$constellation,$birthplace,$profession));
#last movies Id
    $actorId = $pdo->lastInsertId();


    if(isset($_GET['forRole'])){
        return $actorId;
    }else{
        header("Location:../admin.php");
        exit();
    }

