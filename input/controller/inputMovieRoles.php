<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/15
 * Time: 下午9:39
 */


include_once "../connect.php";

$movieTitle = $_POST["movieTitle"];
$movieDescription = $_POST["movieDescription"];
$posterVName = $_POST['posterVName'];
$posterHName = $_POST['posterHName'];
$actors = $_POST["actors"];
$status = $_POST["status"];
$type = $_POST["type"];
$director = $_POST["director"];
$roleNames = $_POST["roleName"];
$roleDescriptions = $_POST["roleDescription"];




$movieSql = 'INSERT INTO `movies` (`title`, `posterV`, `posterH`, `description`, `released`, `type`, `director`) VALUES ( ?, ?, ?, ?, ?, ?, ?);';
$stmt = $pdo->prepare($movieSql);
$stmt->execute(array($movieTitle,$posterVName,$posterHName,$movieDescription,$status,$type,$director));
#last movies Id
$movieId = $pdo->lastInsertId();

$n = 0;

foreach ($roleNames as $roleName){
    $roleName;
    $roleDescription = $roleDescriptions[$n];


    if($status==1){

        $actorId = $actors[$n];


        $rolesSql = 'INSERT INTO `roles` (`movieId`, `name`, `description`, `actorNumber`) VALUES (?, ?, ?,?);';
        $stmt = $pdo->prepare($rolesSql);
        $stmt->execute(array($movieId,$roleName,$roleDescription,1));
        $roleId = $pdo->lastInsertId();

        $inputLikeSql = "INSERT INTO `likes` (`movieId`, `actorId`, `like`, `role`) VALUES (?,?,?,?);";
        $stmt = $pdo->prepare($inputLikeSql);
        $do = $stmt->execute(array($movieId,$actorId,0,$roleId));

    }elseif ($status==0){

        $roleNumber = $n+1;
        $actors = $_POST["actors".$roleNumber];
        $actorNumber = count($actors);

        $rolesSql = 'INSERT INTO `roles` (`movieId`, `name`, `description`, `actorNumber`) VALUES (?, ?, ?,?);';
        $stmt = $pdo->prepare($rolesSql);
        $stmt->execute(array($movieId,$roleName,$roleDescription,$actorNumber));
        $roleId = $pdo->lastInsertId();

        foreach ($actors as $actor){

            $actorId = $actor;

            $inputVotesSql = "INSERT INTO `roleVotes` (`actorId`, `vote`, `roleId`) VALUES (?,?,?);";
            $stmt = $pdo->prepare($inputVotesSql);

            if($stmt->execute(array($actorId,0,$roleId))){
                header("HTTP/1.1 200 OK");
            }
            else{
                echo "Error";
            }
        }

    }



    $n++;
}


header("Location:../index.php");
exit();





