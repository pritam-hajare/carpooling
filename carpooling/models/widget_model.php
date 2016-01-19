<?php
Class Widget_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct()
	{
			parent::__construct();
			$this->load->helper('date');	
			date_default_timezone_set("Asia/Kolkata");
	}
	
	/********************************************************************

	********************************************************************/
	
	
	
	function get_allwidgets()
	{
		
		$result = $this->db->get('tbl_widgets');
		return $result->result_array();

	}
	
	function get_widget($pid=0){

	$this->db->select('*');
	$this->db->where('tbl_widgets.id',$pid);
	return $this->db->get('tbl_widgets')->row();
	
	}		
	
	
	function save($trip)
	{
		if ($trip['id'])
		{
			$this->db->where('id', $trip['id']);
			$this->db->update('tbl_widgets', $trip);
			return $trip['id'];
		}
		else
		{
			$this->db->insert('tbl_widgets', $trip);
			return $this->db->insert_id();
		}
	}
	
	
}