<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/4/5
 * Time: 下午9:13
 */

include_once 'connect.php';

$movieTitle = '测试电影';

$movieDescription = '电影简介';
                echo $director = '导演';


for($i=1;$i<101;$i++){
    $movieSql = 'INSERT INTO `movies` (`title`, `description`, `released`, `type`, `director`) VALUES ( ?, ?, ?, ?, ?);';
    $stmt = $pdo->prepare($movieSql);
    $stmt->execute(array($movieTitle.$i,$movieDescription.$i,0,'电影',$director.$i));
}