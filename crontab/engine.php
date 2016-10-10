<?php

//define host
define('DB_HOST', 'localhost');
define('DB_USER', 'postgres');
define('DB_PASS', 'root');
define('DB_NAME','ULINDB');
define('DB_PREFIX', 'un_');
define('DB_PORT', 5432);


//pg connect
$conn = pg_connect('host='.DB_HOST.' port='.DB_PORT.' dbname='.DB_NAME.' user='.DB_USER.' password='.DB_PASS);

if($conn){
	
	//auto publish news

	$sqlcheck = "SELECT * FROM un_news WHERE is_publish='0'";
	$qcheck = pg_query($sqlcheck);
	$num_rows = pg_num_rows($qcheck);

	if($num_rows>0){

		$start = microtime(true);
		set_time_limit(60);
		for ($i = 0; $i < 59; ++$i) {
		    publish_news();
		    time_sleep_until($start + $i + 1);
		}
			
	     
	}
	//end

}else{
	exit;
}
//auto checking

function publish_news(){

	$dn = date("Y-m-d");
	$tn = date("H:i:s");

	$sqlupdate = "UPDATE un_news SET is_publish='1' WHERE publish_schedule='".$dn." ".$tn."'";
	$qupdate = pg_query($sqlupdate);
	if($qupdate){
		$effected = pg_affected_rows($qupdate);
		if($effected > 0){
			print $effected." row effected at ".$dn." ".$tn."\n";
		}else{
			print "No row effected. Engine Running normally...".$dn." ".$tn."\n";
		}
	}else{
		print "ERROR_ENGINE{'publish_news'}:Can't Execute Query.\n";
	}

}
pg_close();
?>
