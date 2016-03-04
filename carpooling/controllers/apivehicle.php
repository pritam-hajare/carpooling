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
    	$postData = json_decode(file_get_contents("php://input"), true);
        $data["searchResult"]=$this->Vehiclescategory_model->getcategory_list();
        
        if($data!=false){
            $data["status"]="Success";
            $this->response($data);
        }else{
            $data["status"]="fail";
        }
    }

    function getvehicletypes_post(){
        $postData = json_decode(file_get_contents("php://input"), true);
        
        $category_id = $postData["cid"];
        $data["searchResult"]=$this->vechicle_model->get_type_list_for_app($category_id);
        
        if($data!=false){
            $data["status"]="success";
            $this->response($data);
        }else{
            $data["status"]="fail";
        }
    }
    
	function deletevechicle_post(){
    $postData = json_decode(file_get_contents("php://input"), true);
    $param['vechicle_id'] = $postData["VH_ID"];
    $data=$this->vechicle_model->check($postData["VH_ID"]);
        if($data){
        $this->response(array('state'=>'UTC'));
        }else{
        
            $param['is_active']=0;
            $vechicle_id = $this->vechicle_model->save($param);
            if ($vechicle_id)
            {
                $this->response(array('state'=>'success'));
            }else{
               $this->response(array('state'=>'fail'));
            }
            $this->response('error');
        }
    
    }
	
	function updatevechicle_post(){
        $postData = json_decode(file_get_contents("php://input"), true);
       
        $param['vechicle_id'] = $postData["VH_ID"];
        $data=$this->vechicle_model->check($postData["VH_ID"]);
        if($data){
            $this->response(array('state'=>'UTC'));
        }else{
            $param['veh_insurence']=$postData["ins"];
            $param['vechicle_type_id'] = $postData["vechicle_type_id"];
            $param['vechicle_number'] = $postData["txtvechicle"];
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
       }
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
    
        if($vechicle_id)
        {
            $this->response(array('state'=>'success'));
        }else{
            $this->response(array('state'=>'fail'));
        }
        $this->response('error');
    }

    function get_veh_for_select_post() {
        
        $postData = json_decode(file_get_contents("php://input"), true);
        $param['user_id'] = $postData['u_id'];
        $data = $this->vechicle_model->getvechicle_list($param['user_id']);
        
        if(sizeof($data)>0){
            $data['state']='A';
            $this->response($data);
        }
        else{
            $this->response(array('state'=>'NA'));
        }

    }    

    function addmyvehiclewithimg_post(){
   	    //This method works for both add and edit vehicle
        
        $param['vechicle_type_id'] = $_REQUEST["vechicle_type_id"];
        $param['vechicle_number'] = $_REQUEST["txtvechicle"];
        $param['veh_insurence']=$_REQUEST["ins"];
        $param['veh_document']=$_REQUEST["doc"];
        $param['vechicle_class']=$_REQUEST["vechicle_class"];
        $imgName = null;
        $flagUTC = 0;
        if(!isset($_REQUEST['VH_ID']))
        {   //If vechicle_id is not available then add vehicle otherwise update vehicle
            $param['user_id'] = $_REQUEST["u_id"];
            $vechicle_id = $this->vechicle_model->save($param);
            $imgName = 'user_vehicle_' . $vechicle_id . '.jpg';
            $this->vechicle_model->update_veh_name($vechicle_id,$imgName);
        }
        else{
            //Update vehicle
            $imgName = 'user_vehicle_' . $_REQUEST['VH_ID'] . '.jpg';    
            $data=$this->vechicle_model->check($_REQUEST["VH_ID"]);
            if($data){
                $flagUTC = 1;
            }  
            else  
            {
                $param['vechicle_id'] = $_REQUEST['VH_ID'];
                $param['veh_img'] = $imgName;
                $this->vechicle_model->save($param);
            }
        } 

        $base = $_REQUEST['image'];
        $binary=base64_decode($base);
        header('Content-Type: bitmap; charset=utf-8');
        
        $file = fopen('uploads/vehicle/full/'.$imgName, 'wb');
        chmod('uploads/vehicle/full/'.$imgName, 0777);
        $status = fwrite($file, $binary);
        fclose($file);

        $file = fopen('uploads/vehicle/medium/'.$imgName, 'wb');
        chmod('uploads/vehicle/medium/'.$imgName, 0777);
        $status = fwrite($file, $binary);
        fclose($file);

        $file = fopen('uploads/vehicle/small/'.$imgName, 'wb');
        chmod('uploads/vehicle/small/'.$imgName, 0777);
        $status = fwrite($file, $binary);
        fclose($file);

        $file = fopen('uploads/vehicle/thumbnails/'.$imgName, 'wb');
        chmod('uploads/vehicle/thumbnails/'.$imgName, 0777);
        $status = fwrite($file, $binary);
        fclose($file);   

        if($status != false)
        {   
            
            if($flagUTC == 0)
            {   
                echo "<p>success</p>";
            }
            else if($flagUTC == 1){
                echo "<p>UTC</p>";
            }
            else{
                echo "<p>fail</p>";
            }
        }
        else{
            echo "<p>fail</p>";
        }
        
    }
    
}
?>