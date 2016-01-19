<?php

class Testimonials extends Admin_Controller {

    var $testimonial_id = false;
    var $user = '';

    function __construct() {
        parent::__construct();

        $this->CI = & get_instance();
        $this->user = $this->CI->admin_session->userdata('admin');

        $this->load->model(array('testimonial_model'));
        $this->load->helper('formatting_helper');
        $this->load->helper('form');
        $this->lang->load('backend');
    }

    function index() {
        $this->load->library('Pagination_admin');
        $data['page_title'] = ('Group');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'testimonials_ajax';
        $config['base_url'] = site_url('admin/group');
        $data['count_result'] = $this->testimonial_model->count_testimonials();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['testimonials'] = $this->testimonial_model->all_testimonials($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/testimonials', $data);
    }

    function testimonials_ajax() {
        $this->load->library('Pagination_admin');
        $data['page_title'] = ('Group');
        $config['is_ajax_paging'] = true;
        $config['paging_function'] = 'testimonials_ajax';
        $config['base_url'] = site_url('admin/group');
        $data['count_result'] = $this->testimonial_model->count_testimonials();
        $config['total_rows'] = $data['count_result'];
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;

        $this->pagination_admin->initialize($config);

        $data['pagination'] = $this->pagination_admin->create_links();
        $data['testimonials'] = $this->testimonial_model->all_testimonials($this->pagination_admin->per_page, $this->uri->segment(4));

        $this->load->view($this->config->item('admin_folder') . '/testimonials-list', $data);
    }

    function form($id = false) {
        
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['page_title'] = ('Group Form');

        $data['id'] = '';
        $data['name'] = '';
        $data['description'] = '';
        $data['isactive'] = '';
        $data['uploadvalues'] = '';
        $data['test_name'] = '';


        if ($id) {
            $this->testimonial_id = $id;
            $testimonials = $this->testimonial_model->get_testimonial($id);

            //if the testimonials does not exist, redirect them to the testimonials list with an error
            if (!$testimonials) {
                $this->session->set_flashdata('error', 'Testimonials not founded');
                redirect($this->config->item('admin_folder') . '/testimonials');
            }

            //set values to db values
            $data['id'] = $testimonials->id;
            $data['name'] = $testimonials->name;
            $data['test_name'] = $testimonials->name;
            $data['description'] = $testimonials->description;
            $data['isactive'] = $testimonials->isactive;
            $data['uploadvalues'] = $testimonials->image;
        }
        
        
        $this->form_validation->set_rules('name', 'Testimonials Name', 'trim|required|max_length[250]');
        $this->form_validation->set_rules('description', 'Testimonials description', 'trim|required|max_length[150]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view($this->config->item('admin_folder') . '/Testimonials-form', $data);
        } else {

            $save['id'] = $id;
            $save['name'] = $this->input->post('name');
            $save['description'] = $this->input->post('description');
            $save['image'] = $this->input->post('uploadvalues');
            $save['isactive'] = $this->input->post('isactive');


            $this->testimonial_model->save($save);
            $this->session->set_flashdata('message', ('The testimonials has been saved!'));



            //go back to the testimonials list
            redirect($this->config->item('admin_folder') . '/testimonials');
        }
    }

    function testimonials_image_upload() {


        $imagetype = $this->input->post('imageType');

        $filename = $_FILES['testimonialsimg']['name'];
        $size = $_FILES['testimonialsimg']['size'];



        //get the extension of the file in a lower case format
        $ext = $this->getExtension($filename);
        $ext = strtolower($ext);
        $actual_image_name = 'user' . $this->user['id'] . '_testimonials_' . time() . "." . $ext;
        if (!$imagetype) {


            //config image upload  
            $config['allowed_types'] = $this->config->item('acceptable_files');

            $config['upload_path'] = $this->config->item('testimonials_upload_dir') . 'full';
            $config['file_name'] = $actual_image_name;
            $config['remove_spaces'] = true;


            $this->load->library('upload', $config);

            if ($this->upload->do_upload('testimonialsimg')) {
                $upload_data = $this->upload->data();


                $this->load->library('image_lib');
                //this is the larger image
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->config->item('testimonials_upload_dir') . 'full/' . $upload_data['file_name'];
                $config['new_image'] = $this->config->item('testimonials_upload_dir') . 'medium/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 600;
                $config['height'] = 500;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //small image
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->config->item('testimonials_upload_dir') . 'medium/' . $upload_data['file_name'];
                $config['new_image'] = $this->config->item('testimonials_upload_dir') . 'small/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 235;
                $config['height'] = 235;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //cropped thumbnail
                $config['image_library'] = 'gd2';
                $config['source_image'] = $this->config->item('testimonials_upload_dir') . 'small/' . $upload_data['file_name'];
                $config['new_image'] = $this->config->item('testimonials_upload_dir') . 'thumbnails/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 150;
                $config['height'] = 150;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                if ($upload_data) {

                    $style = '<div id="gallery-photos-wrapper" class="testimonialsimage">
							<ul id="gallery-photos" class="clearfix gallery-photos gallery-photos-hover ui-sortable">
								<li id="recordsArray_1" class="col-md-2 col-sm-3 col-xs-6" style="width:45%">								
									<div class="photo-box" style="background-image: url(' . theme_testimonials_img($upload_data['file_name']) . ');"></div>
									<a href="javascript:void(0);" class="remove-photo-link" id="testimonials-img-remove">
										<span class="fa-stack fa-lg">
											<i class="fa fa-circle fa-stack-2x"></i>
											<i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
										</span>
									</a>
								</li>
							</ul>							
							<img src="' . theme_testimonials_img($upload_data['file_name']) . '" style="display:none;">                                                            
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
        $status = $this->testimonial_model->delete_image($img_name);
        if ($img_name) {
            $file = $this->config->item('testimonials_upload_dir') . 'full/' . $img_name;
            //delete the existing file if needed
            if (file_exists($file)) {
                unlink($file);
                $file_1 = $this->config->item('testimonials_upload_dir') . 'medium/' . $img_name;
                $file_2 = $this->config->item('testimonials_upload_dir') . 'small/' . $img_name;
                $file_3 = $this->config->item('testimonials_upload_dir') . 'thumbnails/' . $img_name;
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

    function change_status() {
        $this->auth->is_logged_in();

        $testimonial_id = $this->input->post('mid');
        $status = $this->input->post('status');

        if (!empty($testimonial_id) && !empty($status)) {

            $testimonial = (array) $this->testimonial_model->get_testimonial($testimonial_id);
            if (!$testimonial) {
                echo false;
            }

            if ($status == 'enable') {
                $testimonial['isactive'] = '1';
            } elseif ($status == 'disable') {
                $testimonial['isactive'] = '0';
            }


            $id = $this->testimonial_model->save($testimonial);
            echo $id;
        }

        echo false;
    }
	
	function delete($id = false) {

        
            $testimonial = $this->testimonial_model->get_testimonial($id);

            //if the vehicle does not exist, redirect them to the vehicle list with an error
            if (!$testimonial) {
                $this->session->set_flashdata('error', 'Testimonial not Found');
                redirect($this->config->item('admin_folder') . '/testimonials');
            } else {
                //if the vehicle is legit, delete them
                $delete = $this->testimonial_model->delete($id);

                $this->session->set_flashdata('message', ('The testimonial has been deleted'));
                redirect($this->config->item('admin_folder') . '/testimonials');
            }
       
    }


}
