<?php
class Jobs_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_category_list() {
		return $this->db->order_by('cate_name', 'ASC')->get('job_category')->result();
	}
		
	function get_company_list() {
		return $this->db->order_by('comp_name', 'ASC')->get('job_company')->result();
	}
		
	function get_location_list() {
		return $this->db->order_by('loct_name', 'ASC')->get('job_location')->result();
	}
	
	function get_qualification_list() {
		return $this->db->order_by('qual_name', 'ASC')->get('job_qualification')->result();
	}
	
	function get_skils_list() {
		return $this->db->order_by('kysk_name', 'ASC')->get('job_keyskills')->result();
	}
	
	function totaljob() 
	{
	$this->db->select('*');
	$this->db->join("job_company", "comp_id=jobs_comp_id");
	 $this->db->join('job_company_user', 'job_jobs_list.jobs_usrc_id = job_company_user.usrc_id');
	$query  = $this->db->get('job_jobs_list');
	
	 $result = $query->result_array();
	$num_rows = $query->num_rows();
	
	$this->db->select('*');
	$query  = $this->db->get('job_featured');
	 $result = $query->result_array();
	 $num_rows1 = $query->num_rows(); 
	 return  $num_rows + $num_rows1;
	 
	}
	
	function get_jobs_list() {
		$this->db->from('job_jobs_list');
		$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_company", "comp_id=jobs_comp_id");
		$this->db->where('jobs_status', 1);
		$this->db->where('loct_status', 1);
		$this->db->where('comp_status', 1);
		$res = $this->db->get();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function get_company_jobs_list( $pm_comp_id = 0 ) {
		$this->db->from('job_jobs_list');
		$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_company", "comp_id=jobs_comp_id");
		$this->db->where('jobs_status', 1);
		$this->db->where('loct_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('comp_id', $pm_comp_id);
		$res = $this->db->get();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function get_company_recent_jobs_list( $pm_comp_id = 0 ) {
		$this->db->from('job_jobs_list');
		$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_company", "comp_id=jobs_comp_id");
		$this->db->where('jobs_status', 1);
		$this->db->where('loct_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('comp_id', $pm_comp_id);
		$this->db->order_by('jobs_id', 'DESC');
		$this->db->limit(10);
		$res = $this->db->get();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}

	
	function get_jobs( $pm_jobs_id) {
		$this->db->from('job_jobs_list');
		$this->db->join("job_location", "jobs_location=loct_id");
		$this->db->join("job_company", "comp_id=jobs_comp_id");
		$this->db->where('jobs_status', 1);
		$this->db->where('loct_status', 1);
		$this->db->where('comp_status', 1);
		$this->db->where('jobs_id', $pm_jobs_id);
		$res = $this->db->get();
		return $res->result_array();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}
	
	function insertjobs($pmData)
	{
		if(!$pmData['jobs_id']) 
		{
			$this->db->insert('job_jobs_list', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('jobs_id', $pmData['jobs_id']);
			$this->db->update('job_jobs_list', $pmData);
			return $pmData['jobs_id'];
		}
	}	
	
		function getjob_details($jobid)
	{

	 
	  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	 $this->db->join('job_company_user', 'job_jobs_list.jobs_usrc_id = job_company_user.usrc_id');
	 
	   $this->db->where('jobs_id', $jobid);
	   // $this->db->where('jobs_id', $jobid);
    $query  = $this->db->get('job_jobs_list');
	 $result = $query->result_array();
//	 echo $this->db->last_query();
	  	if($result)
			{
			$i=0;
            foreach( $result as $key => $row )
            {
				
				
				$catid=str_replace('~','',$row['jobs_category']);
				//$this->db->where('cate_id IN("4","5")');
				if($catid == "")
				{
					$catid = '"~~"';
				}
				$this->db->where('cate_id IN('.$catid.')'); 
				$catlist = $this->db->get('job_category')->result();
				$temp['categoryinfo_'.$row['jobs_id']]	  = $catlist;
			}
			foreach( $result as $key => $row )
            {
				
				$qid=str_replace('~','',$row['jobs_qulification']);
				if($qid == "")
				{
					$qid = '"~~"';
				}
				$this->db->where('qual_id IN('.$qid.')'); 
				$qlist = $this->db->get('job_qualification')->result();
				//echo $this->db->last_query();
				$temp['qulificationinfo_'.$row['jobs_id']]	  = $qlist;
			}
			}
			
			//die;
			
			
				
				$data['job_info'] =$result;
			
			if(isset($temp))
			{
			$data['other_info'] =$temp;
			}
			else
			{
				$data['other_info'] = "";
			}
	 return $data;
	}
	function deletejobs($pmJobsId)
	{
		$this->db->where('jobs_id', $pmJobsId);
		$this->db->delete('job_jobs_list');
				
	}
	function deleterssjobs()
	{
		
		$this->db->empty_table('job_featured');
	//	echo $this->db->last_query();
				
	}
	function applyjob($jid=null,$uid=null)
	{
		$this -> db -> select('*');
		$this -> db -> from('job_applied_jobs');
		$this -> db -> where('appl_user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('appl_job_id = ' . "'" . $jid . "'"); 
		//$this -> db -> where('user_id <> ' . "'" .$uid."'");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{ 
		return 1;
		}
		else
		{
		 $newownerdata = array('appl_user_id' => $uid,'appl_job_id' => $jid);
 		 $this->db->insert('job_applied_jobs', $newownerdata); 
		 return 0;
		}
	}
	
	function bookmark($jid=null,$uid=null)
	{
		$this -> db -> select('*');
		$this -> db -> from('job_bookmark_jobs');
		$this -> db -> where('bmrk_user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('bmrk_job_id = ' . "'" . $jid . "'"); 
		//$this -> db -> where('user_id <> ' . "'" .$uid."'");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{ 
		return 1;
		}
		else
		{
		 $newownerdata = array('bmrk_user_id' => $uid,'bmrk_job_id' => $jid);
 		 $this->db->insert('job_bookmark_jobs', $newownerdata); 
		 return 0;
		}
	}
	
	function referfriend($jid=null,$uid=null,$email=null,$subject=null,$message=null,$friendname=null)
	{
		$this -> db -> select('*');
		$this -> db -> from('job_ref_jobs');
		$this -> db -> where('ref_user_id = ' . "'" . $uid . "'"); 
		$this -> db -> where('ref_job_id = ' . "'" . $jid . "'"); 
		$this -> db -> where('ref_email = ' . "'" . $email . "'");
		//$this -> db -> where('user_id <> ' . "'" .$uid."'");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{ 
		return 1;
		}
		else
		{
		 $newownerdata = array('ref_user_id' => $uid,'ref_job_id' => $jid,'ref_email' => $email,'ref_subject' => $subject,'ref_message' => $message,'ref_name'=>$friendname);
 		 $this->db->insert('job_ref_jobs', $newownerdata); 
		 return 0;
		}
	}
	
	function insertrssjobs($pmData)
	{
	
			$this->db->insert('job_featured', $pmData);
			return $this->db->insert_id();
		
	}
}
?>