<?php
require(APPPATH.'/libraries/REST_Controller.php');

class api_verify_otp extends REST_Controller
{	

	function verify_otp_post() {
		$output=array();
		
		$postData = json_decode(file_get_contents("php://input"), true);
		
		$param['user_id'] = $postData['u_id'];
		$param['OTP'] = $postData['otp_pass'];

		$output['state']=$this->verify($param);
		$this->response($output);
	}

	function verify($param){
		
		if (!empty($param['user_id']) && !empty($param['OTP']) ) {
			
			$this->db->select('user_id');
			$this->db->from('tbl_users');
			$this->db->where('OTP', $param['OTP']);
			$this->db->limit(1);
			$result = $this->db->get();
			$result = $result->row_array();

			if (sizeof($result) > 0) {		
				$data=array('mob_vf' => 1);
				$this->db->where('user_id',$param['user_id']);
				$this->db->update('tbl_users', $data);
				return 'success';
			}
			else{
				return 'fail';	
			}
		}else{
			return "fail";
		}
	}
}
?>