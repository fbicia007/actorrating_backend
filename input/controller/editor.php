<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/28
 * Time: 下午10:12
 */

include_once "../connect.php";

    if($_GET['actorId'])
    {
        $actorId = $_GET['actorId'];
        $actorName = $_POST["actorName"];
        $birthday = $_POST["birthday"];
        $constellation = $_POST["constellation"];
        $birthplace = $_POST["birthplace"];
        $profession = $_POST["profession"];
        $actorDescription = $_POST["actorDescription"];
        $photoName = $_POST['photoName'];

        $actorsSql = 'UPDATE `actors` SET `name` = ?, `photo` = ?, `description` = ?, `birthday` = ?, `constellation` = ?, `birthplace` = ?, `profession` = ? WHERE `id` = ?;';
        $stmt = $pdo->prepare($actorsSql);
        $stmt->execute(array($actorName,$photoName,$actorDescription,$birthday,$constellation,$birthplace,$profession,$actorId));

        header("Location:../alist.php");
        exit();

    }
    elseif ($_GET['movieId']&&$_GET['status'])
    {
        $status = $_GET['status'];
        $movieId = $_GET['movieId'];
        header("Location:../movieEditor.php?status=".$status."&movieId=".$movieId);
    }