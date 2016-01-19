<?php
class Technology_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
	}
	
	function get_technologies($parent = false)
	{
		
		if ($parent !== false)
		{
			$this->db->where('parent_id', $parent);
		}
		$this->db->select('techid');
		$this->db->order_by('tbl_technology.sequence', 'ASC');
		
		//this will alphabetize them if there is no sequence
		$this->db->order_by('techname', 'ASC');
		$result	= $this->db->get('tbl_technology');
		
		$technologies	= array();
		foreach($result->result() as $cat)
		{
			$technologies[]	= $this->get_technology($cat->techid);
		}
		
		return $technologies;
	}
	
		
		
		//this is for building a menu
	function get_technologies_tierd($parent=0)
	{
		$technologies	= array();
		$result	= $this->get_technologies($parent);
		foreach ($result as $technology)
		{
			$technologies[$technology->techid]['technology']	= $technology;
			$technologies[$technology->techid]['children']	= $this->get_technologies_tierd($technology->techid);
		}
		return $technologies;
	}
	
	function get_technology($id)
	{
		return $this->db->get_where('tbl_technology', array('techid'=>$id))->row();
	}
	
	function technology_autocomplete($name, $limit)
	{
		return $this->db->like('techname', $name)->get('tbl_technology', $limit)->result();
		//echo $this->db->last_query();
	}
	
	
	
	function inserttechnology($pmData)
	{
		if(!$pmData['cate_id']) 
		{
			$this->db->insert('job_technology', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('cate_id', $pmData['cate_id']);
			$this->db->update('job_technology', $pmData);
			return $pmData['cate_id'];
		}
	}
	
	
	function get_technology_menu()
	{	
		$technologies	= $this->db->order_by('cate_name', 'ASC')->where('cate_status', 1)->get('job_technology')->result();
		$return		= array();
		$i = 0;
		foreach($technologies as $c)
		{
			
			$technologiescnt	= $this->db->select('count(jobs_id) as jobcnt')->where('jobs_technology like "%~'.$c->cate_id.'~%"')->get('job_jobs_list');
		   
if ($technologiescnt->num_rows() > 0 )
    {
	$row = $technologiescnt->row_array();
	        $return[$i]['cate_id'] = $c->cate_id;
		    $return[$i]['cate_name'] = $c->cate_name;
		    $return[$i]['cate_count'] = $row['jobcnt'];			
			$i++;
		}
		}
		
		return $return;
	}
	function deletetechnology($id)
	{
				
		$this->db->where('cate_id', $id);
		$this->db->delete('job_technology');
	}
	
	function save($technology)
	{
		if ($technology['techid'])
		{
			$this->db->where('techid', $technology['techid']);
			$this->db->update('tbl_technology', $technology);
			
			return $technology['techid'];
		}
		else
		{
			$technology['techcreated']	= date('Y-m-d H:i:s',now());
			$this->db->insert('tbl_technology', $technology);
			
			return $this->db->insert_id();
		}
		
		
	}
	
	function delete($id)
	{
		$this->db->where('techid', $id);
		$this->db->delete('tbl_technology');
		
		//delete references to this technology in the product to technology table
		/*$this->db->where('technology_id', $id);
		$this->db->delete('technology_products');*/
	}
}	