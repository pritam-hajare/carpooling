<?php

class Traveller extends Admin_Controller {

    //this is used when editing or adding a provider

    var $user_id = false;

    function __construct() {

        parent::__construct();



        $this->load->model(array('Travel_model', 'Trip_model'));

        $this->load->helper('formatting_helper');

        $this->lang->load('backend');
    }

    function index() {



        $data['page_title'] = ('Travel User list');



        $this->load->helper('form');



        $this->load->library('Pagination_admin');



        $config['is_ajax_paging'] = true;

        $config['paging_function'] = 'travel_ajax';

        $config['base_url'] = site_url('admin/traveller');

        $data['count_result'] = $this->Travel_model->count_travellers();

        $config['total_rows'] = $data['count_result'];

        $config['per_page'] = '10';

        $config['uri_segment'] = 4;



        $this->pagination_admin->initialize($config);



        $data['pagination'] = $this->pagination_admin->create_links();

        $data['traveller'] = $this->Travel_model->get_alltravellers($this->pagination_admin->per_page, $this->uri->segment(4));





        $this->load->view($this->config->item('admin_folder') . '/traveller', $data);
    }

    function travel_ajax() {

        $this->load->library('Pagination_admin');

        $config['is_ajax_paging'] = true;

        $config['paging_function'] = 'travel_ajax';

        $config['base_url'] = site_url('admin/traveller');

        $data['count_result'] = $this->Travel_model->count_travellers();

        $config['total_rows'] = $data['count_result'];

        $config['per_page'] = '10';

        $config['uri_segment'] = 4;



        $this->pagination_admin->initialize($config);



        $data['pagination'] = $this->pagination_admin->create_links();

        $data['traveller'] = $this->Travel_model->get_alltravellers($this->pagination_admin->per_page, $this->uri->segment(4));



        $this->load->view($this->config->item('admin_folder') . '/traveller-list', $data);
    }

    function form($id = false) {



        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['page_title'] = lang('traveller_form');
        
        //default values are empty if the provider is new
        $data['userid'] = '';
        $data['userfirstname'] = '';
        $data['userlastname'] = '';
        $data['usermob'] = '';
        $data['usermail'] = '';
        $data['usercont'] = '';
        $data['usertype'] = '';
        $data['isactive'] = false;



        if ($id) {
            $this->user_id = $id;
            $traveller = $this->Travel_model->get_traveller($id);
            
            //if the provider does not exist, redirect them to the provider list with an error
            if (!$traveller) {
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect($this->config->item('admin_folder') . '/traveller');
            }

            //set values to db values
            $data['userid'] = $traveller->user_id;
            $data['userfirstname'] = $traveller->user_first_name;
            $data['userlastname'] = $traveller->user_last_name;           
            $data['usermail'] = $traveller->user_email;
            $data['usercont'] = $traveller->user_mobile;
            $data['usertype'] = $traveller->user_type;
            $data['isactive'] = $traveller->isactive;            
        }



        $this->form_validation->set_rules('userfirstname', 'lang:traveller', 'trim|required|max_length[250]');
        $this->form_validation->set_rules('usermail', 'lang:email', 'trim|required|valid_email|max_length[128]|callback_check_email');
        $this->form_validation->set_rules('usercont', 'lang:phone', 'trim|required|numeric|min_length[4]|max_length[15]');
        $this->form_validation->set_rules('userlastname', 'lang:traveller', 'trim|max_length[128]');

        
        if ($this->form_validation->run() == FALSE) {

            $this->load->view($this->config->item('admin_folder') . '/traveller-form', $data);
        } else {

            $save['user_id'] = $id;
            $save['user_first_name'] = $this->input->post('userfirstname');
            $save['user_last_name'] = $this->input->post('userlastname');
            $save['user_email'] = $this->input->post('usermail');
            $save['user_mobile'] = $this->input->post('usercont');
            $save['user_type'] = $this->input->post('usertype');
            $save['isactive'] = $this->input->post('isactive');

            if ($this->input->post('password') != '' || !$id) {
                $save['user_password'] = sha1($this->input->post('password'));
            }
            
            if($this->input->post('isactive') == 1)
            {
                $save['user_admin_status'] = 1;
            }
            else
            {
                $save['user_admin_status'] = 0;
            }
            
                    
            $userId = $this->Travel_model->save($save);

            if ($this->input->post('email_flg') == 1 && $this->input->post('isactive') == 1) {



                $InsertTraveller = array();

                $InsertTraveller = (array) $this->Travel_model->get_traveller($userId);



                $InsertTraveller['user_admin_status'] = 1;

                $this->Travel_model->save($InsertTraveller);



                ///*			// send an email */
////			// get the email template

                $res = $this->db->where('tplid', '12')->get('tbl_email_template');

                $row = $res->row_array();



                // set replacement values for subject & body
                // {customer_name}
                
                $row['tplsubject'] =  str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplsubject']);

                $row['tplmessage'] = str_replace('{NAME}', $save['user_first_name'] . '.' . $save['user_last_name'], $row['tplmessage']);

                $row['tplmessage'] = str_replace('{EMAIL}', $this->input->post('usermail'), $row['tplmessage']);

                $row['tplmessage'] = str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplmessage']);
    
                $row['tplmessage'] = str_replace('{ADMIN_EMAIL}', $this->config->item('admin_email'), $row['tplmessage']);



                // {url}

                $row['tplmessage'] = str_replace('{PASSWORD}', $this->input->post('password'), $row['tplmessage']);
				
				$param['message'] = $row['tplmessage'];
	
				$email_subject = $this->load->view($this->config->item('admin_folder') . '/template', $param, TRUE);
	
				$this->load->library('email');
	
				$config['mailtype'] = 'html';
	
				$this->email->initialize($config);


                $this->email->from($this->config->item('email'), $this->config->item('company_name'));

                $this->email->to($save['user_email']);

                $this->email->subject($row['tplsubject']);
				
                $this->email->message(html_entity_decode($email_subject));



                $this->email->send();
            }





            if ($this->input->post('email_flg') == 1 && $this->input->post('isactive') == 0) {



                $InsertTraveller = array();

                $InsertTraveller = (array) $this->Travel_model->get_traveller($userId);

                $code = random_string('alnum', 6);

                $InsertTraveller['isverified'] = sha1($code);

                $InsertTraveller['user_admin_status'] = 0;

                $this->Travel_model->save($InsertTraveller);

                ///* send an email */
                //			// get the email template

                $res = $this->db->where('tplid', '12')->get('tbl_email_template');

                $row = $res->row_array();



                // set replacement values for subject & body
                // {customer_name}
				
				$row['tplsubject'] =  str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplsubject']);

                $row['tplmessage'] = str_replace('{NAME}', $this->input->post('userfirstname') . '.' . $this->input->post('userlastname'), $row['tplmessage']);

                $row['tplmessage'] = str_replace('{EMAIL}', $this->input->post('usermail'), $row['tplmessage']);

                $row['tplmessage'] = str_replace('{PASSWORD}', $this->input->post('password'), $row['tplmessage']);

                $row['tplmessage'] = str_replace('{COMPANY_NAME}', $this->config->item('company_name'), $row['tplmessage']);
    
                $row['tplmessage'] = str_replace('{ADMIN_EMAIL}', $this->config->item('admin_email'), $row['tplmessage']);

                // {url}

                $row['tplmessage'] = str_replace('{SITE_PATH}', $this->config->item('base_url'), $row['tplmessage']);



                $row['tplmessage'] = str_replace('{code}', $code, $row['tplmessage']);


                $param['message'] = $row['tplmessage'];
	
				$email_subject = $this->load->view($this->config->item('admin_folder') . '/template', $param, TRUE);
	
				$this->load->library('email');
	
				$config['mailtype'] = 'html';
	
				$this->email->initialize($config);


                $this->email->from($this->config->item('email'), $this->config->item('company_name'));

                $this->email->to($save['user_email']);

                $this->email->subject($row['tplsubject']);
				
                $this->email->message(html_entity_decode($email_subject));

                $this->email->send();
            }



            $this->session->set_flashdata('message', ('The travel user has been saved!'));





            //go back to the traveller list

            redirect($this->config->item('admin_folder') . '/traveller');
        }
    }

    function delete($id = false) {

        if ($id) {

            $traveller = $this->Travel_model->get_traveller($id);

            //if the traveller does not exist, redirect them to the provider list with an error

            if (!$traveller) {

                $this->session->set_flashdata('error', lang('error_not_found'));

                redirect($this->config->item('admin_folder') . '/traveller');
            } else {



                $uid = $this->Trip_model->delete_trip($id);



                //if the provider is legit, delete them

                $delete = $this->Travel_model->delete($id);



                $this->session->set_flashdata('message', lang('message_travel_deleted'));

                redirect($this->config->item('admin_folder') . '/traveller');
            }
        } else {

            //if they do not provide an id send them to the provider list page with an error

            $this->session->set_flashdata('error', lang('error_not_found'));

            redirect($this->config->item('admin_folder') . '/providers');
        }
    }

    //this is a callback to make sure that providers are not sharing an email address

    function check_email($str) {

        $email = $this->Travel_model->check_email($str, $this->user_id);



        if ($email) {

            $this->form_validation->set_message('check_email', lang('error_email_in_use'));

            return FALSE;
        } else {

            return TRUE;
        }
    }

    function edit($id = false, $duplicate = false) {

        $this->user_id = $id;







        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');



        $data['redirect'] = '';

        if ($this->user_id) {



            $profile = $this->Customer_model->get_customer($this->user_id);



            if (!$profile) {



                $this->session->set_flashdata('error', lang('error_not_found'));

                redirect('travel/profile/');
            }





            //set values to db values

            $data['id'] = $this->user_id;

            $data['txtfirstname'] = $profile->user_first_name;

            $data['txtlastname'] = $profile->user_last_name;

            $data['txtphone'] = $profile->user_mobile;

            $data['txtemail'] = $profile->user_email;

            $data['txtcmpname'] = $profile->user_company_name;

            $data['txtgender'] = $profile->user_gender;

            $data['atxtemail'] = $profile->user_secondary_mail;

            $data['atxtphone'] = $profile->user_secondary_phone;

            $data['mail_flg'] = $profile->communication_email;

            $data['mobile_flg'] = $profile->communication_mobile;

            $data['txtstreet'] = $profile->user_street;

            $data['txtcity'] = $profile->user_city;

            $data['txtcode'] = $profile->postal_code;

            $data['txtcountry'] = $profile->user_country;

            $data['txtoccupation'] = $profile->user_occupation;

            $data['martial_status'] = $profile->marital_status;

            if (!empty($profile->user_dob)) {

                $dob = explode("-", $profile->user_dob);



                $data['month'] = date("F", strtotime($profile->user_dob));

                $data['year'] = $dob[0];

                $data['selday'] = $dob[2];
            } else {

                $data['month'] = '';

                ;

                $data['year'] = '';

                $data['selday'] = '';
            }



            //make sure we haven't submitted the form yet before we pull in the images/related products from the database



            if ($this->input->post('mobile_flg') == 1) {

                $this->form_validation->set_rules('atxtphone', 'Secondary Mobile', 'trim|required|max_length[32]');
            }

            if ($this->input->post('mail_flg') == 1) {

                $this->form_validation->set_rules('atxtemail', 'Secondary Mail', 'trim|required|max_length[32]');
            }
        }



        $this->form_validation->set_rules('txtfirstname', 'Firstname', 'trim|max_length[128]');

        $this->form_validation->set_rules('txtlastname', 'Lastname', 'trim|max_length[128]');

        $this->form_validation->set_rules('txtphone', 'Phone', 'trim|required|max_length[32]');





        if ($duplicate) {

            $data['id'] = false;
        }





        if ($this->form_validation->run() == FALSE) {

            //die;

            $this->load->view($this->config->item('admin_folder') . '/traveller_edit', $data);
        } else {

            $this->load->helper('text');







            if ($this->input->post('year') && $this->input->post('month') && $this->input->post('day')) {

                $enrolled = sprintf('%d-%02d-%02d', $this->input->post('year'), date("m", strtotime($this->input->post('month'))), $this->input->post('day'));
            } else {

                $enrolled = '';
            }



            $save['user_id'] = $this->user_id;

            $save['user_first_name'] = $this->input->post('txtfirstname');

            $save['user_last_name'] = $this->input->post('txtlastname');

            $save['user_type'] = $this->input->post('user_type');

            $save['user_company_name'] = $this->input->post('txtcmpname');

            $save['user_email'] = $this->input->post('txtemail');

            $save['user_mobile'] = $this->input->post('txtphone');

            $save['user_gender'] = $this->input->post('txtgender');

            $save['user_secondary_mail'] = $this->input->post('atxtemail');

            $save['user_secondary_phone'] = $this->input->post('atxtphone');

            $save['communication_mobile'] = $this->input->post('mobile_flg');

            $save['communication_email'] = $this->input->post('mail_flg');

            $save['user_street'] = $this->input->post('txtstreet');

            $save['user_city'] = $this->input->post('txtcity');

            $save['postal_code'] = $this->input->post('txtcode');

            $save['user_country'] = $this->input->post('txtcountry');

            $save['user_occupation'] = $this->input->post('txtoccupation');

            $save['user_dob'] = $enrolled;

            $save['marital_status'] = $this->input->post('martial_status');



            /* 	print_r($save);

              die;

             */



            // save password 

            $profile_id = $this->Customer_model->save($save);







            $this->session->set_flashdata('message', 'The travel user has updated');





            redirect('admin/traveller/details');
        }
    }

    function update($save) {

        $this->db->where('trip_user_id', $save['trip_user_id']);

        $this->db->update('tbl_trips', $save);

        return $save['trip_user_id'];
    }

    function change_status() {

        $this->auth->is_logged_in();



        $user_id = $this->input->post('mid');

        $status = $this->input->post('status');



        if (!empty($user_id) && !empty($status)) {



            $traveller = (array) $this->Travel_model->get_traveller($user_id);



            if (!$traveller) {

                echo false;
            }

            $param['trip_user_id'] = $user_id;

            if ($status == 'enable') {

                $traveller['isactive'] = '1';
                $traveller['user_admin_status'] = 1;
                $param['trip_status'] = '1';
            } elseif ($status == 'disable') {
                $traveller['isactive'] = '1';
                $traveller['user_admin_status'] = 0;
                $param['trip_status'] = '0';
            }

            $uid = $this->Trip_model->tsave($param);

            if ($uid) {

                $id = $this->Travel_model->save($traveller);

                echo $id;
            }
        } else {



            echo false;
        }
    }

}
