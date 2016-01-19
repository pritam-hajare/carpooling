<?php
Class Trip_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct()
	{
			parent::__construct();
			$this->load->helper('date');	
			
	}
	
	/********************************************************************

	********************************************************************/
	
	
	function get_recent_trip($limit='',$order_by='trip_id', $direction='DESC')
	{
		if($limit !='')
		{
			$this->db->limit($limit);
		}
		$this->db->order_by($order_by, $direction);
		$query = $this->db->get('tbl_trips');
		$result =  $query->result_array();
		return $result;
		
	}
	
	function get_trips($uid=0,$data)
	{
		$cdate = date('Y/m/d');
		$this->db->join('tbl_vehicle','tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');
		$this->db->join('tbl_users','tbl_users.user_id = tbl_trips.trip_user_id');
		$this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id ');
		$this->db->where('tbl_trips.trip_user_id',$uid);
		//$this->db->where('tbl_trips.trip_frequncy != ""');
		//$this->db->where('tbl_trips.trip_casual_date > "'.$cdate.'"'); 
		$query_val = "(tbl_trips.trip_frequncy != '' OR tbl_trips.trip_casual_date >='".$cdate."')";
		$this->db->where($query_val); 		
		$query = $this->db->get('tbl_trips');
		$result =  $query->result_array();
		//echo $this->db->last_query(); die;
		$temp = array();
		if($result)
		{
		
			foreach( $result as $key => $row )
			{
				
				if($row['trip_routes'])
				{
					
					$trip_route_ids = explode('~',$row['trip_routes']);				 							
					array_shift($trip_route_ids);
					array_pop($trip_route_ids);
					$ids = array();
					foreach($trip_route_ids as $route)
					{	 				 
						 $ids[] = $route;					 
					}
					
					$temp['route_'.$row['trip_id']] = $ids;
				}
				$temp['leg_'.$row['trip_id']] = $this->db->order_by('trip_led_id','ASC')->get_where('tbl_t_trip_legs', array('trip_id'=>$row['trip_id']))->result_array();
			}
		}
		
		$data['legdetails'] = $temp;
			
		$data['trip_details'] =$result;
		/*echo "<pre>";print_r($data);echo "<pre/>";
		die;*/
		return $data;

	}
	function get_trip($pid=0)
	{

	$this->db->select('*');	

	$this->db->join('tbl_vehicle','tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');

	$this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id ');
	
    $this->db->join('tbl_users','tbl_users.user_id = tbl_trips.trip_user_id');
	$this->db->where('tbl_trips.trip_id',$pid);

	
	return $this->db->get('tbl_trips')->row();

	/*echo $this->db->last_query();

	die;
*/
	}	
	
	
	function get_tripdetail($id)
	{
		$this->db->select('*');			
		$this->db->join('tbl_trips','tbl_trips.trip_id = tbl_t_trip_legs.trip_id','inner');
		$this->db->join('tbl_users','tbl_users.user_id = tbl_trips.trip_user_id','inner');
		$this->db->join('tbl_vehicle','tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id','inner');
		$this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id','inner');	
   		$this->db->where('tbl_t_trip_legs.trip_led_id',$id);	
		return $this->db->get('tbl_t_trip_legs')->row_array();
		
	}
	function get_vehicle($vid)
	{
	$result	= $this->db->get_where('tbl_vehicle', array('vechicle_id'=>$vid));
		return $result->row();	
	}
	
	function get_triped($userid)
	{
		$this->db->join('tbl_vehicle','tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');
		$result	= $this->db->get_where('tbl_trips', array('trip_id'=>$userid));
		return $result->row();
	}
	
		
		function get_city_list()	
		{ 
			return $this->db->order_by('cityname', 'ASC')->get('tbl_city')->result();
    }


	function get_alltrips($limit=0, $offset=0, $order_by='trip_id', $direction='DESC',$data) 
	 {
	  $this->db->order_by($order_by, $direction);
	  if($limit>0)
	  {
	   $this->db->limit($limit, $offset);
	
	  }
	  $this->db->join('tbl_vehicle','tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');
	  $this->db->join('tbl_users','tbl_users.user_id = tbl_trips.trip_user_id');
	  $this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id ');
	  $query = $this->db->get('tbl_trips');	 
	  $result =  $query->result_array();
	  $temp = array();
		if($result)
		{
		
	
			foreach( $result as $key => $row )
			{
				$temp['leg_'.$row['trip_id']] = $this->db->get_where('tbl_t_trip_legs', array('trip_id'=>$row['trip_id']))->result_array();
			}
		}
		
		$data['legdetails'] = $temp;
			
		$data['trip_details'] =$result;
		/*echo "<pre>";print_r($data);echo "<pre/>";
		die;*/
		return $data;
	 }


	function count_trips()
	{
		
		$this->db->join('tbl_vehicle','tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');
	 	$this->db->join('tbl_users','tbl_users.user_id = tbl_trips.trip_user_id');
	  	$this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id ');
	  	return $this->db->count_all_results('tbl_trips');
		
	}
	
	
	function save($trip)
	{
		if ($trip['trip_id'])
		{
			$this->db->where('trip_id', $trip['trip_id']);
			$this->db->update('tbl_trips', $trip);
			return $trip['trip_id'];
		}
		else
		{
			$dats['trip_created_date'] = date('Y-m-d H:i:s',now());
			$this->db->insert('tbl_trips', $trip);
			return $this->db->insert_id();
		}
	}
	
	function check_trip($param)
	{
		
		 $querycon = '( "'.$param['time'].'" BETWEEN `trip_depature_time` AND `trip_return_time`)';				 
		 $this->db->where($querycon);
		 $this->db->where('trip_vehicle_id',$param['vechicle_id']);
		 if(!empty($param['tripid'])){
		 	 $querycon ='trip_id != '.$param['tripid'];
		  	 $this->db->where($querycon);
		 }
		 
		 $frequency = $param['frequency'];
		if($frequency !="")
		{
			
			$str = explode(',',$frequency);
			$querycon = "(";
			foreach ($str as $k => $tmpdept)
			 { 
				if($querycon != "(")
				{
				$querycon .=" OR ";
				 }
				 $querycon .="tbl_trips.trip_frequncy like '%".$tmpdept."%'";
	 
			}
			$querycon .= ")";
			$this->db->where($querycon);
		}
		
		if(!empty($param['date']))
		{
			
			$freq = $param['date_frequency'];
			if($freq !="")
			{
				
			$str = explode(',',$freq);
			$querycon = "(";
			foreach ($str as $k => $tmpdept)
			 { 
				if($querycon != "(")
				{
				$querycon .=" OR ";
				 }
				 $querycon .="tbl_trips.trip_frequncy like '%~".$tmpdept."~%'";
	 
			}
			//$querycon .= ")";
			//$this->db->where($querycon);
			
			//$querycon = "(";
			$querycon .=" OR ";		
			$querycon .="tbl_trips.trip_casual_date = '".$param['date']."'";
			$querycon .= ")";
			$this->db->where($querycon);
			}
			
		}
		
		
		
		 $query = $this->db->get('tbl_trips');
		/*  echo $this->db->last_query();
		die;*/
		
		 if($query->num_rows > 0)
		 {
		 	return true;
		 }
		 else
		 {
		 	return false;
		 }
		 
		
	}
	
	function getmap_details($tripid,$data='')
	{
		$temp = array();
		$this->db->where('tbl_trips.trip_id',$tripid);	
		$result = $this->db->get('tbl_trips')->row();
		//print_r($data->trip_routes_lat_lan);
		/*$temp['latlong']=explode(',',str_replace('~','',$data->trip_routes_lat_lan));
		array_shift($$temp['latlong']);
		array_pop($temp['latlong']);
		$route = $temp['latlong'];*/
		
		if(!empty($result))
		{
			$lanlat = explode('~,',rtrim($result->trip_routes_lat_lan,'~'));
			$data['last'] = sizeof($lanlat);			
			foreach($lanlat as $lat)
			{
				
				 $latlong[] = ltrim($lat,'~');
				
			}
			$data['latlong']	= $latlong;
			$route_lanlat = explode('~,',$result->trip_routes_lat_lan);											
			array_shift($route_lanlat);
			array_pop($route_lanlat);
			$latlan = array();
			foreach($route_lanlat as $route)
			{
				
				 $latlan[] = ltrim($route,'~');
				
			}
			$data['route']	= $latlan;
			$source = ltrim($result->trip_from_latlan,'~');
			$source = rtrim($source,'~');
			$data['origin']= $source;
			$destination = ltrim($result->trip_to_latlan,'~');
			$destination = rtrim($destination,'~');
			$data['destination']=$destination;
		
			return $data;
			
		}
		else
		{
			return false;
		}
		
	}
	
	
	
	function delete($userid)
	{
		
		$this->db->where('user_id', $userid);
		$this->db->delete('tbl_users');
	
	}
	
	function check_email($str, $id=false)
	{
	
		$this->CI->db->select('user_email');
		$this->CI->db->from('tbl_users');
		$this->CI->db->where('user_email', $str);
		if ($id)
		{
			$this->CI->db->where('user_id !=', $id);
		}
		$count = $this->CI->db->count_all_results();
		
		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function save_address($data)
	{
		$this->db->insert('tbl_address', $data);
		return $this->db->insert_id();
	}
	
	function save_tripleg($data)
	{
		if ($data['trip_led_id'])
		{
			$this->db->where('trip_led_id', $data['trip_led_id']);
			$this->db->update('tbl_t_trip_legs', $data);
			return $data['trip_led_id'];
		}
		else
		{
			$data['created_time'] = date('Y-m-d H:i:s',now());
			$this->db->insert('tbl_t_trip_legs', $data);
			return $this->db->insert_id();
		}
		
	}
	
	function delete_legdetils($trip_id)
	{
		$this->db->where('trip_id', $trip_id);
		$this->db->delete('tbl_t_trip_legs');
	}
	
	function get_legdetails($id)
	{
		return $this->db->where('trip_led_id', $id)->get('tbl_t_trip_legs')->row();	
	}
	
	function get_user($tripid)
	{
		return $this->db->where('trip_id', $tripid)->get('tbl_trips')->row();		
	}
	
	function check_legdetils($tripid)
	{
		$this->db->select('trip_return');
		$this->db->where('trip_id',$trip_id);
		$result = $this->db->get('tbl_t_trip_legs');
		$result = $result->result_array();
		return $result;		
	}
        
        function delete_trip_by_edit($trip_id)
	{
		
		$this->db->where('trip_id', $trip_id);
		$query = $this->db->get('tbl_trips');
		if($query->num_rows > 0)
		 {
		 	$row = $query->row_array();
                        
                        $this->delete_legdetils($row['trip_id']);
                        $this->db->where('trip_id', $row['trip_id']);
                        $this->db->delete('tbl_trips');
			
			return $trip_id;
		 }
		 else
		 {
		 	
			return $trip_id;
		 }
		
	}
	
	function delete_trip($trip_id)
	{
		
		$this->db->where('trip_user_id', $trip_id);
		$query = $this->db->get('tbl_trips');
		if($query->num_rows > 0)
		 {
		 	$query = $query->result_array();
			if($query)
			{
				//print_r($query); die;
				foreach($query as $key=>$row)
				{ 
					$this->delete_legdetils($row['trip_id']);
					$this->db->where('trip_id', $row['trip_id']);
					$this->db->delete('tbl_trips');
				}
			}
			return $trip_id;
		 }
		 else
		 {
		 	
			return $trip_id;
		 }
		
	}
	
	function tsave($param)
	{
		$this->db->where('trip_user_id', $param['trip_user_id']);
		$query = $this->db->get('tbl_trips');
		if($query->num_rows > 0)
		 {
		 	$this->db->where('trip_user_id', $param['trip_user_id']);
			$this->db->update('tbl_trips', $param);
			return $param['trip_user_id'];
		 }
		 else
		 {
		 	
			return $param['trip_user_id'];
		 }
		
	}
  function past_trip($uid=0,$data)
  {
	   $cdate = date('Y/m/d');
	  // echo $cdate;
	    $this->db->join('tbl_vehicle','tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');
		$this->db->join('tbl_users','tbl_users.user_id = tbl_trips.trip_user_id');
		$this->db->join('tbl_vechicle_types','tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id ');
		$this->db->where('tbl_trips.trip_user_id',$uid);
		$this->db->where('tbl_trips.trip_frequncy','');
		$this->db->where('tbl_trips.trip_casual_date < "'.$cdate.'"');
		$query = $this->db->get('tbl_trips');
		$result =  $query->result_array();    
		/*echo $this->db->last_query();
		die;*/
		$temp = array();
		if($result)
		{
		

			foreach( $result as $key => $row )
			{
				
				if($row['trip_routes']){
					
					$trip_route_ids = explode('~',$row['trip_routes']);				 							
					array_shift($trip_route_ids);
					array_pop($trip_route_ids);
					$ids = array();
					foreach($trip_route_ids as $route)
					{	 				 
						 $ids[] = $route;					 
					}
					
					$temp['route_'.$row['trip_id']] = $ids;
				}
				$temp['leg_'.$row['trip_id']] = $this->db->order_by('trip_led_id','ASC')->get_where('tbl_t_trip_legs', array('trip_id'=>$row['trip_id']))->result_array();
			}
		}
		
		$data['legdetails'] = $temp;
			
		$data['trip_details'] =$result;
		/*echo "<pre>";print_r($data);echo "<pre/>";
		die;*/
		return $data;

	  
	  
	  
	  
	  
	    /*$this->db->select('trip_casual_date');
		//$this->db->where('trip_id',$trip_id);
		$result = $this->db->get('tbl_trips');
		$result = $result->result_array();
		return $result;*/
  }
		
}