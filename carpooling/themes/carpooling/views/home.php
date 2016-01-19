<?php include('header_home.php'); ?>
<?php echo theme_js('tinycarousel/jquery.tinycarousel.min.js', true);?>
<link href="<?php  echo theme_js('tinycarousel/tinycarousel.css');?> " rel="stylesheet" type="text/css">
<script>
$(document).ready(function() {
$('#slider1').tinycarousel({
	start: 1, // where should the carousel start?
	display: 4, // how many blocks do you want to move at a time?
	axis: 'X', // vertical or horizontal scroller? 'x' or 'y' .
	controls: true, // show left and right navigation buttons?
	pager: false, // is there a page number navigation present?
	interval: true, // move to the next block on interval.
	intervaltime: 3000, // interval time in milliseconds.
	animation: true, // false is instant, true is animate.
	duration: 1000, // how fast must the animation move in milliseconds?
	callback: null, // function that executes after every move
	}); 
});
</script>
<style>
    .overview li a{
        color: #000;
    }
</style>
</head>

<body>
<div class="container-fluid">
<div class="container">
  <div class="row">
    <div class="col-lg-7 margintop20 hideall">
      <h2 class="rec-ride margintop20"><?php echo lang('recent_rides');?></h2>
      <div class="row margintop20">
        <div id="slider1">
          <div class="row margintop20 marginbottom25 nomargin">
            <div class="arr"> <a class="buttons prev" href="#"><img src="<?php echo theme_img('up-arrow.png'); ?>"></a> </div>
          </div>
          <div class="row nomargin">
            <div class="rec-rid-tbl">
              <div class="viewport">
                <ul class="overview">
                  <?php foreach($recent_trips as $trip) { ?>
                  <li>
                      <a href="<?php echo site_url('trip/tripdetails/'.$trip['trip_led_id']);?>" target="blank">   
                        <div class="slid_inner">
                          <div class="slid_first"> <img src="<?php if($trip['user_profile_img']) { echo theme_profile_img($trip['user_profile_img']); } else { echo theme_img('default.png');  }?>" width="40">
                            <h3>
                              <?=$trip['user_first_name'].' '.$trip['user_last_name']?>
                            </h3>
                            <p>
                              <?php 
                                            $source = explode(',',$trip['source']);
                                            echo (!empty($source[0])?$source[0]:'').(!empty($source[1])?','.$source[1]:''); ?>
                            </p>
                          </div>
                          <div class="slid_second"> <img src="<?php echo theme_img('place-marker-ico.png') ?>">
                            <h4>
                              <?php 
                                            $destination = explode(',',$trip['destination']);
                                            echo (!empty($destination[0])?$destination[0]:'').(!empty($destination[1])?','.$destination[1]:''); ?>
                              </p>
                            </h4>
                          </div>
                          <div class="slid_third">
                            <?php if($trip['trip_casual_date'] != '') { ?>
                            <h5 class="size14 fright"> <span class="fleft">
                              <?=$trip['trip_casual_date']?>
                              </span> </h5>
                            <?php } else {  ?>
                            <h5 class="size14 fright"> <span class="fleft">
                              <?= 'Regular' ?>
                              </span> </h5>
                            <?php } ?>
                          </div>
                        </div>
                    </a>    
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="arr barr"> <a class="buttons next" href="#"><img src="<?php echo theme_img('down-arrow.png'); ?>"></a> </div>
          </div>
        </div>
      </div>
      </div>
      <!-- End Recent Rides -->
      
     <div class="col-lg-5 margintop20">
            		<div class="recent-rides rrecent margintop20">
				        <h2> <?php echo lang('testimonials');?> </h2>

				        <ul>
                        <?php 
		 if(!empty($testimonials)){
		 foreach($testimonials as $testimonial) { ?>       
       
				          <li>
				            <div class="rr-lft re-lft fleft">
				              <div class="recent-img rrimg"> <img src="<?php if(!empty($testimonial['image'])) { echo theme_testimonials_img($testimonial['image']); } else {  echo theme_img('mem-img1.jpg'); } ?>"> </div>
				              <h3><?=$testimonial['name']?></h3>
				            </div>
				            <p class="test-rht-bx">
				              <span class="lft-arr-ic"> <img src="<?php echo theme_img('left-arrow-ico.png') ?>"></span> <span style="font-family:Arial;"> " </span>   <?= character_limiter($testimonial['description'], 75) ; ?> 
				            </p>
				          </li>
				          
                           <?php } } ?>
				        </ul>
				      </div>
            	</div>
    </div>
  </div>
<div class="container-fluid">
  <div class="container">
    <div class="row line4 margintop40"></div>
  </div>
</div>
<div class="container-fluid">
  <div class="container">
    <div class="row margintop40">
      <div class="how-but"> <?php echo lang('how_it_works');?> </div>
      <div class="marginbot10">
        <div class="how-it-lft fleft dplnon"> <img src="<?php echo theme_img('car-img.png') ?>"> </div>
        <div class="how-it-lft fright rrecent how-it">
          <h4 class="size22 marginbot10"> <?php echo lang('for_car_owners');?> </h4>
          <ul class="hw-it-wks">
            <li>
              <div class="how-i-img how-search-ico"> </div>
              <div class="how-i-cnt fright">
                <h4 class="marginbot10"> <?php echo lang('find_your_perfect_car_travellers');?> </h4>
                <p class="para"><?php echo lang('find_para');?></p>
              </div>
            </li>
            <li>
              <div class="how-i-img how-contact-ico"> </div>
              <div class="how-i-cnt fright">
                <h4 class="marginbot10"> <?php echo lang('contact_car_travellers');?> </h4>
                <p class="para"><?php echo lang('contact_para');?></p>
              </div>
            </li>
            <li>
              <div class="how-i-img how-hire-ico"> </div>
              <div class="how-i-cnt fright">
                <h4 class="marginbot10"> <?php echo lang('hire_with_confidence');?> </h4>
                <p class="para"><?php echo lang('hire_para');?></p>
              </div>
            </li>
          </ul>
          <div class="how-i-link"> <a href="#" class="cs-blue-bg"> <?php echo lang('view_all_car_travellers');?> </a> <span> or </span> <a href="#" class="cs-grey-bg"> <?php echo lang('post_a_car');?> </a> </div>
        </div>
      </div>
    </div>
    <div class="row line4 margintop40 marginbot40"></div>
    <div class="row">
      <div class="how-it-lft fright dplnon"> <img src="<?php echo theme_img('index-how-it-img.png') ?>"> </div>
      <div class="how-it-lft fleft rrecent how-it">
        <h4 class="size22 marginbot10"> <?php echo lang('for_car_travellers');?> </h4>
        <ul class="hw-it-wks">
          <li>
            <div class="how-i-img how-edit-ico"> </div>
            <div class="how-i-cnt fright">
              <h4 class="marginbot10"> <?php echo lang('create_a_profile');?> </h4>
              <p class="para"><?php echo lang('create_para');?></p>
            </div>
          </li>
          <li>
            <div class="how-i-img how-job-ico"> </div>
            <div class="how-i-cnt fright">
              <h4 class="marginbot10"> <?php echo lang('got_a_job');?> </h4>
              <p class="para"><?php echo lang('got_job_para');?></p>
            </div>
          </li>
          <li>
            <div class="how-i-img how-star-ico"> </div>
            <div class="how-i-cnt fright">
              <h4 class="marginbot10"> <?php echo lang('become_a_star');?> </h4>
              <p class="para"><?php echo lang('become_para');?></p>
            </div>
          </li>
        </ul>
        <div class="row how-i-link"> <a href="#" class="cs-blue-bg"> <?php echo lang('create_a_profile');?> </a> <span> or </span> <a href="#" class="cs-grey-bg"> <?php echo lang('view_all_profiles');?> </a> </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid cs-blue-bg margintop40">
  <div class="container">
    <div class="margintop40 marginbot40 center gtcont">
      <h2 class="colorwhite"> <?php echo lang('got_a_question');?>? </h2>
      <p class="padding20 row colorwhite">We're here to help. Check out our FAQs, Send us an email or call us at 1800 555 555</p>
      <a href="#"> <?php echo lang('contact_now');?> </a> </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo  theme_js('jquery.datepick/redmond.datepick.css');?>">
<?php echo  theme_js('jquery.datepick/jquery.plugin.js',true);?> <?php echo  theme_js('jquery.datepick/jquery.datepick.js',true);?> 
<script type="text/javascript">

$('#journey_date').datepick({
	 changeMonth: false,autoSize: true,minDate: 0,dateFormat: 'dd/mm/yyyy'});
	 
	 $('#journey_dater').datepick({
	 changeMonth: false,autoSize: true,minDate: 0,dateFormat: 'dd/mm/yyyy'});
</script>
<?php include('footer_home.php'); ?>