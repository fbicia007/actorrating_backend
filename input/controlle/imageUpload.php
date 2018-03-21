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

            $path = '../images/movie/';
            $width =300;
            $height = 418;
            break;

        case 'posterH':

            $path = '../images/movie/';
            $width =300;
            $height = 128;
            break;

        case 'actorPic':
            $path = '../images/actor/';
            $width =300;
            $height = 450;
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
                imagecropper($file["tmp_name"],$width,$height,$path.$onlineName.".".$extension);
                //move_uploaded_file($file["tmp_name"], $path.$onlineName.".".$extension);
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

//$source_path string 源图路径

//$target_width integer 目标图宽度

//$target_height integer 目标图高度

//支持图片类型: image/gif, image/jpeg, image/png.

function imagecropper($source_path, $target_width, $target_height, $targetPath)
{
    $source_info   = getimagesize($source_path);
    $source_width  = $source_info[0];
    $source_height = $source_info[1];
    $source_mime   = $source_info['mime'];
    $source_ratio  = $source_height / $source_width;
    $target_ratio  = $target_height / $target_width;

    // 源图过高
    if ($source_ratio > $target_ratio)
    {
        $cropped_width  = $source_width;
        $cropped_height = $source_width * $target_ratio;
        $source_x = 0;
        $source_y = ($source_height - $cropped_height) / 2;
    }
    // 源图过宽
    elseif ($source_ratio < $target_ratio)
    {
        $cropped_width  = $source_height / $target_ratio;
        $cropped_height = $source_height;
        $source_x = ($source_width - $cropped_width) / 2;
        $source_y = 0;
    }
    // 源图适中
    else
    {
        $cropped_width  = $source_width;
        $cropped_height = $source_height;
        $source_x = 0;
        $source_y = 0;
    }

    switch ($source_mime)
    {
        case 'image/gif':
            $source_image = imagecreatefromgif($source_path);
            break;

        case 'image/jpeg':
            $source_image = imagecreatefromjpeg($source_path);
            break;

        case 'image/png':
            $source_image = imagecreatefrompng($source_path);
            break;

        default:
            return false;
            break;
    }

    $target_image  = imagecreatetruecolor($target_width, $target_height);
    $cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);

    // 裁剪
    imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height);
    // 缩放
    imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $cropped_width, $cropped_height);

    header('Content-Type: image/jpeg');
    imagejpeg($target_image,$targetPath);
    imagedestroy($source_image);
    imagedestroy($target_image);
    imagedestroy($cropped_image);

    //return imagedestroy($cropped_image);
}