<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/2/18
 * Time: 上午1:23
 */

include_once "connect.php";
$host = "https://xuwang.de";

if(isset($_GET['actorId'])&&isset($_GET['openId'])&&isset($_GET['roleId'])){

    $openId = $_GET['openId'];
    $actorId = $_GET['actorId'];
    $roleId = $_GET['roleId'];

    $sql = "SELECT * FROM userVote WHERE roleId = '".$roleId."' AND userId = '".$openId."' AND `actorId`='".$actorId."';";
    $result = $mysqli->query($sql);

    $row = $result->fetch_array($result);

    if (!mysqli_num_rows($result))
    {
        $inputVote = "INSERT INTO `userVote` (`userId`, `roleId`, `actorId`) VALUES ('".$openId."', '".$roleId."', '".$actorId."');";

        if($mysqli->query($inputVote)){

            $sumVotes = "UPDATE `roleVotes` SET `vote`=`vote`+1 WHERE `roleId`='".$roleId."' AND `actorId`='".$actorId."'";

            if($mysqli->query($sumVotes)){

                $lastVote = "SELECT `vote` FROM `roleVotes` WHERE `roleId`='".$roleId."' AND `actorId`='".$actorId."'";

                if($endVote = $mysqli->query($lastVote)){

                    $value = $endVote->fetch_object();

                    #vote Sum
                    $sum ="SELECT SUM(`vote`) as total FROM roleVotes WHERE roleId = '".$roleId."';";

                    if ($total = $mysqli->query($sum)) {
                        while($voteSum = $total->fetch_object()){
                            $voteRoleSum = $voteSum->total;
                        }

                    }
                    #end vote Sum

                    if($voteRoleSum != 0)
                    {
                        $vote[] = (object)[
                            'vote'=>round($value->vote*100/$voteRoleSum),
                            'voteSymbol'=> true
                        ];
                    }
                    else{
                        $vote[] = (object)[
                            'vote'=>0,
                            'voteSymbol'=> true
                        ];
                    }

                    echo json_encode($vote);

                }

            }
        }
    }
    else
    {

        $delVote = "DELETE FROM `userVote` WHERE (`userId` = '".$openId."' AND `roleId` = '".$roleId."' AND `actorId` = '".$actorId."');";

        if($mysqli->query($delVote)){

            $sumVotes = "UPDATE `roleVotes` SET `vote`=`vote`-1 WHERE `roleId`='".$roleId."' AND `actorId`='".$actorId."'";

            if($mysqli->query($sumVotes)){

                $lastVote = "SELECT `vote` FROM `roleVotes` WHERE `roleId`='".$roleId."' AND `actorId`='".$actorId."'";

                if($endVote = $mysqli->query($lastVote)){

                    $value = $endVote->fetch_object();

                    #vote Sum
                    $sum ="SELECT SUM(`vote`) as total FROM roleVotes WHERE roleId = '".$roleId."';";

                    if ($total = $mysqli->query($sum)) {
                        while($voteSum = $total->fetch_object()){
                            $voteRoleSum = $voteSum->total;
                        }

                    }
                    #end vote Sum
                    if($voteRoleSum != 0)
                    {
                        $vote[] = (object)[
                            'vote'=>round($value->vote*100/$voteRoleSum),
                            'voteSymbol'=> false
                        ];
                    }
                    else{
                        $vote[] = (object)[
                            'vote'=>0,
                            'voteSymbol'=> false
                        ];
                    }


                    echo json_encode($vote);

                }

            }
        }
    }



}
else {
    echo json_encode(array ());
}


$mysqli->close();