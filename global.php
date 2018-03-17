<?php


define( 'SYSTEM_NAME', 'dumbbell' ); 
define( 'DISPLAY_NAME', 'DUMBBELL ' );
define( 'SYSTEM_ROOT', '/dumbbell' );



define("ENCRYPTION_KEY", "!@1#Y$%^g&k*");
	// encrypt/decrypt($encrypted, ENCRYPTION_KEY);


define( 'MAIN01', 'admin');

define( 'MAIN02', 'gym');




/*
 * ==== 1 =>  admin 

*/



function siteURL() {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http"; 
	return $protocol;
} 

$SPROTOCOL = siteURL();

define( 'ROOT',  $SPROTOCOL. ':' . '//' . $_SERVER['SERVER_NAME'] .':' . $_SERVER['SERVER_PORT']  ); 
define( 'DIRECTORY',  SYSTEM_ROOT . '/'); 
define( 'PATH', $SPROTOCOL. '://' . $_SERVER['SERVER_NAME'] .':' . $_SERVER['SERVER_PORT']  . DIRECTORY ); 





define( 'DIRECTORY_ADMIN', DIRECTORY . MAIN01 . '/' );  
define( 'DIRECTORY_GYM', DIRECTORY . MAIN02 . '/' );  





define( 'PATH_ADMIN', PATH . MAIN01 ); 
define( 'PATH_GYM', PATH . MAIN02 ); 




define('DISPLAY_COLLEGE_NAME', '');
define('DISPLAY_COLLEGE_LOC', ' ');
define("DISPLAY_TEAM", "");


define( 'TERMS__CONDITIONS_URL', '#');
define( 'TERMS__CONDITIONS', ' 2017 ' . DISPLAY_TEAM. ' ');



// echo DIRECTORY_ADMIN;
// echo PATH_ADMIN;


function setLocation ( $nowPath ){ echo '<script type="text/javascript">location.href = "' . $nowPath . '" ;</script>'; }
function encrypt($pure_string, $encryption_key = "25c6c7ff35b9979b151f2136cd13b0ff") {
	if ($encryption_key == "25c6c7ff35b9979b151f2136cd13b0ff") {
		return strtr(base64_encode($pure_string), '+/=', '-_,');
	}
	$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
	return $encrypted_string;
}

/*
 * Returns decrypted original string
 */	
function decrypt($encrypted_string, $encryption_key = "25c6c7ff35b9979b151f2136cd13b0ff") {
	if ($encryption_key == "25c6c7ff35b9979b151f2136cd13b0ff") {
		return base64_decode(strtr($encrypted_string, '-_,', '+/='));
	}

	$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
	return $decrypted_string;
}





?>