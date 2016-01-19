<?php 

class Otp extends Front_Controller 
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('pagination');
		$this->load->helper('text');
		$this->load->model('Trip_model');
				
	}
	function verify($tripid)
	{
		$this->load->helper('form');
		$otp = $this->Trip_model->get_trip($tripid);
		$data['mobile'] = $otp->contact_person_number;
		$data['code'] = '';
		$data['tripid'] =$otp->trip_id;
		$this->load->helper('string');		
		
		//$param['id'] = false;
		//$param['trip_id'] = $trip_id;
		$param['Otp_code'] = random_string('numeric', 6);
		$param['mobile'] = $data['mobile'];
		$otp_id = $this->otp_model->save($param);		
		$this->mobile = $param['mobile'];
		$this->sms_global->to($this->mobile);	
		$this->sms_global->message('your verification code is '.$param['Otp_code'].' http://www.carpoolingscript.com');
		$this->sms_global->send();
		
		$this->load->view('verify_page',$data);	
	}
	
	
	function newcode()
	{
			$this->load->helper('string');
			$mobile = $this->input->post('cmobile');
			$tripid = $this->input->post('tripid');		
			$reset = $this->otp_model->reset_code($mobile);
			
			if ($reset)
			{	
				die(json_encode(array('result'=>true,'message'=>'verification code sent your mobile')));
			}
			else
			{
				$param['id'] = false;
				$param['Otp_code'] = random_string('numeric', 6);
				$param['mobile'] = $this->input->post('cmobile');
				//$param['trip_id'] = $tripid;				
				$otp_id = $this->otp_model->save($param);
				//$name = $this->input->post('name');
				$this->mobile = $param['mobile'];
				$this->sms_global->to($this->mobile);	
				$this->sms_global->message('your verification code is '.$param['Otp_code'].' http://www.carpoolingscript.com');
				$this->sms_global->send();
				$save['contact_person_number'] = $param['mobile'];
				$save['trip_id'] = $tripid;
				$trip_id = $this->Trip_model->save($save);
				die(json_encode(array('result'=>true,'message'=>'verification code sent your mobile')));
			}
	}
	
	function check()
	{
		$param['mobile'] = $this->input->post('mobile');
		$tripid = $this->input->post('tripid');		
		$param['Otp_code'] = $this->input->post('code');	
		
		if($this->otp_model->verify($param)){
			
			$save['trip_id'] = $tripid;
			$save['trip_otp_status'] = 1;
			$trip_id = $this->Trip_model->save($save);
			die(json_encode(array('result'=>true,'message'=>'Your mobile successfully verified')));
		}
		else
		{
			die(json_encode(array('result'=>false,'message'=>'Invalid code')));
		}
	}
}