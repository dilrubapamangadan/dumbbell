<?php include_once('../global.php'); ?>
<?php

/*
 * ==== 1 =>  admin 
 * ==== 2 =>  staff 
 * ==== 3 =>  record
 * ==== 4 =>  pharmacy 
 * ==== 5 =>  employee 
*/


	// Authenticate user login
function auth_login() {


	if( ! isset( $_SESSION[ SYSTEM_NAME . 'userid'] )   ) {
		$cx090 = explode("/", dirname($_SERVER['SCRIPT_NAME']) ) ;
		$current_now = $cx090[count($cx090)-1];

		$dest = ROOT . $_SERVER['REQUEST_URI'];
		$_SESSION['TO'] = $dest; 

		if($current_now == MAIN01)
			setLocation(PATH . 'admin-login');
		else if($current_now == MAIN02)
			setLocation( PATH . 'gym-login');
		else
			setLocation(PATH );
		exit();
		
	}  
	
	$flag = true;  
	if( decrypt($_SESSION[ SYSTEM_NAME . 'type']) == 1 && dirname($_SERVER['SCRIPT_NAME']) . '/' !=  DIRECTORY_ADMIN )  
		$flag = false; 
	if(decrypt( $_SESSION[ SYSTEM_NAME . 'type']) == 2 && dirname($_SERVER['SCRIPT_NAME']) . '/' !=  DIRECTORY_GYM)  
		$flag = false;  


	if( !$flag ) {
	//	header('Location:' . PATH );
		exit();
	}
}







function auth_use() { 
	if( isset( $_SESSION[ SYSTEM_NAME . 'userid'] )   ) { 

		switch (user_type()) {
			case 1:
			setLocation(PATH_ADMIN);
			break; 
			case 2:
			setLocation(PATH_GYM);
			break; 

			default: 
			break;
		} 

	}
	

}
	// get logged user type
function user_type() {
	return decrypt($_SESSION[SYSTEM_NAME . 'type']);
}


?>