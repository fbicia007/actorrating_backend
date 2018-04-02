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
elseif ($_GET['movieId'])
{
    $movieId = $_GET['movieId'];
    $movieTitle = $_POST["movieTitle"];
    $movieDescription = $_POST["movieDescription"];
    $posterVName = $_POST['posterVName'];
    $posterHName = $_POST['posterHName'];
    $status = $_POST["status"];
    $type = $_POST["type"];
    $director = $_POST["director"];


    $roleIds = $_POST["roleId"];
    $roleNames = $_POST["roleName"];
    $roleDescriptions = $_POST["roleDescription"];
    $actors = $_POST["actors"];


    $movieSql = 'UPDATE `movies` SET `title` = ?, `posterV` = ?, `posterH` = ?, `description` = ?, `released` = ?, `type` = ?, `director` = ? WHERE `id` = ?';
    $stmt = $pdo->prepare($movieSql);
    $stmt->execute(array($movieTitle,$posterVName,$posterHName,$movieDescription,$status,$type,$director,$movieId));


    $n = 0;


    foreach ($roleNames as $roleName){
        $roleName;
        $roleDescription = $roleDescriptions[$n];
        $roleId = $roleIds[$n];
        $actorId = $actors[$n];

        if($status==1){


            if($roleId){
                #update old roles
                $rolesSql = 'UPDATE `roles` SET `name`=?, `description`=?, `actorNumber`=? WHERE id =?;';
                $stmt = $pdo->prepare($rolesSql);
                $stmt->execute(array($roleName,$roleDescription,1,$roleId));

                $updateLikeSql = 'UPDATE `likes` SET `actorId`=? WHERE movieId =? AND role =?;';
                $stmt = $pdo->prepare($updateLikeSql);
                $stmt->execute(array($actorId,$movieId,$roleId));


            }else{

                #insert new roles
                $rolesSql = 'INSERT INTO `roles` (`movieId`, `name`, `description`, `actorNumber`) VALUES (?, ?, ?,?);';
                $stmt = $pdo->prepare($rolesSql);
                $stmt->execute(array($movieId,$roleName,$roleDescription,1));
                $roleId = $pdo->lastInsertId();

                $inputLikeSql = "INSERT INTO `likes` (`movieId`, `actorId`, `like`, `role`) VALUES (?,?,?,?);";
                $stmt = $pdo->prepare($inputLikeSql);

                $stmt->execute(array($movieId,$actorId,0,$roleId));
            }

        }elseif ($status==0){
#未上映
            $roleNumber = $n+1;

            if($_POST["actors".$roleNumber]){
                $actors = $_POST["actors".$roleNumber];
            }else{
                #如果没有分配演员给角色，则清空
                $delRoles = "DELETE FROM `roleVotes` WHERE `roleId` = ?;";
                $stmt = $pdo->prepare($delRoles);
                $stmt->execute(array($roleId));
            }

            $actorNumber = count($actors);

            if($roleId){

                #update old roles
                $rolesSql = 'UPDATE `roles` SET `name`=?, `description`=?, `actorNumber`=? WHERE id =?;';
                $stmt = $pdo->prepare($rolesSql);
                $stmt->execute(array($roleName,$roleDescription,$actorNumber,$roleId));


                foreach ($actors as $actor){

                    #判断是否是分配的演员
                    $actorRolesql ='SELECT * FROM `roleVotes` WHERE roleId =? AND actorId =?';
                    $stmt = $pdo->prepare($actorRolesql);
                    $stmt->execute(array($roleId,$actor));
                    $resultActorRole = $stmt->fetchAll();

                    if(!$resultActorRole){

                        $inputVotesSql = "INSERT INTO `roleVotes` (`actorId`, `vote`, `roleId`) VALUES (?,?,?);";
                        $stmt = $pdo->prepare($inputVotesSql);
                        $stmt->execute(array($actor,0,$roleId));

                    }else{

                        $actorRolesql ='SELECT * FROM `roleVotes` WHERE roleId =?';
                        $stmt = $pdo->prepare($actorRolesql);
                        $stmt->execute(array($roleId));
                        $resultActorRole = $stmt->fetchAll();

                        $inputActorsArray = $actors;
                        foreach ($resultActorRole as $actorNotAnyMore){

                            if(!in_array($actorNotAnyMore[actorId], $inputActorsArray)){
                                #删除修改掉的已分配演员
                                $delActorId=$actorNotAnyMore[actorId];
                                $delRoles = "DELETE FROM `roleVotes` WHERE `roleId` = ? AND actorId =?;";
                                $stmt = $pdo->prepare($delRoles);
                                $stmt->execute(array($roleId,$delActorId));
                            }
                        }
                    }

                }


            }else{

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


        }



        $n++;
    }

    header("Location:../index.php");
    exit();
}