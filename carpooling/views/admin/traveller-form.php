<?php include('header.php'); ?>
<?php include('left.php'); ?>

<div id="content-wrapper">
					<div class="row">
						<div class="col-lg-12">
							
							<div class="row">
								<div class="col-lg-12">
									<ol class="breadcrumb">
										<li><a href="#">Home</a></li>
										<li class="active"><span>Add New Travel User</span></li>
									</ol>
									
									
								</div>
							</div>
							<div class="row">
								
								<div class="col-lg-12">
									<div class="main-box">
										<header class="main-box-header clearfix">
											<h2>Add Travel User</h2>
										</header>
										  <?php 
										 
										  echo form_open($this->config->item('admin_folder').'/traveller/form/'.$userid,' id="req-form"'); ?>
										<div class="main-box-body clearfix">
                                     <div class="row">
											<div class="form-group col-xs-3">
												   <label><b>First Name</b></label>
                                                    <?php
													$data	= array('name'=>'userfirstname', 'value'=>set_value('userfirstname', $userfirstname), 'class'=>'form-control');
													echo form_input($data); ?>
											</div>
                                    </div>
                                    <div class="row">
											<div class="form-group col-xs-3">
												   <label><b>Last Name</b></label>
                                                     <?php
													$data	= array('name'=>'userlastname', 'value'=>set_value('userlastname', $userlastname), 'class'=>'form-control');
													echo form_input($data); ?>
											</div>
                                    </div>
                                    <div class="row">
											<div class="form-group col-xs-3">
												   <label><b>User Email</b></label>
                                                    <?php
													$data	= array('name'=>'usermail', 'value'=>set_value('usermail', $usermail), 'class'=>'form-control');
													echo form_input($data); ?>
											</div>
                                    </div>
                                     <div class="row">
											<div class="form-group col-xs-3">
												   <label><b>User Password</b></label>
                                                     <?php
														$data	= array('name'=>'password','class'=>'form-control');
													echo form_password($data);?>
											</div>
                                    </div>
                                    <div class="row">
											<div class="form-group col-xs-3">
												   <label><b>User Phone</b></label>
                                                    <?php
													$data	= array('name'=>'usercont', 'value'=>set_value('usercont', $usercont), 'class'=>'form-control');
													echo form_input($data); ?>
											</div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-xs-5">
                                            <label><b>User Status</b></label>
                                               <div class="checkbox-nice">
												   <?php
                                                    $data	= array('name'=>'isactive', 'value'=>1,'id'=>'checkbox-1', 'checked'=>$isactive);
                                                    echo form_checkbox($data) ?>
                                                       
                                                        <label for="checkbox-1">
                                                            <?=lang('active');?>
                                                        </label>
                                                </div>
                                                <label><b>Email Flag</b></label>
                                               <div class="checkbox-nice">
												   <?php
                                                    $data	= array('name'=>'email_flg', 'value'=>1,'id'=>'checkbox-2');
                                                    echo form_checkbox($data) ?>
                                                       
                                                        <label for="checkbox-2">
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
