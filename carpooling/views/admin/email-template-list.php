<div id="splitresult">
<div class="table-responsive">                                             
<table class="table user-list table-hover">
<thead>
    <tr>
        <th><span>Id</span></th>
        <th><span>Email Name</span></th>
        <th><span>Email subject</span></th>															
        <th>&nbsp;</th>
    </tr>
</thead>
<tbody>
<?php 
foreach ($canned_messages as $canned_message):?>
    <tr>
        <td>
            <?=$canned_message['tplid']?>
        </td>
        <td>
            <?=$canned_message['tplshortname']?>
        </td>
        <td>
            <?=$canned_message['tplsubject'];?> 
            
        </td>															
        <td style="width: 20%;">																
            <a href="<?php echo base_url('admin/settings/canned_message_form/'.$canned_message['tplid']);?>" class="table-link">
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
<?php echo $pagination?>

</div>