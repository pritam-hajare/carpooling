<?php

Class Currency_model extends CI_Model {

    //this is the expiration for a non-remember session
    var $session_expire = 7200;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
    }

    /*     * ******************************************************************

     * ****************************************************************** */

    function all_currencies($limit = 0, $offset = 0, $order_by = 'currency_id', $direction = 'DESC') {
        $this->db->order_by($order_by, $direction);
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        $result = $this->db->get('tbl_currency');
        //echo $this->db->last_query(); die;
        return $result->result_array();
    }

    function count_currencies() {


        return $this->db->count_all_results('tbl_currency');
    }

    function get_currency($id) {

        $result = $this->db->get_where('tbl_currency', array('currency_id' => $id));
        return $result->row();
    }
    
    function get_currency_id($name) {

        $result = $this->db->get_where('tbl_currency', array('currency_name' => $name));
        return $result->row();
    }

    function getcurrency_list() {
        return $this->db->order_by('currency_id', 'ASC')->get('tbl_currency')->result();
    }

    function check_currency($str, $id = false) {

        $this->db->select('currency_name');
        $this->db->from('tbl_currency');
        $this->db->where('currency_name', $str);
        if ($id) {
            $this->db->where('currency_id !=', $id);
        }
        $count = $this->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function check_symbol($str, $id = false) {

        $this->db->select('currency_symbol');
        $this->db->from('tbl_currency');
        $this->db->where('currency_name', $str);
        if ($id) {
            $this->db->where('currency_id !=', $id);
        }
        $count = $this->db->count_all_results();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    function save($currency) {
        if ($currency['currency_id']) {
            $this->db->where('currency_id', $currency['currency_id']);
            $this->db->update('tbl_currency', $currency);
            return $currency['currency_id'];
        } else {
            $currency['created_date'] = date('Y-m-d H:i:s',now());
            $this->db->insert('tbl_currency', $currency);
            return $this->db->insert_id();
        }
    }

        
    function delete($id) {

        $this->db->where('currency_id', $id);
        $this->db->delete('tbl_currency');
    }

}
