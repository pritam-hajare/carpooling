<?php
class Keyskills_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getkeyskills_list() {
		return $this->db->order_by('kysk_id', 'DESC')->get('job_keyskills')->result();
	}
	
	
	function getkeyskills( $pmLoctId ) {
		return $this->db->where('kysk_id', $pmLoctId)->get('job_keyskills')->result();
	}
	
	function insertkeyskills($pmData)
	{
		if(!$pmData['kysk_id']) 
		{
			$this->db->insert('job_keyskills', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('kysk_id', $pmData['kysk_id']);
			$this->db->update('job_keyskills', $pmData);
			return $pmData['kysk_id'];
		}
	}
	
	function deletekeyskills($id)
	{
				
		$this->db->where('kysk_id', $id);
		$this->db->delete('job_keyskills');
	}
	
	
}	