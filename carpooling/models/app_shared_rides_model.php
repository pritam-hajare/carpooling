<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_shared_rides_model extends CI_Model
{
	function get_pass_shared_rides($user_id)
    {  
        $this->db->select('trip_id');
		$this->db->from('tbl_booked_passenger');
		$this->db->where('status','C');
		$this->db->where('book_status',1);
		$this->db->where('user_id', $user_id);
		$result = $this->db->get();
		$result = $result->result_array();

		$trip_ids=null;
		for($i=0;$i<sizeof($result);$i++){
			$trip_ids[$i]=$result[$i]['trip_id'];
		}
		
		if (sizeof($result) > 0) {
			$this->db->select('tbl_users.user_id as u_id,
				               tbl_users.user_first_name as fname,
				               tbl_users.user_last_name as lname,
				               tbl_users.user_mobile as mobile,
				               tbl_trips.source as src,
				               tbl_trips.destination as dest,
				               tbl_trips.trip_depature_time as time');
			$this->db->select('DATE_FORMAT(tbl_trips.trip_casual_date, "%d/%m/%Y") AS date', FALSE);
			$this->db->from('tbl_trips');
			$this->db->where_in('tbl_trips.trip_id',$trip_ids);
			$this->db->where('tbl_trips.trip_status',1);
			$this->db->join('tbl_users','tbl_trips.trip_user_id=tbl_users.user_id');
			$result = $this->db->get();
        	return $result->result_array();
		}
		else{
			return 'NA';
		}
    }

    function get_driver_shared_rides($user_id)
    {  
        $this->db->select('tbl_trips.trip_id as tp_id,
        				   tbl_trips.source as src,
        				   tbl_trips.destination as dest,
        				   tbl_trips.trip_depature_time as time,
        				   tbl_trips.trip_avilable_seat as seat');
        $this->db->select('DATE_FORMAT(tbl_trips.trip_casual_date, "%d-%m-%Y") AS date', FALSE);
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