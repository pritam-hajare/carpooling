<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_notification extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('App_notification_model');
    }

	function notify_single_pass_share_cur_loc_post() {
		
		$postData = json_decode(file_get_contents("php://input"), true);

		$message = array('dr_name' => $postData['dr_name'],
		                 'header' => 'SL',
		                 'dr_user_id' => $postData['dr_u_id'],
		                 'trip_id' => $postData['tp_id'] );	
		
		if($this->App_notification_model->send_notification($postData['pass_u_id'], $message))
		{
			$this->response(array('state'=>'success'));	
		}
		else{
			$this->response(array('state'=>'fail'));		
		}
	}	

	function notify_all_pass_share_cur_loc_post() {
		
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$message = array('dr_name' => $postData['dr_name'],
		                 'header' => 'SL',
		                 'dr_user_id' => $postData['dr_u_id'],
		                 'trip_id' => $postData['tp_id'] );	
		
		if($this->App_notification_model->send_notification($postData['pass_u_id'], $message))
		{
			$this->response(array('state'=>'success'));	
		}
		else{
			$this->response(array('state'=>'fail'));		
		}
	}	

	function notify_set_professional_email_post(){
		
		$message = array('header' => 'SET_PFS_EML');	
		$this->response($this->App_notification_model->send_notification(484, $message));
	}
}
?>