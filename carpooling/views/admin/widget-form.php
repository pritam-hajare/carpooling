<?php include('header.php'); ?>
<?php include('left.php'); ?>

<div id="content-wrapper">
					<div class="row">
						<div class="col-lg-12">
							
							<div class="row">
								<div class="col-lg-12">
									<ol class="breadcrumb">
										<li><a href="#">Home</a></li>
										<li class="active"><span>Edit Widget</span></li>
									</ol>
									
									
								</div>
							</div>
							<div class="row">
								
								<div class="col-lg-12">
									<div class="main-box">
										<header class="main-box-header clearfix">
											<h2>Widget Form</h2>
										</header>
										  <?php 
										 
										  echo form_open($this->config->item('admin_folder').'/widgets/widget_form/'.$id,' id="req-form"'); ?>
										<div class="main-box-body clearfix">
                                     <div class="row">
											<div class="form-group col-xs-3">
												   <label><b>Widget Name</b></label>
                                                    <?php
													$data	= array('name'=>'widget_name', 'value'=>set_value('widget_name', $widget_name), 'class'=>'form-control');
													echo form_input($data); ?>
											</div>
                                    </div>
                                    <div class="row">
											<div class="form-group col-xs-3">
												   <label><b>Widget Link</b></label>
                                                     <?php
													$data	= array('name'=>'widget_link', 'value'=>set_value('widget_link', $widget_link), 'class'=>'form-control','cols'=>'30','rows'=>'10');
													echo form_textarea($data); ?>
											</div>
                                    </div>
                                    <div class="row">
											<div class="form-group col-xs-3">
												   <label><b>Widget Script</b></label>
                                                    <?php
													$data	= array('name'=>'widget_script', 'value'=>set_value('widget_script', $widget_script), 'class'=>'form-control','cols'=>'30','rows'=>'10');
													echo form_textarea($data); ?>
											</div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-xs-5">
                                            <label><b>Widget Status</b></label>
                                               <div class="checkbox-nice">
												   <?php
                                                    $data	= array('name'=>'widget_flag', 'value'=>1,'id'=>'checkbox-1', 'checked'=>$widget_flag);
                                                    echo form_checkbox($data) ?>
                                                       
                                                        <label for="checkbox-1">
                                                            <?=lang('active');?>
                                                        </label>
                                                </div>
                                              
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
    
	<!--<script src="<?php echo admin_js('bootstrap.js');?>"></script>-->
     <script src="<?php echo admin_js('jquery.maskedinput.min.js');?>"></script>
	 <script src="<?php echo admin_js('bootstrap-datepicker.js');?>"></script>
    
 <script>
var baseurl = "<?php print base_url(); ?>";
function redirect()
{
	window.location = baseurl +'admin/radius'
}
</script> 
 
<?php include('footer.php'); ?>
