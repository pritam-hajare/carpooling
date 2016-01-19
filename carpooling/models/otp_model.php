<?php

Class Otp_model extends CI_Model
{
	var $state = '';
	var $state_taxes;
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function check($mobile)
	{
		$this->db->select('mobile');
		$this->db->where('mobile',$mobile);
		$this->db->where('isverified',1);
		$query = $this->db->get('tbl_mobile_otp');
		if($query->num_rows > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
		
	}
	
	function save($param)
	{
		if ($param['mobile'])
		{
			$this->db->select('mobile');
			$this->db->where('mobile',$param['mobile']);
			//$this->db->where('isverified',1);
			$query = $this->db->get('tbl_mobile_otp');
			if($query->num_rows > 0)
			{
				$this->db->where('mobile', $param['mobile']);
				$this->db->update('tbl_mobile_otp', $param);
				return $param['mobile'];
			}
			else
			{
				$this->db->insert('tbl_mobile_otp', $param);
				return $this->db->insert_id();
			}
			
		}
		
	}
	
	function get($id)
	{
		$result	= $this->db->get_where('tbl_mobile_otp', array('id'=>$id));
		return $result->row();
	}
	
	function reset_code($mobile)
	{
		$this->load->library('encrypt');
		$travel = $this->get_by_mobile($mobile);
		if ($travel)
		{
			$this->load->helper('string');
			//$this->load->library('email');
			
			 $new_password		= random_string('numeric', 6);
			$travel['Otp_code ']	= $new_password;

			$id=$this->save($travel);	
			$this->mobile = $mobile;
			$this->sms_global->to($this->mobile);	
			$this->sms_global->message('your verification code is '.$new_password.' http://www.traveleazy.in');
			$this->sms_global->send();	
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function get_by_mobile($mobile)
	{
		$result	= $this->db->get_where('tbl_mobile_otp', array('mobile'=>$mobile));
		return $result->row_array();
	}
	
	function verify($param)
	{
		$this->db->select('*');
		$this->db->where('mobile', $param['mobile']);
		$this->db->where('Otp_code',  $param['Otp_code']);		
		$this->db->limit(1);
		$result = $this->db->get('tbl_mobile_otp');
		$result	= $result->row_array();
		//echo $this->CI->db->last_query();
		if (sizeof($result) > 0)
		{
			$save['mobile'] =  $result['mobile'];
			$save['isverified'] = 1;
			$this->save($save);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function save_new($param)
	{
		$this->db->insert('tbl_mobile_otp', $param);
		return $this->db->insert_id();
		
	}
}