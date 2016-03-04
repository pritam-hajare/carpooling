<?php
	require(APPPATH.'/libraries/REST_Controller.php');

	class Api_booking extends REST_Controller
	{	
		function __construct() {
			parent::__construct();
	        $this->load->model('App_booking_model');
	        $this->load->model('App_notification_model');
	     	$this->load->model('App_user_model');
	    }

		function book_ride_post() {
			$data=array();
			$postData = json_decode(file_get_contents("php://input"), true);
			//Passenger user id
			$param['pass_user_id'] = $postData['pass_u_id'];
			//Driver user id
			$param['dr_user_id'] = $postData['dr_u_id'];
			$param['trip_id'] = $postData['tp_id'];
			//Passenger Name- required for notification
			$param['pass_name'] = $postData['pass_name'];

			if(!empty($param['dr_user_id']) && !empty($param['pass_user_id']))
			{	$seats="";
				if($this->App_booking_model->check_seat_availability($param['trip_id'])){
					$seats='A';
					$status=$this->App_booking_model->check_booking_status($param['trip_id'],$param['pass_user_id'] );
					if($status==false){
						if($this->App_booking_model->request_to_book($param['trip_id'],$param['pass_user_id'])){
							
							$this->send_ride_request_noti($param,$seats);
							$this->response(array('state'=>'success'));
						}
						else{
							$this->response(array('state'=>'fail'));
						}
					}
					else{
						//Ride is full
						$this->response(array('state'=>$status));
					}
				}
				else{
					$this->response(array('state'=>'ride_full'));
				}
			}
			else{
				 $this->response(array('state'=>'err'));
			}	
		}

		function send_ride_request_noti($param,$seats){
			$message['pass_name']=$param['pass_name'];
			$message['header']='SR';
			$message['pass_u_id']=$param['pass_user_id'];
			$message['tp_id']=$param['trip_id'];
			$message['seats']=$seats;
			$img_name = $this->App_user_model->get_profile_img_name($param['pass_user_id']);	
			if($img_name!=false){
				$message['img_name'] = $img_name; 
			}
			else{
				$message['img_name'] = "";	
			}

			return $this->App_notification_model->send_notification($param['dr_user_id'],$message);
		}

		function get_pass_book_list_post($trip_id){
			$data=array();
			$postData = json_decode(file_get_contents("php://input"), true);
			$param['trip_id'] = $postData['tp_id'];

			if(!empty($param['trip_id'])){
				$data=$this->App_booking_model->get_pass_book_list($param['trip_id']);
				if($data!=false){
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

		function confirm_booking_post(){
			
			$postData = json_decode(file_get_contents("php://input"), true);
			$param['trip_id'] = $postData['tp_id'];
			$param['user_id'] = $postData['u_id'];
			$param['dr_name'] = $postData['dr_name'];

			if(!empty($param['trip_id']) && !empty($param['user_id'])){
				if($this->App_booking_model->confirm_booking($param['trip_id'],$param['user_id'])) {
					
					$this->App_booking_model->seatDecreament($param['trip_id']);
					
					$message['dr_name']=$param['dr_name'];
					$message['header']='SACC';
					$message['tp_id']=$param['trip_id'];

					$this->App_notification_model->send_notification($param['user_id'],$message);
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

		function cancel_booking_post(){

			//Cancel booking and reject booking is diff.
			//In cancel booking we increase seat count in tbl_trips but not in reject booking

			$postData = json_decode(file_get_contents("php://input"), true);
			$param['trip_id'] = $postData['tp_id'];
			$param['user_id'] = $postData['u_id'];
			$param['dr_name'] = $postData['dr_name'];

			if(!empty($param['trip_id']) && !empty($param['user_id'])){
				if($this->App_booking_model->cancel_booking($param['trip_id'],$param['user_id'])) {
					//Inrease seat by one..because trip's one seat's bookiing is cancelled and is available for other passengers
        			$this->App_booking_model->seatIncreament($param['trip_id']);
					$message=array();
					$message['dr_name']=$param['dr_name'];
					$message['header']='SREJ';
					$message['tp_id']=$param['trip_id'];

					$this->App_notification_model->send_notification($param['user_id'],$message);
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

		function reject_booking_post(){

			//Cancel booking and reject booking is diff.
			//In cancel booking we increase seat count in tbl_trips but not in reject booking

			$postData = json_decode(file_get_contents("php://input"), true);
			$param['trip_id'] = $postData['tp_id'];
			$param['user_id'] = $postData['u_id'];
			$param['dr_name'] = $postData['dr_name'];

			if(!empty($param['trip_id']) && !empty($param['user_id'])){
				if($this->App_booking_model->cancel_booking($param['trip_id'],$param['user_id'])) {
					
					$message['dr_name']=$param['dr_name'];
					$message['header']='SREJ';
					$message['tp_id']=$param['trip_id'];

					$this->App_notification_model->send_notification($param['user_id'],$message);
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


	}
?>