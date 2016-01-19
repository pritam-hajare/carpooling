<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_travel
{
	var $CI;
	
	//this is the expiration for a non-remember session
	var $session_expire	= 600;

	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->library('encrypt');
		$this->CI->load->helper('date');
		
		$carpool_session_config = array(
		    'sess_cookie_name' => 'carpool_session_config',
		    'sess_expiration' => 0
		);
		$this->CI->load->library('session', $carpool_session_config, 'carpool_session');
		
		$this->CI->load->helper('url');
	}
	
	function check_access($access, $default_redirect=false, $redirect = false)
	{
		echo "test";
		exit;
		
	}
	
        /*
	this checks to see if the provider is logged in
	we can provide a link to redirect to, and for the login page, we have $default_redirect,
	this way we can check if they are already logged in, but we won't get stuck in an infinite loop if it returns false.
	*/
	function is_logged_in($redirect = false, $default_redirect = true)
	{
	
		//var_dump($this->CI->provider_session->userdata('session_id'));

		//$redirect allows us to choose where a customer will get redirected to after they login
		//$default_redirect points is to the login page, if you do not want this, you can set it to false and then redirect wherever you wish.

		$carpool = $this->CI->carpool_session->userdata('carpool');
	
		if (!$carpool)
		{
			if ($redirect)
			{
				$this->CI->carpool_session->set_flashdata('redirect', $redirect);
			}
				
			if ($default_redirect)
			{	
				redirect('login');
			}
			
			return false;
		}
		else
		{
		
			//check if the session is expired if not reset the timer
			if($carpool['expire'] && $carpool['expire'] < time())
			{

				$this->logout();
				if($redirect)
				{
					$this->CI->carpool_session->set_flashdata('redirect', $redirect);
				}

				if($default_redirect)
				{
					redirect('login');
				}

				return false;
			}
			else
			{

				//update the session expiration to last more time if they are not remembered
				if($carpool['expire'])
				{
					$carpool['expire'] = time()+$this->session_expire;
					$this->CI->carpool_session->set_userdata(array('carpool'=>$carpool));
				}

			}

			return true;
		}
	}
	/*
	this function does the logging in.
	*/
	function login_travel($email, $password, $remember=false)
	{
		$this->CI->db->select('*');
		$this->CI->db->where('user_email', $email);
		$this->CI->db->where('user_password',  sha1($password));
		$this->CI->db->where('isactive',  1);
		
		$this->CI->db->limit(1);
		$result = $this->CI->db->get('tbl_users');
		
		$result	= $result->row_array();
		
		if (sizeof($result) > 0)
		{
			if($result['user_admin_status'] == 0 ){
				$this->CI->session->set_flashdata('error','Your account is disabled, please contact '.$this->CI->config->item('admin_email'));
				redirect('login');
			}
			$save['user_id'] =  $result['user_id'];
			$save['user_lost_login'] = date('Y-m-d H:i:s',now());
			
			$this->save($save);
			$carpool = array();
			$carpool['carpool']			= array();
			$carpool['carpool']['user_email']		= $result['user_email'];
			$carpool['carpool']['access'] 	= 'travel';			
			$carpool['carpool']['user_id']	= $result['user_id'];
			$carpool['carpool']['trip_id']	= $this->trips($result['user_id']);
		
			if(!$remember)
			{
				
				$carpool['carpool']['expire'] = time()+$this->session_expire;
			}
			else
			{
				
				$carpool['carpool']['expire'] = false;
			}

			$this->CI->carpool_session->set_userdata($carpool);
			$data['login_ip']=$this->CI->input->ip_address();
			$data['login_id']=$result['user_id'];					
			$id=$this->savelog($data);
		
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	function login_oauth($user_id,$user_profile){
		
		$carpool = array();
		$carpool['carpool']			= array();
		$carpool['carpool']['user_email']		= $user_profile['email'];
		$carpool['carpool']['access'] 		= 'travel';		
		$carpool['carpool']['user_id']	= $user_id;
		$carpool['carpool']['trip_id']	= $this->trips($user_id);
		$carpool['carpool']['expire'] = time()+$this->session_expire;
		$save['user_id'] =  $user_id;
		$save['user_lost_login'] = date('Y-m-d H:i:s',now());
		$data['login_ip']=$this->CI->input->ip_address();
		$data['login_id']=$user_id;					
		$id=$this->savelog($data);
		
		$this->save($save);
		$this->CI->carpool_session->set_userdata($carpool);
		
	}
	
	/*
	this function does the logging out
	*/
	function logout()
	{
		$this->CI->carpool_session->unset_userdata('travel');
		$this->CI->carpool_session->sess_destroy();
	}

	/*
	This function resets the providers password and emails them a copy
	*/
	function reset_password($email)
	{
		$travel = $this->get_travel_by_email($email);
		if ($travel)
		{
			$this->CI->load->helper('string');
			$this->CI->load->library('email');
			
			$new_password		= random_string('alnum', 8);
			$travel['user_password']	= sha1($new_password);
			$this->save($travel);
			
			$this->CI->email->from($this->CI->config->item('email'), $this->CI->config->item('site_name'));
			$this->CI->email->to($email);
			$this->CI->email->subject($this->CI->config->item('site_name').': traveler Password Reset');
			$this->CI->email->message('Your password has been reset to '. $new_password .'.');
			$this->CI->email->send();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	This function gets the provider by their email address and returns the values in an array
	it is not intended to be called outside this class
	*/
	private function get_travel_by_email($email)
	{
		$this->CI->db->select('*');
		$this->CI->db->where('user_email', $email);
		$this->CI->db->limit(1);
		$result = $this->CI->db->get('tbl_users');
		$result = $result->row_array();

		if (sizeof($result) > 0)
		{
			return $result;	
		}
		else
		{
			return false;
		}
	}
	
	/*
	This function takes provider array and inserts/updates it to the database
	*/
	function save($travel)
	{
		if ($travel['user_id'])
		{
			$this->CI->db->where('user_id', $travel['user_id']);
			$this->CI->db->update('tbl_users', $travel);
			
		}
		else
		{
			$this->CI->db->insert('tbl_users', $travel);
		}
	}
	
	
	/*
	This function gets a complete list of all provider
	*/
	function get_travel_list()
	{
		$this->CI->db->select('*');
		$this->CI->db->order_by('user_first_name', 'ASC');
		$this->CI->db->order_by('user_last_name', 'ASC');
		$this->CI->db->order_by('user_email', 'ASC');
		$result = $this->CI->db->get('tbl_users');
		$result	= $result->result();
		
		return $result;
	}

	/*
	This function gets an individual provider
	*/
	function get_travel($id)
	{
		$this->CI->db->select('*');
		$this->CI->db->where('user_id', $id);
		$result	= $this->CI->db->get('tbl_users');
		$result	= $result->row();
		return $result;
	}		
	
	function check_id($str)
	{
		$this->CI->db->select('user_id');
		$this->CI->db->from('tbl_users');
		$this->CI->db->where('user_id', $str);
		$count = $this->CI->db->count_all_results();
		
		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	function check_email($str, $id=false)
	{
		$this->CI->db->select('user_email');
		$this->CI->db->from('tbl_users');
		$this->CI->db->where('user_email', $str);
		if ($id)
		{
			$this->CI->db->where('user_id !=', $id);
		}
		$count = $this->CI->db->count_all_results();
		
		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function trips($tripid)
	{
		$this->CI->db->select('tbl_trips.trip_id');
		$this->CI->db->from('tbl_trips');
		$this->CI->db->join('tbl_enquires','tbl_trips.trip_id = tbl_enquires.enquiry_trip_id','inner');
		$this->CI->db->where('tbl_enquires.enquiry_passanger_id',$tripid);
		$views = $this->CI->db->get();			
		//print_r($views->result_array());
		//die;
		//return $views->result_array();
		 $trip_id = array();
		 if($views->num_rows() > 0)
        {
            
            if($views->result())
            {	
				$i=0;
                foreach ($views->result() as $id)
                {
                    $proj_id[$i] = $id->trip_id;
					$i++;
                }
               /* print_r($proj_id);
				die;*/
				return $trip_id;
            }
           
        }
		 else 
            {
                return false;
            }
	}

	function delete($id)
	{
		if ($this->check_id($id))
		{
			$provider	= $this->get_provider($id);
			$this->CI->db->where('user_id', $id);
			$this->CI->db->limit(1);
			$this->CI->db->delete('tbl_users');

			return $provider->user_first_name.' '.$provider->user_last_name.' has been removed.';
		}
		else
		{
			return 'The provider could not be found.';
		}
	}
	
	function savelog($data)
	{
		$this->CI->db->insert('tbl_t_login_logs', $data);
		return $this->CI->db->insert_id();
	}
}