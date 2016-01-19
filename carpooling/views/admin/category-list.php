<div id="splitresult">
    <div class="table-responsive">                                             
        <table class="table user-list table-hover">
            <thead>
                <tr>
                    <th><span>Id</span></th>
                    <th><span>Vehicle Brand Name</span></th>
                    <th><span>Created</span></th>
                    <th class="text-center"><span>Status</span></th>															
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td>
                            <?= $category['category_id'] ?>
                        </td>
                        <td>
                            <?= $category['category_name'] ?>
                        </td>
                        <td>
                            <?php echo date('d, M Y h:i A', strtotime($category['created_date'])); ?> 

                        </td>
                        <td class="text-center">
                            <?php if ($category['is_active'] == 0) { ?>
                                <span class="label label-default" id="label-<?= $category['category_id'] ?>">Inactive</span>
                            <?php } else { ?>
                                <span class="label label-success" id="label-<?= $category['category_id'] ?>">Active</span>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" id="btn-<?= $category['category_id'] ?>">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    Change Status <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <?php if ($category['is_active'] == 0) { ?>
                                        <li style="border:0px; height:auto; padding:0px;"><a href="#" id="enable-<?= $category['category_id'] ?>" class="change-status" rel="<?= $category['category_id'] ?>">Enable</a></li>
                                    <?php } else { ?>
                                        <li style="border:0px; height:auto; padding:0px;"><a href="#" id="disable-<?= $category['category_id'] ?>" class="change-status" rel="<?= $category['category_id'] ?>">Disable</a></li>
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
                            <a href="<?php echo base_url('admin/category/form/' . $category['category_id']); ?>" class="table-link">
                                <span class="fa-stack">
                                    <i class="fa fa-square fa-stack-2x"></i>
                                    <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <a href="<?php echo base_url('admin/category/delete/' . $category['category_id']); ?>"  onclick="return areyousure();" class="table-link danger">
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