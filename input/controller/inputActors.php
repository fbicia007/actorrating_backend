<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/19
 * Time: 上午12:06
 */
    include_once "../connect.php";

        $actorName = $_POST["actorName"];

        if(!$_POST["birthday"]){
            $birthday = NULL;
        }
        else
        {
            $birthday = $_POST["birthday"];
        }

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
        if($_POST['url']){
            header("Location:../".$_POST['url']);
        }elseif ($_POST['ajaxInputActor']){
            echo $actorId;
        } else{
            echo 1;
            header("Location:../alist.php");
        }

        exit();
    }