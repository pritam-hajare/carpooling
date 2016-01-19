<?php
class Department_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
	}
	
	function get_departments($parent = false)
	{
		
		if ($parent !== false)
		{
			$this->db->where('parent_id', $parent);
		}
		$this->db->select('depid');
		$this->db->order_by('tbl_department.sequence', 'ASC');
		
		//this will alphabetize them if there is no sequence
		$this->db->order_by('depname', 'ASC');
		$result	= $this->db->get('tbl_department');
		
		$departments	= array();
		foreach($result->result() as $cat)
		{
			$departments[]	= $this->get_department($cat->depid);
		}
		
		return $departments;
	}
	
		
		
		//this is for building a menu
	function get_departments_tierd($parent=0)
	{
		$departments	= array();
		$result	= $this->get_departments($parent);
		foreach ($result as $department)
		{
			$departments[$department->depid]['department']	= $department;
			$departments[$department->depid]['children']	= $this->get_departments_tierd($department->depid);
		}
		return $departments;
	}
	
	function get_department($id)
	{
		return $this->db->get_where('tbl_department', array('depid'=>$id))->row();
	}
	
	function department_autocomplete($name, $limit)
	{
		return $this->db->like('depname', $name)->get('tbl_department', $limit)->result();
		//echo $this->db->last_query();
	}
	
	
	
	function insertdepartment($pmData)
	{
		if(!$pmData['cate_id']) 
		{
			$this->db->insert('job_department', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('cate_id', $pmData['cate_id']);
			$this->db->update('job_department', $pmData);
			return $pmData['cate_id'];
		}
	}
	
	
	function get_department_menu()
	{	
		$departments	= $this->db->order_by('cate_name', 'ASC')->where('cate_status', 1)->get('job_department')->result();
		$return		= array();
		$i = 0;
		foreach($departments as $c)
		{
			
			$departmentscnt	= $this->db->select('count(jobs_id) as jobcnt')->where('jobs_department like "%~'.$c->cate_id.'~%"')->get('job_jobs_list');
		   
if ($departmentscnt->num_rows() > 0 )
    {
	$row = $departmentscnt->row_array();
	        $return[$i]['cate_id'] = $c->cate_id;
		    $return[$i]['cate_name'] = $c->cate_name;
		    $return[$i]['cate_count'] = $row['jobcnt'];			
			$i++;
		}
		}
		
		return $return;
	}
	function deletedepartment($id)
	{
				
		$this->db->where('cate_id', $id);
		$this->db->delete('job_department');
	}
	
	function save($department)
	{
		if ($department['depid'])
		{
			$this->db->where('depid', $department['depid']);
			$this->db->update('tbl_department', $department);
			
			return $department['depid'];
		}
		else
		{
			$department['dtcreated']		= date('Y-m-d H:i:s',now());
			$this->db->insert('tbl_department', $department);
			
			return $this->db->insert_id();
		}
		
		
	}
	
	function delete($id)
	{
		$this->db->where('depid', $id);
		$this->db->delete('tbl_department');
		
		//delete references to this department in the product to department table
		//$this->db->where('department_id', $id);
//		$this->db->delete('department_products');
	}
}	