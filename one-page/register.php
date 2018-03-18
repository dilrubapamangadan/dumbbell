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
        echo '<script type="text/javascript">location.href="one-page/dashbord.php"</script>';
      }
      
    }


    if( isset($_POST['registration'])){
     

      $email      = $_POST['email'];
      $name         = $_POST['name'];
      $password      = md5($_POST['password']);
      $number = $_POST['number'];

      $sql = 'select * from subscriber where email = :username';
      $params = array(':username'=>$email);
      if( !$db->display($sql, $params) ){

        $stmnt  = 'insert into subscriber (email,name,password,mobile, login)
        values(:email,:name,:password,:mobile, :login)';
        $params = array(
          ':email' => $email,
          ':name' => $name,
          ':password' => $password,
          ':mobile' => $number,
          ':login'  =>  1
        );
        if ($db->execute_query($stmnt, $params)) {
          $message = '<div class="alert alert-success">Successfully registered!Please login!</div>';
        } 
      } else {
        $message = '<div class="alert alert-danger">Username already exist!Please choose another username</div>';
      }




    }



    ?>


    <div class="contact" id="contact" style="margin-top: 30px;">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-md-offset-3 col-sm-12">
            <form class="form-horizontal contact-form"  role="form" method="post" action="" style="padding-top: 160px;">
              <fieldset>
                <!-- Form Name -->
                <legend>Login Registration</legend>
                <!-- Text input-->

                <!-- Text input-->
                <div lass="form-group wow fadeInUp" data-wow-delay="2" >
                  <label class="control-label pull-left" for="textinput2"><i class="fa fa-user" aria-hidden="true"></i></label>
                  <div class="media-body">
                    <input id="form-name" name="name" placeholder="name" class="form-control input-md" type="text" data-error="name field is required" required>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <!-- Text input-->
                <div lass="form-group wow fadeInUp" data-wow-delay="2" >
                  <label class="control-label pull-left" for="textinput2"><i class="fa fa-envelope-o" aria-hidden="true"></i></label>
                  <div class="media-body">
                    <input id="form-email" name="email" placeholder="E-mail" class="form-control input-md" type="text" data-error="E-mail field is required" required>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>

                <div lass="form-group wow fadeInUp" data-wow-delay="2.2">
                  <label class="control-label pull-left" for="textinput3"><i class="fa fa-phone" aria-hidden="true"></i></label>
                  <div class="media-body">
                    <input id="form-phone" name="number" minlength="10" maxlength="10" placeholder="Phone" class="form-control input-md" type="text" data-error="Phone field is required" required>
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


                <a href="login.php"> login</a>
                <br/>
                <?php  

                echo show_error ($message); ?>
                <!-- Button -->
                <div lass="wow fadeInUp" data-wow-delay="2.6">
                  <div>
                    <button type="submit" class="btn-read-more-fill btn-send"  value="go" name="registration">go</button>
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