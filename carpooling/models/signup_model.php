<?php
Class Signup_model extends CI_Model
{

function checkemail($email)
	{
		$this -> db -> select('user_id,user_email');
		$this -> db -> from('tbl_useraccount');
		$this -> db -> where('user_email = ' . "'" . $email . "'"); 
		//$this -> db -> where('user_id <> ' . "'" .$uid."'");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{ 
			$row = $query -> row();			 
			$user_id = $row->user_id;
			 return $user_id;
		}
		else
		{
			$user_id=-1;
			return $user_id;
		}

	}
	function getcity($name)
	{
		$this -> db -> select('city_id');
		$this -> db -> from('tbl_city');
		$this -> db -> where('city_name = ' . "'" . $name . "'");  
		$query = $this -> db -> get();
		
	//echo $this->db->last_query();

		if($query -> num_rows() == 1)
		{
		  $row = $query->row();		
		  $city_id = $row->city_id;
		  return $city_id;
		}
		 $city_id = -1;
		return $city_id;	
	}
	
function updateuserinfo($data,$user_id)
	{
		$flag = 1;
 	  $this->db->where('user_facebookflg', $flag);
	  $this->db->where('user_id', $user_id);
      $this->db->update('tbl_useraccount', $data);
	  
//echo $this->db->last_query();

	$this -> db -> select('user_facebookflg');
	$this -> db -> from('tbl_useraccount');
	$this->db->where('user_id', $user_id);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			$rows = $query->row();
	  		$flag =  $rows->user_facebookflg;
			return $flag;
	    }
		$flag=-1;
		return $flag;
	}

	function insertuserinfo($data)
	{
 	  $this->db->insert('tbl_useraccount', $data);
	  return $this->db->insert_id();
	}
	
	
	function chksignup($email)
	{
		$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('tbl_useraccount');
		$this -> db -> where('user_email = ' . "'" . $email . "'"); 
		$this -> db -> where('usergroup_id = ' . "2");
		$this -> db -> where('active_flg = ' . "0");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	function chkemailchange($email,$uid)
	{
		$this -> db -> select('user_id,user_email');
		$this -> db -> from('tbl_useraccount');
		$this -> db -> where('user_email = ' . "'" . $email . "'"); 
		//$this -> db -> where('user_id <> ' . "'" .$uid."'");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}

	
	function activateuser($uid,$code)
	{
		$data = array(            
			                
				   
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'active_flg'=>0
				   
							
				 );
	$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('tbl_useraccount');
		$this -> db -> where('user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('user_activationcode = ' . "'" . $code . "'"); 
		$this -> db -> where('usergroup_id = ' . "2");
		$this -> db -> where('active_flg = ' . "1");
		$this -> db -> limit(1);

		$query = $this -> db -> get();
//echo $this->db->last_query();
		if($query -> num_rows() == 1)
		{
			 
	 $this->db->where('user_activationcode',$code);
	 $this->db->where('user_id', $uid);
      $this->db->update('tbl_useraccount', $data);
	  return 1;
	  }
	  else
	  {
	  return 0;
	  }

	}
	
	function resend_activation($email,$activationcode,$uid)
	{
	
	$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('tbl_useraccount');
		$this -> db -> where('user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('usergroup_id = ' . "2");
		$this -> db -> where('active_flg = ' . "1");
		$this -> db -> limit(1);

		$query = $this -> db -> get();
//echo $this->db->last_query();
		if($query -> num_rows() == 1)
		{
		$data = array(            
			                
				   
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'user_activationcode'=>$activationcode,
				    'user_email'=>$email,
				   'active_flg'=>1
				   
							
				 );
				 
				 
			       
			 

	 $this->db->where('user_id', $uid);
      $this->db->update('tbl_useraccount', $data);
	  return true;

	}
	else
	{
	return false;
	}
	}
	function update_newemail($email,$activationcode,$uid)
	{
	
	$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('tbl_useraccount');
		$this -> db -> where('user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('usergroup_id = ' . "2");
		$this -> db -> where('active_flg = ' . "0");
		$this -> db -> limit(1);

		$query = $this -> db -> get();
//echo $this->db->last_query();
		if($query -> num_rows() == 1)
		{
		$data = array(            
			                
				   
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'user_activationcode'=>$activationcode,
				    'user_newtempemail'=>$email,
				  			   
							
				 );
				 
				 
			       
			 

	 $this->db->where('user_id', $uid);
      $this->db->update('tbl_useraccount', $data);
	  return true;

	}
	else
	{
	return false;
	}
	}
	
	
	function confirm_newemail($uid,$code)
	{
		$data = array(            
			                
				   
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'active_flg'=>0
				   
							
				 );
				 
	$this -> db -> select('user_id,user_email,user_newtempemail');
		$this -> db -> from('tbl_useraccount');
		$this -> db -> where('user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('user_activationcode = ' . "'" . $code . "'"); 
		$this -> db -> where('usergroup_id = ' . "2");
		$this -> db -> where('active_flg = ' . "0");
		$this -> db -> limit(1);

		$query = $this -> db -> get();
		
//echo $this->db->last_query();
  $row = $query->row_array();
	if($query -> num_rows() == 1)
		{
		
		$data = array(            
			                
				   
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'user_email'=>$row['user_newtempemail']
				   
							
				 );
		
	 $this->db->where('user_activationcode',$code);
	 $this->db->where('user_id', $uid);
      $this->db->update('tbl_useraccount', $data);
	  return 1;
	  }
	  else
	  {
	  return 0;
	  }

	}
	
	
	function Insert_signup($paramupt)
	{
	$data = array(            
			                
				   'user_name'=>$paramupt['user_name'],
				   'user_password' => $paramupt['user_password'],
	               'user_email'=>$paramupt['user_email'],
				   'user_mobile'=>$paramupt['user_mobile'],
				   'user_mobilecode'=>$paramupt['user_mobilecode'],
				   'usergroup_id' => $paramupt['usergroup_id'],
			       'created_date'=>$paramupt['created_date'],
				   'city_id'=>$paramupt['city_id'],
				   'user_activationcode'=>$paramupt['user_activationcode'],
				   'active_flg'=>$paramupt['active_flg']
				   
							
				 );
			       
			   
	 
      $this->db->insert('tbl_useraccount', $data);
	  return $this->db->insert_id();
	}
	
	function update_forgetpasswordcode($paramupt)
	{
	
	$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('tbl_useraccount');
		$this -> db -> where('user_email = ' . "'" . $paramupt['user_email'] . "'"); 
		$this -> db -> where('usergroup_id = ' . "2");
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
      $this->db->update('tbl_useraccount', $data);
	  return $query->result();
	  }
	  else
	  {
	  return false;
	  }
	}
	
	
	
	function activateforgetpassword($uid,$code,$newpassword)
	{
		$data = array(            
			                
				   
			       'modified_date'=>date('Y-m-d H:i:s'),
				   'user_password'=>$newpassword
				   
				   
							
				 );
	$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('tbl_useraccount');
		$this -> db -> where('user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('user_passwordactivationcode = ' . "'" . $code . "'"); 
		$this -> db -> where('usergroup_id = ' . "2");
		$this -> db -> where('active_flg = ' . "0");
		$this -> db -> limit(1);

		$query = $this -> db -> get();
//echo $this->db->last_query();
		if($query -> num_rows() == 1)
		{
			 
	 $this->db->where('user_passwordactivationcode',$code);
	 $this->db->where('user_id', $uid);
      $this->db->update('tbl_useraccount', $data);
	    return $query->result();
	  }
	  else
	  {
	  return false;
	  }

	}
}
?>