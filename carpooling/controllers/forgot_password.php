<?php include('header_login.php');?>
<style type="text/css">
/*forget password*/
 .forget {  text-align:center; }
</style>
<script type="text/javascript">
  var baseurl = "<?php print base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo theme_js('jquery.validate.js');?>"></script>
<script type="text/javascript">

function showdiv(id) {
  
  
	$("#resend").hide();
		
	
	$("#resendsuccess").show();
	
 
   
}
function notRecive(id) {
  
  
	$("#resendsuccess").hide();
		
	
	$("#resend").show();
	
  
   
}
	$(document).ready(function() {
		
		
			$("#resendForm").validate({
			errorElement: "div",			 
			//set the rules for the fild names
			rules: {				
				email: {
					required: true,
					email: true
					
				}
								
			},
			//set messages to appear inline
			messages: {				
				email: "",				
								
			},
			
			submitHandler: function(form) {
            			$('#resendStatus').html('Please wait...');		
				$.ajax({
					type: "POST",	
					url: '<?php echo base_url('admin/login/send_password/true'); ?>',	
					dataType: "json",	
					data:$('#resendForm').serialize(),
					success: function(json)	{
				
						if (json.result == 0){
						
							$('#resendStatus').html(json.message);
						
							
							return false;
						} else if (json.result == 1) {
							$('#resendStatus').html('');
							$('#statusmsg').html(json.message);
							showdiv('login');
							
						}
					}
				});
			      
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

		});
</script>

    <div class="container">
        <div class="row">
        	<div class="main-box-body clearfix">
            <?php if ($this->session->flashdata('message')):?>
                <div class="alert alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-check-circle fa-fw fa-lg"></i>
                    <strong>Well done!</strong> <?php echo $this->session->flashdata('message');?>
                </div>
                <?php endif;?>
                
                <?php if ($this->session->flashdata('error')):?>
                <div class="alert alert-danger fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-times-circle fa-fw fa-lg"></i>
                    <strong>Oh snap!</strong> <?php echo $this->session->flashdata('error');?>
                </div>
                <?php endif;?>
                <?php if (!empty($error)):?>
                <div class="alert alert-danger fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-times-circle fa-fw fa-lg"></i>
                    <strong>Oh snap!</strong> <?php echo $error;?>
                </div>
                <?php endif;?>
            </div>
            <div class="col-xs-12">
                <div id="login-box">
                    <div id="login-box-holder">
                        <div class="row">
                            <div class="col-xs-12">
                            <header id="login-header">
                             <div id="login-logo">
                              <img src="<?php echo theme_img('logo.png');?>" alt=""/>
                             </div>
                            </header>
                            <div id="login-box-inner" class="with-heading">
                             <h4>Forgot your password?</h4>
                             <div id="resend">
                             <p>
                              Enter your email address to recover your password.
                             </p>
                             <form role="form" id="resendForm">
                             <div  id="resendStatus">
												
											
											</div>
                              <div class="input-group reset-pass-input">                             
                               <span class="input-group-addon"><i class="fa fa-user"></i></span>                              
                               <input class="form-control" type="text" name="email" id="email" placeholder="Email address">
                              </div>
                              <div class="row">
                               <div class="col-xs-12">
                               <input type="hidden" value="1" name="submitted" />
                             <input type="hidden" value="" name="redirect"/>
                             
                                <button type="submit" class="btn btn-success col-xs-12">Reset password</button>
                               </div>
                               <div class="col-xs-12">
                                <br>
                                <a href="<?php echo base_url('admin/login'); ?>" id="login-forget-link" class="forgot-link col-xs-12">Back to login</a>
                               </div>
                              </div>
                             </form>
                             </div>
                             <div id="resendsuccess" style="display:none">
                                <div class="col-xs-12">
                                   <div id="statusmsg"></div>
                                    <br>
                                    <a href="javascript:void(0)" id="login-forget-link" onclick="notRecive('login');" class="forgot-link col-xs-12">Back to login</a>
                                   </div>                              
                              </div>
                             
                            </div>
                           </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo admin_js('jquery.validate.js');?>"></script>
<?php echo admin_js('jquery.validate-rules.js', true);?>

    
    <script type='text/javascript'>
    /* attach a submit handler to the form */
    $("#login-form").submit(function(event) 
	
	{
		
	
		
      /* stop form from submitting normally */
      event.preventDefault();

      if($("#login-form").valid())
	  {
	   $('#spnError').html('Checking...');
	 $.ajax({
					type: "POST",	
					url: baseurl + "admin/login/ajax_login/true",	
					dataType: "json",	
					data:$('#login-form').serialize(),
					success: function(json)	{
				
						if (json.result == 0){
							
							$('#spnError').html('Invalid Login!');
							$('#spnError').addClass('alert alert-danger')
							
						
							//$('#spnError').show();
							return false;
						} else if (json.result == 1) {
							$('#spnError').addClass('alert alert-success')
							
							$('#spnError').html('Success...Transferring');
							window.location	= baseurl + json.redirect;
						}
					}
				});
	  }
	 
    });
</script>
</body>
</html>