

<form action ="login.php" method="post"  style="display: none;" id="gotodis">
  <input type="hidden" name="latitude" id="latitude">
  <input type="hidden" name="longitude" id="longitude"> 
</form>
<!-- Start footer Area -->
<footer>
  <div class="footer-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="about-company">
            <h3>About Company</h3>
            <p>Praesent vel rutrum purus. Nam vel dui eu risus duis dignissim dignissim. Suspen disse at eros tempus, congueconsequat.Fusce sit amet urna feugiat.Praesent vel rutrum purus. Nam vel dui eu risus.</p>
            <div class="social-icons">
              <ul class="social-link">
                <li class="first">
                  <a class="facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>
                <li class="second">
                  <a class="twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li class="third">
                  <a class="linkedin" href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </li>
                <li class="fourth">
                  <a class="pint" href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                </li>
                <li class="five">
                  <a class="skype" href="#"><i class="fa fa-skype" aria-hidden="true"></i></a>
                </li>
                <li class="last">
                  <a class="youtube" href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
  <!-- End footer Area -->
  <!-- Start copyright area -->
  <div class="cards">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
          <div class="copy-right">
            <p>© Copyrights banana 2018. All rights reserved. Designed by banana<a href="https://www.banana.com/"> Team Banana</a></p>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="visa-card">
            <ul>
              <li>
                <a href="#"><img src="img/visa-card.png" alt="visa-card"></a>
              </li>
              <li>
                <a href="#"><img src="img/descover.png" alt="descover"></a>
              </li>
              <li>
                <a href="#"><img src="img/paypal.png" alt="paypal"></a>
              </li>
              <li>
                <a href="#"><img src="img/card.png" alt="card"></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- End copyright area -->
</div>
<!-- End wrapper -->
<a href="#" class="scrollToTop"></a>
    <!-- jquery
      ============================================ -->
      <script src="js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
      ============================================ -->
      <script src="js/bootstrap.min.js"></script>
      <script src="js/bootstrap-tabcollapse.js"></script>
    <!-- meanmenu JS
      ============================================ -->
      <script src="js/jquery.meanmenu.min.js"></script>
    <!-- Owl Cauosel JS 
      ============================================ -->
      <script src="vendor/OwlCarousel/owl.carousel.min.js" type="text/javascript"></script>
    <!-- Nivo slider js
      ============================================ -->
      <script src="css/custom-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
      <script src="css/custom-slider/home.js" type="text/javascript"></script>
    <!-- Zoom JS
      ============================================ -->
      <script src="js/jquery.zoom.js"></script>
    <!-- Isotope JS
      ============================================ -->
      <script src="js/isotope.pkgd.js"></script>
    <!-- Counter Up JS
      ============================================ -->
      <script src="js/waypoints.min.js"></script>
      <script src="js/jquery.counterup.min.js"></script>
    <!-- Magic Popup js 
      ============================================-->
      <script src="js/jquery.magnific-popup.min.js" type="text/javascript"></script>
    <!-- Wow JS
      ============================================ -->
      <script src="js/wow.min.js"></script>
    <!-- One Page menu action JS
      ============================================ -->
      <script src="js/jquery.nav.js"></script>
    <!-- plugins JS
      ============================================ -->
      <script src="js/plugins.js"></script>
      <!-- Google Map js -->
      <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgREM8KO8hjfbOC0R_btBhQsEQsnpzFGQ"></script> -->
    <!-- Validator js 
      ============================================ -->
      <script src="js/validator.min.js" type="text/javascript"></script>
    <!-- main JS
      ============================================ -->
      <script src="js/main.js"></script>

<!-- 
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsp1WqZjtOViQmJ2HbswctGzguIGgVijA&libraries=places&callback=initMap"
      async defer></script>
    -->
      

      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCR-KEWAVCn52mSdeVeTqZjtqbmVJyfSus&libraries=places&callback=initMap"
      async defer></script>

      <script type="text/javascript" src="../admin/js/pages/jquery.validate.min.js"></script>



      <script>


        var localusername = null;

        var config = {
          headers : {
            'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
            'X-Requested-With': 'XMLHttpRequest',   
            'CsrfToken': $('meta[name="csrf-token"]').attr('content')
          }
        }





      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13
        }); 
        var input = document.getElementById('pac-input'); 


        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });


        google.maps.event.addListener(marker,'click',function() {


          console.log(marker.getPosition());
        });


        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }



          var a = place.geometry.location.lat();
          var b = place.geometry.location.lng(); 
          var pyrmont = {lat: a, lng: b};
          console.log(a, b);


          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }


          createMarker(place);


          infowindow = new google.maps.InfoWindow();
          var service = new google.maps.places.PlacesService(map);
          service.nearbySearch({
            location:  pyrmont ,
            radius: 10000,
            type: ['gym']
          }, callback);


          function callback(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
              for (var i = 0; i < results.length; i++) {

                iflocation = results[i] ;


               // createMarker( iflocation );
               var latitude = iflocation.geometry.location.lat();
               var longitude = iflocation.geometry.location.lng();

               console.log(latitude, longitude);




               var dataString =   {action:'check-loc', 
               latitude: latitude, 
               longitude: longitude,
               temp: i
             };
             console.log(dataString);
             $.ajax({
              url: '../root/ajax2.php',
              type: 'POST',
              data:  jQuery.param(dataString)  ,
              dataType: 'JSON',
              headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
                'X-Requested-With': 'XMLHttpRequest',   
                'CsrfToken': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(response, textStatus, jqXHR) { 
               console.log(response);
       // response =$.parseJSON(response);

       // console.log(response.remark.longitude);
       if(response.success == 0){

       } else if(response.success  == -2){    

       } else if(response.success  == 1){  

        var aa = {lat: response.remark.longitude , lng: response.remark.latitude };
        var GB = response.remark.temp;
        console.log(GB);
        createMarker( results[GB] );


      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      console.log('Error');
      console.log(jqXHR, textStatus, errorThrown);
    }
  });





           }





         }
       }











    // $('#join_date').datepicker({
    //   format: 'dd-mm-yyyy',
    //   endDate: '1d',
    //   startDate: '-10d'
    // });














    function createMarker(place) {
      var placeLoc = place.geometry.location;
      var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location
      });

      google.maps.event.addListener(marker, 'click', function() {

        console.log(marker);

             // createMarker( iflocation );
             var latitude = marker.position.lat();
             var longitude = marker.position.lng();

             console.log(latitude, longitude);

             $('#latitude').val(latitude);
             $('#longitude').val(longitude);

             $('#gotodis').submit();
             infowindow.setContent(place.name);
             infowindow.open(map, this);
           });









    }






  });




        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.




        google.maps.event.addListener(map, "click", function (e) {

    //lat and lng is available in e object
    var latLng = e.latLng;

    console.log(e);

  });



        document.getElementById('use-strict-bounds')
        .addEventListener('click', function() {
          console.log('Checkbox clicked! New state=' + this.checked);
          autocomplete.setOptions({strictBounds: this.checked});
        });
      }




    </script>


    <script src="js/cust.js"></script>
  </body>


  <!-- Mirrored from radiustheme.com/demo/html/gymedge/one-page/index4.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Mar 2018 21:20:48 GMT -->
  </html>
