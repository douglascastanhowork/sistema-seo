<?php
session_start();
header("Content-type: image/jpeg");

$n = $_SESSION['captcha'];

$imagem = imagecreate(313, 70);
imagecolorallocate($imagem, 200, 200, 200);

$fontcolor = imagecolorallocate($imagem, 20, 20, 20);

imagettftext($imagem, 60, 0, 110, 50, $fontcolor, 'Ginga.otf', $n);

imagejpeg($imagem, null, 100);
?>