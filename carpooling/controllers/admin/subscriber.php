<?php

class Subscriber extends Admin_Controller {

	//this is used when editing or adding a provider
	var $category_id	= false;	

	function __construct()
	{		
		parent::__construct();

		$this->load->model(array('subscribe_model'));
		$this->load->helper('formatting_helper');
		$this->lang->load('provider');
	}
	
	function index()
	{
		
		
		$this->load->library('Pagination_admin');
		$data['page_title']	= ('Subscriber');
		$config['is_ajax_paging']   = true;
		$config['paging_function'] 	= 'subscriber_ajax';
		$config['base_url'] 		=  site_url('admin/subscriber');
		$data['count_result'] 		= $this->subscribe_model->count_subscribes(); 
		$config['total_rows'] 		= $data['count_result'] ;
		$config['per_page'] 		= '10';
		$config['uri_segment']     	= 4;
	
		$this->pagination_admin->initialize($config);
		
		$data['pagination'] = $this->pagination_admin->create_links();
		$data['subscribers']	= $this->subscribe_model->all_subscribes($this->pagination_admin->per_page,$this->uri->segment(4));
		
		$this->load->view($this->config->item('admin_folder').'/subscriber', $data);
	}
	
	function subscriber_ajax()
	{
		$this->load->library('Pagination_admin');
		$config['is_ajax_paging']   = true;
		$config['paging_function'] 	= 'subscriber_ajax';
		$config['base_url'] 		=  site_url('admin/subscriber');
		$data['count_result'] 		= $this->subscribe_model->count_subscribes(); 
		$config['total_rows'] 		= $data['count_result'] ;
		$config['per_page'] 		= '10';
		$config['uri_segment']     	= 4;
	
		$this->pagination_admin->initialize($config);
		
		$data['pagination'] = $this->pagination_admin->create_links();
		$data['subscribers']	= $this->subscribe_model->all_subscribes($this->pagination_admin->per_page,$this->uri->segment(4));
		
		$this->load->view($this->config->item('admin_folder').'/subscriber-list', $data);
		
	}
	
	function delete($id)
	{
		
			$subscriber	= $this->subscribe_model->get_subscriber($id);
			//if the department does not exist, redirect them to the customer list with an error
			if ($subscriber)
			{
				$this->subscribe_model->delete($id);
				
				$this->session->set_flashdata('message', ('The subscriber has been deleted!'));
				redirect($this->config->item('admin_folder').'/subscriber');
			}
			else
			{
				$this->session->set_flashdata('error', lang('error_not_found'));
			}
		
	}
	
	
}