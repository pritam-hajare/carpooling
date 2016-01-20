<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Loginapi extends REST_Controller
{
	function facebooklogin_post() {
	
		$this->load->helper('url_helper');
		$this->load->library('Auth_travel');
		$this->load->library('OAuth2');
		try {
			$user['email'] = $this->post('email');
			$user['first_name'] = $this->post('first_name');
			$user['last_name'] = $this->post('last_name');
			$user_id = $this->check_mail($user);
			$this->auth_travel->login_oauth($user_id, $user);
			$this->response('Login success');
		} catch (OAuth2_Exception $e) {
			$this->response('Login error');
		}
	}
	
	function check_mail($profile) {
		$this->load->library('session');
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
					redirect('login');
				}
	
				return $result['user_id'];
			} else {
				$this->load->helper('string');
				$password = random_string('alnum', 6);
	
				$save['user_email'] = $profile['email'];
				$save['user_password'] = sha1($password);
				$save['user_first_name'] = $profile['first_name'];
				$save['user_last_name'] = $profile['last_name'];
				$save['user_last_name'] = $profile['last_name'];
				$save['isactive'] = 1;
				$save['user_admin_status'] = 1;
	
				$this->db->insert('tbl_users', $save);
				$user_id = $this->db->insert_id();
	
	
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
	
				return $user_id;
			}
		} else {
			$this->session->set_flashdata('error', 'Unable to login');
			redirect('login');
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