<?php

class Dashboard extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		remove_ssl();
		
		$this->load->model('Customer_model');
		$this->load->model(array('Customer_model','Travel_model','Trip_model','Vehicles_model','subscribe_model','enquiry_model','testimonial_model','category_model'));
		$this->load->helper('date');
		
		$this->lang->load('dashboard');
	}
	
	function index()
	{
		
		$data['page_title']	=  lang('dashboard');
		$data['total_users'] = $this->Travel_model->count_travellers();
		$data['total_trips'] = $this->Trip_model->count_trips(); 
		$data['total_subscribers'] = $this->subscribe_model->count_subscribes(); 
		$data['total_vehicles'] = $this->Vehicles_model->count_vehicles(); 
		$data['total_enquiry'] = $this->enquiry_model->count_enquiry();
		$data['total_testimonials'] = $this->testimonial_model->count_testimonials();  
		$data['total_categories'] = $this->category_model->count_categories(); 
		$data['visiter_data'] = $this->Travel_model->get_daily_visiter_data();
		
		$this->load->view($this->config->item('admin_folder').'/dashboard', $data);
	}

}