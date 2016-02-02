<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_alert_guardian extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('App_sms_model');
    }

	function alert_post() {
		
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$param['mob_no'] = $postData['mobno'];
		$param['msg'] = $postData['msg'];
		
		$this->response($this->App_sms_model->alert_guardian($param['mob_no'], $param['msg']));	
	}	
}
?>