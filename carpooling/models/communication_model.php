<?php
Class Communication_model extends CI_Model
{

	//this is the expiration for a non-remember session
	
	
	
	function __construct()
	{
			parent::__construct();
			$data['error'] ="";
    	 $account['user'] = 'piccosoft';
	 	 $account['pass'] = 'xxxxxx';
		 $account['from'] = 'FNLSEM';
		 $this->load->library('Sms_global',$account);
	}
	
	 function student_pwd_send($mobileno,$password)
	  {
		    $this -> mobile = $mobileno;
			$this->sms_global->to($this -> mobile);	
			$this->sms_global->message('Your Password is ' .$password.' By www.finalsem.com');
			$this->sms_global->send();
			return true;
			
	  }
	  
	  function provider_pwd_send($mobileno,$password)
	  {
		    $this -> mobile = $mobileno;
			$this->sms_global->to($this -> mobile);	
			$this->sms_global->message('Your Password is ' .$password.' By www.finalsem.com');
			$this->sms_global->send();
			return true;
			
	  }
	  
	  function provider_enquiry_send($data)
	  {
		    $this -> mobile = $data['mobileno'];
			$this->sms_global->to($this -> mobile);	
			$this->sms_global->message('You have received a New student enquiry.  Mobile: '.$data['studno'].' Name: '.$data['studname'].' By www.finalsem.com');
			$this->sms_global->send();
	
			//echo "test success";
	  }
	  
	  function student_enquiry_send($data)
	  {
		    $this -> mobile = $data['mobileno'];
			$this->sms_global->to($this -> mobile);	
			$this->sms_global->message('Please find contact information of project center.  Mobile: '.$data['prodcontno'].' Name: '.$data['prodcompname'].' Email:'.$data['prodemail'].'By www.finalsem.com');
			$this->sms_global->send();
	
			//echo "test success";
	  }
	  
	
	  
	  function provider_intimation($data)
	  {
		    $this -> mobile = $data['mobileno'];
			$this->sms_global->to($this -> mobile);	
			$this->sms_global->message('Congrates! New Enquiry -  Mobile:xxxxx Name:xxxxx but your balance is low update your package By www.finalsem.com');
			$this->sms_global->send();
	
			//echo "test success";
	  }
	  
	  
}

