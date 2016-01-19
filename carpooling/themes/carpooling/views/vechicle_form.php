<script>
<?php if($vechicle_type_id != ''){ ?>

get_types(<?php echo $vechicle_type_id; ?>);

<?php }?>

function get_types(type_id){
var param = 'tid='+type_id+'&cid=<?php echo $vechiclecategory_id; ?>'
  $.ajax({
                type: "POST",
                url: "<?php echo  base_url();?>vechicle/type_dropdown",
				data: param,
      beforeSend: function () {
   
      $("#vechicletype").html('Loading.....');
    },
                success: function(types)
                { 
       $("#vechicletype").html(types);
	   $( "#txtvechicle" ).removeClass('disable');
      }
    });
}
</script>    
<h4> <?php echo lang('edit_car_information');?> </h4>
<div class="row margintop20 marginleft20">

<form id="vechicleform">
  <div class="cp-col-6 fleft">
    <div class="row  center"> 
      <div id='preview' class="img-preview">
       <?php 
		if(!empty($uploadvalues)) { ?>
		<div class="groupimage"> <img src="<?=base_url('uploads/vehicle/thumbnails/'.$uploadvalues)?>" class="border padding5">  <p class="margintop20"> <a href="javascript:void(0)" class="cs-blue-text remove-photo"> <?php echo lang('remove_photo');?> </a> </p>						
		 </div>
		<input type="hidden" name="uploadvalues" value="<?=$uploadvalues?>" />
	
	<?php } ?>      
      </div>
        <div id='imageloadstatus' style="display:none">
        <img src='<?php echo theme_img('ajaxloader.gif'); ?>'/> <?php echo lang('upload_msg');?> ....
        </div>     
      <div id="uploadlink"  <?php 
		if(!empty($uploadvalues)) { ?> style="display:none" <?php }  ?> >
      <img class="border padding5" src="<?php echo theme_img('no_car.png') ?>"> 
       <p class="margintop20"> <a href="javascript:void(0)" class="cs-blue-text add-photo"> <?php echo lang('add_photo');?> </a> </p>     
      </div>   
  </div>
  </div>
  <!-- End Add Image -->
  <div class="cp-col-6-r fright">

    <div class="padding1020 row">
        <div class="fleft pro-tab-cont">
          <!--<h5>No. of Passenger Seats</h5>
          <span>
            <i class="star-img"><img src="<?php echo theme_img('passenger-seats-ico.png') ?>"></i>
            <i class="star-img"><img src="<?php echo theme_img('passenger-seats-ico.png') ?>"></i>
            <i class="star-img"><img src="<?php echo theme_img('passenger-seats-ico.png') ?>"></i> 
            <i class="star-img"><img src="<?php echo theme_img('passenger-seats-higphen-ico.png') ?>"></i>
            <i class="star-img"><img src="<?php echo theme_img('passenger-seats-higphen-ico.png') ?>"></i> 
          </span>
          <p class="para"> 3 Places </p>-->
        </div>
        <div class="fleft pro-tab-cont">
          <h5><?php echo lang('brand');?></h5>
         <?php				
				$data	= array('' => '-- Select --');
				
				foreach($vechiclecategory as $parent)
				{
						$data[$parent->category_id ] = $parent->category_name;	
				}
				echo form_dropdown('vechiclecategory', $data, $vechiclecategory_id,' id="vechiclecategory"');
				?>
        </div>
         <div class="fright pro-tab-cont">
          <h5><?php echo lang('vehicle_number');?></h5>
           <input type="text" placeholder="Vechicle Number" class="disable" name="txtvechicle" id="txtvechicle" value="<?=$txtvechicle?>" />
        </div>
      </div>

      <div class="padding1020 row">
        <div class="fleft pro-tab-cont">
          <h5><?php echo lang('car_type');?></h5>
          <select name="vechicletype" id="vechicletype" >
            <option value=""><?php echo lang('select_type');?></option>
           </select>
        </div>
       <div class="fright pro-tab-cont">
          <h5><?php echo lang('comfort');?></h5>
          <?php
		  $vcdata	= array('' => '-- Select --','1' => 'Normal','2' => 'Basic','3' => 'Comfortable','4' => 'Luxury');
		 
          echo form_dropdown('vechiclecomfort', $vcdata, $vechiclecomfort,' id="vechiclecomfort"'); ?>
          
        </div>
      </div>

      <!--<div class="padding1020 row">
        
      </div>-->

      <div class="padding1020 row">
        <div class="fleft pro-tab-cont">
          <h5><?php echo lang('basic');?></h5>
          <p class="para"> <?php echo lang('car_with_basic');?> </p>
          <h5><?php echo lang('normal');?></h5>
          <p class="para"> <?php echo lang('car_with_air');?> </p>
          <h5><?php echo lang('comfortable');?></h5>
          <p class="para"> <?php echo lang('car_with_air');?> &amp; <?php echo lang('power_locks');?> </p>
          <h5><?php echo lang('luxury');?></h5>
          <p class="para"> <?php echo lang('car_with_aircon');?> <?php echo lang('power_locks');?> &amp; <?php echo lang('leather_seats');?> </p>
        </div>
      </div>

      <div class="fright row size14 sea-trp-view"> 
        <p class="margintop20 fright ed-can-trp">
        	<input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
            <input type="hidden" value="<?php echo $vechicle_id; ?>" name="vehicleid" id="vehicleid"/>
			<input type="hidden" value="1" name="submitted" />
            <input type="Submit" value="<?php echo lang('save');?>" id="search_but">                  
          
          <a href="javascript:void(0)" class="back"> <img src="<?php echo theme_img('back-ico.png') ?>" width="12" height="12"> <?php echo lang('back');?> </a>
        </p>
      </div>
     </form>
</div>
<div id='imageloadbutton' style="display:none">
	<?php 
$attributes = array('id' => 'imageform');
echo form_open_multipart(base_url('vechicle/image_upload'),$attributes);?>	
    <input type="file" name="photoimg" id="photoimg"/>
    <input type='hidden'  name="imageType" />
</form>  
</div>

