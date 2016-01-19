<?php

class Vechicle extends Traveller_Controller 
{

    var $CI;
    var $user_id;

    function __construct() 
	{
        parent::__construct();
        remove_ssl();
        $this->CI = & get_instance();

        $this->load->model('vechicle_model');
        $this->load->model('Vehiclescategory_model');
        $this->load->model('travel_model');
        $this->load->helper('date');
        $this->load->helper('form');
    }

    function index() 
	{

        $carpool_session['carpool_session'] = $this->CI->carpool_session->userdata('carpool');
        $this->user_id = $carpool_session['carpool_session']['user_id'];

        $data['seo_title'] = '';
        $data['seo_description'] = '';
        $data['seo_keyword'] = '';
        $this->load->helper('form');
        $term = false;

        $data['vechicletypes'] = $this->vechicle_model->getvechicle_list($this->user_id);

        $data['vehicletypeid'] = '';
        $data['txtvechicle'] = '';
        $data['redirect'] = '';
        $this->load->view('vechicles', $data);
    }

    function vechicleform($id = false) 
	{
        $carpool_session['carpool_session'] = $this->CI->carpool_session->userdata('carpool');
        $this->user_id = $carpool_session['carpool_session']['user_id'];

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');


        $data['seo_title'] = 'Project Form';
        $data['seo_description'] = '';
        $data['seo_keyword'] = '';
        $data['vechicle_id'] = '';
        $data['vechiclecategory_id'] = '';
        $data['vechiclecategory'] = $this->Vehiclescategory_model->getcategory_list();
        $data['vechicle_type_id'] = '';
        $data['txtvechicle'] = '';
        $data['userfile'] = '';
        $data['vechiclecomfort'] = '';
        $data['redirect'] = '';
        $data['uploadvalues'] = '';


        if ($id) 
		{
            if ($this->vechicle_model->check($id)) 
			{
                $this->session->set_flashdata('error', 'You cannot edit this vehicle, Because already allocated one trip');
                return false;
            }

            $profile = $this->vechicle_model->getvechicle($id);

            //if the profile does not exist, redirect them to the vechicle list with an error
            if (!$profile) 
			{
                $this->session->set_flashdata('error', lang('error_not_found'));
                redirect('vechicle');
            }



            //set values to db values
            $data['vechicle_id'] = $profile->vechicle_id;
            $data['vechiclecomfort'] = $profile->vechiclecomfort;
            $data['vechicle_type_id'] = $profile->vechicle_type_id;
            $data['txtvechicle'] = $profile->vechicle_number;
            $data['uploadvalues'] = $profile->vechicle_logo;
            $data['vechiclecategory_id'] = $profile->category_id;
        }

        $this->form_validation->set_rules('txtvechicle', 'Vehicle Number', 'trim|required|max_length[350]');
        $this->form_validation->set_rules('vechicletype', 'Vehicle Name', 'trim|required');


        if ($this->form_validation->run() == FALSE) 
		{

            $this->load->view('vechicle_form', $data);
        } 
		else 
		{
            $param['vechicle_id'] = $id;
            $param['vechicle_type_id'] = $this->input->post('vechicletype', true);
            $param['vechicle_number'] = $this->input->post('txtvechicle', true);
            $param['user_id'] = $this->user_id;
            $param['vechicle_logo'] = $this->input->post('uploadvalues', true);
            $param['vechiclecomfort'] = $this->input->post('vechiclecomfort', true);

            $vechicle_id = $this->vechicle_model->save($param);

            if ($vechicle_id) 
			{
                $this->session->set_flashdata('message', 'Vehicle details saved');
                die(json_encode(array('result' => true)));
            }
            $this->session->set_flashdata('message', 'Vehicle details saved');
            redirect('vechicle');
        }
    }

    function image_upload() 
	{

        $imagetype = $this->input->post('imageType');

        $filename = $_FILES['photoimg']['name'];
        $size = $_FILES['photoimg']['size'];

        $ext = $this->getExtension($filename);
        $ext = strtolower($ext);
        $actual_image_name = 'user' . $this->user_id . '_vehicle_' . time() . "." . $ext;
        if (!$imagetype) 
		{

            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG';
            //$config['max_size']	= $this->config->item('size_limit');
            $config['upload_path'] = 'uploads/vehicle/full';
            $config['remove_spaces'] = true;
            $config['file_name'] = $actual_image_name;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photoimg'))
			 {
                $upload_data = $this->upload->data();

                $this->load->library('image_lib');

                //this is the larger image
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/vehicle/full/' . $upload_data['file_name'];
                $config['new_image'] = 'uploads/vehicle/medium/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 600;
                $config['height'] = 500;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //small image
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/vehicle/medium/' . $upload_data['file_name'];
                $config['new_image'] = 'uploads/vehicle/small/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 235;
                $config['height'] = 235;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                //cropped thumbnail
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/vehicle/small/' . $upload_data['file_name'];
                $config['new_image'] = 'uploads/vehicle/thumbnails/' . $upload_data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 180;
                $config['height'] = 180;
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $data['file_name'] = $upload_data['file_name'];
                if ($upload_data) 
				{
                    $src = base_url('uploads/vehicle/thumbnails/' . $upload_data['file_name']);
                    $style = '<div class="groupimage"> <img src="' . $src . '" class="border padding5">  <p class="margintop20"> <a href="javascript:void(0)" class="cs-blue-text remove-photo"> Remove Photo </a> </p>						
						<input type="hidden" name="uploadvalues" value="' . $upload_data['file_name'] . '" /> </div>';
                    echo $style;
                }
            }

            if ($this->upload->display_errors() != '') 
			{
                echo $this->upload->display_errors();
            }
        }
    }

    function delete_image() 
	{
        $img_name = $this->input->post('img_name');
        if ($img_name) 
		{

            $file = 'uploads/vehicle/full/' . $img_name;
            //delete the existing file if needed

            if (file_exists($file)) 
			{
                unlink($file);
                $file_1 = 'uploads/vehicle/medium/' . $img_name;
                $file_3 = 'uploads/vehicle/small/' . $img_name;
                $file_4 = 'uploads/vehicle/thumbnails/' . $img_name;


                if (file_exists($file_1)) 
				{
                    unlink($file_1);
                }
                if (file_exists($file_3)) 
				{
                    unlink($file_3);
                }
                if (file_exists($file_4)) 
				{
                    unlink($file_4);
                }
                echo true;
            }
            echo false;
        }
		 else 
		 {
            echo false;
        }
    }

    function getExtension($str) 
	{
        $i = strrpos($str, ".");
        if (!$i) 
		{
            return "";
        }

        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    function get_types() 
	{
        $category_id = $this->input->post('cid');
        echo(json_encode($this->vechicle_model->get_type_list($category_id)));
    }

    function get_image() 
	{
        $category_id = $this->input->post('cid');
        $image = $this->vechicle_model->get_image($category_id);
        die(json_encode(array('result' => true, 'image' => $image)));
    }

    function delete($id = 0) 
	{
        if ($id) 
		{
            if ($this->vechicle_model->check($id)) 
			{
                $this->session->set_flashdata('error', 'You cannot delete this vehicle, Because already allocated one trip');
                redirect('profile#my-cars-info');
            }
            $this->db->where('vechicle_id', $id);
            $this->db->delete('tbl_vehicle');
            $this->session->set_flashdata('message', 'Your vehicle has been deleted');
            redirect('profile#my-cars-info');
        }
    }

    function type_dropdown() 
	{
        $this->load->helper(array('form_helper', 'formatting_helper'));
        $category_id = $this->input->post('cid');
        $type_id = $this->input->post('tid');
        $type = $this->vechicle_model->get_type($category_id);
        $data = array('' => 'Select Type');
        foreach ($type as $parent) 
		{
            $data[$parent->vechicle_type_id] = $parent->vechicle_type_name;
        }

        echo form_dropdown('vechicletype', $data, $type_id, 'id="vechicletype"');
    }

}
