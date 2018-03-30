<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/2/18
 * Time: 上午1:23
 */

include_once "pdo_connect.php";
$host = 'https://'.$_SERVER['HTTP_HOST'];

if(isset($_GET['actorId'])&&isset($_GET['openId'])&&isset($_GET['roleId'])){

    $openId = $_GET['openId'];
    $actorId = $_GET['actorId'];
    $roleId = $_GET['roleId'];

    $sql = "SELECT * FROM userVote WHERE roleId = ? AND userId = ? ;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($roleId,$openId));
    $result = $stmt->fetchAll();

    if (!$result)
    {
        $inputVote = "INSERT INTO `userVote` (`userId`, `roleId`, `actorId`) VALUES (?,?,?);";
        $stmt = $pdo->prepare($inputVote);

        if($stmt->execute(array($openId,$roleId,$actorId))){

            $sumVotes = "UPDATE `roleVotes` SET `vote`=`vote`+1 WHERE `roleId`=? AND `actorId`=?";
            $stmt = $pdo->prepare($sumVotes);

            if($stmt->execute(array($roleId,$actorId))){

                $lastVote = "SELECT `vote` FROM `roleVotes` WHERE `roleId`=? AND `actorId`=?";
                $stmt = $pdo->prepare($lastVote);

                if($stmt->execute(array($roleId,$actorId))){

                    #这个角色的这个演员总最后得票数
                    $value = $stmt->fetchAll();
                    $value = $value[0]['vote'];

                    #vote Sum
                    $sum ="SELECT SUM(`vote`) as total FROM roleVotes WHERE roleId = ?;";
                    $stmt = $pdo->prepare($sum);

                    if ($stmt->execute(array($roleId))) {

                        $voteRoleSum = $stmt->fetchAll();
                        $voteRoleSum = $voteRoleSum[0]['total'];

                    }
                    #end vote Sum

                    if($voteRoleSum != 0)
                    {
                        $vote[] = (object)[
                            'vote'=>round($value*100/$voteRoleSum),
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
        $oldActorId = $result[0]['actorId'];

        $delVote = "DELETE FROM `userVote` WHERE (`userId` = ? AND `roleId` = ?);";
        $stmt = $pdo->prepare($delVote);
        $stmt->execute(array($openId,$roleId));

        if($actorId!=$oldActorId){

            $inputVote = "INSERT INTO `userVote` (`userId`, `roleId`, `actorId`) VALUES (?,?,?);";
            $stmt = $pdo->prepare($inputVote);
            $stmt->execute(array($openId,$roleId,$actorId));

            $sumVotes = "UPDATE `roleVotes` SET `vote`=`vote`+1 WHERE `roleId`=? AND `actorId`=?";
            $stmt = $pdo->prepare($sumVotes);
            $stmt->execute(array($roleId,$actorId));

            $sumVotes = "UPDATE `roleVotes` SET `vote`=`vote`-1 WHERE `roleId`=? AND `actorId`=?";
            $stmt = $pdo->prepare($sumVotes);
            $stmt->execute(array($roleId,$oldActorId));

            $symbol = true;

        }else{

            $sumVotes = "UPDATE `roleVotes` SET `vote`=`vote`-1 WHERE `roleId`=? AND `actorId`=?";
            $stmt = $pdo->prepare($sumVotes);
            $stmt->execute(array($roleId,$oldActorId));

            $symbol = false;

        }

        $lastVote = "SELECT `vote` FROM `roleVotes` WHERE `roleId`=? AND `actorId`=?";

        if($stmt = $pdo->prepare($lastVote)){

            $stmt->execute(array($roleId,$actorId));
            $value = $stmt->fetchAll();
            $value = $value[0][vote];

            #vote Sum
            $sum ="SELECT SUM(`vote`) as total FROM roleVotes WHERE roleId = ?;";
            $stmt = $pdo->prepare($sum);

            if ($stmt->execute(array($roleId))) {

                $voteRoleSum = $stmt->fetchAll();
                $voteRoleSum = $voteRoleSum[0]['total'];
            }
            #end vote Sum
            if($voteRoleSum != 0)
            {
                $vote[] = (object)[
                    'vote'=>round($value*100/$voteRoleSum),
                    'voteSymbol'=> $symbol
                ];
            }
            else{
                $vote[] = (object)[
                    'vote'=>0,
                    'voteSymbol'=> $symbol
                ];
                }

                echo json_encode($vote);
        }

    }

}
else {
    echo json_encode(array ());
}

