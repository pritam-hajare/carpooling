<?php
Class Login_model extends CI_Model
{
	function login($username, $password)
	{
		$this -> db -> select('user_id,user_email,user_password,usrd_fname');
		$this->db->join("job_user_details", "usrd_user_id=user_id");
		$this -> db -> from('job_user');
		$this -> db -> where('user_email = ' . "'" . $username . "'"); 
		$this -> db -> where('user_password = ' . "'" . MD5($password) . "'"); 
		$this -> db -> where('active_flg = ' . "0");
		$this -> db -> limit(1);
       
		$query = $this -> db -> get();
		
//echo   $this -> db -> last_query();
		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
}
?>