<?php
class Referfriend_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getreferfriend_list() {
		//return $this->db->order_by('ref_id', 'DESC')->get('job_ref_jobs')->result();
		return $this->db->query('SELECT comp_name, jobs_code, jobs_title, ref_user_id, ref_job_id, count( * ) AS ref_count
								FROM job_jobs_list
								INNER JOIN job_ref_jobs ON jobs_id = ref_job_id
								LEFT JOIN job_company ON comp_id = jobs_comp_id
								AND comp_status =1
								WHERE jobs_status =1
								GROUP BY ref_user_id, ref_job_id')->result();
	}
	
	function getreferfriend_emp_list($pmComp_id = 0) {
		//return $this->db->order_by('ref_id', 'DESC')->get('job_ref_jobs')->result();
		return $this->db->query('SELECT comp_name, jobs_code, jobs_title, ref_user_id, ref_job_id, count( * ) AS ref_count
								FROM job_jobs_list
								INNER JOIN job_ref_jobs ON jobs_id = ref_job_id
								LEFT JOIN job_company ON comp_id = jobs_comp_id
								AND comp_status =1
								WHERE jobs_status =1 AND comp_id = '.$pmComp_id.'
								GROUP BY ref_user_id, ref_job_id')->result();
	}
	
	function viewdetails($pm_job_id = 0, $pm_user_id = 0, $pm_comp_id = 0) {
		//return $this->db->order_by('ref_id', 'DESC')->get('job_ref_jobs')->result();
		if ($pm_comp_id == 0 ) {
			return $this->db->query('SELECT usrd_fname, usrd_lname, user_email, jobs_code, ref_email, ref_subject, ref_message  FROM job_ref_jobs
									INNER JOIN job_jobs_list ON jobs_id = ref_job_id
									INNER JOIN job_user ON ref_user_id = user_id 
									INNER JOIN job_user_details ON usrd_user_id = user_id 
									WHERE ref_user_id = '.$pm_user_id.' AND ref_job_id = '.$pm_job_id)->result();
		} else {
			return $this->db->query('SELECT usrd_fname, usrd_lname, user_email, jobs_code, ref_email, ref_subject, ref_message  FROM job_ref_jobs
									INNER JOIN job_jobs_list ON jobs_id = ref_job_id
									INNER JOIN job_company ON comp_id = jobs_comp_id
									INNER JOIN job_user ON ref_user_id = user_id 
									INNER JOIN job_user_details ON usrd_user_id = user_id 
									WHERE ref_user_id = '.$pm_user_id.' AND comp_id = '.$pm_comp_id.' AND ref_job_id = '.$pm_job_id)->result();
		}						
	}
	
	
	function getreferfriend( $pmLoctId ) {
		return $this->db->where('ref_id', $pmLoctId)->get('job_ref_jobs')->result();
	}
	
	function insertreferfriend($pmData)
	{
		if(!$pmData['stat_id']) 
		{
			$this->db->insert('job_ref_jobs', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('stat_id', $pmData['stat_id']);
			$this->db->update('job_ref_jobs', $pmData);
			return $pmData['stat_id'];
		}
	}
	
	function deletereferfriend($id)
	{
				
		$this->db->where('stat_id', $id);
		$this->db->delete('job_ref_jobs');
	}
	
}	

?>