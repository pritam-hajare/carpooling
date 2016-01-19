<?php

class Settings extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
		remove_ssl();

		
		$this->load->model('Settings_model');
		$this->load->model('Messages_model');
		$this->lang->load('settings');
	}
	
	
	
	function index()
	{
		
		$this->load->library('Pagination_admin');
		$data['page_title']	= ('Category');
		$config['is_ajax_paging']   = true;
		$config['paging_function'] 	= 'canned_message_ajax';
		$config['base_url'] 		=  site_url('admin/settings');
		$data['count_result'] 		= $this->Messages_model->count_messages(); 
		$config['total_rows'] 		= $data['count_result'] ;
		$config['per_page'] 		= '5';
		$config['uri_segment']     	= 4;
	
		$this->pagination_admin->initialize($config);
		
		$data['pagination'] = $this->pagination_admin->create_links();
		$data['canned_messages']	= $this->Messages_model->get_list($this->pagination_admin->per_page,$this->uri->segment(4));
		
		$this->load->view($this->config->item('admin_folder').'/email-template', $data);
	}
	
	function canned_message_ajax()
	{
		$this->load->library('Pagination_admin');
		$config['is_ajax_paging']   = true;
		$config['paging_function'] 	= 'canned_message_ajax';
		$config['base_url'] 		=  site_url('admin/settings');
		$data['count_result'] 		= $this->Messages_model->count_messages(); 
		$config['total_rows'] 		= $data['count_result'] ;
		$config['per_page'] 		= '5';
		$config['uri_segment']     	= 4;
	
		$this->pagination_admin->initialize($config);
		
		$data['pagination'] = $this->pagination_admin->create_links();
		$data['canned_messages']	= $this->Messages_model->get_list($this->pagination_admin->per_page,$this->uri->segment(4));
		
		$this->load->view($this->config->item('admin_folder').'/email-template-list', $data);
		
	}
	
	function canned_message_form($id=false)
	{
		$data['page_title'] = lang('canned_message_form');

		$data['id']			= $id;
		$data['email_name']		= '';
		$data['subject']	= '';
		$data['content']	= '';
		
		
		if($id)
		{
			$message = $this->Messages_model->get_message($id);
						
			$data['email_name']		= $message['tplshortname'];
			$data['subject']	= $message['tplsubject'];
			$data['content']	= $message['tplmessage'];
			
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email_name', 'Email name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('subject', 'Email subject', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('content', 'Email message content', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['errors'] = validation_errors();
			
			$this->load->view($this->config->item('admin_folder').'/email_template_form', $data);
		}
		else
		{
			
			$save['tplid']			= $id;
			$save['tplshortname']		= $this->input->post('email_name');
			$save['tplsubject']	= $this->input->post('subject');
			$save['tplmessage']	= $this->input->post('content');
		
			$this->Messages_model->save_message($save);
			
			$this->session->set_flashdata('message', lang('message_saved_message'));
			redirect($this->config->item('admin_folder').'/settings');
		}
	}
	
	function delete_message($id)
	{
		$this->Messages_model->delete_message($id);
		
		$this->session->set_flashdata('message', lang('message_deleted_message'));
		redirect($this->config->item('admin_folder').'/settings');
	}
}