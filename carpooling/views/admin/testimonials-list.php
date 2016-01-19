<div id="splitresult">
 <div class="table-responsive">                                             
<table class="table user-list table-hover">
    <thead>
        <tr>
            <th><span>Id</span></th>
            <th><span>Testimonials Name</span></th>
            <th><span>Testimonials Description</span></th>            
            <th><span>Created</span></th>
            <th class="text-center"><span>Status</span></th>															
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($testimonials as $testimonial):?>
        <tr>
            <td>
                <?=$testimonial['id']?>
            </td>
            <td>
                <?=$testimonial['name']?>
            </td>
            <td>
                <?=$testimonial['description']?>
            </td>            
            <td>
                <?php echo date('d, M Y h:i A',strtotime($testimonial['created_date']));?> 
                
            </td>
            <td class="text-center">
                                                            <?php if($testimonial['isactive'] == 0) { ?>
                <span class="label label-default" id="label-<?=$testimonial['id']?>">Inactive</span>
                                                            <?php } else { ?>
                                                             <span class="label label-success" id="label-<?=$testimonial['id']?>">Active</span>
                                                            <?php } ?>
               </td>
                                                            <td class="text-center">
                                                                <div class="btn-group" id="btn-<?=$testimonial['id']?>">
                                                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                                                        Change Status <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                    <?php if($testimonial['isactive'] == 0) { ?>
                                                                        <li style="border:0px; height:auto; padding:0px;"><a href="#" id="enable-<?=$testimonial['id']?>" class="change-status-testimonials" rel="<?=$testimonial['id']?>">Enable</a></li>
                                                                    <?php } else { ?>
                                                                     <li style="border:0px; height:auto; padding:0px;"><a href="#" id="disable-<?=$testimonial['id']?>" class="change-status-testimonials" rel="<?=$testimonial['id']?>">Disable</a></li>
                 <?php } ?>
                                                                        
                                                                        <li class="divider"></li>
                                                                    </ul>
                                                                    
                                                                 </div>
                                                            </td>
            <td style="width: 20%;" class="bacis">																
                <a href="<?php echo base_url('admin/testimonials/form/'.$testimonial['id']);?>" class="table-link">
                    <span class="fa-stack">
                        <i class="fa fa-square fa-stack-2x"></i>
                        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                    </span>
                </a>
               <a href="javascript:void(0)" class="table-link danger" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Currently you are viewing the demo version. The demo version of the site doesn't provide the option for deleting any source content from the site. The option for deleting the source content will be available on the purchase of the Script only." data-original-title="" title="">
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