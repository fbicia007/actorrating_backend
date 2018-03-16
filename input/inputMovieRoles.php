<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/15
 * Time: 下午9:39
 */


include_once "connect.php";

$movieTitle = $_POST["movieTitle"];
$posterV = $_POST["posterV"];
$posterH = $_POST["posterH"];
$movieDescription = $_POST["movieDescription"];
$status = $_POST["status"];
$type = $_POST["type"];
$director = $_POST["director"];
$roleNames = $_POST["roleName"];
$roleDescriptions = $_POST["roleDescription"];


$actorsSql = 'INSERT INTO `movies` (`title`, `posterV`, `posterH`, `description`, `released`, `type`, `director`) VALUES ( ?, ?, ?, ?, ?, ?, ?);';
$stmt = $pdo->prepare($actorsSql);
$stmt->execute(array($movieTitle,$posterV,$posterH,$movieDescription,$status,$type,$director));
#last movie Id
$movieId = $pdo->lastInsertId();

$n = 0;

foreach ($roleNames as $roleName){
    $roleName;
    $roleDescription = $roleDescriptions[$n];


    $rolesSql = 'INSERT INTO `roles` (`movieId`, `name`, `description`) VALUES (?, ?, ?);';
    $stmt = $pdo->prepare($rolesSql);
    $stmt->execute(array($movieId,$roleName,$roleDescription));


    $n++;
}

