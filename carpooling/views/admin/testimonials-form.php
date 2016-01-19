<?php include('header.php'); ?>
<?php include('left.php'); ?>
<?php echo theme_js('jquery.wallform.js', true); ?>
<?php echo admin_js('admin.js', true); ?>

<div id="content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><span>Add New Testimonials</span></li>
                    </ol>


                </div>
            </div>


            <div class="row">

                <div class="col-lg-12">
                    <div class="main-box">
                        <header class="main-box-header clearfix">
                            <h2>Add Testimonials</h2>
                        </header>
                        <?php echo form_open($this->config->item('admin_folder') . '/testimonials/form/' . $id, ' id="req-form"'); ?>
                        <div class="main-box-body clearfix">


                            <div class="row">
                                <div class="form-group col-xs-3">
                                    <label><b>Testimonials Name</b></label>
<?php
$data = array('name' => 'name', 'value' => set_value('name', $test_name), 'class' => 'form-control');
echo form_input($data);
?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <label><b>Testimonials Description</b></label>
<?php
$data = array('name' => 'description', 'value' => set_value('description', $description), 'class' => 'form-control', 'rows' => '3');
echo form_textarea($data);
?>
                                </div>
                            </div>

                            <div class="row">										
                                <div class="form-group col-xs-5">
                                    <label><b>Testimonials Image</b></label>
                                    <div id='preview' class="img-preview">
                                        <?php if (!empty($id)) {
                                            if (!empty($uploadvalues)) {
                                                ?>
                                                <div id="gallery-photos-wrapper" class="testimonialsimage">
                                                    <ul id="gallery-photos" class="clearfix gallery-photos gallery-photos-hover ui-sortable">
                                                        <li id="recordsArray_1" class="col-md-2 col-sm-3 col-xs-6" style="width:45%">								
                                                            <div class="photo-box" style="background-image: url('<?= theme_testimonials_img($uploadvalues) ?>');"></div>
                                                            <a href="javascript:void(0);" class="remove-photo-link" id="testimonials-img-remove">
                                                                <span class="fa-stack fa-lg">
                                                                    <i class="fa fa-circle fa-stack-2x"></i>
                                                                    <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>                                                
                                                    <img src="'<?= theme_testimonials_img($uploadvalues) ?>" style="display:none;">
                                                    <input type="hidden" name="uploadvalues" value="<?= $uploadvalues ?>" />
                                                </div>
                                                

                                            <?php }
                                        } ?>
                                    </div>
                                    <div id='imageloadstatus' style="display:none">
                                        <img src='<?php echo theme_img('loader.gif'); ?>'/> Uploading please wait ....
                                    </div>                                    
                                    <div id="uploadlink" <?= !empty($uploadvalues) ? 'style="display: none"' : '' ?>>
                                        <a href="javascript:void(0);" class="btn btn-link" id="camera" title="Upload Image">
                                            upload image
                                        </a>
                                    </div>
                                        
                                </div>
                            </div>  

                            <div class="row">
                                <div class="form-group col-xs-5">
                                    <label><b>Testimonials Status</b></label>
                                    <div class="checkbox-nice">
                                        <?php
                                        $data = array('name' => 'isactive', 'value' => 1, 'id' => 'checkbox-1', 'checked' => $isactive);
                                        echo form_checkbox($data)
                                        ?>

                                        <label for="checkbox-1">
                                            <?= lang('active'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">


                                    <div class="actions">
                                      <button data-last="Finish" class="btn btn-success btn-mini btn-next" type="submit">Save<i class="icon-arrow-right"></i></button>
                                        <button class="btn btn-default btn-mini btn-prev"  onClick="redirect();" type="button"> <i class="icon-arrow-left"></i>Cancel</button>

                                    </div>
                                </div>



                            </div>
                            <br/><br/>
                        </div>

                        </form>
                        <div class="row">
                            <div id='imageloadbutton' style="display:none">
                                <?php
                                $attributes = array('id' => 'testimonialsimageform');
                                echo form_open_multipart(base_url('admin/testimonials/testimonials_image_upload'), $attributes);
                                ?>

                                <input type="file" name="testimonialsimg" id="testimonialsimg"/>
                                <input type='hidden'  name="imageType" />
                                </form>  
                            </div>
                        </div>  
                    </div>
                </div>	
            </div>




        </div>
    </div>


    <script type="text/javascript" src="<?php echo admin_js('jquery.validate.js'); ?>"></script>
<?php echo admin_js('jquery.validate-rules.js', true); ?>


    <script src="<?php echo admin_js('jquery.maskedinput.min.js'); ?>"></script>
    <script src="<?php echo admin_js('bootstrap-datepicker.js'); ?>"></script>

    <script>
                                            var baseurl = "<?php print base_url(); ?>";
                                            function redirect()
                                            {
                                                window.location = baseurl + 'admin/testimonials'
                                            }
    </script> 

<?php include('footer.php'); ?>
