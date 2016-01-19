<?php include('header_login.php');?>
<style type="text/css">
/*forget password*/
 .forget {  text-align:center; }
</style>

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
                                <div id="login-box-inner">
                                    <form id="login-form" >
                                      <div  id="spnError">
												
											
											</div>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <?php echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'Email address')); ?>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                            <?php echo form_password(array('name'=>'password', 'class'=>'form-control','placeholder'=>'Password')); ?>
                                        </div>
                                        <div id="remember-me-wrapper">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="checkbox-nice">
                                                    <?php echo form_checkbox(array('name'=>'remember','id'=>'remember-me', 'value'=>'true', 'class'=>'icheck-me'))?>
                                                        <label for="remember-me">
                                                            <?php echo lang('stay_logged_in');?>
                                                        </label>
                                                    </div>
                                                                                                    
                                            </div>
                                            <div class="col-xs-12">
                                            
                                                    <p class="forget"> <a href="<?php echo base_url('admin/login/forget_password'); ?>"><?php echo lang('forgot_password');?>?</a> </p> 
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button type="submit" class="btn btn-success col-xs-12">Login</button>
                                                <input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
												<input type="hidden" value="submitted" name="submitted"/>			
                                            </div>
                                        </div>                                       
                                    </form>
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