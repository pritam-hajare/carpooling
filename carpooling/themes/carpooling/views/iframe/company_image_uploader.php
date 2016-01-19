<?php include('header.php');?>

<script type="text/javascript">

<?php if( $this->input->post('submit') ):?>
$(window).ready(function(){
	$('#iframe_uploader', window.parent.document).height($('body').height());	
});
<?php endif;?>

<?php 
//print_r($file_name);
if($file_name):
 ?>

	parent.add_company_image('<?php echo $file_name;?>');
<?php endif;?>

</script>

<?php if (!empty($error)): ?>
	<div class="alert alert-error">
		<a class="close" data-dismiss="alert">×</a>
		<?php echo $error; ?>
	</div>
<?php endif; ?>


		<?php echo form_open_multipart($this->config->item('travel_folder').'/vechicle/vehicle_image_upload');?>
			<div class="dash_row" style="width:680px;">
               <div class="post_row_lft"></div>
              <div class="post_row_rht">
			<?php echo form_upload(array('name'=>'userfile', 'id'=>'userfile', 'class'=>'upload_pho'));?>
             <input class="upload" name="submit" value="Upload" type="submit" value="<?php echo lang('upload');?>" />
             </div>
             </div>
		</form>
        
	

<?php include('footer.php');