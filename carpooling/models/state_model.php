<?php
class State_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getstate_list() {
		return $this->db->order_by('stat_id', 'DESC')->get('job_state')->result();
	}
	
	
	function getstate( $pmLoctId ) {
		return $this->db->where('stat_id', $pmLoctId)->get('job_state')->result();
	}
	
	function insertstate($pmData)
	{
		if(!$pmData['stat_id']) 
		{
			$this->db->insert('job_state', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('stat_id', $pmData['stat_id']);
			$this->db->update('job_state', $pmData);
			return $pmData['stat_id'];
		}
	}
	
	function deletestate($id)
	{
				
		$this->db->where('stat_id', $id);
		$this->db->delete('job_state');
	}
	
}	

?>