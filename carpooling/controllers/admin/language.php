<?php

class Language extends Admin_Controller {

    var $language_id = false;

    function __construct() {
        parent::__construct();

        $this->load->model(array('language_model'));
        $this->load->helper('formatting_helper');
		$this->lang->load('backend');
        
    }

    function index() {


        $data['page_title'] = ('Language');


        $this->load->library('Pagination_admin');
        $data['page_title'] = ('language');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'language_ajax';
        $config['base_url'] = site_url('admin/language');
        $data['count_result'] = $this->language_model->count_languages();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['languages'] = $this->language_model->all_languages($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/language', $data);
    }

    function language_ajax() {
        $this->load->library('Pagination_admin');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'language_ajax';
        $config['base_url'] = site_url('admin/language');
        $data['count_result'] = $this->language_model->count_languages();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['languages'] = $this->language_model->all_languages($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/language-list', $data);
    }

    function form($id = false) {
        
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['page_title'] = ('language Form');

        //default values are empty if the language is new
        $data['languageid'] = '';
        $data['languagename'] = '';
        $data['languagecode'] = '';		
        $data['isactive'] = '';


        if ($id) {
            $this->language_id = $id;
            $language = $this->language_model->get_language($id);

            //if the language does not exist, redirect them to the language list with an error
            if (!$language) {
                $this->session->set_flashdata('error', lang('language errors_not_found'));
                redirect($this->config->item('admin_folder') . '/language');
            }

            //set values to db values
            $data['languageid'] = $language->language_id;
            $data['languagename'] = $language->language_name;
            $data['languagecode'] = $language->language_code;			
            
        }

        $this->form_validation->set_rules('languagename', 'lang:languagename', 'trim|required|max_length[250]|callback_check_language');
        $this->form_validation->set_rules('languagecode', 'language Code', 'trim|required|max_length[250]|callback_check_code');
	

        //if this is a new account require a password, or if they have entered either a password or a password confirmation
        if ($this->form_validation->run() == FALSE) {
            $this->load->view($this->config->item('admin_folder') . '/language_form', $data);
        } else {

            $languages = array();
            $save['language_id'] = $id;
            $save['language_name'] = $this->input->post('languagename');
            $save['language_code'] = $this->input->post('languagecode');
            
            if (!defined('ENVIRONMENT') AND !is_dir(APPPATH . 'language/' . ENVIRONMENT . '/' . $save['language_name'])) {
                
                $dirPath = APPPATH . 'language/' . ENVIRONMENT . '/' . $save['language_name'];        
                mkdir($dirPath, 0755);
                if(is_dir(APPPATH . 'language/' . $save['language_name'])){
                    
                    $file_contents_1 = $this->load->view('admin/templates/language', $languages, true);
					//echo '<pre>';print_r($file_contents_1);echo'</pre>';
                    $file_1 = $dirPath.'/'.$save['language_code'].'_lang.php';
                    if (file_exists($file_1)) {
                        unlink($file_1);
                    }
                    write_file($file_1, $file_contents_1);
                }
                
                
            } elseif (!is_dir(APPPATH . 'language/' . $save['language_name'])) {                
                $dirPath = APPPATH . 'language/' . $save['language_name'];        
                mkdir($dirPath, 0755);
                if(is_dir(APPPATH . 'language/' . $save['language_name'])){
                    
                    $file_contents_1 = $this->load->view('admin/templates/language', $languages, true);
					//echo '<pre>';print_r($file_contents_1);echo'</pre>';
                    $file_1 = $dirPath.'/'.$save['language_code'].'_lang.php';
                    if (file_exists($file_1)) {
                        unlink($file_1);
                    }
                    write_file($file_1, $file_contents_1);                  
                    
                    
                }
                
            }
			
			//die;
            
            $this->language_model->save($save);
            $this->session->set_flashdata('message', ('The Language has been saved!'));



            //go back to the language list
            redirect($this->config->item('admin_folder') . '/language');
        }
    }

    function delete($id) {
       
            $language = $this->language_model->get_language($id);
            //if the language does not exist, redirect them to the language list with an error
            if ($language) {
                $this->language_model->delete($id);

                $this->session->set_flashdata('message', ('The Language has been deleted!'));
                redirect($this->config->item('admin_folder') . '/language');
            } else {
                $this->session->set_flashdata('error', lang('error_not_found'));
            }
        
    }

    function check_language($str) {
        $name = $this->language_model->check_language($str, $this->language_id);

        if ($name) {
            $this->form_validation->set_message('check_language', 'The language name already in use');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_code($str) {
        $name = $this->language_model->check_code($str, $this->language_id);

        if ($name) {
            $this->form_validation->set_message('check_code', 'The language Code already in use');
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

            $language = (array) $this->language_model->get_language($user_id);

            if (!$language) {
                echo false;
            }

            if ($status == 'enable') {
                $language['is_active'] = '1';
            } elseif ($status == 'disable') {
                $language['is_active'] = '0';
            }
            $id = $this->language_model->save($language);
            echo $id;
        } else {

            echo false;
        }
    }

}




