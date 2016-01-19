<?php
class Admin_user_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
		
	function get_jobs_list() {
		$this->db->from('job_jobs_list');
		$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_company", "comp_id=jobs_comp_id");
		$this->db->where('jobs_status', 1);
		$this->db->where('loct_status', 1);
		$this->db->where('comp_status', 1);
		$res = $this->db->get();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function get_admin_user_list( ) {
		$this->db->from('job_admin');	
		$this->db->where('usra_status', 1);		
		$res = $this->db->get();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function check_valid( $pmEmail) {
		$this->db->from('job_admin');
		$this->db->where('usra_status', 1);		
		$this->db->where('usra_email', $pmEmail);
		$res = $this->db->get();
		return $res->num_rows();
		
		
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
		
	}
	
	function insertuser($pmData)
	{
		if(!$pmData['usra_id']) 
		{
			$this->db->insert('job_admin', $pmData);
			return $this->db->insert_id();
		} 		
	}
			
	function deleteuser($pmUserId)
	{
		$this->db->where('usra_id', $pmUserId);
		$this->db->delete('job_admin');
				
	}		
}

?>	