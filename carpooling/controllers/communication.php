<?php

class Communication extends Traveller_Controller {

    var $CI;
    var $user;

    function __construct() {
        parent::__construct();

        $this->CI = & get_instance();
        $this->user = $this->CI->carpool_session->userdata('carpool');

        $this->load->model('Trip_model');
        $this->load->model('Customer_model');

    }

    function sendenquiry($ajax = false) {
 	
        if ($this->input->post('pmId')) {
            $trip_id = $this->input->post('pmId');
        }
		
		

        $profile = $this->Trip_model->get_trip($trip_id);
		
        $user_id = $this->user['user_id'];
		
        $customer = $this->Customer_model->get_customer($user_id);
		
        if ($this->check_enquiry($user_id, $trip_id)) 
		{
			
            $name = $customer->user_first_name . '.' . $customer->user_last_name;
            $passanger_email = $customer->user_email;
			$passanger_mobile = $customer->user_mobile;
			

            $traveller_name = $profile->user_first_name . '.' . $profile->user_last_name;
			$traveller_email = $profile->user_email;
			$traveller_mobile = $profile->user_mobile;

           // $traveller_email = $profile->user_email;
            $save['enquiry_passanger_id'] = $user_id;
            $save['enquiry_trip_id'] = $trip_id;
            $save['enquire_travel_id'] = $profile->trip_user_id;
            $id = $this->save_enquiry($save);

            $edata['passanger_name'] = $name;
            $edata['passanger_email'] = $passanger_email;
			$edata['passanger_mobile']=$passanger_mobile;

            $edata['traveller_name'] = $traveller_name;
            $edata['traveller_email'] = $traveller_email;
			$edata['traveller_mobile']=$traveller_mobile;
            
			
            $this->tripowner($edata);
            $this->tripbooker($edata);


            if ($ajax) {
                die(json_encode(array('result' => true)));
            }
        } else {
			
            if ($ajax) {
                die(json_encode(array('result' => false)));
            }
        }
		
        //$redirect = $this->input->post('redirect');
        //die;
        //die(json_encode(array('result'=>false,'message'=>lang('error_no_account_record'))));
    }

    function tripowner($edata) {
        // send an email */
////			// get the email template
        $res = $this->db->where('tplid', '27')->get('tbl_email_template');
        $row = $res->row_array();

        // set replacement values for subject & body
        // {customer_name}
        
	$row['tplsubject'] =  str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplsubject']);	
        
	$row['tplmessage'] = str_replace('{NAME}', $edata['traveller_name'], $row['tplmessage']);

        $row['tplmessage'] = str_replace('{PNAME}', $edata['passanger_name'], $row['tplmessage']);

        $row['tplmessage'] = str_replace('{PEMAIL}', $edata['passanger_email'], $row['tplmessage']);
		
	$row['tplmessage'] = str_replace('{PMOBILE}', $edata['passanger_mobile'], $row['tplmessage']);

        $row['tplmessage'] = str_replace('{IP}', $this->input->ip_address(), $row['tplmessage']);
        
        $row['tplmessage'] = str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplmessage']);


        $param['message'] = $row['tplmessage'];
		

        $email_subject = $this->load->view('template', $param, TRUE);
		
		
        $this->load->library('email');

        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $this->email->from($this->config->item('email'), $this->config->item('company_name'));
        $this->email->to($edata['traveller_email']);
        $this->email->bcc($this->config->item('email'));
        $this->email->subject($row['tplsubject']);
        $this->email->message(html_entity_decode($email_subject));

        $this->email->send();
    }

    function tripbooker($edata) {
        // send an email */
        // get the email template

        $res = $this->db->where('tplid', '28')->get('tbl_email_template');
        $row = $res->row_array();

        // set replacement values for subject & body
        
        $row['tplsubject'] =  str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplsubject']);

        $row['tplmessage'] = str_replace('{NAME}', $edata['passanger_name'], $row['tplmessage']);

        $row['tplmessage'] = str_replace('{PNAME}', $edata['traveller_name'], $row['tplmessage']);

        $row['tplmessage'] = str_replace('{PEMAIL}', $edata['traveller_email'], $row['tplmessage']);
		
	$row['tplmessage'] = str_replace('{PMOBILE}', $edata['traveller_mobile'], $row['tplmessage']);

        $param['message'] = $row['tplmessage'];
        
        $row['tplmessage'] = str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplmessage']);

        $email_subject = $this->load->view('template', $param, TRUE);

        $this->load->library('email');

        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $this->email->from($this->config->item('email'), $this->config->item('company_name'));
        $this->email->to($edata['passanger_email']);
        $this->email->bcc($this->config->item('email'));
        $this->email->subject($row['tplsubject']);
        $this->email->message(html_entity_decode($email_subject));

        $this->email->send();
    }

    function check_enquiry($user_id, $trip_id) {

        $this->db->select('*');
        $this->db->where(array('enquiry_passanger_id' => $user_id, 'enquiry_trip_id' => $trip_id));
        $this->db->from('tbl_enquires');
        $result = $this->db->get();
        if ($result->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    function save_enquiry($data) {

        if (!empty($data['enquiry_id'])) {
            $this->db->where('enquiry_id', $data['enquiry_id'])->update('tbl_enquires', $data);
            return $data['enquiry_id'];
        } else {
            $this->db->insert('tbl_enquires', $data);
            return $this->db->insert_id();
        }
    }

}
