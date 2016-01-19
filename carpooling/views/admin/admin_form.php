<?php include('header.php'); ?>
<?php include('left.php'); ?>
<div id="content-wrapper">
					<div class="row">
						<div class="col-lg-12">
							
							<div class="row">
								<div class="col-lg-12">
									<ol class="breadcrumb">
										<li><a href="#">Home</a></li>
										<li class="active"><span>Add New User</span></li>
									</ol>
									
									
								</div>
							</div>
							<div class="row">
								
								<div class="col-lg-12">
									<div class="main-box">
										<header class="main-box-header clearfix">
											<h2> <?php if(!empty($page_title)):?>
	
		<?php echo  $page_title; ?>
           <?php endif; ?></h2>
										</header>
										 
                                         <?php echo form_open($this->config->item('admin_folder').'/admin/form/'.$id); ?>
										<div class="main-box-body clearfix">
                                     <div class="row">
											<div class="form-group col-xs-3">
<label><b><?php echo ('Admin Name');?></b></label>
		<?php
		$data	= array('name'=>'name', 'value'=>set_value('name', $name), 'class'=>'form-control');
		echo form_input($data);
		?>
        	</div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-xs-5">
		<label><b><?php echo lang('email');?></b></label>
		<?php
		$data	= array('name'=>'email', 'value'=>set_value('email', $email), 'class'=>'form-control');
		echo form_input($data);
		?>											</div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-xs-5">
                                    <label><b><?php echo lang('password');?></b></label>
		<?php
		$data	= array('name'=>'password', 'class'=>'form-control');
		echo form_password($data);
		?></div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-xs-5">
                                    <label><b><?php echo lang('confirm_password');?></b></label>
		<?php
		$data	= array('name'=>'confirm', 'class'=>'form-control');
		echo form_password($data);
		?>
                                    
                                    </div>
                                    </div>
                                            <div class="row">
                                            <div class="form-group">
												
                                                    
                                                      <div class="actions">
                                                      
                                                       <button data-last="Finish" class="btn btn-success btn-mini btn-next" type="submit">Save<i class="icon-arrow-right"></i></button>
                                                      <button class="btn btn-default btn-mini btn-prev"  onClick="redirect();" type="button"> <i class="icon-arrow-left"></i>Cancel</button>
            
		</div>
	
</form>
                                                      
                                                     
														
														
													</div>
												</div>
                                                
                                                
                                                
											</div>
										</div>
                                        
                                       
							
						</div>
					</div>	
                    </div>

<script type="text/javascript">
if ($.browser.webkit) {
    $('input').attr('autocomplete', 'off');
}
$('form').submit(function() {
	$('.btn').attr('disabled', true).addClass('disabled');
});
</script>
<script>
var baseurl = "<?php print base_url(); ?>";
function redirect()
{
	window.location = baseurl +'admin/admin'
}
</script>
<?php include('footer.php');