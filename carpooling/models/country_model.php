<?php

Class Country_model extends CI_Model {

    //this is the expiration for a non-remember session
    var $session_expire = 7200;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
    }

    /*     * ******************************************************************

     * ****************************************************************** */

    function all_countries($limit = 0, $offset = 0, $order_by = 'country_id', $direction = 'DESC') {
        $this->db->order_by($order_by, $direction);
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        $result = $this->db->get('tbl_country');
        //echo $this->db->last_query(); die;
        return $result->result_array();
    }

    function count_countries() {


        return $this->db->count_all_results('tbl_country');
    }

    function get_country($typeid) {

        $result = $this->db->get_where('tbl_country', array('country_id' => $typeid));
        return $result->row();
    }

    function getcountry_list() {
        return $this->db->order_by('country_id', 'ASC')->where('is_active',1)->get('tbl_country')->result();
    }

    function check_country($str, $id = false) {

        $this->db->select('country_name');
        $this->db->from('tbl_country');
        $this->db->where('country_name', $str);
        if ($id) {
            $this->db->where('country_id !=', $id);
        }
        $count = $this->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function check_code($str, $id = false) {

        $this->db->select('country_code');
        $this->db->from('tbl_country');
        $this->db->where('country_name', $str);
        if ($id) {
            $this->db->where('country_id !=', $id);
        }
        $count = $this->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function save($country) {
        if ($country['country_id']) {                                              
            $this->db->where('country_id', $country['country_id']);
            $this->db->update('tbl_country', $country);
            return $country['country_id'];
        } else {
			$country['created_date'] = date('Y-m-d H:i:s',now());
            $this->db->insert('tbl_country', $country);
            return $this->db->insert_id();
        }
    }

        
    function delete($prodid) {

        $this->db->where('country_id', $prodid);
        $this->db->delete('tbl_country');
    }

}
