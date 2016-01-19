<div id="splitresult">
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
            <td class="text-center">
                <?=$radius['radius']?>
            </td>
            <td style="width: 20%;">																
                <a href="<?php echo base_url('admin/radius/form/'.$radius['category_id']);?>" class="table-link">
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