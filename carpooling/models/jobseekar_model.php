<?php
class Jobseekar_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	function insertjobseeker($pmData, $pmData1) {
		
		if(!$pmData['user_id']) 
		{
			$this->db->insert('job_user', $pmData);
			$vInsertId	= $this->db->insert_id();
			
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
				return true;
			}
		} else {
			$this->db->where('user_id', $pmData['user_id']);
			$this->db->update('job_user', $pmData);
			
			$this->db->where('usrd_user_id', $pmData['user_id']);
			$this->db->update('job_user_details', $pmData1);
			return $pmData['user_id'];
		}
		
		return $vInsertId;		
	}

	function get_category_list() {
		return $this->db->order_by('cate_name', 'ASC')->get('job_category')->result();
	}
		
	function get_company_list() {
		return $this->db->order_by('comp_name', 'ASC')->get('job_company')->result();
	}
		
	function get_location_list() {
		return $this->db->order_by('loct_name', 'ASC')->get('job_location')->result();
	}
	
	function get_qualification_list() {
		return $this->db->order_by('qual_name', 'ASC')->get('job_qualification')->result();
	}
	
	function get_skils_list() {
		return $this->db->order_by('kysk_name', 'ASC')->get('job_keyskills')->result();
	}
	
	function get_jobseekar_list() {
		$this->db->from('job_user_details');
		//$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_user", "usrd_user_id=user_id");
		$this->db->where('usrd_status', 1);
		$this->db->where('user_status', 1);
		
		$res = $this->db->get();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function get_jobs( $pm_jobs_id) {
		$this->db->from('job_jobs_list');
		$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_company", "comp_id=jobs_comp_id");
		$this->db->where('jobs_status', 1);
		$this->db->where('loct_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('jobs_id', $pm_jobs_id);
		$res = $this->db->get();
		return $res->result_array();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function get_jobseekar_recent_list() {
		$this->db->from('job_user_details');
		//$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_user", "usrd_user_id=user_id");
		$this->db->where('usrd_status', 1);
		$this->db->where('user_status', 1);
		$this->db->order_by('user_id', 'DESC');
		$this->db->limit(10);
		
		$res = $this->db->get();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function get_jobseekar( $pm_user_id) {
		$this->db->from('job_user');
		$this->db->join("job_user_details", "user_id=usrd_user_id");
		$this->db->where('usrd_status', 1);
		$this->db->where('user_status', 1);
		$this->db->where('user_id', $pm_user_id);
		$res = $this->db->get();
		return $res->result_array();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	
	function insertjobs($pmData)
	{
		if(!$pmData['jobs_id']) 
		{
			$this->db->insert('job_jobs_list', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('jobs_id', $pmData['jobs_id']);
			$this->db->update('job_jobs_list', $pmData);
			return $pmData['jobs_id'];
		}
	}	
	function deletejobseekar($id)
	{
				
		$this->db->where('user_id', $id);
		$this->db->delete('job_user');
	}	
}

?>	