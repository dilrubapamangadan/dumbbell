<?php 

include_once( 'global.php' );
include_once( 'root/connection.php');

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}  

try { 
	global $a;
	$a = new Database();

} catch (Exception $e) {

}

try {
	date_default_timezone_set("Asia/Kolkata");
} catch (Exception $e) {

}





$array = array(  "user"     => decrypt($_SESSION[SYSTEM_NAME.'userid0']) ,
	"username"  => decrypt($_SESSION[SYSTEM_NAME.'userid']) ,
		"action"  => -1 , //logout
		"result"    =>  0,
		"remark"    => " logout action",
		"date" => date("Y-m-d H:i:s") 
	);

try { 
	session_destroy();
	$array['result'] = 1;
} catch (Exception $e) {
	
}
$result  = insertInToTable ('tbl_log', $array, $a );


// header("Location: index.php");
setLocation("index.php");

?>