<?php 
		 $attributes = array('id' => 'settings');	
		echo form_open('profile/settings/'.$id,$attributes); ?>

<h4> <?php echo lang('settings');?> </h4>
<ul class="pref-tab row margintop20 marginleft20"> 
 <li class="width55"> <label class="swith_class"><?php echo lang('show_phone');?></label>
 <div class="ios-input">
 <label>
 	<input type="checkbox" class="ios-switch" <?php if(!empty($number)){ echo 'checked'; } ?> name="number" value="1"/> 
 <label>
 </div>
 </li>
 <li class="width55"> <label class="swith_class"><?php echo lang('send_sms');?></label>
 <div class="ios-input">
 <label>
 	<input type="checkbox" class="ios-switch" <?php if(!empty($sms)){ echo 'checked'; } ?> name="sms" value="1"/>
 <label>
 </div>
 </li>
 <li class="width55"> <label class="swith_class"><?php echo lang('chat');?></label>
 <div class="ios-input">
 <label>
 	<input type="checkbox" class="ios-switch" <?php if(!empty($chat)){ echo 'checked'; } ?> name="chat" value="1"/>
 <label>
 </div>
 </li>
 <li class="width55"> <label class="swith_class"><?php echo lang('music');?></label>
 <div class="ios-input">
 <label>
 	<input type="checkbox" class="ios-switch" <?php if(!empty($music)){ echo 'checked'; } ?> name="music" value="1"/>
 <label>
 </div>
 </li>
 <li class="width55"> <label class="swith_class"><?php echo lang('pet');?></label>
 <div class="ios-input">
 <label>
	<input type="checkbox" class="ios-switch" <?php if(!empty($pet)){ echo 'checked'; } ?> name="pet" value="1"/>
 <label>
 </div>
 </li>
 <li class="width55"> <label class="swith_class" ><?php echo lang('smoke');?></label>
 <div class="ios-input">
 <label>
 	<input type="checkbox" class="ios-switch" <?php if(!empty($smoke)){ echo 'checked'; } ?> name="smoke" value="1"/>
 <label>
 </div>
 </li>
 <li class="width55"> <label class="swith_class"><?php echo lang('food');?></label>
 <div class="ios-input">
 <label>
 	<input type="checkbox" class="ios-switch" <?php if(!empty($food)){ echo 'checked'; } ?> name="food" value="1"/>
 <label>
 </div>
 </li>
</ul>
<div class="width53 fleft margintop20 size14 sea-trp-view"> 
<input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
	<input type="hidden" value="1" name="submitted" />
	<input type="Submit" value="<?php echo lang('save');?>" class="green-bg padchg margintop20">                        
  </div>
	

               
           