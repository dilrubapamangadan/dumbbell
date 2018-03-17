<?php include_once('../global.php'); ?>
<?php

session_start();
$authentication = true;

if (empty($_SESSION[ SYSTEM_NAME .'_token']) || !isset($_SESSION[ SYSTEM_NAME .'_token'] )) {
	$_SESSION[  SYSTEM_NAME . '_token'] = bin2hex(random_bytes(32));
}

header('Content-Type: application/json');
$headers = apache_request_headers();
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

if (isset($headers['CsrfToken'])) {
	if ($headers['CsrfToken'] !== $_SESSION[ SYSTEM_NAME .'_token' ]) 
		$authentication = false;
} else {	
	$authentication = false;
}






if( !$authentication ) {
	echo json_encode(array('success'=> -1 ,
		'data' => "errror",
		'remark' => "Empty and/or invalid CSRF token." ));	 
	exit( );
}



if (!isset($_SESSION[SYSTEM_NAME.'userid0']) || !isset($_SESSION[SYSTEM_NAME.'userid']) || !isset($_SESSION[SYSTEM_NAME.'type'])) {
	echo json_encode(array('success'=> -1 ,
		'data' => "errror",
		'remark' => "access denied due to invalid authentication." ));	 
	exit( );
}



$returnArray = array('success' => 0, 
	'data' => null,
	'remark' => "Nothing here.");

include_once( 'processes.php' ); 



// admin only 
if( isset($_POST['action']) &&  IS_AJAX  &&  decrypt($_SESSION[ SYSTEM_NAME .'type' ]) == 1 ) {

	switch( $_POST['action'] ) { 

		case 'check-user': 
		$returnArray = checkUser( 1 );
		break;

		case 'set-profile':  


		$name = $_POST['name'];  
		$email = $_POST['email']; 
		$mobile = $_POST['phone']; 
		$image = $_POST['image']; 

		$returnArray = setProfile( $name , $email, $mobile , $image ,   1 );
		break;

		case 'get-profile':   

		$returnArray = getProfile( 1 );
		break;

		case 'get-profile-basic':   

		$returnArray = getProfileBasic( 1 );
		break;






		case 'update-dp':    
		$data = $_POST['data'];   
		$returnArray = updateDp( $data ,  1 );
		break;

		// case 'get-log': 
		// $from = $_POST['from'];   
		// $limit = $_POST['limit'];   
		// $returnArray = getLog( 1, $from, $limit  );
		// break;




		case 'update-login': 
		$password = $_POST['password'];   
		$newpassword = $_POST['newpassword'];    
		$returnArray = updateLogin( 1, $password, $newpassword   );
		break;
		



		case 'check-email':    
		$data = $_POST['email'];
		$id= null;   
		if(isset( $_POST['id']))
			$id = $_POST['id'];
		$returnArray = checkEmail( $data, $id );
		break;



		case 'check-phone':    
		$data = $_POST['phone'];
		$id= null;   
		if(isset( $_POST['id']))
			$id = $_POST['id'];
		$returnArray = checkPhone( $data, $id );
		break;


		
		





		default :  
		$returnArray['success'] = 0; 
		$returnArray['remark'] = " server 304 error , refresh page";
		break; 
	}
} 





















echo json_encode($returnArray); 
?>