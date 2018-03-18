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


    if(isset($_POST['gotonext'])){

      $stmnt  = 'update subscriber set class_id = :area_name where email = :area_id';
      $params = array(
        ':area_name' => $_POST['id'], 
        ':area_id'  =>  $_SESSION['userid']
      );
      $istrue = $db->execute_query($stmnt, $params);
      if ($istrue) {
        echo '<script type="text/javascript">location.href="dashbord.php"</script>';
      }



    }






    $stmnt='select * from gym_class where delete_status = 0';


    $result = $db->display($stmnt);





    ?>
    <!-- Main Banner area-->

    <!-- Start feature classes area -->

    <div class="pricing" id="pricing" >
      <h2 class="section-title-default title-bar-high">Choose your Class First</h2>
      <div class="container">
       <div class="row">


        <?php

        if($result)
          foreach ($result as $key => $value) {
            echo '

            <div class="col-lg-3 col-md-3 col-lg-3 col-md-3 wow flipInY" data-wow-delay="0.8s">
            <div class="package">
            <h4>' . $value['class_name'] . '</h4>
            <h1>' . $value['amount'] . '</h1>
            <b>Monthly</b>
            <form action="" method="post">

            <input type="hidden" name="id" value="' . $value['id'] . '">
            <button class="btn btn-success" type="submit" name="gotonext" value="go">Get Started</button>


            </form>

            </div>
            </div>


            ';


          }

          ?>



        </div>
      </div>
    </div>
    <!-- end pricing -->

    <!-- End feature product area -->

    <


    <?php

    include_once('footer.php');

    ?>