<div id="splitresult">
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
                              
                              <a href="javascript:void(0)" class="table-link danger" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Currently you are viewing the demo version. The demo version of the site doesn't provide the option for deleting any source content from the site. The option for deleting the source content will be available on the purchase of the Script only." data-original-title="" title="">
                                            <span class="fa-stack">
                                                            <i class="fa fa-square fa-stack-2x"></i>
                                                            <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                        </span>
            </a></td>
                          </tr>
                          <?php	}	?>
                        </tbody>
                        <?php endif;?>
                      </table>
</div>
<?php echo $pagination?>

</div>