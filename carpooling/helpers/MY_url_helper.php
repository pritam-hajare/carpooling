<?php

function ssl_support()
{
	$CI =& get_instance();
    return $CI->config->item('ssl_support');
}

if ( ! function_exists('force_ssl'))
{
	function force_ssl()
	{
		if (ssl_support() &&  (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off'))
		{
			$CI =& get_instance();
			$CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
			redirect($CI->uri->uri_string());
		}
	}
}

//thanks C4iO [PyroDEV]
if ( ! function_exists('remove_ssl'))
{
	function remove_ssl()
	{	
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
		{
			$CI =& get_instance();
			$CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
			
			redirect($CI->uri->uri_string());
		}
	}
}

function theme_url($uri)
{
	$CI =& get_instance();
	return $CI->config->base_url('carpooling/themes/'.$CI->config->item('theme').'/'.$uri);
}

//to generate an image tag, set tag to true. you can also put a string in tag to generate the alt tag
function theme_img($uri, $tag=false)
{
	if($tag)
	{
		return '<img src="'.theme_url('assets/img/'.$uri).'" alt="'.$tag.'">';
	}
	else
	{
		return theme_url('assets/img/'.$uri);
	}
	
}

function theme_js($uri, $tag=false)
{
	if($tag)
	{
		return '<script type="text/javascript" src="'.theme_url('assets/js/'.$uri).'"></script>';
	}
	else
	{
		return theme_url('assets/js/'.$uri);
	}
}

//you can fill the tag field in to spit out a link tag, setting tag to a string will fill in the media attribute
function theme_css($uri, $tag=false)
{
	if($tag)
	{
		$media=false;
		if(is_string($tag))
		{
			$media = 'media="'.$tag.'"';
		}
		return '<link href="'.theme_url('assets/css/'.$uri).'" type="text/css" rel="stylesheet" '.$media.'/>';
	}
	
	return theme_url('assets/css/'.$uri);
}

//profile image tag
function theme_profile_img($uri)
{
	
		$CI =& get_instance();
		return $CI->config->base_url('uploads/profile/source/'.$uri);
	
}

//image tag
function theme_vehicles_img($uri)
{
	
		$CI =& get_instance();
		return $CI->config->base_url('uploads/vehicle/thumbnails/'.$uri);
	
}


function theme_logo_img($uri)
{
	
		$CI =& get_instance();
		return $CI->config->base_url('uploads/logo/thumbnails/'.$uri);
	
}

//admin profile image tag
function admin_profile_img($uri)
{
	
		$CI =& get_instance();
		return $CI->config->base_url('uploads/admin/source/'.$uri);
	
}

//testimonials image
function theme_testimonials_img($uri,$size='small')
{
	
		$CI =& get_instance();
		return $CI->config->base_url('uploads/testimonials/'.$size.'/'.$uri);
	
}

function admin_js($uri, $tag=false)
{
	$CI =& get_instance();
	if($tag)
	{
		return '<script type="text/javascript" src="'.$CI->config->base_url('assets/js/'.$uri).'"></script>';
	}
	else
	{
		return $CI->config->base_url('assets/js/'.$uri);
	}
}

function admin_img($uri, $tag=false)
{
	$CI =& get_instance();
	if($tag)
	{
		return '<img src="'.$CI->config->base_url('assets/images/'.$uri).'" alt="'.$tag.'">';
	}
	else
	{
		return $CI->config->base_url('assets/images/'.$uri);
	}
	
}

function admin_css($uri, $tag=false)
{
	$CI =& get_instance();
	if($tag)
	{
		$media=false;
		if(is_string($tag))
		{
			$media = 'media="'.$tag.'"';
		}
		return '<link href="'.$CI->config->base_url('assets/css/'.$uri).'" type="text/css" rel="stylesheet" '.$media.'/>';
	}
	
	return $CI->config->base_url('assets/css/'.$uri);
}



if ( ! function_exists('get_random_password'))
{
    /**
     * Generate a random password. 
     * 
     * get_random_password() will return a random password with length 6-8 of lowercase letters only.
     *
     * @access    public
     * @param    $chars_min the minimum length of password (optional, default 6)
     * @param    $chars_max the maximum length of password (optional, default 8)
     * @param    $use_upper_case boolean use upper case for letters, means stronger password (optional, default false)
     * @param    $include_numbers boolean include numbers, means stronger password (optional, default false)
     * @param    $include_special_chars include special characters, means stronger password (optional, default false)
     *
     * @return    string containing a random password 
     */    
    function get_random_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=false, $include_special_chars=false)
    {
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@04f7c318ad0360bd7b04c980f950833f11c0b1d1quot;#$%&[]{}?|";
        }
                                
        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
            $password .=  $current_letter;
        }                
        
        return $password;
    }

}