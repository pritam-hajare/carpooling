<?php          
         if($search_results)
          {                              
            foreach ($search_results as $search_result)
           { 
           ?>
        <div class="row sea-box">
          <a href="<?php echo site_url('trip/tripdetails/'.$search_result['trip_led_id']);?>">
            <div class="sea-col1">            
              <div class="sea-nam">
                <h3> <?php if($search_result['user_type'] == 1){echo $search_result['user_company_name']; }else{ echo $search_result['user_first_name'].'.'.$search_result['user_last_name'];}?></h3>
                <div class="line2"></div>
                <div> 
                 <?php if(!empty($search_result['vechicle_logo'])){ ?>
                <img src="<?php echo base_url('uploads/vehicle/thumbnails/'.$search_result['vechicle_logo']); ?>" class="search-thumb search-user-thumb"><?php } else {  ?>
                <img src="<?php echo theme_img('no_car.png'); ?>" class="search-thumb search-user-thumb">
                <?php }?>
                </div>                
              </div>
            </div>
            <div class="sea-col2">
              <h3><?=date('Y/m/d l ',now());?> <?=(!empty($search_result['trip_depature_time'])?'- '.$search_result['trip_depature_time']:'');?></h3>
              <div class="line2"></div>
              <div class="sea-city-city"> 
              		<?php $source = explode(",", $search_result['source']); 
                    echo  $source[0]; ?> <span> <img src="<?php echo theme_img('search-arrow-right.png') ?>"> </span> 
                    <?php $destination = explode(",", $search_result['destination']); 
                    echo  $destination[0]; ?>
              </div> <br>
              <div class="search-pick-point">
                <strong class="cs-blue-text"><span> <img src="<?php echo theme_img('src-dest-ico.png') ?>"> </span> <?php echo lang('departure');?></strong>
                <?= $search_result['source'] ?>
                <span class="cs-blue-text"><?='( '.$amenties_details['distance_'.$search_result['trip_id']].' km away from your search location)'?></span>
                <br>
                <div class="paddingtop10"><strong class="cs-blue-text margintop10"><span> <img src="<?php echo theme_img('src-dest-ico.png') ?>"> </span> <?php echo lang('arrival');?></strong>
                 <?= $search_result['destination'] ?></div>
              </div>
            </div>
            <div class="sea-col3">
              <strong class="size16 text-success"> <?= format_currency($search_result['route_rate']); ?> </strong> <span class="size14"> <?php echo lang('per_passenger');?> </span>
              <div class="line2"></div>
              <!--<h4> Payment Methods </h4>
              <div class="pay-met paddingtop10"> <img src="<?php //echo theme_img('pay-method.png') ?>"> </div> <br>-->
              <span class="badge blue-badge marginleft0" ><?= $search_result['trip_avilable_seat'] ?></span> <span class="size14"> <?php echo lang('available_seat');?> </span>
              <br><br>
              <!--<span class="size14 fleft"> Comfort Level </span>
              <div class="starrow fleft marginleft10">
                <i class="star-img"><img src="<?php //echo theme_img('star-ico.png') ?>"></i>
                <i class="star-img"><img src="<?php //echo theme_img('star-ico.png') ?>"></i>
                <i class="star-img"><img src="<?php //echo theme_img('star-ico.png') ?>"></i>
                <i class="star-img"><img src="<?php //echo theme_img('nostar-ico.png') ?>"></i>
                <i class="star-img"><img src="<?php //echo theme_img('nostar-ico.png') ?>"></i>
              </div>-->
            </div>
          </a>
        </div>
        <!-- End Box -->
        <?php }
				  }?>