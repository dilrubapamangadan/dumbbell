var admin_app = angular.module( 'app-admin',
	['ngRoute', 'ngAnimate', 'ngProgressLite', 'toastr', 'dcbImgFallback', 'ngtimeago', '720kb.datepicker', 'ngImgCrop', 'xeditable', 'simpleGrid',
	'google.places'  ]	); 

var token = angular.element( document.querySelector( 'meta[name="csrf-token"]' ) );


var config = {
	headers : {
		'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
		'X-Requested-With': 'XMLHttpRequest',		
		'CsrfToken': token.attr('content')
	}
}


admin_app.config([ '$routeProvider', '$locationProvider', function( $routeProvider, $locationProvider ) {
	$routeProvider
	.when('/admin-dashboard', {
		templateUrl: 'admin/pages/home.html',
		controller: 'admin_appController0'
	}) 
	.when('/admin-profile', {
		templateUrl: 'admin/pages/profile.html',
		controller: 'admin_appControllerProfile'
	})  
	.when('/admin-settings', {
		templateUrl: 'admin/pages/settings.html',
		controller: 'admin_appControllerSettings'
	})  
	
	.when('/admin-class', {
		templateUrl: 'admin/pages/class.html',
		controller: 'admin_appControllerClass'
	})  
	
	.when('/admin-gym-add', {
		templateUrl: 'admin/pages/admin-gym-add.html',
		controller: 'admin_appControllerAdminGymAdd'
	})  
	
	.when('/admin-gym-view', {
		templateUrl: 'admin/pages/admin-gym-view.html',
		controller: 'admin_appControllerAdminGymView'
	})  
	.when('/admin-gym-single', {
		templateUrl: 'admin/pages/admin-gym-single.html',
		controller: 'admin_appControllerAdminGymVSingle'
	})   

	.otherwise({
		redirectTo: '/admin-dashboard'
	});

	$locationProvider.html5Mode({
		enabled: true,
		requireBase: false
	});

}]);

admin_app.run( function($rootScope, ngProgressLite,  $location, $timeout) {

	$rootScope.$on('$routeChangeStart', function() {
		ngProgressLite.start();
	});

	$rootScope.$on('$routeChangeSuccess', function() {
		ngProgressLite.done(); 
	});


});

admin_app.run(function(editableOptions, editableThemes) {
	editableThemes.bs3.inputClass = 'input-sm';
	editableThemes.bs3.buttonsClass = 'btn-sm';
	editableOptions.theme = 'bs3';
});

/*==================================================>>======================================================*/



// admin_app.directive('showTab',
// 	function () {
// 		return {
// 			link: function (scope, element, attrs) {
// 				element.bind('click', function(e) {
// 					e.preventDefault();
// 					$(element).tab('show');
// 				})

// 			}
// 		};
// 	});



admin_app.service('myservice', function() {
	this.value = null;
	this.name = null;
});

admin_app.config(function(toastrConfig) {
	angular.extend(toastrConfig, {
		allowHtml: false,
		closeButton: false,
		closeHtml: '<button>&times;</button>', 
		timeOut: 7500,
		titleClass: 'toast-title',
		toastClass: 'toast'
	});
});
function pushMe($baseArr, $newArr) { 
	angular.forEach($baseArr, function(value, newKey) { 
		for (var key in $newArr) { 
			if (key === 'length' || !$newArr.hasOwnProperty(key) ) continue; 
			if( !($newArr[key] === undefined ||$newArr[key] === null ) )
				$baseArr[key] = $newArr[key]; 		
		} 
	});
}








admin_app.controller( 'SystemControllerBoady',  function($timeout, $location, $scope, $http , $window){ 
	$scope.exit =  function(){ 
		$window.location.href = 'exit';
	}



	//$scope.networkIcon = network.actual ? 'assets/img/networkicons/' + network.actual + '.png' : 'assets/img/networkicons/default.png';
	$scope.baseuser = {
		name: "user name",
		email: null,
		image: 'assets/images/default/image.png'

	}

	$scope.authentication = {username : null,
		lockscreen: null,
		password: null,
		isLock: false,
		invalidPassword: false,
		remark: "test"
	}; 

	$scope.logDataMin = [];

	$timeout( function(){




		var data = $.param({
			action: 'get-profile-basic' 
		});	

		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) { 
			response = userAuthenticationAgent($scope, response);

			if(! (response === null || response === undefined) )

				if(response.status == 3) { 
					$scope.baseuser = {
						name: response.data.name ,
						email: response.data.email ,
						image: response.data.image
					} 
				} else if(response.status == 2) {
					toastr.error( response.message );				
				} else {
					toastr.info( response.message );


				}

			}, function myError(response) { 
				console.log(response);
			});






	}, 9);


	$scope.lockLogin = function() {


		var data = $.param({ 
			action:'login-1', 
			username: $scope.authentication.username, 
			password: $scope.authentication.password
		});	

		$http.post("root/login.php", data, config)
		.then(function mySuccess(response) { 
			response = userAuthenticationAgent($scope, response); 
			if(response.status == -2) {
				$scope.authentication.invalidPassword = true; 
			}

		}, function myError(response) { 
			console.log("Error");
		});
	}


});






admin_app.controller( 'admin_appControllerProfile', function($timeout, $location, $scope, $http, $window, toastr){ 
	doCheckUser($scope, $http);


// iamge edit rpev start
$scope.size='big';
$scope.type='square';
$scope.imageDataURI='';
$scope.resImageDataURI='data:image/png;base64,iVBORw';
$scope.resImgFormat='image/png';
$scope.resImgQuality=1;
$scope.selMinSize=50;
$scope.resImgSize=300;
$scope.enableCrop=false;

$scope.logLimit = 30;
$scope.logOffset = 0;
$scope.logData = [];
$scope.moreLogR = true;
$scope.isLoadingLog = false;
	//  image edit rpev end 

	//  profile user start
	$scope.profile = [];
	$scope.profile = {
		name: null, 
		email: null,
		phone: null,
		image: null
		
	}
	// profile uer  end 



	$scope.adminProfileSubmit = () => {
		console.log($scope.profile); 


		var data = $scope.profile;
		pushMe(data, {action: 'set-profile' }); 
		var data = $.param(data); 

		$http.post("root/ajax.php", data, config).then(function mySuccess(response) { 
			response = userAuthenticationAgent($scope, response);
			// console.log(response);
			if(response.status == 1) {


				toastr.success( response.message );
			} else if(response.status == 2) {
				toastr.error( response.message);				
			} else {
				toastr.info( response.message);


			}



			console.log(response);

		}, function myError(response) { 
			console.log(response);
		});


		pushMe($scope.$parent.baseuser, {
			name: $scope.profile.name ,
			email: $scope.profile.email
		} );

	}

	$scope.openSocialNewTab = (locat) => {
		$window.open(locat, '_blank');
	}


	$scope.$watch('profile.image', function() {
		pushMe($scope.$parent.baseuser, {image: $scope.profile.image } );
	});

	var handleFileSelect=function(evt) {
		console.log( ($scope.enableCrop + '').length );
		console.log($scope.enableCrop);

		if(($scope.enableCrop + '').length > 2){
			$scope.enableCrop=true;
		}

		var file=evt.currentTarget.files[0];
		var reader = new FileReader();
		reader.onload = function (evt) {
			$scope.$apply(function($scope){
				$scope.imageDataURI=evt.target.result;
			});
		};
		reader.readAsDataURL(file);
	};
	angular.element(document.querySelector('#fileInputM')).on('change',handleFileSelect);
	$scope.$watch('resImageDataURI',function(){
	          //console.log('Res image', $scope.resImageDataURI);
	      });



	$scope.fileNameChanged = () => {

	}

	$scope.doneImageCrop = () => {  
		fvb =  angular.element( document.querySelector( '#opImageSrc' ) ); 

		$scope.imageDataURI = '';
		$scope.enableCrop= false;



		var data = $.param({
			action: 'update-dp' ,
			data: fvb.attr('src')
		});	 
		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) { 
			response = userAuthenticationAgent($scope, response);
			// console.log(response);
			if(! (response === null || response === undefined) )

				if(response.status == 1) { 

					pushMe( $scope.profile, { image: response.data});

				} else if(response.status == 2) {
					toastr.error( response.message );				
				} else {
					toastr.info( response.message );


				}

			}, function myError(response) { 
				console.log(response);
			});




	}


	$scope.clearImageNow = function (){
		$scope.imageDataURI = '';
		$scope.enableCrop= false;
	}


	$scope.uploadImgTriggen = function(){
		setTimeout(function() {
			document.getElementById('fileInputM').click()        
		}, 0);
	}




	$scope.reformatDate = (dateStr) =>  {
		dArr = dateStr.split("-"); 
		return dArr[2]+ "-" +dArr[1]+ "-" +dArr[0] ;  
	}

	$scope.moreLogs = () => {

	}

	$timeout( function(){

		var data = $.param({
			action: 'get-profile' 
		});	

		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) { 
			response = userAuthenticationAgent($scope, response);
			// console.log(response);

			if(! (response === null || response === undefined) )

				if(response.status == 3) {
					$scope.profile = response.data;
					pushMe ($scope.profile , {phone: parseInt(response.data.phone) , landline: parseInt(response.data.landline) } );

				} else if(response.status == 2) {
					toastr.error( response.message );				
				} else {
					toastr.info( response.message );


				}

			}, function myError(response) { 
				console.log(response);
			});




		$scope.logLimit = 100;
		$scope.logOffset = 0;

	},1);
});




admin_app.controller( 'admin_appControllerSettings', function($timeout, $scope, $http, $location, $filter, myservice, toastr){
	doCheckUser($scope, $http);

	//  new variable xxx xzzz 
	$scope.login = { repassword: null,
		newpassword: null};




	//  password change new password

	$scope.$watch( 'login.repassword', function(newdata) {		
		$scope.misMPassword = null; 
		var a =	$scope.login.repassword ;
		var b = $scope.login.newpassword ;
		if ( a && b) 
			if (a != b) { 
				$scope.misMPassword = "Password mismatch";
				$scope.adminLogin.repassword.$invalid = true;
				$scope.adminLogin.$invalid = true;
			}
		});



	$scope.$watch( 'login.newpassword', function(newdata) {		
		$scope.misMPassword = null; 
		var a =	$scope.login.repassword ;
		var b = $scope.login.newpassword ;
		if ( a && b) 
			if (a != b) { 
				$scope.misMPassword = "Password mismatch";
				$scope.adminLogin.repassword.$invalid = true;
				$scope.adminLogin.$invalid = true;
			}
		});


	$scope.$watch( 'login.password', function(newdata) {	
		$scope.errorPassword = null;

	});



	$scope.$watch( 'login.newpassword', function(newdata) {	 
		$scope.errorNewPassword = null;
	});

	$scope.adminLoginSubmit = function () {


		if ($scope.login.newpassword != $scope.login.repassword) { 
			$scope.misMPassword = "Password mismatch";
			$scope.adminLogin.repassword.$invalid = true;
			$scope.adminLogin.$invalid = true;			 
			return;
		}



		var exdata = {
			action: 'update-login', 
			password: $scope.login.password,
			newpassword: $scope.login.repassword
		}
		var data = $.param(exdata);	



		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) { 
			response = userAuthenticationAgent($scope, response);
			console.log(response); 

			success = response.status;	
			if(success == 1){


				toastr.success( 'successfully updated' ); 


				$scope.login = {dname: "test"};
			}

			if(success == 2){ 
				$scope.errorPassword = response.message;
				$scope.adminLogin.password.$invalid = true;
				$scope.adminLogin.$invalid = true;		

			}

			if(success == 21){ 
				$scope.errorNewPassword = response.message;
				$scope.adminLogin.newpassword.$invalid = true;
				$scope.adminLogin.$invalid = true;		

			}

			if(success == 0){  
				toastr.error('make sure that all details are correct, or refresh' ); 
			}





		}, function myError(response) { 
			console.log(response);
		});





	}

// password change end end end 

$timeout( function(){





},3);
});













admin_app.controller( 'admin_appControllerClass', function($timeout, $scope, $http, $location, $filter, $log, myservice, toastr){
	doCheckUser($scope, $http);
	









	// add new category


	$scope.gymClassSubmit = () => {



		var exdata = {
			action: 'add-category',
			name: $scope.class.name,
			weigh: $scope.class.weigh,
			remark: $scope.class.remark
		}
		var data = $.param(exdata);

		console.log(data);

		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) {
			response = userAuthenticationAgent($scope, response);
			//console.log(response);

			success = response.status;
			if(success == 1){

				toastr.success( 'successfully added' );
				$scope.category = null;
				var c = $scope.data.length + 1;
				var item = response.data;
				$scope.class = null;
				$scope.data.splice(0, 0, item);
				console.log($scope.data);
			} else if(success == 11){

				toastr.warning( response.message );

			}

			if(success == 2){

			}


			if(success == 0){
				toastr.error('make sure that all details are correct, or refresh' );
			}





		}, function myError(response) {
			console.log(response);
		});



	}
















	$scope.gridConfig = {
		options: {
			showEditButton: true,
			editRequested: function (row) { console.log('edit request:', row); 	updateMe(row); },

                    //orderBy: 'age',
                    //reverseOrder: false,
                    editable: true, // true is the default - set here manually to true to make it easier to bind to in the demo html
                    disabled: false,
                    perRowEditModeEnabled: true,
                    allowMultiSelect: false,
                    pageSize: 4,
                    pageNum: 0,
                    dynamicColumns: true,
                    columns: [
                    {
                    	field: 'class_name',

                    	title: 'class ',
                    	required: true
                    },
                    {
                    	field: 'remark',
                    	title: 'Remark',
                    	inputType: 'text'
                    },
                    {
                    	field: 'amount',
                    	title: 'cost/ month',
                    	inputType: 'number'
                    },
                    {
                    	field: "delete_status",
                    	inputType: "select",

                    	title: 'deleted',
                    	options: [{ value: 0, title: 'false'}, { value: 1, title: 'true'}],
                    	formatter: function(item) { return item.title; },
                    	select: function(item) { return item.value; }

                    }

                    ]
                },
                getData: function () { return $scope.data; }
            };



            function updateMe(newdata) {

            	var data = $.param({
            		action: 'update-category' ,
            		id: newdata.id,
            		details: newdata.remark,
            		name: newdata.class_name,
            		weigh: newdata.amount,
            		delete : newdata.delete_status

            	});

            	console.log(data);

            	$http.post("root/ajax.php", data, config)
            	.then(function mySuccess(response) {

            		console.log(response.data);
            		response = userAuthenticationAgent($scope, response);

            		if(! (response === null || response === undefined) )
            			if(response.status == 1) {

            				toastr.success(response.message );
            			} else if (response.status == 2) {
            				updateMeStatus();

            				toastr.error( response.message );
            			}

            		}, function myError(response) {
            			console.log(response);
            			// updateMeStatus();

            		});


            	console.log(newdata);

            };



   // utility stuff
   $scope.movePage = function (offset) {
   	$scope.gridConfig.options.pageNum += offset;
   	$scope.gridConfig.options.pageNum = Math.max(0, $scope.gridConfig.options.pageNum);
   };


















   function updateMeStatus () {
   	var data = $.param({
   		action: 'get-category'
   	});

   	$http.post("root/ajax.php", data, config)
   	.then(function mySuccess(response) {
   		response = userAuthenticationAgent($scope, response);
   		console.log(response);

   		success = response.status;
   		if(success == 3){

   			$scope.data = [];
   			angular.forEach(response.data , function(value, key) {
   				if( value != null){
	         					// value.delete_status = (value.delete_status == 1) ? true : false;
	         					this.push(value);
	         				}
	         			}, $scope.data );


   		} else if(success == 11){

   			toastr.warning( response.message );

   		}

   		if(success == 2){

   		}

   		console.log($scope.data );

   	}, function myError(response) {
   		console.log(response);
   	});




   }




   $timeout( function(){
   	// toastr.success('I don\'t need a title to live' );
   	updateMeStatus();




   },3);
});








admin_app.controller( 'admin_appControllerAdminGymAdd', function($timeout, $scope, $http, $location, $filter, myservice, toastr){
	
	doCheckUser($scope, $http);

	$scope.gym = {
		gym_licenseid: null,
		gym_name:  null,
		gym_owner: null,
		gym_email: null,
		city: null,
		longitude: null,
		latitude: null,
		amount: null,
		class_id: null,
		max_take: null
	}


	$scope.abc;
	$scope.efg;





	$scope.result1 = 'initial value';
	$scope.options1 = null;
	$scope.details1 = '';

	$scope.modd

	$scope.result2 = '';
	$scope.options2 = {
		country: 'ca',
		types: '(cities)'
	};    $scope.details2 = '';



	$scope.result3 = '';
	$scope.options3 = {
		country: 'gb',
		types: 'establishment'
	};
	$scope.details3 = '';




	$timeout( function(){


		// eachCampuse ( {
		// 	id : 'map',
		// 	city : 'PG Hostel',
		// 	desc : 'SPG Hostel RIT',
		// 	lat : 9.578964,
		// 	long : 76.62155181,
		// 	address: 'Abc, xyz street London, HG521A',
		// 	phone: '0800 - 1234 - 562 - 6',
		// 	fax : '+4 1234 567 - 9',
		// 	email : 'query@domain.com',
		// 	complaint : 'complaint@domain.com',
		// 	map: null
		// }  );
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

        $scope.$apply(function() { 
   // every changes goes here
   $('#l1').val(a); 
   $('#l2').val(b); 
});

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

        function createMarker(place) {
        	var placeLoc = place.geometry.location;
        	var marker = new google.maps.Marker({
        		map: map,
        		position: place.geometry.location
        	});

        	google.maps.event.addListener(marker, 'click', function() {
        		infowindow.setContent(place.name);
        		infowindow.open(map, this);
        	});







        }






    });









    },3);



	$scope.$watch('showOffset', function( ) {
		console.log("change");



	});

	var eachCampuse = ( campuse   )=> {


		console.log("ss");



		thisis = campuse.id ;
		console.log(campuse, thisis);



		var mapOptions = {
			zoom: 17,
			center: new google.maps.LatLng(campuse.lat ,  campuse.long),
			mapTypeId: google.maps.MapTypeId.TERRAIN
		}
		console.log(document.getElementById( thisis) );

		campuse.map = new google.maps.Map(document.getElementById( thisis), mapOptions) ;

		createMarker(campuse);
	}

	var createMarker = function (info){

		var marker = new google.maps.Marker({
			map: info.map,
			position: new google.maps.LatLng(info.lat, info.long),
			title: info.city
		}); 


	}  




    //============== DRAG & DROP =============
    // source for drag&drop: http://www.webappers.com/2011/09/28/drag-drop-file-upload-with-html5-javascript/
    var dropbox = document.getElementById("dropbox")
    $scope.dropText = 'Drop files here...'

    // init event handlers
    function dragEnterLeave(evt) {
    	evt.stopPropagation()
    	evt.preventDefault()
    	$scope.$apply(function(){
    		$scope.dropText = 'Drop files here...'
    		$scope.dropClass = ''
    	})
    }
    if(dropbox) {
    	dropbox.addEventListener("dragenter", dragEnterLeave, false)
    	dropbox.addEventListener("dragleave", dragEnterLeave, false)
    	dropbox.addEventListener("dragover", function(evt) {
    		evt.stopPropagation()
    		evt.preventDefault()
    		var clazz = 'not-available'
    		var ok = evt.dataTransfer && evt.dataTransfer.types && evt.dataTransfer.types.indexOf('Files') >= 0
    		$scope.$apply(function(){
    			$scope.dropText = ok ? 'Drop files here...' : 'Only files are allowed!'
    			$scope.dropClass = ok ? 'over' : 'not-available'
    		})
    	}, false)
    	dropbox.addEventListener("drop", function(evt) {
    		console.log('drop evt:', JSON.parse(JSON.stringify(evt.dataTransfer)))
    		evt.stopPropagation()
    		evt.preventDefault()
    		$scope.$apply(function(){
    			$scope.dropText = 'Drop files here...'
    			$scope.dropClass = ''
    		})
    		var files = evt.dataTransfer.files
    		if (files.length > 0) {
    			$scope.$apply(function(){
    				$scope.files = []
    				for (var i = 0; i < files.length; i++) {
    					$scope.files.push(files[i])
    				}
    			})
    		}
    	}, false)

    }
    //============== DRAG & DROP =============

    $scope.setFiles = function(element) {
    	$scope.$apply(function(scope) {
    		console.log('files:', element.files);
      // Turn the FileList object into an Array
      $scope.files = []
      for (var i = 0; i < element.files.length; i++) {
      	$scope.files.push(element.files[i])
      }
      $scope.progressVisible = false
  });
    };


    function uploadProgresses(evt, $scope) {

    	console.log(evt);
    	$scope.progressVisible = true;

    	$scope.progress = Math.round(evt.loaded * 100 / evt.total);

    }


 /////////////////////////////////////////////////

 $scope.getNumber = function(num) {
 	var test = [];
 	for (var i = 0; i< num; i++ ) {
 		test.push(i+1);
 	}
 	return test;
 }




 $scope.gymGymSubmit = ($e) => {

 	// console.log($scope.gym);











 	var form_data = new FormData();
 	angular.forEach($scope.files, function(file){
 		console.log(file);
 		form_data.append('file[]', file);
 	});

 	// console.log(form_data);

 	angular.forEach( $scope.gym, function(value, key){
 		console.log(key, value);
 		form_data.append(key, value);
 	});

 	form_data.append('action', 'add-gym');


 	console.log(form_data);
 	$http.post("root/ajax.php", form_data,

 	{
 		headers : {
 			'Content-Type': undefined,
 			'X-Requested-With': 'XMLHttpRequest',
 			'CsrfToken': token.attr('content')
 		},

 		uploadEventHandlers: { progress: function(e) {
 			uploadProgresses(e, $scope);
 		}
 	}


 }
 )
 	.then(function mySuccess(response) {
 		response = userAuthenticationAgent($scope, response);
 		console.log(response);


 		success = response.status;
 		if(success == 1){

 			$scope.categories = [];
 			$scope.gym = {
 				category: null,
 				subject:  null,
 				gym: null,
 				details: null,
 				option: null,
 				attachment: null,
 				manual: null,
 				typeofq: null,
 				answer: null,
 				hint: null
 			}

 			$scope.gym = null;
    // Create a counter to keep track of the additional telephone inputs
    $scope.inputCounter = 0;
    $scope.gym.optionEach = [];
    var myEl = angular.element( document.querySelector( '.removeAll' ) );
    myEl.remove();
    nowCateg();


            $($e.target).find('.removeAll').remove(); // Not working


            $scope.gym = null;

            toastr.success( response.message );
        } else if(success == 11){

        	toastr.warning( response.message );

        }

        if(success == 2){

        } else {
        	
        	$location.path('/admin-gym-view');
        }



    }, function myError(response) {
    	console.log(response);
    });






 }




 function nowCateg () {


 	var data = $.param({
 		action: 'get-category'
 	});

 	$http.post("root/ajax.php", data, config)
 	.then(function mySuccess(response) {
 		response = userAuthenticationAgent($scope, response);
 		console.log(response);

 		success = response.status;
 		if(success == 3){

 			$scope.categories = [];
 			angular.forEach(response.data , function(value, key) {
 				if( value != null)
 					if(value.delete_status == 0)
 						this.push(value);
 				}, $scope.categories );


 		} else if(success == 11){

 			toastr.warning( response.message );

 		}

 		if(success == 2){

 		}

 		console.log($scope.categories );

 	}, function myError(response) {
 		console.log(response);
 	});




 }

 $scope.removeLastMe = (e) => {
 	console.log("remove me");
 	$scope.gym.optionEach.splice($scope.inputCounter, 1);
 	$scope.inputCounter --;

            $(e.target).parent().remove(); // Not working
        }

        $timeout( function(){
		// toastr.success('I don\'t need a title to live' );/
		nowCateg();





	},3);





    });



admin_app.controller( 'admin_appControllerAdminGymView', function($timeout, $scope, $http, $location, $filter, myservice, toastr){
	



	doCheckUser($scope, $http);

	$scope.gyms = [];
	$scope.showGyms = [];
	docCount = 8;
	$scope.docOfset = 0;
	$scope.showOffset = 0;



	$scope.removeaddSingleGym = ( gym, $sta ) => {





		var data = $.param({
			id: gym.id,
			delete: $sta ,
			action: 'remove-gym'
		});


		console.log(data);
		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) {
			response = userAuthenticationAgent($scope, response);
			console.log(response);

			if(! (response === null || response === undefined) )

				console.log(response.status);
			if(response.status == 1) {


				toastr.success( response.message );

				pushMe(gym, {delete_status : $sta});

			} else if(response.status == 2) {
				toastr.error( response.message );
			} else {
				toastr.info( response.message );


			}

		}, function myError(response) {
			console.log(response);
		});

	}

	$scope.viewSingleGym = ( gym_id ) => {
		$scope.myservice = myservice;
		var passData = { id: gym_id};
		$scope.myservice.value = passData;
		$location.path('/admin-gym-single');
	}


	$scope.$watch('showOffset', function( ) {
		console.log("change");

		if($scope.gyms[ $scope.showOffset ])	{
			//
			var test = angular.element( document.getElementsByClassName( 'myAmimateTe' ) );
			test.addClass('fadeOutLeft');

			$scope.showGyms = $scope.gyms[$scope.showOffset ];
		}

	});

	$scope.addOfset = ( key ) => {
		$scope.showOffset = key;
	}


	var getGyms = () => {


		var data = $.param({
			action: 'get-gym',
			offset: $scope.docOfset,
			count: docCount
		});

		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) {
			response = userAuthenticationAgent($scope, response);
			// console.log(response);

			if(! (response === null || response === undefined) )
				if(response.status == 3) {
					if((response.data  != null ))
						$scope.docOfset = $scope.docOfset  + response.data.length;
					tempArr = [];

					angular.forEach(response.data , function(value, key) {

						// value.image =  'files/images/employee/' + value.image;
						// str.substring(1, 4);
						this.push(value);
					}, tempArr);
					$scope.gyms.push(tempArr);

					if($scope.showGyms.length == 0 )
						$scope.showGyms = $scope.gyms[0];

					if((response.data  != null ))
						if( (response.data.length > 1) && 1)
							getGyms();
					}

					console.log($scope.gyms);

				}, function myError(response) {
					console.log(response);
				});

	}


	$timeout( function(){


		getGyms();



	},3);


});















admin_app.controller( 'admin_appControllerAdminGymVSingle', function($timeout, $scope, $http, $location, $filter, myservice, toastr){
	
	doCheckUser($scope, $http);
	$scope.myservice = myservice;
	if($scope.myservice.value == null){

		$location.path('/admin-gym-view');
		toastr.info("select a gym first");
	} else {
		$scope.gym_id = $scope.myservice.value.id;
	}


	console.log($scope.gym_id);




	$scope.categories = [];
	$scope.gym = {
		gym_licenseid: null,
		gym_name:  null,
		gym_owner: null,
		gym_email: null,
		city: null,
		longitude: null,
		latitude: null,
		amount: null,
		class_id: null,
		max_take: null
	}

	$scope.optintodo = null;
	$scope.newOptionNowError = false;




    // Create a counter to keep track of the additional telephone inputs
    $scope.inputCounter = 0;
    $scope.gym.optionEach = [];

    $scope.manual = [{ value: 0, label: 'false'}, { value: 1, label: 'true'}];

    $scope.attachments = [];








 /////////////////////////////////////////////////////


    //============== DRAG & DROP =============
    // source for drag&drop: http://www.webappers.com/2011/09/28/drag-drop-file-upload-with-html5-javascript/
    var dropbox = document.getElementById("dropbox")
    $scope.dropText = 'Drop files here...'

    // init event handlers
    function dragEnterLeave(evt) {
    	evt.stopPropagation()
    	evt.preventDefault()
    	$scope.$apply(function(){
    		$scope.dropText = 'Drop files here...'
    		$scope.dropClass = ''
    	})
    }
    if(dropbox) {
    	dropbox.addEventListener("dragenter", dragEnterLeave, false)
    	dropbox.addEventListener("dragleave", dragEnterLeave, false)
    	dropbox.addEventListener("dragover", function(evt) {
    		evt.stopPropagation()
    		evt.preventDefault()
    		var clazz = 'not-available'
    		var ok = evt.dataTransfer && evt.dataTransfer.types && evt.dataTransfer.types.indexOf('Files') >= 0
    		$scope.$apply(function(){
    			$scope.dropText = ok ? 'Drop files here...' : 'Only files are allowed!'
    			$scope.dropClass = ok ? 'over' : 'not-available'
    		})
    	}, false)
    	dropbox.addEventListener("drop", function(evt) {
    		console.log('drop evt:', JSON.parse(JSON.stringify(evt.dataTransfer)))
    		evt.stopPropagation()
    		evt.preventDefault()
    		$scope.$apply(function(){
    			$scope.dropText = 'Drop files here...'
    			$scope.dropClass = ''
    		})
    		var files = evt.dataTransfer.files
    		if (files.length > 0) {
    			$scope.$apply(function(){
    				$scope.files = []
    				for (var i = 0; i < files.length; i++) {
    					$scope.files.push(files[i])
    				}
    			})
    		}
    	}, false)

    }
    //============== DRAG & DROP =============

    $scope.setFiles = function(element) {
    	$scope.$apply(function(scope) {
    		console.log('files:', element.files);
      // Turn the FileList object into an Array
      $scope.files = []
      for (var i = 0; i < element.files.length; i++) {
      	$scope.files.push(element.files[i])
      }
      $scope.progressVisible = false
  });
    };


    function uploadProgresses(evt, $scope) {

    	console.log(evt);
    	$scope.progressVisible = true;

    	$scope.progress = Math.round(evt.loaded * 100 / evt.total);

    }


 /////////////////////////////////////////////////

 $scope.getNumber = function(num) {
 	var test = [];
 	for (var i = 0; i< num; i++ ) {
 		test.push(i+1);
 	}
 	return test;
 }



 //////////////////////////////////////














 $scope.gymgymSubmit = ($e) => {



 	// console.log($scope.gym);

 	var form_data = new FormData();
 	angular.forEach($scope.files, function(file){
 		console.log(file);
 		form_data.append('file[]', file);
 	});

 	// console.log(form_data);
 	console.log($scope.gym);
 	$vqoptlength  = 0 ;
 	$vqopts  = null ;

 	angular.forEach( $scope.gym, function(value, key){
 		if(key == "optionEach") {
 			$vqoptlength  = value.length ;
 			$vqopts = value;
 			value = JSON.stringify(value);
 		}
 		console.log(key, value);
 		form_data.append(key, value);
 	});

 	form_data.append('action', 'update-gym');
 	varerr = false;
 	if ($vqopts != null) {

 		angular.forEach( $vqopts, function(value0, key0){
 			angular.forEach( $vqopts, function(value1, key1){
 				if( key0 != key1)
 					if(value0 == value1)
 						varerr = true;
 				});
 		});
 	}

 	if (varerr) {


 		toastr.error( "duplicate option" );
 		return;

 	}


 	console.log($vqoptlength);
 	if( $vqoptlength > 0)
 		if(!( 0 < $scope.gym.option) ) {

 			toastr.error( "invalid option" );
 			return;
 		}


 		$http.post("root/ajax.php", form_data,

 		{
 			headers : {
 				'Content-Type': undefined,
 				'X-Requested-With': 'XMLHttpRequest',
 				'CsrfToken': token.attr('content')
 			},

 			uploadEventHandlers: { progress: function(e) {
 				uploadProgresses(e, $scope);
 			}
 		}


 	}
 	)
 		.then(function mySuccess(response) {




 			response = userAuthenticationAgent($scope, response);
 			console.log(response);


 			success = response.status;
 			if(success == 1){


 				$location.path('/admin-gym-view');



 				toastr.success( response.message );
 			} else if(success == 11){

 				toastr.warning( response.message );

 			}

 			if(success == 2){

 			}



 		}, function myError(response) {
 			console.log(response);
 		});






 	}









 	function nowCateg () {


 		var data = $.param({
 			action: 'get-category'
 		});

 		$http.post("root/ajax.php", data, config)
 		.then(function mySuccess(response) {
 			response = userAuthenticationAgent($scope, response);
 			console.log(response);

 			success = response.status;
 			if(success == 3){

 				$scope.categories = [];
 				angular.forEach(response.data , function(value, key) {
 					if( value != null)
 						if(value.delete_status == 0)
 							this.push(value);
 					}, $scope.categories );


 			} else if(success == 11){

 				toastr.warning( response.message );

 			}

 			if(success == 2){

 			}

 			console.log($scope.categories );

 		}, function myError(response) {
 			console.log(response);
 		});




 	}







 	$scope.addMeu =  ( newOptionNow ) =>  {
 		$scope.newOptionNowError = false;
 		$scope.optintodo = newOptionNow;
 		console.log(newOptionNow);
 		console.log($scope.optintodo);
 		if($scope.optintodo == null || $scope.optintodo.length < 1 ) {
 			$scope.newOptionNowError = true;

 		}
 		else {

 			$scope.gym.optionEach.push({
 				id: null,
 				option_key: $scope.inputCounter,
 				option_value: $scope.optintodo ,
 				gym_id: $scope.gym_id
 			});
 			$scope.optintodo = null;
 			optintodo = null;

 			return null;
 			console.log($scope.gym.optionEach);
 		}


 	}



 	$scope.removeLastMe = (e) => {
 		console.log("remove me");
 		$scope.gym.optionEach.splice($scope.inputCounter, 1);
 		$scope.inputCounter --;

            $(e.target).parent().remove(); // Not working
        }



        $scope.removeAttachmentMe = ($index, attachment) => {



        	var data = $.param({
        		id: $scope.gym_id,
        		attachment_id: attachment.id ,
        		action: 'remove-gym-attachment'
        	});


        	console.log(data);
        	$http.post("root/ajax.php", data, config)
        	.then(function mySuccess(response) {
        		response = userAuthenticationAgent($scope, response);
        		console.log(response);

        		if(! (response === null || response === undefined) )

        			console.log(response.status);
        		if(response.status == 1) {


        			$scope.attachments.splice($index, 1);

        			toastr.success( response.message );


        		} else if(response.status == 2) {
        			toastr.error( response.message );
        		} else {
        			toastr.info( response.message );


        		}

        	}, function myError(response) {
        		console.log(response);
        	});
        }

        $scope.removeMe = ($mek, gymeach) => {

        	if(gymeach.id ==  null ) {

        		$scope.gym.optionEach.splice($mek, 1);

        		return;


        	}
        	var data = $.param({
        		id: $scope.gym_id,
        		option_id: gymeach.id ,
        		action: 'remove-gym-option'
        	});


        	console.log(data);
        	$http.post("root/ajax.php", data, config)
        	.then(function mySuccess(response) {
        		response = userAuthenticationAgent($scope, response);
        		console.log(response);

        		if(! (response === null || response === undefined) )

        			console.log(response.status);
        		if(response.status == 1) {


        			$scope.gym.optionEach.splice($mek, 1);

        			toastr.success( response.message );


        		} else if(response.status == 2) {
        			toastr.error( response.message );
        		} else {
        			toastr.info( response.message );


        		}

        	}, function myError(response) {
        		console.log(response);
        	});


        }

        $timeout( function(){
		// toastr.success('I don\'t need a title to live' );/
		nowCateg();



		var data = $.param({
			id: $scope.gym_id,
			action: 'get-single-gym'
		});


		console.log(data);
		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) {
			response = userAuthenticationAgent($scope, response);
			console.log(response);

			if(! (response === null || response === undefined) )

				console.log(response.status);
			if(response.status == 3) {
							// $scope.profile = response.data ;
							// pushMe ($scope.profile , {phone: parseInt(response.data.phone) ,
							// 	landline: ""  ,
							// 	officephone : ""   ,
							// 	image :   'files/images/employee/' + response.data.image} );

							// if(parseInt(response.data.landline) != 0)
							// 	pushMe ($scope.profile , {landline: parseInt(response.data.landline)} );

							// if(  parseInt(response.data.officephone) != 0)
							// 	pushMe ($scope.profile , { officephone : parseInt(response.data.officephone) } );


							// $scope.oldProfile = $scope.profile;
							$data = response.data[0];


							console.log($data);
							


							$scope.gym = {
								id: $data['id'],
								gym_licenseid: $data['gym_licenseid'],
								gym_name:  $data['gym_name'],
								gym_owner: $data['gym_owner'],
								gym_email: $data['gym_email'],
								city: $data['city'],
								longitude: $data['longitude'],
								latitude: $data['latitude'],
								amount: $data['amount'],
								class_id: $data['class_id'],
								max_take: $data['max_take'],
								mobile: parseInt($data['mobile']),
							}

    // Create a counter to keep track of the additional telephone inputs

    $dataa = response.data[1];

    $scope.inputCounter = 0;
    if($dataa)
    	$scope.inputCounter = $dataa.length ;
    $scope.gym.optionEach = [];

    angular.forEach($dataa , function(value, key) {
    	if( value != null)
    		if(value.delete_status == 0)
    			this.push(value);
    	}, $scope.gym.optionEach );

    console.log($scope.gym.optionEach );



    $dataa = response.data[2];


    $scope.attachments = [];
    angular.forEach($dataa , function(value, key) {
    	if( value != null)
    		if(value.delete_status == 0)
    			this.push(value);
    	}, $scope.attachments );

    console.log($scope.attachments);





} else if(response.status == 2) {
	toastr.error( response.message );
} else {
	toastr.info( response.message );


}

}, function myError(response) {
	console.log(response);
});

	},1);
    });










admin_app.controller( 'admin_appController0', function($timeout, $scope, $http, $location, $filter, myservice, toastr){
	doCheckUser($scope, $http);
	$timeout( function(){
		toastr.success('I don\'t need a title to live' );

		var data = $.param({
			action: 'get-Image' 
		});	

		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) { 
			response = userAuthenticationAgent($scope, response);
			console.log(response);

		}, function myError(response) { 
			console.log(response);
		});


	},999);
});



function getFormattedDate() {
	var date = new Date();
	var str = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " +  date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();

	return str;
}

function userAuthenticationAgent ($scope, response){
	returnResponse = null;
	loname = null;
	// console.log(response);
	try {
		response = response.data;
		response =angular.fromJson(response);
		returnResponse = { status: response.success ,  data:response.data,  message: response.remark};
		if(response.success == -1 ){
			try{
				loname = localStorage.localusername;
			} catch (err){
				alert("something went wrong, manually reload the page !");
			}
			$scope.$parent.authentication = {username : loname,
				lockscreen: 'admin/pages/lockscreen.html',
				isLock: true,
				password: null,
				invalidPassword: false,
				remark: 'user session timeout'
			};
		}else if(response.success == 1 ){
			try{
				loname = localStorage.localusername;
			} catch (err){
				alert("something went wrong, manually reload the page !");
			}
			$scope.authentication = {username : loname,
				isLock: false,
				lockscreen: null,
				password: null,
				invalidPassword: false,
				remark: 'access granted'
			};
		}

	}
	catch(err) {
		console.log("error here");
	}
	return returnResponse;
}

function doCheckUser($scope,$http) {
	$scope.authentication = {lockscreen : null};
	var data = $.param({
		action: 'check-user'
	});

	$http.post("root/ajax.php", data, config)
	.then(function mySuccess(response) {
		response = userAuthenticationAgent($scope, response);
	}, function myError(response) {
		alert("server error 500");
	});
}
