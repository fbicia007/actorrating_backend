<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/2/17
 * Time: 下午11:09
 */

include_once "connect.php";
$host = "https://xuwang.de";

if(isset($_GET['id'])){

    $id = $_GET['id'];
    $sql = "SELECT * FROM movies WHERE released = 0 AND id = ".$id.";";

}
else {
    $sql = "SELECT * FROM movies WHERE released = 0;";
}


if ($result = $mysqli->query($sql)) {
    while($obj = $result->fetch_object()) {

        $movieId = $obj->id;

        $roles = "SELECT * FROM roles WHERE movieId = ".$movieId.";";
        if ($resultRoles = $mysqli->query($roles)) {

            while ($objRoles = $resultRoles->fetch_object()) {

                $roleDescription = $objRoles->description;
                $roleName = $objRoles->name;
                $roleId = $objRoles->id;

                #vote Sum
                $sum ="SELECT SUM(`vote`) as total FROM roleVotes WHERE roleId = '".$roleId."';";

                if ($total = $mysqli->query($sum)) {
                    while($voteSum = $total->fetch_object()){
                        $voteRoleSum = $voteSum->total;
                    }

                }
                #end vote Sum

                $actorsSql = "SELECT * FROM roleVotes WHERE roleId = ".$roleId.";";
                if ($resultActors = $mysqli->query($actorsSql)) {

                    while ($objActors = $resultActors->fetch_object()) {

                        $actorId = $objActors->actorId;
                        #start 这个角色这个演员的vote数字
                        $voteActorSql = "SELECT vote FROM roleVotes WHERE actorId = ".$actorId." AND roleId = ".$roleId.";";

                        if($resultVoteActor = $mysqli->query($voteActorSql)){
                            while ($objVoteActor = $resultVoteActor->fetch_object()) {
                                $vote = $objVoteActor->vote;
                            };
                        }
                        #end 这个角色这个演员的vote数字

                        #user voted or not
                        if(isset($_GET['openId'])){
                            $openId = $_GET['openId'];
                            $beVoted = "SELECT * FROM userVote WHERE userId = '".$openId."' AND `roleId`='".$roleId."' AND `actorId`='".$actorId."';";
                            $resultBeVoted = $mysqli->query($beVoted);
                            $rowBeVoted = $resultBeVoted->fetch_array($resultBeVoted);
                            if (!mysqli_num_rows($resultBeVoted)){
                                $voteSymbol=false;
                            }
                            else{
                                $voteSymbol=true;
                            }
                        }
                        else{
                            $voteSymbol=false;
                        }
                        #end user voted or not

                        $actorRow = "SELECT * FROM actors WHERE id = ".$actorId.";";

                        if ($resultActor = $mysqli->query($actorRow)) {

                            while($objActor = $resultActor->fetch_object()){

                                if($voteRoleSum!=0){
                                    $actors[] = (object)[
                                        'id'=>(int)$objActor->id,
                                        'name'=>$objActor->name,
                                        'photo'=>$host.'/actorrating/images/actors/'.$objActor->photo,
                                        'vote'=>round($vote/$voteRoleSum,2)*100,
                                        'voteSymbol'=>$voteSymbol
                                    ];
                                }
                                else{
                                    $actors[] = (object)[
                                        'id'=>(int)$objActor->id,
                                        'name'=>$objActor->name,
                                        'photo'=>$host.'/actorrating/images/actors/'.$objActor->photo,
                                        'vote'=>(int)$vote,
                                        'voteSymbol'=>$voteSymbol
                                    ];
                                }

                            }

                        }

                    };
                    $offlineRoles[] = (object)[
                        'id'=>$roleId,
                        'name'=>$roleName,
                        'description'=>$roleDescription,
                        'actors'=>$actors
                    ];

                    $actors=[];

                }
            };
        }
        $out[] = (object)[
            'id' => (int)$obj->id,
            'title' => $obj->title,
            'posterV' => $host.'/actorrating/images/movies/'.$obj->posterV,
            'posterH' => $host.'/actorrating/images/movies/'.$obj->posterH,
            'description' => $obj->description,
            'director' => $obj->director,
            'type' => $obj->type,
            'status' => (int)$obj->released,
            'roles' => $offlineRoles
        ];

        $offlineRoles=[];

    }
    if($out != null){
        #翻页
        if (isset($_GET['start']) && isset($_GET['count'])) {

            $startId = $_GET['start'];
            $count = $_GET['count'];

            $array = array();

            for ($x=$startId; $x<$count; $x++) {
                $array[] = $out[$x];
            }
            echo json_encode($array);
        }
        else{
            echo json_encode($out);
        }
    }
    else{
        echo json_encode(array ());
    }


}

$mysqli->close();