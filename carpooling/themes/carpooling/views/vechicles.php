<h4> <?php echo lang('my_cars');?> </h4>
<div class="row margintop20 marginleft20">
  <table cellspacing="0" cellpadding="0" width="100%" border="0" class="margintop20 tab-table"  valign="middle">
    <tr>
      <th> <?php echo lang('photo');?> </th>
      <th> <?php echo lang('model');?> </th>
      <th> <?php echo lang('vehicle_name');?> </th>
      <th> <?php echo lang('vehicle_number');?> </th>
      <th width="20%"> <?php echo lang('passenger_seats');?> </th>
      <th>  </th>
    </tr>   
    <?php if($vechicletypes){
				foreach ($vechicletypes as $vechicletype){
					?>	
     <tr>
      <td><img class="search-thumb my-car-photo search-user-thumb" style="margin: 15px 0 15px 0px;" src=" <?php if(!empty($vechicletype->vechicle_logo)){ echo  base_url('uploads/vehicle/thumbnails/'.$vechicletype->vechicle_logo ); } else { echo theme_img('no_car.png'); } ?>"></td>
      <td class="cs-blue-text"> <b><?=$vechicletype->category_name?> </b> </td>
      <td> 
        <?=$vechicletype->vechicle_type_name?> 
		  
      </td>
      <td class="cs-grey-text"> <b><?=$vechicletype->vechicle_number?> </b> </td>      
      <td class="action-div">
        <a href="javascript:void(0)" class="edit" rel="<?=$vechicletype->vechicle_id?>"> <img src="<?php echo theme_img('edit-ico.png') ?>"> </a>
        <a href="<?= base_url('vechicle/delete/'.$vechicletype->vechicle_id); ?>" class="red-bg delete"> <img src="<?php echo theme_img('delete-ico.png') ?>"> </a>
      </td>
    </tr>
      <?php } ?>
  </table>
  <?php } else { ?>
  </tr> </table>
  <p class="margintop20"> <?php echo lang('no_car_added');?> </p>
  <?php } ?>
  <p class="margintop20 fright ed-can-trp"> <a href="javascript:void(0)" class="new"> <img src="<?php echo theme_img('add-ico.png') ?>"> <?php echo lang('add_new_car');?> </a> </p>
</div>