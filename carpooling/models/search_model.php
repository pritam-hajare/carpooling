<?php
Class Search_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('string');
	}
	
	
	
	function getSearchResults($param,$offset = NULL,$data,$map=0)
	{
		//calculate distance
		
		$source = $param['fromlatlng'];
		$destination = $param['tolatlng'];		
		if($source !="" && $destination!="")
		{
			
			$source_latlng= explode(',',$source);
			$source_lat = $source_latlng[0];
			$source_lng = $source_latlng[1];
			
			$destination_latlng= explode(',',$destination);
			$destination_lat = $destination_latlng[0];
			$destination_lng = $destination_latlng[1];
			
			$distance = $this->distance($source_lat,$source_lng,$destination_lat,$destination_lng, "K");			
			$this->db->select('tbl_radius.radius');
			$querycon = '( '.$distance.' BETWEEN `distance_from` AND `distance_to`)';
			$this->db->where($querycon);
			$query = $this->db->get('tbl_radius');
			$result = $query->row_array();						
			if (sizeof($result) > 0)
			{
				
				$radius = $result['radius'];
                                if($radius == ''){
                                    $radius = 5;
                                }
			}
			else
			{
				$radius = 10;
			}
		
		}
		
		if(empty($map)){
			$limit =3;
			$this->db->limit($limit,$offset);
		}
		//filter 1:
		$frequency_type = $param['frquencytype'];
		if($frequency_type == 1){
			$querycon ="(tbl_trips.trip_frequncy like '%~".$param['frequency']."~%')";
			$this->db->where($querycon);
		}
		else if($frequency_type == 2){
			$querycon ="(tbl_trips.trip_casual_date = '".date('Y/m/d',strtotime(str_replace("/","-",$param['date'])))."')";
			$this->db->where($querycon);
		}
		else{
		$frequency = $param['frequency'];
		if($frequency !="" && $frequency !="NaN")
			{
				
			$str = explode(',',$frequency);
			$querycon = "(";
			foreach ($str as $k => $tmpdept)
			 { 
				if($querycon != "(")
				{
				$querycon .=" OR ";
				 }
				 $querycon .="tbl_trips.trip_frequncy like '%~".$tmpdept."~%'";
	 
			}
			
			$querycon .=" OR ";		
			$querycon .="tbl_trips.trip_casual_date = '".date('Y/m/d',strtotime(str_replace("/","-",$param['date'])))."'";
			$querycon .= ")";
			$this->db->where($querycon);
			}
		
		}
			
			
		
			
			//filter 5
			$return = $param['return'];
			
			if($return !="" )
			{
			
				$this->db->where('tbl_trips.trip_return',$return);
			}	
		
			$this->db->select('tbl_t_trip_legs.*,tbl_trips.*,tbl_users.*,tbl_vehicle.*,tbl_vechicle_types.*,tbl_category.*,ACOS( SIN( RADIANS( tbl_t_trip_legs.source_latitude ) ) * SIN( RADIANS( '.$source_lat.' ) ) + COS( RADIANS( tbl_t_trip_legs.source_latitude ) )* COS( RADIANS( '.$source_lat.' )) * COS( RADIANS( tbl_t_trip_legs.source_longitude) - RADIANS( '.$source_lng.' )) ) * 6380 AS `source_distance`,ACOS( SIN( RADIANS( tbl_t_trip_legs.destination_latitude ) ) * SIN( RADIANS( '.$destination_lat.' ) ) + COS( RADIANS( tbl_t_trip_legs.destination_latitude ) )* COS( RADIANS( '.$destination_lat.' )) * COS( RADIANS( tbl_t_trip_legs.destination_longitude) - RADIANS( '.$destination_lng.' )) ) * 6380 AS `distination_distance`');
			
			$this->db->join('tbl_trips', 'tbl_trips.trip_id  = tbl_t_trip_legs.trip_id');	
			$this->db->join('tbl_users', 'tbl_users.user_id = tbl_trips.trip_user_id');
			$this->db->join('tbl_vehicle', 'tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');
			$this->db->join('tbl_vechicle_types', 'tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id');
			$this->db->join('tbl_category', 'tbl_category.category_id = tbl_vechicle_types.category_id');
			$this->db->having('source_distance <'.$radius);
			$this->db->having('distination_distance <'.$radius);
			$this->db->order_by('source_distance','DESC');
                        $this->db->where('tbl_trips.trip_status','1');
			
			$result = $this->db->get('tbl_t_trip_legs');
                        
                       		
			$result = $result->result_array();
			
			if($result){
				$result_set1 = array();
				foreach( $result as $key => $row )
				{					
					$result_set1[$row['trip_id']] = $row;
					$temp['distance_'.$row['trip_id']] = round($row['source_distance']);
					if($row['trip_from_latlan'])
					{
						$marker['latlng_'.$row['trip_id']] = $row['source_latitude'].','.$row['source_longitude'];
						$marker['source_'.$row['trip_id']] = $row['source_leg'];
					}
					
				}
				
							$data['amenties_details'] = $temp;
							$data['map_details'] = $marker;
							
							$data['search_results'] =$result_set1;	
							
							return $data;	
					
				}
				else
				{
					$temp =array();
					 $result = array();
					 $marker = array();
					 $data['amenties_details'] = $temp;
					$data['map_details'] = $marker;
					$data['search_results'] =$result;	
					return $data;	
				}
	}
	
	
	function SearchResults_count($param,$data)
	{
		
		$source = $param['fromlatlng'];
		$destination = $param['tolatlng'];		
		if($source !="" && $destination!="")
		{
			
			$source_latlng= explode(',',$source);
			$source_lat = $source_latlng[0];
			$source_lng = $source_latlng[1];
			
			$destination_latlng= explode(',',$destination);
			$destination_lat = $destination_latlng[0];
			$destination_lng = $destination_latlng[1];
			
			$distance = $this->distance($source_lat,$source_lng,$destination_lat,$destination_lng, "K");			
			$this->db->select('tbl_radius.radius');
			$querycon = '( '.$distance.' BETWEEN `distance_from` AND `distance_to`)';
			$this->db->where($querycon);
			$query = $this->db->get('tbl_radius');
			$result = $query->row_array();						
			if (sizeof($result) > 0)
			{
				
				$radius = $result['radius'];
                                if($radius == ''){
                                    $radius = 5;
                                }
			}
			else
			{
				$radius = 10;
			}
		
		}
		
		//filter 1:
		$frequency_type = $param['frquencytype'];
		if($frequency_type == 1){
			$querycon ="(tbl_trips.trip_frequncy like '%~".$param['frequency']."~%')";
			$this->db->where($querycon);
		}
		else if($frequency_type == 2){
			$querycon ="(tbl_trips.trip_casual_date = '".date('Y/m/d',strtotime(str_replace("/","-",$param['date'])))."')";
			$this->db->where($querycon);
		}
		else{
		$frequency = $param['frequency'];
		if($frequency !="" && $frequency !="NaN")
			{
				
			$str = explode(',',$frequency);
			$querycon = "(";
			foreach ($str as $k => $tmpdept)
			 { 
				if($querycon != "(")
				{
				$querycon .=" OR ";
				 }
				 $querycon .="tbl_trips.trip_frequncy like '%~".$tmpdept."~%'";
	 
			}
			
			$querycon .=" OR ";		
			$querycon .="tbl_trips.trip_casual_date = '".date('Y/m/d',strtotime(str_replace("/","-",$param['date'])))."'";
			$querycon .= ")";
			$this->db->where($querycon);
			}
		
		}
			
		
			
			//filter 5
			$return = $param['return'];
			
			if($return !="" )
			{
			
				$this->db->where('tbl_trips.trip_return',$return);
			}
		
			$this->db->select('tbl_trips.*,ACOS( SIN( RADIANS( tbl_t_trip_legs.source_latitude ) ) * SIN( RADIANS( '.$source_lat.' ) ) + COS( RADIANS( tbl_t_trip_legs.source_latitude ) )* COS( RADIANS( '.$source_lat.' )) * COS( RADIANS( tbl_t_trip_legs.source_longitude) - RADIANS( '.$source_lng.' )) ) * 6380 AS `source_distance`,ACOS( SIN( RADIANS( tbl_t_trip_legs.destination_latitude ) ) * SIN( RADIANS( '.$destination_lat.' ) ) + COS( RADIANS( tbl_t_trip_legs.destination_latitude ) )* COS( RADIANS( '.$destination_lat.' )) * COS( RADIANS( tbl_t_trip_legs.destination_longitude) - RADIANS( '.$destination_lng.' )) ) * 6380 AS `distination_distance`');
			
			$this->db->join('tbl_trips', 'tbl_trips.trip_id  = tbl_t_trip_legs.trip_id');	
			$this->db->join('tbl_users', 'tbl_users.user_id = tbl_trips.trip_user_id');
			$this->db->join('tbl_vehicle', 'tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');
			$this->db->join('tbl_vechicle_types', 'tbl_vechicle_types.vechicle_type_id = tbl_vehicle.vechicle_type_id');
			$this->db->join('tbl_category', 'tbl_category.category_id = tbl_vechicle_types.category_id');	
			$this->db->having('source_distance <'.$radius);
			$this->db->having('distination_distance <'.$radius);
			$this->db->order_by('source_distance','DESC');
                        $this->db->where('tbl_trips.trip_status','1');
			
			$result = $this->db->get('tbl_t_trip_legs');
                        
                        
			
			$result = $result->result_array();
			
			if($result){
				$result_set1 = array();
				foreach( $result as $key => $row )
				{
					$result_set1[$row['trip_id']] = $row;
				}
				
				$data['count'] = sizeof($result_set1);
				return $data;	
					
				}
				else
				{
					 $temp =array();
					 $result = array();
					 $data['count'] = sizeof($result);
					return $data;	
				}
		
	}
	
	function distance($lat1, $lon1, $lat2, $lon2, $unit) {

	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);
	
	  if ($unit == "K") {
			$distance = round(($miles * 1.609344));
			//echo $distance;
			if((string)$distance == "NAN"){
				$distance = 0;
			}
			return $distance;
	  } else if ($unit == "N") {
		  return ($miles * 0.8684);
		} else {
			return $miles;
		  }
	}
	
}