<?php

class Radius extends Admin_Controller {

    //this is used when editing or adding a provider
    var $radius_id = false;

    function __construct() {
        parent::__construct();

        $this->load->model(array('radius_model'));
        $this->load->helper('formatting_helper');
        $this->lang->load('radius');
    }

    function index() {


        $data['page_title'] = 'Radius Page';

        $this->load->library('pagination_admin');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'radius_ajax';
        $config['base_url'] = site_url('admin/group');
        $data['count_result'] = $this->radius_model->count_radiues();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['radiuses'] = $this->radius_model->all_radiues($this->pagination_admin->per_page, $this->uri->segment(4));



        $this->load->view($this->config->item('admin_folder') . '/radius', $data);
    }

    function radius_ajax() {
        $this->load->library('pagination_admin');
        $data['page_title'] = 'Radius Page';
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'radius_ajax';
        $config['base_url'] = site_url('admin/group');
        $data['count_result'] = $this->radius_model->count_radiues();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['radiuses'] = $this->radius_model->all_radiues($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/radius-list', $data);
    }

    function form($id = false) {
        
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['page_title'] = 'Radius form';

        //default values are empty if the radius is new
        $data['radiusid'] = '';
        $data['distancefrom'] = '';
        $data['distanceto'] = '';
        $data['radius'] = '';






        if ($id) {
            $this->radius_id = $id;

            $radius = $this->radius_model->get_radius($id);



            //if the radius does not exist, redirect them to the radius list with an error
            if (!$radius) {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/radius');
            }

            //set values to db values
            $data['radiusid'] = $radius->id;
            $data['distancefrom'] = $radius->distance_from;
            $data['distanceto'] = $radius->distance_to;
            $data['radius'] = $radius->radius;
        }

        $this->form_validation->set_rules('distancefrom', 'Distance From', 'trim|required|max_length[250]|numeric');
        $this->form_validation->set_rules('radius', 'Distance To', 'trim|required|max_length[32]|numeric');
        $this->form_validation->set_rules('distanceto', 'Radius', 'trim|max_length[128]|numeric');




        if ($this->form_validation->run() == FALSE) {
            $this->load->view($this->config->item('admin_folder') . '/radius-form', $data);
        } else {
            $save['id'] = $id;
            $save['distance_from'] = $this->input->post('distancefrom');
            $save['distance_to'] = $this->input->post('distanceto');
            $save['radius'] = $this->input->post('radius');




            $this->radius_model->save($save);

            $this->session->set_flashdata('message', ('The Radius detail has been saved!'));


            //go back to the radius list
            redirect($this->config->item('admin_folder') . '/radius');
        }
    }

    function delete($id = false) {
        if ($id) {
            $company = $this->radius_model->get_radius($id);
            //if the radius does not exist, redirect them to the radius list with an error
            if (!$company) {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/radius');
            } else {
                //if the radius is legit, delete them
                $delete = $this->radius_model->delete($id);

                $this->session->set_flashdata('message', 'Selected radius details deleted');
                redirect($this->config->item('admin_folder') . '/radius');
            }
        } else {
            //if they do not radius an id send them to the radius list page with an error
            $this->session->set_flashdata('error', lang('errors_not_found'));
            redirect($this->config->item('admin_folder') . '/radius');
        }
    }

}
