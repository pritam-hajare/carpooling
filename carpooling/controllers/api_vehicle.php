<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_vehicle extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('vechicle_model');
    }

	function get_veh_for_select_post() {
		
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['user_id'] = $postData['u_id'];
		$data = $this->vechicle_model->getvechicle_list($param['user_id']);
		
		if(sizeof($data)>0){
			$data['state']='A';
			$this->response($data);
		}
		else{
			$this->response(array('state'=>'NA'));
		}

	}	
}
?>