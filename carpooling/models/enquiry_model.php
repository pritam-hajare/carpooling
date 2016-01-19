<?php
Class Enquiry_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	

	
	function get_enquiry($provid)
	{
		$this->db->select();
		$this->db->join('tbl_projects', 'tbl_projects.projid = tbl_provider_enquires.project_id');
		$this->db->join('tbl_msiteuser', 'tbl_msiteuser.isiteuser = tbl_provider_enquires.student_id');			
		$this->db->where('provider_id', $provid);
		$this->db->limit(5);
		
		return $this->db->get('tbl_provider_enquires')->result();
		//die;
	}
	
	function count_enquiry()
	{
		return $this->db->count_all_results('tbl_enquires');
	}
	
	
	

	function get_enquires_list($id)
	{
		$this->db->join('tbl_trips', 'tbl_trips.trip_id = tbl_enquires.enquiry_trip_id');
		$this->db->join('tbl_users', 'tbl_users.user_id = tbl_enquires.enquiry_passanger_id');
		$this->db->join('tbl_vehicle','tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');
		$this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id ');
		$this->db->where('tbl_enquires.enquire_travel_id', $id);
		//$this->db->get('tbl_enquires');
		return $this->db->get('tbl_enquires')->result();
	    /*echo $this->db->last_query();
		die;*/
		
	}
		
}