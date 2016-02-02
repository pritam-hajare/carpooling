<?php
	require(APPPATH.'/libraries/REST_Controller.php');

	class Api_get_userdet extends REST_Controller
	{	
		function __construct() {
			parent::__construct();
	        $this->load->model('App_user_model');
	    }

		function get_userdet_post() {
			$data=array();
			$postData = json_decode(file_get_contents("php://input"), true);
			$param['user_id'] = $postData['user_id'];

			if(!empty($param['user_id']))
			{	
				$data=$this->App_user_model->get_user($param['user_id']);
						
				if($data!=false){
					//A determines details are available
					$data['state']='A';
					$this->response($data);	
				}
				else{
					$this->response(array('state'=>'NA'));
				}
			}
			else{
				 $this->response(array('state'=>'err'));
			}	
		}
	}
?>