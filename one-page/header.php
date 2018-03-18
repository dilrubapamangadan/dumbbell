<!doctype html>
<html class="no-js" lang="">

<?php


session_start();


include_once('../root/connection.php');







    // error message 
function show_error ($message) {
    $message_return = "";
    if (!empty($message)) {
        $message_return = $message_return . "<div class = 'alert ";
        switch ($message[0]) {
            case 1: $message_return = $message_return .  "alert-success"; break;
            case 2: $message_return = $message_return .  "alert-info"; break;
            case 3: $message_return = $message_return .  "alert-warning"; break; 
            case 4: $message_return = $message_return .  "alert-danger"; break;
            default: $message_return = $message_return .  "hidden"; break;
        }
        $message_return = $message_return .  "' role='alert'>";
        switch ($message[0]) {
            case 1: $message_return = $message_return .  
            '<i class="fa fa-check-circle" aria-hidden="true"></i>'; break;
            case 2: $message_return = $message_return .  
            '<i class="fa fa-info-circle" aria-hidden="true"></i>'; break;
            case 3: $message_return = $message_return .  
            '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>'; break; 
            case 4: $message_return = $message_return . 
            '<i class="fa fa-exclamation-circle" aria-hidden="true"></i>'; break;               
            default: $message_return = $message_return .  ""; break;
        }
        $message_return = $message_return . "<span style='padding-left: 10px;'>" . $message[1] . "</span>" ;
        $message_return = $message_return .  "</div>";
    }
    return $message_return;

}

?>


<!-- Mirrored from radiustheme.com/demo/html/gymedge/one-page/index4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Mar 2018 21:20:48 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>GymEdge | Home Page 4</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
        ============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <!-- Bootstrap CSS
        ============================================ -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome CSS
        ============================================ -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Owl Caousel CSS 
        ============================================ -->
        <link rel="stylesheet" href="vendor/OwlCarousel/owl.carousel.min.css">
        <link rel="stylesheet" href="vendor/OwlCarousel/owl.theme.default.min.css">
    <!-- meanmenu CSS
        ============================================ -->
        <link rel="stylesheet" href="css/meanmenu.min.css">
    <!-- normalize CSS
        ============================================ -->
        <link rel="stylesheet" href="css/normalize.css">
    <!-- main CSS
        ============================================ -->
        <link rel="stylesheet" href="css/main.css">
    <!-- nivo slider CSS
        ============================================ -->
        <link rel="stylesheet" href="css/custom-slider/css/nivo-slider.css" type="text/css" />
        <link rel="stylesheet" href="css/custom-slider/css/preview.css" type="text/css" media="screen" />
    <!-- flaticon CSS
        ============================================ -->
        <link rel="stylesheet" type="text/css" href="css/flaticon.css">
    <!-- Wow CSS
        ============================================ -->
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="stylesheet" type="text/css" href="css/site.css">
    <!-- Switch Style CSS 
        ============================================ -->
        <link rel="stylesheet" href="css/hover-min.css">
    <!-- Magic popup CSS 
        ============================================-->
        <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- style CSS
        ============================================ -->
        <link rel="stylesheet" href="style.css">
    <!-- responsive CSS
        ============================================ -->
        <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr JS
        ============================================ -->
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <style>
    /*pricing*/

    .pricing {
        text-align: center !important;
        padding: 50px 0 80px;
        background-color: #f5f5f5;
    }
    .pricing h2,.pricing p{
        color:#fff;
        text-align: center;

    }
    .pricing p{
     padding-bottom: 40px;   
 }

 .pricing .package{
     padding: 30px;
     border: 1px solid #ccc;
     background-color: #fff;
     border-radius: 5px;
     margin-top: 30px;
 }

 .package li{

    display: block;
    padding: 5px;
}
.package h4 ,package h1 ,package b ,.package p{
    color :#4c4c4c;
}
#contact{
    background-color: #f5f5f5;
}

.btn-send{
    height: 30px;
    border-radius: 8px;
    padding: 0 !important;
}
.pricing h2{
    color: #000000;
}
@media(max-width:768px){
    @media(max-width:768px) {

        .pricing {

            padding: 30px;
        }

        .packages {

            width: 80%;
            margin-left: 25px;
        }
    }

}

/*   search */
.search-gym{

    padding-top: 40px;
    padding-bottom: 40px;
}
.search-box1{

    color: #000000;
    text-align: center;


}
.search-gym input{
 width: 400px;
 height: 40px;
 border-radius: 8px;
 outline: none;


}
.search-gym button{
    height: 40px;
    background-color: #fb5b21;
    width: 100px;
    border-radius:8px;
    color: white;
    outline: none;

}

/*   cities */


.cities{
    padding: 50px 0 80px ;
    text-align: center;   
}
.cities {

    padding: 50px 0 80px;
    text-align: center;
}

.cities b,
.cities h2,
.cities h4 {

    margin: 20px 0 20px;
    color: #4c4c4c;
    text-align: center;
}


.cities p {

    color: #737373;
}

.cities img {

    height: 250px;
    width: 250px;
    margin-top: 80px;
    border-radius: 50%;
}


.cities i {

    height: 30px;
    width: 30px;
    padding: 5px;
    font-size: 17px;
    border-radius: 50%;
    background-color: #a0db8e;
    color: #fff;
}

.cities a:hover i {

    background-color: #709963;
}
@media(max-width:768px){

}


/*    cities end*/
/*   cards */
.cards ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.cards li {
    float: left;
}

.cards li a {
    display: block;
    color: white;
    text-align: center;
    padding: 16px;
    text-decoration: none;
}
/*     cards end*/

/*    contact*/
.contact{
    text-align: center;
    margin-top: 30px;
    margin-bottom: 30px;
}

@media(max-width:768px){

 .main-banner-inner .button{
     margin-top: 0px;
 }
}
/*    contact us*/

#map {
    height: 100%;
    height: 30pc;
}


/*   search end */
</style>



<body>
    <!-- Start wrapper -->
    <div class="wrapper">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Preloader Start Here -->
        <div id="preloader"></div>
        <!-- Preloader End Here -->
        <!-- Start Header area -->
        <header class="main-header header-style4" id="sticker">

            <div class="header-top-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="logo-area">
                                <a href="index.html"><img src="img/logo.png" style=" display: none;" width="20px" height="20px" alt="logo"></a>  <strong style="font-size: 40px;">dumbbell</strong>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-10">
                            <div class="main-menu">
                                <nav>
                                    <ul id="nav">
                                        <li class="current"><a href="index4.html">Home</a></li>
                                        <li><a href="#about">About</a></li>
                                        <li><a href="#classes">Classes</a></li>
                                        <li><a href="#contact">Contact</a></li>

                                        <?php  if( isset( $_SESSION['userid'] ) ) {
                                            
                                          
                                        }



                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End header Top Area -->
            <!-- mobile-menu-area start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul>
                                        <li class="current"><a href="index4.html">Home</a></li>
                                        <li><a href="#about">About</a></li>
                                        <li><a href="#classes">Classes</a></li>
                                        <li><a href="#contact">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area end -->
        </header>