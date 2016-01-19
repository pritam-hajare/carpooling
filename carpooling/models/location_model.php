<?php
class Location_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getlocation_list() {
		return $this->db->order_by('loct_id', 'DESC')->get('job_location')->result();
	}
	
	
	function getlocation( $pmLoctId ) {
		return $this->db->where('loct_id', $pmLoctId)->get('job_location')->result();
	}
	
	function insertlocation($pmData)
	{
		if(!$pmData['loct_id']) 
		{
			$this->db->insert('job_location', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('loct_id', $pmData['loct_id']);
			$this->db->update('job_location', $pmData);
			return $pmData['loct_id'];
		}
	}
	
	function deletelocation($id)
	{
				
		$this->db->where('loct_id', $id);
		$this->db->delete('job_location');
	}
	
		function get_location_menu()
	{	
		
		$this->db->select('job_location.loct_id,job_location.loct_name,count(loct_id) as loctcnt');
			$this->db->join('job_jobs_list', 'job_jobs_list.jobs_location = job_location.loct_id');
			 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	 $this->db->join('job_company_user', 'job_jobs_list.jobs_usrc_id = job_company_user.usrc_id');
			$this->db->group_by('loct_id');
			
	
			
           $query = $this->db->get('job_location');
		 //  echo  $this->db->last_query();
	        $result=$query->result();
			
			return $result;
	}
	
}	

?>