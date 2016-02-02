<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_reviews_model extends CI_Model
{
	function get_reviews($user_id)  
    {   
        $this->db->select('tbl_reviews.writer_user_id as wtr_u_id, 
                           tbl_reviews.rating as user_rating,
                           tbl_reviews.review as user_review,
                           tbl_reviews.date as rev_date,
                           tbl_users.user_first_name as fname,
                           tbl_users.user_last_name as lname');
        $this->db->from('tbl_reviews');
        $this->db->where('tbl_reviews.user_id',$user_id);
        $this->db->join('tbl_users','tbl_reviews.writer_user_id=tbl_users.user_id');
        
        $result = $this->db->get();
        return $result->result_array();
    }

    function write_review($param)  
    {   
        return $this->db->insert('tbl_reviews', $param);
    }

    function verify_mob_for_rev($mobno){
        $this->db->select('user_id as u_id,user_first_name as fname,user_last_name as lname');
        $this->db->from('tbl_users');
        $this->db->where('user_mobile',$mobno);
        $result = $this->db->get()->result_array();
        return $result;
    }
}    
?>