<?php include_once('../global.php'); ?>
<?php include_once('../root/functions.php'); ?>

<?php 
session_start();

auth_use();

if (empty($_SESSION[ SYSTEM_NAME . '_token'])) {
  $_SESSION[ SYSTEM_NAME . '_token'] = bin2hex(random_bytes(33));
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">


  <base href="<?php echo DIRECTORY ; ?>">
  <title><?php  echo DISPLAY_NAME; ?></title>

  <link rel="apple-touch-icon" sizes="57x57" href="assets/images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="assets/images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
  <link rel="manifest" href="assets/images/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">


  <meta name="csrf-token" content="<?php echo $_SESSION[ SYSTEM_NAME . '_token']; ?>">
  <meta name="to-dest" content="<?php if(isset($_SESSION['TO'])) echo $_SESSION['TO']; ?>">



  
  <!-- Bootstrap 4.0-->
  <link rel="stylesheet" href="assets/components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Bootstrap 4.0-->
  <link rel="stylesheet" href="assets/components/bootstrap/dist/css/bootstrap-extend.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="admin/css/master_style.css">

  <link rel="stylesheet" href="admin/css/skins/_all-skins.css">	

    	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
.login-box {
  color: white !important;
}
.login-a>b{
  padding-right: 5px  ;
}
.login-box {
  margin: 2% auto  ; 
  width: 450px  ;
}
.login-b {  
  font-size: 25px  ;
}
.login-c { 
  font-size: 18px  ;
}
footer {
  margin-left: 0px !important;
  position: absolute;
  bottom: 0;
  height: 45px;
  width: 100%;
}
</style>
</head>
<body class="hold-transition login-page">
  <div class="login-box" >
    <div class="login-logo" style=" background: rgba(0, 0, 0, 0.54); padding: 10px; ">  
      <a  class="login-a" ><b><?php  echo DISPLAY_NAME; ?></b></a>
      <p class="login-b" > <small> <?php  echo DISPLAY_TEAM; ?> GYM LOGIN</small> </p>
      <p class="login-c" > <small><?php  echo DISPLAY_COLLEGE_NAME; ?></small> <span>, <?php  echo DISPLAY_COLLEGE_LOC; ?></span></p>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="plzValidateThisFormMe" method="post" class="form-element">
        <div class="form-group has-feedback">
          <input name="username" type="email" class="form-control" placeholder="Username">
          <span class="ion ion-email form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input name="password" type="password" class="form-control" placeholder="Password">
          <span class="ion ion-locked form-control-feedback"></span>
        </div>
        <div class="nowDosSh"  >

        </div>
        <div class="row">
          <div class="col-6">
           <?php 
           if(false){
             ?>
             <div class="checkbox">
               <input type="checkbox" id="basic_checkbox_1" >
               <label for="basic_checkbox_1">Remember Me</label>
             </div>
             <?php
           }
           ?>
         </div>
         <!-- /.col -->
         <div class="col-6">
           <div class="fog-pwd text-right">
             <a href="javascript:void(0)"><i class="ion ion-locked"></i> Forgot pwd?</a><br>
           </div>
         </div>
         <!-- /.col -->
         <div class="col-12 text-center">
          <button type="submit" class="btn btn-info btn-block margin-top-10">SIGN IN</button>
        </div>
        <!-- /.col -->
      </div>
    </form>



  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->




<footer class="main-footer">
  <div class="pull-right d-none d-sm-inline-block">

  </div>
  &copy;  <a href="<?php echo TERMS__CONDITIONS_URL; ?>"><?php echo TERMS__CONDITIONS; ?></a>. All Rights Reserved.
</footer>



<!-- jQuery 3 -->
<script src="assets/components/jquery/dist/jquery.min.js"></script>

<!-- popper -->
<script src="assets/components/popper/dist/popper.min.js"></script>

<!-- Bootstrap 4.0-->
<script src="assets/components/bootstrap/dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="admin/js/pages/jquery.validate.min.js"></script>


<!-- toast -->



<script type="text/javascript">
  $(document).ready(function(){ 

    var localusername = null;

    var config = {
      headers : {
        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
        'X-Requested-With': 'XMLHttpRequest',   
        'CsrfToken': $('meta[name="csrf-token"]').attr('content')
      }
    }





    // $('#join_date').datepicker({
    //   format: 'dd-mm-yyyy',
    //   endDate: '1d',
    //   startDate: '-10d'
    // });




    $("#plzValidateThisFormMe").validate({
      rules: {
        username: {
          required: true,
          email: true
        }, 
        password: {
          required: true,
          minlength: 6,
        }, 
      },
      messages: { 
        password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },
        username: "Please enter a valid email address"
      },
      submitHandler: function(form, event){  





        var dataString =   {action:'login-2', 
        username:form.username.value, 
        password: form.password.value
      };
      
      $.ajax({
       url: 'root/login.php',
       type: 'POST',
       data:  jQuery.param(dataString)  ,
       dataType: 'JSON',
       headers : {
        'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
        'X-Requested-With': 'XMLHttpRequest',   
        'CsrfToken': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response, textStatus, jqXHR) {
       $('#alterMepassword').addClass('animated zoomOut');
       // response =$.parseJSON(response);
       if(response.success == 0){

       } else if(response.success  == -2){    
        $('.nowDosSh').html('  <div id="alterMepassword" class="alert alert-danger alert-dismissable animated    "  >'+
         ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <p>' + response.remark  + '</p></div>');

        $('#alterMepassword').addClass('animated zoomIn');
      } else if(response.success  == 1){  
       $('#alterMepassword').addClass('animated zoomOut');

       localStorage.localusername = form.username.value;
       $toThe  = $('meta[name="to-dest"]').attr('content');

       if (typeof $toThe === "undefined") {
         location.href=".";
       } else {
        location.href= $toThe;
      }
    }
  },
  error: function(jqXHR, textStatus, errorThrown){
    console.log('Error');
    console.log(jqXHR, textStatus, errorThrown);
  }
});








    }
  });






  });
</script>

</body>

</html>
