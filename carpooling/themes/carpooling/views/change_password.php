<?php include('header.php');?>
<script type="text/javascript" src="<?php echo theme_js('jquery.validate.js');?>"></script>
<script type="text/javascript" src="<?php echo theme_js('travel-details-rules.js');?>"></script>
<div class="header indwrp">
<div class="header pst_cnt">
	<div class="post_wrap">
    	
        <div class="ad_trp">
         <?php 
							 $attributes = array('id' => 'changepwd');	
							echo form_open('profile/changepwd_form/'.$id,$attributes); ?>
                <?php
	//lets have the flashdata overright "$message" if it exists
	if($this->session->flashdata('message'))
	{
		$message	= $this->session->flashdata('message');
	}
	
	if($this->session->flashdata('error'))
	{
		$error	= $this->session->flashdata('error');
	}
	
	if(function_exists('validation_errors') && validation_errors() != '')
	{
		$error	= validation_errors();
	}
	?>
        	  <?php if ($this->session->flashdata('message')):?>
			<div class="alert alert-info">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('message');?>
			</div>
		<?php endif;?>
		
		<?php if ($this->session->flashdata('error')):?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('error');?>
			</div>
		<?php endif;?>
		
		<?php if (!empty($error)):?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $error;?>
			</div>
		<?php endif;?>
                  
                  <h3><?php echo lang('change_password');?></h3>
            	<div class="ad_trip_bx">
            	<div class="ad_vhl vh3">
                	<span class="pwd_span"><?php echo lang('old_password');?></span>
                    <?php $data	= array( 'name'=>'txtoldpwd','placeholder'=>'Old password','id'=>'txtoldpwd');
						echo form_password($data);?>
                </div> <br /><br /><br /><br />
                <div class="ad_vhl vh3">
                	<span class="pwd_span"><?php echo lang('new_password');?></span>
                    <?php $data	= array( 'name'=>'txtnewpwd','placeholder'=>'New password','id'=>'txtnewpwd');
						echo form_password($data);?>
                </div>
                <br /><br /><br /><br />
                 <div class="ad_vhl vh3">
                	<span class="pwd_span"><?php echo lang('confirm_new_pass');?> </span>
                 <?php $data	= array( 'name'=>'txtcnewpwd','placeholder'=>'Conform new password','id'=>'txtcnewpwd');
						echo form_password($data);?>
                </div>
            </div>
                 <div class="pst_subm">
                	<input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
<input type="hidden" value="1" name="submitted" />
                	<label class="btn_subm"> <input type="Submit" value="<?php echo lang('save');?>" class="search_but"> </label>
                    </form>
                	</div>
            </div>
            <!-- End Project Left -->
    </div>
</div>
</div>
<?php include('footer.php');?>
