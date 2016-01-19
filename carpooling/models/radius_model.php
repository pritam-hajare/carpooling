<?php
Class Radius_model extends CI_Model
{

	
	
	
	function __construct()
	{
			parent::__construct();
		 
		 
	}
	
	/********************************************************************

	********************************************************************/
	
	
	function all_radiues($limit=0, $offset=0, $order_by='distance_from', $direction='ASC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('tbl_radius');
		
		return $result->result_array();
	}
	
	function count_radiues()
	{
			return $this->db->count_all_results('tbl_radius');
	}
	
	function get_radiues()
	{
		
		$result	= $this->db->get('tbl_radius');
		
		return $result->result();
	}
	
	function get_radius($userid)
	{
		
		$result	= $this->db->get_where('tbl_radius', array('id'=>$userid));
		return $result->row();
	}
	
	
	
	function save($company)
	{
		if ($company['id'])
		{
			$this->db->where('id', $company['id']);
			$this->db->update('tbl_radius', $company);
			return $company['id'];
		}
		else
		{
			$this->db->insert('tbl_radius', $company);
			return $this->db->insert_id();
		}
	}
	
	
	
	function delete($prodid)
	{
		
		$this->db->where('id', $prodid);
		$this->db->delete('tbl_radius');
		
		
	}
	
	
}