<?php
class Employer_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getemployer_list() {
		return $this->db->order_by('comp_id', 'DESC')->get('job_company')->result();
	}
	
	function getemployer_recent_list() {
		return $this->db->order_by('comp_id', 'DESC')->limit(10)->get('job_company')->result();
	}	
	
	function getemployer( $pmEmployer_Id ) {
		return $this->db->where('comp_id', $pmEmployer_Id)->get('job_company')->result();
	}
	
	function insertemployer($pmData, $pmData1)
	{
		if(!$pmData['comp_id'] && $pmData1['usrc_email']) 
		{
			$this->db->insert('job_company', $pmData);
			$vInsertId	= $this->db->insert_id();
			
			if ($vInsertId) {
				$pmData1['usrc_comp_id']	= $vInsertId;
				$this->db->insert('job_company_user', $pmData1);
				$vInsertId	= $this->db->insert_id();
			}
			
			return $vInsertId;
		} 
		else 
		{
			$this->db->where('comp_id', $pmData['comp_id']);
			$this->db->update('job_company', $pmData);
			
			return $pmData['comp_id'];
		}
	}
	
	function getCity() {
		return $this->db->order_by('city_name', 'ASC')->get('job_city')->result();
	}
	
	function getState() {
		return $this->db->order_by('stat_name', 'ASC')->get('job_state')->result();
	}
	
	function get_company_profile_detail($pm_comp_id = 0) { 
		$this->db->from('job_company');
			
		$this->db->where('comp_status', 1);
		$this->db->where('comp_id', $pm_comp_id);
		$res = $this->db->get();
		return $res->result_array();
		//return $this->db->where('comp_id', $pmEmployer_Id)->get('job_company')->result_array();
	}
	
	function getStateCity($pm_comp_id = 0) { 
		$this->db->from('job_city');			
		$this->db->where('active_flg', 0);
		$this->db->where('state_id', $pm_comp_id);
		$res = $this->db->get();
		return $res->result_array();
		//return $this->db->where('comp_id', $pmEmployer_Id)->get('job_company')->result_array();
	}
	
	function updateprofile( $pmData )
	{
		$this->db->where('comp_id', $pmData['comp_id']);
		$this->db->update('job_company', $pmData);
			
		return $pmData['comp_id'];
		
	}
	
	function updatepassword( $pmData, $pmData1) {
		$this->db->from('job_company_user');
			
		$this->db->where('usrc_status', 1);
		$this->db->where('usrc_id', $pmData1['usrc_id']);
		$this->db->where('usrc_password', md5($pmData1['usrc_old_pwd']));
		$res = $this->db->get();
		$vResult	= $res->result_array();
		
		if ($vResult) {
			$this->db->where('usrc_id', $pmData1['usrc_id']);
			$this->db->update('job_company_user', $pmData);
			
			return true;
			
		} else {
			return false;
		}
	
	}
	
	function updateadminpassword( $pmData, $pmData1) {
		$this->db->from('job_admin');
			
		$this->db->where('usra_status', 1);
		$this->db->where('usra_id', $pmData1['usra_id']);
		$this->db->where('usra_password', md5($pmData1['usra_old_pwd']));
		$res = $this->db->get();
		$vResult	= $res->result_array();
		
		if ($vResult) {
			$this->db->where('usra_id', $pmData1['usra_id']);
			$this->db->update('job_admin', $pmData);
			
			return true;
			
		} else {
			return false;
		}
	
	}
	
	function deleteemployer($id)
	{
				
		$this->db->where('comp_id', $id);
		$this->db->delete('job_company');
	}
	
}	


?>