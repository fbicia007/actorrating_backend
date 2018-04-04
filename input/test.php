<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/19
 * Time: 上午12:06
 */
include_once "connect.php";

$actorsSql = "SELECT * FROM `actors`";
$stmt = $pdo->prepare($actorsSql);
$stmt->execute();
$resultActors = $stmt->fetchAll();