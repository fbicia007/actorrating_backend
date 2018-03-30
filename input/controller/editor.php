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
        $actorNumbers = $_POST["actorNumbers"];


        $movieSql = 'UPDATE `movies` SET `title` = ?, `posterV` = ?, `posterH` = ?, `description` = ?, `released` = ?, `type` = ?, `director` = ? WHERE `id` = ?';
        $stmt = $pdo->prepare($movieSql);
        $stmt->execute(array($movieTitle,$posterVName,$posterHName,$movieDescription,$status,$type,$director,$movieId));


        $n = 0;

        foreach ($roleNames as $roleName){
            $roleName;
            $roleDescription = $roleDescriptions[$n];
            $roleId = $roleIds[$n];
            echo $actorNumber = $actorNumbers[$n];

            if($roleId){
                #update old roles
                $rolesSql = 'UPDATE `roles` SET `name`=?, `description`=?, `actorNumber`=? WHERE id =?;';
                $stmt = $pdo->prepare($rolesSql);
                $stmt->execute(array($roleName,$roleDescription,$actorNumber,$roleId));
            }else{
                #insert new roles
                $rolesSql = 'INSERT INTO `roles` (`movieId`, `name`, `description`, `actorNumber`) VALUES (?, ?, ?,?);';
                $stmt = $pdo->prepare($rolesSql);
                $stmt->execute(array($movieId,$roleName,$roleDescription,$actorNumber));
            }

            $n++;

        }

        header("Location:../actor_role.php?status=".$status."&movieId=".$movieId);
        exit();
    }