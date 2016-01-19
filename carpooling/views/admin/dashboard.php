<?php include('header.php'); ?>
<?php include('left.php'); ?>

<div id="content-wrapper">
					<div class="row">
						<div class="col-lg-12">
							
							<div class="row">
								<div class="col-lg-12">
									<ol class="breadcrumb">
										<li><a href="#">Home</a></li>
										<li class="active"><span>Dashboard</span></li>
									</ol>
									
									
								</div>
							</div>
                            
                            <div class="row">								
                            	
								<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box colored emerald-bg">
										<i class="fa fa-user"></i>
										<span class="headline">Users</span>
										<span class="value"><?=$total_users?></span>
									</div>
								</div>

								<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box colored green-bg">
										<i class="fa fa-map-marker"></i>
										<span class="headline">Trips</span>
										<span class="value"><?=$total_trips?></span>
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box colored purple-bg">
										<i class="fa fa-bookmark-o"></i>
										<span class="headline">Subscribers</span>
										<span class="value"><?=$total_subscribers?></span>
									</div>
								</div>
                                <div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box colored red-bg">
										<i class="fa  fa-car"></i>
										<span class="headline">Vehicles</span>
										<span class="value"><?=$total_vehicles?></span>
									</div>
								</div>
							</div>
                            
                            <div class="row">
								<div class="col-md-12">
									<div class="main-box">
										<header class="main-box-header clearfix">
											<h2 class="pull-left">Daily Logged Users</h2>
										</header>

										<div class="main-box-body clearfix">
											<div class="row">
												<div class="col-md-12">
													<div id="graph-bar" style="height: 240px; padding: 0px; position: relative;"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            
                            <div class="row">
                            	<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box">
										<i class="fa fa-file-photo-o emerald-bg"></i>
										<span class="headline">Enquires</span>
										<span class="value">
											<span class="timer" data-from="30" data-to="658" data-speed="800" data-refresh-interval="30">
												<?=$total_enquiry?>
											</span>
										</span>
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box">
										<i class="fa fa-sliders red-bg"></i>
										<span class="headline">Testimonials</span>
										<span class="value">
											<span class="timer" data-from="120" data-to="2562" data-speed="1000" data-refresh-interval="50">
												<?=$total_testimonials?>
											</span>
										</span>
									</div>
								</div>								
								<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box">
										<i class="fa fa-arrows-alt green-bg"></i>
										<span class="headline">Vehicle Category</span>
										<span class="value">
											<span class="timer" data-from="83" data-to="8400" data-speed="900" data-refresh-interval="60">
												<?=$total_categories?>
											</span>
										</span>
									</div>
								</div>
							</div>
							
							
							
													
							
							
						</div>
					</div>
                    
<?php echo admin_js('flot/jquery.flot.min.js',true); ?>
 <?php echo admin_js('flot/jquery.flot.resize.min.js',true); ?>
 <?php echo admin_js('flot/jquery.flot.time.min.js',true); ?>
  <?php echo admin_js('flot/jquery.flot.threshold.js',true); ?>
 <?php echo admin_js('flot/jquery.flot.axislabels.js',true); ?>  
<!-- this page specific inline scripts -->
	<script>
	$(document).ready(function() {

	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}

		if ($('#graph-bar').length) {
			
			var data2 = <?=$visiter_data?>;

			var series = new Array();

			
			series.push({
				data: data2,
				color: '#e84e40',
				lines: {
					show : true,
					lineWidth: 3,
				},
				points: {
					fillColor: "#e84e40",
					fillColor: '#ffffff',
					pointWidth: 1,
					show: true
				},
				label: 'Daily Logged Users'
			});

			$.plot("#graph-bar", series, {
				colors: ['#03a9f4', '#f1c40f', '#2ecc71', '#3498db', '#9b59b6', '#95a5a6'],
				grid: {
					tickColor: "#f2f2f2",
					borderWidth: 0,
					hoverable: true,
					clickable: true
				},
				legend: {
					noColumns: 1,
					labelBoxBorderColor: "#000000",
					position: "ne"
				},
				shadowSize: 0,
				xaxis: {
					mode: "time",
					tickSize: [1, "month"],
					tickLength: 0,
					// axisLabel: "Date",
					axisLabelUseCanvas: true,
					axisLabelFontSizePixels: 12,
					axisLabelFontFamily: 'Open Sans, sans-serif',
					axisLabelPadding: 10
				}
			});

			var previousPoint = null;
			$("#graph-bar").bind("plothover", function (event, pos, item) {
				if (item) {
					if (previousPoint != item.dataIndex) {

						previousPoint = item.dataIndex;

						$("#flot-tooltip").remove();
						var x = item.datapoint[0],
						y = item.datapoint[1];

						showTooltip(item.pageX, item.pageY, item.series.label, y );
					}
				}
				else {
					$("#flot-tooltip").remove();
					previousPoint = [0,0,0];
				}
			});

			function showTooltip(x, y, label, data) {
				$('<div id="flot-tooltip">' + '<b>' + label + ': </b><i>' + data + '</i>' + '</div>').css({
					top: y + 5,
					left: x + 20
				}).appendTo("body").fadeIn(200);
			}
		}
});
</script>		                    


<?php include('footer.php'); ?>
