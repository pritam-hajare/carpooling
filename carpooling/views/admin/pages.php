<?php include('header.php'); ?>
    <?php include('left.php'); ?>
    <script type="text/javascript">
	var baseurl = "<?php print base_url(); ?>";
function page_ajax(url) {
		
		$.ajax({
		type: "POST",
		url: baseurl+"admin/pages/page_ajax/"+url,		
		success: function(html){		
		var message = $('<div />').append(html).find('#splitresult').html();
		$("#pageresult").html(message);
		$('body').find('.bacis a').popover();
		}
	});
}
	
	
	
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete');?>');
}
</script> 
    <script src="<?php echo base_url('assets/js/plugins/datatable/jquery.dataTables.min.js'); ?>"></script>
    <div id="content-wrapper">
      <div class="row">
        <div class="container-fluid">
          <div class="col-lg-12">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li><a href="#">CMS</a></li>
              <li class="active"><span>Pages</span></li>
            </ol>
            <div class="clearfix">
              <h1 class="pull-left">
                <?php if(!empty($page_title)):?>
                <?php echo  $page_title; ?>
                <?php endif; ?>
              </h1>
              <div class="pull-right top-page-ui"> <a href="<?php echo base_url('admin/pages/form');?>" class="btn btn-primary pull-right"> <i class="fa fa-plus-circle fa-lg"></i> Add New Page </a> </div>
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
                            <th><?php echo lang('title');?></th>
                            <th></th>
                          </tr>
                        </thead>
                        <?php echo (count($pages) < 1)?'<tr><td style="text-align:center;" colspan="2">'.lang('no_pages_or_links').'</td></tr>':''?>
                        <?php if($pages):?>
                        <tbody>
                          <?php
		$GLOBALS['admin_folder'] = $this->config->item('admin_folder');
		
			foreach($pages as $page)	{?>
                          <tr class="gc_row">
                            <td><?php echo $page->title; ?></td>
                            <td style="width: 20%;" class="bacis">
                              <a href="<?php echo site_url($GLOBALS['admin_folder'].'/pages/form/'.$page->id); ?>" class="table-link"> <span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-pencil fa-stack-1x fa-inverse"></i> </span> </a><a class="btn btn-primary pull-right" href="<?php echo site_url($page->slug); ?>" target="_blank"><?php echo lang('go_to_page');?></a>
                              <a href="<?php echo site_url($GLOBALS['admin_folder'].'/pages/delete/'.$page->id); ?>"  onclick="return areyousure();" class="table-link danger"> <span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i> </span> </a></td>
                               </td>
                          </tr>
                          <?php	}	?>
                        </tbody>
                        <?php endif;?>
                      </table>
                    </div>
                    <?php echo $pagination; ?>
                  </div>
                </div>
              </div>
            </div>
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
<?php include('footer.php');

