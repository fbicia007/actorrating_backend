<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/11
 * Time: 下午9:01
 */


//include_once "connect.php";
include_once "pdo_connect.php";

$host = 'https://'.$_SERVER['HTTP_HOST'];

if(isset($_GET["id"]))
{
    $actorId = $_GET["id"];
    $sql = "SELECT * FROM actors WHERE `id` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($actorId));
    $result = $stmt->fetchAll();
}
elseif(isset($_GET["srch_text"]))
{
    $search_keyword = $_GET["srch_text"];
    $sql = "SELECT * FROM actors WHERE `name` LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($search_keyword));
    $result = $stmt->fetchAll();
}
else{
    $sql = 'SELECT * FROM actors ORDER BY CONVERT( name USING gbk ) COLLATE gbk_chinese_ci ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array());
    $result = $stmt->fetchAll();
}


if ($result) {

    foreach($result as $key) {

        $actorId = $key['id'];
        $ratingView = false;
        $comments = [];

        $actorVoteSql = "SELECT * FROM actorVote WHERE actorId = ?;";
        $stmt = $pdo->prepare($actorVoteSql);
        $stmt->execute(array($actorId));
        $resultActorVotes = $stmt->fetchAll();

        if ($resultActorVotes) {

            #count votes 0
            $vote0Sql = "SELECT COUNT(openId) AS NumberOfVotes FROM actorVote where actorId = ? AND vote = 0;";
            $stmt = $pdo->prepare($vote0Sql);
            $stmt->execute(array($actorId));
            $resultVote0 = $stmt->fetchAll();
            $votes0 = $resultVote0[0]['NumberOfVotes'];

            #count votes 1-4
            $vote1_4Sql = "SELECT COUNT(openId) AS NumberOfVotes FROM actorVote where actorId = ? AND vote between 1 and 4;";
            $stmt = $pdo->prepare($vote1_4Sql);
            $stmt->execute(array($actorId));
            $resultVote1_4 = $stmt->fetchAll();
            $votes1_4 = $resultVote1_4[0]['NumberOfVotes'];

            #count votes 5-8
            $vote5_8Sql = "SELECT COUNT(openId) AS NumberOfVotes FROM actorVote where actorId = ? AND vote between 5 and 8;";
            $stmt = $pdo->prepare($vote5_8Sql);
            $stmt->execute(array($actorId));
            $resultVote5_8 = $stmt->fetchAll();
            $votes5_8 = $resultVote5_8[0]['NumberOfVotes'];

            #count votes 9-10
            $vote9_10Sql = "SELECT COUNT(openId) AS NumberOfVotes FROM actorVote where actorId = ? AND vote between 9 and 10;";
            $stmt = $pdo->prepare($vote9_10Sql);
            $stmt->execute(array($actorId));
            $resultVote9_10 = $stmt->fetchAll();
            $votes9_10 = $resultVote9_10[0]['NumberOfVotes'];

            #average for all votes
            $avgActorVoteSql = "SELECT AVG(vote) AS averageVote FROM actorVote WHERE actorId = ? AND vote NOT LIKE 0";
            $stmt = $pdo->prepare($avgActorVoteSql);
            $stmt->execute(array($actorId));
            $resultAvgActorVotes = $stmt->fetchAll();
            $averageVote = $resultAvgActorVotes[0]['averageVote'];

            $ratingSum =$votes0+$votes1_4+$votes5_8+$votes9_10;

            if($ratingSum >=2){

                $ratingView = true;
            }
            $percentage14=$votes1_4/$ratingSum;
            $percentage58=$votes5_8/$ratingSum;
            $percentage910=$votes9_10/$ratingSum;

            foreach($resultActorVotes as $objActorVotes) {

                $openId = $objActorVotes['openId'];

                #user info
                $sqlUser = 'SELECT user_info FROM cSessionInfo WHERE open_id = ?';
                $stmt = $pdo->prepare($sqlUser);
                $stmt->execute(array($openId));
                $resultUserInfo = $stmt->fetchAll();
                $userInfo = $resultUserInfo[0]['user_info'];


                $comment = $objActorVotes['comment'];
                $vote = $objActorVotes['vote'];
                $dateTime = $objActorVotes['timestamp'];

                $comments[] = (object)[
                    'nickName'=>json_decode($userInfo)->nickName,
                    'avatarUrl'=>json_decode($userInfo)->avatarUrl,
                    'comment'=>$comment,
                    'rating'=>(int)$vote,
                    'time'=>date("Y-m-d H:i",strtotime($dateTime))
                ];


            }

        }#end vote detail

        #all actors infos
        if($key['birthday']==null){
            $birthday = '';
        }else{
            $birthday = $key['birthday'];
        }

        if($ratingView==true){

            //$outTrue[] = (object)[
            //$outTrue[] = [
            $out1[] = (object)[
                'id' => (int)$key['id'],
                'name' => $key['name'],
                'photo' => $host.'/actorrating/images/actors/'.$key['photo'],
                'description' => $key['description'],
                'birthday' => $birthday,
                'constellation' => $key['constellation'],
                'birthplace' => $key['birthplace'],
                'profession' => $key['profession'],
                'averageRating' => round($averageVote,1),
                'ratingLow' => round(number_format($percentage14*100,0)),
                'ratingMiddle' => round(number_format($percentage58*100,0)),
                'ratingHigh' => round(number_format($percentage910*100,0)),
                'rated'=>$ratingView,
                'comments' => $comments
            ];



        }else{
            $out2[] = (object)[
                'id' => (int)$key['id'],
                'name' => $key['name'],
                'photo' => $host.'/actorrating/images/actors/'.$key['photo'],
                'description' => $key['description'],
                'birthday' => $birthday,
                'constellation' => $key['constellation'],
                'birthplace' => $key['birthplace'],
                'profession' => $key['profession'],
                'averageRating' => round($averageVote,1),
                'ratingLow' => round(number_format($percentage14*100,0)),
                'ratingMiddle' => round(number_format($percentage58*100,0)),
                'ratingHigh' => round(number_format($percentage910*100,0)),
                'rated'=>$ratingView,
                'comments' => $comments
            ];


        }

        $averageVote = 0;
        $percentage14=0;
        $percentage58=0;
        $percentage910=0;


    }



 $sort = array(
            'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
            'field'     => 'averageRating',       //排序字段
        );
        $arrSort = array();
        $xx = array();
        foreach($out1 AS $uniqid => $row){

            foreach($row AS $key=>$value){

                $arrSort[$key][$uniqid] = $value;

            }
        }

        if($sort['direction']){
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $out1);
        }

        $out=array_merge($out1,$out2);

    //var_dump($out);
    #排序
/*
    function cmp($a, $b)
    {
        return bccomp($b->averageRating, $a->averageRating);
    }

    usort($out, "cmp");

    #end 排序
*/




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

            //var_dump($out);
            echo json_encode($out);
        }
    }
    else{
        echo json_encode(array ());
    }
}

$pdo = null;