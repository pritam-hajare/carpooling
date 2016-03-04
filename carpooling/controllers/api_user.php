<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_user extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('App_user_model');
        $this->load->model('App_sms_model');
        $this->load->model('App_otp_model');
    }

    function set_professional_email_post(){
    	$postData = json_decode(file_get_contents("php://input"), true);
		$param['user_id'] = $postData['u_id'];
		$param['user_professional_email'] = $postData['pf_email'];

		if(!empty($param['user_id']) && !empty($param['user_professional_email']))
		{
			$this->App_user_model->set_professional_email($param);
			//$this->App_user_model->send_activation_link($param['user_professional_email']);	
			$this->response(array('state'=>"success"));
		}	
		else{
			$this->response(array('state'=>'err'));
		}	
    }

    function get_userdet_post() {

		$data=array();
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['user_id'] = $postData['u_id'];

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

    function edit_userdet_post() {
		$data=array();
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['user_id'] = $postData['u_id'];
		$param['user_first_name'] = $postData['first_name'];
		$param['user_last_name'] = $postData['last_name'];
		$param['user_gender'] = $postData['u_gender'];
		$param['user_street'] = $postData['u_address'];
		$param['user_city'] = $postData['u_city'];
		$param['user_company_name'] = $postData['company'];

		if(!empty($param['user_id']) && !empty($param['user_first_name']) && !empty($param['user_last_name']))
		{	
			if($this->App_user_model->edit_user($param)){
				$this->response(array("state"=>"success"));
			}
			else{
				$this->response(array("state"=>"fail"));	
			}
		}
		else{
			 $this->response(array('state'=>'err'));
		}	
	}

	function set_pref_post() {
		
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['user_id'] = $postData['u_id'];
		$param['allowed_pet'] = $postData['pet'];
		$param['allowed_smoke'] = $postData['smoke'];
		$param['allowed_music'] = $postData['music'];
		
		if($this->App_user_model->set_pref($param)){
			$this->response(array('state'=>'success'));
		}
		else{
			$this->response(array('state'=>'fail'));
		}

	}	

	function chk_mob_for_offertrip_post(){
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$param['user_id'] = $postData['u_id'];

		if(!empty($param['user_id'])){
			$data=$this->App_user_model->get_mob_det($param['user_id']);
			if(sizeof($data)>0){

				if($data['mob_vf']==0 && $data['mobile']!=null)	
				{
					$OTP= rand(100000, 999999);
					$this->App_otp_model->save_otp($param['user_id'] ,$OTP);
					$this->App_sms_model->send_otp($data['mobile'],$OTP);		
				}		

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

	function verify_mob_post() {	
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$param['user_id'] = $postData['u_id'];
		$param['user_mobile'] = $postData['mobno'];
		$OTP= rand(100000, 999999);
		
		if($this->App_otp_model->save_otp($param['user_id'],$OTP)){	
			$this->App_sms_model->send_otp($param['user_mobile'],$OTP);
			$this->response(array('state'=>'success'));
		}
		else{
			$this->response(array('state'=>'fail'));
		}
	}

	function get_pref_post() {
		
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['user_id'] = $postData['u_id'];
		
		if(!empty($param['user_id']))
		{	
			$data=$this->App_user_model->get_pref($param['user_id']);
			if($data!=false){
				$data["state"]='success';
				$this->response($data);
			}
			else{
				$this->response(array('state'=>'fail'));
			}
		}
		else{
			$this->response(array('state'=>'err'));
		}	
	}	

	function upload_pic_post(){
		
		$id = $_REQUEST['u_id'];
		$base = $_REQUEST['image'];
		$extention = $_REQUEST['ext'];
		$randomNo = $_REQUEST['random_no'];

		$imgName = 'user' . $id . '_profile'. $randomNo . $extention;

		$binary=base64_decode($base);
		header('Content-Type: bitmap; charset=utf-8');
		$file = fopen('uploads/profile/original/'.$imgName, 'wb');
		chmod('uploads/profile/original/'.$imgName, 0777);
		$status = fwrite($file, $binary);
		fclose($file);
		
		$file = fopen('uploads/profile/source/'.$imgName, 'wb');
		chmod('uploads/profile/source/'.$imgName, 0777);
		$status = fwrite($file, $binary);
		fclose($file);
		
		if($status != false)
		{
			$this->App_user_model->set_profile_imgname($id,$imgName);
			echo "<p>success</p>";
			
		}
		else{
			echo "<p>fail</p>";
		}
	}
}
?>