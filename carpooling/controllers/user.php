<?php

class User extends CI_Controller 
{

    function __construct() 
	{
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->helper('url');
    }

    function access() 
	{
        $id = $this->uri->segment(3);

        $id = sha1($id);
        if ($this->Customer_model->check_access($id)) 
		{
            $this->session->set_flashdata('message', 'Your account has been verified and activated');
            redirect('login');
        } 
		else 
		{
            $this->session->set_flashdata('message', 'Code is incorrect');
            redirect('login');
        }
    }

}

?>