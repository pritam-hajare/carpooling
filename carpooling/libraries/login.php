<?php
class Login extends Front_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('Auth_travel');
		$this->load->library('OAuth2');
		$this->lang->load('login');
		$this->load->model('Travel_model');
		$this->config->load('facebook');
		$this->load->helper('url');
		
	
	}

	function index()
	{
	
		//we check if they are logged in, generally this would be done in the constructor, but we want to allow customers to log out still
		//or still be able to either retrieve their password or anything else this controller may be extended to do
		$redirect	= $this->auth_travel->is_logged_in(false, false);
		//if they are logged in, we send them back to the dashboard by default, if they are not logging in
		if ($redirect)
		{
			redirect('dashboard');
		}
		
		$data['seo_title']	= '';
		$data['seo_description']='';
		$data['seo_keyword']='';
		$this->load->helper('form');
		$data['redirect']	= $this->session->flashdata('redirect');
		$submitted 			= $this->input->post('submitted');
		if ($submitted)
		{
			$email		= $this->input->post('txtUserName');
			$password	= $this->input->post('txtPassword');
			$remember   = $this->input->post('remember');
			$redirect	= $this->input->post('redirect');
			//echo $remember;
			//die;
			$login		= $this->auth_travel->login_travel($email, $password, $remember);
			if ($login)
			{
				if ($redirect == '')
				{
					$redirect = 'dashboard';
				}
				redirect($redirect);
			}
			else
			{
				//this adds the redirect back to flash data if they provide an incorrect credentials
				$this->session->set_flashdata('redirect', $redirect);
				$this->session->set_flashdata('error', lang('error_authentication_failed'));
				redirect('login');
			}
		}
		$this->load->view('login', $data);
	
		
	 }
	
	
	
	
	
	
	
	function loginvalidated($ajax = false)
	{
		$redirect	= $this->auth_travel->is_logged_in(false, false);
		//if they are logged in, we send them back to the dashboard by default, if they are not logging in
		if ($redirect)
		{
			redirect('dashboard');
		}
		
		
		$this->load->helper('form');
		$data['redirect']	= $this->session->flashdata('redirect');
		//die;
		$submitted 			= $this->input->post('submitted');
		
		if ($submitted)
		{
			 $email		= $this->input->post('txtUserName');			
			 $password	= $this->input->post('txtPassword');			 
			$remember   = $this->input->post('remember');
			$redirect	= $this->input->post('redirect');			
			$login		= $this->auth_travel->login_travel($email, $password, $remember);
			
			if ($login)
			{
				
				if($ajax)
				{
					die(json_encode(array('result'=>true,'redirect'=>$redirect)));
				}
				else
				{
					if ($redirect == '')
					{
						//if there is not a redirect link, send them to the my account page
						redirect('dashboard');
					}
					redirect($redirect);
				}
			}
			else
			{
				
				if($ajax)
				{
					die(json_encode(array('result'=>false)));
				}
				else
				{
					$this->session->set_flashdata('redirect', $redirect);
					$this->session->set_flashdata('error', lang('login_failed'));
					
					redirect('login');
				}
				
			}
		}
		$this->load->helper('directory');
		$this->load->view('login', $data);
	}
	
	function logout()
	{
		$this->auth_travel->logout();
		
		//when someone logs out, automatically redirect them to the login page.
		$this->session->set_flashdata('message', lang('message_logged_out'));
		redirect('login');
	}
	
	
	function forget_password()
	{
		$this->load->helper('form');	
		$this->load->view('forgetpassword');
	}
	
	
	function send_password($ajax=false)
	{
		
		//find out if they're already logged in, if they are redirect them to the my account page
		$redirect	= $this->auth_travel->is_logged_in(false, false);
		//if they are logged in, we send them back to the my_account by default, if they are not logging in
		if ($redirect)
		{
			redirect('dashboard');
		}
		
		$data['page_title']	= 'Login Verify';
		//$data['gift_cards_enabled'] = $this->gift_cards_enabled;
		
		$this->load->helper('form');
		$data['redirect']	= $this->session->flashdata('redirect');
		$submitted = $this->input->post('submitted');
		
		if ($submitted)
		{
			$this->load->helper('string');
			$email = $this->input->post('email');
			$data['user_email ']=$email;
			$reset = $this->Travel_model->reset_password($email);
			
			if ($reset)
			{						
				$this->session->set_flashdata('message', lang('message_new_provider_password'));
				if($ajax)
				{
					$redirect = $this->input->post('redirect');
					die(json_encode(array('result'=>true,'redirect'=>$redirect,'message'=>lang('message_new_travel_password'))));
				}
				else{
				
					redirect($redirect);
				}
			}
			else
			{
				$this->session->set_flashdata('error', lang('error_no_account_record'));
				if($ajax)
				{
					$redirect = $this->input->post('redirect');
					die(json_encode(array('result'=>false,'redirect'=>$redirect,'message'=>lang('error_no_account_record'))));
				}
				else
				{
					$this->session->set_flashdata('redirect', $redirect);
					$this->session->set_flashdata('error', lang('login_failed'));
					
					//redirect('student/login');
				}
			}
			
				
			redirect('login/send_password');
			
			
		}
		
		
		//$this->load->view('forgot_password', $data);
	}
	
	public function sociallogin($provider) { 

    	 $this->load->helper('url_helper');
         //facebook
         if($provider == 'facebook') {
                $app_id = $this->config->item('fb_appid');
		$app_secret = $this->config->item('fb_appsecret');		
		$provider	= $this->oauth2->provider($provider, array(
			'id' => $app_id,
			'secret' => $app_secret,
			));			
		}
	//google
		else if($provider == 'google'){

			$app_id 		= $this->config->item('googleplus_appid');
			$app_secret 	= $this->config->item('googleplus_appsecret');
			$provider 		= $this->oauth2->provider($provider, array(
				'id' => $app_id,
				'secret' => $app_secret,
			)); 			
		}

	

	if ( ! $this->input->get('code'))
        {  
            // By sending no options it'll come back here
            $provider->authorize();
            redirect('social?error');
        }
        else
        {
            // Howzit?
            try
            {
                $token = $provider->access($_GET['code']);
                $user = $provider->get_user_info($token);
				

                if($this->uri->segment(3) == 'google'){
					
                     $user_id = $this->check_mail($user);
					 $this->auth_travel->login_oauth($user_id,$user);
					 redirect('home');
                }

                elseif($this->uri->segment(3) == 'facebook'){
                    $user_id = $this->check_mail($user);
					 $this->auth_travel->login_oauth($user_id,$user);
					 redirect('home');         

            	}

        	$this->session->set_flashdata('info',$message);
                redirect('social?tabindex=s&status=sucess');

            }

            catch (OAuth2_Exception $e)
            {
                redirect('home');
            }

        }
	}

	
	
	
	function check_mail($profile){
		$this->load->library('session');
		if(!empty($profile['email'])){
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('user_email', $profile['email']);
		//$this->db->where('isactive',  1);
		$this->db->limit(1);		
		//$count = $this->CI->db->count_all_results();		
		$result = $this->db->get();
		$result	= $result->row_array();
		/*print_r($result);
		die;*/
		if (sizeof($result) > 0)
		{
			if($result['user_admin_status'] == 0 ){
				$this->session->set_flashdata('error','Your account is disabled, please contact info@carpooling.in ');
				redirect('login');
			}
				
			return $result['user_id'];
			//return true;
		}
		else
		{
			$this->load->helper('string');
			$password=random_string('alnum', 6);
			
			$save['user_email'] = $profile['email'];
			$save['user_password'] = sha1($password);
			$save['user_first_name'] = $profile['first_name'];
			$save['user_last_name'] = $profile['last_name'];
			$save['user_last_name'] = $profile['last_name'];
			$save['isactive']= 1;
			$save['user_admin_status']= 1;
			
			$this->db->insert('tbl_users',$save);
			$user_id = $this->db->insert_id();
			
//			$id =  $this->db->insert_id();

///*			// send an email */
////			// get the email template
			$res = $this->db->where('tplid', '12')->get('tbl_email_template');
			$row = $res->row_array();
			
			// set replacement values for subject & body
			
			// {customer_name}
			$row['tplmessage'] = str_replace('{NAME}', $profile['first_name'].'.'.$profile['last_name'], $row['tplmessage']);

			$row['tplmessage'] = str_replace('{EMAIL}', $save['user_email'], $row['tplmessage']);
			
			$row['tplmessage'] = str_replace('{IP}', $this->input->ip_address(), $row['tplmessage']);
			
			// {url}
			$row['tplmessage'] = str_replace('{PASSWORD}', $password, $row['tplmessage']);
			
			
			
			$this->load->library('email');
			
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
	
			$this->email->from($this->config->item('email'), $this->config->item('company_name'));
			$this->email->to($save['user_email']);
			$this->email->bcc($this->config->item('email'));
			$this->email->subject($row['tplsubject']);
			$this->email->message(html_entity_decode($row['tplmessage']));
			
			$this->email->send();
			
			return $user_id;			
			
				
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'Unable to login');
			redirect('login');
		}
	}
	


}

?>
