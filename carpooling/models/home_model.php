<?php 

class Home_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
		
	function getbanner()
	{
		$this->db->order_by('id', 'RANDOM');
		$this->db->where('count != 0');
		$this->db->where('isactive',1);
    	$this->db->limit(1);
    	$query = $this->db->get('banners');
		/*echo $this->db->last_query();
		die;*/
		/*print_r($query->result());
		die;*/
			$result = $query->result_array();
			if($result){
			$save['id'] = $result[0]['id'];
			$save['count'] =  $result[0]['count'] - 1;
			$id = $this->save_banner($save);
		return  $result;
		
		}else
		{
			return false;
		}
		
		
	}
	
	function save_banner($save)
	{
		if ($save['id'])
		{
			$this->db->where('id', $save['id']);
			$this->db->update('banners', $save);
			return $save['id'];
		}
		else
		{
			$this->db->insert('banners', $save);
			return $this->db->insert_id();
		}
	}
	
	function get_recently_trip_list($limit=0,$data,$order_by='trip_id', $direction='DESC')
	{
		
		$temp = array();
		$result = $this->db->query("SELECT tbl_trips.trip_id, max(tbl_trips.`trip_id`) as MostRecentid,
			   substring_index(group_concat(tbl_users.user_id), ',', 1) as MostRecentUser
		FROM tbl_trips JOIN
			 tbl_users
			 ON tbl_users.user_id = tbl_trips.trip_user_id                         
		GROUP BY tbl_trips.trip_user_id		
		ORDER BY max(tbl_trips.`trip_id`) DESC LIMIT ".$limit);
	/*	echo $this->db->last_query();
		die;*/
		$result = $result->result_array();
		
		if($result)
		{
			$i=0;

			foreach( $result as $key => $row )
			{
				
				
				$temp[] = $this->db->join('tbl_users','tbl_users.user_id = tbl_trips.trip_user_id')->join('tbl_t_trip_legs','tbl_t_trip_legs.trip_id = tbl_trips.trip_id')->where('tbl_trips.trip_id',$row['MostRecentid'])->group_by('tbl_t_trip_legs.trip_id')->get('tbl_trips')->row_array();
				
			}
		}
		
		$data['recent_trips'] = $temp;
		/*echo'<pre>';print_r($data);echo'</pre>';
		die;*/
		return $data;
		/*echo $this->db->last_query();
		die;
		
		*/
		
	}
	
	function get_testimonials($limit=0,$order_by='id', $direction='RANDOM')
	{
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit);
		}
		$this->db->where('isactive','1');
		$result	= $this->db->get('tbl_testimonials');
		/*echo $this->db->last_query();
		die;*/		
		return $result->result_array();
	}
}	

?>