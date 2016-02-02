<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_otp_model extends CI_Model
{
	function save_otp($user_id,$otp)
    {   
        $data=array('OTP'=>$otp);
        $this->db->where('user_id',$param['user_id']);
        $this->db->update('tbl_users', $data);    
    }
}    
?>