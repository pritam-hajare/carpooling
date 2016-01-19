<?php

class Search extends Front_Controller 
{

    var $travel;
    var $id;

    function __construct() 
	{
        parent::__construct();

        $this->load->library('pagination');
        $this->load->helper('text');
        $this->load->model('search_model');
        $this->load->model('vechicle_model');
        $this->load->model('category_model');
        $this->load->model('trip_model');

        if ($this->auth_travel->is_logged_in(false, false)):
            $this->CI = & get_instance();
            $this->carpool = $this->CI->carpool_session->userdata('carpool');
            $carpool_session['carpool_session'] = $this->CI->carpool_session->userdata('carpool');
            $this->id = $carpool_session['carpool_session']['user_id'];

        else:
            $this->travel = '';
        endif;
    }

    function index() 
	{
        $this->load->helper('form');
        
        $data['seo_title'] = '';
        $data['seo_keyword'] = '';
        $data['seo_description'] = '';
        $term = false;
        $data['error'] = '';
        $data['alert'] = 0;
        $data['email'] = '';

        $data['param'] = '';
        $data['vechicletype'] = $this->vechicle_model->getvechicletype_list();
        $data['vechiclecategory'] = $this->category_model->getcategory_list();

        if ($_GET) 
		{
            $param = array('SOURCE' => $this->input->get('source', true), 'DESTINATION' => $this->input->get('destination', true), 'fromlatlng' => $this->input->get('formlatlng', true), 'tolatlng' => $this->input->get('tolatlng', true), 'frequency' => date('w', strtotime(str_replace("/", "-", $this->input->get('journey_date', true)))), 'date' => $this->input->get('journey_date', true), 'vechiclecategory' => $this->input->get('VECHICATEGORY_FILTER', true), 'vechicletype' => $this->input->get('VECHITYPE_FILTER', true), 'amenities' => $this->input->get('AMENITIES_FILTER', true), 'traveltype' => $this->input->get('TRAVELTYPE_FILTER', true), 'allowtype' => $this->input->get('TRAVELALLOW_FILTER', true), 'frquencytype' => $this->input->post('FREQUENCY_FILTER', true), 'return' => $this->input->get('Return_Type', true));
        } 
		else 
		{

            $param = array('SOURCE' => $this->input->get('source', true), 'DESTINATION' => $this->input->get('destination', true), 'fromlatlng' => $this->input->get('formlatlng', true), 'tolatlng' => $this->input->get('tolatlng', true), 'frequency' => date('w', strtotime(str_replace("/", "-", $this->input->get('journey_date', true)))), 'date' => $this->input->get('journey_date', true), 'vechiclecategory' => $this->input->get('VECHICATEGORY_FILTER', true), 'vechicletype' => $this->input->get('VECHITYPE_FILTER', true), 'amenities' => $this->input->get('AMENITIES_FILTER', true), 'traveltype' => $this->input->get('TRAVELTYPE_FILTER', true), 'frquencytype' => $this->input->get('FREQUENCY_FILTER', true), 'allowtype' => $this->input->get('TRAVELALLOW_FILTER', true), 'return' => $this->input->get('Return_Type', true));
        }

        if (!empty($param['fromlatlng']) && !empty($param['tolatlng']) && !empty($param['date'])) 
		{

            $data['selparam'] = $param;
            $data = $this->search_model->getSearchResults($param, $offset = null, $data);
            $data = $this->search_model->SearchResults_count($param, $data);
            if ($data['count'] == 0) 
			{
                $data['alert'] = 1;
            }
        } 
		else 
		{

            $data['selparam'] = $param;
            $data['count'] = '';
            $data['search_results'] = '';
            $data['error'] = 'Correct source,desination address and date required';
        }
        if (!empty($this->travel)) 
		{
            $data['travel'] = $this->travel;
        }
		
//		echo '<pre>';print_r($data);echo'</pre>';
//		die;

        $this->load->view('search', $data);
    }

    function search_ajax($offset) 
	{
        $this->load->helper('form');

        $param = array('SOURCE' => $this->input->post('source', true), 'DESTINATION' => $this->input->post('destination', true), 'fromlatlng' => $this->input->post('formlatlng', true), 'tolatlng' => $this->input->post('tolatlng', true), 'frequency' => date('w', strtotime(str_replace("/", "-", $this->input->get('journey_date', true)))), 'date' => $this->input->post('journey_date', true), 'vechiclecategory' => $this->input->post('VECHICATEGORY_FILTER', true), 'vechicletype' => $this->input->post('VECHITYPE_FILTER', true), 'filter' => $this->input->post('FILTER', true), 'amenities' => $this->input->post('AMENITIES_FILTER', true), 'traveltype' => $this->input->post('TRAVELTYPE_FILTER', true), 'frquencytype' => $this->input->post('FREQUENCY_FILTER', true), 'allowtype' => $this->input->post('TRAVELALLOW_FILTER', true), 'return' => $this->input->post('Return_Type', true));
        $data['vechicletype'] = $this->vechicle_model->getvechicletype_list();
        $data['selparam'] = $param;

        if (!empty($param['fromlatlng']) && !empty($param['tolatlng']) && !empty($param['date'])) 
		{
            $data = $this->search_model->getSearchResults($param, $offset, $data);
            $data = $this->search_model->SearchResults_count($param, $data);
        } 
		else 
		{
            $data['count'] = '';
            $data['search_results'] = '';
        }

        $data['filter'] = $param['filter'];

        if (!empty($this->travel)) 
		{
            $data['travel'] = $this->travel;
        }

        if ($data['filter'] == 1) 
		{
            $this->load->view('search_ajax', $data);
        }
		 else 
		 {
            $data['currentpage'] = $offset / 5;
            $this->load->view('search_ajax_more', $data);
        }
    }

    function search_map() 
	{
        $this->load->helper('form');

        $param = array('SOURCE' => $this->input->post('source', true), 'DESTINATION' => $this->input->post('destination', true), 'fromlatlng' => $this->input->post('formlatlng', true), 'tolatlng' => $this->input->post('tolatlng', true), 'frequency' => date('w', strtotime(str_replace("/", "-", $this->input->get('journey_date', true)))), 'date' => $this->input->post('journey_date', true), 'vechiclecategory' => $this->input->post('VECHICATEGORY_FILTER', true), 'vechicletype' => $this->input->post('VECHITYPE_FILTER', true), 'filter' => $this->input->post('FILTER', true), 'amenities' => $this->input->post('AMENITIES_FILTER', true), 'traveltype' => $this->input->post('TRAVELTYPE_FILTER', true), 'frquencytype' => $this->input->post('FREQUENCY_FILTER', true), 'allowtype' => $this->input->post('TRAVELALLOW_FILTER', true), 'return' => $this->input->post('Return_Type', true));
        $data['vechicletype'] = $this->vechicle_model->getvechicletype_list();
        $data['selparam'] = $param;

        if (!empty($param['fromlatlng']) && !empty($param['tolatlng']) && !empty($param['date'])) 
		{
            $data = $this->search_model->getSearchResults($param, $offset = 'null', $data, $map_view = 1);
            $data = $this->search_model->SearchResults_count($param, $data);
            if ($data['count'] != 0) 
			{
                $this->load->library('googlemaps');

                $config['center'] = $param['fromlatlng'];
                $config['zoom'] = '10';
                $this->googlemaps->initialize($config);

                if ($data['map_details']) 
				{
                    if ($data['search_results']) 
					{
                        foreach ($data['search_results'] as $result) 
						{
                            $marker = array();
                            $marker['position'] = $data['map_details']['latlng_' . $result['trip_id']];
                            $marker['infowindow_content'] = $data['map_details']['source_' . $result['trip_id']];
                            $marker['icon'] = theme_img('map-marker-ico.png');
                            $this->googlemaps->add_marker($marker);
                        }
                    }
                }

                $data['map'] = $this->googlemaps->create_map();
                $this->load->view('search_map', $data);
            } 
			else 
			{
                echo false;
            }
        }
    }

}

?>
