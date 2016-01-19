<?php include('header.php'); ?>
<?php include('left.php'); ?>
<style>
    .icon {
    margin-top: 4px;
    float: left;
    }
    .txt-input {
        width: 93%;
        float: left;
        margin-right: 4px;
    }
    .form-control{ width:96%!important; float:left; margin-right:3px; }
</style>
<div id="content-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><span>Edit Settings</span></li>
                    </ol>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-12">
                    <div class="main-box">                       

                        <?php echo form_open($this->config->item('admin_folder') . '/admin/edit_settings'); ?>
                        <div class="main-box-body clearfix">
                            <header class="main-box-header clearfix">
                                <h2><b> Communication </b></h2>
                            </header>
                            <div class="row">                                
                                <div class="form-group col-xs-5 clearfix bacis">
                                    <label><b><?php echo 'Website Email'; ?></b></label>
                                    <?php echo form_input(array('class'=>'form-control', 'placeholder'=>'Website Email', 'name'=>'email', 'value'=>set_value('email',$email) ));?>
                                    <a href="javascript:void(0)" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Registration Email, and updates to the Script will be intimated to this Email ID" data-original-title="" title="">
                                            <i class="fa fa-question"></i>
                                    </a>
                                </div>                                   
                                <div class="col-xs-5 clearfix bacis clearfix bacis">
                                    <label><b><?php echo 'Site Admin Email' ?></b></label>                                    
                                    <?php echo form_input(array('class'=>'form-control txt-input', 'placeholder'=>'Site Admin Email', 'name'=>'admin_email', 'value'=>set_value('admin_email',$admin_email) ));?>
                                    
                                    <a href="javascript:void(0)" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Email ID provided by you during installation of this Script." data-original-title="" title="">
                                            <i class="fa fa-question"></i>
                                    </a>
                                   
                                </div>
                            </div>
                            
                            <header class="main-box-header clearfix">
                                <h2><b> Country information </b></h2>
                            </header>
                            <div class="row">                                                               
                                <div class="form-group col-xs-5 clearfix bacis">
                                    <label><b><?php echo 'Country'; ?></b></label>
                                    <?php				
                                    $data	= array(0 => 'Select Country');
                                    foreach($countries as $cat)
                                    {                                                    
                                        $data[$cat->country_code] = $cat->country_name;
                                    }
                                    echo form_dropdown('country', $data, $country,'class = "form-control"');
                                    ?>
                                    <a href="#" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Select the country in which you own your Car Pooling business." data-original-title="" title="">
                                            <i class="fa fa-question"></i>
                                    </a>

                                </div>
                                <div class="form-group col-xs-5 clearfix bacis">
                                    <label><b><?php echo 'Language'; ?></b></label>
                                    <?php				
                                    $data	= array(0 => 'Select Language');
                                    foreach($languages as $cat)
                                    {                                                    
                                        $data[$cat->language_code] = $cat->language_name;
                                    }
                                    echo form_dropdown('language', $data, $language,'class = "form-control"');
                                    ?>
                                    <a href="javascript:void(0)" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Select the language in which you want website content." data-original-title="" title="">
                                            <i class="fa fa-question"></i>
                                    </a>

                                </div>
                            </div>
                            
                            <header class="main-box-header clearfix">
                                <h2><b> OAuth Detail Information </b></h2>
                            </header>
                            <div class="row">
                                <div class="form-group col-xs-5 clearfix bacis">
                                    <label><b><?php echo 'Facebook App Id'; ?></b></label>
                                    <?php echo form_input(array('class'=>'form-control', 'placeholder'=>'Facebook App Id', 'name'=>'fb_appid', 'value'=>set_value('fb_appid',$fb_appid) ));?>
                                    
                                    <a href="javascript:void(0)" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="This is the ID you will receive when you register with Facebook to obtain a Facebook API for your site. " data-original-title="" title="">
                                            <i class="fa fa-question"></i>
                                    </a>
                                    
                                </div>

                                <div class="form-group col-xs-5 clearfix bacis">
                                    <label><b><?php echo 'Facebook App Secret Id'; ?></b></label>
                                    <?php echo form_input(array('class'=>'form-control', 'placeholder'=>'Facebook App Secret Id', 'name'=>'fb_appsecret', 'value'=>set_value('fb_appsecret',$fb_appsecret) ));?>
                                    
                                    <a href="javascript:void(0)" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="This is the Secret ID you will receive when you register with Facebook to obtain a Facebook API for your site. " data-original-title="" title="">
                                            <i class="fa fa-question"></i>
                                    </a>
                                    
                                </div>                                   
                                <div class="form-group col-xs-5 clearfix bacis">
                                    <label><b><?php echo 'Google App Id' ?></b></label>
                                    <?php echo form_input(array('class'=>'form-control', 'placeholder'=>'Google App Id', 'name'=>'googleplus_appid', 'value'=>set_value('googleplus_appid',$googleplus_appid) ));?>
                                    
                                    <a href="javascript:void(0)" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="This is the ID you will receive when you register with Google to obtain a Google API for your site." data-original-title="" title="">
                                            <i class="fa fa-question"></i></a>
                                    
                                    </div>                                   

                                <div class="form-group col-xs-5 clearfix bacis">
                                    <label><b><?php echo 'Google App Secret Id'; ?></b></label>
                                    <?php echo form_input(array('class'=>'form-control', 'placeholder'=>'Google App Secret Id', 'name'=>'googleplus_appsecret', 'value'=>set_value('googleplus_appsecret',$googleplus_appsecret) ));?>
                                    
                                     <a href="javascript:void(0)" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="This is the Secret ID you will receive when you register with Google to obtain a Google API for your site." data-original-title="" title="">
                                            <i class="fa fa-question"></i>
                                    </a>
                                    

                                </div>                                
                            </div>
                            
                            <header class="main-box-header clearfix">
                                <h2><b> Currency Information </b></h2>
                            </header>
                            <div class="row">
                                <div class="form-group col-xs-5 clearfix bacis">
                                    <label><b><?php echo 'Currency'; ?></b></label>
                                    <?php				
                                    $data	= array(0 => 'Select Currency');
                                    foreach($currencies as $cat)
                                    {                                                    
                                        $data[$cat->currency_id] = $cat->currency_name;
                                    }
                                    echo form_dropdown('currency', $data, $currency_id,'class = "form-control currency"');
                                    ?>
                                    <a href="javascript:void(0)" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Select your currency of business from the dropdown. " data-original-title="" title="">
                                            <i class="fa fa-question"></i>
                                    </a>
                                    
                                </div>

                                <div class="form-group col-xs-5 clearfix bacis">
                                    <label><b><?php echo 'Currency Symbol'; ?></b>                                        
                                    </label>
                                    <input type="text" id="symbol" value="<?=$currency_symbol?>" disabled="disabled" class = "form-control"/>
                                    
                                    <a href="javascript:void(0)" class="table-link icon" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Select the currency symbol you want to show on your website." data-original-title="" title="">
                                            <i class="fa fa-question"></i>
                                    </a>
                                    
                                    
                                </div>
                                <input type="hidden" name="currency_name" value="<?=$currency_name?>" id="currency_name"/>
                                <input type="hidden" name="currency_symbol" value="<?=$currency_symbol?>" id="currency_symbol"/>
                                                                
                            </div>
                            
                            <div class="row">
                                <div class="form-group">


                                    <div class="actions">

                                   <button data-last="Finish" class="btn btn-success btn-mini btn-next" type="submit">Save<i class="icon-arrow-right"></i></button>
                                        <button class="btn btn-default btn-mini btn-prev"  onClick="redirect();" type="button"> <i class="icon-arrow-left"></i>Cancel</button>

                                    </div>

                                    </form>




                                </div>
                            </div>



                        </div>
                    </div>



                </div>
            </div>	
        </div>

        <script type="text/javascript">
            var baseurl = "<?php print base_url(); ?>";
            $(document).ready(function() {
                   $('.bacis a').popover();
                   
                   $('body').on('change','.currency', function(){
                
                    var currencyID  = $(this).val();

                    $.ajax({
                        type: "POST",
                        url: baseurl+'admin/admin/get_currency',	 			
                        dataType: "json",
                        data: { currency_id : currencyID },                        
                        success: function(status){
                            
                            if(status.result == 1){
                                
                                $('#currency_name').val(status.name);
                                $('#currency_symbol').val(status.symbol);
                                $('#symbol').val(status.symbol)
                                
                            }
                            
                        }
                    });// ajax end

                });// end
            });
            if ($.browser.webkit) {
                $('input').attr('autocomplete', 'off');
            }
            $('form').submit(function () {
                $('.btn').attr('disabled', true).addClass('disabled');
            });
        </script>
        <script>
            
            function redirect()
            {
                window.location = baseurl + 'admin/dashboard'
            }
        </script>
        <?php
        include('footer.php');
        