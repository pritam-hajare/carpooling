<?php include('header.php'); ?>
<script type="text/ecmascript">
var baseurl = "<?php print base_url(); ?>";
function viewPopcontact(pmId)
 {

 var pmQueryString = 'pmId='+pmId; 
 $.ajax({
   type: "POST", 
   url: baseurl + "communication/sendenquiry/true",  
   dataType: "json", 
   data:pmQueryString,
   success: function(json) {
  
    if (json.result == 0){                                                                   
     $('#enquiry_'+pmId).addClass(".book-active-success");
	 $('#enquiry_'+pmId).removeClass("book-button");
     $('#enquiry_'+pmId).text('Your request already sent. You may call if required')     
     //$('#spnError').show();
	  
     return false;
    } else if (json.result == 1) {
	 $('#enquiry_'+pmId).addClass(".book-active-success");
	 $('#enquiry_'+pmId).removeClass("book-button");
     $('#enquiry_'+pmId).text('Your Enquiry has been submitted successfully!')
    }
   }
  });
}
</script>
<div class="container-fluid margintop40">
  <div class="container">
            <div class="row">
    <ul class="row brd-crmb">
      <li><a href="<?php echo  base_url('home'); ?>"> <img src="<?php echo theme_img('home-ico.png');?>"> </a></li>
      <li> / </li>
      <li><a href="javascript:void(0)"><?php echo lang('search');?></a></li>
      <li> / </li>
      <li><a href="javascript:void(0)">
	  				<?php $source = explode(",", $tripdetails['source_leg']); 
                    echo  $source[0]; ?> <span> <img src="<?php echo theme_img('search-arrow-right-grey.png') ?>"> </span> 
                    <?php $destination = explode(",", $tripdetails['destination_leg']); 
                    echo  $destination[0]; ?>
					
	</a></li>
    </ul>
    <div class="rowrec margin">
      <div class="trip-lft">
        
      <div class="rowrec view-map"><?php echo $map['js']; 
							echo $map['html']; ?>
                            <div id="directionsDiv"></div></div>

      <div class="row margin">
        <div class="view-col1">
            <h4><?php echo lang('trip_detail');?> </h4><small class=""><?php echo lang('published_at');?> <?php echo date('d/m/Y',strtotime($tripdetails['trip_created_date']));?></small>
        </div>
        <div class="view-col1">
            <h4 class="cs-blue-text"> <?php echo lang('preferences');?>  </h4>
            <p> </p>
        </div>
      </div>
      <div class="rowrec line4"></div>

      <div class="sea-city-city cs-blue-text size16"> <b><?= $tripdetails['source_leg'] ?> 
    	<span> <img src="<?php echo theme_img('search-arrow-right-grey.png');?>"> </span>
	  <?= $tripdetails['destination_leg'] ?> </b> </div>

      <div class="rowrec line4"></div>

      <div class="rowrec">

        <div class="trip-col3">
            <span class=""><span> <img src="<?php echo theme_img('src-dest-ico.png');?>"> </span> <?php echo lang('departure_point');?></span>
            <br>
            <span class=""><?= $tripdetails['source_leg'] ?></span>
            <br><br>
            <span class=""><span> <span> <img src="<?php echo theme_img('src-dest-ico-green.png');?>"> </span> </span> <?php echo lang('destination');?></span>
            <br>
            <span class=""><?= $tripdetails['destination_leg'] ?></span>
        </div>

        <div class="trip-col3">
            <span><span> <img src="<?php echo theme_img('random-ico.png');?>"> </span> <?php echo lang('detour');?></span>
            <br><br><br>
            <span class=""> <?php echo lang('maximum');?></span>
        </div>

        <div class="trip-col3">
            <span><span> <img src="<?php echo theme_img('time-ico.png');?>"> </span> <?php echo lang('flexibility');?></span>
            <br><br>            
            <span> <?php echo lang('leave');?></span>
        </div>

        <div class="trip-col3">
            <span><span> <img src="<?php echo theme_img('suitcase-ico.png');?>"> </span> <?php echo lang('luggage_size');?></span>
            <br><br>
            <span><?php echo lang('small');?></span>
        </div>

      </div>

      <div class="rowrec line4"></div>

    </div>
    <!-- End Left -->

    <div class="trip-right cs-lgrey-bg">
      
      <div class="rowrec trp-top padding10">
          <strong class="cs-blue-text"><?= $tripdetails['user_first_name'] .' '.$tripdetails['user_last_name'] ?></strong> <span><?php echo lang('offer');?> </span>
          <h4 class="paddingtop10 cs-blue-text">
		  <?php $source = explode(",", $tripdetails['source_leg']); 
			echo  $source[0]; ?>  <span class="paddinglr10"> <img src="<?php echo theme_img('search-arrow-right-grey.png');?>"> </span>
			<?php $destination = explode(",", $tripdetails['destination_leg']); 
			echo  $destination[0]; ?>
		  </h4>
      </div>

      <div class="rowrec line4"></div>

      <div class="padding20">          
          <h3 class="size22">  <?= format_currency($tripdetails['route_rate']); ?>  <?php echo lang('per_passenger');?></h3>
          
      </div>

      

      <div class="row">
		<?php if($tripdetails['trip_casual_date']){ ?>
        <div class="colmd6">
            <?php echo lang('departure_date');?><br>
            <span class="size20"><span><img src="<?php echo theme_img('cal-14-14.png');?>"></span> <?php echo date('d/m/Y',strtotime($tripdetails['trip_casual_date']));?>
            </span><br>
            <small> <?php echo date('M',strtotime($tripdetails['trip_casual_date']));?> </small>
        </div>
        <?php } ?>
        <div class="colmd6 noborder">
            <?php echo lang('departure_time');?><br>
            <span class="size20"><span><img src="<?php echo theme_img('time-ico.png');?>"></span> <?= $tripdetails['expected_time'] ?>
            </span><br>
           
        </div>

      </div>

      <div class="rowrec line4"></div>

      <div class="rowrec size20 cs-blue-text center"> <?php echo lang('total_no_seats');?> <?= $tripdetails['trip_avilable_seat'] ?>   </div> 

      <div class="rowrec line4"></div>

      <div class="rowrec center margin padding10">
      
      	<?php 
			
			if($islogin){
				
				if($tripdetails['trip_user_id'] == $user['user_id'])
				{?>
					<a href="javascript:void(0)" class="book-button padding10 row">  <?php echo lang('your_trip');?> </a>
				
		<?php }else if($status == 1){ 
		
		?>       
      		 
            <a href="javascript:void(0)" class="book-button padding10 rowrec"  id="enquiry_<?=$tripdetails['trip_id']?>"onclick="viewPopcontact(<?=$tripdetails['trip_id']?>)"><?php echo lang('get_enquiry');?></a> 
            
            <?php
				}
				else
				{ ?> 
                <a href="javascript:void(0)" class="book-button padding10 rowrec">  <?php echo lang('already');?> </a>
                
                <?php
					
				}
			}else {
				?>
                <a href="<?=base_url('login')?>" class="book-button padding10 rowrec"> <?php echo lang('get_enquiry');?> </a> 
                <?php
			}
			?>
      </div>

      <div class="rowrec line4"></div>

    </div>
    <!-- End Right -->

    </div>
    <!-- End -->

    <div class="rowrec margin">

      <div class="trip-lft">

        <h2> <?php echo lang('more_details');?> </h2>

        <div class="rowrec line4"></div>

        <p class="para"> <?= $tripdetails['trip_comments'] ?> </p>

      </div>
      <!-- End 2  left row -->

      <div class="trip-right">

        <h3 class="cs-lgrey-bg padding10"> <span> <img src="<?php echo theme_img('driver-ico.png');?>"> </span> <?php echo lang('driver');?> </h3>

        <div class="rowrec line4"></div>

        <div class="rowrec">

          <div class="fleft paddingright10">
              <a href="javascript:void(0)"> <img src="<?php if($tripdetails['user_profile_img']) { echo theme_profile_img($tripdetails['user_profile_img']); } else { echo theme_img('default.png');  }?>" class="search-thumb search-user-thumb"> </a>
          </div>
          <div class="fleft paddingtop10">
              <strong class="size16">
                  <a href="javascript:void(0)" class="cs-blue-text"><?= $tripdetails['user_first_name'] .' '.$tripdetails['user_last_name'] ?></a>
              </strong><br>
              <small class="size13" > </small>
              
          </div>
          
        </div>

        <div class="rowrec line4"></div>

        <h3 class="rowrec cs-lgrey-bg padding10"> <span> <img src="<?php echo theme_img('suitcase-ico.png');?>"> </span> <?php echo lang('my_verifications');?> </h3>

        <div class="rowrec line4"></div>

        <ul class="rowrec trp-cont-rht">
            <li>
                <span class="trp-imge paddingtop5"><img src="<?php echo theme_img('mobile-ico.png');?>"></span> <strong class="size14 paddingleft8"><?php echo lang('phone');?> </strong>
                <span class="fright paddingtop5"><img src="<?php echo theme_img('verified-ico-red.png ');?>"></span>
            </li>
            <li>
              <span class="trp-imge paddingtop5"><img src="<?php echo theme_img('mail-ico.png');?>"></span> <strong class="size14 paddingleft8"><?php echo lang('email');?> </strong>            
              <span class="fright paddingtop5"><img src="<?php echo theme_img('verified-ico-green.png');?>"></span>
            </li>
        </ul>

        <div class="rowrec line4"></div>

        <h3 class="rowrec cs-lgrey-bg padding10"> <span> <img src="<?php echo theme_img('suitcase-ico.png');?>"> </span> <?php echo lang('activity');?> </h3>

        <div class="rowrec line4"></div>

        <ul class="size14 row trp-cont-rht">           
            <li><span class="trp-imge paddingtop5"><img src="<?php echo theme_img('cal-14-14.png');?>" width="12" height="12"></span> <strong class="paddingleft8">Since</strong>: <?php echo date('d/m/Y',strtotime($tripdetails['user_created_date']));?></li>
            <li><span class="trp-imge paddingtop5"><img src="<?php echo theme_img('time-ico.png');?>"></span> <strong class="paddingleft8"><?php echo lang('last_visit');?></strong>: <?php echo date('d/m/Y',strtotime($tripdetails['user_lost_login']));?></li>
           
        </ul>

        <div class="rowrec line4"></div>

        <h3 class="rowrec cs-lgrey-bg padding10"> <span> <img src="<?php echo theme_img('suitcase-ico.png');?>"> </span> <?php echo lang('car');?> </h3>

        <div class="rowrec line4"></div>

        <div class="rowrec center">
              <span class=" rowrec cs-blue-text"><b><?= $tripdetails['vechicle_type_name'] ?></b></span>
              <img class="search-thumb search-user-thumb " style="margin: 15px 0 15px 7px;" src="<?php if(!empty($tripdetails['vechicle_logo'])){ echo  base_url('uploads/vehicle/thumbnails/'.$tripdetails['vechicle_logo'] ); } else { echo theme_img('no_car.png'); } ?>">
               
              </div>
          </div>

      </div>
      <!-- End 2  right row -->

    </div>


  </div>
</div>
<?php include('footer.php'); ?>
