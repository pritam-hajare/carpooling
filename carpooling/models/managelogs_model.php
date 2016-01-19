<?php
class Managelogs_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
		
	function get_applied_jobs_list( $pm_comp_id = 0 ) { 
		
		return $this->db->query('SELECT jobs_id, jobs_code, comp_id, jobs_title, usrc_name AS posted_name, 
							count( appl_user_id ) applied_count, DATE_FORMAT(jobs_posted_date, "%d-%m-%Y") poted_date
							FROM job_jobs_list
							INNER JOIN job_applied_jobs ON appl_job_id = jobs_id
							AND jobs_status =1
							INNER JOIN job_user ON user_id = appl_user_id
							AND user_status =1
							INNER JOIN job_company ON comp_id = jobs_comp_id
							AND comp_status =1
							LEFT JOIN job_company_user ON usrc_id = jobs_usrc_id
							WHERE comp_id ='.$pm_comp_id.'
							GROUP BY jobs_id')->result();
	}
	
	function get_applied_jobs_aadmin_list( ) { 
		
		return $this->db->query('SELECT jobs_id, jobs_code, comp_id, comp_name, jobs_title, usrc_name AS posted_name, 
							count( appl_user_id ) applied_count, DATE_FORMAT(jobs_posted_date, "%d-%m-%Y") poted_date
							FROM job_jobs_list
							INNER JOIN job_applied_jobs ON appl_job_id = jobs_id							 
							INNER JOIN job_user ON user_id = appl_user_id
							AND user_status =1
							INNER JOIN job_company ON comp_id = jobs_comp_id
							AND comp_status =1
							LEFT JOIN job_company_user ON usrc_id = jobs_usrc_id
							WHERE jobs_status =1 GROUP BY jobs_id')->result();
	}
		
	function get_company_recent_applied_jobs_list( $pm_comp_id = 0 ) {

		//$this->db->get_group('jobs_id');
		return $this->db->query('SELECT jobs_id, jobs_code, comp_id, jobs_title, usrc_name AS posted_name, 
							count( appl_user_id ) applied_count, DATE_FORMAT(jobs_posted_date, "%d-%m-%Y") poted_date
							FROM job_jobs_list
							INNER JOIN job_applied_jobs ON appl_job_id = jobs_id
							AND jobs_status =1
							INNER JOIN job_user ON user_id = appl_user_id
							AND user_status =1
							INNER JOIN job_company ON comp_id = jobs_comp_id
							AND comp_status =1
							LEFT JOIN job_company_user ON usrc_id = jobs_usrc_id
							WHERE comp_id ='.$pm_comp_id.'
							GROUP BY jobs_id ORDER BY DATE(appl_job_date) DESC LIMIT 10')->result();
		
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
	
	
	function get_applied_jobs_user_list( $pm_comp_id = 0, $pm_job_id ) { 
		
		return $this->db->query('SELECT jobs_id, jobs_code, usrd_fname, usrd_lname,  comp_id, jobs_title, user_id, usrd_resume_path,
							 appl_user_id, DATE_FORMAT(appl_job_date, "%d-%m-%Y") applied_date, user_email, usrd_mobile_no
							FROM job_jobs_list
							INNER JOIN job_applied_jobs ON appl_job_id = jobs_id
							AND jobs_status =1 
							INNER JOIN job_user ON user_id = appl_user_id
							AND user_status =1
							INNER JOIN job_company ON comp_id = jobs_comp_id
							AND comp_status =1
							INNER JOIN job_user_details ON user_id = usrd_user_id
							WHERE comp_id ='.$pm_comp_id.' AND jobs_id = '.$pm_job_id.'
							')->result_array();
	}
	
	function get_applied_jobs_admin_user_list( $pm_job_id ) { 
		
		return $this->db->query('SELECT jobs_id, jobs_code, usrd_fname, usrd_lname,  comp_id, jobs_title, user_id, usrd_resume_path, 
							 appl_user_id, DATE_FORMAT(appl_job_date, "%d-%m-%Y") applied_date, user_email, usrd_mobile_no
							FROM job_jobs_list
							INNER JOIN job_applied_jobs ON appl_job_id = jobs_id
							AND jobs_status =1 
							INNER JOIN job_user ON user_id = appl_user_id
							AND user_status =1
							INNER JOIN job_company ON comp_id = jobs_comp_id
							AND comp_status =1
							INNER JOIN job_user_details ON user_id = usrd_user_id
							WHERE jobs_id = '.$pm_job_id.'
							')->result_array();
	}
	
	function get_message_list( $pm_user_id = 0, $pm_jobs_id = 0 ) { 
		
		return $this->db->query('SELECT jobs_code, mesg_title, mesg_description, DATE_FORMAT(mesg_date,"%d-%m-%Y") mesg_date, 
								IF(mesg_response = "","-", mesg_response) AS mesg_response, 
								IF (YEAR(mesg_response_date) = 0, "-", DATE_FORMAT(mesg_response_date,"%d-%m-%Y")) AS response_date
								FROM job_message
								INNER JOIN job_jobs_list ON jobs_id = mesg_job_id
								INNER JOIN job_user ON user_id = mesg_usr_id
								WHERE user_id = '.$pm_user_id.' AND jobs_id = '.$pm_jobs_id)->result();
	}
	
	function get_download_profile_list( $pm_comp_id = 0 ) { 
		
		return $this->db->query('SELECT jobs_id, jobs_code, usrd_fname, usrd_lname, usrd_experience,  comp_id, jobs_title, user_id, usrd_resume_path , 
								appl_user_id, DATE_FORMAT(appl_job_date, "%d-%m-%Y") applied_date, user_email, usrd_mobile_no,usrd_nationality
								FROM job_jobs_list
								INNER JOIN job_applied_jobs ON appl_job_id = jobs_id
								AND jobs_status =1 
								INNER JOIN job_user ON user_id = appl_user_id
								AND user_status =1
								INNER JOIN job_company ON comp_id = jobs_comp_id
								AND comp_status =1
								INNER JOIN job_user_details ON user_id = usrd_user_id
								WHERE comp_id ='.$pm_comp_id.' GROUP BY user_id')->result_array();
	}
	
	function get_user_profile_details( $pm_user_id = 0 ) { 
		
		return $this->db->query('SELECT jobs_id, jobs_code, usrd_fname, usrd_lname, usrd_gender, user_email, usrd_mobile_no, usrd_phone_no, 
								usrd_experience,  comp_id, jobs_title, user_id, usrd_skils, usrd_job_type, usrd_function, usrd_current_industry,
								appl_user_id, user_email, usrd_mobile_no, usrd_phone_no, usrd_nationality 
								FROM job_jobs_list
								INNER JOIN job_applied_jobs ON appl_job_id = jobs_id
								AND jobs_status =1 
								INNER JOIN job_user ON user_id = appl_user_id
								AND user_status =1
								INNER JOIN job_company ON comp_id = jobs_comp_id
								AND comp_status =1
								INNER JOIN job_user_details ON user_id = usrd_user_id
								WHERE user_id ='.$pm_user_id.' GROUP BY user_id')->result_array();
	}
	function insertmessage($pmData)
	{
		
		$this->db->insert('job_message', $pmData);
		return $this->db->insert_id();		 
		
	}
	
	function deletejobs($pmJobsId)
	{
		$this->db->where('jobs_id', $pmJobsId);
		$this->db->delete('job_jobs_list');
				
	}
}
?>