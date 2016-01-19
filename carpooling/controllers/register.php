<?php

class Register extends Front_Controller 
{

    function __construct() 
	{
        parent::__construct();

        $this->load->helper('url');
    }

    function index() 
	{

        //we check if they are logged in, generally this would be done in the constructor, but we want to allow customers to log out still
        //or still be able to either retrieve their password or anything else this controller may be extended to do
        $redirect = $this->auth_travel->is_logged_in(false, false);
        //if they are logged in, we send them back to the dashboard by default, if they are not logging in
        if ($redirect) 
		{
            redirect('home');
        }


        $this->load->helper('form');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');

        /*
          we're going to set this up early.
          we can set a redirect on this, if a customer is checking out, they need an account.
          this will allow them to register and then complete their checkout, or it will allow them
          to register at anytime and by default, redirect them to the homepage.
         */
        $data['redirect'] = $this->session->flashdata('redirect');

        $data['seo_title'] = 'Register';
        $data['seo_description'] = '';
        $data['seo_keyword'] = '';


        //default values are empty if the customer is new

        $data['txtfirstname'] = '';
        $data['txtlastname'] = '';
        $data['txtpassword'] = '';
        $data['txtcpassword'] = '';
        $data['txtemail'] = '';
        $data['txtphone'] = '';
        $data['txttype'] = '';


        $this->form_validation->set_rules('txtfirstname', 'Firstname', 'trim|max_length[128]');
        $this->form_validation->set_rules('txtlastname', 'Lastname', 'trim|max_length[128]');
        $this->form_validation->set_rules('txtemail', 'Email', 'trim|required|valid_email|max_length[128]|callback_check_email');
        $this->form_validation->set_rules('txtphone', 'Phone', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('txtpassword', 'Password', 'required|min_length[6]');


        if ($this->form_validation->run() == FALSE) 
		{
            //if they have submitted the form already and it has returned with errors, reset the redirect
            if ($this->input->post('submitted')) 
			{
                $data['redirect'] = $this->input->post('redirect');
            }

            // load other page content 

            $this->load->helper('directory');

            $data['txtfirstname'] = $this->input->post('txtfirstname');
            $data['txtlastname'] = $this->input->post('txtlastname');
            $data['txttype'] = $this->input->post('txttype');
            $data['txtemail'] = $this->input->post('txtemail');
            $data['txtphone'] = $this->input->post('txtphone');



            $data['error'] = validation_errors();


            $this->load->view('register', $data);
        } 
		else 
		{
            $data['seo_title'] = 'Register';
            $data['seo_description'] = '';
            $data['seo_keyword'] = '';

            $save['user_id'] = false;
            $save['user_first_name'] = $this->input->post('txtfirstname');
            $save['user_last_name'] = $this->input->post('txtlastname');
            $save['user_mobile'] = $this->input->post('txtphone');
            $save['user_email'] = $this->input->post('txtemail');
            $code = random_string('alnum', 6);
            $save['isverified'] = sha1($code);
            $save['isactive'] = 0;
            $save['login_type'] = 0;
            $save['user_password'] = sha1($this->input->post('txtpassword'));


            $redirect = $this->input->post('redirect');

            //if we don't have a value for redirect
            if ($redirect == '') 
			{
                $redirect = 'login';
            }

            // save the customer info and get their new id
            $id = $this->Travel_model->save($save);

///*			// send an email */
////			// get the email template
            $res = $this->db->where('tplid', '3')->get('tbl_email_template');
            $row = $res->row_array();

            // set replacement values for subject & body
            // {customer_name}
            
            $row['tplsubject'] =  str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplsubject']);
            
            $row['tplmessage'] = str_replace('{NAME}', $this->input->post('txtfirstname') . '.' . $this->input->post('txtlastname'), $row['tplmessage']);

            $row['tplmessage'] = str_replace('{EMAIL}', $this->input->post('txtemail'), $row['tplmessage']);

            $row['tplmessage'] = str_replace('{IP}', $this->input->ip_address(), $row['tplmessage']);
			
	    $row['tplmessage'] = str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplmessage']);
    
            $row['tplmessage'] = str_replace('{ADMIN_EMAIL}', $this->config->item('admin_email'), $row['tplmessage']);
			



            // {url}
            $row['tplmessage'] = str_replace('{SITE_PATH}', $this->config->item('base_url'), $row['tplmessage']);

            $row['tplmessage'] = str_replace('{code}', $code, $row['tplmessage']);


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

            $this->session->set_flashdata('message', 'Thanks for registering with '. $this->config->item('company_name').'! verification email is sent.');
            redirect($redirect);
        }
    }

    function check_email($str) 
	{
        $email = $this->auth_travel->check_email($str);
        if ($email) 
		{
            $this->form_validation->set_message('check_email', lang('error_email'));
            return FALSE;
        } 
		else 
		{
            return TRUE;
        }
    }

}
