<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/30
 * Time: 下午11:42
 */

include_once '../connect.php';

if($_GET["movieId"]){

    $movieId = $_GET["movieId"];
    $title = $_POST['title'];

    $sqlAllMovieTitle = 'SELECT * FROM movies WHERE id <> ? AND title = ?';
    $stmt = $pdo->prepare($sqlAllMovieTitle);
    $stmt->execute(array($movieId,$title));
    $resultAllMovieTitle = $stmt->fetchAll();

}else{

    $title = $_POST['title'];
    $sqlAllMovieTitle = 'SELECT * FROM movies WHERE title = ?';
    $stmt = $pdo->prepare($sqlAllMovieTitle);
    $stmt->execute(array($title));
    $resultAllMovieTitle = $stmt->fetchAll();
}


if(count($resultAllMovieTitle)==0){

    echo 1;
    exit();

}else{

    echo 0;
    exit();

}