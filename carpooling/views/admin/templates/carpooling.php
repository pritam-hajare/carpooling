<?php echo '<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');';?>


$config['theme']			= 'carpooling';

// SSL support
$config['ssl_support']		= 'false';

// Business information
$config['company_name']		= '<?php echo $company_name;?>';
$config['address1']			= '<?php echo $address1;?>';
$config['address2']			= '<?php echo $address2;?>';
$config['country']			= '<?php echo $country;?>'; // use proper country codes only
$config['city']				= '<?php echo $city;?>'; 
$config['state']			= '<?php echo $state;?>';
$config['zip']				= '<?php echo $zip;?>';
$config['email']			= '<?php echo $email;?>';
$config['admin_email']                  = '<?php echo $admin_email;?>';


//facebook and google app id
$config['fb_appid']				= '<?php echo $fb_appid;?>';
$config['fb_appsecret']			= '<?php echo $fb_appsecret;?>';
$config['googleplus_appid']		= '<?php echo $googleplus_appid;?>';
$config['googleplus_appsecret']	= '<?php echo $googleplus_appsecret;?>';

$config['country_code']			= '<?php echo $country_code;?>'; // use proper country codes only

$config['site_language_prefix']			= '<?php echo $site_language_prefix;?>';
$config['site_language']				= '<?php echo $site_language;?>';



// Store currency
$config['currency']						= '<?php echo $currency;?>';  // USD, EUR, etc
$config['currency_symbol']				= '<?php echo $currency_symbol;?>';
$config['currency_symbol_side']			= 'left'; // anything that is not "left" is automatically right
$config['currency_decimal']				= '.';
$config['currency_thousands_separator']	= ',';

// site logo path (for packing slip)
$config['site_logo']		= '/assets/img/logo.png';

//change the name of the admin controller folder 
$config['admin_folder']		= 'admin';

//file upload size limit
$config['size_limit']		= intval(ini_get('upload_max_filesize'))*1024;

//are new registrations automatically approved (true/false)
$config['new_customer_status']	= true;

//are new registrations automatically approved (true/false)
$config['new_provider_status']	= false;

//do we require customers to log in 
$config['require_login']		= false;

//file upload path
$config['vechicle_upload_dir']='uploads/vechicle/';
$config['profile_upload_dir']='uploads/profile/';
$config['admin_upload_dir']='uploads/admin/';
$config['testimonials_upload_dir']='uploads/testimonials/';
$config['max_width']='1907';
$config['max_height']='1280';
$config['max_kb']='5000';
$config['acceptable_files']='gif|jpg|png|jpeg|bmp||PNG|JPG|JPEG|GIF|BMP';