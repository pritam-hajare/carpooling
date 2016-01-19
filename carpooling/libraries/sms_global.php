<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sms_global {
    var $user;
    var $pass;
    var $to;
    var $from;
    var $message;
    var $error;
    var $smsID;
    var $serverResponse;
    
    function _clear()
    {
        $this->to = '';
        $this->from = '';
        $this->message = '';
        $this->error = '';
    }
    
    function Sms_global($config = array())
    {        
	     
        $this->_clear();
        if (count($config) > 0)
        {
            foreach ($config as $key => $val)
            {
                $this->$key = $val;
            }
        }    

    }
    
    function to($to)
    {
        $this->to = $to;
    }
    
    function from($from)
    {
        $this->from = $from;
    }
    
    function message($message)
    {
        $this->message = $message;
    }
    
    function send()
    {
       	return true;
    }
    
    function get_sms_id()
    {
        return $this->smsID;
    }
    
    function print_debugger()
    {
        echo '<strong>Status:</strong> ';
        if ($this->error)
        {
            echo $this->error.'<br />';
        } 
        else
        {
            echo 'SMS sent succesfully<br />';
        }
        echo '<strong>SMS ID:</strong> '.$this->smsID.'<br />';
        echo '<strong>Username:</strong> '.$this->user.'<br />';
        echo '<strong>Password:</strong> '.$this->pass.'<br />';
        echo '<strong>To:</strong> '.$this->to.'<br />';
        echo '<strong>From:</strong> '.$this->from.'<br />';
        echo '<strong>Message:</strong> '.$this->message.'<br />';
        echo '<strong>Server Response</strong> '.$this->serverResponse;
        
    }
    
    function sg_send_sms($user,$pass,$sms_from,$sms_to,$sms_msg)  
    {      
       /* echo $user.','.$pass.','.$sms_from.','.$sms_to.','.$sms_msg;
		die;*/
		$msg_type = "text";      
        $unicode = "0";            
        $query_string = "httpapi/smsapi?uname=".$user."&password=".$pass;
	
	    $query_string .= "&sender=".rawurlencode($sms_from)."&receiver=".rawurlencode($sms_to);
        $query_string .= "&route=T&msgtype=1";
        $query_string .= "&sms=".rawurlencode(stripslashes($sms_msg));
      $url = "http://live.pay4sms.in/".$query_string;      
        $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_URL,$url);
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,30);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        $this->serverResponse = $response;
        if ($response)      
        {          
		
		$ok = true;
            // got response from server          
           // $response = split("; Sent queued message ID:",$response);          
//            $response1 = split(":",$response[0]);          
//            $smsglobal_status = trim($response1[1]);          
//          //  $response2 = split(":",$response[1]);          
//          //  $smsglobalmsgid = trim($response2[1]);            
//            if ($smsglobal_status=="0")          
//            {              
//                // message sent successfully              
//                $ok = $smsglobalmsgid;          
//            }          
//            else           
//            {              
//                // gateway will issue a pause here and output will be delayed
//                // possible bad user name and password 
//                $ok = false;          
//            }      
        }      
        else       
        {          
            // no contact with gateway          
            $ok = false;      
        }      
        return $ok;  
    }

}    
?>