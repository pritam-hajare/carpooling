<?php

class Country extends Admin_Controller {

    var $country_id = false;

    function __construct() {
        parent::__construct();

        $this->load->model(array('country_model'));
        $this->load->helper('formatting_helper');
        $this->lang->load('backend');
    }

    function index() {


        $data['page_title'] = ('Category');


        $this->load->library('Pagination_admin');
        $data['page_title'] = ('Category');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'country_ajax';
        $config['base_url'] = site_url('admin/country');
        $data['count_result'] = $this->country_model->count_countries();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['countries'] = $this->country_model->all_countries($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/country', $data);
    }

    function country_ajax() {
        $this->load->library('Pagination_admin');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'country_ajax';
        $config['base_url'] = site_url('admin/country');
        $data['count_result'] = $this->country_model->count_countries();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['countries'] = $this->country_model->all_countries($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/country-list', $data);
    }

    function form($id = false) {
        
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['page_title'] = ('Country Form');

        //default values are empty if the country is new
        $data['countryid'] = '';
        $data['countryname'] = '';
        $data['countrycode'] = '';
        $data['isactive'] = '';


        if ($id) {
            $this->country_id = $id;
            $country = $this->country_model->get_country($id);

            //if the country does not exist, redirect them to the country list with an error
            if (!$country) {
                $this->session->set_flashdata('error', lang('vehicle errors_not_found'));
                redirect($this->config->item('admin_folder') . '/country');
            }

            //set values to db values
            $data['countryid'] = $country->country_id;
            $data['countryname'] = $country->country_name;
            $data['countrycode'] = $country->country_code;
            $data['isactive'] = $country->is_active;
        }

        $this->form_validation->set_rules('countryname', 'lang:countryname', 'trim|required|max_length[250]|callback_check_country');
        $this->form_validation->set_rules('countrycode', 'Country Code', 'trim|required|max_length[250]|callback_check_code');
		

        //if this is a new account require a password, or if they have entered either a password or a password confirmation
        if ($this->form_validation->run() == FALSE) {
            $this->load->view($this->config->item('admin_folder') . '/country_form', $data);
        } else {


            $save['country_id'] = $id;
            $save['country_name'] = $this->input->post('countryname');
            $save['country_code'] = $this->input->post('countrycode');
            $save['is_active'] = $this->input->post('isactive');

            $this->country_model->save($save);
            $this->session->set_flashdata('message', ('The Category has been saved!'));



            //go back to the country list
            redirect($this->config->item('admin_folder') . '/country');
        }
    }

    function delete($id) {
       
            $country = $this->country_model->get_country($id);
            //if the country does not exist, redirect them to the country list with an error
            if ($country) {
                $this->country_model->delete($id);

                $this->session->set_flashdata('message', ('The Category has been deleted!'));
                redirect($this->config->item('admin_folder') . '/country');
            } else {
                $this->session->set_flashdata('error', lang('error_not_found'));
            }
        
    }

    function check_country($str) {
        $name = $this->country_model->check_country($str, $this->country_id);

        if ($name) {
            $this->form_validation->set_message('check_country', 'The country name already in use');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_code($str) {
        $name = $this->country_model->check_code($str, $this->country_id);

        if ($name) {
            $this->form_validation->set_message('check_code', 'The country Code already in use');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function change_status() {
        $this->auth->is_logged_in();

        $user_id = $this->input->post('mid');
        $status = $this->input->post('status');

        if (!empty($user_id) && !empty($status)) {

            $country = (array) $this->country_model->get_country($user_id);

            if (!$country) {
                echo false;
            }

            if ($status == 'enable') {
                $country['is_active'] = '1';
            } elseif ($status == 'disable') {
                $country['is_active'] = '0';
            }
            $id = $this->country_model->save($country);
            echo $id;
        } else {

            echo false;
        }
    }

}
