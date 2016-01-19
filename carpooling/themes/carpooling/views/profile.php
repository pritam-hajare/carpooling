<?php include('header.php');?>
<?php echo theme_js('jquery_tab.min.js',true) ?>
<?php echo theme_js('jquery.ba-hashchange.js',true) ?>
<?php echo theme_js('tab_script.js',true) ?>
<?php echo theme_js('jquery.wallform.js',true) ?>
<?php echo theme_js('notification/goNotification.js',true) ?>
<link href="<?php echo theme_js('notification/goNotification.css') ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo theme_js('popup/css/jquery-confirm.css') ?>" />

<link rel="stylesheet" href="<?php echo theme_js('popup/boxy.css') ?>">
<?php echo theme_js('popup/jquery.boxy.js',true) ?>
<?php echo theme_css('checkbox.css',true) ?>





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
			position: 'top center', // bottom left | bottom right | bottom center | top left | top right | top center
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
			position: 'top center', // bottom left | bottom right | bottom center | top left | top right | top center
			timeout: 200000, // time in milliseconds to self-close; false for disable 4000 | false
			animation: 'fade', // fade | slide
			animationSpeed: 'slow', // slow | normal | fast
			allowClose: true, // display shadow?true | false
			});
		<?php
		}
		?>
		
			
	});
	

<?php /*?>function areyousure()
{
	//return confirm('<?php echo 'Are you want to delete this Vehicle';?>');
	 Boxy.confirm("Please confirm:", function() { return true; }, {title: 'Message'});
    //return false;

}	<?php */?>
	
 
var baseurl = "<?php print base_url(); ?>";  
</script>
<script type="text/javascript" src="<?php echo theme_js('jquery.validate.js');?>"></script>
<?php echo theme_js('profile.js',true) ?>
<style>
.size14 {
    font-size: 14px;
    margin-left: 20px;
}
</style>
<div class="container-fluid margintop40">
  <div class="container">
     <div class="row"> 
    <ul class="row brd-crmb">
      <li><a href="#"> <img src="<?php echo theme_img('home-ico.png') ?>"> </a></li>
      <li> / </li>
      <li><a href="#"><?php echo lang('my_account');?></a></li>
      <li> / </li>
      <li><a href="#"><?php echo lang('personal_information');?></a></li>
    </ul>
    </div>
    </div>
    </div>
   <div class="container-fluid">
  <div class="container">
    <div class="row">
      
      <div id="v-nav">
        <ul>
            <li tab="personal-info" class="first current vtab"> <span> <img src="<?php echo theme_img('profile-tab-ico.png') ?>"> </span> <?php echo lang('personal_info');?></li>
            <li tab="settings" class="vtab"> <span> <img src="<?php echo theme_img('preference-tab-ico.png') ?>"> </span> <?php echo lang('settings');?></li>
            <li tab="my-cars-info" class="last vtab"> <span> <img src="<?php echo theme_img('my-car-tab-ico.png') ?>"> </span> <?php echo lang('my_cars');?></li>
        </ul>
        
        <?php 
		$attributes = array('id' => 'profileimageform');
		echo form_open_multipart(base_url('profile/profile_image_upload'),$attributes);?>
		<div  class="uploadFile timelineUploadImg" style="display:none">
		<input type="file"  name="profileimg" id="profileimg">
		</div>		      
		</form>

        <div class="tab-content" style="display: block;">
                 <?php 
							 $attributes = array('id' => 'changepwd');	
							echo form_open('profile/edit/'.$id,$attributes); ?>
               
            
            <div class="rowrec">
              <div class="profile-pic" id="ProfilePic"> 
              <img src="<?php if($customer->user_profile_img) { echo theme_profile_img($customer->user_profile_img); } else { echo theme_img('default.png');  }?>" id="old-image" width="100" height="100"> </div>
              <h3 class="profile-hd-tit"> <?=$customer->user_first_name ?>  <a href="javascript:void(0)" id="edit-profile"> (Edit Photo) </a> </h3>
              <div id='imageloadstatus' style="display:none">
                <img src='<?php echo theme_img('ajaxloader.gif'); ?>'/> Uploading please wait ....
              </div>   
              <div class="rowrec line4"></div>
            <div class="rowrec">
                <div class="inner-trip-det marginbot10">
                  <div class="sea-city-city topbg colorwhite padding10 cs-blue-text size16"> 
                    <?php echo lang('mobile_number');?>
                  </div>
                  <div class="padding20 row">
                    <div class="fleft pro-tab-cont">
                      <input type="text" placeholder="Mobile No." class="disable" name="txtphone" id="txtphone"  value="<?=$txtphone?>"/>                  
                    </div>
                  </div>
                </div>
              </div>
              <!-- End1 -->

              <div class="rowrec">
                <div class="inner-trip-det marginbot10">
                  <div class="sea-city-city topbg colorwhite padding10 cs-blue-text size16"> 
                    <?php echo lang('email');?>
                  </div>
                  <div class="padding20 rowrec">
                    <h5><?php echo lang('main_email');?></h5>
                    <div class="fleft pro-tab-cont full-width paddingtop10">
                      <input type="text" placeholder="Email Id" class="disable" name="txtemail" id="txtemail" readonly value="<?=$txtemail?>" />
                    </div>                   
                  </div>

                  <div class="padding20 rowrec">
                    <h5><?php echo lang('official_email');?></h5>
                    <div class="fleft pro-tab-cont full-width paddingtop10">
                      <input type="text" placeholder="Alternative Email Id" name="atxtemail" id="atxtemail" value="<?=$atxtemail?>" />
                    </div>                  
                  </div>
                  
                   <div class="padding20 rowrec">
                    <h5><?php echo lang('official_email_as_communication');?></h5>
                    <div class="fleft paddingtop10">
                       <?php
							$data	= array('name'=>'mail_flg', 'value'=>1 ,'class'=>'chkml' ,'checked'=>$mail_flg);
							echo form_checkbox($data); ?>
                    </div>                  
                  </div>                  

                </div>
              </div>
              <!-- End2 -->

              <div class="rowrec">
                <div class="inner-trip-det marginbot10">
                  <div class="sea-city-city topbg colorwhite padding10 cs-blue-text size16"> 
                    <?php echo lang('personal_info');?>
                  </div>
                  <div class="padding20 rowrec">
                    <div class="fleft pro-tab-cont">
                      <h5><?php echo lang('first_name');?></h5>
                     <input type="text" placeholder="First Name" name="txtfirstname" id="txtfirstname" value="<?=$txtfirstname?>"/>
                    </div>
                    <div class="fright pro-tab-cont">
                      <h5><?php echo lang('birthdate');?></h5>
                      <div class="sea-city-city rowrec perso-inf fright cs-grey-text size14 ed-tme"> 
                        <span><?php echo lang('day');?></span>
                        <?php 
						$days = array();
						for($day = 1; $day <= 31; $day++): 
							$days[$day] = $day;
							 endfor;
							 echo form_dropdown('day', $days, $selday, ' id="day" ');
							 ?>
                        <span><?php echo lang('month');?></span>
                        <?php $data = array(
						'' => 'Month',
						'January'=>'January',
						'February'=>'February',
						'March'=>'March',
						'April'=>'April',
						'May'=>'May',
						'June'=>'June',
						'August'=>'August',
						'September'=>'September',
						'October'=>'October',
						'November'=>'November',
						'December'=>'December');
						 echo form_dropdown('month', $data, $month, ' id="month" ');?>

                        <span><?php echo lang('year');?></span>
                        <?php 
						$years = array();
						for($iYear = date('Y'); $iYear >= date('Y') - 50; $iYear--): 
							$years[$iYear] = $iYear;
							 endfor;
							  echo form_dropdown('year', $years, $year, ' id="year" ');
                    	?>    
                      </div>
                    </div>
                  </div>

                  <div class="padding20 rowrec">
                    <div class="fleft pro-tab-cont">
                      <h5><?php echo lang('last_name');?> </h5>
                       <input type="text" placeholder="Last Name"  name="txtlastname" id="txtlastname" value="<?=$txtlastname?>" />
                    </div>
                    <div class="fright pro-tab-cont">
                      <h5> <?php echo lang('about_you');?> </h5>
                      <textarea rows="4" name="txtaboutus" placeholder="Tell me about you"><?=$txtaboutus?></textarea>
                    </div>
                  </div>

                  <div class="padding20 rowrec">
                    <div class="fleft row pro-tab-chk">
                     <!-- <h5><?php echo lang('share_the_follow');?></h5>
                      <label><input type="checkbox"><?php echo lang('mobile_phone');?></label>
                      <label><input type="checkbox"><?php echo lang('email');?></label>
                      <label><input type="checkbox"><?php echo lang('facebook_profile');?></label>
                      <p><label><input type="checkbox"> <?php echo lang('i_agree_to');?> </label> -->
                        <div class="fright row size14 sea-trp-view"> 
                        <input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
                        <input type="hidden" value="1" name="submitted" />
                        <input type="Submit" value="<?php echo lang('submit');?>" class="green-bg padchg">
                         
                        </div>
                      </p>
                    </div>
                  </div>

                </div>                 


              </div>
            </div>
            <!-- End3 -->
			</form>
        </div>

        <div class="tab-content" style="display: none;">
        	<?php include('settings.php');?>
        </div>

        <div class="tab-content" style="display: none;">
            <div id="vehicle-list">
            	<?php include('vechicles.php');?>
            </div>   
            <div id="vehicle-from-content" style="display:none">
            	
            </div>           
			
        </div>



    </div>
    <!-- End V Tab -->

    </div>
    <!-- End -->

    </div>


  </div>
</div>
<div class="modal"></div>
