var admin_app = angular.module( 'app-admin', ['ngRoute', 'ngAnimate', 'ngProgressLite', 'toastr', 'dcbImgFallback', 'ngtimeago', '720kb.datepicker', 'ngImgCrop', 'xeditable']); 

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













admin_app.controller( 'admin_appControllerClass', function($timeout, $scope, $http, $location, $filter, myservice, toastr){
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


