<div id="splitresult">
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
            
           <a href="javascript:void(0)" class="table-link danger" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Delete option disable for demo.Currently you are viewing the demo version. The demo version of the site doesn't provide the option for deleting any source content from the site. The option for deleting the source content will be available on the purchase of the Script only." data-original-title="" title="">
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