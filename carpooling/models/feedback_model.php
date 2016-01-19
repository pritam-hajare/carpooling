<?php
Class Feedback_model extends CI_Model
{

	//this is the expiration for a non-remember session
	var $session_expire	= 7200;
	
	
	function __construct()
	{
			parent::__construct();
		 
		 
	}
	
	/********************************************************************

	********************************************************************/
	
	function get_feedback($search=false, $limit=0, $offset=0, $order_by='id', $direction='DESC')
	{
		//if(!empty($search->start_top))
//			{
//				$search->start_top = date('Y-m-d', strtotime($search->start_top)+86400);
//				$this->db->where('create_date >=',$search->start_top);
//			}
//		if(!empty($search->end_top))
//			{
//				//echo $search->end_date;
//				//increase by 1 day to make this include the final day
//				//I tried <= but it did not function. Any ideas why?
//				$search->end_top = date('Y-m-d', strtotime($search->end_top)+86400);
//				$this->db->where('create_date <',$search->end_top);
//			}
	
			
		$this->db->order_by($order_by, $direction);
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}
		
		$result	= $this->db->get('tbl_feedback');
		/*echo $this->db->last_query();
		die;*/
		return $result->result();
	}
	
	
}