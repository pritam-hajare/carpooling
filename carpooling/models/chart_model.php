<?php
Class Chart_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		
	}
	
	function get_charts($provid)
	 {
		  $this->db->select('sum(projhit) as projhit ,month,year');
		  $this->db->group_by('month');
		  $this->db->order_by('projhit ASC');
		 $this->db->where('provider_id',$provid); 
		  $result = $this->db->get('tbl_chart');
		  //echo $this->db->last_query();
		  return $result->result();
		  $chartdata = array();
		  foreach($result->result() as $cat)
		  {
		   $chartdata[] = array($cat->year,date("m", strtotime($cat->month)),$cat->projhit);
		  }
		  
		  return $chartdata;
	 }
	
	function add_projhit($param){
		$this->db->insert('tbl_chart', $param);
		return $this->db->insert_id();
	}
}