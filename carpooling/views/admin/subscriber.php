<?php include('header.php'); ?>
<?php include('left.php'); ?>
<?php echo admin_js('admin.js', true);?>
<script type="text/javascript" language="javascript">

var baseurl = "<?php print base_url(); ?>";
function category_ajax(url) {
		
		$.ajax({
		type: "POST",
		url: baseurl+"admin/subscriber/subscriber_ajax/"+url,		
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
                                    <li class="active"><span>Subscribers</span></li>
                                </ol>
                                
                                <div class="clearfix">
                                    <h1 class="pull-left">All Subscribers</h1>
                                    
                                   
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
                                                            <th><span>Id</span></th>
                                                            <th><span>Subscribed Email-Id</span></th>
                                                            <th><span>Subscribed IP</span></th>
                                                            <th class="text-center"><span>created</span></th>															
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($subscribers as $subscriber):?>
                                                        <tr>
                                                            <td>
                                                                <?=$subscriber['subscribe_id']?>
                                                            </td>
                                                            <td>
                                                                <?=$subscriber['subscribe_email']?>
                                                            </td>
                                                            <td>
                                                                <?=$subscriber['subscribe_ip']?>            
                                                            </td>
                                                            <td>
                                                                <?php echo date('d, M Y h:i A',strtotime($subscriber['created_date']));?> 
                                                                
                                                            </td>      
                                                            <td style="width: 20%;" class="bacis">
                                                                
                                                                <a href="<?php echo base_url('admin/subscriber/delete/'.$subscriber['subscribe_id']);?>"  onclick="return areyousure();" class="table-link danger">
                                                                    <a href="<?php echo base_url('admin/subscriber/delete/'.$subscriber['subscribe_id']);?>"  onclick="return areyousure();" class="table-link danger">
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
