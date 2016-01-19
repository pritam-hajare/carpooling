<?php include('header.php');?>
<style type="text/css">
 .mandatory,spnerror { color:red; }
</style>
<script type="text/javascript" src="<?php echo theme_js('travel-details-rules.js');?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places&language=en"></script>
<link rel="stylesheet" type="text/css" href="<?php echo  theme_js('jquery.datepick/redmond.datepick.css');?>"> 
<?php echo  theme_js('jquery.datepick/jquery.plugin.js',true);?>
<?php echo  theme_js('jquery.datepick/jquery.datepick.js',true);?>

<?php echo theme_js('notification/goNotification.js',true) ?>
<link href="<?php echo theme_js('notification/goNotification.css') ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo theme_js('popup/css/jquery-confirm.css') ?>" />

<link rel="stylesheet" href="<?php echo theme_js('popup/boxy.css') ?>">
<?php echo theme_js('popup/jquery.boxy.js',true) ?>
<script>
$(document).ready(function() {
	
	$('#rpt_from_date').datepick({
	 changeMonth: false,autoSize: true,minDate: 0,dateFormat: 'dd/mm/yyyy'});
		
		change_trip(1);
		<?php if($return == 'yes') { ?>
		change_trip(2);
		<?php } ?>
		
		$('#tzone').attr('selectedIndex', 0);
		
                <?php if($rpt_from_date == '') { ?>
		$('#regu').attr('checked',true);
                change_type(1)
                <?php } else { ?>
                $('#casu').attr('checked',true);
                change_type(2)
                <?php } ?>
		$('#<?=$return?>').attr('checked',true);
		var initValues = <?=$frequency_values?>;
		//alert(initValues);
		$('#frmtrip').find(':checkbox[name^="frequency[]"]').each(function () {
			$(this).attr("checked", ($.inArray($(this).val(), initValues) != -1));
		});
		
		
		
		<?php
		//lets have the flashdata overright "$message" if it exists
		if($this->session->flashdata('message'))
		{
			$message	= $this->session->flashdata('message'); ?>
			$.goNotification('<?=$message?>', { 
			type: 'success', // success | warning | error | info | loading
			position: 'top center', // bottom left | bottom right | bottom center | top left | top right | top center
			timeout: 5000, // time in milliseconds to self-close; false for disable 4000 | false
			animation: 'fade', // fade | slide
			animationSpeed: 'slow', // slow | normal | fast
			allowClose: true, // display shadow?true | false
			});
		<?php }
		
		if($this->session->flashdata('error'))
		{
			$error	= $this->session->flashdata('error'); 
			?>
			$.goNotification("<?=trim($error)?>", { 
			type: 'error', // success | warning | error | info | loading
			position: 'top center', // bottom left | bottom right | bottom center | top left | top right | top center
			timeout: 5000, // time in milliseconds to self-close; false for disable 4000 | false
			animation: 'fade', // fade | slide
			animationSpeed: 'slow', // slow | normal | fast
			allowClose: true, // display shadow?true | false
			});
		<?php
		}
		
		if(function_exists('validation_errors') && validation_errors() != '')
		{
			$error	= validation_errors();
			?>
			$.goNotification('<?=trim($error)?>', { 
			type: 'error', // success | warning | error | info | loading
			position: 'top center', // bottom left | bottom right | bottom center | top left | top right | top center
			timeout: 200000, // time in milliseconds to self-close; false for disable 4000 | false
			animation: 'fade', // fade | slide
			animationSpeed: 'slow', // slow | normal | fast
			allowClose: true, // display shadow?true | false
			});
		<?php
		}
		?>

		
			
	});
	
</script>
<?php  echo theme_css('jquery.tagbox.css', true);?>
<?php  echo theme_js('jquery.tagbox.js', true);?>
<script type="text/javascript" src="<?php echo theme_js('jquery.validate.js');?>"></script>
<script type="text/javascript">
var baseurl = "<?php print base_url(); ?>";
var country = '<?php print ($this->config->item('country_code') != '')?$this->config->item('country_code'):''; ?>';
</script>
<?php  echo theme_js('trip.js', true);?>
  
  
<div class="container-fluid margintop40">
  <div class="container">
   <div class="row">
     <ul class="brd-crmb">
      <li><a href="#"> <img src="<?php echo theme_img('home-ico.png') ?>"> </a></li>
      <li> / </li>
      <li><a href="#"><?php echo lang('register_your_carpool');?></a></li>
    </ul>
    <div class="row margin">
   
    <?php /*?><?php 
		  $attributes = array('id' => 'frmtrip','class'=>'bbq');				 
		 echo form_open('addtrip/form/'.$tripid,$attributes); ?><?php */?>
         <form class="bbq" id="frmtrip">
		 <input type="hidden" name="tripid" id="tripid" value="<?=$tripid?>" />
		<input type="hidden" name="submitted" id="route-map" value="submitted" />
        <input type="hidden" name="edited" id="edited" value="" />
        <input type="hidden" name="checktrip" id="checktrip" value="1" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />     
         <div class="container-fluid">
        <div class="container">
            <div class="fleft width100">
            	
	            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">     
      <div class="trip-lft">
        
        <h2 class="pst-trip-tit"><?php echo lang('register_your_trip');?></h2>
          <!--<div class="fleft width100 margintop20">
          <ul class="trp-part">
            <li> <p><?php echo lang('part_1_of_2');?></p> <span class="cs-blue-bg"></span> </li>
            <li> <p><?php echo lang('part_2_of_2');?></p> <span></span> </li>
          </ul>
        </div>-->
        <div class="fleft width100 line4"></div>
				        <div class="fleft width100 margintop20"> 
          <div class="roundstep-no fleft size13"><?php echo lang('step_1');?> &nbsp;</div> 
          <span class="size16 fleft bold"><?php echo lang('add_vehicle_info');?></span>   
        </div>
       <div class="fleft width100 margintop20">
          <span class="size14 bold"><span class="mandatory">*</span> <?php echo lang('travel_type');?></span>
           <?php				
				$data	= array('' => 'Select your car');				
				foreach($vehicle as $parent)
				{ 
				   $data[$parent->vechicle_id ] = strtoupper($parent->vechicle_type_name) .' - '. $parent->vechicle_number; 
				}
				echo form_dropdown('vechicletype', $data, $vechicletype,' id="vechicletype" class="fleft width100 padding10" onchange="get_vehicle();"');
				?>
        </div>
        <div class="fleft width100 margintop20">
          <span class="size14 bold fleft paddingright10"><?php echo lang('vehicle_number');?> </span>
          <p class="fleft size16 bold" id="vehnum"><?=$vehnum?></p>          
        </div>
        <div class="fleft width100 line4"></div>
				        <div class="fleft width100 margintop20"> 
          <div class="roundstep-no fleft size13"><?php echo lang('step_2');?> &nbsp;</div> 
          <span class="size16 fleft bold"><?php echo lang('add_trip');?></span>   
        </div>
        <div class="fleft width100 margintop20">
          <span class="size14 bold"><span class="mandatory">*</span> <?php echo lang('from');?></span>          
          <input type="text" class="fleft width100 padding10" placeholder="your departure point (address,city,station...)"   name="txtsource" id="txtsource"class="frt_src" value="<?=$txtsource?>" >
                    <input type="hidden" name="source_ids" id="source_ids"  value="<?=$source_ids?>"/>
        </div>
        <div class="fleft width100 margintop20">
          <span class="size14 bold"><span class="mandatory">*</span> <?php echo lang('to');?></span>          
            <input type="text" class="fleft width100 padding10" placeholder="your arrival point (address,city,station...)"  name="txtdestination" id="txtdestination"  value="<?=$txtdestination?>"/>
                    <input type="hidden" name="destination_ids" id="destination_ids"  value="<?=$destination_ids?>"/>
        </div>
        <div class="fleft width100 margintop20">
          <span class="size14 bold row"><span class="mandatory">*</span> <?php echo lang('add_route');?></span>
          <input  type="text" id="jquerytagboxtext" class="fleft padding10 width51" name="jquerytagboxtext"  value="<?=$jquerytagboxtext?>"/>
           <input type="hidden" name="routes" id="routes" value="<?=$routes?>" />
          <input type="hidden" name="routesdata" id="routesdata" value="<?=$routesdata?>" />
         <input type="hidden" name="route_lanlat" id="route_lanlat" value="<?=$route_lanlat?>" />         
        </div>      
        <div class="fleft width100 line4"></div>
				        <div class="fleft width100 margintop20"> 
          <span class="size14 bold row"><span class="mandatory">*</span> <?php echo lang('frequency');?></span>
          <p class="row bold paddingtop10"> 
        
            <span class="fleft size14"> <input type="radio" name="trip_type" id="regu" onclick="change_type(1)"/> <?php echo lang('recurring');?> </span>
            <span class="fleft size14 marginleft30"> <input type="radio" name="trip_type" id="casu" onclick="change_type(2)"/> <?php echo lang('one_time');?>  </span>
          </p>
          <p class="row paddingtop10 bold" id="regular"> 
            <span class="fleft size14"> <input type="checkbox" name="frequency[]" value="0" onchange="filter_result()"/> Sun </span>
            <span class="fleft size14 marginleft30"> <input type="checkbox" name="frequency[]" value="1" onchange="filter_result()"/> Mon </span>
            <span class="fleft size14 marginleft30"> <input type="checkbox" name="frequency[]" value="2" onchange="filter_result()"/> Tue </span>
            <span class="fleft size14 marginleft30"> <input type="checkbox" name="frequency[]" value="3" onchange="filter_result()"/> Wed </span>
            <span class="fleft size14 marginleft30"> <input type="checkbox" name="frequency[]" value="4" onchange="filter_result()"/> Thu </span>
            <span class="fleft size14 marginleft30"> <input type="checkbox" name="frequency[]" value="5" onchange="filter_result()"/> Fri </span>
            <span class="fleft size14 marginleft30"> <input type="checkbox" name="frequency[]" value="6" onchange="filter_result()"/> Sat </span>
             <input type="hidden" name="frequency_ids" id="frequency_ids" value="<?=$frequency_ids?>" />
          </p>
          <p class="row paddingtop10 bold" id="casuals"> 
            <span class="size14 bold"> </span>    
             <input type="text" id="rpt_from_date" placeholder="Date Of Journey " class="fleft width100 padding10 row" name="rpt_from_date" onchange="clearnow();" value="<?=$rpt_from_date?>">        
          </p>
        </div>
       <div class="fleft width100 margintop20">           
          <span class="row size14 bold"><span class="mandatory">*</span> <?php echo lang('type_of_trip');?></span>
        </div>
        <div class="fleft width100 margintop20">
          <ul class="trp-part paddingtop10">
            <li class="bold"> <input name="return" type="radio" value="no" id="no" onclick="change_trip(1)"> <?php echo lang('one_way_trip');?> </li>
            <li class="bold"> <input name="return" type="radio" value="yes" id="yes" onclick="change_trip(2)"> <?php echo lang('return_trip');?> </li>             
          </ul>
        </div>
        <div class="fleft width100 margintop20">
          <ul class="trp-step">
            <li id="departure"> 
              <span class="row size14 bold"><?php echo lang('departure_time');?></span>              
              <?php  $options = array(
			'' => 'HH',
			'1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12' );
			echo form_dropdown('fhh', $options, set_value('fhh',$fhh),' id="fhh" class="fleft padding10 " onchange="clearnow();"  placeholder="hh"');?>
              <p class="marginleft10 paddingtop6 size16 fleft">:</p>
              <?php  $options = array(
						'' => 'MM','00'=>'00',
						'15'=>'15','30'=>'30','45'=>'45');
				echo form_dropdown('fmm', $options, set_value('fmm',$fmm),' id="fmm" class="fleft padding10 marginleft10" onchange="clearnow();" ');?>
              <p class="marginleft10 paddingtop6 size16 fleft"> </p>
              		<?php  $options = array(
						'' => 'AM/PM',
						'am'=>'AM','pm'=>'PM');
						echo form_dropdown('fzone', $options, set_value('fzone',$fzone),' id="fzone" class="fleft padding10 marginleft10" onchange="clearnow();" ');?>            </li>
            <li id="return"> 
              <span class="row size14 bold"><?php echo lang('return_time');?></span>
              <?php  $options = array(
			'' => 'HH',
			'1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12' );
			echo form_dropdown('thh', $options, set_value('thh',$thh),' id="thh" class="fleft padding10 " onchange="clearnow();"  placeholder="hh"');?>
              <p class="marginleft10 paddingtop6 size16 fleft">:</p>
              <?php  $options = array(
						'' => 'MM','00'=>'00',
						'15'=>'15','30'=>'30','45'=>'45');
						echo form_dropdown('tmm', $options, set_value('tmm',$tmm),'id="tmm" class="fleft padding10 marginleft10" onchange="clearnow();" ');?>
              <p class="marginleft10 paddingtop6 size16 fleft"> </p>
              <?php  $options = array(
				'' => 'AM/PM',
				'am'=>'AM','pm'=>'PM');
				echo form_dropdown('tzone', $options,'1', '  id="tzone" class="fleft padding10 marginleft10"');?>
            </li>
            <input type="hidden" name="depature_time" id="depature_time" value="<?=$depature_time?>" />
            <input type="hidden" name="arrival_time" id="arrival_time" value="<?=$arrival_time?>" />
          </ul>
        </div>  
        
        <div class="fleft width100 line4"></div>
				        <div class="fleft width100 margintop20">
          <span class="size14 bold row"><span class="mandatory">*</span> <?php echo lang('available_seat');?></span>          
          <?php
		$data	= array('name'=>'avail_seats','id'=>'avail_seats','class'=>'fleft width100 padding10 row', 'placeholder'=>'Available Seat', 'value'=>set_value('avail_seats', $avail_seats));
		echo form_input($data);?>
        </div>
        <div class="fleft width100 margintop20">
          <span class="size14 bold row"><span class="mandatory">*</span> <?php echo lang('phone_number');?></span>
          <?php
		$data	= array('name'=>'number', 'id'=>'number','class'=>'fleft width100 padding10 row',  'placeholder'=>'Contact Person Number', 'value'=>set_value('number', $number));
		echo form_input($data);?>
        </div>
        <div class="fleft width100 margintop20">
          <span class="size14 bold row"><span class="mandatory">*</span> <?php echo lang('comments');?></span>
           <?php
		$data	= array('name'=>'comments','class'=>'fleft width100 padding10 rows','rows'=>'4', 'id'=>'comments', 'value'=>set_value('comments', $comments));
		echo form_textarea($data);?> 
         
        </div>
        <div class="fleft width100 line4"></div>
        <div class="margintop20 fright">
          <input type="submit" value="<?php echo lang('post');?>" class="padding10 colorwhite cs-blue-bg trp-cont-but size16 bold">
        </div>

    </div>
     </div>
    <!-- End Left -->
      <div class="col-lg-4  col-md-12 col-sm-12 col-xs-12">
    <div class="trip-right">

      <h2 class="pst-trip-titrht size22"><?php echo lang('journey_route');?></h2>

      <div class="float width100 line4"></div>

      <div class="row ">
      	<div id="route-map-data">       
        </div>
        
      </div>

      <div class="fleft width100 line4"></div>

    </div>
    <!-- End Right -->

    </div>
    <!-- End -->

    </div>


  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
 
<?php include('footer.php');?> 
