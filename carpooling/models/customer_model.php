<?php
Class Customer_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct()
	{
			parent::__construct();
			
    	 $data['error'] ="";
		  $sms['user'] = 'traveleazyin';
		 $sms['pass'] = 'Hit@12345';
		 $sms['from'] = 'TRLEZY';
		 $this->load->library('Sms_global',$sms);
    	

	}
	
	/********************************************************************

	********************************************************************/
	
	function get_customers($limit=0, $offset=0, $order_by='id', $direction='DESC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('tbl_users');
		return $result->result();
	}
	
	function count_customers()
	{
		return $this->db->count_all_results('tbl_users');
	}
	
	function get_customer($user_id)
	{
		
		$result	= $this->db->get_where('tbl_users', array('user_id'=>$user_id));
		return $result->row();
	}
	
	function check_access($id)
	{
		//$this->db->select('isactive')
		$this->db->where('isverified',$id);
		$data= $this->db->get('tbl_users');
		//$data = $data->row();
		if($data->num_rows >0)
		{
			
			$userid = $data->row()->user_id;
			$mobile = $data->row()->user_mobile;
			$firstname = $data->row()->user_first_name;
			$lastname = $data->row()->user_last_name;
			$save['isactive']= 1;
			$save['user_admin_status']= 1;
			$save['user_id']=$userid;
			$this->save($save);
			/*$this->mobile = $mobile;
			$this->sms_global->to($this->mobile);	
			$this->sms_global->message('Welcome '.$firstname.'.'.$lastname.'!, your account has been activated. http://www.traveleazy.in');
			$this->sms_global->send();*/
			
			return true;
			}
		else
		{
			return false;
		}
		
		//('isverified'=>sha1($id)));
		
		//return $result->row();
	}
	function get_jobassistance($isiteuser)
	{
		
		$result	= $this->db->get_where('tbl_jobassitance', array('student_id '=>$isiteuser));
		return $result->row();
	}
	
	
	function get_subscribers()
	{
		$this->db->where('email_subscribe','1');
		$res = $this->db->get('tbl_msiteuser');
		return $res->result_array();
	}
	
	
	
	function get_address($address_isiteuser)
	{
		$address= $this->db->where('isiteuser', $address_isiteuser)->get('customers_address_bank')->row_array();
		if($address)
		{
			$address_info			= unserialize($address['field_data']);
			$address['field_data']	= $address_info;
			$address				= array_merge($address, $address_info);
		}
		return $address;
	}
	
	function get_allstudent_count()
	{
		$this->db->where('isactive', 1);
		$this->db->from('tbl_msiteuser');		
		$count= $this->db->count_all_results();
		return $count;
	}
	
	function save_address($data)
	{
		// prepare fields for db insertion
		$data['field_data'] = serialize($data['field_data']);
		// update or insert
		if(!empty($data['isiteuser']))
		{
			$this->db->where('isiteuser', $data['isiteuser']);
			$this->db->update('customers_address_bank', $data);
			return $data['isiteuser'];
		} else {
			$this->db->insert('customers_address_bank', $data);
			return $this->db->insert_id();
		}
	}
	
	function delete_address($isiteuser, $customer_isiteuser)
	{
		$this->db->where(array('isiteuser'=>$isiteuser, 'customer_isiteuser'=>$customer_isiteuser))->delete('customers_address_bank');
		return $isiteuser;
	}
	
	function save($customer)
	{
		if ($customer['user_id'])
		{
			$this->db->where('user_id',$customer['user_id']);
			$this->db->update('tbl_users',$customer);
			//echo $this->db->last_query();
			return $customer['user_id'];
		}
		else
		{
			$this->db->insert('tbl_users', $customer);
			
			return $this->db->insert_id();
		}
	}
	
	function deactivate($isiteuser)
	{
		$customer	= array('isiteuser'=>$isiteuser, 'active'=>0);
		$this->save_customer($customer);
	}
	
	function delete($isiteuser)
	{
		/*
		deleting a customer will remove all their orders from the system
		this will alter any report numbers that reflect total sales
		deleting a customer is not recommended, deactivation is preferred
		*/
		
		//this deletes the customers record
		$this->db->where('isiteuser', $isiteuser);
		$this->db->delete('tbl_msiteuser');
		
		// Delete Address records
		$this->db->where('customer_isiteuser', $isiteuser);
		$this->db->delete('customers_address_bank');
		
		//get all the orders the customer has made and delete the items from them
		$this->db->select('isiteuser');
		$result	= $this->db->get_where('orders', array('customer_isiteuser'=>$isiteuser));
		$result	= $result->result();
		foreach ($result as $order)
		{
			$this->db->where('order_isiteuser', $order->isiteuser);
			$this->db->delete('order_items');
		}
		
		//delete the orders after the items have already been deleted
		$this->db->where('customer_isiteuser', $isiteuser);
		$this->db->delete('orders');
	}
	
	function check_email($str, $isiteuser=false)
	{
		$this->db->select('vcsiteuseremail');
		$this->db->from('tbl_msiteuser');
		$this->db->where('vcsiteuseremail', $str);
		if ($isiteuser)
		{
			$this->db->where('isiteuser !=', $isiteuser);
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
	
	function check_mobile($str, $isiteuser=false)
	{
		$this->db->select('isiteuserid');
		$this->db->from('tbl_msiteuser');
		$this->db->where('isiteuserid', $str);
		if ($isiteuser)
		{
			$this->db->where('isiteuser !=', $isiteuser);
		}
		$count = $this->db->count_all_results();
		
	//	echo $this->db->last_query();
		
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
		$this->session->unset_userdata('student');
		//$this->finalsem->destroy(false);
		//$this->session->sess_destroy();
	}
	
	function login($mobile, $password, $remember=false)
	{
		$this->db->select('*');
		$this->db->where('isiteuserid', $mobile);
		$this->db->where('isactive', 1);
		$this->db->where('vcsiteuserpwd',  sha1($password));
		$this->db->limit(1);
		$result = $this->db->get('tbl_msiteuser');
		
		$customer	= $result->row_array();
	
		if ($customer)
		{
			
					
			
			if(!$remember)
			{
				$customer['expire'] = time()+$this->session_expire;
			}
			else
			{
				$customer['expire'] = false;
			}
			
			// put our customer in the cart
			$this->finalsem->save_customer($customer);
			
			

		
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function is_logged_in($redirect = false, $default_redirect = 'student/login/')
	{
		
		//$redirect allows us to choose where a customer will get redirected to after they login
		//$default_redirect points is to the login page, if you do not want this, you can set it to false and then redirect wherever you wish.
		
		$customer = $this->finalsem->customer();

		//print_r($customer);
		if (!$customer)
		{
			//die;
			//this tells Carpooling where to go once logged in
			if ($redirect)
			{
				$this->session->set_flashdata('redirect', $redirect);
			}
			
			if ($default_redirect)
			{	
				redirect($default_redirect);
			}
			
			return false;
		}
		else
		{
		
			//check if the session is expired if not reset the timer
			if($customer['expire'] && $customer['expire'] < time())
			{
				//die;
				$this->logout();
				if($redirect)
				{
					$this->session->set_flashdata('redirect', $redirect);
				}

				if($default_redirect)
				{
					redirect('student/login');
				}

				return false;
			}
			else
			{

				//update the session expiration to last more time if they are not remembered
				if($customer['expire'])
				{
					$customer['expire'] = time()+$this->session_expire;
					$this->finalsem->save_customer($customer);
				}

			}

			return true;
		}
	}
	
	
	function is_logged_in_project()
	{
		
		//$redirect allows us to choose where a customer will get redirected to after they login
		//$default_redirect points is to the login page, if you do not want this, you can set it to false and then redirect wherever you wish.
		
		$customer = $this->finalsem->customer();

		
		if (!isset($customer['user_id']))
		{
						
			return false;
		}
		else
		{
		
			//check if the session is expired if not reset the timer
			if($customer['expire'] && $customer['expire'] < time())
			{

				$this->logout();
				

			
				return false;
			}
			else
			{

				//update the session expiration to last more time if they are not remembered
				if($customer['expire'])
				{
					$customer['expire'] = time()+$this->session_expire;
					$this->finalsem->save_customer($customer);
				}

			}

			return true;
		}
	}
	
	
	
	
	
	function reset_password($mobile)
	{
		$this->load->library('encrypt');
		$customer = $this->get_customer_by_mobile($mobile);
		if ($customer)
		{
			$this->load->helper('string');
			$this->load->library('email');
			
			 $new_password		= random_string('alnum', 6);
			$customer['vcsiteuserpwd']	= sha1($new_password);

			$id=$this->save($customer);
			
			/*$this->load->library('email');
//			
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
	
			$this->email->from($this->config->item('email'), $this->config->item('company_name'));
			$this->email->to($customer['vcsiteuseremail']);
			$this->email->bcc($this->config->item('email'));
			$this->email->subject($this->config->item('site_name').': Password Reset');
			$this->email->message('Your password is <strong>'. $new_password .'</strong>.');			
			$this->email->send();*/
			
			$this -> mobile = $customer['isiteuserid'];
			$this->sms_global->to($this -> mobile);	
			$this->sms_global->message('Your Password is '.$new_password.' By www.finalsem.com');
			$this->sms_global->send();			
//			$this->email->from($this->config->item('email'), $this->config->item('site_name'));
//			$this->email->to($email);
//			$this->email->subject($this->config->item('site_name').': Password Reset');
//			$this->email->message('Your password has been reset to <strong>'. $new_password .'</strong>.');
//			$this->email->send();
			
			
			/*$this -> mobile = $mobile;
			$this->sms_global->to($this -> mobile);	
			$this->sms_global->message('Your Password is'.$new_password.' By www.finalsem.com');
			$this->sms_global->send();*/
					
					
			 
			
			return true;
		}
		else
		{
			return false;
		}
	}	
	
	function get_customer_by_mobile($mobile)
	{
		$result	= $this->db->get_where('tbl_msiteuser', array('isiteuserid'=>$mobile,'isactive'=>1,'isverify'=>1));
		return $result->row_array();
	}
	
	
	/// Customer groups functions
	
	function get_groups()
	{
		return $this->db->get('customer_groups')->result();		
	}
	
	function get_group($isiteuser)
	{
		return $this->db->where('isiteuser', $isiteuser)->get('customer_groups')->row();		
	}
	
	function delete_group($isiteuser)
	{
		$this->db->where('isiteuser', $isiteuser);
		$this->db->delete('customer_groups');
	}
	
	function save_group($data)
	{
		if(!empty($data['isiteuser'])) 
		{
			$this->db->where('isiteuser', $data['isiteuser'])->update('customer_groups', $data);
			return $data['isiteuser'];
		} else {
			$this->db->insert('customer_groups', $data);
			return $this->db->insert_isiteuser();
		}
	}
	
	function save_enquire($data)
	{
		$this->db->select('*');
		$this->db->where('student_id',$data['student_id']);
		$this->db->where('project_id', $data['project_id']);
		$this->db->limit(1);
		$result = $this->db->get('tbl_provider_enquires');
		$enquire	= $result->row_array();
		//echo $this->db->last_query();
	
		if ($enquire)
		{
			$this->db->where('enquire_id', $enquire['enquire_id'])->update('tbl_provider_enquires', $data);
			return $enquire['enquire_id'];
		}
		
		 else
		{
			$result	= $this->db->get_where('tbl_provider_enquires', array('provider_id'=>$data['provider_id'],'student_id'=>$data['student_id'],'show_flg'=>0));
		 	$row=$result->row();
			if($row)
			{
				
				$credit			= (array)$this->get_provider_credit($data['provider_id']);				
				if($credit)
				{
					if($credit['available_credit'] > 0)
					{
						echo "Not Send Intimation";
						
			
					}
					else
					{
						echo "inform low balance mail";
						$data['show_flg'] = 1; 
					}
				}
				else //Non paid Provider
				{
						echo "non paid inform low balance mail";
						$data['show_flg'] = 1; 
				}
			
			}
			else
			{
			
				
				$credit			= (array)$this->get_provider_credit($data['provider_id']);				
				if($credit)//if paid, customer
				{
					if($credit['available_credit'] > 0)
					{
						echo "send Intimation";
						$pcredit['available_credit'] = $credit['available_credit'] - 1;						
						$this->db->where('provider_id', $data['provider_id'])->update('tbl_provider_credits', $pcredit);
			
					}
					else
					{
						echo "inform low balance mail";
						$data['show_flg'] = 1; 
					}
				}
				else //Non paid Provider
				{
						echo "non paid inform low balance mail";
						$data['show_flg'] = 1; 
				}

		}
			
			
			$this->db->insert('tbl_provider_enquires', $data);
			//return $this->db->insert_id();
			
		}
	}
	
	function get_provider_credit($provider_id)
	{
		
		$result	= $this->db->get_where('tbl_provider_credits', array('provider_id'=>$provider_id));
		return $result->row();
	}
	
	function checkcontact($projid=0,$studid=0,$provid=0){
		
		$this->db->select('*');
		$this->db->where(array('student_id'=>$studid,'project_id'=>$projid,'provider_id'=>$provid,'show_flg'=>1));
		$this->db->limit(1);
		$result = $this->db->get('tbl_provider_enquires');
		$enquire	= $result->row_array();
		if($enquire)
		{
			
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function wish_Auth($projid=0,$studid=0){
		$result=$this->db->get_where('tbl_wishlist', array('student_id'=>$studid,'project_id'=>$projid));
		if($result->num_rows > 0)
		{
			
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function add_wish($data)
	{
		if($this->db->insert('tbl_wishlist', $data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function get_totalwishlist($projid)
	{
		$this->db->select_sum('projhits');
		$this->db->where('project_id', $projid);
		$this->db->from('tbl_wishlist');
		$list = $this->db->get();
		return $list->row()->projhits;
		
	}
	
	function remove_wish($data)
	{
//		$this->db->where('tbl_wishlist', $data);
		$this->db->delete('tbl_wishlist',$data);
	}
	
	
	function profile_photochange($param)
	 {
	  
		  $this->db->from('tbl_msiteuser');
				$this->db->select('vcsiteuserlogo');
		  $this->db->where('isiteuser', $param['isiteuser']);
		  $query = $this->db->get();
		 
		  if($query->num_rows() > 0)
			  {
		   $row = $query->row_array();
		   @unlink('./uploads/student/profiles/'.$row['vcsiteuserlogo']);
		   @unlink('./uploads/student/'.$row['vcsiteuserlogo']);		   
		   $user_photo= $param['vcsiteuserlogo'];
		   $data = array('vcsiteuserlogo' => $user_photo);
			$this->db->where('isiteuser', $param['isiteuser']);
			   $this->db->update('tbl_msiteuser', $data);
		   }
		   else
		   {
			$data = array('vcsiteuserlogo' => $param['vcsiteuserlogo']);
			$this->db->where('isiteuser', $param['isiteuser']);
			   $this->db->update('tbl_msiteuser', $data);
		   }
	  
	 }
	 
	 function get_contact($projid=0)
	 {
	 	$this->db->select('*');
		$this->db->from('tbl_provider');
		$this->db->join('tbl_projects','tbl_provider.prodid = tbl_projects.projproid','inner');	
		$this->db->where('tbl_projects.projid',$projid);
		$views = $this->db->get();
		return $views->row();
	 }
		
}