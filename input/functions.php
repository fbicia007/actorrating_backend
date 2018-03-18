<?php
/**
 * Created by PhpStorm.
 * User: fbicia
 * Date: 2018/3/17
 * Time: 下午3:17
 */

function imgUpload($file,$type,$onlineName){

    switch ($type)
    {
        case 'posterV':

            $path = 'images/movie/';
            break;

        case 'posterH':

            $path = 'images/movie/';
            break;

        case 'actorPic':
           echo  $path = 'images/actor/';
            break;
    }


    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $file["name"]);
    //echo $file["size"];
    $extension = end($temp);     // 获取文件后缀名
    if ((($file["type"] == "image/gif")
            || ($file["type"] == "image/jpeg")
            || ($file["type"] == "image/jpg")
            || ($file["type"] == "image/pjpeg")
            || ($file["type"] == "image/x-png")
            || ($file["type"] == "image/png"))
        && ($file["size"] < 2048000)   // 小于 200 kb
        && in_array($extension, $allowedExts))
    {
        if ($file["error"] > 0)
        {
            echo "错误：: " . $file["error"] . "<br>";
        }
        else
        {
            //echo "上传文件名: " . $file["name"] . "<br>";
            //echo "文件类型: " . $file["type"] . "<br>";
            //echo "文件大小: " . ($file["size"] / 1024) . " kB<br>";
            //echo "文件临时存储的位置: " . $file["tmp_name"] . "<br>";

            // 判断当前目录下是否存在该文件

            if (file_exists($path.$onlineName.".".$extension))
            {
                //echo $onlineName.".".$extension . " 文件已经存在。 ";
                return 2;
            }
            else
            {
                // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                move_uploaded_file($file["tmp_name"], $path.$onlineName.".".$extension);
                //echo "文件存储在: " . $path.$onlineName.".".$extension;
                return 1;
            }
        }
    }
    else
    {
        //echo "非法的文件格式";
        return 3;
    }
}