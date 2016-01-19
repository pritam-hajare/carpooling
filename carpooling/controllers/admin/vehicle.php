<?php

class Vehicle extends Admin_Controller {

    var $vehicle_id = false;
    var $user = '';

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->user = $this->CI->admin_session->userdata('admin');
        $this->load->model(array('Vehicles_model','category_model'));
        $this->load->helper('formatting_helper');
        $this->load->helper('form');
        $this->lang->load('backend');
    }

    function index() {
        //we're going to use flash data and redirect() after form submissions to stop people from refreshing and duplicating submissions
        //$this->session->set_flashdata('message', 'this is our message');
        $this->load->library('Pagination_admin');
        $data['page_title'] = ('Vehicle');

        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'vehicle_ajax';
        $config['base_url'] = site_url('admin/vehicle');
        $data['count_result'] = $this->Vehicles_model->count_vehicles();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['vehicle'] = $this->Vehicles_model->get_vehicles($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/vehicle', $data);
    }

    function vehicle_ajax() {
        $this->load->library('Pagination_admin');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'vehicle_ajax';
        $config['base_url'] = site_url('admin/vehicle');
        $data['count_result'] = $this->Vehicles_model->count_vehicles();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['vehicle'] = $this->Vehicles_model->get_vehicles($this->pagination_admin->per_page, $this->uri->segment(4));
        $this->load->view($this->config->item('admin_folder') . '/vehicle-list', $data);
    }

    function form($id = false) {
        
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['page_title'] = ('Vehicle Form');

        //default values are empty if the provider is new
        $data['vehicletypeid'] = '';
        $data['vehicletypename'] = '';
        $data['categoryid'] = '';
        $data['uploadvalues'] = '';
        $data['isactive'] = '';
        $data['category'] = $this->category_model->getcategory_list();

        if ($id) {
            $this->vehicle_id = $id;
            $vehicle = $this->Vehicles_model->get_vehicle($id);

            //if the vehicle does not exist, redirect them to the vehicle list with an error
            if (!$vehicle) {
                $this->session->set_flashdata('error', lang('vehicle errors_not_found'));
                redirect($this->config->item('admin_folder') . '/vehicle');
            }

            //set values to db values
            $data['vehicletypeid'] = $vehicle->vechicle_type_id;
            $data['vehicletypename'] = $vehicle->vechicle_type_name;
            $data['uploadvalues'] = $vehicle->vechicle_image;
            $data['categoryid'] = $vehicle->category_id;
            $data['isactive'] = $vehicle->isactive;
        }

        $this->form_validation->set_rules('vehicletypename', 'lang:vehicletypename', 'trim|required|max_length[250]|callback_check_vehicle');
        $this->form_validation->set_rules('categoryid', 'categoryid', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view($this->config->item('admin_folder') . '/vehicletype_form', $data);
        } else {

            $save['vechicle_type_id'] = $id;
            $save['vechicle_type_name'] = $this->input->post('vehicletypename');
            $save['vechicle_image'] = $this->input->post('uploadvalues');
            $save['category_id'] = $this->input->post('categoryid');
            $save['isactive'] = $this->input->post('isactive');
           
            $this->Vehicles_model->save($save);
            $this->session->set_flashdata('message', ('The Vehicle has been saved!'));



            //go back to the vehicle list
            redirect($this->config->item('admin_folder') . '/vehicle');
        }
    }

    function vehicles_image_upload() {


        $imagetype = $this->input->post('imageType');

        $filename = $_FILES['vehiclesimg']['name'];
        $size = $_FILES['vehiclesimg']['size'];



        //get the extension of the file in a lower case format
        $ext = $this->getExtension($filename);
        $ext = strtolower($ext);
        $actual_image_name = 'user' . $this->user['id'] . '_vehicles_' . time() . "." . $ext;
        if (!$imagetype) {


            //config image upload  
            $config['allowed_types'] = $this->config->item('acceptable_files');
            $config['upload_path'] = $this->config->item('vehicles_upload_dir') . 'full';
            $config['file_name'] = $actual_image_name;
            $config['remove_spaces'] = true;
			
			


            $this->load->library('upload', $config);

            if ($this->upload->do_upload('vehiclesimg')) {
                $upload_data = $this->upload->data();


                $this->load->library('image_lib');
                //this is the larger image
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->config->item('vehicles_upload_dir') . 'full/' . $upload_data['file_name'];
                $config['new_image'] = $this->config->item('vehicles_upload_dir') . 'medium/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 600;
                $config['height'] = 500;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //small image
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->config->item('vehicles_upload_dir') . 'medium/' . $upload_data['file_name'];
                $config['new_image'] = $this->config->item('vehicles_upload_dir') . 'small/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 235;
                $config['height'] = 235;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //cropped thumbnail
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->config->item('vehicles_upload_dir') . 'small/' . $upload_data['file_name'];
                $config['new_image'] = $this->config->item('vehicles_upload_dir') . 'thumbnails/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 150;
                $config['height'] = 150;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                if ($upload_data) {

                    $style = '<div id="gallery-photos-wrapper" class="vehiclesimage">
							<ul id="gallery-photos" class="clearfix gallery-photos gallery-photos-hover ui-sortable">
								<li id="recordsArray_1" class="col-md-2 col-sm-3 col-xs-6" style="width:45%">								
									<div class="photo-box" style="background-image: url(' . theme_vehicles_img($upload_data['file_name']) . ');"></div>
									<a href="javascript:void(0);" class="remove-photo-link" id="vehicles-img-remove">
										<span class="fa-stack fa-lg">
											<i class="fa fa-circle fa-stack-2x"></i>
											<i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
										</span>
									</a>
								</li>
							</ul>							
							<img src="' . theme_vehicles_img($upload_data['file_name']) . '" style="display:none;">
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

    function delete($id = false) {

        $vehicle = $this->Vehicles_model->check_vehicles($id);

        if ($vehicle) {

            $this->session->set_flashdata('error', 'Please delete the vehicle  under the vehicle type');
            redirect($this->config->item('admin_folder') . '/vehicle');
        } else {
            $vehicle = $this->Vehicles_model->get_vehicle($id);

            //if the vehicle does not exist, redirect them to the vehicle list with an error
            if (!$vehicle) {
                $this->session->set_flashdata('error', lang('vehicle errors_not_found'));
                redirect($this->config->item('admin_folder') . '/vehicle');
            } else {
                //if the vehicle is legit, delete them
                $delete = $this->Vehicles_model->delete($id);

                $this->session->set_flashdata('message', ('The vehicle has been deleted'));
                redirect($this->config->item('admin_folder') . '/vehicle');
            }
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

    function delete_image() {
        $img_name = $this->input->post('img_name');
        $status = $this->Vehicles_model->delete_image($img_name);
        if ($img_name) {
            $file = $this->config->item('vehicles_upload_dir') . 'full/' . $img_name;
            //delete the existing file if needed
            if (file_exists($file)) {
                unlink($file);
                $file_1 = $this->config->item('vehicles_upload_dir') . 'medium/' . $img_name;
                $file_2 = $this->config->item('vehicles_upload_dir') . 'small/' . $img_name;
                $file_3 = $this->config->item('vehicles_upload_dir') . 'thumbnails/' . $img_name;
                if (file_exists($file_1)) {
                    unlink($file_1);
                }
                if (file_exists($file_2)) {
                    unlink($file_2);
                }
                if (file_exists($file_3)) {
                    unlink($file_3);
                }
                echo true;
            }
            echo false;
        } else {
            echo false;
        }
    }

    function check_vehicle($str) {
        $name = $this->Vehicles_model->check_vehicle($str, $this->vehicle_id);

        if ($name) {
            $this->form_validation->set_message('check_vehicle', 'The vehicle name already in use');
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

            $vehicle = (array) $this->Vehicles_model->get_vehicle($user_id);
            if (!$vehicle) {
                echo false;
            } else {

                if ($status == 'enable') {
                    $vehicle['isactive'] = '1';
                } elseif ($status == 'disable') {
                    $vehicle['isactive'] = '0';
                }

                $id = $this->Vehicles_model->save($vehicle);
                echo $id;
            }
        }

        echo false;
    }

}
