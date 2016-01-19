<?php
class City_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function getcity_list() {
		return $this->db->order_by('city_id', 'DESC')->get('job_city')->result();
	}
	function getstate_list() {
		return $this->db->order_by('stateid', 'DESC')->get('tbl_state')->result();
	}
	
	function getcities($data,$order_by='prodid', $direction='DESC') {
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
	
	function getcity( $pmLoctId ) {
		 $result = $this->db->where('cityid', $pmLoctId)->get('tbl_city');
		 return $result->row();
	}
	
	function city_autocomplete($name, $limit)
	{
		return $this->db->like('cityname', $name)->get('tbl_city', $limit)->result();
		//echo $this->db->last_query();
	}
	
	function insertcity($pmData)
	{
		if(!$pmData['cityid']) 
		{
			$this->db->insert('tbl_city', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('cityid', $pmData['cityid']);
			$this->db->update('tbl_city', $pmData);
			return $pmData['cityid'];
		}
	}
	
	function deletecity($id)
	{
				
		$this->db->where('cityid', $id);
		$this->db->delete('tbl_city');
	}
	
}	

?>