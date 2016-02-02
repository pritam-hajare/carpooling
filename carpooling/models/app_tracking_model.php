<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_tracking_model extends CI_Model
{
	function set_pass_cur_loc($param)
    {   
        $data=array();
		$data['lat'] = $param['lat'];
		$data['lng'] = $param['lng'];
		
		$this->db->where('user_id',$param['user_id']);
		$this->db->where('trip_id',$param['trip_id']);

		return $this->db->update('tbl_booked_passenger', $data);
    }

    function get_pass_loc($param){

    	/*Here I have retrieved record in date_time order.
    	Because i have retrieved record on getPassengerBookingList.php(PassengerBookingList Activity) so that order of passenger will be same.
    	This order affects on popup that occures by clicking on passenger icon on TrackingMapActivity.*/

    	$this->db->select('lat as latitude,lng as longitude');
	  	$this->db->from('tbl_booked_passenger');
		$this->db->where('trip_id',$param['trip_id']);
		$this->db->where_in('user_id',$param['user_id']);

		$result = $this->db->get();
		return $result->result_array();
    }
}    
?>