     <?php

     include_once('header.php');


     if(isset($_POST['latitude']) && isset($_POST['longitude'])){
      $_SESSION['latitude'] = $_POST['latitude'];
      $_SESSION['longitude'] = $_POST['longitude'];
    }



    $db=new Database();
    $error='';



    $message = array(null, null);





    if( isset( $_SESSION['userid'] ) ) {
      if( $_SESSION['type'] == '1' ) {
        header('Location: ' . PATH . '/admin');
      }         
      if( $_SESSION['type'] == '2' ) {
        header('Location: ' . PATH . '/gym' );
      }         
      if($_SESSION['type'] == '3'){
        echo '<script type="text/javascript">location.href="dashbord.php"</script>';
      }
      
    }



    if( isset($_POST['login'])){



      $username = $_POST['email'];
      $password = $_POST['password'];
      print_r($_POST);
      $stmnt='select * from subscriber where email = :username and password = :password';
      $params=array( 
       ':username'  =>  $username,
       ':password'  =>  md5($password)
     );
      if($db->display($stmnt,$params)){

        $_SESSION['userid']=$username;
        $_SESSION['type']='3';
        header('Location: dashbord.php');
        exit();
      }else{


        $message [0] = 4;
        $message [1] = 'Incorrect username or password ';  



      }



    }



    ?>


    <div class="contact" id="contact" style="margin-top: 30px;">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-md-offset-3 col-sm-12">
            <form class="form-horizontal contact-form" id='' role="form" method="post" action="" style="padding-top: 160px;">
              <fieldset>
                <!-- Form Name -->
                <legend>Login Form</legend>
                <!-- Text input-->

                <!-- Text input-->
                <div lass="form-group wow fadeInUp" data-wow-delay="2" >
                  <label class="control-label pull-left" for="textinput2"><i class="fa fa-envelope-o" aria-hidden="true"></i></label>
                  <div class="media-body">
                    <input id="form-email" name="email" placeholder="E-mail" class="form-control input-md" type="text" data-error="E-mail field is required" required>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <!-- Text input-->
                <div lass="form-group wow fadeInUp" data-wow-delay="2.2">
                  <label class="control-label pull-left" for="textinput3"><i class="fa fa-key" aria-hidden="true"></i></label>
                  <div class="media-body">
                    <input id="form-phone" name="password" placeholder="Password" class="form-control input-md" type="password" data-error="Phone field is required" required>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>

                <a href="register.php"> new user ?</a>



                <?php echo show_error ($message); ?>
                <!-- Button -->
                <div lass="wow fadeInUp" data-wow-delay="2.6">
                  <div>
                    <button type="submit" class="btn-read-more-fill btn-send"  value="go" name="login">go</button>
                  </div>
                </div>
                <div class='form-response'></div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>


    <?php

    include_once('footer.php');

    ?>