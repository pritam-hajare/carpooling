<?php include('header.php'); ?>
<?php include('left.php'); ?>
<?php echo admin_js('admin.js', true);?>
<script type="text/javascript" language="javascript">

function areyousure()
{
	return confirm('<?php echo 'Are you want to Edit this';?>');
}
</script>
<style type="text/css"> iframe[id^='twitter-widget-']{ width:280px !important;} </style>
<div id="content-wrapper">
					<div class="row">
						<div class="col-lg-12">
                                <ol class="breadcrumb">
                                    <li><a href="#">Home</a></li>
                                    <li class="active"><span>Widgets</span></li>
                                </ol>
                                
                                <div class="clearfix">
                                    <h1 class="pull-left">List Of Widgets</h1>
                                    
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
															<th><span>Widget Name</span></th>
                                                            <th><span>Widget</span></th>                                                           
															<th class="text-center"><span>Status</span></th>
                                                            <th></th>
                                                            <th><span>Action</span></th>
														</tr>
													</thead>
													<tbody>
                                                    <?php foreach ($widgets as $widget): ?>
														<tr>
															<td>
																<?=$widget['widget_name']?> 
															</td>
                                                            <td>
																<?=$widget['widget_link']?>
                                                                <?=$widget['widget_script']?>
															</td>
                                                                                                                     														
															 <td class="text-center">
                                                            <?php if($widget['widget_flag'] == 0) { ?>
                <span class="label label-default" id="label-<?=$widget['id']?>">Inactive</span>
                                                            <?php } else { ?>
                                                             <span class="label label-success" id="label-<?=$widget['id']?>">Active</span>
                                                            <?php } ?>
               </td>
                                                            <td class="text-center">
                                                                <div class="btn-group" id="btn-<?=$widget['id']?>">
                                                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                                                        Change Status <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                    <?php if($widget['widget_flag'] == 0) { ?>
                                                                        <li style="border:0px; height:auto; padding:0px;"><a href="#" id="enable-<?=$widget['id']?>" class="change-status-widget" rel="<?=$widget['id']?>">Enable</a></li>
                                                                    <?php } else { ?>
                                                                     <li style="border:0px; height:auto; padding:0px;"><a href="#" id="disable-<?=$widget['id']?>" class="change-status-widget" rel="<?=$widget['id']?>">Disable</a></li>
                 <?php } ?>                                                                        
                                                                        <li class="divider"></li>
                                                                    </ul>
                                                                    
                                                                 </div>
                                                            </td>
															<td style="width: 20%;">																
																<a href="<?php echo base_url('admin/widgets/widget_form/'.$widget['id']);?>" class="table-link">
																	<span class="fa-stack">
																		<i class="fa fa-square fa-stack-2x"></i>
																		<i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
																	</span>
																</a>
																
															</td>
														</tr>
														<?php endforeach; ?>
													</tbody>
												</table>
											</div>
                                           
										</div>
                                        </div>
									</div>
								</div>
							</div>
					</div>


<?php include('footer.php'); ?>
