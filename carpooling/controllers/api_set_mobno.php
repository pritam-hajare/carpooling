<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_set_mobno extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('App_sms_model');
        $this->load->model('App_otp_model');
    }

	function setmobno_post() {
		$output=array();
		$OTP= rand(100000, 999999);
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$param['user_id'] = $postData['u_id'];
		$param['user_mobile'] = $postData['user_mob'];
		$param['otp'] = $OTP;	
		if (!empty($param['user_id']) && !empty($param['user_mobile']) ) {
			$output["state"]=$this->update_mobno($param);
			$this->response($output);	
			$this->App_sms_model->send_otp($param['user_mobile'],$OTP);
		}else{
			$this->response(array('state'=>'fail'));
		}
	}

	function update_mobno($param){
		$data=array('user_mobile' => $param['user_mobile'],'OTP'=>$param['otp']);
		$this->db->where('user_id',$param['user_id']);
		if($this->db->update('tbl_users', $data)){
			return 'success';
		}
		else{
			return 'fail';
		}
	}
	
}
?>