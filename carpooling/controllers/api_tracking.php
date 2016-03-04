<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_tracking extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('App_tracking_model');
    }

	function set_pass_cur_loc_post() {
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$param['user_id'] = $postData['u_id'];
		$param['trip_id'] = $postData['tp_id'];
		$param['lat'] = $postData['loc_lat'];
		$param['lng'] = $postData['loc_lng'];
		
		if($this->App_tracking_model->set_pass_cur_loc($param)){
			$this->response(array('state'=>'success'));
		}
		else{
			$this->response(array('state'=>'fail'));	
		}
		
	}

	function get_pass_loc_post() {
		$output=array();
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['user_id'] = explode(',',$postData['u_id']);
		$param['trip_id'] = $postData['tp_id'];
		
		$output=$this->App_tracking_model->get_pass_loc($param);
		if($output!=false){
			$output['state']='success';	
			$this->response($output);
		}
		else{
			$this->response(array('state'=>'fail'));	
		}
		
	}


}
?>