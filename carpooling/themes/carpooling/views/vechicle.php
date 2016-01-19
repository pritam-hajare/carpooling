<?php include('header.php');?>
<?php echo theme_js('jquery-ui.js', true);?>

<?php  echo theme_css('themes/base/jquery.ui.all.css', true);?>
<?php echo theme_js('popup.js', true);?>

<script type="text/ecmascript">
function viewForgetpassword()
 {
	
	
	JqueryPopup('Forget Password', 470, 470, '<?php echo base_url('provider/login/forget_popup'); ?>');
}
</script>
<div class="header pst_cnt">
	<div class="post_wrap">
    	
        <div class="ad_trp">
         <?php $attributes = array('id' => 'vechicleform');				
                echo form_open_multipart('travel/vechicle/vechicleform/'.$vechicle_id, $attributes); ?>
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
                  
                  <h3>Add Vehicle Info</h3>
            	<div class="ad_trip_bx">
            	<div class="ad_vhl">
                	<span>Travel Type</span>
                    <?php
				
				$data	= array(0 => '-- Select --');
				
				foreach($vechicletype as $parent)
				{
					
						$data[$parent->vechicle_type_id ] = $parent->vechicle_type_name;
					
				}
				echo form_dropdown('vechicletype', $data, $vechicle_type_id,' id="veh" onchange="get_vehicle();"');
				?>
                </div> <br /><br /><br /><br />
                <div class="ad_vhl">
                	<span>Vehicle Number :</span>
                    <input type="text" placeholder="Vechicle Number" name="txtvechicle" id="txtvechicle" value="<?=$txtvechicle?>" />
                </div>
                 <div class="ad_vhl">
                	<span>Attach if, your Vechicle Photo(only .jpeg,.png) </span>
                <input type="file" class="upload_res" name="userfile">
                </div>
            </div>
                 <div class="pst_subm">
                	<input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
<input type="hidden" value="1" name="submitted" />
                	<label> <input type="Submit" value="Submit" class="search_but"> </label>
                    </form>
                	</div>
            </div>
            <!-- End Project Left -->
      
       
    </div>
</div>
<script type="text/javascript" src="<?php echo theme_js('jquery.validate.js');?>"></script>
<script type="text/javascript" src="<?php echo theme_js('travel-details-rules.js');?>"></script>
<?php include('footer.php');?>
