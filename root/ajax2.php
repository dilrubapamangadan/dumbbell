<?php include_once('../global.php'); ?><?php

session_start();
$authentication = true; 
$header_token = null;

header('Content-Type: application/json');
$headers = apache_request_headers();
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');




if (empty($_SESSION[ SYSTEM_NAME .'_token'])) {
	$_SESSION[  SYSTEM_NAME . '_token'] = bin2hex(random_bytes(32));
}



// -2 Invalid Username or Password  


$returnArray = array('success' => -2, 
	'data' => null,
	'remark' => "Invalid Username or Password");

include_once( 'processes.php' ); 




if( isset($_POST['action']) &&  IS_AJAX  ) {

	switch( $_POST['action'] ) { 

		case 'check-loc':    
		$latitude = $_POST['latitude']; 
		$longitude = $_POST['longitude']; 
		$temp = $_POST['temp']; 
		$returnArray = checkLoc( $latitude, $longitude, $temp );
		break;

















		default :
		$data = null;
		break;		
	}


	echo json_encode($returnArray); 
}  


?>