<?php

class Home extends Front_Controller 
{

    function __construct() 
	{
        parent::__construct();
        $this->load->model('Home_model');
     
    }

    function index() 
	{
        $this->load->helper('form');
        $this->load->helper('text');
        $data['testimonials'] = $this->Home_model->get_testimonials($limit = 3);
        $data = $this->Home_model->get_recently_trip_list($limit = 10, $data);
//        echo '<pre>';print_r($data);echo'</pre>';exit;

        $this->load->view('home', $data);
    }

}

?>
