$(document).ready(function($) {



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
	console.log("lets goo");
	
});