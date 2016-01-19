<?php

class Category extends Admin_Controller {

    //this is used when editing or adding a provider
    var $category_id = false;

    function __construct() {
        parent::__construct();

        $this->load->model(array('category_model'));
        $this->load->helper('formatting_helper');
        $this->lang->load('backend');
    }

    function index() {


        $data['page_title'] = ('Category');


        $this->load->library('Pagination_admin');
        $data['page_title'] = ('Vehicle Brand');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'category_ajax';
        $config['base_url'] = site_url('admin/category');
        $data['count_result'] = $this->category_model->count_categories();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['categories'] = $this->category_model->all_categories($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/category', $data);
    }

    function category_ajax() {
        $this->load->library('Pagination_admin');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'category_ajax';
        $config['base_url'] = site_url('admin/category');
        $data['count_result'] = $this->category_model->count_categories();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['categories'] = $this->category_model->all_categories($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/category-list', $data);
    }

    function form($id = false) {
        
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['page_title'] = ('Vehicle Brand Form');

        //default values are empty if the provider is new
        $data['categoryid'] = '';
        $data['categoryname'] = '';
        $data['isactive'] = '';


        if ($id) {
            $this->category_id = $id;
            $category = $this->category_model->get_category($id);

            //if the provider does not exist, redirect them to the provider list with an error
            if (!$category) {
                $this->session->set_flashdata('error', lang('vehicle errors_not_found'));
                redirect($this->config->item('admin_folder') . '/category');
            }

            //set values to db values
            $data['categoryid'] = $category->category_id;
            $data['categoryname'] = $category->category_name;
            $data['isactive'] = $category->is_active;
        }

        $this->form_validation->set_rules('categoryname', 'Vehicle Brand Name', 'trim|required|max_length[250]|callback_check_category');

        //if this is a new account require a password, or if they have entered either a password or a password confirmation
        if ($this->form_validation->run() == FALSE) {
            $this->load->view($this->config->item('admin_folder') . '/category-form', $data);
        } else {


            $save['category_id'] = $id;
            $save['category_name'] = $this->input->post('categoryname');
            $save['is_active'] = $this->input->post('isactive');

            $this->category_model->save($save);
            $this->session->set_flashdata('message', ('The Category has been saved!'));



            //go back to the category list
            redirect($this->config->item('admin_folder') . '/category');
        }
    }

    function delete($id) {
        $vehicle = $this->category_model->check_vehicle($id);

        //if the category does not exist, redirect them to the category list with an error
        if ($vehicle) {

            $this->session->set_flashdata('error', 'Please delete the vehicle type under the vehicle brand');
            redirect($this->config->item('admin_folder') . '/category');
        } else {
            $category = $this->category_model->get_category($id);
            //if the category does not exist, redirect them to the category list with an error
            if ($category) {
                $this->category_model->delete($id);

                $this->session->set_flashdata('message', ('The vehicle brand has been deleted!'));
                redirect($this->config->item('admin_folder') . '/category');
            } else {
                $this->session->set_flashdata('error', lang('error_not_found'));
            }
        }
    }

   
    function check_category($str) {
        $name = $this->category_model->check_category($str, $this->category_id);

        if ($name) {
            $this->form_validation->set_message('check_category', 'The vehicle brand name already in use');
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

            $category = (array) $this->category_model->get_category($user_id);

            if (!$category) {
                echo false;
            }

            if ($status == 'enable') {
                $category['is_active'] = '1';
            } elseif ($status == 'disable') {
                $category['is_active'] = '0';
            }
            $id = $this->category_model->save($category);
            echo $id;
        } else {

            echo false;
        }
    }

}
