<?php include('header.php'); ?>
    <?php include('left.php'); ?>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js');?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.js');?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js/redactor.min.js');?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/js/file-browser.js');?>"></script> 
    <script type="text/javascript">
$(document).ready(function(){
	$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('.redactor').redactor({
		focus: true,
		plugins: ['fileBrowser']
	});
});
</script>
    <div id="content-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12">
              <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active"><span>Add New Travel User</span></li>
              </ol>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="main-box">
                <header class="main-box-header clearfix">
                  <h2><?php echo  $page_title; ?></h2>
                </header>
                <?php echo form_open($this->config->item('admin_folder').'/pages/form/'.$id); ?>
                <div id="main">
                  <div class="container-fluid">
                    <div class="row-fluid">
                      <div class="span12">
                        <div class="box-content">
                          <div class="tabbable">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#content_tab" data-toggle="tab"><?php echo lang('content');?></a></li>
                              <li><a href="#attributes_tab" data-toggle="tab"><?php echo lang('attributes');?></a></li>
                              <li><a href="#seo_tab" data-toggle="tab"><?php echo lang('seo');?></a></li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="content_tab">
                                <fieldset>
                                  <div class="row">
                                    <div class="form-group col-xs-3">
                                      <label for="title"><b><?php echo lang('title');?></b></label>
                                      <?php
				$data	= array('name'=>'title', 'value'=>set_value('title', $title), 'class'=>'span12 form-control');
				echo form_input($data);
				?>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group col-xs-3">
                                      <label for="content"><b><?php echo lang('content');?></b></label>
                                      <?php
				$data	= array('name'=>'content', 'class'=>'redactor form-control', 'value'=>set_value('content', $content));
				echo form_textarea($data);
				?>
                                    </div>
                                  </div>
                                </fieldset>
                              </div>
                              <div class="tab-pane" id="attributes_tab">
                                <fieldset>
                                  <div class="row">
                                    <div class="form-group col-xs-3">
                                      <label for="menu_title"><b><?php echo lang('menu_title');?></b></label>
                                      <?php
				$data	= array('name'=>'menu_title', 'value'=>set_value('menu_title', $menu_title), 'class'=>'span3 form-control');
				echo form_input($data);
				?>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group col-xs-3">
                                      <label for="slug"><b><?php echo lang('slug');?></b></label>
                                      <?php
				$data	= array('name'=>'slug', 'value'=>set_value('slug', $slug), 'class'=>'span3 form-control');
				echo form_input($data);
				?>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group col-xs-3">
                                      <label for="sequence"><b><?php echo lang('parent_id');?></b></label>
                                      <?php
				$options	= array();
				$options[0]	= lang('top_level');
				function page_loop($pages, $dash = '', $id=0)
				{
					$options	= array();
					foreach($pages as $page)
					{
						//this is to stop the whole tree of a particular link from showing up while editing it
						if($id != $page->id)
						{
							$options[$page->id]	= $dash.' '.$page->title;
							$options			= $options + page_loop($page->children, $dash.'-', $id);
						}
					}
					return $options;
				}
				$options	= $options + page_loop($pages, '', $id);
				echo form_dropdown('parent_id', $options,  set_value('parent_id', $parent_id));
				?>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group col-xs-3">
                                      <label for="sequence"><b><?php echo lang('sequence');?></b></label>
                                      <?php
				$data	= array('name'=>'sequence', 'value'=>set_value('sequence', $sequence), 'class'=>'span3 form-control');
				echo form_input($data);
				?>
                                    </div>
                                  </div>
                                </fieldset>
                              </div>
                              <div class="tab-pane" id="seo_tab">
                                <fieldset>
                                  <div class="row">
                                    <div class="form-group col-xs-3">
                                      <label for="code"><b><?php echo lang('seo_title');?></b></label>
                                      <?php
				$data	= array('name'=>'seo_title', 'value'=>set_value('seo_title', $seo_title), 'class'=>'span12 form-control');
				echo form_input($data);
				?>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="form-group col-xs-3">
                                      <label><b><?php echo lang('meta');?></b></label>
                                      <?php
				$data	= array('rows'=>'3', 'name'=>'meta', 'value'=>set_value('meta', html_entity_decode($meta)), 'class'=>'span12 form-control');
				echo form_textarea($data);
				?>
                                    </div>
                                  </div>
                                  <p class="help-block"><?php echo lang('meta_data_description');?></p>
                                </fieldset>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group" style="float:left;">
                              <div class="actions">
                                <button data-last="Finish" class="btn btn-success btn-mini btn-next" type="submit">Save<i class="icon-arrow-right"></i></button>
                                <button class="btn btn-default btn-mini btn-prev"  onClick="redirect();" type="button"> <i class="icon-arrow-left"></i>Cancel</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       
        <script>
var baseurl = "<?php print base_url(); ?>";
function redirect()
{
	window.location = baseurl +'admin/pages'
}
</script>
        <?php include('footer.php'); ?>