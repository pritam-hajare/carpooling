<div class="row brd-crmb">
  <ul class="my-trp-lft">
  		<?php if($this->auth_travel->is_logged_in(false, false)): ?>				
         <li class="srh_lft"><a href="<?php echo base_url('');?>"><?php echo lang('search_for_lift');?></a></li>
         <li class="lft_add"><a href="<?php echo base_url('addtrip/form');?>"><?php echo lang('add_a_lift');?></a></li>            
           <?php  else: ?>
         <li class="srh_lft"><a href="<?php echo base_url('home');?>"><?php echo lang('search_for_lift');?></a></li>
         <li class="lft_add"><a href="<?php echo base_url('register');?>"><?php echo lang('add_a_lift');?></a></li>              
          <?php endif; ?>
  </ul>
  <ul id="menu" class="fright">
  			<?php if($this->auth_travel->is_logged_in(false, false)):				
				?>	
                 <li class="menu_right brd" ><a href="#" class="drop"> <?php echo lang('my_settings');?></a>
                    <div class="dropdown_1column align_right">                
                        <div class="col_1">                        
                            <ul class="simple">                            	
                            	<li><a href="<?php echo base_url('profile/');?>"><?php echo lang('edit_profile');?></a></li>
                            	<li><a href="<?php echo base_url('profile/changepwd_form');?>"><?php echo lang('change_password');?></a></li>
                            	<li><a href="<?php echo base_url('profile/settings');?>"><?php echo lang('settings');?></a>                            </li>
                        	</ul>                             
                        </div>                       
                	</div>                
            	</li>
                 <li class="menu_right"><a href="#" class="drop"> <?php echo lang('my_trips');?></a>
                	<div class="dropdown_1column align_right">                
                        <div class="col_1">                        
                            <ul class="simple">
                            	<li> <a href="<?php echo site_url('addtrip/form');?>"><?php echo lang('post_a_ride');?></a> </li>
                            	<li><a href="<?php echo base_url('profile#my-cars-info');?>"><?php echo lang('add_vehicle');?> </a></li>
                            	<li><a href="<?php echo base_url('profile#my-cars-info');?>"><?php echo lang('list_of_vehicles');?></a></li>
                            	<li><a href="<?php echo base_url('addtrip');?>"><?php echo lang('list_of_trips');?></a></li>                        	
                         	</ul>                             
                        </div>                       
                	</div>                
            	</li>
         <?php endif ?> 
  </ul>   
</div>