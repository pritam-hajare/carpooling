<?php
class Vechicle_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getvechicletype_list() 
	{
		return $this->db->order_by('vechicle_type_id', 'DESC')->get('tbl_vechicle_types')->result();
	}
	function getvechicle_list($id) 
	{
		$this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id');
		$this->db->join('tbl_category','tbl_category.category_id = tbl_vechicle_types.category_id');
		$this->db->where('user_id',$id);	
		return $this->db->get('tbl_vehicle')->result();
	} 
	
	function get_image($c_id)
	{
		$this->db->where('vechicle_type_id',$c_id);
		$result = $this->db->get('tbl_vechicle_types');
		$result = $result->row();
		//$result->vechicle_image;
		$source = '<img src=" '. base_url('uploads/vechicle/profiles/'.$result->vechicle_image).'" alt="current"/>
                    <br/> Default Image';
		return $source;
	}
	
	
	function get_type($id) 
	{
		//$this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id');
		$this->db->where('category_id',$id);	
		return $this->db->get('tbl_vechicle_types')->result();
	} 
	
	function getvechicle($id)
	{
		
		$this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id');
		$result	= $this->db->get_where('tbl_vehicle', array('tbl_vehicle.vechicle_id '=>$id));
		return $result->row();
	}
	
	function check($v_id)
	{
		$this->db->where('trip_vehicle_id',$v_id);
		$query = $this->db->get('tbl_trips');
		//echo $this->db->last_query();
		if($query->num_rows > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		//die;
	}
	
	
	function save($pmData)
	{
		if(!$pmData['vechicle_id']) 
		{
			$this->db->insert('tbl_vehicle', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('vechicle_id', $pmData['vechicle_id']);
			$this->db->update('tbl_vehicle', $pmData);
			return $pmData['vechicle_id'];
		}
	}
	
	function getstate_list() 
	{
		return $this->db->order_by('stateid', 'DESC')->get('tbl_state')->result();
	}
	
	function getcities($data,$order_by='prodid', $direction='DESC') 
	{
		$temp = array();
		$this->db->order_by($order_by, $direction);
		$view = $this->db->get('tbl_city');
		$result=$view->result_array();
		if($result)
			{
			$i=0;
	
				foreach( $result as $key => $row )
				{
					$id = $this->db->select('stateid')->where('cityid',$row['cityid'])->get('tbl_city');
					$stateid=$id->row()->stateid;
					$temp['state_'.$row['cityid']]=$this->db->select('statename')->where('stateid',$stateid)->get('tbl_state')->row()->statename;
				}
			}
			$data['city_list']=$result;
			$data['state_list']=$temp;
			//print_r($data);
//			die;
			return $data;
	}
	
	function getcity( $pmLoctId ) 
	{
		 $result = $this->db->where('cityid', $pmLoctId)->get('tbl_city');
		 return $result->row();
	}
	
	function city_autocomplete($name, $limit)
	{
		return $this->db->like('cityname', $name)->get('tbl_city', $limit)->result();
		//echo $this->db->last_query();
	}
	
	
	
	function deletecity($id)
	{
				
		$this->db->where('cityid', $id);
		$this->db->delete('tbl_city');
	}
	
	
	function get_type_list($cid)
	{
		    $this->db->select('vechicle_type_id,vechicle_type_name');
			$this->db->where('category_id', $cid);
                        $this->db->where('tbl_vechicle_types.isactive','1');
			$data = $this->db->get('tbl_vechicle_types');
			//return $data->result();
			$type = array();
	 if($data->result())
	 {
		  foreach ($data->result() as $location) 
		  {
			  $type[$location->vechicle_type_id ] = $location->vechicle_type_name ;
		  }
	  return $type;
	  }
	  else
	  {
		  return FALSE;
	  }
	}
	
}	

?>