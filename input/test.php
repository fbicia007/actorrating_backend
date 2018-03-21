<?php

//这里仅仅是为了案例需要准备一些素材图片
$url = 'daomubuji.jpeg';
$content = file_get_contents($url);
$filename = 'tmp.jpg';
file_put_contents($filename, $content);
$url = 'daomubiji.jpeg';
file_put_contents('daomubiji.jpeg', file_get_contents($url));
///开始添加水印操作
$im = imagecreatefromjpeg($filename);
$logo = imagecreatefrompng('daomubiji.jpeg');
$size = getimagesize('daomubiji.jpeg');
imagecopy($im, $logo, 15, 15, 0, 0, $size[0], $size[1]); header("content-type: image/jpeg");
imagejpeg($im);

?>