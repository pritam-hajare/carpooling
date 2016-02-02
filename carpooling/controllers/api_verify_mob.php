<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_verify_mob_guardian extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('App_sms_model');
        $this->load->model('App_otp_model');
    }

	function verify_post() {	
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$param['user_id'] = $postData['u_id'];
		$param['user_mobile'] = $postData['mobile'];
		$OTP= rand(100000, 999999);
		
		if($this->App_otp_model->save_otp($param['user_id'],$OTP)){	
			$this->App_sms_model->send_otp($param['user_mobile'],$OTP);
			$this->response(array('state'=>'s'));
		}
		else{
			$this->response(array('state'=>'f'));
		}
	}
}
?>