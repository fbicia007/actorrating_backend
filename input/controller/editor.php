<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/28
 * Time: 下午10:12
 */

    if($_GET['actorId'])
    {
        echo "编辑演员";

    }
    elseif ($_GET['movieId']&&$_GET['status'])
    {
        echo "编辑movie";
    }