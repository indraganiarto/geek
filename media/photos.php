<?php 
include '../sys.dll';

if(!$_GET) die('Unknown method');

if($_GET['filename']) $filename=$_GET['filename'];

if(!$filename) die('Require filename value');

function curl($url){
	$init=curl_init($url);
	ob_start();
	curl_exec($init);
	$results=ob_get_contents();
	ob_end_clean();
	curl_close($init);
	return $results;
}

$file_original = curl(HOST.'_temp/'.$filename);
file_put_contents('photos/original/'.$filename, $file_original);

$file_resize = curl(HOST.'resize.php?width=130&image='.HOST.'_temp/'.$filename);
file_put_contents('photos/resize/'.$filename, $file_resize);

$file_thumbs = curl(HOST.'resize.php?width=100&height=100&cropratio1:1&image='.HOST.'_temp/'.$filename);
file_put_contents('photos/thumbs/'.$filename, $file_thumbs);

//unlink(TEMP.$filename);