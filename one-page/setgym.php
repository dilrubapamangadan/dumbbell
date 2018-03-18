
<?php

include_once('header.php');



if( !isset( $_SESSION['userid'] ) ) {
	if( $_SESSION['type'] == '1' ) {
		header('Location: ' . PATH . '/admin');
	}         
	if( $_SESSION['type'] == '2' ) {
		header('Location: ' . PATH . '/gym' );
	}         
	if($_SESSION['type'] == '3'){
		echo '<script type="text/javascript">location.href="login.php"</script>';
	}

}



?>





<?php 


    // if(isset($_POST['latitude']) && isset($_POST['longitude'])){
    //   $_SESSION['latitude'] = $_POST['latitude'];
    //   $_SESSION['longitude'] = $_POST['longitude'];
    // }



$db=new Database();
$error='';



$message = array(null, null);






$stmnt='select * from subscriber where  email ="'.$_SESSION['userid']. '"';


$result = $db->display($stmnt);

if(is_null($result[0]['class_id']))
	echo '<script type="text/javascript">location.href="add-class.php"</script>';





$stmnt='select * from gym_class where delete_status = 0';


$result = $db->display($stmnt);





?>

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 search-gym" >
			<div class="search-box1">
				<h2 class="section-title-default title-bar-high">Find Your Near GYm</h2>

				<form class="form-wrapper">
					<input type="text" id="pac-input" placeholder="Enter location..." required>
					<!-- <button type="submit">Search</button> -->
				</form>


				<div class="row" style="margin-top: 2pc;">

					<div class="col-md-12">

						<div id="map"></div>
					</div>

				</div>

				<div class="pac-card" id="pac-card">



					<div id="infowindow-content">




						<div class="pac-card" id="pac-card">
							<div  style="display: none !important;">
								<div id="title">
									Autocomplete search
								</div>
								<div id="type-selector" class="pac-controls" >
									<input type="radio" name="type" id="changetype-all" checked="checked">
									<label for="changetype-all">All</label>

									<input type="radio" name="type" id="changetype-establishment">
									<label for="changetype-establishment">Establishments</label>

									<input type="radio" name="type" id="changetype-address">
									<label for="changetype-address">Addresses</label>

									<input type="radio" name="type" id="changetype-geocode">
									<label for="changetype-geocode">Geocodes</label>
								</div>
								<div id="strict-bounds-selector" class="pac-controls">
									<input type="checkbox" id="use-strict-bounds" value="">
									<label for="use-strict-bounds">Strict Bounds</label>
								</div>
							</div>
							<div id="pac-container">

							</div>
						</div>
						<div id="infowindow-content">
							<img src="" width="16" height="16" id="place-icon">
							<span id="place-name"  class="title"></span><br>
							<span id="place-address"></span>
						</div>


					</div>



				</div>
			</div>
		</div>
	</div>
</div>



<?php

include_once('footer.php');

?>