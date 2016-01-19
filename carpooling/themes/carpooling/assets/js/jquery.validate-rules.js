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
					minlength:4,
					maxlength:15
					
					
				},
				txtmsg : {
					required :true,
					
					
					
				},
				travellermobile : {
					required :true,
					minlength:4,
					maxlength:15
					
					
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
				minlength: "Number must be at least 4 characters long",
				maxlength: "Number can not be more than 15 characters"
				},
				
				travellermobile: {
				required: "Mobile Number is required",
				minlength: "Number must be at least 4 characters long",
				maxlength: "Number can not be more than 15 characters"
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
			
			
				$("#form-login").validate({
			
			 errorElement: "span", 
			 
			 
			//set the rules for the fild names
			rules: {
			
				
				username: {
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
				required: "Please provide a password.",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},
				
				
				
				username: "Valid email is required.",
				
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});
		
		
		
			$("#loginForm").validate({
			errorElement: "div",			 
			//set the rules for the fild names
			rules: {				
				cmobile: {
					required: true,
					minlength:4,
					maxlength:15
					
				},
				password: {
					required: true,
					minlength: 6,
					maxlength:50
				},				
			},
			//set messages to appear inline
			


			messages: {				
				cmobile: {
				required: "Mobile Number is required",
				minlength: "Number must be at least 4 characters long",
				maxlength: "Number can not be more than 15 characters"
				},
				
				password: {
				required: "Please provide a password.",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},				
								
			},
			
			submitHandler: function(form) {
				
            					
				$.ajax({
					type: "POST",	
					url: baseurl + "student/login/loginvalidated/true",	
					dataType: "json",	
					data:$('#loginForm').serialize(),
					success: function(json)	{
				
						if (json.result == 0){
							
							$('#spnError').html('Invalid Login!');
							//$('#spnError').show();
							return false;
						} else if (json.result == 1) {
							$('#spnError').html('Success...transfering');
							
							window.location	= baseurl + "/student/dashboard";
							
						}
					}
				});
			      
			},
			
			errorPlacement: function(error, element) {               
				error.appendTo(element.parent());     
			}

		});
				
				
		$("#registerForm").validate({
			errorElement: "div",			 
			//set the rules for the fild names
			rules: {	
			
			name: {
					required: true,
				
					
				},
							
				rmobile: {
					required: true,
					minlength:4,
					maxlength:15,
					digits: true,
					
				},
				uemail: {
					required: true,
					email: true
					
				}
							
			},
			//set messages to appear inline
			messages: {	
			name: 
				{
				required: "Your name required"
				
				}
			,				
				rmobile: 
				{
				required: "Please provide a mobile.",
				minlength: "must be at least 4 characters long",
				maxlength: "Mobile can not be more than 15 characters"
				},		
				
				uemail: 
				{
				required: "Please provide a Email-ID.",
				email: "Valid Email is required."
				},		
								
			},
			
			submitHandler: function(form) {
            		$('#regspnError').html('Please Wait...');			
				$.ajax({
					type: "POST",	
					url: baseurl + "student/register/prompt_register/true",		
					dataType: "json",	
					data:$('#registerForm').serialize(),
					success: function(json)	{
				
						if (json.result == 0){
							
							$('#regspnError').html(json.error);
							//$('#spnError').show();
							return false;
						} else if (json.result == 1) {
							$('#regspnError').html('Success...transfering');
							window.location	= baseurl +json.redirect +'/?uid='+ json.rmobile;
						}
					}
				});
			      
			},
			
			errorPlacement: function(error, element) {               
				error.appendTo(element.parent());     
			}

		});
				
				
				// step-1 validation
				
				$("#frmproject").validate({
			
			 errorElement: "span", 
			 
			 
			//set the rules for the fild names
			rules: {
			
				
				txttitle: {
					required: true,
					minlength: 10,
					maxlength:300
					
				},
				
				
				
				txtcode: {
					required: true,
					minlength: 2,
					maxlength:15
					
				},
				
				
				
				
				
				
				
			},
			//set messages to appear inline
			messages: {
				
				txttitle:  {
					required: "",
					
					minlength: "Project title must be at least 10 characters long",
					maxlength: "Project title can not be more than 300 characters"
				
				},
				
				txtcode: {
					required: "",
					
					minlength: "Project code must be at least 2 characters long",
					maxlength: "Project code can not be more than 15 characters"
				
				}
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});
				
				
				
				
				// step-1 validation
				
				$("#frmproperty").validate({
			
			 errorElement: "span", 
			 
			 
			//set the rules for the fild names
			rules: {
			
				
				txttitle: {
					required: true
					
				},
				
				
				
			},
			//set messages to appear inline
			messages: {
			
				
				
								
				
				txttitle: "* Project Title Required!",
				
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});
		
		
		
		
		
		
		// Home page send Enquiry
				
				$("#homebooking").validate({
			
			 errorElement: "span", 
			 
			 
			//set the rules for the fild names
			rules: {
			
				
				mobile: {
					digits: true,
					required :true,
					minlength:4,
					maxlength:15
					
				},
				
				email: {
					required: true,
					email: true
					
				},
				place: {
					required: true
					
				},
				message: {
					required: true,
					maxlength:250,
					
				},
				
				
				
				
			},
			//set messages to appear inline
			messages: {
			
								
				mobile: {
				required: "Mobile Number is required",
				minlength: "Number must be at least 4 characters long",
				maxlength: "Number can not be more than 15 characters",
				digits: "Should be a Number"
				},
				email: "Valid email is required.",
				place: "place is required.",
				message: {
					required: "message is required.",
					
				maxlength: "Number can not be more than 250 characters"
				}
				
				
				
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});
		
		$("#changepwd").validate({
			
			 errorElement: "span", 
			 
			 
			//set the rules for the fild names
			rules: {
			
				
				txtoldpwd: {
					required: true,
					minlength: 6,
					maxlength:50
				},
				
				txtnewpwd: {
					required: true,					
					minlength: 6,
					maxlength:50
				},
				
				txtcnewpwd: {
					required: true,
					equalTo: "#password",
					minlength: 6,
					maxlength:50
				},
				
							
			},
			//set messages to appear inline
			messages: {
			
				txtoldpwd: {
				required: "Please provide a password.",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},
				
				txtnewpwd: {
				required: "Please provide a Confirm password.",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},
				
				txtcnewpwd: {
				required: "Please provide a old password.",
				equalTo:	"Password Does not Match",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				}
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});
		
		
		// step-1 validation
				
				$("#postproject").validate({
			
			 errorElement: "div", 
			 
			 
			//set the rules for the fild names
			rules: {
				
				txtname: {
					required: true,
				
					
				},
			
				txtmobile: {
					required: true,
					minlength:4,
					maxlength:15,
					digits: true,
					
				},
				
				txttitle: {
					required: true,
					minlength: 10,
					maxlength:300
					
				},
				
				txtabs: {
					required: true,
					minlength: 20,
					maxlength:300
					
				},
				
				projectdept: {
					required: true
					
				},

				projectcat: {
					required: true
					
				},

				txtemail: {
					required: true,
					email: true
				},
								
				
				
				
				
				
				
			},
			//set messages to appear inline
			messages: {
				
				txtname: {
					
				required: "Your name required"
				
				},
								
				txtmobile: {
					
				required: "Please provide a mobile.",
				minlength: "must be at least 4 characters long",
				maxlength: "Mobile can not be more than 15 characters"
				},
				
				txtemail: "Valid email is required.",
				
				mobile: {
				required: "Mobile Number is required",
				minlength: "Number must be at least 10 characters long",
				maxlength: "Number can not be more than 10 characters"
				},
				
				txttitle:  {
				
					required: "Concept Title is required",
					
					minlength: "Project title must be at least 10 characters long",
					maxlength: "Project title can not be more than 300 characters"
				
				},
				
				txtabs:  {
				
					required: "About Concept is required",
					
					minlength: "Project title must be at least 20 characters long",
					maxlength: "Project title can not be more than 300 characters"
				
				},
				
				projectdept:{
					valueNotEquals: "Please select Your Degree",
				},
				
				projectcat:{
					required: "Please select Your ProjectCategory",
				},
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});
		
		
		
		
		
	});