<?php
class Ifunction extends CI_Model{

	public function __construct()
	{
        parent::__construct();
    }
	
	public function get_pswd($text)
	{
		$result=crypt(md5($text.'99*&^%$#@!QQ+'), 'Developed by irvanfauzie@gmail.com');
		return $result;
	}
	public function get_pswd1($text)
	{
		$result=crypt(md5($text.'1+4=5|>tRuE'), 'Developed by irvanfauzie@gmail.com');
		return $result;
	}
	public function action_response($status, $form_id, $css, $message)
	{
		$result='<div class="'.$css.'">'.$message.'</div><script>iFresponse('.$status.', "'.$form_id.'")</script>';
		return $result;
	}
	
	public function slidedown_response($form_id, $css, $message)
	{
		$result='<div class="'.$css.'">'.$message.'</div><script>$("#'.$form_id.'").slideDown()</script>';
		return $result;
	}
	
	public function xlsBOF()
	{
		echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		return;
	}
	
	public function xlsEOF()
	{
		echo pack("ss", 0x0A, 0x00);
		return;
	}
	
	public function xlsWriteNumber($rows, $cols, $values)
	{
		echo pack("sssss", 0x203, 14, $rows, $cols, 0x0);
		echo pack("d", $values);
		return;
	}
	
	public function xlsWriteLabel($rows, $cols, $values )
	{
		$L = strlen($values);
		echo pack("ssssss", 0x204, 8 + $L, $rows, $cols, 0x0, $L);
		echo $values;
		return;
	}
	
	public function convert_to_jpg($target, $newcopy, $ext) {
		list($w_orig, $h_orig) = getimagesize($target);
		if($ext == "gif") $img = imagecreatefromgif($target); elseif($ext =="png") $img = imagecreatefrompng($target);
		$tci = imagecreatetruecolor($w_orig, $h_orig);
		imagecopyresampled($tci, $img, 0, 0, 0, 0, $w_orig, $h_orig, $w_orig, $h_orig);
		imagejpeg($tci, $newcopy, 84);
	}
	public function add_watermark($target,$stampsrc){
		// Load the stamp and the photo to apply the watermark to
		$stamp_img = base_url()."media/".$stampsrc;
		$im = imagecreatefromjpeg($target);
		$stamp = imagecreatefromjpeg($stamp_img);

		// Set the margins for the stamp and get the height/width of the stamp image
		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		// Merge the stamp onto our photo with an opacity of 50%
		imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);

		// Save the image to file and free memory
		imagepng($im, $target);
		imagedestroy($im);
	}
	public function un_link($url){
		if(file_exists($url)) unlink($url);
		return true;
	}
	
	public function curl($url)
	{
		$init=curl_init($url);
		ob_start();
		curl_exec($init);
		$get_content=ob_get_contents();
		ob_end_clean();
		curl_close($init);
		return $get_content;
	}
	
	public function curl_file_get_contents($url)
	{
		$ch = curl_init();
		curl_setopt_array($ch,
			array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_COOKIE => NULL,
				CURLOPT_NOBODY => false
			)
		);
		$contents = curl_exec($ch);
		curl_close($ch);
		if($contents) return $contents; else return false;
	}
	
	public function uid(){
		$mt=microtime();
		$string = array('.',' ');
		$result = str_replace($string, '', $mt);
		$results = rand(100, 999).$result.rand(21, 99);
		return $results;
	}
	
	public function alert_note($message, $len)
	{
		if(strlen($message) > $len) $content = '<a onclick=\'alert("'.str_replace('"', '', $message).'")\'>'.substr($message, 0, $len).'..</a>'; else $content = $message;
		return $content;
	}
	
	public function youtube_id($url, $return='id', $width='', $height='', $rel=0)
	{
		$urls = parse_url($url);
		
		if($urls['host'] == 'youtu.be'){
			$id = ltrim($urls['path'], '/');
		}elseif(strpos($urls['path'], 'embed') == 1){
			$id = end(explode('/', $urls['path']));
		}elseif(strpos($url, '/')===false){
			$id = $url;
		}else{
			if(isset($urls['query'])){
				$v = '';
				parse_str($urls['query']);
				$id = $v;
			}else{
				return false;
				exit();
			}
		}
		
		if($return == 'embed') return '<iframe width="'.($width?$width:560).'" height="'.($height?$height:349).'" src="http://www.youtube.com/embed/'.$id.'?rel='.$rel.'" frameborder="0" allowfullscreen></iframe>';
		elseif($return == 'thumb') return 'http://i1.ytimg.com/vi/'.$id.'/default.jpg';
		elseif($return == 'hqthumb') return 'http://i1.ytimg.com/vi/'.$id.'/hqdefault.jpg';
		else return $id;
	}
	
	public function paging($p=1, $page, $num_page, $num_record, $extra='')
	{
		$pnumber = '';
		echo '<div class="box-paging">';
		echo '<span>Total: <b>'.$num_record.'</b> Records</span>';
		if($p>1){
			$previous=$p-1;
			echo '<a class="text" href="'.$page.$previous.$extra.'" title="Previous Page">&laquo; Previous</a> ';
		}
		if($p>3) echo '<a class="text" href="'.$page.'1'.$extra.'" title="First Page">&laquo; First</a> ';
		for($i=$p-2;$i<$p;$i++){
		  if($i<1) continue;
		  $pnumber .= '<a href="'.$page.$i.$extra.'" title="'.$i.'">'.$i.'</a> ';
		}
		$pnumber .= ' <a class="active" title="'.$p.'">'.$p.'</a> ';
		for($i=$p+1;$i<($p+3);$i++){
		  if($i>$num_page) break;
		  $pnumber .= '<a href="'.$page.$i.$extra.'" title="'.$i.'">'.$i.'</a> ';
		}
		$pnumber .= ($p+2<$num_page ? ' <a class="text" href="'.$page.$num_page.$extra.'" title="Last Page">Last &raquo;</a> ' : " ");
		echo $pnumber;
		if($p<$num_page){
			$next=$p+1;
			echo '<a class="text" href="'.$page.$next.$extra.'" title="Next Page">Next &raquo;</a>';
		}
		echo '</div>';
	}
}