<?php include('header.php');?>
<?php  $this->load->helper('html');?>
<script type="text/javascript" src="<?php echo theme_js('jquery.validate.js');?>"></script>
<script type="text/javascript" src="<?php echo theme_js('travel-details-rules.js');?>"></script>
<?php echo theme_js('notification/goNotification.js',true) ?>
<link href="<?php echo theme_js('notification/goNotification.css') ?>" rel="stylesheet" type="text/css">
<script>
$(document).ready(function() {	
	
		<?php if (empty($txtphone)){ ?>
		$('#txtphone').attr('readonly', false);
		$('#txtphone').removeClass('disable');
		<?php } ?>
		
		<?php
		//lets have the flashdata overright "$message" if it exists
		if($this->session->flashdata('message'))
		{
			$message	= $this->session->flashdata('message'); ?>
			$.goNotification('<?=$message?>', { 
			type: 'success', // success | warning | error | info | loading
			position: 'top center', // bottom left | bottom right | bottom center | top left | top right | top center
			timeout: 5000, // time in milliseconds to self-close; false for disable 4000 | false
			animation: 'fade', // fade | slide
			animationSpeed: 'slow', // slow | normal | fast
			allowClose: true, // display shadow?true | false
			});
		<?php }
		
		if($this->session->flashdata('error'))
		{
			$error	= $this->session->flashdata('error'); 
			?>
			$.goNotification("<?=trim($error)?>", { 
			type: 'error', // success | warning | error | info | loading
			position: 'top right', // bottom left | bottom right | bottom center | top left | top right | top center
			timeout: 5000, // time in milliseconds to self-close; false for disable 4000 | false
			animation: 'fade', // fade | slide
			animationSpeed: 'slow', // slow | normal | fast
			allowClose: true, // display shadow?true | false
			});
		<?php
		}
		
		if(function_exists('validation_errors') && validation_errors() != '')
		{
			$error	= validation_errors();
			?>
			$.goNotification('<?=trim($error)?>', { 
			type: 'error', // success | warning | error | info | loading
			position: 'top right', // bottom left | bottom right | bottom center | top left | top right | top center
			timeout: 200000, // time in milliseconds to self-close; false for disable 4000 | false
			animation: 'fade', // fade | slide
			animationSpeed: 'slow', // slow | normal | fast
			allowClose: true, // display shadow?true | false
			});
		<?php
		}
		?>
		
			
	});
</script>   
<div class="container-fluid margintop40">
        <div class="container">
            <div class="row margintop40"> 

     <div class="col-lg-5 col-md-5 col-sm-6 padding20 reg-main">
        <ul class="reg-cont margintop40">
          <li>
            <h3><?php echo lang('welcome_to_car_pooling');?></h3>
            <p><?php echo lang('welcome_para');?></p>
          </li>
          <li>
            <h3><?php echo lang('Find_a_ride_and_Share_a_ride');?></h3>
            <p><?php echo lang('find_para');?></p>
          </li>
          <li>
            <h3><?php echo lang('save_money_fuel_environment');?></h3>
            <p><?php echo lang('save_para');?></p>
          </li>
        </ul>
      </div>      

      <div class="col-lg-6 col-md-6 col-sm-6 fleft padding20 grey-bg reg-main">
        <h2 class="center marginbot40"> <?php echo lang('join_carpooling');?> </h2>
        <?php 
				  $attributes = array('id' => 'frmregister');
				 
				 echo form_open('register',$attributes); ?>
             <input type="hidden" name="submitted" value="submitted" />
			<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        <ul class="top-nav reg-nav">
          <li> <a href="<?php echo site_url('login/facebooklogin');?>" class="flogin regflogin"> <?php echo lang('login');?> </a> </li>
          <li class="reg-rht"> <a href="<?php echo site_url('login/googlelogin');?>" class="gplogin regglogin"> <?php echo lang('login');?> </a> </li>
        </ul>
        <ul class="rowrec reg-inp">
          <li>
            <span><?php echo lang('first_name');?></span>
            <input type="text" placeholder="First name" name="txtfirstname" id="txtfirstname" value="<?=$txtfirstname?>"/> 
          </li>
           <li>
            <span><?php echo lang('last_name');?></span>
            <input type="text" placeholder="Last name"  name="txtlastname" id="txtlastname" value="<?=$txtlastname?>" />
          </li>
          <li>
            <span><?php echo lang('email_id');?></span>
             <input type="text" placeholder="Email Id" name="txtemail" id="txtemail" value="<?=$txtemail?>" />
          </li>
          <li>
            <span><?php echo lang('mobile_no');?></span>
             <input type="text" placeholder="Mobile no." name="txtphone" id="txtphone" value="<?=$txtphone?>"/>
          </li>
          
          <li>
            <span><?php echo lang('password');?></span>
            <input type="password" placeholder="Password" name="txtpassword" id="txtpassword" value="<?=$txtpassword?>" />
          </li>
          <li> <p> <?php echo lang('by_joining');?> <a href="#"><?php echo lang('terms');?></a>, <a href="#"><?php echo lang('privacy');?></a> <?php echo lang('and');?> <a href="#"><?php echo lang('ip_policy');?></a>. </p> </li>
          <li>
            <input type="submit" value="<?php echo lang('register');?>" class="fright reg-sbmt">
          </li>
        </ul>
        </form>
      </div>
      <!-- Right -->
    </div>
  </div>
</div>
<div class="container-fluid cs-blue-bg margintop40">
  <div class="container">
    <div class="margintop40 marginbot40 center gtcont">
      <h2 class="colorwhite"> <?php echo lang('got_a_question');?>? </h2>
      <p class="padding20 row colorwhite">We're here to help. Check out our FAQs, Send us an email or call us at 1800 555 555</p>
      <a href="#"> <?php echo lang('contact_now');?> </a> </div>
  </div>
</div>
<?php include('footer.php');?>
