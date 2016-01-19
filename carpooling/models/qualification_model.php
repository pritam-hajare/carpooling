<?php
class Qualification_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getqualification_list() {
		return $this->db->order_by('qual_id', 'DESC')->get('job_qualification')->result();
	}
	
	
	function getqualification( $pmLoctId ) {
		return $this->db->where('qual_id', $pmLoctId)->get('job_qualification')->result();
	}
	
	function insertqualification($pmData)
	{
		if(!$pmData['qual_id']) 
		{
			$this->db->insert('job_qualification', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('qual_id', $pmData['qual_id']);
			$this->db->update('job_qualification', $pmData);
			return $pmData['qual_id'];
		}
	}
	
	function deletequalification($id)
	{
				
		$this->db->where('qual_id', $id);
		$this->db->delete('job_qualification');
	}
	
}	

?>