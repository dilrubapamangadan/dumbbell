var gym_app = angular.module( 'app-gym', ['ngRoute', 'ngAnimate', 'ngProgressLite', 'toastr', 'dcbImgFallback', 'ngtimeago', '720kb.datepicker', 'ngImgCrop', 'xeditable']); 

var token = angular.element( document.querySelector( 'meta[name="csrf-token"]' ) );


var config = {
	headers : {
		'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
		'X-Requested-With': 'XMLHttpRequest',		
		'CsrfToken': token.attr('content')
	}
}


gym_app.config([ '$routeProvider', '$locationProvider', function( $routeProvider, $locationProvider ) {
	$routeProvider
	.when('/gym-dashboard', {
		templateUrl: 'gym/pages/home.html',
		controller: 'gym_appController0'
	}) 
	.when('/gym-profile', {
		templateUrl: 'gym/pages/profile.html',
		controller: 'gym_appControllerProfile'
	})  
	.when('/gym-settings', {
		templateUrl: 'gym/pages/settings.html',
		controller: 'gym_appControllerSettings'
	})   
	.otherwise({
		redirectTo: '/gym-dashboard'
	});

	$locationProvider.html5Mode({
		enabled: true,
		requireBase: false
	});

}]);

gym_app.run( function($rootScope, ngProgressLite,  $location, $timeout) {

	$rootScope.$on('$routeChangeStart', function() {
		ngProgressLite.start();
	});

	$rootScope.$on('$routeChangeSuccess', function() {
		ngProgressLite.done(); 
	});


});

gym_app.run(function(editableOptions, editableThemes) {
	editableThemes.bs3.inputClass = 'input-sm';
	editableThemes.bs3.buttonsClass = 'btn-sm';
	editableOptions.theme = 'bs3';
});

/*==================================================>>======================================================*/



// gym_app.directive('showTab',
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



gym_app.service('myservice', function() {
	this.value = null;
	this.name = null;
});

gym_app.config(function(toastrConfig) {
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








gym_app.controller( 'SystemControllerBoady',  function($timeout, $location, $scope, $http , $window, toastr){ 
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






//// gewtting some logn 100



$scope.isLoadingLog = true;


var data = $.param({
	action: 'get-log',
	from: 0 ,
	limit: 270
});	

$http.post("root/ajax.php", data, config)
.then(function mySuccess(response) { 
	response = userAuthenticationAgent($scope, response);
	// console.log(response); 

	if(! (response === null || response === undefined) ) 
		angular.forEach(response.data , function(value, key) { 
			value.date = value.day + ' ' + value.time;
			this.push(value);   
		}, $scope.logDataMin);  


}, function myError(response) { 			 
	console.log("error ");
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






gym_app.controller( 'gym_appControllerProfile', function($timeout, $location, $scope, $http, $window, toastr){ 
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
		image: null,
		landline: null,
		address: null,
		sex: null,
		facebook: null,
		twitter: null,
		instagram: null,
		description: null,
		
	}
	// profile uer  end 



	$scope.gymProfileSubmit = () => {
		console.log($scope.profile); 


		var data = $scope.profile;
		pushMe(data, {action: 'set-profile' }); 
		var data = $.param(data); 

		$http.post("root/ajax.php", data, config).then(function mySuccess(response) { 
			response = userAuthenticationAgent($scope, response);

			if(response.status == 1) {


				toastr.success( response.messages );
			} else if(response.status == 2) {
				toastr.error( response.messages );				
			} else {
				toastr.info( response.messages );


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

	var getLog = () => {

		$scope.isLoadingLog = true;


		var data = $.param({
			action: 'get-log',
			from: $scope.logOffset ,
			limit: $scope.logLimit 
		});	

		$http.post("root/ajax.php", data, config)
		.then(function mySuccess(response) { 
			response = userAuthenticationAgent($scope, response);
			// console.log(response); 
			Tdate = null; Tdata = []; 
			if(! (response === null || response === undefined) ){
				if(! (response.data === null || response.data === undefined) ) {  
					$scope.logOffset = $scope.logOffset  + response.data.length;

					angular.forEach(response.data , function(value, key) { 
						value.date = value.day + ' ' + value.time;
						if(Tdate == null )
							Tdate = value.day; 
						if(Tdate == value.day) {
							Tdate = value.day;  
						} else if( Tdate != null && Tdata.length > 0){		
							this.push(Tdata); 	 
							Tdata = [];
						} 
						Tdata.push(value);
						Tdate = value.day;  
					}, $scope.logData); 
				} else {
					$scope.moreLogR = false;
				}
			} else {
				$scope.moreLogR = false;
			}
			if(Tdate != null)
				$scope.logData.push(Tdata); 	

			$scope.isLoadingLog = false;

		}, function myError(response) { 			
			$scope.moreLogR = false;
			$scope.isLoadingLog = false;
			console.log("error ");
		});


	}

	$scope.reformatDate = (dateStr) =>  {
		dArr = dateStr.split("-"); 
		return dArr[2]+ "-" +dArr[1]+ "-" +dArr[0] ;  
	}

	$scope.moreLogs = () => {
		getLog();
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

		getLog();


	},1);
});




gym_app.controller( 'gym_appControllerSettings', function($timeout, $scope, $http, $location, $filter, myservice, toastr){
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
				$scope.gymLogin.repassword.$invalid = true;
				$scope.gymLogin.$invalid = true;
			}
		});



	$scope.$watch( 'login.newpassword', function(newdata) {		
		$scope.misMPassword = null; 
		var a =	$scope.login.repassword ;
		var b = $scope.login.newpassword ;
		if ( a && b) 
			if (a != b) { 
				$scope.misMPassword = "Password mismatch";
				$scope.gymLogin.repassword.$invalid = true;
				$scope.gymLogin.$invalid = true;
			}
		});


	$scope.$watch( 'login.password', function(newdata) {	
		$scope.errorPassword = null;

	});



	$scope.$watch( 'login.newpassword', function(newdata) {	 
		$scope.errorNewPassword = null;
	});

	$scope.gymLoginSubmit = function () {


		if ($scope.login.newpassword != $scope.login.repassword) { 
			$scope.misMPassword = "Password mismatch";
			$scope.gymLogin.repassword.$invalid = true;
			$scope.gymLogin.$invalid = true;			 
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
				$scope.gymLogin.password.$invalid = true;
				$scope.gymLogin.$invalid = true;		

			}

			if(success == 21){ 
				$scope.errorNewPassword = response.message;
				$scope.gymLogin.newpassword.$invalid = true;
				$scope.gymLogin.$invalid = true;		

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










gym_app.controller( 'gym_appController0', function($timeout, $scope, $http, $location, $filter, myservice, toastr){
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
				lockscreen: 'gym/pages/lockscreen.html',
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


