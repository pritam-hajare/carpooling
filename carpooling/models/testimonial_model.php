<?php
Class Testimonial_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct()
	{
			parent::__construct();
		 
		 
	}
	
	/********************************************************************

	********************************************************************/
	
	function all_testimonials($limit=0, $offset=0, $order_by='name', $direction='ASC')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		
		$result	= $this->db->get('tbl_testimonials');
		
		return $result->result_array();
	}
	
	function count_testimonials()
	{
		return $this->db->count_all_results('tbl_testimonials');
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
        
        function delete_image($img_name)
        {
            $image	= $this->get_image_by_name($img_name);
            if ($image)
            {
                
                $image['image'] = '';
                $this->save($image);
                return true;                
            }               
        }
        
        function get_image_by_name($img_name)
        {
            
            $this->db->where('image', $img_name);
            $result = $this->db->get('tbl_testimonials');
            $result = $result->row_array();
            return $result;
            
        }
	
	
}