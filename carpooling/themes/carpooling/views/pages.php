<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Front_Controller {
	
	var $CI;
	var $user_id;
  function __construct()
  {
    parent::__construct();
	
	
  
		 $this->load->model('subscribes_model');
		 $this->load->model('Page_model');
		 $this->load->helper('url');
		  $this->load->helper('file');
	 
	
  }

  function index()
  {
redirect('home', 'refresh');
	}
	
	
function page($id = false)
 {
  //if there is no page id provided redirect to the homepage.
  $data['page'] = $this->Page_model->get_page($id);
  if(!$data['page'])
  {
   show_404();
  }
  
  /*$data['banners']   = $this->Banner_model->get_homepage_banners(5);
  $data['boxes']    = $this->box_model->get_homepage_boxes(4);*/
  $data['base_url']   = $this->uri->segment_array();
  
  //$data['fb_like']   = true;

  $data['page_title']   = $data['page']->title;
  
  //$data['meta']    = $data['page']->meta;
  //$data['seo_title']   = (!empty($data['page']->seo_title))?$data['page']->seo_title:$data['page']->title;
  
  //$data['gift_cards_enabled'] = $this->gift_cards_enabled;
  
  $this->load->view('page', $data);
 }
 
 function add_subscriber($ajax=false)
	{
		if($ajax)
		{
				 $email_id = $this->input->post('email');
				 if($this->check($email_id)){
					 $save['subscribe_id'] = null;
					 $save['subscribe_email'] =  $email_id;
					 $save['subscribe_ip'] = $this->input->ip_address();				 
					 $id = $this->subscribes_model->save($save);			 
					 
							   
					
					/* send an email */
					// get the email template
					$res = $this->db->where('tplid', '2')->get('tbl_email_template');
					//echo $this->db->last_query();
					//die;
					$row = $res->row_array();
					
					$param['message'] = $row['tplmessage'];
					$email_subject  =  $this->load->view('template',$param, TRUE);
					
					
					$this->load->library('email');
					$config['mailtype'] = 'html';
				
					$this->email->initialize($config);
			
					$this->email->from($this->config->item('email'), $this->config->item('company_name'));
					$this->email->to($email_id);    
					$this->email->bcc($this->config->item('email'));        
					$this->email->subject(email_subject);
					$this->email->message(html_entity_decode($row['tplmessage']));
					
					$this->email->send();
					
					echo json_encode(array('result'=>true));
				 	
				 }
				 else
				 {
				 	echo json_encode(array('result'=>false,'message'=>'You are already subscribe'));
				 }
				 
		}
	}
	
	
	function check_email($str)
	{
		$email = $this->subscribes_model->check_email($str);
		if ($email)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	

}

?>