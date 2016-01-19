<?php

/**
 * The base controller which is used by the Front and the Admin controllers
 */
class Base_Controller extends CI_Controller {

    public function __construct() {

        parent::__construct();
		$language = $this->config->item('site_language');
		$language_prfix = $this->config->item('site_language_prefix');
		
		if($language!='' && $language_prfix !=''){
			
			$this->lang->load($language_prfix,$language);
		}
		else{
			$this->lang->load('en');
		}
    }
	
	

//end __construct()
}

//end Base_Controller

class Front_Controller extends Base_Controller {

    function __construct() {

        parent::__construct();


        $this->load->library('Carpooling');


        //load the theme package
        $this->load->add_package_path(APPPATH . 'themes/' . $this->config->item('theme') . '/');
	$this->load->model(array('logo_model'));
	$this->logo = $this->logo_model->get_logo(1);
    }

}

class Admin_Controller extends Base_Controller {

    var $trips = array();

    function __construct() {


        parent::__construct();

        $this->load->library('auth');
        $this->load->helper('form');
        $this->auth->is_logged_in(uri_string());

        //load the base language file
        $this->lang->load('admin_common');
        $this->load->model(array('trip_model','logo_model'));
        $this->trips = $this->trip_model->get_recent_trip(6);
	$this->logo = $this->logo_model->get_logo(1);
    }

}

class Traveller_Controller extends Base_Controller {

    function __construct() {

        parent::__construct();

        $this->load->library('auth_travel');
        $this->load->library('Carpooling');
        $this->load->add_package_path(APPPATH . 'themes/' . $this->config->item('theme') . '/');
        $this->auth_travel->is_logged_in(uri_string());

        //load the base language file
        $this->lang->load('provider_common');
	$this->load->model(array('logo_model'));
	$this->logo = $this->logo_model->get_logo(1);
    }

}
