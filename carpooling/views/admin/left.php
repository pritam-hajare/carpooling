<?php
$status = $this->uri->segment(2);
$masteractive="";

if( $this->uri->segment(2) == "users")
{
	 $useractive = "active";
}
else
{
	$masteractive = "active";
}
	

?>
<script type="text/javascript">
  $(document).ready(function() {  
    /* Uploading Profile Image */
	$('body').on('click','#profile_pic', function()
	{
		$( "#profilephotoimg" ).trigger( "click" );
	});
	
	/* Uploading timelineProfile  Image left menu */
	$('body').on('change','#profilephotoimg', function()
	{
		$("#profileimageform").ajaxForm({target: '#ProfilePic',
			beforeSubmit:function(){
			},
			success:function(){
				$("#previousImage").hide();				
			},
			error:function(){
			
			} }).submit();
	});
   });
</script>
<?php echo theme_js('jquery.wallform.js',true) ?>
<div id="nav-col">
<section id="col-left" class="col-left-nano">
    <div id="col-left-inner" class="col-left-nano-content">
        <div id="user-left-box" class="clearfix hidden-sm hidden-xs dropdown profile2-dropdown">
            <div id="ProfilePic">
            <img alt="" id="previousImage" src="<?php if(!empty($admin_img['admin_img'])){ echo admin_profile_img($admin_img['admin_img']); }else { echo theme_img('default.png'); }?>" />
            </div>
            <div class="user-box">
                <span class="name">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      Welcome  <?= $name; ?> 
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" id="profile_pic"><i class="fa fa-user"></i>Edit Photo</a></li>						
                    </ul>
                </span>
                
            </div>
             <?php 
			$attributes = array('id' => 'profileimageform');
			echo form_open_multipart(base_url('admin/admin/profile_image_upload'),$attributes);?>
			<div style="display:none;">
			<input type="file"  name="photoimg" id="profilephotoimg" class="custom-file-input " original-title="Upload Profile Picture">
			</div>			     
			</form>
			</div>
        <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">	
            <ul class="nav nav-pills nav-stacked">                
                <li>
                    <a href="<?php echo $admin_url;?>dashboard/">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                        <span class="label label-primary label-circle pull-right"></span>
                    </a>
                </li>
          
                   <li> 
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-table"></i>
                        <span>Master</span>
                        <i class="fa fa-angle-right drop-icon"></i>
                    </a>                   
                     <ul class="submenu">
                     	<li>
                            <a href="<?php echo $admin_url;?>country">                                
                                Country
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo $admin_url;?>currency">                                
                                Currency
                            </a>
                        </li>                    
                                            
                        <li>
                            <a href="<?php echo $admin_url;?>language">                                
                                Language
                            </a>
                        </li>
                         <li>
                            <a href="<?php echo $admin_url;?>category">                                
                                Vehicle Brand
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $admin_url;?>vehicle">                               
                                Vehicles
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $admin_url;?>radius">                               
                                Radius
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-child"></i>
                        <span>Site Users</span>
                        <i class="fa fa-angle-right drop-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li>
							<a href="<?php echo $admin_url;?>traveller/form">Add Site User</a>
                        </li>
                        <li>
                            <a href="<?php echo $admin_url;?>traveller">List Site User</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-users"></i>
                        <span>User Management</span>
                        <i class="fa fa-angle-right drop-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li>
							<a href="<?php echo $admin_url;?>admin">Admin</a>
						</li>
                    </ul>
                </li>
            
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="fa  fa-file-text"></i>
                        <span>CMS</span>
                        <i class="fa fa-angle-right drop-icon"></i>
                    </a>
                    <ul class="submenu">
                        <!--<li>
							<a href="<?php //echo $admin_url;?>banner">Banners</a>
						</li>-->
						<li>
							<a href="<?php echo $admin_url;?>pages">Pages</a>
						</li>
                        <li>
							<a href="<?php echo $admin_url;?>testimonials">testimonials</a>
						</li>
                    </ul>
                </li>
                
                
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="fa fa-cab"></i>
                        <span>Trips</span>
                        <i class="fa fa-angle-right drop-icon"></i>
                    </a>
                    <ul class="submenu">
                        <li>
							<a href="<?php echo $admin_url;?>trip">List of Trips</a>
						</li>
                    </ul>
                </li>
                
                
                
                
            </ul>
        </div>
    </div>
</section>
<div id="nav-col-submenu"></div>
</div>