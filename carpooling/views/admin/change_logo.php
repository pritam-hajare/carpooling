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
                        <li class="active"><span>Change logo</span></li>
                    </ol>


                </div>
            </div>
            <div class="row">

                <div class="col-lg-12">
                    <div class="main-box">
                        <header class="main-box-header clearfix">
                            <h2> <?php if (!empty($page_title)): ?>

                                    <?php echo "Change logo"; ?>
                                <?php endif; ?></h2>
                        </header>
                        <?php echo form_open($this->config->item('admin_folder') . '/admin/change_logo/'); ?>
                        <div class="main-box-body clearfix">
                            
                            <div class="logo">
                               <h1>Upload your logo image file here</h1>
                               <p>Ensure that your image size is exactly 225px in width, and 53px in height.</p>
                               </div>
                              
                                    <div class="form-group col-xs-12">
                                        <label><b>Logo Image</b></label>
                                        <div id='preview' class="img-preview">
                                            <?php
                                            if (!empty($vehicletypeid)) {
                                                if (!empty($uploadvalues)) {
                                                    ?>
                                                    <div id="gallery-photos-wrapper" class="vehiclesimage">
                                                        <ul id="gallery-photos" class="clearfix gallery-photos gallery-photos-hover ui-sortable">
                                                            <li id="recordsArray_1" class="col-md-2 col-sm-3 col-xs-6" style="width:45%">								
                                                                <div class="photo-box" style="background-image: url('<?= theme_vehicles_img($uploadvalues) ?>');"></div>
                                                                <a href="javascript:void(0);" class="remove-photo-link" id="vehicles-img-remove">
                                                                    <span class="fa-stack fa-lg">
                                                                        <i class="fa fa-circle fa-stack-2x"></i>
                                                                        <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        </ul>                                                
                                                        <img src="'<?= theme_vehicles_img($uploadvalues) ?>" style="display:none;">
                                                        <input type="hidden" name="uploadvalues" value="<?= $uploadvalues ?>" />
                                                    </div>


                                                <?php }
                                            }
                                            ?>
                                        </div>
                                        <div id='imageloadstatus' style="display:none">
                                            <img src='<?php echo theme_img('loader.gif'); ?>'/> Uploading please wait ....
                                        </div>


                                        <div id="uploadlink" <?= !empty($uploadvalues) ? 'style="display: none"' : '' ?>>

                                            <a href="javascript:void(0);" class="btn btn-link" id="camera2" title="Upload Image">
                                                upload image
                                            </a>
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

                        </div>
                    </div>	
                </div>
                </form>
                <div class="row">
                    <div id='imageloadbutton' style="display:none">
                        <?php
                        $attributes = array('id' => 'logoimgform');
                        echo form_open_multipart(base_url('admin/admin/logo_image_upload'), $attributes);
                        ?>

                        <input type="file" name="logoimg" id="logoimg"/>
                        <input type='hidden'  name="imageType" />
                        </form>  



                    </div>
                </div>
                </div>


<?php include('footer.php'); ?>