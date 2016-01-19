<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trip extends Front_Controller 
{

    var $student;

    function __construct() 
	{
        parent::__construct();
        $this->load->library('session');
        $this->load->model('trip_model');
        $data['error'] = "";
        $this->CI = & get_instance();
        $this->user = $this->CI->carpool_session->userdata('carpool');
    }

    function index() 
	{
        redirect('home', 'refresh');
    }

    function tripdetails($id) 
	{
        $data['error'] = "";
        $data['staus'] = "";
        $data['islogin'] = false;
		$data['user']='';
        $data['tripdetails'] = $this->trip_model->get_tripdetail($id);

		
		if(!empty($data['tripdetails'])){
			if (!empty($this->user['user_id'])) 
			{
				$data['islogin'] = true;
				$data['user']=$this->user;
				$data['status'] = $this->check_enquiry($this->user['user_id'], $data['tripdetails']['trip_id']);
			}
			$map = $this->trip_model->getmap_details($data['tripdetails']['trip_id']);
			$this->load->library('googlemaps');
			$config['center'] = $map['origin'];
			$config['zoom'] = 'auto';
			$config['directions'] = TRUE;
			$config['directionsStart'] = $map['origin'];
			$config['directionsEnd'] = $map['destination'];
			$config['directionsWaypointArray'] = $map['route'];
			$config['map_height'] = '230px';
			$config['draggable'] = FALSE;
			$config['scrollwheel'] = FALSE;
	
	
	
			$this->googlemaps->initialize($config);
	
	
			$data['map'] = $this->googlemaps->create_map();
			
	
			$this->load->view('trip_detail', $data);
		}
		else
		{
			show_error('Not found trip details');
		}
			
    }

    function check_enquiry($user_id, $trip_id) 
	{

        $this->db->select('*');
        $this->db->where(array('enquiry_passanger_id' => $user_id, 'enquiry_trip_id' => $trip_id));
        $this->db->from('tbl_enquires');
        $result = $this->db->get();
        if ($result->num_rows > 0) 
		{
            return 0;
        } 
		else 
		{
            return 1;
        }
    }

}

?>