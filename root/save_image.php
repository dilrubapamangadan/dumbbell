<?php 

function saveImageNow ($srcimage, $sitedirectory, $newWidth = 300) {




	$response = array("image" => $sitedirectory, "error" => true, "path" => $sitedirectory, "msg" => "Image converted succesfully");
	if(preg_match("/^data:image\/(\w+);base64,/", $srcimage) == 1){ 
		$filename               = md5($srcimage);
		$response["filename"]   = $filename ;

		list($type, $srcimage) = explode(';', $srcimage);
		list(, $srcimage)      = explode(',', $srcimage);

		$srcimage = base64_decode($srcimage);

		if(file_exists( $sitedirectory . '/' . $filename . '.png')  ){ 
			$response["image"] =    $filename . ".png";
			$response["msg"] = "Image retrieved from cache. Saved at: " . date("Y-m-d H:i:s" );
	    return $response;  // Kill and return response
	}

	try{ 

		if( file_exists($sitedirectory . '/' . $filename . '.png'))
			unlink($sitedirectory . '/' . $filename . '.png'); 

		file_put_contents($sitedirectory . '/' . $filename . '.png', $srcimage); 

		$response["image"] =  $filename . ".png";
		$response["path"] =  $sitedirectory;

		a9845735909847530485z ($newWidth, $sitedirectory . '/' .  $filename , $sitedirectory . '/' . $response["image"]) ;
		

		$response['error'] = false;



	} catch(ImagickException $e){
		$response["error"]  = true;
		$response["msg"]    = $e->getMessage();

	}



} 

return $response; 
}

function a9845735909847530485z ($newWidth, $targetFile, $originalFile) {


	
	$info = getimagesize($originalFile);
	$mime = $info['mime'];


	switch ($mime) {
		case 'image/jpeg':
		$image_create_func = 'imagecreatefromjpeg';
		$image_save_func = 'imagejpeg';
		$new_image_ext = 'jpg';
		break;

		case 'image/png':
		$image_create_func = 'imagecreatefrompng';
		$image_save_func = 'imagepng';
		$new_image_ext = 'png';
		break;

		case 'image/gif':
		$image_create_func = 'imagecreatefromgif';
		$image_save_func = 'imagegif';
		$new_image_ext = 'gif';
		break;


	}


	$img = $image_create_func($originalFile);
	list($width, $height) = getimagesize($originalFile);

	$newHeight = ($height / $width) * $newWidth;
	$tmp = imagecreatetruecolor($newWidth, $newHeight);
	imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

	if (file_exists($targetFile)) {
		unlink($targetFile);
	}
	$image_save_func($tmp, "$targetFile.$new_image_ext");

	$returnStatus = true;



}

?>