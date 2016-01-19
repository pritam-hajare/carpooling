<?php
class Currency extends Admin_Controller {

    var $currency_id = false;

    function __construct() {
        parent::__construct();

        $this->load->model(array('currency_model'));
        $this->load->helper('formatting_helper');
        $this->lang->load('backend');
    }

    function index() {


        $data['page_title'] = ('Currency');


        $this->load->library('Pagination_admin');
        $data['page_title'] = ('currency');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'currency_ajax';
        $config['base_url'] = site_url('admin/currency');
        $data['count_result'] = $this->currency_model->count_currencies();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['currencies'] = $this->currency_model->all_currencies($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/currency', $data);
    }

    function currency_ajax() {
        $this->load->library('Pagination_admin');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'currency_ajax';
        $config['base_url'] = site_url('admin/currency');
        $data['count_result'] = $this->currency_model->count_currencies();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['currencies'] = $this->currency_model->all_currencies($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/currency-list', $data);
    }

    function form($id = false) {
        
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['page_title'] = ('currency Form');

        //default values are empty if the currency is new
        $data['currencyid'] = '';
        $data['currencyname'] = '';
        $data['currencysymbol'] = '';		
        $data['isactive'] = '';


        if ($id) {
            $this->currency_id = $id;
            $currency = $this->currency_model->get_currency($id);

            //if the currency does not exist, redirect them to the currency list with an error
            if (!$currency) {
                $this->session->set_flashdata('error', lang('currency errors_not_found'));
                redirect($this->config->item('admin_folder') . '/currency');
            }

            //set values to db values
            $data['currencyid'] = $currency->currency_id;
            $data['currencyname'] = $currency->currency_name;
            $data['currencysymbol'] = $currency->currency_symbol;			
            
        }

        $this->form_validation->set_rules('currencyname', 'lang:currencyname', 'trim|required|max_length[250]|callback_check_currency');
        $this->form_validation->set_rules('currencysymbol', 'currency Symbol', 'trim|required|max_length[250]|callback_check_symbol');
	

        //if this is a new account require a password, or if they have entered either a password or a password confirmation
        if ($this->form_validation->run() == FALSE) {
            $this->load->view($this->config->item('admin_folder') . '/currency_form', $data);
        } else {

            $currencies = array();
            $save['currency_id'] = $id;
            $save['currency_name'] = $this->input->post('currencyname');
            $save['currency_symbol'] = $this->input->post('currencysymbol');
            
            $this->currency_model->save($save);
            $this->session->set_flashdata('message', ('The Currency has been saved!'));



            //go back to the currency list
            redirect($this->config->item('admin_folder') . '/currency');
        }
    }

    function delete($id) {
       
            $currency = $this->currency_model->get_currency($id);
            //if the currency does not exist, redirect them to the currency list with an error
            if ($currency) {
                $this->currency_model->delete($id);

                $this->session->set_flashdata('message', ('The Currency has been deleted!'));
                redirect($this->config->item('admin_folder') . '/currency');
            } else {
                $this->session->set_flashdata('error', lang('error_not_found'));
            }
        
    }

    function check_currency($str) {
        $name = $this->currency_model->check_currency($str, $this->currency_id);

        if ($name) {
            $this->form_validation->set_message('check_currency', 'The currency name already in use');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_symbol($str) {
        $name = $this->currency_model->check_symbol($str, $this->currency_id);

        if ($name) {
            $this->form_validation->set_message('check_symbol', 'The currency Symbol already in use');
            return FALSE;
        } else {
            return TRUE;
        }
    }    

}