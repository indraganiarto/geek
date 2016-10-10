<?php

session_start();
$width = 75; //Ukuran lebar
$height = 20; //Tinggi
$im = imagecreate($width, $height);
$bg = imagecolorallocate($im, 245, 245, 245);
$len = 5; //Panjang karakter 
$char = md5(microtime());
$string = substr($char, 5, 5);
$_SESSION['security_code'] = $string; //hasil acak disimpan dalam session
//menambahkan titik2 gambar / noise
$bgR = mt_rand(100, 200);
$bgG = mt_rand(100, 200);
$bgB = mt_rand(100, 200);
//$noise_color = imagecolorallocate($im, abs(255 - $bgR), abs(255 - $bgG), abs(255 - $bgB));
//for ($i = 0; $i < ($width * $height) / 3; $i++) {
//    imagefilledellipse($im, mt_rand(0, $width), mt_rand(0, $height), 3, rand(2, 5), $noise_color);
//}
// proses membuat tulisan
$text_color = imagecolorallocate($im, 100, 100, 100);
$rand_x = rand(0, $width - 50);
$rand_y = rand(0, $height - 20);
imagestring($im, 3, 15, 3, $string, $text_color);
header("Content-type: image/png"); //Output format gambar
imagepng($im);
?>  
