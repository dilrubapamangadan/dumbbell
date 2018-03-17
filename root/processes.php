<?php
include_once('../global.php');
include_once( 'connection.php' ); 
include_once( 'save_image.php' ); 

try { 
	global $a;
	$a = new Database();

} catch (Exception $e) {

}

try {
	date_default_timezone_set("Asia/Kolkata");
} catch (Exception $e) {

}




function get_client_ip() {
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}

// 
// 
// 
// actions
// 
// 

// 0 login
// -1 logout
// 1 normal
// 
// 
// 
// 


function userLogin ( $username, $password , $type, $header_token ) {


	global $a;
	$authentication = false;
	$returnArray = array('success' => -2, 
		'data' => null,
		'remark' => "Invalid Username or Password");

	$query = 'select * from admin where email = :username and password = :password AND delete_status =0 AND login = 1  ';
	$userid = 0;
	$params = array(
		':username' =>  $username, 
		':password' =>  md5($password) 
	);  
	$user = $a->display( $query, $params );

	
	if( $user ) {
		if($user[0]['email'] == $username &&   md5($password) == $user[0]['password']) {
			$userid = $user[0]['id'];
			$authentication = true;

		} 
	} 


	if( $authentication ){

		$_SESSION[SYSTEM_NAME.'userid0'] = encrypt($user[0]['id']);
		$_SESSION[SYSTEM_NAME.'userid'] = encrypt($username);
		$_SESSION[SYSTEM_NAME.'type'] = encrypt($type);
		$returnArray['success'] = 1;
		$returnArray['remark'] = "yor login successful";
		

	}

	if(  $authentication &&  !is_null($header_token) && ($header_token != $_SESSION[SYSTEM_NAME .'_token'] ) )
		$_SESSION[ SYSTEM_NAME .'_token' ] = $header_token;

	return  $returnArray;



}






function checkUser ( $type ){  
	$returnArray = array('success' => -1, 
		'data' => null,
		'remark' => "session expired, login again "); 

	if(isset($_SESSION[SYSTEM_NAME.'userid']) && isset($_SESSION[SYSTEM_NAME.'type']) )
		if( decrypt($_SESSION[SYSTEM_NAME.'type']) == $type) {
			$returnArray['success'] = 1;
			$returnArray['remark'] = "access granted";
		} 
		return  $returnArray;
	}



	function setProfile( $name , $email, $mobile , $image , $type ) {

		global $a;

		$returnArray = array('success' => -2, 
			'data' => null,
			'remark' => "Invalid input");



		$array =  array(
			'name' => $name, 
			'email' => $email, 
			'mobile' => $mobile, 
			'image' =>  basename($image) ,
			"date" => date("Y-m-d H:i:s")
		);






		try {

			$result  = updateTable ('admin', $array,  ' id = ' . decrypt($_SESSION[SYSTEM_NAME.'userid0']) . ' AND delete_status = 0   ', $a ); 
			$returnArray['success'] = $result;
			$returnArray['remark'] = "data updated successfully";
			//myActivity("profile updated");
		} catch (Exception $e) {
			
			$returnArray['success'] = 2;
			$returnArray['remark'] = "invalid data";
		}



		return  $returnArray;
	}


	function getProfile( $type) {

		global $a;

		$returnArray = array('success' => 0, 
			'data' => null,
			'remark' => "Invalid request");



		try {


			$result = selectFromTable (' *', 'admin',  ' id = ' . decrypt($_SESSION[SYSTEM_NAME.'userid0']) . ' AND delete_status = 0  '  , $a );

			$returnArray['success'] = 3;
			$returnArray['data'] = $result[0];
			$returnArray['data']['image'] = 'files/images/admin/' . $returnArray['data']['image']; 
			$returnArray['data']['phone'] =  $returnArray['data']['mobile']; 
			$returnArray['remark'] = "data fetching success";


		} catch (Exception $e) {
			
			$returnArray['success'] = 2;
			$returnArray['remark'] = "invalid request";
		}



		return  $returnArray;

	}











	function updateDp ($data, $type) {
		$done = false;
		$path = null;
		$sitedirectory = '../files/images/admin';
		global $a;

		$returnArray = array('success' => 2, 
			'data' => null,
			'remark' => "Invalid input");


		try {
			$path =  saveImageNow($data , $sitedirectory );
			$done = true;
		} catch (Exception $e) {
			$done = false;
		}

		if( $done ) {



			try { 
				$result = selectFromTable (' * ', 'admin',  ' id = ' . decrypt($_SESSION[SYSTEM_NAME.'userid0']) . ' AND delete_status = 0   '  , $a );


				$xarray =  $result[0];



				$array =  array( 
					'image' => $path['image'] ,
					"date" => date("Y-m-d H:i:s")
				);


				$result  = updateTable ('admin', $array,  ' id = ' . decrypt($_SESSION[SYSTEM_NAME.'userid0']) . ' AND delete_status = 0    '  , $a ); 
				$returnArray['success'] = $result;
				$returnArray['remark'] = "image updated successfully";


				$returnArray['data'] = 'files/images/admin/' . $path['image'];


				//myActivity("profile picture updated");

			} catch (Exception $e) {

				$returnArray['success'] = 2;
				$returnArray['remark'] = "invalid request";
			}


		}








		return  $returnArray;
	}



	function getProfileBasic ( $type) {

		global $a;

		$returnArray = array('success' => 0, 
			'data' => null,
			'remark' => "Invalid request");



		try {


			$result = selectFromTable (' * ', 'admin',  ' id = ' . decrypt($_SESSION[SYSTEM_NAME.'userid0']) . ' AND delete_status = 0  ' , $a );

			$returnArray['success'] = 3; 

			$returnArray['data']['name']=  $result[0]['name'];  
			$returnArray['data']['email'] =  $result[0]['email'] ;  
			$returnArray['data']['image'] = 'files/images/admin/' . $result[0]['image'] ; 


			$returnArray['remark'] = "data fetching success";


		} catch (Exception $e) {
			
			$returnArray['success'] = 2;
			$returnArray['remark'] = "invalid request";
		}



		return  $returnArray;

	}






	function updateLogin( $type, $password, $newpassword  ) {
		global $a;

		$returnArray = array('success' => 2, 
			'data' => null,
			'remark' => "Invalid Current Password");

		$authentication = false;


		try {

			$returnArray['data']  =11;

			$result = selectFromTable (' id, email, password ', '   admin   ',  ' id = ' . decrypt($_SESSION[SYSTEM_NAME.'userid0']) . ' AND delete_status = 0  AND login = 1 AND password = "' . md5($password) .  '"    '    , $a );

			

			if(! is_null( $result))
				if( $result[0]['email'] === decrypt($_SESSION[SYSTEM_NAME.'userid']) &&   $result[0]['id'] == decrypt($_SESSION[SYSTEM_NAME.'userid0']) &&  $result[0]['password'] === md5($password)  )
					$authentication = true;

			} catch (Exception $e) {

				$authentication = false;
			}





			if( $authentication && ($password === $newpassword)   ) { 
				$returnArray['success'] = 21;
				$returnArray['remark'] = "password has been previously used. please choose a different one.";
				$authentication = false;
			}



			if( $authentication   ) {



				$array =  array( 
					'password' => md5($newpassword), 
					"date" => date("Y-m-d H:i:s")
				);

				try { 

					$result  = updateTable ('admin', $array,  ' id = ' . decrypt($_SESSION[SYSTEM_NAME.'userid0']) . ' AND delete_status = 0  '   , $a ); 


					$returnArray['success'] = $result;
					$returnArray['remark'] = "password updated successfully";
					//myActivity("password updated ");

				} catch (Exception $e) {

					$returnArray['success'] = 2;
					$returnArray['remark'] = "invalid data";
				}



			} else {

				//myActivity( "attempt to change password" , 0, 1, 0);
			}







			return  $returnArray;
		}






		function addDoctor( $image, $address, $city, $dob, $email, $fname, $landline, $lname, $location, $oaddress, $officephone, $phone, $pin, $qualification, $remark, $sex, $state    ) {


			$done = false;
			$path = null;
			$sitedirectory = '../files/images/employee';
			global $a;

			//$//myActivity_status = 0;
			//$//myActivity_type = 0;
			//$//myActivity_who = 0;


			$returnArray = array('success' => 2, 
				'data' => null,
				'remark' => "Invalid input");



			$temp  = checkEmail( $email ); 
			if($temp['success'] != 1)  
				return $temp;

			$temp  = checkPhone( $phone ); 
			if($temp['success'] != 1)  
				return $temp;





			if( $image == null )
				$done = true;

			if( !$done  ) {
				try {
					$path =  saveImageNow($image , $sitedirectory );
					$done = true;
				} catch (Exception $e) {
					$done = false;
				}

			}



			if( $done  ) {






				try { 


// ;

					$password = mt_rand();

					$array = array(   
						"email"  => $email,
						"authentication"  => 2,
						"Login"  => 1,
						"Password"  => md5($password), 
						"date" => date("Y-m-d H:i:s")
					);
					$result  = insertInToTable ('admin', $array, $a, true );


					//$//myActivity_who = $result;

					$array = array(  
						"user_id" => $result,
						"address"  => $address,
						"city"  => $city,
						"dob"  => $dob,
						"email"  => $email,
						"fname"  => $fname,
						"landline"  => $landline,
						"lname"  => $lname,
						"location"  => $location,
						"oaddress"  => $oaddress,
						"officephone"  => $officephone,
						"phone"  => $phone,
						"pin"  => $pin,
						"qualification"  => $qualification,
						"remark"  => $remark,
						"sex"  => $sex,			
						"image" => null,
						"state"  => $state,
						"date" => date("Y-m-d H:i:s")
					);

					if($path != null )		
						if(isset($path['image']))				
							$array["image"] = $path['image'];

						$result  = insertInToTable ('tbl_doctor', $array, $a );



						$returnArray['success'] = $result;
						$returnArray['remark'] = "added successfully";


						$returnArray['data'] = null;


						//$//myActivity_status = $result;
						//$//myActivity_type = 1;
					// //myActivity("profile picture updated");

					} catch (Exception $e) {

						$returnArray['success'] = 2;
						$returnArray['remark'] = "invalid request";
					}



				}


				//myActivity( "attempt to add new doctor " , //$//myActivity_status, //$//myActivity_type, //$//myActivity_who);


				return  $returnArray;

			}

			function checkEmail( $data , $id  = null) {

				global $a;

				$returnArray = array('success' => 2, 
					'data' => null ,
					'remark' => "email already exist");



				try {

					if( $id == null )
						$result = selectFromTable ('  email  ', ' admin ',  '  email = "' . $data . '"  '    , $a );
					else
						$result = selectFromTable ('  email  ', ' admin ',  '  email = "' . $data . '"  AND id != ' . $id    , $a );


					if($result ){
						$returnArray['success'] = 2;
					} else {

						$returnArray['success'] = 1;
						$returnArray['remark'] = " go ";
					}


				} catch (Exception $e) {

					$returnArray['success'] = 2;
					$returnArray['remark'] = "email already exist";
				}



				return  $returnArray;

			}




			function checkPhone( $data , $id  = null ) {

				global $a;

				$returnArray = array('success' => 2, 
					'data' => null ,
					'remark' => "phone number already exist");



				try {

					if( $id == null )
						$result = selectFromTable ('  phone  ', ' tbl_doctor ',  '  phone =  ' . $data . '   '    , $a );
					else
						$result = selectFromTable ('  phone  ', ' tbl_doctor ',  '  phone =  ' . $data . '  AND  user_id != ' . $id    , $a );


					if($result ){
						$returnArray['success'] = 2;
					} else {

						$returnArray['success'] = 1;
						$returnArray['remark'] = " go ";
					}


				} catch (Exception $e) {

					$returnArray['success'] = 2;
					$returnArray['remark'] = "phone number already exist";
				}



				return  $returnArray;

			}




			function getDoctor ( $limit, $offset) {



				global $a;

				$returnArray = array('success' => 0, 
					'data' => null ,
					'remark' => "Invalid request");



				try {

					/*user_id, fname, lname, email, dob, sex, phone, landline, officephone, state, city, address, oaddress, location, pin, qualification, image, remark, delete_status, DATE_FORMAT( date , '%Y-%m-%d') AS date*/

					//IF ( CHAR_LENGTH(fname) > 2 , CONCAT (SUBSTR(fname, 1, 2), "..") , fname ) 
					$result = selectFromTable (' user_id AS id , CONCAT (fname, " ", lname) AS name, email, phone, IF ( CHAR_LENGTH(qualification) > 24 , CONCAT( SUBSTR(qualification, 1, 22), "..."), qualification )AS q, image, delete_status AS d , DATE_FORMAT( date , "%Y-%m-%d") AS date  ', ' tbl_doctor ',  '  1 = 1 ORDER BY  fname ASC LIMIT  ' .  $limit . '  OFFSET ' . $offset    , $a );

					$returnArray['success'] = 3;
					$returnArray['data'] =  $result; 
					$returnArray['remark'] = "data fetching success";


				} catch (Exception $e) {

					$returnArray['success'] = 2;
					$returnArray['remark'] = "invalid request";
				}



				return  $returnArray;
			}


			function  getSingleDoctor( $id ) {


				global $a;

				$returnArray = array('success' => 0, 
					'data' => null ,
					'remark' => "Invalid request");



				try {

					/**/

		//IF ( CHAR_LENGTH(fname) > 2 , CONCAT (SUBSTR(fname, 1, 2), "..") , fname ) 
					$result = selectFromTable (' user_id AS id, fname, lname, email, dob, sex, phone, landline, officephone, state, city, address, oaddress, location, pin, qualification, image, remark, delete_status, DATE_FORMAT( date , "%Y-%m-%d") AS date ', ' tbl_doctor ',  ' user_id = ' . $id  , $a );

					$returnArray['success'] = 3;
					$returnArray['data'] =  $result[0]; 
					$returnArray['remark'] = "data fetching success";


				} catch (Exception $e) {

					$returnArray['success'] = 2;
					$returnArray['remark'] = "invalid request";
				}



				return  $returnArray;
			}


			function updateDoctor(  $id, $image, $address, $city, $dob, $email, $fname, $landline, $lname, $location, $oaddress, $officephone, $phone, $pin, $qualification, $remark, $sex, $state    ) {






				$done = false;
				$path = null;
				$sitedirectory = '../files/images/employee';
				global $a;

				//$//myActivity_status = 0;
				//$//myActivity_type = 0;
				//$//myActivity_who = $id;


				$returnArray = array('success' => 2, 
					'data' => null,
					'remark' => "Invalid input");



				$temp  = checkEmail( $email, $id ); 
				if($temp['success'] != 1)  
					return $temp;

				$temp  = checkPhone( $phone, $id ); 
				if($temp['success'] != 1)  
					return $temp;





				if( $image == null )
					$done = true;

				if( !$done  ) {
					try {
						if(preg_match("/^data:image\/(\w+);base64,/", $image))
							$path =  saveImageNow($image , $sitedirectory );
							else
								$path["image"] = basename($image);
							$done = true;
						} catch (Exception $e) {
							$done = false;
						}

					}



					if( $done   ) {

						$array = array(   
							"email"  => $email,
							"authentication"  => 2,
							"Login"  => 1,
							"date" => date("Y-m-d H:i:s")
						);
						$result  = updateTable ('admin', $array , ' delete_status= 0 and user_id = ' . $id, $a );






						try { 

							$oldImage = selectFromTable ('  image  ', ' tbl_doctor ',  '  user_id =  ' . $id . '   '    , $a);
				// ;



							$array = array(  
								"user_id" => $result,
								"address"  => $address,
								"city"  => $city,
								"dob"  => $dob,
								"email"  => $email,
								"fname"  => $fname,
								"landline"  => $landline,
								"lname"  => $lname,
								"location"  => $location,
								"oaddress"  => $oaddress,
								"officephone"  => $officephone,
								"phone"  => $phone,
								"pin"  => $pin,
								"qualification"  => $qualification,
								"remark"  => $remark,
								"sex"  => $sex,			
								"image" => null,
								"state"  => $state,
								"date" => date("Y-m-d H:i:s")
							);

							if($path != null )		
								if(isset($path['image']))				
									$array["image"] = $path['image'];

								$result  = updateTable ('tbl_doctor', $array, ' delete_status= 0 and user_id = ' . $id , $a );



								$returnArray['success'] = $result;
								$returnArray['remark'] = "updated successfully";


								$returnArray['data'] = null;


								//$//myActivity_status = $result;
								//$//myActivity_type = 1;
									// //myActivity("profile picture updated");

								$upStatus = unlink($sitedirectory . '/' . $oldImage );

							} catch (Exception $e) {

								$returnArray['success'] = 2;
								$returnArray['remark'] = "invalid request";
							}



						}


						//myActivity( "attempt to update doctor " , //$//myActivity_status, //$//myActivity_type, //$//myActivity_who);


						return  $returnArray;

					}








































					function	addCategory( $name, $remark , $weigh  ) {





						global $a;
						$done = true ;
						$myActivity_status = 0;
						$myActivity_who = 0;
						$result = 0;

						$result = selectFromTable ('  id  ', ' gym_class ',  '  class_name =  "' . $name . '"  '    , $a );

						if(isset($result)) 
							if($result > 0)
								$done = false;

							if( $done  ) {






								try { 


									$array = array(   
										"class_name"  => $name,
										"remark"  => $remark,
										'amount' => $weigh, 
										"date" => date("Y-m-d H:i:s")
									);

									$result  = insertInToTable ('gym_class', $array, $a, true );


									if($result > 0)
										$myActivity_status = 1; 


									$myActivity_who = $result;



									$returnArray['success'] = $myActivity_status;
									$returnArray['remark'] = "added successfully";

									$returnArray['data'] = selectFromTable ('   id, class_name, remark, amount, delete_status, date   ', ' gym_class ',  '  id = ' . $result    , $a );
									$returnArray['data'] = $returnArray['data'][0];



								} catch (Exception $e) {

									$returnArray['success'] = 2;
									$returnArray['remark'] = "invalid request";
								}



							} else {
								$returnArray['success'] = 11;
								$returnArray['remark'] = "already exists";

							}

					//( $remark , $status = 1, $action = 1, $targ_table = NULL, $targ_id = 0) {


							return  $returnArray;

						}











						function getCategory (){




							global $a;

							$returnArray = array('success' => 0, 
								'data' => null ,
								'remark' => "Invalid request");



							try {

								/**/

							//IF ( CHAR_LENGTH(fname) > 2 , CONCAT (SUBSTR(fname, 1, 2), "..") , fname ) 
								$result = selectFromTable ('   id, class_name, remark, amount, delete_status, date   ', ' gym_class ',  ' 1=1 ORDER BY date DESC'  , $a );

								$returnArray['success'] = 3;
								$returnArray['data'] =  $result ; 
								$returnArray['remark'] = "data fetching success";


							} catch (Exception $e) {

								$returnArray['success'] = 2;
								$returnArray['remark'] = "invalid request";
							}



							return  $returnArray;



						}


						function updateCategory( $id, $name, $details, $delete, $weigh ) {

							global $a;

							$returnArray = array('success' => 2, 
								'data' => null, 
								'remark' => "Invalid data");

							$authentication = true;


							try {



								$result = selectFromTable (' * ', '   gym_class   ',  ' id <> ' . $id. ' AND class_name = "' . $name.  '"    '    , $a );


								if(isset($result))
									if(! is_null( $result))  {
										$authentication = false;
										$returnArray['data'] = ' id <>  ' . $id. ' AND gym_class = "' . $name.  '"    '  ;

									}



								} catch (Exception $e) {

									$authentication = false;
								}





								if( ! $authentication     ) { 
									$returnArray['success'] = 2;
									$returnArray['remark'] = "name already used."; 
								}



								if( $authentication   ) {



									$array =  array( 
										'class_name' => $name, 
										"remark" => $details,
										'amount' => $weigh,
										"delete_status" => $delete 
									);

									try { 

										$result  = updateTable (' gym_class ', $array,  ' id = ' . $id . '  '  , $a ); 


										$returnArray['success'] = $result;
										$returnArray['remark'] = "gym class updated successfully"; 

									} catch (Exception $e) {

										$returnArray['success'] = 2;
										$returnArray['remark'] = "invalid data";
									}



								} else {

									

								}







								return  $returnArray;
							}







							?>