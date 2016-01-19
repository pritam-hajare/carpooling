<?php

class Admin extends Admin_Controller {

    //these are used when editing, adding or deleting an admin
    var $CI;
    var $admin_id = false;
    var $current_admin = false;
	var $user = '';


    function __construct() {
        parent::__construct();
        $this->auth->check_access('Admin', true);

        //load the admin language file in
		
        $this->lang->load('admin');
        $this->load->helper(array('file'));
        $this->load->model(array('country_model','currency_model','language_model','logo_model'));
        $this->CI = & get_instance();
        $this->current_admin = $this->CI->admin_session->userdata('admin');
		$this->user = $this->CI->admin_session->userdata('admin');
    }

    function index() {
        $data['page_title'] = lang('admins');
        $data['admins'] = $this->auth->get_admin_list();

        $this->load->view($this->config->item('admin_folder') . '/admins', $data);
    }

    function delete($id) {

        //even though the link isn't displayed for an admin to delete themselves, if they try, this should stop them.
        if ($this->current_admin['id'] == $id) {

            $this->session->set_flashdata('error', lang('error_self_delete'));
            redirect($this->config->item('admin_folder') . '/admin');
        }

        //delete the user
        $this->auth->delete($id);
        $this->session->set_flashdata('message', lang('message_user_deleted'));
        redirect($this->config->item('admin_folder') . '/admin');
    }

    function form($id = false) {
		      
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['page_title'] = lang('admin_form');

        //default values are empty if the customer is new
        $data['id'] = '';
        $data['name'] = '';
        $data['email'] = '';
        $data['access'] = '';

        if ($id) {
            $this->admin_id = $id;
            $admin = $this->auth->get_admin($id);
            //if the administrator does not exist, redirect them to the admin list with an error
            if (!$admin) {
                $this->session->set_flashdata('message', lang('admin_not_found'));
                redirect($this->config->item('admin_folder') . '/admin');
            }
            //set values to db values
            $data['id'] = $admin->id;
            $data['name'] = $admin->admin_name;
            $data['email'] = $admin->admin_email;
        }

        $this->form_validation->set_rules('name', 'Admin Name', 'trim|required|max_length[32]');

        $this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|max_length[128]|callback_check_email');


        //if this is a new account require a password, or if they have entered either a password or a password confirmation
        if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id) {
            $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]|sha1');
            $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->load->view($this->config->item('admin_folder') . '/admin_form', $data);
        } else {
            $save['id'] = $id;
            $save['admin_name'] = $this->input->post('name');
            $save['admin_email'] = $this->input->post('email');


            if ($this->input->post('password') != '' || !$id) {
                $save['admin_password'] = $this->input->post('password');
            }


            $this->auth->save($save);

            $this->session->set_flashdata('message', lang('message_user_saved'));

            //go back to the admin list
            redirect($this->config->item('admin_folder') . '/admin');
        }
    }

    function check_email($str) {
        $email = $this->auth->check_email($str, $this->admin_id);
        if ($email) {
            $this->form_validation->set_message('check_email', lang('error_email_taken'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function changepwd_form($id = false) {
        $this->admin_id = $id;

        if (!$id) {
            $this->admin_id = $this->current_admin['id'];
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['redirect'] = '';
        $data['error'] = '';
        $data['page_title'] = 'Change Password Form';
        if ($this->admin_id) {

            $profile = $this->auth->get_admin($this->admin_id);
            if (!$profile) {

                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect('admin/dashboard');
            }


            //set values to db values
            $data['id'] = $this->admin_id;


            //make sure we haven't submitted the form yet before we pull in the images/related products from the database
        }

        $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]|sha1');
        $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');



        if ($this->form_validation->run() == FALSE) {
            $data['error'] = $this->load->view($this->config->item('admin_folder') . '/change_password', $data);
        } else {
            $this->load->helper('text');



            $save['id'] = $this->admin_id;            
            $save['admin_password'] = $this->input->post('password');
            
           
            // save password
            $profile_id = $this->auth->save($save);



            $this->session->set_flashdata('message', 'Your password has been changed');


            redirect('admin/dashboard');
        }
    }

    function edit_profile($id = false) {
        $this->admin_id = $id;

        if (!$id) {
            $this->admin_id = $this->current_admin['id'];
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data['redirect'] = '';
        $data['error'] = '';
        $data['page_title'] = 'Edit Profile Form';
        if ($this->admin_id) {

            $admin = $this->auth->get_admin($this->admin_id);
            if (!$admin) {

                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect('admin/dashboard');
            }


            //set values to db values
            $data['id'] = $this->admin_id;
            $data['company_name'] = $admin->company_name;
            $data['company_email'] = $admin->company_email;
            $data['company_mobile'] = $admin->company_mobile;
            $data['first_name'] = $admin->first_name;
            $data['last_name'] = $admin->last_name;

            //make sure we haven't submitted the form yet before we pull in the images/related products from the database
        }

        $this->form_validation->set_rules('company_name', 'Comapany Name', 'trim|max_length[32]');
        $this->form_validation->set_rules('first_name', 'lang:firstname', 'trim|max_length[32]');
        $this->form_validation->set_rules('last_name', 'lang:lastname', 'trim|max_length[32]');
        $this->form_validation->set_rules('company_email', 'lang:email', 'trim|valid_email|max_length[128]|callback_check_email');
        $this->form_validation->set_rules('company_mobile', 'Company mobile', 'trim|max_length[10]|min_length[10]|numeric');



        if ($this->form_validation->run() == FALSE) {
            $data['error'] = $this->load->view($this->config->item('admin_folder') . '/edit_profile', $data);
        } else {
            $this->load->helper('text');



            $save['id'] = $this->admin_id;
            $save['company_email'] = $this->input->post('company_email');
            $save['company_name'] = $this->input->post('company_name');
            $save['company_mobile'] = $this->input->post('company_mobile');
            $save['first_name'] = $this->input->post('first_name');
            $save['last_name'] = $this->input->post('last_name');


            // save password
            $profile_id = $this->auth->save($save);



            $this->session->set_flashdata('message', 'Your Profile has been changed');


            redirect('admin/dashboard');
        }
    }

    function edit_settings() {

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');


        $subfolder = rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/\\') . '/';
        $configFileName = str_replace('/', '', APPPATH);
        $settings = array();
        // Load the routes.php file.
        if (defined('ENVIRONMENT') AND is_file(APPPATH . 'config/' . ENVIRONMENT . '/' . $configFileName . '.php')) {
            include(APPPATH . 'config/' . ENVIRONMENT . '/' . $configFileName . '.php');
        } elseif (is_file(APPPATH . 'config/' . $configFileName . '.php')) {
            include(APPPATH . 'config/' . $configFileName . '.php');
        }

        $settings = (!isset($config) OR ! is_array($config)) ? array() : $config;
        unset($config);

        $data['redirect'] = '';
        $data['error'] = '';
       
        $data['currency_id'] ='';
        $data['countries'] = $this->country_model->getcountry_list();
        $data['currencies'] = $this->currency_model->getcurrency_list();
        $data['languages'] = $this->language_model->getlanguage_list();
        
        $currency = $this->currency_model->get_currency_id($settings['currency']);
        if($currency){
            
            $data['currency_id'] = $currency->currency_id;
        }


        $data['country'] = $settings['country_code'];
        $data['currency_name'] = $settings['currency'];
        $data['currency_symbol'] = $settings['currency_symbol'];
        $data['language'] = $settings['site_language_prefix'];
        $data['email'] = $settings['email'];
        $data['admin_email'] = $settings['admin_email'];
        $data['fb_appid'] = $settings['fb_appid'];
        $data['fb_appsecret'] = $settings['fb_appsecret'];
        $data['googleplus_appid'] = $settings['googleplus_appid'];
        $data['googleplus_appsecret'] = $settings['googleplus_appsecret'];

        //echo '<pre>';print_r($data);echo'</pre>';
        //die;



        $this->form_validation->set_rules('email', 'Website Email', 'required|valid_email');
        $this->form_validation->set_rules('admin_email', 'Site Admin Email', 'required|valid_email');

        $this->form_validation->set_rules('country', 'country code', 'required');


        if ($this->form_validation->run() == FALSE) {
            $data['error'] = $this->load->view($this->config->item('admin_folder') . '/edit_settings', $data);
        } else {
            //setup the carpooling config file
            //$settings                               = array();
            $settings['ssl_support'] = (bool) 1;
            $settings['country_code'] = $this->input->post('country');
            $settings['currency'] = $this->input->post('currency_name');
            $settings['currency_symbol'] = $this->input->post('currency_symbol');
            $settings['site_language_prefix'] = $this->input->post('language');
			$settings['site_language'] = $this->get_language($this->input->post('language'));
            $settings['email'] = $this->input->post('email');
            $settings['admin_email'] = $this->input->post('admin_email');
            $settings['fb_appid'] = $this->input->post('fb_appid');
            $settings['fb_appsecret'] = $this->input->post('fb_appsecret');
            $settings['googleplus_appid'] = $this->input->post('googleplus_appid');
            $settings['googleplus_appsecret'] = $this->input->post('googleplus_appsecret');

            $file_contents = $this->load->view('admin/templates/' . $configFileName, $settings, true);

            $file = APPPATH . 'config/' . $configFileName . '.php';

            if (file_exists($file)) {
                unlink($file);
            }



            write_file(APPPATH . 'config/' . $configFileName . '.php', $file_contents);


            $this->session->set_flashdata('message', 'Your Profile has been changed');


            redirect('admin/dashboard');
        }
    }
	
	
	
	function get_language($langPrefix)
	{
		$name = '';
		if($langPrefix)
		{
			
			$language = $this->language_model->get_language_name($langPrefix);
			if($language){
				
				$name = $language->language_name;
				return $name;
			}
			
		}
		
		return $name;
		
		
	}

    function profile_image_upload() {

        $imagetype = $this->input->post('imageType');

        $filename = $_FILES['photoimg']['name'];
        $size = $_FILES['photoimg']['size'];



        $ext = $this->getExtension($filename);
        $ext = strtolower($ext);
        $actual_image_name = 'admin' . $this->current_admin['id'] . '_cover_' . time() . "." . $ext;

        //config image upload
        $config['allowed_types'] = $this->config->item('acceptable_files');
        $config['upload_path'] = $this->config->item('admin_upload_dir') . 'original';
        $config['file_name'] = $actual_image_name;
        $config['remove_spaces'] = true;


        $this->load->library('upload', $config);

        if ($this->upload->do_upload('photoimg')) {
            $upload_data = $this->upload->data();


            $this->load->library('image_lib');
            //this is the larger image
            $config['image_library'] = 'gd2';
            $config['source_image'] = $this->config->item('admin_upload_dir') . 'original/' . $upload_data['file_name'];
            $config['new_image'] = $this->config->item('admin_upload_dir') . 'source/' . $upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 160;
            $config['height'] = 204;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();

            $data['file_name'] = $upload_data['file_name'];

            $param['admin_img'] = $data['file_name'];
            $param['id'] = $this->current_admin['id'];
            $uid = $this->auth->save($param);
            $image = (array) $this->auth->get_admin($this->current_admin['id']);
            if ($image) {

                echo '<img src="' . admin_profile_img($image['admin_img']) . '" style="top:0px"/>';
            }
        }

        if ($this->upload->display_errors() != '') {
            echo $this->upload->display_errors();
        }
    }

    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }

        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }
    
    function get_currency()
    {
        $currency_id = $this->input->post('currency_id');
        $currency = $this->currency_model->get_currency($currency_id);        
        if($currency)
        {
           die(json_encode(array('result' => true, 'name' => $currency->currency_name,'symbol' => $currency->currency_symbol)));
        }
        
    }
   function change_logo($id=false)
   {
	    $this->load->helper('form');
        $this->load->library('form_validation');

        $data['page_title'] = ('Vehicle Form');
		
		$data['id'] = '';
        $data['uploadvalues'] = '';
		 if ($id) {
            $this->admin_id = $id;
            $admin = $this->logo_model->get_logo($id);
            //if the administrator does not exist, redirect them to the admin list with an error
            if (!$admin) {
                $this->session->set_flashdata('message', lang('admin_not_found'));
                redirect($this->config->item('admin_folder') . '/admin');
            }
            //set values to db values
            $data['id'] = $admin->id;
            $data['name'] = $admin->name;        }
		$this->form_validation->set_rules('uploadvalues', 'Image', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['error'] = $this->load->view($this->config->item('admin_folder') . '/change_logo', $data);
        } else {
	$id =1;		
	$save['id'] = $id; 
        $save['name'] = $this->input->post('uploadvalues');
        $this->logo_model->save($save);
        $this->session->set_flashdata('message', ('The logo has been saved!'));
        redirect($this->config->item('admin_folder') . '/admin/change_logo');
		}

   }
   
   
    function logo_image_upload() {


        $imagetype = $this->input->post('imageType');

        $filename = $_FILES['logoimg']['name'];
        $size = $_FILES['logoimg']['size'];
		
        //get the extension of the file in a lower case format
        $ext = $this->getExtension($filename);
        $ext = strtolower($ext);
        $actual_image_name = 'user' . $this->user['id'] . '_logo_' . time() . "." . $ext;
        if (!$imagetype) 


            //config image upload  
            $config['allowed_types'] = $this->config->item('acceptable_files');
            $config['upload_path'] = $this->config->item('logo_upload_dir') . 'full';
            $config['file_name'] = $actual_image_name;
            $config['remove_spaces'] = true;
			
			


            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logoimg')) {
                $upload_data = $this->upload->data();


                $this->load->library('image_lib');
                //this is the larger image
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->config->item('logo_upload_dir') . 'full/' . $upload_data['file_name'];
                $config['new_image'] = $this->config->item('logo_upload_dir') . 'medium/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 600;
                $config['height'] = 500;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //small image
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->config->item('logo_upload_dir') . 'medium/' . $upload_data['file_name'];
                $config['new_image'] = $this->config->item('logo_upload_dir') . 'small/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 235;
                $config['height'] = 235;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //cropped thumbnail
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->config->item('logo_upload_dir') . 'small/' . $upload_data['file_name'];
                $config['new_image'] = $this->config->item('logo_upload_dir') . 'thumbnails/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 235;
                $config['height'] = 53;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                if ($upload_data) {

                    $style = '<div id="gallery-photos-wrapper" class="logoimage">
							<ul id="gallery-photos" class="clearfix gallery-photos gallery-photos-hover ui-sortable">
								<li id="recordsArray_1" class="col-md-2 col-sm-3 col-xs-6" style="width:45%">								
									<div class="photo-box" style="background-image: url(' . theme_logo_img($upload_data['file_name']) . ');"></div>
									<a href="javascript:void(0);" class="remove-photo-link" id="logo-img-remove">
										<span class="fa-stack fa-lg">
											<i class="fa fa-circle fa-stack-2x"></i>
											<i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
										</span>
									</a>
								</li>
							</ul>							
							<img src="' . theme_logo_img($upload_data['file_name']) . '" style="display:none;">
                                                        <input type="hidden" name="uploadvalues" value="' . $upload_data['file_name'] . '" />
						</div>';

                    echo $style;
                }
            }

            if ($this->upload->display_errors() != '') {
                echo $this->upload->display_errors();
            }
        }
}
