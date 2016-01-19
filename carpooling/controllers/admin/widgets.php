<?php

class Widgets extends Admin_Controller {

	var $passenger_id	= false;	

	function __construct()
	{		
		parent::__construct();

		$this->load->model(array('Widget_model'));
		$this->load->helper('formatting_helper');
		$this->lang->load('provider');
	}
	
	function index()
	{
		$this->load->helper('form');
		$data['widgets']	= $this->Widget_model->get_allwidgets();
		$this->load->view($this->config->item('admin_folder').'/widgets', $data);
	}
	
	
	function widget_form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['page_title']		= 'Widget Form';
				
		if ($id)
		{	
			$this->id	= $id;	
		
			$widget		= $this->Widget_model->get_widget($id);
			
			
			//if the provider does not exist, redirect them to the provider list with an error
			if (!$widget)
			{
				$this->session->set_flashdata('error', lang('error_not_found'));
				redirect($this->config->item('admin_folder').'/widgets');
			}
			
			//set values to db values
			$data['id']					= $widget->id;
			$data['widget_name']		= $widget->widget_name;
			$data['widget_link']		= $widget->widget_link;
			$data['widget_script']		= $widget->widget_script;
			$data['widget_flag']		= $widget->widget_flag;
		
			$this->form_validation->set_rules('widget_name', 'Widget Name', 'trim|required|');
			$this->form_validation->set_rules('widget_link', 'Widget Link', 'trim|required|');
			$this->form_validation->set_rules('widget_script', 'Widget Script', 'trim|required|');	
			
				
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view($this->config->item('admin_folder').'/widget-form', $data);
			}
			else
			{
				$save['id']		        = $id;
				$save['widget_name']	= $this->input->post('widget_name');
				$save['widget_link']	= $this->input->post('widget_link');
				$save['widget_script']	= $this->input->post('widget_script');
				$save['widget_flag']	= $this->input->post('widget_flag');
							
				$profile_id	= $this->Widget_model->save($save);			
				$this->session->set_flashdata('message', 'The Widget has been saved');			
				redirect($this->config->item('admin_folder').'/widgets');		
			}
			}
		else{
			$this->session->set_flashdata('error', 'You have not permitted to Submit new widget');	
			redirect($this->config->item('admin_folder').'/widgets');
		}
		
	}
	
	function change_status()
    {
     $this->auth->is_logged_in();  
     $widget_id = $this->input->post('mid');
     $status = $this->input->post('status');
  
  if( !empty($widget_id) && !empty($status)){
   
   $widget = (array)$this->Widget_model->get_widget($widget_id);
   
   if(!$widget){
    echo false;
   }
   
   if($status == 'enable')
   {
    $widget['widget_flag'] = '1';
   }
   elseif($status == 'disable'){
    $widget['widget_flag'] = '0';
   }   
   $id = $this->Widget_model->save($widget);
   echo $id;
   }else{
  
     echo false;
    }
	}
	
	
}