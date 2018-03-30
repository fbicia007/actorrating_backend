<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/18
 * Time: 下午3:12
 */

include_once "../connect.php";

$roles = $_POST["roles"];
$movieId = $_POST["movieId"];
$status = $_GET['status'];

$rolesSql = "SELECT * FROM `roles` WHERE `movieId`=?  ";
$stmt = $pdo->prepare($rolesSql);
$stmt->execute(array($movieId));
$resultRoles = $stmt->fetchAll();


if($status==1){

    $actors = $_POST["actors"];

    $n = 0;

    foreach ($resultRoles as $role){


        $actorId = $actors[$n];
        #是否已为此角色分配过演员
        $roleId =$role[id];
        $ifActorSql = "SELECT * FROM `likes` WHERE movieId = ? AND role = ?;";
        $stmt = $pdo->prepare($ifActorSql);
        $stmt->execute(array($movieId,$roleId));
        $resultIfActor = $stmt->fetchAll();
        if(empty($resultIfActor)){

            $inputLikeSql = "INSERT INTO `likes` (`movieId`, `actorId`, `like`, `role`) VALUES (?,?,?,?);";
            $stmt = $pdo->prepare($inputLikeSql);
            $do = $stmt->execute(array($movieId,$actorId,0,$roleId));

            if($do){
                header("HTTP/1.1 200 OK");
            }
            else{
                echo "Error";
            }

        }else{

            foreach ($resultIfActor as $ifActor){

                if($ifActor[actorId]==$actorId){

                    header("HTTP/1.1 200 OK");

                }else{

                    $inputLikeSql = "UPDATE `likes` SET `actorId`=?, `like`=? WHERE movieId = ? AND role = ?;";
                    $stmt = $pdo->prepare($inputLikeSql);
                    $do = $stmt->execute(array($actorId,0,$movieId,$roleId));

                    if($do){
                        header("HTTP/1.1 200 OK");
                    }
                    else{
                        echo "Error";
                    }

                }

            }

        }

        $n ++;
    }
}elseif ($status==0){

    foreach ($resultRoles as $role){

        $actors = $_POST["actors".$role[id]];

        foreach ($actors as $actor){
            $roleId = $role[id];
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
}


$pdo = null;

header("Location:../index.php");
exit();