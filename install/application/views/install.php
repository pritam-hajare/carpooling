<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<style type="text/css">
 .para { color:red; }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Carpooling Script Installation</title>
<!-- must have -->
<link href="<?php echo $subfolder;?>assets/css/style.css" type="text/css" rel="stylesheet"/>


</head>

<body>




<div class="container-main fixed borderbottom blue-bg">
	<div class="container">
		<div class="logo"> <a href="#"> <img src="<?php echo $subfolder;?>assets/img/logo-install.png"> </a> </div>
		<ul class="fright nav-top">
            <li><a href="http://www.carpoolingscript.com/">Home</a></li>
            <li><a href="http://www.carpoolingscript.com/php-carpooling-script-features/">Features</a></li>
            <li><a href="http://www.carpoolingscript.com/buy-carpooling-script/">Buy Now</a></li>
            <li><a href="http://www.carpoolingscript.com/install-guide/">Install Guide</a></li>
            <li><a href="http://www.carpoolingscript.com/faq/">FAQ</a></li>
            <li><a href="http://www.carpoolingscript.com/support/">Support</a></li>
            <li><a href="http://www.carpoolingscript.com/contact-us/">Contact Us</a></li>
            <li class="blue-text"><a href="http://www.carpoolingscript.com/demo/">Demo</a></li>	
        </ul>
	</div>
</div>
<!-- Header -->

<div class="container-main margintop140 marginbottom40">
	<div class="container">
		<div class="width960 center">
        <?php if(!$config_writable):?>
			<div class="alert alert-error">
				<p>The <?php echo $relative_path?> folder is not writable! This is required to generate the config files.</p>
			</div>
		<?php endif;?>
		<?php if(!$root_writable):?>
			<div class="alert alert-error">
				<p>The root folder is not writable! This is required if you want to eliminate "index.php" from the URL by generating an .htaccess file.</p>
			</div>
		<?php endif;?>
		<?php if($errors):?>
			<div class="alert alert-error">
				<?php echo $errors;?>
			</div>
		<?php endif;?>
			<h2 class="size40 bold">Installing Carpooling Script</h2>
            <?php echo form_open('/');?>			
			<h3 class="left bold"> Step 1 - Database Information: </h3>
            <div class="row fleft padding10 blue-bg marginbottom40">            
				<div class="padding10 fleft width100">
					<ul class="con-main">						
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Hostname', 'name'=>'hostname', 'value'=>set_value('hostname', 'localhost') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Database Name', 'name'=>'database', 'value'=>set_value('database') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Username', 'name'=>'username', 'value'=>set_value('username') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Password', 'name'=>'password', 'value'=>set_value('password') ));?>
						</li>						
					</ul>
				</div>
				<!-- End Left -->				
			</div>
            
            <h3 class="left bold"> Step 2 - Admin Information: </h3>
            <div class="row fleft padding10 blue-bg marginbottom40">            
				<div class="padding10 fleft width100">
					<ul class="con-main">						
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Admin Email', 'name'=>'admin_email', 'value'=>set_value('admin_email') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Admin Password', 'name'=>'admin_password', 'value'=>set_value('admin_password') ));?>
						</li>						
					</ul>
				</div>
				<!-- End Left -->				
			</div>
            
            <h3 class="left bold"> Step 3 - Company Information: </h3>
            <div class="row fleft padding10 blue-bg marginbottom40">           
				<div class="padding10 fleft width100">
					<ul class="con-main">						
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Company Name', 'name'=>'company_name', 'value'=>set_value('company_name') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Website Email', 'name'=>'website_email', 'value'=>set_value('website_email') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Site Admin Email', 'name'=>'site_admin_email', 'value'=>set_value('site_admin_email') ));?>
						</li>						
						<li>
                         <?php
							$data	= array('name'=>'mod_rewrite', 'value'=>1,'checked'=>(bool)set_value('mod_rewrite'),'class'=>'chkbox');
							echo form_checkbox($data) ?>
							 <span>Remove "index.php" from the url <small>(requires Apache with mod_rewrite)</small></span>
						</li>
					</ul>
				</div>
				<!-- End Left -->				
			</div>
            
            <h3 class="left bold"> Step 4 - Address information: </h3>
            <div class="row fleft padding10 blue-bg marginbottom40">            
				<div class="padding10 fleft width100">
					<ul class="con-main">						
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Address', 'name'=>'address1', 'value'=>set_value('address1') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Address 2', 'name'=>'address2', 'value'=>set_value('address2') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'City', 'name'=>'city', 'value'=>set_value('city') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'State', 'name'=>'state', 'value'=>set_value('state') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Zip', 'name'=>'zip', 'value'=>set_value('zip') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Country Short Name(US)', 'name'=>'country', 'value'=>set_value('country') ));?>
						</li>
					</ul>
				</div>
				<!-- End Left -->				
			</div>
            
			<h3 class="left bold"> Step 5 - Oauth Information: </h3>
            <div class="row fleft padding10 blue-bg marginbottom40">            
				<div class="padding10 fleft width100">
					<ul class="con-main">						
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Facebook App Id', 'name'=>'facebook_app_id', 'value'=>set_value('facebook_app_id') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Facebook App Secret Id', 'name'=>'facebook_app_secret_id', 'value'=>set_value('facebook_app_secret_id') ));?>
						</li>
						<li>
							<div class="glyphicon con-ico"></div>
							 <?php echo form_input(array('class'=>'span8', 'placeholder'=>'Google App Id', 'name'=>'google_app_id', 'value'=>set_value('google_app_id') ));?>
						</li>						
						<li>
							<?php echo form_input(array('class'=>'span8', 'placeholder'=>'Google App Secret Id', 'name'=>'google_app_secret_id', 'value'=>set_value('google_app_secret_id') ));?>
						</li>
					</ul>
				</div>
				<!-- End Left -->				
			</div>
            <h3 class="left bold"> Step 6 - Final Step: </h3>
            <div class="para">
            <p>The Step-6 of installation guide will hold good only for first version. This section has been given for the purpose of testing, using a sample data, which is one time only. Since you will be downloading version 1.3, and not the first version, do not select this option.</p> 
            </div>
            <div class="row fleft padding10 blue-bg marginbottom40">            
				<div class="padding10 fleft width100">
					<ul class="con-main">						
						<li>
							<div class="glyphicon con-ico"></div>
							<?php $data	= array('name'=>'sample_data', 'value'=>1,'checked'=>(bool)set_value('sample_data'),'class'=>'chkbox');
								  echo form_checkbox($data) ?>
								  <span>Install Sample Data</span>
						</li>
						<li class="no-border">
							<button type="submit" class="cont-sbmt">Install Carpooling!</button>
						</li>
					</ul>
				</div>
				<!-- End Left -->				
			</div>
		</div>
	</div>
</div>

</body>
</html>