<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_notification_model extends CI_Model
{   

    public function __construct()
    {
        parent::__construct();
    }

    function send_notification($user_ids,$message)  
    {   
        $gcmIds=$this->get_gcm_id($user_ids);
        return $this->sendNotification($gcmIds,$message);
    }

    function get_gcm_id($user_ids)  
    {   
        $this->db->select('gcm_id');
        $this->db->from('tbl_users');
        $this->db->where('user_id',$user_ids);
        $this->db->where('login_state_app',1);
              
        $result = $this->db->get();
        $result = $result->result_array();
        
        $i=0;
        foreach ($result as $row);
        {
            $gcm_ids[$i]=$row['gcm_id'];
            $i++;
        }

        return $gcm_ids;
    }

    function sendNotification($gcm_ids, $message) {

        $this->load->library('gcm');

        for ($i=0; $i < count($gcm_ids) ; $i++) { 
            $this->gcm->addRecepient($gcm_ids[$i]);
        }

        $this->gcm->setData($message);
        if ($this->gcm->send())
            return true;
        else
            return false;
    }
}    
?>