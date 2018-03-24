<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/12
 * Time: 下午5:01
 */

//include_once "connect.php";
include_once "pdo_connect.php";

$host = "https://xuwang.de";

if(isset($_GET["openId"])&&isset($_GET["rating"])&&isset($_GET["comment"])&&isset($_GET["actorId"])){

    $openId = $_GET['openId'];
    $actorId = $_GET['actorId'];
    $rating = $_GET['rating'];
    $comment = $_GET['comment'];

    #search is this user hat this actors voted
    $searchSql = "SELECT COUNT(*) AS 'old' FROM `actorVote` WHERE `openId`=? AND `actorId`=? ";
    $stmt = $pdo->prepare($searchSql);
    $stmt->execute(array($openId,$actorId));
    $result = $stmt->fetchAll();

    if($result[0]['old']==1){

        #voted, now only update
        $updateVoteSql ="UPDATE `actorVote` SET `comment` = ?, `vote` = ? WHERE `openId` = ? AND `actorId` = ?;";
        $stmt = $pdo->prepare($updateVoteSql);
        $stmt->execute(array($comment,$rating,$openId,$actorId));

    }else{

        #new, insert the vote and comment
        $inputVoteSql = "INSERT INTO `actorVote` (`openId`, `comment`, `actorId`, `vote`) VALUES (?,?,?,?);";
        $stmt = $pdo->prepare($inputVoteSql);

        if($stmt->execute(array($openId,$comment,$actorId,$rating))){
            header("HTTP/1.1 200 OK");
        }
        else{
            echo "Error";
        }
    }

}
elseif(isset($_GET["openId"])&&isset($_GET["actorId"])&&!isset($_GET["rating"])&&!isset($_GET["comment"])){

    $openId = $_GET['openId'];
    $actorId = $_GET['actorId'];

    #search is this user hat this actors voted
    $searchSql = "SELECT COUNT(*) AS 'old' FROM `actorVote` WHERE `openId`=? AND `actorId`=? ";
    $stmt = $pdo->prepare($searchSql);
    $stmt->execute(array($openId,$actorId));
    $result = $stmt->fetchAll();

    if($result[0]['old']==1){

        #find the comment and ratiing
        $updateVoteSql ="SELECT * FROM `actorVote` WHERE `openId` = ? AND `actorId` = ?;";
        $stmt = $pdo->prepare($updateVoteSql);
        $stmt->execute(array($openId,$actorId));
        $commentAndRating = $stmt->fetchAll();


        $like[] = (object)[
            'comment'=>$commentAndRating[0]['comment'],
            'rating'=> $commentAndRating[0]['vote']
        ];

        echo json_encode($like);

    }else{

        #no comment yet
        $like[] = (object)[
            'comment'=>'',
            'rating'=> ''
        ];
        echo json_encode($like);
    }

}
else
{
    echo "not parameters";
}


$pdo = null;