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


if (isset($headers['CsrfToken'])) {
	if ($headers['CsrfToken'] !== $_SESSION[ SYSTEM_NAME .'_token' ]) 
		$authentication = false;
	$header_token = $headers['CsrfToken'];
} else {	
	$authentication = false;
}

if( !$authentication ) {

	if ( !isset( $_POST['username'] ) && !isset( $_POST['password'] ) ) {
		echo json_encode(array('success'=> -1 , 
			'remark' => "Invalid CSRF token or Timeout , refresh page " ));	 
		exit(json_encode(['error' => 'Empty and/or Wrong CSRF token.']));
	}



}


// -2 Invalid Username or Password  


$returnArray = array('success' => -2, 
	'data' => null,
	'remark' => "Invalid Username or Password");

include_once( 'processes.php' ); 




if( isset($_POST['action']) &&  IS_AJAX  ) {

	switch( $_POST['action'] ) { 

		case 'login-1':
		$username = $_POST['username']; 
		$password = $_POST['password']; 

		$returnArray = userLogin($username, $password , 1, $header_token);
		break;

		case 'login-2':
		$username = $_POST['username']; 
		$password = $_POST['password']; 

		$returnArray = userLogin2($username, $password , 2, $header_token);
		break;


















		default :
		$data = null;
		break;		
	}


	echo json_encode($returnArray); 
}  


?>