<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/12
 * Time: 下午5:27
 */
header("Content-Type:text/html; charset=utf8");
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=cAuth;charset=UTF8', $user, $pass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}