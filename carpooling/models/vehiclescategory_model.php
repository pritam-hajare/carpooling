<?php
Class Vehiclescategory_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;

	function __construct()
	{
			parent::__construct();
		 
		 
	}
	
	/********************************************************************

	********************************************************************/
	
	function get_category($limit=0, $offset=0, $order_by='category_id', $direction='DESC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('tbl_category');
		
		return $result->result();
	}
	
	function get_categories($typeid)
	{
		
		$result	= $this->db->get_where('tbl_category', array('category_id'=>$typeid));
		return $result->row();
	}
	
	function getcategory_list()
	{
            return $this->db->order_by('category_name', 'ASC')->where('is_active','1')->get('tbl_category')->result();	
	}
	
	function save($category)
	{
		if ($category['category_id'])
		{
			$this->db->where('category_id', $category['category_id']);
			$this->db->update('tbl_category', $category);
			return $category['category_name'];
		}
		else
		{
			$this->db->insert('tbl_category', $category);
			return $this->db->insert_id();
		}
	}
	
	function deactivate($prodid)
	{
		$provider	= array('prodid'=>$prodid, 'active'=>0);
		$this->save_provider($provider);
	}
	
	function check_vehicle($id)
	{
	return $this->db->where('category_id', $id)->get('tbl_vechicle_types')->result();
	}	
	
	function delete($prodid)
	{
		
		$this->db->where('category_id', $prodid);
		$this->db->delete('tbl_category');
		
	}
	
	
}