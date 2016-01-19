<?php include('header.php'); ?>
<?php include('left.php'); ?>

<script type="text/javascript" language="javascript">

var baseurl = "<?php print base_url(); ?>";
function radius_ajax(url) {
		
		$.ajax({
		type: "POST",
		url: baseurl+"admin/radius/radius_ajax/"+url,		
		success: function(html){		
		var message = $('<div />').append(html).find('#splitresult').html();
		$("#pageresult").html(message);
		$('body').find('.bacis a').popover();
		}
	});
}

function areyousure()
{
	return confirm('<?php echo 'Are you want to delete this';?>');
}
</script>

<div id="content-wrapper">
					<div class="row">
						<div class="col-lg-12">
                                <ol class="breadcrumb">
                                    <li><a href="#">Home</a></li>
                                    <li class="active"><span>Radius</span></li>
                                </ol>
                                
                                <div class="clearfix">
                                    <h1 class="pull-left">All Radius</h1>
                                    
                                    <div class="pull-right top-page-ui">
                                        <a href="<?php echo base_url('admin/radius/form');?>" class="btn btn-primary pull-right">
                                            <i class="fa fa-plus-circle fa-lg"></i> Add Radius
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
								<div class="col-lg-12">
									<div class="main-box no-header clearfix">
										<div class="main-box-body clearfix">
											<div id="pageresult">
                                            <div class="table-responsive">                                             
												<table class="table user-list table-hover">
													<thead>
														<tr>
															<th><span>Distance From</span></th>
                                                            <th><span>Distance To</span></th>
															<th><span>Radius</span></th>																													
															<th>&nbsp;</th>
														</tr>
													</thead>
													<tbody>
                                                    <?php foreach ($radiuses as $radius):?>
														<tr>
															<td>
																<?=$radius['distance_from']?>
															</td>
                                                            <td>
																<?=$radius['distance_to']?>
															</td>															
															<td>
                                                            	<?=$radius['radius']?>
															</td>
															<td style="width: 20%;" class="bacis">																
																<a href="<?php echo base_url('admin/radius/form/'.$radius['id']);?>" class="table-link">
																	<span class="fa-stack">
																		<i class="fa fa-square fa-stack-2x"></i>
																		<i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
																	</span>
																</a>
																<a href="<?php echo base_url('admin/radius/delete/'.$radius['id']);?>" onclick="return areyousure();" class="table-link danger">
                                            <span class="fa-stack">
                                                            <i class="fa fa-square fa-stack-2x"></i>
                                                            <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                        </span>
																</a>
															</td>
														</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
											</div>
                                            <?php echo $pagination?>
										</div>
                                        </div>
									</div>
								</div>
							</div>
						
						
					</div>
                    <script>
	 $(document).ready(function() {
                $('body').find('.bacis a').popover();
            });
	</script>


<?php include('footer.php'); ?>
