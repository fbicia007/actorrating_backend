<?php
$movieId = $_GET["movieId"];
$filename = "http://mysites/actorrating_backend/in_theaters.php?id=".$movieId;
$json_string = file_get_contents($filename);

$ss =  json_decode($json_string);
echo $ss[0]->id;
?>