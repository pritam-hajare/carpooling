<?php

Class Language_model extends CI_Model {

    //this is the expiration for a non-remember session
    var $session_expire = 7200;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
    }

    /*     * ******************************************************************

     * ****************************************************************** */

    function all_languages($limit = 0, $offset = 0, $order_by = 'language_id', $direction = 'DESC') {
        $this->db->order_by($order_by, $direction);
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        $result = $this->db->get('tbl_language');
        //echo $this->db->last_query(); die;
        return $result->result_array();
    }

    function count_languages() {


        return $this->db->count_all_results('tbl_language');
    }

    function get_language($id) {

        $result = $this->db->get_where('tbl_language', array('language_id' => $id));
        return $result->row();
    }
	
	function get_language_name($prefix)
	{
		$result = $this->db->get_where('tbl_language', array('language_code' => $prefix));
        return $result->row();
	}

    function getlanguage_list() {
        return $this->db->order_by('language_id', 'ASC')->get('tbl_language')->result();
    }

    function check_language($str, $id = false) {

        $this->db->select('language_name');
        $this->db->from('tbl_language');
        $this->db->where('language_name', $str);
        if ($id) {
            $this->db->where('language_id !=', $id);
        }
        $count = $this->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function check_code($str, $id = false) {

        $this->db->select('language_code');
        $this->db->from('tbl_language');
        $this->db->where('language_name', $str);
        if ($id) {
            $this->db->where('language_id !=', $id);
        }
        $count = $this->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function save($language) {
        if ($language['language_id']) {
            $this->db->where('language_id', $language['language_id']);
            $this->db->update('tbl_language', $language);
            return $language['language_id'];
        } else {
            $language['created_date'] = date('Y-m-d H:i:s',now());
            $this->db->insert('tbl_language', $language);
            return $this->db->insert_id();
        }
    }

        
    function delete($prodid) {

        $this->db->where('language_id', $prodid);
        $this->db->delete('tbl_language');
    }

}
