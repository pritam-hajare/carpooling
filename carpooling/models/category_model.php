<?php
Class Category_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct()
	{
			parent::__construct();
		 
		 
	}
	
	/********************************************************************

	********************************************************************/
	
	
	
	function all_categories($limit=0, $offset=0, $order_by='category_id', $direction='DESC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('tbl_category');
		//echo $this->db->last_query(); die;
		return $result->result_array();
	}
	
	function count_categories()
	{
		

			return $this->db->count_all_results('tbl_category');
	}
	
	function get_category($typeid)
	{
		
		$result	= $this->db->get_where('tbl_category', array('category_id'=>$typeid));
		return $result->row();
	}
	
	function getcategory_list()
	{
            return $this->db->order_by('category_id', 'ASC')->where('is_active','1')->get('tbl_category')->result();	
	}
	
	function check_category($str, $id=false)
	{
	
		$this->db->select('category_name');
		$this->db->from('tbl_category');
		$this->db->where('category_name', $str);
		if ($id)
		{
			$this->db->where('category_id !=', $id);
		}
		$count = $this->db->count_all_results();
		
		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	
	
	function save($category)
	{
		if ($category['category_id'])
		{
			$this->db->where('category_id', $category['category_id']);
			$this->db->update('tbl_category', $category);
			return $category['category_id'];
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