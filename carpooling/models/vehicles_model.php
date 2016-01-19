<?php
Class Vehicles_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	function __construct()
	{
			parent::__construct();
		 
		 
	}
	
	/********************************************************************

	********************************************************************/
	
	function get_vehicles($limit=0, $offset=0, $order_by='tbl_vechicle_types.vechicle_type_id', $direction='DESC')
	{
		
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		$this->db->join('tbl_category','tbl_category.category_id = tbl_vechicle_types.category_id');

		$result	= $this->db->get('tbl_vechicle_types');
		
		return $result->result();
	}
	
	function getcity_list() 
	{
		$this->db->order_by('vechicle_type_id', 'ASC');
		$this->db->select('tbl_vechicle_types.*,tbl_category.category_name');
		$this->db->join('tbl_category','tbl_category.category_id = tbl_vechicle_types.category_id');
		$data= $this->db->get('tbl_vechicle_types');
		return $data->result();
	}
	
	function get_vehicle($typeid)
	{
		
		$result	= $this->db->get_where('tbl_vechicle_types', array('vechicle_type_id'=>$typeid));
		return $result->row();
	}
	
	function count_vehicles()
	{
		$this->db->join('tbl_category','tbl_category.category_id = tbl_vechicle_types.category_id');
			return $this->db->count_all_results('tbl_vechicle_types');
	}
	
	function check_vehicles($id)
	{
		return $this->db->where('vechicle_type_id', $id)->get('tbl_vehicle')->result();
	}	
	
	
	function check_vehicle($str, $id=false)
	{
	
		$this->db->select('vechicle_type_name');
		$this->db->from('tbl_vechicle_types');
		$this->db->where('vechicle_type_name', $str);
		if ($id)
		{
			$this->db->where('vechicle_type_id !=', $id);
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
	
	function save($vehicle)
	{
		
		if ($vehicle['vechicle_type_id'])
		{
			$this->db->where('vechicle_type_id', $vehicle['vechicle_type_id']);
			$this->db->update('tbl_vechicle_types', $vehicle);
			return $vehicle['vechicle_type_id'];
		}
		else
		{
			$this->db->insert('tbl_vechicle_types', $vehicle);
			return $this->db->insert_id();
		}
	}
	function delete($vechicle_type_id)
	{
		    $this->db->where('vechicle_type_id',$vechicle_type_id);
			$this->db->delete('tbl_vechicle_types');
	}
        
        function delete_image($img_name)
        {
            $image	= $this->get_image_by_name($img_name);
            if ($image)
            {
                
                $image['vechicle_image'] = '';
                $this->save($image);
                return true;                
            }               
        }
        
        function get_image_by_name($img_name)
        {
            
            $this->db->where('vechicle_image', $img_name);
            $result = $this->db->get('tbl_vechicle_types');
            $result = $result->row_array();
            return $result;
            
        }
	

}