<?php
	require(APPPATH.'/libraries/REST_Controller.php');

	class Api_reviews extends REST_Controller
	{	
		function __construct() {
			parent::__construct();
	        $this->load->model('App_reviews_model');
	    }

		function get_reviews_post() {
			$data=array();
			$postData = json_decode(file_get_contents("php://input"), true);
			$param['user_id'] = $postData['u_id'];

			if(!empty($param['user_id']))
			{	
				$data=$this->App_reviews_model->get_reviews($param['user_id']);
				if(!empty($data)){
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

		function setavg_post(){
			$this->response($this->App_reviews_model->set_avg_rating(484,4));
		}

		function write_review_post() {
		
			$postData = json_decode(file_get_contents("php://input"), true);
			$param['user_id'] = $postData['u_id'];
			$param['writer_user_id'] = $postData['wtr_u_id'];
			$param['review'] = $postData['u_rev'];
			$param['rating'] = $postData['u_rat'];

			if(!empty($param['user_id']) && !empty($param['writer_user_id']))
			{	
				if($this->App_reviews_model->write_review($param)){
					$this->response(array('state'=>'success'));
				}
				else{
					$this->response(array('state'=>'fail'));
				}
			}
			else{
				 $this->response(array('state'=>'err'));
			}	
		}

		function verify_mob_for_rev_post(){
			$postData = json_decode(file_get_contents("php://input"), true);
			$param['user_mobile'] = $postData['mob_no'];
			if(!empty($param['user_mobile']))	
			{
				$user_id=$this->App_reviews_model->verify_mob_for_rev($param['user_mobile']);
				if(!empty($user_id)){
					$user_id['state']='A';
					$this->response($user_id);
				}
				else{
					$this->response(array('state'=>"NA"));
				}
			}
			else{
				$this->response(array('state'=>'err'));
			}
		}
	}
?>