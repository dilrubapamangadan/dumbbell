     <?php

     include_once('header.php');

     ?>



     <!-- End Header area -->
     <!-- Main Banner area -->
     <div class="main-banner slider-top-space-header4 ">
      <img src="img/slides/4-1.jpg" alt="image" class="img-responsive" />
      <div class="main-banner-inner" >
               <!-- <div >
                   <!--                search box    
                    
                   -->



                   <div class="button" style="margin-top:20px;"><a href="login.php" class="btn custom-button" data-title="Join With Us">Sign In</a></div>

                   <div class="button" style="margin-top:20px;"><a href="register.php" class="btn custom-button" data-title="Join With Us">Join With Us</a></div>
                   <br/>
                   <a href="../admin"> login as admin </a>
                   <a style="padding-left: 30px;" href="../gym"> login as gym </a>
                   <ul class="main-banner-link" style="padding-top: 30px;">
                    <li>
                      <a class="facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    </li>
                    <li>
                      <a class="twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <li>
                      <a class="linkedin" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </li>
                    <li>
                      <a class="skype" href="#"><i class="fa fa-skype" aria-hidden="true"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- Main Banner area-->

              <!-- Start feature classes area -->

              <!-- pricing -->
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
        <div class="pricing" id="pricing" >
         <h2 class="section-title-default title-bar-high">Choose your Classes</h2>
         <div class="container">
           <div class="row">


             <div class="col-lg-3 col-md-3 col-lg-3 col-md-3 wow flipInY" data-wow-delay="0.8s">
              <div class="package">
                <h4>Bronze</h4>
                <h1>9.99</h1>
                <b>Monthly</b>
                <p>Lorem Ipsum passages, and more recently with desktop</p>
                <hr>
                <li>100 Users</li>
                <li>SSL Certificate</li>
                <li>Online Support</li>
                <li>300GB Disckspace</li>
                <li>100 Email Address</li>
                <li>MySQL Database</li>
                <button class="btn btn-success">Get Started</button>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-lg-3 col-md-3 wow flipInY" data-wow-delay="0.8s">
              <div class="package">
                <h4>Silver</h4>
                <h1>19.99</h1>
                <b>Monthly</b>
                <p>Lorem Ipsum passages, and more recently with desktop</p>
                <hr>
                <li>100 Users</li>
                <li>SSL Certificate</li>
                <li>Online Support</li>
                <li>300GB Disckspace</li>
                <li>100 Email Address</li>
                <li>MySQL Database</li>
                <button class="btn btn-success">Get Started</button>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-lg-3 col-md-3 wow flipInY" data-wow-delay="0.8s">
              <div class="package">
                <h4>Gold</h4>
                <h1>29.99</h1>
                <b>Monthly</b>
                <p>Lorem Ipsum passages, and more recently with desktop</p>
                <hr>
                <li>100 Users</li>
                <li>SSL Certificate</li>
                <li>Online Support</li>
                <li>300GB Disckspace</li>
                <li>100 Email Address</li>
                <li>MySQL Database</li>
                <button class="btn btn-success">Get Started</button>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-lg-3 col-md-3 wow flipInY" data-wow-delay="0.8s">
              <div class="package">
                <h4>Premium</h4>
                <h1>39.99</h1>
                <b>Monthly</b>
                <p>Lorem Ipsum passages, and more recently with desktop</p>
                <hr>
                <li>100 Users</li>
                <li>SSL Certificate</li>
                <li>Online Support</li>
                <li>300GB Disckspace</li>
                <li>100 Email Address</li>
                <li>MySQL Database</li>
                <button class="btn btn-success">Get Started</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end pricing -->

      <!-- End feature product area -->



      <!-- Start Expert trainers area -->
      <div class="cities">
       <div class="container">
         <h2 class="wow fadeInUp">We are availiable at</h2>
         <div class="row">

          <div class="col-lg-3 col-md-3 wow fadeInLeft" data-wow-delay="2s">
            <img src="img/kochi.jpg" class="img-circle" alt="">

            <p><b>Kochi</b></p>

          </div>
          <div class="col-lg-3 col-md-3 wow fadeInLeft" data-wow-delay="2s">
            <img src="img/Chennai.jpg" class="img-circle" alt="">
            <p><b>Chennai</b></p>

          </div>
          <div class="col-lg-3 col-md-3 wow fadeInLeft" data-wow-delay="2s" >
            <img src="img/hyderbad.jpg" class="img-circle" alt="">    
            <p><b>Hyderabad</b></p>

          </div>
          <div class="col-lg-3 col-md-3 wow fadeInLeft" data-wow-delay="2s">
            <img src="img/delhi.jpg" class="img-circle" alt="">
            <p><b>Delhi</b></p>

          </div>
        </div>
      </div>
    </div>
    <!-- End Expert tainers area -->

    <!-- Start Contact page area -->
    <div class="contact" id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <form class="form-horizontal contact-form" id='contact-form' role="form">
              <fieldset>
                <!-- Form Name -->
                <legend>Contact Form</legend>
                <!-- Text input-->
                <div class="form-group wow fadeInUp" data-wow-delay="1.8">
                  <label class="control-label pull-left" for="textinput1"><i class="fa fa-user" aria-hidden="true"></i></label>
                  <div class="media-body">
                    <input id="form-name" name="textinput" placeholder="Name" class="form-control input-md" type="text" data-error="Name field is required" required>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <!-- Text input-->
                <div lass="form-group wow fadeInUp" data-wow-delay="2" >
                  <label class="control-label pull-left" for="textinput2"><i class="fa fa-envelope-o" aria-hidden="true"></i></label>
                  <div class="media-body">
                    <input id="form-email" name="textinput" placeholder="E-mail" class="form-control input-md" type="text" data-error="E-mail field is required" required>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <!-- Text input-->
                <div lass="form-group wow fadeInUp" data-wow-delay="2.2">
                  <label class="control-label pull-left" for="textinput3"><i class="fa fa-phone" aria-hidden="true"></i></label>
                  <div class="media-body">
                    <input id="form-phone" name="textinput" placeholder="Phone" class="form-control input-md" type="text" data-error="Phone field is required" required>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <!-- Textarea -->
                <div lass="form-group wow fadeInUp" data-wow-delay="2.4">
                  <label class="control-label arealebel pull-left" for="textarea"><i class="fa fa-envelope" aria-hidden="true"></i></label>
                  <div class="media-body">
                    <textarea class="textarea form-control" id="form-message" name="textarea" placeholder="Message" data-error="Message field is required" required></textarea>
                    <div class="help-block with-errors"></div>
                  </div>
                </div>
                <!-- Button -->
                <div lass="wow fadeInUp" data-wow-delay="2.6">
                  <div>
                    <button type="submit" class="btn-read-more-fill btn-send">Send</button>
                  </div>
                </div>
                <div class='form-response'></div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End Contact page area -->

    <?php

    include_once('footer.php');

    ?>