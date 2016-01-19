<?php include('header.php'); ?>
<?php include('left.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete');?>');
}
</script>
<script src="<?php echo base_url('assets/js/plugins/datatable/jquery.dataTables.min.js'); ?>"></script>
<div id="content-wrapper">
    <div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active"><span>User Management</span></li>
        </ol>
        <div class="clearfix">
           <h1 class="pull-left">Admin Users</h1>
            <div class="pull-right top-page-ui">
                <a href="<?php echo site_url($this->config->item('admin_folder').'/admin/form'); ?>" class="btn btn-primary pull-right">
                <i class="fa fa-plus-circle fa-lg"></i>Add Users
                </a>
            </div>
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
                                            <th><?php echo ('Admin Name');?></th>
                                            <th><?php echo lang('email');?></th>			
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php foreach ($admins as $admin):?>
                                            <tr>
                                                <td><?php echo $admin->admin_name; ?></td>
                                                <td><a href="mailto:<?php echo $admin->admin_email;?>"><?php echo $admin->admin_email; ?></a></td>
                                                <td style="width: 20%;" class="bacis">																
                                                <a href="<?php echo site_url($this->config->item('admin_folder').'/admin/form/'.$admin->id);?>" class="table-link">
                                                <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                                </span>
                                                </a>
                                                <a href="<?php echo site_url($this->config->item('admin_folder').'/admin/delete/'.$admin->id); ?>"  onclick="return areyousure();" class="table-link danger">
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
                        </div> 
                 	</div>
                 </div>
             </div>
         </div> 
    </div>
    <script>
	 $(document).ready(function() {
                   $('.bacis a').popover();
            });
	</script>

<?php include('footer.php'); ?>
