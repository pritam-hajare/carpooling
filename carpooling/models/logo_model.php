<?php
Class Logo_model extends CI_Model
{
	function __construct()
	{
			parent::__construct();
		  
	}
	
	function get_logo($id)
	{
		$this->db->where('id',$id);
		$result = $this->db->get('tbl_logo');
		$result = $result->row();
		return $result;
	}
	
	function save($logo)
	{
	
        
		
		if ($logo['id'])
		{
			$this->db->where('id', $logo['id']);
			$this->db->update('tbl_logo', $logo);
			return $logo['id'];
		}
		else
		{
			$this->db->insert('tbl_logo', $logo);
			return $this->db->insert_id();
		}
	}
}
