	$(document).ready(function() {
			
				jQuery.validator.addMethod("lettersonly", function(value, element) {
					return this.optional(element) || /^[a-z]+$/i.test(value);
					}, "Please enter only letters"); 
					
					
					jQuery.validator.addMethod("mobile", function(value, element) {
					return this.optional(element) || /^[1-9]{1}[0-9]{3,14}$/i.test(value);
					}, "Please enter valid mobile number"); 
					
		
		
		// validate contact form on keyup and submit
			$("#frmregister").validate({
			
			 errorElement: "spnError", 
			 
			 
			//set the rules for the fild names
			rules: {
			
				txtfirstname: {
					required: true,
					minlength: 3,
					maxlength:50,
					
				},
				txtlastname: {
					required: true,
					minlength: 3,
					maxlength:50,
					
				},
				txtusername: {
					required: true,
					minlength: 3,
					maxlength:50,
					
				},
				txtpassword: {
					required: true,
					minlength: 6,
					maxlength:50
				},
								
				txtemail: {
					required: true,
					email: true
				},	
				
				txtphone: {
					required: true,
					minlength: 4,
					maxlength:15,
					digits: true
					
				},
				chkbox:{
					required: true,
				},
				
				
			},
			//set messages to appear inline
			messages: {
			
				txtfirstname: {
					required: "",
				},
				
				txtlastname: {
					required: "",
				},
				
				txtusername: {
					required: "",
				},
				
				txtpassword: {
				required: "",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},
				
				txtemail: "",
				
				txtphone: {
				required: "",
				minlength: "Number must be at least 4 characters long",
				maxlength: "Number can not be more than 15 characters"
				},
				
						
				chkbox: {
				required: "In order to use our services, you must agree to Travel Eazy's Terms of Service.",
				
				},
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});		
		
		$("#frmlogin").validate({
			errorElement: "spnError",			 
			//set the rules for the fild names
			rules: {				
				txtUserName: {
					required: true,
					email: true
					
				},
				txtPassword: {
					required: true,
					minlength: 6,
					maxlength:50
				},				
			},
			//set messages to appear inline
			
			

			messages: {	
			
				txtUserName:"" ,
							
				txtPassword: {
				required: "",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},				
								
			},
			
					
			errorPlacement: function(error, element) {               
				error.appendTo(element.parent());     
			}

		});	
		
		$("#changepwd").validate({
			
			 errorElement: "spnError", 
			 
			 
			//set the rules for the fild names
			rules: {
			
				
				txtnewpwd: {
					required: true,
					minlength: 6,
					maxlength:50
				},
				
				txtcnewpwd: {
					required: true,
					equalTo: "#txtnewpwd",
					minlength: 6,
					maxlength:50
				},
				
				txtoldpwd: {
					required: true,
					minlength: 6,
					maxlength:50
				},
				
				
				
			},
			//set messages to appear inline
			messages: {				
				
				txtnewpwd: {
				required: "",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},
				
				txtcnewpwd: {
				required: "",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters",
				equalTo: "Password not matching"
				},
				
				txtoldpwd: {
				required: "",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Password can not be more than 15 characters"
				},				
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});	
		
		
		
		
		
		$("#vechicleform").validate({
			
			 errorElement: "spnError", 
			 
			 
			//set the rules for the fild names
			rules: {
			
				
				vechicletype: {
					required: true,					
				},
				
				vechiclecategory: {
					required: true,					
				},
				
				txtvechicle: {
					required: true,
					
				},
				
				
				
			},
			//set messages to appear inline
			messages: {				
				
				vechicletype: {
				required: "",
				
				},
				
				vechiclecategory: {
				required: "",
				
				},
				
				txtvechicle: {
				required: "",
				
				},				
				
				
			},
			
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
				}

		});			
		

		
	});