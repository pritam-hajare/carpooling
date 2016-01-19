<div id="splitresult">
    <div class="table-responsive">                                             
        <table class="table user-list table-hover">
            <thead>
                <tr>
                    <th><?php echo 'Vehicle Id'; ?></th>
                    <th><?php echo 'Vehicle Name'; ?></th>
                    <th><?php echo 'Vehicle Brand name'; ?></th>
                    <th><?php echo 'Vehicle Image'; ?></th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicle as $travell): ?>
                    <tr>
                        <td><?php echo $travell->vechicle_type_id; ?></td>
                        <td class="gc_cell_left"><?php echo $travell->vechicle_type_name; ?></td>
                        <td class="gc_cell_left"><?php echo $travell->category_name; ?></td>
                        <td class="gc_cell_left"><?php if(!empty($travell->vechicle_image)){ ?>
                            <img src="<?=theme_vehicles_img($travell->vechicle_image,'small')?>"/>
                          <?php } else { ?>
                            <img src="<?=theme_img('no_car.png');?>"/>
                          <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if ($travell->isactive == 0) { ?>
                                <span class="label label-default" id="label-<?= $travell->vechicle_type_id; ?>">Inactive</span>
                            <?php } else { ?>
                                <span class="label label-success" id="label-<?= $travell->vechicle_type_id; ?>">Active</span>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" id="btn-<?= $travell->vechicle_type_id; ?>">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    Change Status <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <?php if ($travell->isactive == 0) { ?>
                                        <li style="border:0px; height:auto; padding:0px;"><a href="#" id="enable-<?= $travell->vechicle_type_id; ?>" class="change-status" rel="<?= $travell->vechicle_type_id; ?>">Enable</a></li>
                                    <?php } else { ?>
                                        <li style="border:0px; height:auto; padding:0px;"><a href="#" id="disable-<?= $travell->vechicle_type_id; ?>" class="change-status" rel="<?= $travell->vechicle_type_id; ?>">Disable</a></li>
                                    <?php } ?>

                                    <li class="divider"></li>
                                </ul>

                            </div>
                        </td>
                        <td style="width: 20%;"><a href="<?php echo base_url('admin/vehicle/form/' . $travell->vechicle_type_id); ?>" class="table-link"> <span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-pencil fa-stack-1x fa-inverse"></i> </span> </a> <a href="<?php echo base_url('admin/vehicle/delete/' . $travell->vechicle_type_id); ?>"  onclick="return areyousure();" class="table-link danger"> <span class="fa-stack"> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i> </span> </a></td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    <?php echo $pagination ?>

</div>