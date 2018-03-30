<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/2/9
 * Time: 下午8:36
 */
include_once "connect.php";
$host = 'https://'.$_SERVER['HTTP_HOST'];

if(isset($_GET['actorId'])&&isset($_GET['openId'])&&isset($_GET['movieId'])){

    $openId = $_GET['openId'];
    $movieId = $_GET['movieId'];
    $actorId = $_GET['actorId'];

    $sql = "SELECT * FROM userLike WHERE userId = '".$openId."' AND `movieId`='".$movieId."' AND `actorId`='".$actorId."';";
    $result = $mysqli->query($sql);

    $row = $result->fetch_array($result);

    if (!mysqli_num_rows($result))
    {
        $inputLike = "INSERT INTO `userLike` (`userId`, `movieId`, `actorId`) VALUES ('".$openId."', '".$movieId."', '".$actorId."');";

        if($mysqli->query($inputLike)){

            $sumLikes = "UPDATE `likes` SET `like`=`like`+1 WHERE `movieId`='".$movieId."' AND `actorId`='".$actorId."'";

            if($mysqli->query($sumLikes)){

                $lastLike = "SELECT `like` FROM `likes` WHERE `movieId`='".$movieId."' AND `actorId`='".$actorId."'";

                if($endLike = $mysqli->query($lastLike)){

                    $value = $endLike->fetch_object();

                    $like[] = (object)[
                        'like'=>(int)$value->like,
                        'likeSymbol'=> true
                    ];

                    echo json_encode($like);

                }

            }
        }
    }
    else
    {
        $delLike = "DELETE FROM `userLike` WHERE (`userId` = '".$openId."' AND `movieId` = '".$movieId."' AND `actorId` = '".$actorId."');";

        if($mysqli->query($delLike)){

            $disLikes = "UPDATE `likes` SET `like`=`like`-1 WHERE `movieId`='".$movieId."' AND `actorId`='".$actorId."'";

            if($mysqli->query($disLikes)){

                $lastLike = "SELECT `like` FROM `likes` WHERE `movieId`='".$movieId."' AND `actorId`='".$actorId."'";

                if($endLike = $mysqli->query($lastLike)){

                    $value = $endLike->fetch_object();

                    $like[] = (object)[
                        'like'=>(int)$value->like,
                        'likeSymbol'=> false
                    ];

                    echo json_encode($like);

                }

            }
        }


    }



}
else {
    echo json_encode(array ());
}


$mysqli->close();