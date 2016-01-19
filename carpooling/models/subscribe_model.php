<?php
Class Subscribe_model extends CI_Model
{

	/********************************************************************
	Page functions
	********************************************************************/
	
	
	function get_subscriber($id)
	{
		$this->db->where('subscribe_id', $id);
		$result = $this->db->get('tbl_subscribe')->row();
		return $result;
	}
	
	function all_subscribes($limit=0, $offset=0)
	{
		
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('tbl_subscribe');
		
		return $result->result_array();
	}
	function count_subscribes()
	{
		return $this->db->count_all_results('tbl_subscribe');
	}
	
	function delete($id)
	{
		$this->db->where('subscribe_id', $id);
		$this->db->delete('tbl_subscribe');
	}
	
	function save($data)
	{
		if($data['subscribe_id'])
		{
			$this->db->where('subscribe_id', $data['id']);
			$this->db->update('tbl_subscribe', $data);
			return $data['subscribe_id'];
		}
		else
		{
			$this->db->insert('tbl_subscribe', $data);
			return $this->db->insert_id();
		}
	}
	
	function check_email($str)
	{
		$this->db->select('subscribe_email');
		$this->db->from('tbl_subscribe');
		$this->db->where('subscribe_email', $str);		
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

}