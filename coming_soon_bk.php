<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/1/12
 * Time: 下午3:56
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
    while($obj = $result->fetch_object()){

        $movieId = $obj->id;
        $likes = "SELECT * FROM likes WHERE movieId = ".$movieId.";";
        if ($resultLikes = $mysqli->query($likes)) {

            while($objLikes = $resultLikes->fetch_object()){

                $role = $objLikes->role;
                $like = (int)$objLikes->like;

                $actorsRow = "SELECT * FROM actors WHERE id = ".$objLikes->actorId.";";
                if ($resultActors = $mysqli->query($actorsRow)) {

                    while($objActors = $resultActors->fetch_object()){
                        $actors[] = (object)[
                            'id'=>(int)$objActors->id,
                            'name'=>$objActors->name,
                            'photo'=>$host.'/actorrating/images/actors/'.$objActors->photo,
                            'like'=>$like,
                            'role'=>$role
                        ];
                    }

                }

            }
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
            'actors' => $actors
        ];

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