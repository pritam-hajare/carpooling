<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Apivehicle extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('Vehiclescategory_model');
        $this->load->model('vechicle_model');
    }
    
    function getvehiclecategory_post() {
    	$data=$this->Vehiclescategory_model->getcategory_list();
    	$this->response($data);
    }
    
	function deletevechicle_post(){
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['vechicle_id'] = $postData["VH_ID"];
		//$vehicle_id=$postData["VH_ID"];
		$param['is_active']=0;
		//$data=$this->vechicle_model->deletevehicle($user_id,$vehicle_id,$data1);
		$vechicle_id = $this->vechicle_model->save($param);
	    
	    	if ($vechicle_id)
	    	{
	    		$this->response(array('state'=>'success'));
	    	}else{
			   $this->response(array('state'=>'fail'));
			}
	    	$this->response('error');
		/*if($data>0){
		$result['state']="success";
		$this->response($result);
		}else{
		$result['state']="fail";
		$this->response($result);
		}*/
	}
	
	function updatevechicle_post(){
	    $postData = json_decode(file_get_contents("php://input"), true);
	    $param['vechicle_type_id'] = $postData["vechicle_type_id"];
    	$param['vechicle_number'] = $postData["txtvechicle"];
    	$param['vechicle_id'] = $postData["VH_ID"];
		$param['veh_insurence']=$postData["ins"];
		
		$param['veh_document']=$postData["doc"];
		$param['vechicle_class']=$postData["vechicle_class"];
		$vechicle_id = $this->vechicle_model->save($param);
    
    	if ($vechicle_id)
    	{
    		$this->response(array('state'=>'success'));
    	}else{
		   $this->response(array('state'=>'fail'));
		}
    	$this->response('error');
    
      	/*$vechicle_id = $this->vechicle_model->updatevehicle($param);
    
    	if ($vechicle_id)
    	{
    		$this->response(array('state'=>'success'));
    	}else{
		   $this->response(array('state'=>'fail'));
		}
    	$this->response('error'); */
	
	
	}
	
    function getvehicletypes_post(){
    	$postData = json_decode(file_get_contents("php://input"), true);
    	$category_id = $postData["cid"];
    	$data = $this->vechicle_model->get_type_list($category_id);
    	$this->response($data);
    }
	
	
	
    function getallvehicle_post(){
    	$postData = json_decode(file_get_contents("php://input"), true); 
 		$user_id=$postData["u_id"];
		$data = $this->vechicle_model->getvechicle_list($user_id);
	
	    if($data!=false){
		    $result['result']=$data;
			$result['state']="A";
			$this->response($result);	
		}
		else{
			$this->response(array('state'=>'NA'));
		}
		$this->response($data);
	}
	
    function addmyvehicle_post(){
    	$postData = json_decode(file_get_contents("php://input"), true);
    	$this->user_id = $postData['u_id'];
    	$id = null;
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
    
    	$param['vechicle_id'] = $id;
    	$param['vechicle_type_id'] = $postData["vechicle_type_id"];
    	$param['vechicle_number'] = $postData["txtvechicle"];
    	$param['user_id'] = $this->user_id;
		$param['veh_insurence']=$postData["ins"];
		
		$param['veh_document']=$postData["doc"];
		$param['vechicle_class']=$postData["vechicle_class"];
    	//$param['vechicle_logo'] = $postData["uploadvalues"];
    	//$param['vechiclecomfort'] = $postData["vechiclecomfort"];
    
      	$vechicle_id = $this->vechicle_model->save($param);
    
    	if ($vechicle_id)
    	{
    		$this->response(array('state'=>'success'));
    	}else{
		   $this->response(array('state'=>'fail'));
		}
    	$this->response('error');
    }

  function addmyvehiclewithimg_post(){
   	$postData = json_decode(file_get_contents("php://input"), true);
    	$this->user_id = $postData['u_id'];
    	$id = null;
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
    
    	$param['vechicle_id'] = $id;
    	$param['vechicle_type_id'] = $postData["vechicle_type_id"];
    	$param['vechicle_number'] = $postData["txtvechicle"];
    	$param['user_id'] = $this->user_id;
		$param['veh_insurence']=$postData["ins"];
		$param['veh_document']=$postData["doc"];
		$param['vehicle_type_name']=$postData["vehicle_type_name"];
    	//$param['vechicle_logo'] = $postData["uploadvalues"];
    	//$param['vechiclecomfort'] = $postData["vechiclecomfort"];
        $base=$postData['image'];
		$structure = 'vehicle_images/'.$this->user_id.'/';

	  mkdir($structure, 0777, true);

	$binary=base64_decode($base);
	header('Content-Type: bitmap; charset=utf-8');
	$file = fopen('vehicle_images/'.$this->user_id.'/veh_img.jpg', 'wb');
	$ret=fwrite($file, $binary);
    	//$vechicle_id = $this->vechicle_model->save($param);
    
    	if ($vechicle_id)
    	{
    		$this->response(array('state'=>'success'));
    	}else{
		   $this->response(array('state'=>'fail'));
		}
    	$this->response('error');
  }
}
?>