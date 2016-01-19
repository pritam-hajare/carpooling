<?php
class Jobs_model extends CI_Model 
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
	
	function get_applied_jobs_list( $pm_comp_id = 0 ) {
		$this->db->query('SELECT jobs_id, comp_id, jobs_title, count( appl_user_id ), DATE_FORMAT(jobs_posted_date, "%d-%m-%Y")
							FROM job_jobs_list
							INNER JOIN job_applied_jobs ON appl_job_id = jobs_id
							AND jobs_status =1
							INNER JOIN job_user ON user_id = appl_user_id
							AND user_status =1
							INNER JOIN job_company ON comp_id = jobs_comp_id
							AND comp_status =1
							WHERE comp_id ='.$pm_comp_id.'
							GROUP BY jobs_id');		
		//$res = $this->db->get();
		return  $this->db->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
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
	
	function get_company_jobs_list( $pm_comp_id = 0 ) {
		$this->db->from('job_jobs_list');
		$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_company", "comp_id=jobs_comp_id");
		$this->db->where('jobs_status', 1);
		$this->db->where('loct_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('comp_id', $pm_comp_id);
		$res = $this->db->get();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function get_company_recent_jobs_list( $pm_comp_id = 0 ) {
		$this->db->from('job_jobs_list');
		$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_company", "comp_id=jobs_comp_id");
		$this->db->where('jobs_status', 1);
		$this->db->where('loct_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('comp_id', $pm_comp_id);
		$this->db->order_by('jobs_id', 'DESC');
		$this->db->limit(10);
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
	
	function deletejobs($pmJobsId)
	{
		$this->db->where('jobs_id', $pmJobsId);
		$this->db->delete('job_jobs_list');
				
	}
}

?>	