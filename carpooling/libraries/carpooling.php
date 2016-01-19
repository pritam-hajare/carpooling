<?php  
class carpooling {
	var $CI;
	

	// Cart properties and items will go in here
	//  Modified from the original cart lib as follows:
	//    _cart_contents[ (cart property indexes) ] = (property value)
	//    _cart_contents[items]	= (shopping cart products list)
	// This has to be in a single variable for easy session storage
	var $_cart_contents	= array();
		var $carpool_sess = array();
		
	
	var $gift_cards_enabled = false;
	
	function __construct() 
	{
		$this->CI =& get_instance();
	//	$this->CI->load->model(array('Coupon_model' , 'Gift_card_model', 'Settings_model', 'Digital_Product_model'));
		
		// Load the saved session
		
		
				$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->library('encrypt');
		
		$carpool_session_config = array(
		    'sess_cookie_name' => 'carpool_session_config',
		    'sess_expiration' => 0
		);
		$this->CI->load->library('session', $carpool_session_config, 'carpool_session');
		//print_r($this->CI->student_session->userdata('student'));
		if ($this->CI->carpool_session->userdata('carpool') !== FALSE)
		{
			$this->carpool_sess = $this->CI->carpool_session->userdata('carpool');
		}
		else
		{
			// Or init a new session
			$this->_init_properties();
			
		}
		
		
		
		//die(var_dump($this->_cart_contents));
	}

	private function _init_properties($totals_only=false, $preserve_customer=false)
	{
		
		
		
		// We want to preserve the cart items and properties, but reset total values when recalculating
		if( ! $totals_only) 
		{
		
			
			if(!$preserve_customer)
			{
				// customer data container
				
				$this->carpool_sess = false;
			}
			
			
			
			
			
		}
	}
	

	
		

	function contents()
	{
		return $this->_cart_contents['items'];
	}
	
	 
	

	function customer()
	{


		//print_r( $this->student_sess);
		if(!$this->carpool_sess)
		{
			return false;
		}
		else
		{
			return $this->carpool_sess;
		}
		
	}
	
	// Saves customer data in the carpool
	function save_customer($data)
	{
    	 $this->CI->carpool_session->set_userdata(array('carpool' => $data));
	
	}
	
	
	

	function total_items()
	{
		return $this->_cart_contents['total_items'];
	}
}
?>