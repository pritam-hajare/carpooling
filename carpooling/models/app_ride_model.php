<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_ride_model extends CI_Model
{   
    function __construct()
    {
        parent::__construct();   
    }

	function get_ride_for_noti($trip_id)
    {   
    	$this->db->select('tbl_trips.source, 
                           tbl_trips.destination,
                           tbl_trips.trip_depature_time');
        $this->db->select('DATE_FORMAT(tbl_trips.trip_casual_date, "%d-%m-%Y") AS date', FALSE);
        $this->db->from('tbl_trips');
        $this->db->where('tbl_trips.trip_id',$trip_id);
        
        $result = $this->db->get();
        return $result->result_array();       
    }
}    
?>