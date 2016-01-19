	$(document).ready(function() {
			
				jQuery.validator.addMethod("lettersonly", function(value, element) {
					return this.optional(element) || /^[a-z]+$/i.test(value);
					}, "Please enter only letters"); 
					
			// validate contact form on keyup and submit
			$("#form").validate({
			
			 errorElement: "span", 
			 
			 
			//set the rules for the fild names
			rules: {
			
				name: {
					required: true,
					minlength: 3,
					maxlength:50,
					
				},
				pincode: {
					required: true,
					minlength: 5,
					maxlength:15,
					
				},
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 6,
					maxlength:50
				},
				
				confpassword: {
					required: true,
					equalTo: "#password",
					minlength: 6,
					maxlength:50
				},
				
				oldpassword: {
					required: true,
					minlength: 6,
					maxlength:50
				},
				
				gender : {
					required :true
				},
				
				mobile : {
					digits: true,
					required :true,
					minlength:10
					
					
				},
				txtmsg : {
					required :true,
					
					
					
				},
				travellermobile : {
					required :true,
					minlength:10
					
					
				},
				travellername : {
					minlength:3
				},
				state : {
					required :true
				},
				city : {
					minlength:3
				},
				
				agree : {
					required :true
				},	
				
				cemail: {
					required: true,
					equalTo: "#email",
					email: true
				},
				
			},
			//set messages to appear inline
			messages: {
			
				name: {
					required: "Name is required",
				},
				
				password: {
				required: "Please provide a password.",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},
				
				confpassword: {
				required: "Please provide a Confirm password.",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},
				
				oldpassword: {
				required: "Please provide a old password.",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},
				
				email: "Valid email is required.",
				
				mobile: {
				required: "Mobile Number is required",
				minlength: "Number must be at least 10 characters long",
				maxlength: "Number can not be more than 10 characters"
				},
				
				travellermobile: {
				required: "Mobile Number is required",
				minlength: "Number must be at least 10 characters long",
				maxlength: "Number can not be more than 10 characters"
				},
			
			    travellername: 
				{
				required: "Name is required",
				minlength: "Name must be at least 3 characters long",
				},
				city: 
				{
				required: "City is required",
				minlength: "City must be at least 3 characters long",
				},
				txtmsg: 
				{
				required: "Message is required",
				
				},
				
				agree: "You must agree to our terms.",
				gender: "Gender is required",
				state: "Select state",
				pincode: 
				{
				
					required: "Pincode is required",
				minlength: "Pincode must be at least 5 characters long",
				maxlength: "Pincode can not be more than 15 characters"
				}
				
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});
			
			
				$("#login-form").validate({
			
		 errorElement: "span", 
			 errorClass:"inputError",
			 successClass:"inputSuccess",
			 
			 
			//set the rules for the fild names
			rules: {
			
				
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 6,
					maxlength:50
				},
				
				
				
			},
			//set messages to appear inline
			messages: {
			
				
				
				password: {
				required: " ",
				minlength: " ",
				maxlength: " "
				},
				
				
				
				email: " ",
				
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				},
				 highlight: function(element) {
$(element).closest('.input-group').removeClass('has-success').addClass('has-error');
},
 success: function(element) {
element.closest('.input-group').removeClass('has-error').addClass('has-success');
}

		});

				
				


		
		
		
		
		
	
		
		$("#req-form").validate({
			
			 errorElement: "span", 
			 errorClass:"inputError",
			 successClass:"inputSuccess",
			 
			//set the rules for the fild names
			rules: {
			
			
			req_customer_id: {
					required: true,
					
				},
				
				req_hiring_location: {
					required: true,
					
				},
				req_business_unit: {
					required: true,
					
				},
				req_hiring_manager: {
					required: true,
					
				},
				req_work_location: {
					required: true,
					
				},
				
				req_assigned_to: {
					required: true,
					
				},
				
				
				
				req_title: {
					required: true,
					maxlength:500,
					
				},
				
				req_no_position: {
					required: true,
					digits:true,
					maxlength:3,
					
				},
				
				req_number: {
					required: true,
					maxlength:8,
					
				},
				
				
				
				
				
				
				
							
			},
			//set messages to appear inline
			messages: {
				
				req_customer_id: {
				required: " ",
				
				},
				req_hiring_location: {
				required: " ",
				
				},
				req_business_unit: {
				required: " ",
				
				},
				req_hiring_manager: {
				required: " ",
				
				},
				req_work_location: {
				required: " ",
				
				},
				
			
				req_title: {
				required: " ",
				
				},
				
				req_no_position: {
				required: " ",
				
				},
				req_assigned_to: {
				required: " ",
				
				},
				
				req_number: {
				required: " ",
				
				},
				
				
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				},
				 highlight: function(element) {
$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
},
 success: function(element) {
element.closest('.form-group').removeClass('has-error').addClass('has-success');
}
				
				

		});
		
	
		
		
	});