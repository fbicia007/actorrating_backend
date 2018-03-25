<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/15
 * Time: 下午9:39
 */


    include_once "../connect.php";
    include_once "imageUpload.php";

    $movieTitle = $_POST["movieTitle"];
    $movieDescription = $_POST["movieDescription"];
    echo $posterVName = $_POST['posterVName'];
    echo $posterHName = $_POST['posterHName'];
    $status = $_POST["status"];
    $type = $_POST["type"];
    $director = $_POST["director"];
    $roleNames = $_POST["roleName"];
    $roleDescriptions = $_POST["roleDescription"];
    $actorNumbers = $_POST["actorNumber"];



    $movieSql = 'INSERT INTO `movies` (`title`, `posterV`, `posterH`, `description`, `released`, `type`, `director`) VALUES ( ?, ?, ?, ?, ?, ?, ?);';
    $stmt = $pdo->prepare($movieSql);
    $stmt->execute(array($movieTitle,$posterVName,$posterHName,$movieDescription,$status,$type,$director));
#last movies Id
    $movieId = $pdo->lastInsertId();

    $n = 0;

    foreach ($roleNames as $roleName){
        $roleName;
        $roleDescription = $roleDescriptions[$n];
        $actorNumber = $actorNumbers[$n];


        $rolesSql = 'INSERT INTO `roles` (`movieId`, `name`, `description`, `actorNumber`) VALUES (?, ?, ?,?);';
        $stmt = $pdo->prepare($rolesSql);
        $stmt->execute(array($movieId,$roleName,$roleDescription,$actorNumber));

        $n++;
    }

    header("Location:../actor_role.php?status=".$status."&movieId=".$movieId);
    exit();





