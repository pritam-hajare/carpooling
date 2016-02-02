<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_trip extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('trip_model');
    }

	function get_trip_for_noti_post() {
		
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['trip_id'] = $postData['trip_id'];
		
		$data=$this->trip_model->get_ride_for_noti($param['trip_id']);	
		if($data!=false){
			$data['state']="A";
			$this->response($data);	
		}
		else{
			$this->response(array('state'=>'NA'));
		}

	}	
}
?>