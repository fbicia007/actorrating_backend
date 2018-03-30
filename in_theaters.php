<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/1/12
 * Time: 下午3:56
 */

include_once "connect.php";
$host = "http://".$_SERVER['HTTP_HOST'];

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    $sql = "SELECT * FROM movies WHERE released = 1 AND id = ".$id.";";

}
else {
    $sql = "SELECT * FROM movies WHERE released = 1;";
}


if ($result = $mysqli->query($sql)) {
    while($obj = $result->fetch_object()){

        $movieId = $obj->id;

        $likes = "SELECT * FROM likes WHERE movieId = ".$movieId.";";
        if ($resultLikes = $mysqli->query($likes)) {

            while($objLikes = $resultLikes->fetch_object()){

                $roleId = $objLikes->role;
                $roleSql = "SELECT * FROM roles WHERE id = ".$roleId.";";
                $resultRole = $mysqli->query($roleSql);
                while($objRole = $resultRole->fetch_object()){
                   $role = $objRole->name;
                   $roleId = $objRole->id;
                   $roleDescription = $objRole->description;
                }

                $like = (int)$objLikes->like;

                #user liked or not
                if(isset($_GET['openId'])){
                    $openId = $_GET['openId'];
                    $beliked = "SELECT * FROM userLike WHERE userId = '".$openId."' AND `movieId`='".$movieId."' AND `actorId`='".$objLikes->actorId."';";
                    $resultBeliked = $mysqli->query($beliked);
                    $rowBeliked = $resultBeliked->fetch_array($resultBeliked);
                    if (!mysqli_num_rows($resultBeliked)){
                        $likeSymbol=false;
                    }
                    else{
                        $likeSymbol=true;
                    }
                }
                else{
                    $likeSymbol=false;
                }
                #end user liked or not
                $actorsRow = "SELECT * FROM actors WHERE id = ".$objLikes->actorId.";";
                if ($resultActors = $mysqli->query($actorsRow)) {

                    while($objActors = $resultActors->fetch_object()){
                        $actors[] = (object)[
                            'id'=>(int)$objActors->id,
                            'name'=>$objActors->name,
                            'photo'=>$host.'/actorrating/images/actors/'.$objActors->photo,
                            'like'=>$like,
                            'role'=>$role,
                            'roleId'=>$roleId,
                            'roleDescription'=>$roleDescription,
                            'likeSymbol'=>$likeSymbol
                        ];
                    }

                }

            }
        }
        
        if($obj->posterH==''){
            $out[] = (object)[
                    'id' => (int)$obj->id,
                    'title' => $obj->title,
                    'posterV' => $host.'/actorrating/images/movies/'.$obj->posterV,
                    'posterH' => $host.'/actorrating/images/movies/'.$obj->posterH,
                    'posterVName' => $obj->posterV,
                    'posterHName' => $obj->posterH,
                    'description' => $obj->description,
                    'director' => $obj->director,
                    'type' => $obj->type,
                    'status' => (int)$obj->released,
                    'actors' => $actors
                ];
        }else{
            $out[] = (object)[
                    'id' => (int)$obj->id,
                    'title' => $obj->title,
                    'posterV' => $host.'/actorrating/images/movies/'.$obj->posterV,
                    'posterH' => $host.'/actorrating/images/movies/'.$obj->posterH,
                    'posterVName' => $obj->posterV,
                    'posterHName' => $obj->posterH,
                    'description' => $obj->description,
                    'director' => $obj->director,
                    'type' => $obj->type,
                    'status' => (int)$obj->released,
                    'actors' => $actors
                ];
        }
        

        $actors = [];

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