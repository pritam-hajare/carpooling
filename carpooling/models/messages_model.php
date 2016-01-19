<?php
Class Messages_model extends CI_Model
{
	function __construct()
	{
			parent::__construct();
	}
	
	
	function get_list($limit=0, $offset=0, $order_by='tplid', $direction='ASC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		
		$res = $this->db->get('tbl_email_template');
		return $res->result_array();
	}
	
	function count_messages()
	{
		return $this->db->count_all_results('tbl_email_template');
	}
	
	function get_message($id)
	{
		$res = $this->db->where('tplid', $id)->get('tbl_email_template');
		return $res->row_array();
	}
	
	function save_message($data)
	{
		if($data['tplid'])
		{
			$this->db->where('tplid', $data['tplid'])->update('tbl_email_template', $data);
			return $data['tplid'];
		}
		else 
		{
			$this->db->insert('tbl_email_template', $data);
			return $this->db->insert_id();
		}
	}
	
	function delete_message($id)
	{
		$this->db->where('tplid', $id)->delete('tbl_email_template');
		return $id;
	}
	
	
}