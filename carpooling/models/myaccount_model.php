<?php
class Myaccount_model extends CI_Model {


function __construct()
    {
        parent::__construct();
		
    }


	
	function getapplied_list($param, $limit = NULL, $offset = NULL)
	{
          $this->db->limit($limit,$offset);
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	$this->db->join('job_applied_jobs', 'job_jobs_list.jobs_id = job_applied_jobs.appl_job_id');
	$this->db->where('appl_user_id',$param['uid']);
	
    $query  = $this->db->get('job_jobs_list');
	 $result = $query->result_array();
//echo  $this->db->last_query();
	  	if($result)
			{
			$i=0;
            foreach( $result as $key => $row )
            {
				$category = str_replace('~','"',$row['jobs_category']);
				//die;
				$this->db->where('cate_id IN('.$category.')'); 
				$catlist = $this->db->get('job_category')->result();
				$temp['categoryinfo_'.$row['jobs_id']]	  = $catlist;
			}
			$data['job_info'] =$result;
			$data['other_info'] =$temp;
	
			}
			else
			{
				$data['job_info'] ="";
				$data['other_info'] ="";
			}
			 return $data;
			//die;
			
    
	}
	
			function getreferfriend_list($param, $limit = NULL, $offset = NULL)
	{
          $this->db->limit($limit,$offset);
		  $this->db->select('*');
	
	$this->db->join('job_ref_jobs', 'job_jobs_list.jobs_id = job_ref_jobs.ref_job_id');
	$this->db->where('ref_user_id',$param['uid']);
	
    $query  = $this->db->get('job_jobs_list');
	 $result = $query->result_array();

			$data['job_info'] =$result;
			
			 return $data;
			//die;
			
    
	}
		function getbookmark_list($param, $limit = NULL, $offset = NULL)
	{
          $this->db->limit($limit,$offset);
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	$this->db->join('job_bookmark_jobs', 'job_jobs_list.jobs_id = job_bookmark_jobs.bmrk_job_id');
	$this->db->where('bmrk_user_id',$param['uid']);
	
    $query  = $this->db->get('job_jobs_list');
	 $result = $query->result_array();
//echo  $this->db->last_query();
	  	if($result)
			{
			$i=0;
            foreach( $result as $key => $row )
            {
				$category = str_replace('~','"',$row['jobs_category']);
				//die;
				$this->db->where('cate_id IN('.$category.')'); 
				$catlist = $this->db->get('job_category')->result();
				$temp['categoryinfo_'.$row['jobs_id']]	  = $catlist;
			}
			$data['job_info'] =$result;
			$data['other_info'] =$temp;
	
			}
			else
			{
				$data['job_info'] ="";
				$data['other_info'] ="";
			}
			 return $data;
			//die;
			
    
	}
	function getourpicks_list($param, $limit = NULL, $offset = NULL)
	{
		
		   $queryame = $this->db->query('SELECT * FROM job_user_details WHERE usrd_user_id = '.$param['uid']);
	        $resultame=$queryame->result();
			if($resultame)
			{
			$ameid='0,';
			 foreach($resultame as $ame) 
			 {
            $keyskills= $ame->usrd_skils;
			//$queryame = $this->db->query('SELECT * FROM job_keyskills WHERE kysk_name like %'.$keyskills.')');
//	        $resultskill=$queryame->result();
//			if($resultskill)
//			{
//			
//			 foreach($resultame as $skill) 
//			 {
//				 $skillid.= $skill->kysk_id.',';
//			 }
//			}
             }
		   }
		   else
		   {
		   $ameid ='';
		   }
		   
          $this->db->limit($limit,$offset);
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	//$this->db->join('job_applied_jobs', 'job_jobs_list.jobs_id = job_applied_jobs.appl_job_id');
	$this->db->where('MATCH(jobs_keyskills_text) AGAINST("'.$keyskills.'" IN BOOLEAN MODE)'); 
	 
	
    $query  = $this->db->get('job_jobs_list');
	 $result = $query->result_array();
//echo  $this->db->last_query();
	  	if($result)
			{
			$i=0;
            foreach( $result as $key => $row )
            {
				$category = str_replace('~','"',$row['jobs_category']);
				//die;
				$this->db->where('cate_id IN('.$category.')'); 
				$catlist = $this->db->get('job_category')->result();
				$temp['categoryinfo_'.$row['jobs_id']]	  = $catlist;
			}
			$data['job_info'] =$result;
			$data['other_info'] =$temp;
	
			}
			else
			{
				$data['job_info'] ="";
				$data['other_info'] ="";
			}
			 return $data;
			//die;
			
    
	}
	
	
	function getwish_list($param, $limit = NULL, $offset = NULL)
	{
		
		   $queryame = $this->db->query('SELECT * FROM job_user_details WHERE usrd_user_id = '.$param['uid']);
	        $resultame=$queryame->result();
			if($resultame)
			{
			$ameid='0,';
			 foreach($resultame as $ame) 
			 {
            $keyskills= $ame->usrd_secskils;
			 }
		   }
		   else
		   {
		   $ameid ='';
		   }
		   
          $this->db->limit($limit,$offset);
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	//$this->db->join('job_applied_jobs', 'job_jobs_list.jobs_id = job_applied_jobs.appl_job_id');
	$this->db->where('MATCH(jobs_keyskills_text) AGAINST("'.$keyskills.'" IN BOOLEAN MODE)'); 
	 
	
    $query  = $this->db->get('job_jobs_list');
	 $result = $query->result_array();
//echo  $this->db->last_query();
	  	if($result)
			{
			$i=0;
            foreach( $result as $key => $row )
            {
				$category = str_replace('~','"',$row['jobs_category']);
				//die;
				$this->db->where('cate_id IN('.$category.')'); 
				$catlist = $this->db->get('job_category')->result();
				$temp['categoryinfo_'.$row['jobs_id']]	  = $catlist;
			}
			$data['job_info'] =$result;
			$data['other_info'] =$temp;
	
			}
			else
			{
				$data['job_info'] ="";
				$data['other_info'] ="";
			}
			 return $data;
			//die;
			
    
	}
		function count_result($param) 
		{
		
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	$this->db->join('job_applied_jobs', 'job_jobs_list.jobs_id = job_applied_jobs.appl_job_id');
	$this->db->where('appl_user_id',$param['uid']);
	
    
    $query  = $this->db->get('job_jobs_list');
	//echo  $this->db->last_query();
	 $result = $query->result_array();
		 return $num_rows = $query->num_rows();
      
    } 
	
	function bookmarkcount_result($param) 
		{
		
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	$this->db->join('job_bookmark_jobs', 'job_jobs_list.jobs_id = job_bookmark_jobs.bmrk_job_id');
	$this->db->where('bmrk_user_id',$param['uid']);
	
    
    $query  = $this->db->get('job_jobs_list');
	//echo  $this->db->last_query();
	 $result = $query->result_array();
		 return $num_rows = $query->num_rows();
      
    } 
	
		function referfriendcount_result($param) 
		{
		
 $this->db->select('*');
	
	$this->db->join('job_ref_jobs', 'job_jobs_list.jobs_id = job_ref_jobs.ref_job_id');
	$this->db->where('ref_user_id',$param['uid']);
	
    $query  = $this->db->get('job_jobs_list');

	
	//echo  $this->db->last_query();
	 $result = $query->result_array();
		 return $num_rows = $query->num_rows();
      
    } 
	
	function wishcount_result($param) 
		{
		
		 $queryame = $this->db->query('SELECT * FROM job_user_details WHERE usrd_user_id = '.$param['uid']);
	        $resultame=$queryame->result();
			if($resultame)
			{
			$ameid='0,';
			 foreach($resultame as $ame) 
			 {
          
			 $keyskills= $ame->usrd_secskils;
			 }
		   }
		   else
		   {
		   $ameid ='';
		   }
		   
         
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	//$this->db->join('job_applied_jobs', 'job_jobs_list.jobs_id = job_applied_jobs.appl_job_id');
	$this->db->where('MATCH(jobs_keyskills_text) AGAINST("'.$keyskills.'" IN BOOLEAN MODE)'); 
	 
	
    $query  = $this->db->get('job_jobs_list');
	 $result = $query->result_array();
		 return $num_rows = $query->num_rows();
      
    } 
	
	
		function pickscount_result($param) 
		{
		
		 $queryame = $this->db->query('SELECT * FROM job_user_details WHERE usrd_user_id = '.$param['uid']);
	        $resultame=$queryame->result();
			if($resultame)
			{
			$ameid='0,';
			 foreach($resultame as $ame) 
			 {
             $keyskills= $ame->usrd_skils;
			 }
		   }
		   else
		   {
		   $ameid ='';
		   }
		   
         
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	//$this->db->join('job_applied_jobs', 'job_jobs_list.jobs_id = job_applied_jobs.appl_job_id');
	$this->db->where('MATCH(jobs_keyskills_text) AGAINST("'.$keyskills.'" IN BOOLEAN MODE)'); 
	 
	
    $query  = $this->db->get('job_jobs_list');
	 $result = $query->result_array();
		 return $num_rows = $query->num_rows();
      
    } 
	
	function count_appresult($uid=null) {
		
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	$this->db->join('job_applied_jobs', 'job_jobs_list.jobs_id = job_applied_jobs.appl_job_id');
	$this->db->where('appl_user_id',$uid);
    $query  = $this->db->get('job_jobs_list');
	//echo  $this->db->last_query();
	 $result = $query->result_array();
		 return $num_rows = $query->num_rows();
      
    } 
	
		function count_bookresult($uid=null) 
		{
		
		  $this->db->select('*');
	 $this->db->join('job_location', 'job_jobs_list.jobs_location = job_location.loct_id');
	 $this->db->join('job_company', 'job_jobs_list.jobs_comp_id = job_company.comp_id');
	$this->db->join('job_bookmark_jobs', 'job_jobs_list.jobs_id = job_bookmark_jobs.bmrk_job_id');
	$this->db->where('bmrk_user_id',$uid);
    $query  = $this->db->get('job_jobs_list');
	//echo  $this->db->last_query();
	 $result = $query->result_array();
		 return $num_rows = $query->num_rows();
      
    } 
	
	
	function Update_profile($paramupt)
	{
	$data = array(  
			        'usrd_fname' => $paramupt['usrd_fname'],
					'usrd_lname' => $paramupt['usrd_lname'],
					'usrd_gender' =>$paramupt['usrd_gender'],
				   'usrd_phone_no' => $paramupt['usrd_phone_no'],
				   'usrd_mobile_no' => $paramupt['usrd_mobile_no'],
				   'usrd_skils' => $paramupt['usrd_skils'],
				   'usrd_secskils' => $paramupt['usrd_secskils'],
				   'usrd_experience' => $paramupt['usrd_experience'],
				   'usrd_current_industry' => $paramupt['usrd_current_industry'],
				   'usrd_current_loct_id' => $paramupt['usrd_current_loct_id']
				 );
			  
			   
	  $this->db->where('usrd_user_id',  $paramupt['usrd_user_id']);
      $this->db->update('job_user_details', $data);
	 // echo $this->db->last_query();
	  
	//   echo $this->db->affected_rows();
	}
	
	function Update_password($paramupt)
	{
	$data = array(            
			                'user_password' => $paramupt['user_password']
									   
				   
							
				 );
			   
			   
	  $this->db->where('user_id', $paramupt['user_id']);
      $this->db->update('job_user', $data);
	}
	function get_oldpassword($username, $password)
	{
		$this -> db -> select('user_id,user_email, user_password');
		$this -> db -> from('job_user');
		$this -> db -> where('user_id = ' . "'" . $username . "'"); 
		$this -> db -> where('user_password = ' . "'" . MD5($password) . "'"); 
	
		$this -> db -> where('active_flg = ' . "0");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}
	function profile_photochange($param)
	{
	$this->db->from('job_user');
        $this->db->select('user_photo');
		$this->db->where('user_id', $param['user_id']);
		$query = $this->db->get();
	
if ( $query->num_rows() > 0 )
    {
	$row = $query->row_array();
	@unlink('./uploads/profiles/'.$row['user_photo']);
	$user_photo= base_url().'uploads/profiles/'.$param['user_photo'];
	$data = array('user_photo' => $user_photo);
	 $this->db->where('user_id', $param['user_id']);
     $this->db->update('job_user', $data);
	 }
	 else
	 {
	 $data = array('user_photo' => $param['user_photo']);
	 $this->db->where('user_id', $param['user_id']);
     $this->db->update('job_user', $data);
	 }
	 
	}
	
	function getproperty_roomdetails($propertyid)
	{
	$this->db->where('property_id', $propertyid);
      return $this->db->get('tbl_propertydetails')->result();
	}
	
	
	
	function getproperty_photo($propertyid)
	{
      $this->db->order_by('propertyphoto_id','asc');
	  $this->db->where('property_id',$propertyid);
      return $this->db->get('tbl_propertyphoto')->result();
	}
	
	function getjobseekar_profile($ownerid) 
	{


	   $this->db->join('job_user_details', 'job_user_details.usrd_user_id = job_user.user_id');
		$this->db->where('user_id', $ownerid);
		$data = $this->db->get('job_user')->result();
	//echo $this->db->last_query();
	 return $data;
		
       
	}
	
	

	function getcountry_list()
	{ 
	
		$this->db->select('country_id,country_name');
		$this->db->order_by('country_id');
        $data = $this->db->get('tbl_country')->result();
        return $data;
    } 
	
	function getstate_list($country = null)
	{
      $this->db->select('state_id, state_name');
 
      if($country != NULL)
	  {
          $this->db->where('country_id', $country);
      }
 
     $query = $this->db->get('tbl_state');
 
     $state = array();
 
     if($query->result()){
          foreach ($query->result() as $state) {
              $staties[$state->state_id] = $state->state_name;
			 
          }
      return $staties;
      }else{
          return FALSE;
      }
   }
   function getcity_list($state = null)
	{
      $this->db->select('city_id, city_name');
 
      if($state != NULL)
	  {
          $this->db->where('state_id', $state);
      }
 
     $query = $this->db->get('tbl_city');
 
     $city = array();
 
     if($query->result()){
          foreach ($query->result() as $city) {
              $cities[$city->city_id] = $city->city_name;
			 
          }
      return $cities;
      }else{
          return FALSE;
      }
   }

	
	
	

	
}
?>