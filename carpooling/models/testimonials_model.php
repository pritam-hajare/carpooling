<?php
Class Testimonials_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct()
	{
			parent::__construct();
		 
		 
	}
	
	/********************************************************************

	********************************************************************/
	
	function get_testimonials($direction='DESC')
	{
		$this->db->order_by('name',$direction);
		
		$result	= $this->db->get('tbl_testimonials');
		
		return $result->result();
	}
	
	function get_testimonial($id)
	{
		
		$result	= $this->db->get_where('tbl_testimonials', array('id'=>$id));
		return $result->row();
	}
	
	function save($company)
	{
		if ($company['id'])
		{
			$this->db->where('id', $company['id']);
			$this->db->update('tbl_testimonials', $company);
			return $company['id'];
		}
		else
		{
			$this->db->insert('tbl_testimonials', $company);
			return $this->db->insert_id();
		}
	}
	
	
	
	function delete($id)
	{
		/*
		deleting a provider will remove all their orders from the system
		this will alter any report numbers that reflect total sales
		deleting a provider is not recommended, deactivation is preferred
		*/
		
		//this deletes the providers record
		$this->db->where('id', $id);
		$this->db->delete('tbl_testimonials');		
	
	}
	
	
}