<?php
class Emp_user_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
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
	
	function get_company_user_list( $pmCompId) {
		$this->db->from('job_company_user');
		$this->db->join("job_company", "comp_id=usrc_comp_id");
		$this->db->where('usrc_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('comp_id', $pmCompId);
		$res = $this->db->get();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function check_valid( $pmEmail, $pmId) { 
		return $this->db->query('SELECT usrc_id FROM job_company_user 
									INNER JOIN job_company ON comp_id=usrc_comp_id WHERE usrc_status = 1 AND comp_status = 1
									AND usrc_email = "'.$pmEmail.'" AND usrc_id != '. $pmId)->num_rows();
							
							
		/*<!--$this->db->from('job_company_user');
		$this->db->join("job_company", "comp_id=usrc_comp_id");
		$this->db->where('usrc_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('usrc_email', $pmEmail);
		$res = $this->db->get();
		return $res->num_rows();-->*/
		
		
	}
	
	function check_access_count( $pm_comp_id) {
		$this->db->from('job_company_user');
		$this->db->join("job_company", "comp_id=usrc_comp_id");
		$this->db->where('usrc_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('comp_id', $pm_comp_id);
		$res = $this->db->get();
		$vCurrentAccess	= $res->num_rows();
		
		$this->db->from('job_company_user');
		$this->db->join("job_company", "comp_id=usrc_comp_id");
		$this->db->where('usrc_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('comp_id', $pm_comp_id);
		$res = $this->db->get();
		$vTotalAccess	= $res->result_array();
		
		if ($vCurrentAccess >= $vTotalAccess[0]['comp_total_access'])
			return 1;
		else  
			return 0;
			
		
	}
	
	function get_user( $pm_user_id, $pmCompId) {
	
	$this->db->from('job_company_user');
		$this->db->join("job_company", "comp_id=usrc_comp_id");
		$this->db->where('usrc_status', 1);
		$this->db->where('usrc_id', $pm_user_id);
		$this->db->where('comp_status', 1);
		$this->db->where('comp_id', $pmCompId);
		$res = $this->db->get();
		return $res->result_array();
		
		
		/*$this->db->from('job_jobs_list');
		$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_company", "comp_id=jobs_comp_id");
		$this->db->where('jobs_status', 1);
		$this->db->where('loct_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('jobs_id', $pm_jobs_id);
		$res = $this->db->get();
		return $res->result_array();*/		
		
	}
	
	function insertuser($pmData)
	{
		if(!$pmData['usrc_id']) 
		{
			$this->db->insert('job_company_user', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('usrc_id', $pmData['usrc_id']);
			$this->db->update('job_company_user', $pmData);
			return $pmData['usrc_id'];
		}
	}
			
	function deleteuser($pmUserId)
	{
		$this->db->where('usrc_id', $pmUserId);
		$this->db->delete('job_company_user');
				
	}		
}

?>	