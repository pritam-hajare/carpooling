<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_booking_model extends CI_Model
{   
    function __construct()
    {
      parent::__construct();
    }

	  function request_to_book($trip_id,$pass_user_id)
    {  
       $data['trip_id'] = $trip_id;
       $data['user_id'] = $pass_user_id;
       $data['status'] = 'NC';

       if($this->db->insert('tbl_booked_passenger', $data))
       {
       		return $this->set_booked_status($trip_id);
       }
       else{
          return false;
       }
    }

    function check_seat_availability($trip_id){
        $this->db->select('trip_id');
  		  $this->db->from('tbl_trips');
  		  $this->db->where('trip_avilable_seat > 0');
  		  $this->db->where('trip_id', $trip_id);
  		  $this->db->limit(1);
  		  $result = $this->db->get();
  		  $result = $result->row_array();	
  		  if (sizeof($result) > 0) {
  			   return true;
  		  }
  		  else{
  			   return false;
  		  }
    }

    function check_booking_status($trip_id,$pass_user_id){
      $this->db->select('status');
  		$this->db->from('tbl_booked_passenger');
  		$this->db->where('trip_id', $trip_id);
  		$this->db->where('user_id', $pass_user_id);
  		$result = $this->db->get();
  		$result = $result->row_array();	
  		if (sizeof($result) > 0) {
  			return $result['status'];
  		}
  		else{
  			return false;
  		}
    }

    function set_booked_status($trip_id){
    	 $data=array('is_booked'=>1);
       $this->db->where('trip_id',$trip_id);
       return $this->db->update('tbl_trips', $data);   
    }

    function get_pass_book_list($trip_id){
       	return $this->db->query('
       	SELECT tbl_users.user_id as u_id,tbl_users.user_first_name as first_name,tbl_users.user_last_name as last_name,tbl_users.user_mobile as mobile,tbl_booked_passenger.status as book_pass_status
       		FROM tbl_users,tbl_booked_passenger 
         WHERE tbl_users.user_id=tbl_booked_passenger.user_id
           AND tbl_users.user_id IN (SELECT user_id from tbl_booked_passenger where tbl_booked_passenger.trip_id='.$trip_id.') AND tbl_booked_passenger.trip_id='.$trip_id.' ORDER BY date_time')->result_array();  	
    }

    function confirm_booking($trip_id,$user_id){
        $data=array('status'=>'C');
        $this->db->where('trip_id',$trip_id);
        $this->db->where('user_id',$user_id);
        return $this->db->update('tbl_booked_passenger', $data);   
    }

    function cancel_booking($trip_id,$user_id){
        $data=array('status'=>'CL');
        $this->db->where('trip_id',$trip_id);
        $this->db->where('user_id',$user_id);

        return $this->db->update('tbl_booked_passenger', $data);   
    }


    function seatIncreament($trip_id){
        
        return $this->db->query('update tbl_trips set trip_avilable_seat = trip_avilable_seat+1 where trip_id='.$trip_id.' ');               
    }

    function seatDecreament($trip_id){
        return $this->db->query('update tbl_trips set trip_avilable_seat = trip_avilable_seat-1 where trip_id='.$trip_id.' ');               
    }
}    
?>