<?php
Class App_user_model extends CI_Model
{
	function get_user($user_id)
	{
		$this->db->select('user_first_name as fname,user_last_name as lname,user_street as address,user_city as city,user_gender as gender,user_email as email, user_professional_email as profs_email,rating as user_rating,user_company_name as company,user_mobile as mobile,mob_vf as mobile_vf,profs_email_vf as pemail_vf,user_profile_img as prof_img');
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
		
		if($param['user_street']!=null)
		{
			$data['user_street'] = $param['user_street'];
		}
		else{
			$data['user_street'] = null;
		}

		if($param['user_city']!=null)
		{$data['user_city'] =$param['user_city'];}
		else{ $data['user_city'] = null; }

		if($param['user_company_name']!=null)
		{$data['user_company_name'] = $param['user_company_name'];}
		else{ $data['user_company_name'] = null; }
		
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

	function get_email($user_id){
		$this->db->select('user_email as email');
		$this->db->from('tbl_users');
		$this->db->where('user_id', $user_id);
		$result = $this->db->get();
		return $result = $result->row_array();		
	}

	function get_mob_det($user_id)
	{
		$this->db->select('user_mobile as mobile,mob_vf');
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

	function set_profile_imgname($user_id,$imgName){
		$data=array();
		$data['user_profile_img'] = $imgName;

		$this->db->where('user_id',$user_id);
		$this->db->update('tbl_users', $data);
		
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	function set_professional_email($param){
		$data=array();
		$data['user_professional_email'] = $param['user_professional_email'];
		$data['profs_email_vf'] = 0;

		$this->db->where('user_id',$param['user_id']);
		$this->db->update('tbl_users', $data);
		
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	function get_profile_img_name($user_id)
	{
		$this->db->select('user_profile_img as img_name');
		$this->db->from('tbl_users');
		$this->db->where('user_id', $user_id);

		$result = $this->db->get();
		$result = $result->row_array();	
		if (sizeof($result) > 0) {
			return $result['img_name'];
		}
		else{
			return false;
		}
	}
	
}
?>