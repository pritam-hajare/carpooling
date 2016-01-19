<?php
class Enquiry extends Traveller_Controller 
{
	var $CI;
	var $user_id;
	function __construct()
	{
		parent::__construct();
		remove_ssl();
		$this->CI =& get_instance();		
		
		$this->load->model('Enquiry_model');
		$this->load->model('vechicle_model');
		$this->load->model('travel_model');
		$this->load->helper('date');		
			
	}
	
	function index($order_by="projtitle", $sort_order="ASC", $code=0, $page=0, $rows=5)
	{
				
		$carpool_session['carpool_session']		= $this->CI->carpool_session->userdata('carpool');
		$this->user_id	= $carpool_session['carpool_session']['user_id'];
		
		$data['seo_title']	= '';
		$data['seo_description']='';
		$data['seo_keyword']='';
		$this->load->helper('form');
		$term				= false;
	
		$data['enquiries']=$this->Enquiry_model->get_enquires_list($this->user_id);	
		$this->load->view($this->config->item('travel_folder').'/enquiries', $data);
	}
	
	
	
}