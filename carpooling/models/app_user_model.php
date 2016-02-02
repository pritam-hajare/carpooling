<?php
Class App_user_model extends CI_Model
{
	function get_user($user_id)
	{
		$this->db->select('user_first_name as fname,user_last_name as lname,user_street as address,user_city as city,user_gender as gender,user_email as email,rating as user_rating,user_company_name as company,user_mobile as mobile,mob_vf as mobile_vf');
		$this->db->from('tbl_users');
		$this->db->where('user_id', $user_id);
		$this->db->limit(1);
		$result = $this->db->get();
		$result = $result->row_array();	
		if (sizeof($result) > 0) {
			return $result;
		}
		else{
			return false;
		}
	}

	function edit_user($param)
	{	
		$data=array();
		$data['user_first_name'] =$param['user_first_name'];
		$data['user_last_name'] =$param['user_last_name'];
		
		if($param['user_address']!='NA')
		$data['user_street'] =$param['user_address'];
		if($param['user_city']!='NA')
		{$data['user_city'] =$param['user_city'];}
		if($param['user_company_name']!='NA')
		{$data['user_company_name'] =$param['user_company_name'];}
		
		$data['user_gender'] =$param['user_gender'];

		$this->db->where('user_id',$param['user_id']);
		return $this->db->update('tbl_users', $data);
		
	}

	function set_pref($param){
		$data=array();
		$data['allowed_pet'] = $param['allowed_pet'];
		$data['allowed_smoke'] = $param['allowed_smoke'];
		$data['allowed_music'] = $param['allowed_music'];

		$this->db->where('user_id',$param['user_id']);
		return $this->db->update('tbl_users', $data);
	}

	function get_pref($user_id)
	{
		$this->db->select('allowed_pet as pet,allowed_music as msc,allowed_smoke as smk');
		$this->db->from('tbl_users');
		$this->db->where('user_id', $user_id);

		$result = $this->db->get();
		$result = $result->row_array();	
		if (sizeof($result) > 0) {
			return $result;
		}
		else{
			return false;
		}
	}

}
?>