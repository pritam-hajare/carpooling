<?php
Class Register_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
	}
	
		function getCity() {
		return $this->db->order_by('city_name', 'ASC')->get('job_city')->result();
	}
	
	function getState() {
		return $this->db->order_by('stat_name', 'ASC')->get('job_state')->result();
	}
		
	function insertjobseeker($pmData, $pmData1) {
		
		$this->db->insert('job_user', $pmData);
		$vInsertId	= $this->db->insert_id();
		$uid = $vInsertId;
		
		if ($vInsertId) {
			$pmData1['usrd_user_id']	= $vInsertId;
			$this->db->insert('job_user_details', $pmData1);
			$vInsertId	= $this->db->insert_id();
		}
		
		if ($vInsertId > 0) {
			$admin = array();
			$admin['user']					= array();
			$admin['user']['id']			= $vInsertId;
			$admin['user']['access'] 		= 'user';
			$admin['user']['email']		= $pmData['user_email'];
			
			$this->session->set_flashdata('redirect', $admin);
			return $uid;
		}
		else
		{
			return false;
		}
		
		return $uid;		
	}
	
	

function insertcompany($pmData1)
 {
	 $this->db->insert('job_company', $pmData1);
	 $vInsertId	= $this->db->insert_id();
	 return $vInsertId;
		
 }
function insertemployeer($pmData)
 {
		
		
		if ($pmData) {
			
			$this->db->insert('job_company_user', $pmData);
			$vInsertId	= $this->db->insert_id();
		}
		
		if ($vInsertId > 0) {
			
			return $vInsertId;
		}
		else
		{
			return false;
		}
		
		return $vInsertId;		
	}	
	
		function activateuser($uid,$code)
	{
		$data = array( 
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'active_flg'=>0
				 );
	$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('job_user');
		$this -> db -> where('user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('user_activationcode = ' . "'" . $code . "'"); 
		$this -> db -> where('active_flg = ' . "1");
		$this -> db -> limit(1);

		$query = $this -> db -> get();
//echo $this->db->last_query();
		if($query -> num_rows() == 1)
		{
			 
	 $this->db->where('user_activationcode',$code);
	 $this->db->where('user_id', $uid);
      $this->db->update('job_user', $data);
	  return $query->result();;
	  }
	  else
	  {
	  return 0;
	  }

	}
	
	
	function activateempuser($uid,$code)
	{
		$data = array( 
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'usrc_activation_flag'=>0
				 );
	$this -> db -> select('usrc_id,usrc_email, usrc_password');
		$this -> db -> from('job_company_user');
		$this -> db -> where('usrc_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('usrc_activation_code = ' . "'" . $code . "'"); 
		$this -> db -> where('usrc_activation_flag = ' . "1");
		$this -> db -> limit(1);

		$query = $this -> db -> get();
//echo $this->db->last_query();
		if($query -> num_rows() == 1)
		{
			 
	 $this->db->where('usrc_activation_code',$code);
	 $this->db->where('usrc_id', $uid);
      $this->db->update('job_company_user', $data);
	  return $query->result();;
	  }
	  else
	  {
	  return 0;
	  }

	}
	
	function Update_password($paramupt,$uid)
	{
		$this->db->where('user_id', $uid);
      $this->db->update('job_user', $paramupt);
	 // echo $this->db->last_query();
	   return 1;
	}
		
		function Update_emppassword($paramupt,$uid)
	{
		$this->db->where('usrc_id', $uid);
      $this->db->update('job_company_user', $paramupt);
	 // echo $this->db->last_query();
	   return 1;
	}
	
	function Update_resume($paramupt,$uid)
	{
		$this->db->where('usrd_user_id', $uid);
      $this->db->update('job_user_details', $paramupt);
	 // echo $this->db->last_query();
	   return 1;
	}
	function getcity_list($state = null)
	{
      $this->db->select('city_id, city_name');
 
      if($state != NULL)
	  {
          $this->db->where('state_id', $state);
      }
 
     $query = $this->db->get('job_city');
 
     $city = array();
 
     if($query->result()){
          foreach ($query->result() as $city) {
              $cities[$city->city_id] = $city->city_name;
			 
          }
      return $cities;
      }else{
          return FALSE;
      }
   }
   
   
   
   function update_forgetpasswordcode($paramupt)
	{
	
	$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('job_user');
		$this -> db -> where('user_email = ' . "'" . $paramupt['user_email'] . "'"); 
		$this -> db -> where('active_flg = ' . "0");
		$this -> db -> limit(1);

		$query = $this -> db -> get();
//echo $this->db->last_query();
		if($query -> num_rows() == 1)
		{
		
	
	$data = array(            
			                
				   
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'user_passwordactivationcode'=>$paramupt['user_passwordactivationcode']
				  
				 );
				 
				 
			       
			 

	 $this->db->where('user_email',$paramupt['user_email']);
      $this->db->update('job_user', $data);
	  return $query->result();
	  }
	  else
	  {
	  return false;
	  }
	}
	
	
	
	function activateforgetpassword($uid,$code)
	{
		
	$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('job_user');
		$this -> db -> where('user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('user_passwordactivationcode = ' . "'" . $code . "'"); 
	
		$this -> db -> where('active_flg = ' . "0");
		$this -> db -> limit(1);

		$query = $this -> db -> get();
//echo $this->db->last_query();
		if($query -> num_rows() == 1)
		{
			 
			 $data = array(            
			                
				   
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'user_passwordactivationcode'=>''
				   
				   
							
				 );
				 
	 $this->db->where('user_passwordactivationcode',$code);
	 $this->db->where('user_id', $uid);
      $this->db->update('job_user', $data);
	//  echo $this->db->last_query();
	    return $query->result();
	  }
	  else
	  {
	  return false;
	  }

	}
	  
}
?>