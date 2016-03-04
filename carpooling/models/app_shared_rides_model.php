<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_shared_rides_model extends CI_Model
{
	function get_pass_shared_rides($user_id)
    {  
        
		$this->db->select('tbl_users.user_id as u_id,
						   tbl_trips.trip_id as tp_id,
			               tbl_users.user_first_name as fname,
			               tbl_users.user_last_name as lname,
			               tbl_users.user_mobile as mobile,
			               tbl_users.user_profile_img as img_profile,
			               tbl_trips.source as src,
			               tbl_trips.trip_status as st_trip,
			               tbl_trips.destination as dest,
			               tbl_trips.trip_depature_time as time,
			               tbl_booked_passenger.status as st,
			               tbl_vehicle.vechicle_number as veh_no');
		$this->db->select('DATE_FORMAT(tbl_trips.trip_casual_date, "%d/%m/%Y") AS date', FALSE);
		$this->db->from('tbl_booked_passenger');
		$this->db->where('tbl_booked_passenger.user_id',$user_id);
		$this->db->join('tbl_trips','tbl_trips.trip_id = tbl_booked_passenger.trip_id');
		$this->db->join('tbl_users','tbl_users.user_id = tbl_trips.trip_user_id');
		$this->db->join('tbl_vehicle','tbl_vehicle.vechicle_id = tbl_trips.trip_vehicle_id');
    	$result = $this->db->get();
    	return $result->result_array();

    }

    function get_driver_shared_rides($user_id)
    {  
        $this->db->select('tbl_trips.trip_id as tp_id,
        				   tbl_trips.source as src,
        				   tbl_trips.destination as dest,
        				   tbl_trips.trip_status as st_trip,
        				   tbl_trips.trip_depature_time as time,
        				   tbl_trips.trip_avilable_seat as seat');
        $this->db->select('DATE_FORMAT(tbl_trips.trip_casual_date, "%d/%m/%Y") AS date', FALSE);
		$this->db->from('tbl_trips');
		$this->db->where('tbl_trips.trip_user_id',$user_id);
		$this->db->where('tbl_trips.is_booked',1);
		$this->db->where('tbl_trips.trip_status',1);
		$result = $this->db->get();
		$result = $result->result_array();

		return $result;
    }
}    
?>