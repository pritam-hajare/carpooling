<?php
class Forms_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function get_category_list() {
		return $this->db->order_by('catname', 'ASC')->get('tbl_category')->result();
	}
	function get_year_list() {
		return $this->db->order_by('yearname', 'ASC')->get('tbl_year')->result();
	}
		
	function get_company_list() {
		return $this->db->order_by('comp_name', 'ASC')->get('job_company')->result();
	}
		
	
	function get_city_list()	{ 
			return $this->db->order_by('cityname', 'ASC')->get('tbl_city')->result();
    }
	
	function get_tech_list() {
		return $this->db->order_by('techname', 'ASC')->get('tbl_technology')->result();
	}
	function get_project_tech_list($techids) {
		 
		return $this->db->order_by('techname', 'ASC')->where('techid IN('.$techids.')')->get('tbl_technology')->result();
	}
	
	function get_dept_list() {
		return $this->db->order_by('depname', 'ASC')->get('tbl_department')->result();
	}
	function get_project_dept_list($deptids) {
		 
		return $this->db->order_by('depname', 'ASC')->where('depid IN('.$deptids.')')->get('tbl_department')->result();
	}
	
	
	function get_domain_list() {
		return $this->db->order_by('domainname', 'ASC')->get('tbl_domain')->result();
	}
	function get_project_domain_list($domainids) {
		 
		return $this->db->order_by('domainname', 'ASC')->where('domainid IN('.$domainids.')')->get('tbl_domain')->result();
	}
	function get_project($id)
	{
		return $this->db->get_where('tbl_projects', array('projid'=>$id))->row();
	}
	function get_providerproject($id,$pm_comp_id=0)
	{
		return $this->db->get_where('tbl_projects', array('projid'=>$id,'projproid'=>$pm_comp_id))->row();
	}

	
	function projects($data=array(), $return_count=false)
	{
		if(empty($data))
		{
			//if nothing is provided return the whole shabang
			$this->get_all_projects();
		}
		else
		{
			//grab the limit
			if(!empty($data['rows']))
			{
				$this->db->limit($data['rows']);
			}
			
			//grab the offset
			if(!empty($data['page']))
			{
				$this->db->offset($data['page']);
			}
			
			//do we order by something other than category_id?
			if(!empty($data['order_by']))
			{
				//if we have an order_by then we must have a direction otherwise KABOOM
				$this->db->order_by($data['order_by'], $data['sort_order']);
			}
			
			//do we have a search submitted?
			if(!empty($data['term']))
			{
				$search	= json_decode($data['term']);
				//if we are searching dig through some basic fields
				if(!empty($search->term))
				{
					$this->db->like('projtitle', $search->term);
					$this->db->or_like('description', $search->term);
					$this->db->or_like('excerpt', $search->term);
					$this->db->or_like('sku', $search->term);
				}
				
				if(!empty($search->category_id))
				{
					//lets do some joins to get the proper category projects
					$this->db->join('category_projects', 'category_projects.product_id=projects.id', 'right');
					$this->db->where('category_projects.category_id', $search->category_id);
					$this->db->order_by('sequence', 'ASC');
				}
			}
			
				$this->db->join('tbl_provider', 'tbl_provider.prodid=tbl_projects.projproid');
			if($return_count)
			{
				return $this->db->count_all_results('tbl_projects');
			}
			else
			{
				return $this->db->get('tbl_projects')->result();
			}
			
		}
	}
	
	function get_all_projects()
	{
		//sort by alphabetically by default
		$this->db->order_by('projtitle', 'ASC');
		$this->db->join('tbl_provider', 'tbl_provider.prodid=tbl_projects.projproid');
		$result	= $this->db->get('tbl_projects');
		//apply group discount
		$return = $result->result();
		
		return $return;
	}
	
	

	
	function get_projects( $pm_comp_id = 0 ) {
		$this->db->from('tbl_projects');

		$this->db->where('projproid', $pm_comp_id);
		$this->db->order_by('projid', 'DESC');
		$res = $this->db->get();
		//echo $this->db->last_query();
		return $res->result();
		
		//return $this->db->order_by('jobs_id', 'DESC')->get('job_jobs_list')->result();
	}



	
	function saveconcept($pmData)
	{
		
		
		if(!$pmData['projectconceptid']) 
		{
			$this->db->insert('tbl_projectconcept', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('projectconceptid', $pmData['projectconceptid']);
			$this->db->update('tbl_projectconcept', $pmData);
			return $pmData['projectconceptid'];
		}
	}	
	
	function savejobs($pmData)
	{
		
		$this->db->select('*');
		$this->db->where('student_id',$pmData['student_id']);
		$this->db->limit(1);
		$result = $this->db->get('tbl_jobassitance');
		$jobs	= $result->row_array();
		//echo $this->db->last_query();
	
		if ($jobs)
		{
			$this->db->where('student_id', $jobs['student_id'])->update('tbl_jobassitance', $pmData);
			return $jobs['jobid'];
		}
		else
		{
			if(!$pmData['jobid']) 
			{
				$this->db->insert('tbl_jobassitance', $pmData);
				return $this->db->insert_id();
			} 
			else 
			{
				$this->db->where('jobid', $pmData['jobid']);
				$this->db->update('tbl_jobassitance', $pmData);
				return $pmData['jobid'];
			}
		}
	}
	
	function saveexpert($pmData)
	{
			
		if(!$pmData['id']) 
		{
			$this->db->insert('tbl_asktoexpert', $pmData);
			return $this->db->insert_id();
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
		function delete_project($id)
	{
		// delete product 
		$this->db->where('projid', $id);
		$this->db->delete('tbl_projects');

	

	}
}
?>