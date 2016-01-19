<?php
class Notification_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_notification_list() {
		return $this->db->order_by('noti_id', 'DESC')->get('job_notification')->result();
	}
	
	
	function getcity( $pmLoctId ) {
		return $this->db->where('city_id', $pmLoctId)->get('job_city')->result();
	}
	
	function insertmessage($pmData)
	{
		if(!$pmData['noti_id']) 
		{
			$this->db->insert('job_notification', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('noti_id', $pmData['noti_id']);
			$this->db->update('job_notification', $pmData);
			return $pmData['noti_id'];
		}
	}
	
	function deletenotification($id)
	{
				
		$this->db->where('noti_id', $id);
		$this->db->delete('job_notification');
	}
	
}	

?>