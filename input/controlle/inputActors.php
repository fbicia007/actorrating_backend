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
$photo = $_FILES['photo'];
#用时间戳重命名文件

$today = date("Ymdhis");

#文件后缀名
$v = end(explode(".", $photo["name"]));

$uploadPhoto = imgUpload($photo,'actorPic',$today);

if($uploadPhoto==1){

    $actorsSql = 'INSERT INTO `actors` (`name`, `photo`, `description`, `birthday`, `constellation`, `birthplace`, `profession`) VALUES ( ?, ?, ?, ?, ?, ?, ?);';
    $stmt = $pdo->prepare($actorsSql);
    $stmt->execute(array($actorName,$today.".".$v,$actorDescription,$birthday,$constellation,$birthplace,$profession));
#last movie Id
    $actorId = $pdo->lastInsertId();


    if(isset($_GET['forRole'])){
        return $actorId;
    }else{
        header("Location:../admin.php");
        exit();
    }


}else{
    echo "upload Error!";
}
