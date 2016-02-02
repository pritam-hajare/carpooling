<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_notification extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('App_notification_model');
    }

	function notify_pass_share_cur_loc_post() {
		
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$message = array('dr_name' => $postData['dr_name'],
		                 'header' => 'SL',
		                 'dr_user_id' => $postData['dr_u_id'],
		                 'trip_id' => $postData['tp_id'] );	

		$this->response($this->App_notification_model->send_notification($postData['pass_user_id'], $message));	
	}	
}
?>