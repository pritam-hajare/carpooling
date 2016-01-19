<?php include('header.php'); ?>
<?php include('left.php'); ?>

<div id="content-wrapper">
					<div class="row">
						<div class="col-lg-12">
							
							<div class="row">
								<div class="col-lg-12">
									<ol class="breadcrumb">
										<li><a href="#">Home</a></li>
										<li class="active"><span>Add New Email Template</span></li>
									</ol>
									
									
								</div>
							</div>
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
	
	<div id="js_error_container" class="alert alert-error" style="display:none;"> 
		<p id="js_error"></p>
	</div>
	
	<div id="js_note_container" class="alert alert-note" style="display:none;">
		
	</div>
	
	<?php if (!empty($message)): ?>
		<div class="alert alert-success">
			<a class="close" data-dismiss="alert">×</a>
			<?php echo $message; ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($error)): ?>
		<div class="alert alert-error">
			<a class="close" data-dismiss="alert">×</a>
			<?php echo $error; ?>
		</div>
	<?php endif; ?>
							
							<div class="row">
								
								<div class="col-lg-12">
									<div class="main-box">
										<header class="main-box-header clearfix">
											<h2>Add Email Template</h2>
										</header>
										  <?php 
										 
										  echo form_open($this->config->item('admin_folder').'/settings/canned_message_form/'.$id,' id="req-form"'); ?>
                                    <div class="main-box-body clearfix">
                                     <div class="row">
                                        <div class="form-group col-xs-5">
                                               <label><b>Email Name</b></label>
                                               
                                                    <?php
								$name_array = array('name' =>'email_name', 'class'=>'form-control', 'value'=>set_value('email_name', $email_name));
							
								echo form_input($name_array);?>
                                        </div>
                                </div>
                                     <div class="row">
											<div class="form-group col-xs-5">
												   <label><b>Email Subject</b></label>
                                                   
                                                        <?php echo form_input(array('name'=>'subject', 'class'=>'form-control', 'value'=>set_value('subject', $subject)));?>
											</div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-xs-9">
                                    <label><b>Email Message</b></label>
                                  <?php
									$data	= array('id'=>'description', 'name'=>'content','row'=>3, 'class'=>'form-control ckeditor', 'value'=>set_value('content', $content));
									echo form_textarea($data);
									?>
                                    </div>
                                    </div>
                                            <div class="row">
                                            <div class="form-group">
												
                                                    
                                                      <div class="actions">
                                                      <button data-last="Finish" class="btn btn-success btn-mini btn-next" type="submit">Save<i class="icon-arrow-right"></i></button>
														<button class="btn btn-default btn-mini btn-prev"  onClick="redirect();" type="button"> <i class="icon-arrow-left"></i>Cancel</button>
														
													</div>
												</div>
                                                
                                                
                                                
											</div>
											<br/><br/>
										</div>
                                        
                                        </form>
                                        
									</div>
								</div>	
							</div>
							
													
							
							
						</div>
					</div>
               

	<script type="text/javascript" src="<?php echo admin_js('jquery.validate.js');?>"></script>
<?php echo admin_js('jquery.validate-rules.js', true);?>
    
	
     <script src="<?php echo admin_js('jquery.maskedinput.min.js');?>"></script>
	 <script src="<?php echo admin_js('bootstrap-datepicker.js');?>"></script>
     <script src="<?php echo admin_js('ckeditor/ckeditor.js');?>"></script>
    
 <script>
var baseurl = "<?php print base_url(); ?>";
function redirect()
{
	window.location = baseurl +'admin/settings'
}
</script> 
 
<?php include('footer.php'); ?>
