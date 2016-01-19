<?php

class Trip extends Admin_Controller {

	//this is used when editing or adding a provider
	var $passenger_id	= false;	

	function __construct()
	{		
		parent::__construct();

		$this->load->model(array('Trip_model'));
		$this->load->helper('formatting_helper');
		$this->lang->load('provider');
	}
	
	function index()
	{
				
		$data['page_title']	= ('Trip');
		
		$this->load->library('Pagination_admin');
		
		$config['is_ajax_paging']   = true;
		$config['paging_function'] 	= 'trip_ajax';
		$config['base_url'] 		=  site_url('admin/trip');
		$data['count_result'] 		= $this->Trip_model->count_trips(); 
		$config['total_rows'] 		= $data['count_result'] ;
		$config['per_page'] 		= '10';
		$config['uri_segment']     	= 4;
		
		$this->pagination_admin->initialize($config);
		$data['pagination'] = $this->pagination_admin->create_links();
		$data	= $this->Trip_model->get_alltrips($this->pagination_admin->per_page,$this->uri->segment(4),$order_by='trip_id', $direction='ASC',$data);
		$this->load->helper('form');
		
		$this->load->view($this->config->item('admin_folder').'/trip', $data);
	}
	
	function trip_ajax()
	{
		
		$this->load->library('Pagination_admin');
		
		$config['is_ajax_paging']   = true;
		$config['paging_function'] 	= 'trip_ajax';
		$config['base_url'] 		=  site_url('admin/trip');
		$data['count_result'] 		= $this->Trip_model->count_trips(); 
		$config['total_rows'] 		= $data['count_result'] ;
		$config['per_page'] 		= '10';
		$config['uri_segment']     	= 4;
		$this->pagination_admin->initialize($config);
		
		$data['pagination'] = $this->pagination_admin->create_links();
		$data	= $this->Trip_model->get_alltrips($this->pagination_admin->per_page,$this->uri->segment(4),$order_by='trip_id', $direction='ASC',$data);
		$this->load->helper('form');
		
		$this->load->view($this->config->item('admin_folder').'/trip-list', $data);
		
	}
	function edit_confirm()
    {
    	$this->auth->is_logged_in();
		$user_details = $this->Trip_model->get_user($this->input->post('id'));
		$user = $this->Travel_model->get_traveller($user_details->trip_user_id);
    	$event['trip_id']		= $this->input->post('id');
    	$event['trip_status']	= $this->input->post('confirmed');
    	/*print_r($event);
		die;*/
    	$this->Trip_model->save($event);
		
		//if($event['trip_status'] == 1)
//		{
//		/*	echo 'active';
//			die;*/
//			$email = $user->user_email;
//			if($user->communication_email == 1)
//			{
//				$email = $user->user_secondary_mail;
//			}
//			///*			// send an email */
//////			// get the email template
//				$res = $this->db->where('tplid', '16')->get('tbl_email_template');
//				$row = $res->row_array();
//				
//				// set replacement values for subject & body
//				
//				// {customer_name}
//				$row['tplmessage'] = str_replace('{NAME}', $user->user_first_name.'.'.$user->user_last_name, $row['tplmessage']);
//				$row['tplsubject'] = str_replace('{EMAIL}', $email, $row['tplsubject']);				
//				
//			
//				
//						
//				$config = Array(
//						  'protocol' => 'smtp',
//						  'smtp_host' => 'ssl://smtp.googlemail.com.',
//						  'smtp_port' => 465,
//						  'smtp_user' => $this->config->item('email'), // change it to yours
//						  'smtp_pass' => $this->config->item('password'), // change it to yours
//						  'mailtype'  => 'html', 
//						  'charset'   => 'iso-8859-1'
//						  );
//				$this->load->library('email',$config);
//				$this->email->set_newline("\r\n");
//				$this->email->from($this->config->item('email'), $this->config->item('company_name'));
//				$this->email->to($email);
//				$this->email->subject(html_entity_decode($row['tplsubject']));
//				$this->email->message(html_entity_decode($row['tplmessage']));
//				
//				$this->email->send();
//		
//		}else
//		{
//			/*echo 'deactive';
//			die;*/
//			$email = $user->user_email;
//			if($user->communication_email == 1)
//			{
//				$email = $user->user_secondary_mail;
//			}
//			///*			// send an email */
//////			// get the email template
//				$res = $this->db->where('tplid', '15')->get('tbl_email_template');
//				$row = $res->row_array();
//				
//				// set replacement values for subject & body
//				
//				// {customer_name}
//				$row['tplmessage'] = str_replace('{NAME}',  $user->user_first_name.'.'.$user->user_last_name, $row['tplmessage']);
//				$row['tplsubject'] = str_replace('{EMAIL}', $email, $row['tplsubject']);
//				
//				$config = Array(
//						  'protocol' => 'smtp',
//						  'smtp_host' => 'ssl://smtp.googlemail.com.',
//						  'smtp_port' => 465,
//						  'smtp_user' => $this->config->item('email'), // change it to yours
//						  'smtp_pass' => $this->config->item('password'), // change it to yours
//						  'mailtype'  => 'html', 
//						  'charset'   => 'iso-8859-1'
//						  );
//				$this->load->library('email',$config);
//				$this->email->set_newline("\r\n");
//				$this->email->from($this->config->item('email'), $this->config->item('company_name'));
//				$this->email->to($email);
//				$this->email->subject(html_entity_decode($row['tplsubject']));
//				$this->email->message(html_entity_decode($row['tplmessage']));
//				
//				$this->email->send();
//			
//		}
    	
    	echo url_title($event['trip_status']);
    }
	
	function change_status()
    {
     $this->auth->is_logged_in();
  
     $trip_id = $this->input->post('mid');
     $status = $this->input->post('status');
  
  if( !empty($trip_id) && !empty($status)){
   
   $trip = (array)$this->Trip_model->get_tripc($trip_id);
   
   if(!$trip){
    echo false;
   }
   
   if($status == 'enable')
   {
    $trip['trip_status'] = '1';
   }
   elseif($status == 'disable'){
    $trip['trip_status'] = '0';
   }   
   $id = $this->Trip_model->save($trip);
   echo $id;
   }else{
  
     echo false;
    }
	}
	
	
	
}