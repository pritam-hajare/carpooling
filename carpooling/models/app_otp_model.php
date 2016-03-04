<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_otp_model extends CI_Model
{
	function save_otp($user_id,$otp)
    {   
        $data=array('OTP'=>$otp);
        $this->db->where('user_id',$user_id);
        return $this->db->update('tbl_users', $data);    
    }

    function send_otp_by_mail($user_id,$OTP){

    	$this->load->model('App_user_model');
    	$user_email = $this->App_user_model->get_email($user_id);

    	$res = $this->db->where('tplid', '29')->get('tbl_email_template');
		$row = $res->row_array();

		$row['tplmessage'] = str_replace('{OTP}', $OTP);
		$param['message'] = $row['tplmessage'];

		//$email_subject = $this->load->view('template', $param, TRUE);

		$this->load->library('email');

		$config['mailtype'] = 'html';

		$this->email->initialize($config);

		$this->email->from($this->config->item('email'), $this->config->item('company_name'));
		$this->email->to($user_email['email']);
		//$this->email->bcc($this->config->item('email'));
		$this->email->subject($row['tplsubject']);
		$this->email->message(html_entity_decode($email_subject)); 
		$user_email	= $this->App_user_model->get_email($user_id);

		return $this->email->send();
	
    }
}    
?>