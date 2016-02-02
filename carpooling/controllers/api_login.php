<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Api_login extends REST_Controller
{	
	
	function __construct() {
		parent::__construct();
        $this->load->model('App_otp_model');
		$this->load->model('App_sms_model');
	}


	function facebooklogin_post() {
		$result=array();
		$output=array();
		$postData = json_decode(file_get_contents("php://input"), true);
		try {
			$user['email'] = $postData['email'];
			$user['first_name'] = $postData['first_name'];
			$user['gender'] = $postData['gender'];
			$user['gcm_id'] = $postData['g_id'];
			$result = $this->check_mail($user);
			$this->auth_travel->login_oauth($result['user_id'], $user);
			
			if($result['regFbState']=='success'){
				$output['regFbState']=$result['regFbState'];
				$output['u_id']=$result['user_id'];
			}
			else if($result['regFbState']=='already_available'){
				$output['regFbState']=$result['regFbState'];
				$output['u_id']=$result['user_id'];
				$output['fname']=$result['user_first_name'];
				$output['mobile']=$result['user_mobile'];
				$output['mob_vf']=$result['mob_vf'];
			}
			else if($result['regFbState']=='disable'){
				$output['regFbState']=$result['regFbState'];
			}

			$this->response($output);

			//Send otp to mobile no if mobile noavailable and not verified
			if(!empty($output['user_mob']) && $result['regFbState']!='disable'){
				if($output['mob_vf']==0){
					$OTP=rand(100000, 999999);
					$this->App_otp_model->save_otp($output['user_id'],$OTP);
					$this->App_otp_model->send_otp($output['user_mob'],$OTP);	
				}
			}
		} catch (OAuth2_Exception $e) {
			$this->response(array('regFbState'=>'fail'));
		}
	}

	function facebook_logout_post(){
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$param['user_id'] = $postData['u_id'];

		if(!empty($param['user_id'])){
			$data=array('login_state_app'=>0);
			$this->db->update('tbl_users', $data);
			if($this->db->where('user_id',$param['user_id'])){
				$this->response(array('state'=>'success'));
			}
			else{
				$this->response(array('state'=>'fail'));
			}
		}
	}
	
	function check_mail($profile) {
		$result=array();
		if (!empty($profile['email'])) {
			$this->db->select('*');
			$this->db->from('tbl_users');
			$this->db->where('user_email', $profile['email']);
			$this->db->limit(1);
			$result = $this->db->get();
			$result = $result->row_array();
			if (sizeof($result) > 0) {
				if ($result['user_admin_status'] == 0) {
					$this->session->set_flashdata('error', 'Your account is disabled, please contact '.$this->config->item('admin_email'));
					$result['regFbState']='disable';
				}else{
					$result['regFbState']='already_available';	

					$data=array('login_state_app'=>1);
        			$this->db->where('user_id',$result['user_id']);
        			$this->db->update('tbl_users', $data); 	
				}
				
				return $result;
			} else {
				//$this->load->helper('string');
				//$password = random_string('alnum', 6);
	
				$save['user_email'] = $profile['email'];
				$save['user_first_name'] = $profile['first_name'];
				$save['gcm_id'] = $profile['gcm_id'];
				$save['user_gender'] = $profile['gender'];
				$save['isactive'] = 1;
				$save['login_state_app'] = 1;
				$save['user_admin_status'] = 1;
				
				$this->db->insert('tbl_users', $save);
				$user_id = $this->db->insert_id();
				$result['regFbState']='success';	
				$result['user_id']=$user_id;	
				///*			// send an email */
				////			// get the email template
				$res = $this->db->where('tplid', '12')->get('tbl_email_template');
				$row = $res->row_array();
	
				// set replacement values for subject & body
				// {customer_name}
				$row['tplmessage'] = str_replace('{NAME}', $profile['first_name'] . '.' . $profile['last_name'], $row['tplmessage']);
	
				$row['tplmessage'] = str_replace('{EMAIL}', $save['user_email'], $row['tplmessage']);
	
				$row['tplmessage'] = str_replace('{IP}', $this->input->ip_address(), $row['tplmessage']);
	
				// {url}
				$row['tplmessage'] = str_replace('{PASSWORD}', $password, $row['tplmessage']);
	
				$param['message'] = $row['tplmessage'];
	
				$email_subject = $this->load->view('template', $param, TRUE);
	
				$this->load->library('email');
	
				$config['mailtype'] = 'html';
	
				$this->email->initialize($config);
	
				$this->email->from($this->config->item('email'), $this->config->item('company_name'));
				$this->email->to($save['user_email']);
				$this->email->bcc($this->config->item('email'));
				$this->email->subject($row['tplsubject']);
				$this->email->message(html_entity_decode($email_subject));
	
				$this->email->send();
	
				return $result;
			}
		} else {
			$this->session->set_flashdata('error', 'Unable to login');
			//redirect('login');
		}
	}
	
	function user_get()
	{
		if(!$this->get('id'))
		{
			$this->response(NULL, 400);
		}

		$user = $this->user_model->get( $this->get('id') );
		 
		if($user)
		{
			$this->response($user, 200); // 200 being the HTTP response code
		}

		else
		{
			$this->response(NULL, 404);
		}
	}
	 
	function user_post()
	{
		$result = $this->user_model->update( $this->post('id'), array(
				'name' => $this->post('name'),
				'email' => $this->post('email')
		));
		 
		if($result === FALSE)
		{
			$this->response(array('status' => 'failed'));
		}
		 
		else
		{
			$this->response(array('status' => 'success'));
		}
		 
	}
	 
	function users_get()
	{
		$users = $this->user_model->get_all();
		 
		if($users)
		{
			$this->response($users, 200);
		}

		else
		{
			$this->response(NULL, 404);
		}
	}
}
?>