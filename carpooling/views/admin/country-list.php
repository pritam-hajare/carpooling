<div id="splitresult">
    <div class="table-responsive">                                             
        <table class="table user-list table-hover">
            <thead>
                <tr>
                    <th><span>Id</span></th>
                    <th><span>Country Name</span></th>
                    <th><span>Country Short Name</span></th>
                    <th><span>Created</span></th>
                    <th class="text-center"><span>Status</span></th>															
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($countries as $country): ?>
                    <tr>
                        <td>
                            <?= $country['country_id'] ?>
                        </td>
                        <td>
                            <?= $country['country_name'] ?>
                        </td>
                        <td>
                            <?= $country['country_code'] ?>
                        </td>
                        <td>
                            <?php echo date('d, M Y h:i A', strtotime($country['created_date'])); ?> 

                        </td>
                        <td class="text-center">
                            <?php if ($country['is_active'] == 0) { ?>
                                <span class="label label-default" id="label-<?= $country['country_id'] ?>">Inactive</span>
                            <?php } else { ?>
                                <span class="label label-success" id="label-<?= $country['country_id'] ?>">Active</span>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" id="btn-<?= $country['country_id'] ?>">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    Change Status <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <?php if ($country['is_active'] == 0) { ?>
                                        <li style="border:0px; height:auto; padding:0px;"><a href="#" id="enable-<?= $country['country_id'] ?>" class="change-status-country" rel="<?= $country['country_id'] ?>">Enable</a></li>
                                    <?php } else { ?>
                                        <li style="border:0px; height:auto; padding:0px;"><a href="#" id="disable-<?= $country['country_id'] ?>" class="change-status-country" rel="<?= $country['country_id'] ?>">Disable</a></li>
                                    <?php } ?>

                                    <li class="divider"></li>
                                </ul>

                            </div>
                        </td>
                        <td style="width: 20%;" class="bacis">
                            <a href="#" class="table-link">
                                <span class="fa-stack">
                                    <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <a href="<?php echo base_url('admin/country/form/' . $country['country_id']); ?>" class="table-link">
                                <span class="fa-stack">
                                    <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <a href="<?php echo base_url('admin/country/delete/' . $country['country_id']); ?>"  onclick="return areyousure();" class="table-link danger">
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
    <?php echo $pagination ?>

</div>