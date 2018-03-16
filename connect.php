<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/1/12
 * Time: 下午2:33
 */


$mysqli = new mysqli('127.0.0.1', 'root', 'root', 'cAuth');
mysqli_query($mysqli, "SET NAMES 'utf8'");
/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}
//echo 'Success... ' . $mysqli->host_info . "\n";

//$mysqli->close();
