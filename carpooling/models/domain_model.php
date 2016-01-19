<?php
class Domain_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
	}
	
	function get_domains()
	{
		
		/*if ($parent !== false)
		{
			$this->db->where('parent_id', $parent);
		}*/
		//$this->db->select('domainid');
		//$this->db->order_by('tbl_domain.domainid', 'ASC');
		
		//this will alphabetize them if there is no sequence
		$this->db->order_by('domainid', 'ASC');
		$result	= $this->db->get('tbl_domain');
		
		$domains	= $result->result();
		/*foreach($result->result() as $cat)
		{
			$domains[]	= $this->get_domain($cat->domainid);
			
		}*/
		
		return $domains;
	}
	
		
		
		//this is for building a menu
	function get_domains_tierd()
	{
		$domains	= array();
		$result	= $this->get_domains();
		
		foreach ($result as $domain)
		{
			$domains[$domain->domainid]['domain']	= $domain;
			//$domains[$domain->domainid]['children']	= $this->get_domains_tierd($domain->domainid);
			
		}
		print_r($domains);
			die;
		return $domains;
	}
	
	function get_domain($id)
	{
		return $this->db->get_where('tbl_domain', array('domainid'=>$id))->row();
	}
	
	function domain_autocomplete($name, $limit)
	{
		return $this->db->like('domainname', $name)->get('tbl_domain', $limit)->result();
		//echo $this->db->last_query();
	}
	
	
	
	function insertdomain($pmData)
	{
		if(!$pmData['cate_id']) 
		{
			$this->db->insert('job_domain', $pmData);
			return $this->db->insert_id();
		} 
		else 
		{
			$this->db->where('cate_id', $pmData['cate_id']);
			$this->db->update('job_domain', $pmData);
			return $pmData['cate_id'];
		}
	}
	
	
	function get_domain_menu()
	{	
		$domains	= $this->db->order_by('cate_name', 'ASC')->where('cate_status', 1)->get('job_domain')->result();
		$return		= array();
		$i = 0;
		foreach($domains as $c)
		{
			
			$domainscnt	= $this->db->select('count(jobs_id) as jobcnt')->where('jobs_domain like "%~'.$c->cate_id.'~%"')->get('job_jobs_list');
		   
if ($domainscnt->num_rows() > 0 )
    {
	$row = $domainscnt->row_array();
	        $return[$i]['cate_id'] = $c->cate_id;
		    $return[$i]['cate_name'] = $c->cate_name;
		    $return[$i]['cate_count'] = $row['jobcnt'];			
			$i++;
		}
		}
		
		return $return;
	}
	function deletedomain($id)
	{
				
		$this->db->where('cate_id', $id);
		$this->db->delete('job_domain');
	}
	
	function save($domain)
	{
		if ($domain['domainid'])
		{
			$this->db->where('domainid', $domain['domainid']);
			$this->db->update('tbl_domain', $domain);
			
			return $domain['domainid'];
		}
		else
		{
			$domain['dtcreated'] = date('Y-m-d H:i:s',now());
			$this->db->insert('tbl_domain', $domain);
			
			return $this->db->insert_id();
		}
		
		
	}
	
	function delete($id)
	{
		$this->db->where('domainid', $id);
		$this->db->delete('tbl_domain');
		
		//delete references to this domain in the product to domain table
		//$this->db->where('domain_id', $id);
//		$this->db->delete('domain_products');
	}
}	