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
$posterH = $_FILES['posterH'];
$posterV = $_FILES['posterV'];
$status = $_POST["status"];
$type = $_POST["type"];
$director = $_POST["director"];
$roleNames = $_POST["roleName"];
$roleDescriptions = $_POST["roleDescription"];
$actorNumbers = $_POST["actorNumber"];
$today = date("Ymdhis");

#用时间戳重命名文件
$posterVName= 'v'.$today;
$posterHName= 'h'.$today;

#文件后缀名
$v = end(explode(".", $posterV["name"]));
$h = end(explode(".", $posterH["name"]));

$uploadPV = imgUpload($posterV,'posterV',$posterVName);
$uploadPH = imgUpload($posterH,'posterH',$posterHName);

if($uploadPH==1 && $uploadPV==1){

    $movieSql = 'INSERT INTO `movies` (`title`, `posterV`, `posterH`, `description`, `released`, `type`, `director`) VALUES ( ?, ?, ?, ?, ?, ?, ?);';
    $stmt = $pdo->prepare($movieSql);
    $stmt->execute(array($movieTitle,$posterVName.".".$v,$posterHName.".".$h,$movieDescription,$status,$type,$director));
#last movie Id
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


}else{
    echo "upload Error!";
}




