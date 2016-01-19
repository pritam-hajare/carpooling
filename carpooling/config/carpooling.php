<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['theme']			= 'carpooling';

// SSL support
$config['ssl_support']		= false;

// Business information
$config['company_name']		= 'GreenTech';
$config['address1']			= 'Hinjawadi';
$config['address2']			= 'pimpri-chinchwad';
$config['country']			= 'IND'; // use proper country codes only
$config['city']				= 'Pune'; 
$config['state']			= 'Maharashtra';
$config['zip']				= '411027';
$config['email']			= 'car@gmail.com';
$config['admin_email']		= 'car@gmail.com';


//facebook and google app id
$config['fb_appid']				= '1452830428353334';
$config['fb_appsecret']			= '0cc15b553727f6707335acb58d9e1f66';
$config['googleplus_appid']		= '';
$config['googleplus_appsecret']	= '';

$config['country_code']   = ''; 

$config['site_language_prefix']			= '';
$config['site_language']				= '';


// Store currency
$config['currency']						= 'INR';  // USD, EUR, etc
$config['currency_symbol']				= 'Rs';
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
$config['vehicles_upload_dir']='uploads/vehicle/';                           
$config['profile_upload_dir']='uploads/profile/';
$config['admin_upload_dir']='uploads/admin/';
$config['testimonials_upload_dir']='uploads/testimonials/';
$config['max_width']='1907';
$config['max_height']='1280';
$config['max_kb']='5000';
$config['acceptable_files']='gif|jpg|png|jpeg|bmp||PNG|JPG|JPEG|GIF|BMP';