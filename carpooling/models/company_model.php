<?php
Class Company_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct()
	{
			parent::__construct();
		 
		 
	}
	
	/********************************************************************

	********************************************************************/
	
	function get_companys($limit=0, $offset=0, $order_by='company_id', $direction='DESC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('tbl_company');
		
		return $result->result();
	}
	
	function get_company($userid)
	{
		
		$result	= $this->db->get_where('tbl_company', array('company_id'=>$userid));
		return $result->row();
	}
	
	
	
	
	
	
	function subscribed_providers($limit=0, $offset=0, $order_by='prodid', $direction='DESC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where(array('subscribe_flg'=>1, 'isactive'=>1));
		$result	= $this->db->get('tbl_provider');
		
		return $result->result();
	}
	
	function unsubscribed_providers($limit=0, $offset=0, $order_by='prodid', $direction='DESC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->where(array('subscribe_flg'=>0, 'isactive'=>1));
		$result	= $this->db->get('tbl_provider');
		
		return $result->result();
	}
	
	function get_providers_nopost_report($limit=0, $offset=0, $order_by='prodid', $direction='DESC')
	{
		//$this->db->order_by($order_by, $direction);
		$this->db->select('*');
		
		$this->db->from('tbl_provider');
		$this->db->join('tbl_projects','tbl_projects.projproid = tbl_provider.prodid','left');	
		$this->db->where('tbl_projects.projproid IS NULL AND tbl_provider.isactive=1');
		$views = $this->db->get();
		/*echo $this->db->last_query();
				die;*/	
		return $views->result();
	}
	
	function get_providers_post_ten_report($limit=0, $offset=0, $order_by='prodid', $direction='DESC' ,$term)
	{
		$this->db->order_by($order_by, $direction);
		$this->db->select('tbl_provider.*,count(tbl_projects.projid) as `total`');
		
		$this->db->from('tbl_provider');
		$this->db->group_by('tbl_projects.projproid');
		$this->db->join('tbl_projects','tbl_projects.projproid = tbl_provider.prodid','inner');	
		$this->db->where('tbl_provider.isactive', 1);
		if(!empty($term)){
			
			if(!empty($term->count))
			{
				$this->db->having('total >=',$term->count);
			}
		}
		else
		{
			$this->db->having('total >=',10);
		}
		
		$result = $this->db->get();
		/*echo $this->db->last_query();
				die;	*/
		return $result->result();
	}
	
	function count_providers()
	{
		return $this->db->count_all_results('tbl_provider');
	}
	
	function get_provider($userid)
	{
		
		$result	= $this->db->get_where('tbl_provider', array('prodid'=>$prodid));
		return $result->row();
	}
		
	function get_allprovider_count()
	{
		$this->db->where('isactive', 1);
		$this->db->from('tbl_provider');		
		$count= $this->db->count_all_results();
		return $count;
	}
		
	function get_viewedproject($prodid)
	{
		
		$result	= $this->db->order_by('projhits', 'DSC')->limit(5)->get_where('tbl_projects', array('projproid'=>$prodid));
		/*print_r($result->result());
		die;*/
		return $result->result();
	}
		
		function get_city_list()	{ 
			return $this->db->order_by('cityname', 'ASC')->get('tbl_city')->result();
    }

	
	function get_subscribers()
	{
		$this->db->where('email_subscribe','1');
		$res = $this->db->get('tbl_provider');
		return $res->result_array();
	}
	
	
	
	function get_address($address_prodid)
	{
		$address= $this->db->where('prodid', $address_prodid)->get('providers_address_bank')->row_array();
		if($address)
		{
			$address_info			= unserialize($address['field_data']);
			$address['field_data']	= $address_info;
			$address				= array_merge($address, $address_info);
		}
		return $address;
	}
	
	function save_address($data)
	{
		// prepare fields for db insertion
		$data['field_data'] = serialize($data['field_data']);
		// update or insert
		if(!empty($data['prodid']))
		{
			$this->db->where('prodid', $data['prodid']);
			$this->db->update('providers_address_bank', $data);
			return $data['prodid'];
		} else {
			$this->db->insert('providers_address_bank', $data);
			return $this->db->insert_prodid();
		}
	}
	
	function delete_address($prodid, $provider_prodid)
	{
		$this->db->where(array('prodid'=>$prodid, 'provider_prodid'=>$provider_prodid))->delete('providers_address_bank');
		return $prodid;
	}
	
	function save($company)
	{
		if ($company['company_id'])
		{
			$this->db->where('company_id', $company['company_id']);
			$this->db->update('tbl_company', $company);
			return $company['company_name'];
		}
		else
		{
			$this->db->insert('tbl_company', $company);
			return $this->db->insert_id();
		}
	}
	
	function deactivate($prodid)
	{
		$provider	= array('prodid'=>$prodid, 'active'=>0);
		$this->save_provider($provider);
	}
	
	function delete($prodid)
	{
		/*
		deleting a provider will remove all their orders from the system
		this will alter any report numbers that reflect total sales
		deleting a provider is not recommended, deactivation is preferred
		*/
		
		//this deletes the providers record
		$this->db->where('company_id', $prodid);
		$this->db->delete('tbl_company');
		
		//// Delete Address records
//		$this->db->where('provider_prodid', $prodid);
//		$this->db->delete('providers_address_bank');
//		
//		//get all the orders the provider has made and delete the items from them
//		$this->db->select('prodid');
//		$result	= $this->db->get_where('orders', array('provider_prodid'=>$prodid));
//		$result	= $result->result();
//		foreach ($result as $order)
//		{
//			$this->db->where('order_prodid', $order->prodid);
//			$this->db->delete('order_items');
//		}
//		
//		//delete the orders after the items have already been deleted
//		$this->db->where('provider_prodid', $prodid);
//		$this->db->delete('orders');
	}
	
	function check_email($str, $id=false)
	{
		
	
		$this->db->select('company_email');
		$this->db->from('tbl_company');
	/*	echo $this->db->last_query();
		die;*/
		$this->db->where('company_email', $str);
		if ($id)
		{
			$this->db->where('company_id !=', $id);
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
		$this->session->unset_userdata('provider');
		$this->finalsem->destroy(false);
		//$this->session->sess_destroy();
	}
	

	
	
	
	
	/// Provider groups functions
	
	function get_groups()
	{
		return $this->db->get('provider_groups')->result();		
	}
	
	function get_group($prodid)
	{
		return $this->db->where('prodid', $prodid)->get('provider_groups')->row();		
	}
	
	function delete_group($prodid)
	{
		$this->db->where('prodid', $prodid);
		$this->db->delete('provider_groups');
	}
	
	function save_group($data)
	{
		if(!empty($data['prodid'])) 
		{
			$this->db->where('prodid', $data['prodid'])->update('provider_groups', $data);
			return $data['prodid'];
		} else {
			$this->db->insert('provider_groups', $data);
			return $this->db->insert_prodid();
		}
	}
	
	function profile_photochange($param)
	 {
	  
		  $this->db->from('tbl_provider');
				$this->db->select('prodlogo');
		  $this->db->where('prodid', $param['prodid']);
		  $query = $this->db->get();
		 
		  if($query->num_rows() > 0)
			  {
		   $row = $query->row_array();
		   @unlink('./uploads/provider/profiles/'.$row['prodlogo']);
		   @unlink('./uploads/provider/'.$row['prodlogo']);		   
		   $user_photo= $param['prodlogo'];
		   $data = array('prodlogo' => $user_photo);
			$this->db->where('prodid', $param['prodid']);
			   $this->db->update('tbl_provider', $data);
		   }
		   else
		   {
			$data = array('prodlogo' => $param['prodlogo']);
			$this->db->where('prodid', $param['prodid']);
			   $this->db->update('tbl_provider', $data);
		   }
	  
	 }
	 
	function get_totalenquiry($provid)
	{
		$this->db->where('provider_id', $provid);
		$this->db->from('tbl_provider_enquires');		
		$count= $this->db->count_all_results();
		return $count;
	}
	
	function get_totalcredit($provid)
	{
		$this->db->select('available_credit');
		$this->db->where('provider_id', $provid);
		$this->db->from('tbl_provider_credits');
		$views = $this->db->get();
		return $views->row()->available_credit;
		
	}
	
	
	function reset_password($email)
	{
		$this->load->library('encrypt');
		$provider = $this->get_provider_by_email($email);
		if ($provider)
		{
			$this->load->helper('string');
			$this->load->library('email');
			
			 $new_password		= random_string('alnum', 6);
			$provider['prodpwd']	= sha1($new_password);

			$id=$this->save($provider);
			
		
			
			$this->load->library('email');
//			
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
	
			$this->email->from($this->config->item('email'), $this->config->item('company_name'));
			$this->email->to($provider['prodemail']);
			//$this->email->bcc($this->config->item('email'));
			$this->email->subject($this->config->item('site_name').': Password Reset');
			$this->email->message('Your password has been reset to <strong>'. $new_password .'</strong>.');			
			$this->email->send();
			
//			$this->email->from($this->config->item('email'), $this->config->item('site_name'));
//			$this->email->to($email);
//			$this->email->subject($this->config->item('site_name').': Password Reset');
//			$this->email->message('Your password has been reset to <strong>'. $new_password .'</strong>.');
//			$this->email->send();
			
			/*$this -> mobile = $provider['prodcontno'];
			$this->sms_global->to($this -> mobile);	
			$this->sms_global->message('Your Password is '.$new_password.' By www.finalsem.com');
			$this->sms_global->send();*/
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function get_provider_by_email($email)
	{
		$result	= $this->db->get_where('tbl_provider', array('prodemail'=>$email,'isactive'=>1));
		return $result->row_array();
	}
}