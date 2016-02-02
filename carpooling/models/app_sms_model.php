<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class App_sms_model extends CI_Model
{
	function send_otp($mobno,$otp)  
    {   
        $api_url = "http://www.logonutility.in/enterprise/app/smsapi/index.php?key=356601BDA902DC&campaign=5887&routeid=20&type=text&contacts=".$mobno."&senderid=OPAUTO&msg=Message+from+GoGreenRyde+:+your+phone+verification+code+is+".$otp."";
		$response = file_get_contents($api_url);
    }

    function alert_guardian($mobno,$msg)  
    {   
        $api_url = "http://www.logonutility.in/enterprise/app/smsapi/index.php?key=356601BDA902DC&campaign=5887&routeid=20&type=text&contacts=".$mobno."&senderid=OPAUTO&msg=".$msg."";
		$response = file_get_contents($api_url);
    }
}    
?>