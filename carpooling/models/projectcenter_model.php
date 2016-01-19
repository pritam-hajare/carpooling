<?php
Class Projectcenter_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	function Getprojectcenters($value=array(),$data)
	{
		   $temp=array();
		  if(!empty($value['city']))
		  {
		  	$city_id=$this->getcityid($value['city']);
			$this->db->join('tbl_projects','tbl_projects.projproid = tbl_provider.prodid','inner');	
			$this->db->group_by('tbl_provider.prodname');
			$this->db->like('tbl_projects.projcity', $city_id);
			
		  }	
		 
		  if(!empty($value['order_by']))
		  {
			//if we have an order_by then we must have a direction otherwise KABOOM
			$this->db->order_by($value['order_by'], $value['sort_order']);
		  }
		  
		 
		 			 
		  $view=$this->db->get('tbl_provider');
		  $result=$view->result_array();
		  $data['rowcount'] = $view->num_rows();
		  //shuffle ($result);
		  //echo $this->db->last_query();
		  //print_r($result);
		  //die;
		  if($result)
			{
			$i=0;
	
				foreach( $result as $key => $row )
				{
					
					
					$this->db->select('projtech');
					$this->db->where('projproid',$row['prodid']);
					$this->db->group_by('tbl_projects.projtech');
					$view1=$this->db->get('tbl_projects');	
					//echo $this->db->last_query();				
					$result1=$view1->result_array();
					//print_r($result1);
					 if($result1)
					{
						$id='';
						foreach( $result1 as $key1 => $row1 )
						{
							
							$id.= $row1['projtech'].',';
													
							
						}
						//echo $id;
//						die;
						$techids = str_replace('~','',$id);						
						$techids = rtrim($techids,',');
						//echo $techids;
						$temp['tech_'.$row['prodid']] = $this->db->order_by('techname', 'ASC')->where('techid IN('.$techids.')')->get('tbl_technology')->result();
							  
							
					}
					
					$this->db->select('projcity');
					$this->db->where('projproid',$row['prodid']);
					$this->db->group_by('tbl_projects.projcity');
					$view1=$this->db->get('tbl_projects');	
					//echo $this->db->last_query();				
					$result1=$view1->result_array();
					//print_r($result1);
					
					 if($result1)
					{
						$cityid='';
						foreach( $result1 as $key1 => $row1 )
						{
							
							$cityid.= $row1['projcity'].',';
													
							
						}
						//echo $id;
//						die;
						$cityids = str_replace('~','',$cityid);						
						$cityids = rtrim($cityids,',');
						//echo $cityids;
						if($cityids != '')
						{
							
						$temp['city_'.$row['prodid']] = $this->db->order_by('cityname', 'ASC')->where('cityid IN('.$cityids.')')->get('tbl_city')->result();
						}							  
						//print_r($temp);
//						die;	
					}
					
					
					//print_r($temp);
		  			//die;
				}
			}
			//print_r($temp);
//			die;
			$data['projectcenter_details'] = $temp;
			
			$data['projectcenter_results'] =$result;
			//print_r($data);
//			die;
			return $data;
//			print_r($data);
//			die;
		 // echo $this->db->last_query();
//		  die;
		
	}
	
	function Getprojectcenter_detail($prodid=0,$data)
	{
		 $temp=array();
		
		$this->db->join('tbl_category', 'tbl_category.catid = tbl_projects.projcatid');
		$this->db->where('tbl_projects.projstatus', '1');
		$this->db->where('tbl_projects.projproid',$prodid);
		
		
		$this->db->order_by('tbl_projects.projid','RAND'); 		 
	    $this->db->group_by('tbl_projects.projtitle');
		$query = $this->db->get('tbl_projects');
		
//echo $this->db->last_query();
        $result = $query->result_array();
		shuffle ($result);		
	
		if($result)
			{
			$i=0;
	
            foreach( $result as $key => $row )
            {
				
				$domainids = str_replace('~', '', $row['projdomain']);
				$techids = str_replace('~', '', $row['projtech']);
				$depids = str_replace('~', '', $row['projdept']);
				$cityids = str_replace('~', '', $row['projcity']);
				$yearid =  $row['projyearid'];
				
				$temp['domain_'.$row['projid']] = $this->db->order_by('domainname', 'ASC')->where('domainid IN('.$domainids.')')->get('tbl_domain')->result();
			    $temp['tech_'.$row['projid']] = $this->db->order_by('techname', 'ASC')->where('techid IN('.$techids.')')->get('tbl_technology')->result();
				$temp['dept_'.$row['projid']] = $this->db->order_by('depname', 'ASC')->where('depid IN('.$depids.')')->get('tbl_department')->result();
				
				if($cityids != '')
				{
					
				$temp['city_'.$row['projid']] = $this->db->order_by('cityname', 'ASC')->where('cityid IN('.$cityids.')')->get('tbl_city')->result();
				}
				if(isset($yearid))
				{
				$temp['year_'.$row['projid']] = $this->db->order_by('yearname', 'ASC')->where('yearid = '.$yearid.'')->get('tbl_year')->result();
				}
					
				
			}
			
			}
			$data['project_details'] = $temp;
			
			$data['search_results'] =$result;
		
			//print_r($result);
           // return $result;
		   return $data;
		// return $result;

   
	}
	
	function getcityid($cityname=0)
	{
		$view = $this->db->select('cityid')->where('cityname',$cityname)->get('tbl_city');
		//$id=$view->cityid;		
		return $view->row()->cityid;
		//die;
	}
	
}