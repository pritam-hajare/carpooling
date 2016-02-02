<?php
	require(APPPATH.'/libraries/REST_Controller.php');

	class Api_shared_rides extends REST_Controller
	{	
		function __construct() {
			parent::__construct();
	        $this->load->model('App_shared_rides_model');
	    }

		function get_pass_rides_post() {
			$data=array();
			$postData = json_decode(file_get_contents("php://input"), true);
			$param['user_id'] = $postData['u_id'];

			if(!empty($param['user_id']))
			{	
				$data=$this->App_shared_rides_model->get_pass_shared_rides($param['user_id']);
				
				if(!empty($data) && $data!="NA"){
					$data['state']='A';
					$this->response($data);
				}
				else if($data=="NA") {
					$this->response(array('state'=>'NA'));
				}
			}
			else{
				 $this->response(array('state'=>'err'));
			}	
		}

		function get_driver_rides_post() {
			$data=array();
			$postData = json_decode(file_get_contents("php://input"), true);
			$param['user_id'] = $postData['u_id'];

			if(!empty($param['user_id']))
			{	
				$data=$this->App_shared_rides_model->get_driver_shared_rides($param['user_id']);
				
				if(!empty($data) && $data!="NA"){
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