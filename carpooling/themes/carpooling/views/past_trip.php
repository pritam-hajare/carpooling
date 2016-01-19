<?php include('header.php');?>

<?php  echo theme_js('tab.js', true);?>
<script>
 var baseurl = "<?php print base_url(); ?>";
$(document).ready(function() {
	
	/* Slider Expand Click */
	$('body').on("click",'.slider',function()
	{
		var ID = $(this).attr("rel");
		if($('#slide'+ID).is(':visible'))
		{
			close()
		}
		else
		{
			close()
					
			$('#slide'+ID).addClass('open').removeClass('close');		
			 $('#slide'+ID).slideToggle('slow');
			
			return false;
		}
	});
	
	function close() {
        opened = $(document).find('.open');
        $.each(opened, function() {
            //give the proper class to the linked element
            $(this).addClass('close').removeClass('open');
             $(this).slideToggle('slow');
        });
    }
	
	
	
	$('body').on("click",'.enquery',function(){
	
		$.ajax({
		type: "POST",
		url:  baseurl+"addtrip/enquery/",		
		cache: false,
		success: function(html){
			if(html){
				$body = $("body");
   				$body.addClass("loading");
				setTimeout(function(){ 			
				$(".enquery_list").html(html);
				$(".enquery_list").fadeIn('slow');						
				}, 1000);
				setTimeout(function(){ 						
				$body.removeClass("loading");						
				}, 1500);
					
			}
		 }
	  });
	
		return false;
	
	});
		
			
	});
	


</script>
<?php  echo theme_js('common.js', true);?>


    <div class="container-fluid margintop40">
  <div class="container">
            <div class="row">

            <ul class="brd-crmb">
      <li><a href="#"> <img src="<?php echo theme_img('home-ico.png') ?>"> </a></li>
      <li> / </li>
      <li><a href="#"><?php echo lang('my_trips');?></a></li>
    </ul>
                 </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="container">
            <div class="row">
            	<h2 class="pst-trip-tit"><?php echo lang('my_trips');?></h2>
     

            	<div class="fleft width100 margin">

        <div class="p_top">
         <a id="a_tab" class="b_t_1  active" onclick="tab_tab(this, 'p_block_bottom'), height_right()"><?php echo lang('rides_offered');?></a>
         <a id="a_tab" class="b_t_1 enquery" onclick="tab_tab(this, 'p_block_bottom'), height_right()"><?php echo lang('enquiry');?></a>
         <div class="cr">
        </div>
      </div>
      
			      <div class="obj_cont p_block_bottom rowrec" style="display: block;">
			        <div class="my-trp-tab row">
          <div class="my-trp-main">
           <a href="<?=base_url('addtrip/upcoming_trip')?>" class="upcoming_trip"><?php echo lang('upcoming_trips');?> </a>
            <a href="javascript:void(0)" class="trp-main-active past_trip"><?php echo lang('past_trips');?></a>
          </div>
			          <div class="my-trp-content rowrec">
			            <p class="para"><?php echo lang('up_this_page');?></p>
            <?php if($trip_details){
				$i =1;
					foreach ($trip_details as $trip){
						?>
            <div class="inner-trip-det">
              <div class="sea-city-city topbg colorwhite padding10 cs-blue-text size16"> 
                <b><?=$trip['source']?> <span> <img src="<?php echo theme_img('arrow-right-white.png') ?>"> </span> <?=$trip['destination']?>  </b> 
                <span class="trp-para"><?php echo lang('trip_type');?> <?php if(!empty($trip['trip_casual_date'])){ echo $trip['trip_casual_date']; } else { echo 'Regular';} ?></span> 
                <a href="javascript:void(0)" class="fright trp-acc-arr slider" rel="<?=$i?>"> <img src="<?php echo theme_img('arr-ver-down.png') ?>"> </a>
              </div>
              <div id="slide<?=$i?>" style="display:none">
			              <div class="fleft width100 margintop20 padding20">
                <span class="fleft"> <img src="<?php echo theme_img('src-dest-ico.png') ?>"> </span>
			                <div class="sea-city-city fleft cs-grey-text size14 mar-min fleftnon"> 
			                  <b><?=$trip['source']?></b> <?php  
							 if(!empty($legdetails['route_'.$trip['trip_id']])){
							 foreach ($legdetails['route_'.$trip['trip_id']] as $trip_routes){ 
							?>
                 <span> <img src="<?php echo theme_img('search-arrow-right-grey.png') ?>"> </span> <?=$trip_routes?> <span> 
                 <?php } } ?>
                 <img src="<?php echo theme_img('search-arrow-right-grey.png') ?>"> </span> <b><?=$trip['destination']?> </b>
                  
                  <span class="trp-para"><?php echo lang('trip_type');?> <?php if(!empty($trip['trip_casual_date'])){ echo $trip['trip_casual_date']; } else { echo 'Regular';} ?></span> 
                </div>
              </div>
			              <h5 class="fleft width100 inner-in-trp"> <img src="<?php echo theme_img('trip-icon.png') ?>"> <?php echo lang('trip_leg');?>: </h5>
               <?php  
							 if(!empty($legdetails['leg_'.$trip['trip_id']])){
							 foreach ($legdetails['leg_'.$trip['trip_id']] as $trip_leg){ 
							 //print_r($trip_leg); die;
							?>
			              <div class="fleft width100 inner-in-trp">
                <div class="inner-trip-det marginbot10">
                  <div class="sea-city-city topbg colorwhite padding5 cs-blue-text size14"> 
                    <span><?php echo lang('trip_leg');?></span> 
                    <b><?=$trip_leg['source_leg']?><span> <img src="<?php echo theme_img('arrow-right-white.png') ?>"> </span> <?=$trip_leg['destination_leg']?> </b> 
                  </div>
			                  <div class="padding20 fleft width100">
                    <div class="inn-in-left fleft">
			                      <div class="sea-city-city cs-grey-text size14"> 
                        <img src="<?php echo theme_img('time-ico.png') ?>"> <b> <?php echo lang('expected_departure');?> </b> <span id="time_<?=$trip_leg['trip_led_id']?>"><?=$trip_leg['expected_time']?></span>
                      </div>
			                      <div class="sea-city-city margintop30 cs-grey-text size14"> 
			                        <img src="<?php echo theme_img('rs-ico-big.png') ?>"> <b> <?php echo lang('price');?>: </b> <span class="grey" id="amount_<?=$trip_leg['trip_led_id']?>"> <?php if(!empty($trip_leg['route_rate'])){ echo format_currency($trip_leg['route_rate']);  } else { echo '-';} ?> <?php echo lang('inr');?></span>
                      </div>
                      <h4 class="cs-blue-text size14"> <?php echo lang('available_seats');?> <?=$trip['trip_avilable_seat']?> </h4>
                    </div>
			                    <div class="inn-in-left fright flefti margintop20i">
			                      <div class="sea-city-city fright fleftnon cs-grey-text size14 ed-tme"> 
                        <b><?php echo lang('edit_time');?></b>
                        <div id="edit-time-<?=$trip_leg['trip_led_id']?>" style="display:none">
                        <?php  
						$fresult = explode(' ',$trip_leg['expected_time']);						
						$ftime = explode(':',$fresult[0]);
						$options = array(						
						'1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12' );
						echo form_dropdown('fhh', $options, set_value('fhh',$ftime[0]),' id="fhh" class="hour'.$trip_leg['trip_led_id'].'" placeholder="hh"');?>
                        <?php  $options = array(
						'' => 'MM','00'=>'00',
						'15'=>'15','30'=>'30','45'=>'45');
				echo form_dropdown('fmm', $options, set_value('fmm',$ftime[1]),' id="fmm" class="min'.$trip_leg['trip_led_id'].'"');?>
                        <?php  $options = array(						
						'am'=>'AM','pm'=>'PM');
						echo form_dropdown('fzone', $options, set_value('fzone',$fresult[1]),' id="fzone" class="zone'.$trip_leg['trip_led_id'].'"');?>  
                        <a href="javascript:void(0)" class="green-bg padchg save-leg" rel="<?=$trip_leg['trip_led_id']?>"> <?php echo lang('save');?> </a>
                        <a href="javascript:void(0)" class="red-bg padchg cancel-leg" rel="<?=$trip_leg['trip_led_id']?>"> <?php echo lang('cancel');?> </a>
                        </div>
                        <div id="leg-time-<?=$trip_leg['trip_led_id']?>">
                        <input type="text" name="trip_time_<?=$trip_leg['trip_led_id']?>" id="trip_time_<?=$trip_leg['trip_led_id']?>" value="<?=$trip_leg['expected_time']?>" class="edit_fld"> 
                        <a href="javascript:void(0)" class="edit-leg efld" rel="<?=$trip_leg['trip_led_id']?>"> <img src="<?php echo theme_img('edit-ico.png') ?>"> </a>
                        </div>
                      </div>
                       <div class="sea-city-city fright cs-grey-text size14 ed-tme" style="width:100%;"> 
                       <b><?php echo lang('edit_rate');?></b>
                        <div id="edit-rate-<?=$trip_leg['trip_led_id']?>" style="display:none">
                        <?php  
						$fresult = $trip_leg['route_rate'];						 
		$data	= array('name'=>'route_rate','id'=>'rate'.$trip_leg['trip_led_id'],'class'=>'rate'.$trip_leg['trip_led_id'], 'placeholder'=>'Trip Rate', 'value'=>set_value('avail_seats', $fresult));
		echo form_input($data);?>
						
            
                        <a href="javascript:void(0)" class="green-bg padchg save-leg-rate" rel="<?=$trip_leg['trip_led_id']?>"> <?php echo lang('save');?> </a>
                        <a href="javascript:void(0)" class="red-bg padchg cancel-leg-rate" rel="<?=$trip_leg['trip_led_id']?>"> <?php echo lang('cancel');?> </a>
                        </div>
                        <div id="leg-rate-<?=$trip_leg['trip_led_id']?>">
                      	<input type="text"  name="trip_rate_<?=$trip_leg['trip_led_id']?>" id="trip_rate_<?=$trip_leg['trip_led_id']?>" value="<?=$trip_leg['route_rate']?>" class="edit_fld"> 
                        <a href="javascript:void(0)" class="edit-leg-rate efld" rel="<?=$trip_leg['trip_led_id']?>"> <img src="<?php echo theme_img('edit-ico.png') ?>"> </a>     
                      </div>
                      </div>
                     <!-- <div class="fright margintop30 row size14 sea-trp-view"> 
                        <a href="#"> View Trip </a>
                      </div>-->
                    </div>
                  </div>
                </div>
              </div>
              <?php } } ?>
			              <!-- End Trip3 -->

			              <div class="fleft width100 padding20 ed-can-trp">
                <a href="<?= base_url('addtrip/delete/'.$trip['trip_id']); ?>" class="red-bg"> <img src="<?php echo theme_img('cancel-ico.png') ?>"> <?php echo lang('delete_all_trips');?> </a>

                <a href="<?= base_url('addtrip/form/'.$trip['trip_id']); ?>"> <img src="<?php echo theme_img('edit-ico.png') ?>"> Edit trips </a>


              </div>
        

              </div>
                  <!-- Ena Main Trip 2 -->
            </div>
             <?php $i++; } } ?>
          </div>
        </div>
      </div>
      <!-- end tab1 -->
      
      <div class="obj_cont p_block_bottom" style="display: none;">
      <div class="enquery_list"> <?php echo lang('no_ratings_given');?> </div>
      </div>
      <!-- end tab2 -->
      
			     
			      <!-- end tab3 -->
		      
      </div>


    </div>
        </div>
    </div>


    
<?php include('footer.php');?>
