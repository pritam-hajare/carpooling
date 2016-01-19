<?php
Class Travel_model extends CI_Model
{

	
	function __construct()
	{
			parent::__construct();
		 $data['error'] ="";
    	 
	}
	
	/********************************************************************

	********************************************************************/
	
	function get_alltravellers($limit=0, $offset=0, $order_by='user_id', $direction='ASC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('tbl_users');
		
		return $result->result_array();
	}
	
	
	function count_travellers()
	{
		return $this->db->count_all_results('tbl_users');
	}
	
	function get_traveller($userid)
	{
		
		$result	= $this->db->get_where('tbl_users', array('user_id'=>$userid));
		return $result->row();
	}

		function get_city_list()	
		{ 
			return $this->db->order_by('cityname', 'ASC')->get('tbl_city')->result();
    }

	
	
	
	function save($traveller)
	{
		if ($traveller['user_id'])
		{
			$this->db->where('user_id', $traveller['user_id']);
			$this->db->update('tbl_users', $traveller);
			return $traveller['user_id'];
		}
		else
		{
			$this->db->insert('tbl_users', $traveller);
			return $this->db->insert_id();
		}
	}
	
	function delete($userid)
	{
		
		//this deletes the user record
		$this->db->where('user_id', $userid);
		$this->db->delete('tbl_users');
		
		
	}
	
	function check_email($str, $id=false)
	{
	
		$this->db->select('user_email');
		$this->db->from('tbl_users');
		$this->db->where('user_email', $str);
		if ($id)
		{
			$this->db->where('user_id !=', $id);
		}
		$count = $this->db->count_all_results();
		
		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/*
	these functions handle logging in and out
	*/
	function logout()
	{
		$this->session->unset_userdata('travel');
		$this->carpooling->destroy(false);
		//$this->session->sess_destroy();
	}
	
	
	function reset_password($email)
	{
		$this->load->library('encrypt');
		$travel = $this->get_provider_by_email($email);
		if ($travel)
		{
	
//			
		if($travel['user_admin_status'] == 0 && $travel['isactive'] == 0){
			$this->load->helper('string');
			//$this->load->library('email');
			
			
			$new_password		= random_string('alnum', 6);
			$travel['user_password ']	= sha1($new_password);

			$id=$this->save($travel);
			
			///*			// send an email */
////			// get the email template
			$res = $this->db->where('tplid', '26')->get('tbl_email_template');
			$row = $res->row_array();
			
			// set replacement values for subject & body
			
			// {customer_name}						
			$row['tplmessage'] = str_replace('{EMAIL}', $email, $row['tplmessage']);
			
			$row['tplmessage'] = str_replace('{IP}', $this->input->ip_address(), $row['tplmessage']);
			
			$row['tplsubject'] = str_replace('{EMAIL}', $email, $row['tplsubject']);
			//$row['tplsubject']
			$row['tplmessage'] = str_replace('{PASSWORD}', $new_password, $row['tplmessage']);
			
			
			$param['message'] = $row['tplmessage'];
			
			$email_subject  =  $this->load->view('template',$param, TRUE);
			
			$this->load->library('email');
			
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
	
			$this->email->from($this->config->item('email'), $this->config->item('company_name'));
			$this->email->to($email);
			$this->email->bcc($this->config->item('email'));
			$this->email->subject($row['tplsubject']);
			$this->email->message(html_entity_decode($email_subject));
			
			$this->email->send();
			
			
			return true;
			
		}
		
		
		if($travel['user_admin_status'] == 1 && $travel['isactive'] == 1)
		{
			$this->load->helper('string');
			//$this->load->library('email');
			
			
			$new_password		= random_string('alnum', 6);
			$travel['user_password ']	= sha1($new_password);

			$id=$this->save($travel);
			
			///*			// send an email */
////			// get the email template
			$res = $this->db->where('tplid', '26')->get('tbl_email_template');
			$row = $res->row_array();
			
			// set replacement values for subject & body
			
			// {customer_name}						
			$row['tplmessage'] = str_replace('{EMAIL}', $email, $row['tplmessage']);
			
			$row['tplmessage'] = str_replace('{IP}', $this->input->ip_address(), $row['tplmessage']);
			
			$row['tplsubject'] = str_replace('{EMAIL}', $email, $row['tplsubject']);
			//$row['tplsubject']
			$row['tplmessage'] = str_replace('{PASSWORD}', $new_password, $row['tplmessage']);
			
			$param['message'] = $row['tplmessage'];
			
			$email_subject  =  $this->load->view('template',$param, TRUE);
			
			$this->load->library('email');
			
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
	
			$this->email->from($this->config->item('email'), $this->config->item('company_name'));
			$this->email->to($email);
			$this->email->bcc($this->config->item('email'));
			$this->email->subject($row['tplsubject']);
			$this->email->message(html_entity_decode($email_subject ));
			
			$this->email->send();
			
			return true;
			
		}
			
			
		}
		else
		{
			return false;
		}
	}
	
	function get_provider_by_email($email)
	{
		$result	= $this->db->get_where('tbl_users', array('user_email '=>$email,'isactive'=>1));
		return $result->row_array();
	}
	
	function get_daily_visiter_data()
	{
		 $this->db->select('count(login_id) as visters ,login_time');
		  $this->db->group_by('DATE(login_time)');
		  $result = $this->db->get('tbl_t_login_logs');	
		  $result =$result->result_array();
		/*  echo '<pre>';print_r($result);echo'</pre>';
		  die;*/
		  $chartdata = array();
		  foreach($result as $cat)
		  {
		   $chartdata[] = array('gd('.date('Y',strtotime($cat['login_time'])).','.date('j',strtotime($cat['login_time'])).','.date('n',strtotime($cat['login_time'])).'), '.$cat['visters'].'');
		  }
		  /*   echo '<pre>';print_r($chartdata);echo'</pre>';
		  die;*/
		  
		  $data = json_encode($chartdata);
		  $data = str_replace('"', '', $data);
		  return $data;
		 
	}
}