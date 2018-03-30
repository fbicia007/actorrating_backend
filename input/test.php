<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/15
 * Time: 下午9:39
 */


include_once "connect.php";

$movieId = $_GET['movieId'];
$movieTitle = $_POST["movieTitle"];
$movieDescription = $_POST["movieDescription"];
$posterVName = $_POST['posterVName'];
$posterHName = $_POST['posterHName'];
$status = $_POST["status"];
$type = $_POST["type"];
$director = $_POST["director"];


$roleIds = $_POST["roleId"];
var_dump($roleIds);
$roleNames = $_POST["roleName"];
$roleDescriptions = $_POST["roleDescription"];
$actorNumbers = $_POST["actorNumber"];




//$movieSql = 'INSERT INTO `movies` (`title`, `posterV`, `posterH`, `description`, `released`, `type`, `director`) VALUES ( ?, ?, ?, ?, ?, ?, ?);';
$movieSql = 'UPDATE `movies` SET `title` = ?, `posterV` = ?, `posterH` = ?, `description` = ?, `released` = ?, `type` = ?, `director` = ? WHERE `id` = ?';
$stmt = $pdo->prepare($movieSql);
$stmt->execute(array($movieTitle,$posterVName,$posterHName,$movieDescription,$status,$type,$director,$movieId));


$n = 0;

foreach ($roleNames as $roleName){
    $roleName;
    $roleDescription = $roleDescriptions[$n];
    $roleId = $roleIds[$n];
    $actorNumber = $actorNumbers[$n];

    if($roleId){
        #update old roles
        $rolesSql = 'UPDATE `roles` SET `name`=?, `description`=?, `actorNumber`=?) VALUES (?, ?, ?);';
        $stmt = $pdo->prepare($rolesSql);
        $stmt->execute(array($roleName,$roleDescription,$actorNumber));
    }else{
        #insert new roles
        $rolesSql = 'INSERT INTO `roles` (`movieId`, `name`, `description`, `actorNumber`) VALUES (?, ?, ?,?);';
        $stmt = $pdo->prepare($rolesSql);
        $stmt->execute(array($movieId,$roleName,$roleDescription,$actorNumber));
    }

    $n++;

}

//header("Location:actor_role.php?status=".$status."&movieId=".$movieId);
exit();




