<?php
Class Page_model extends CI_Model
{

	/********************************************************************
	Page functions
	********************************************************************/
	function get_pages($parent = 0)
	{
		$this->db->order_by('sequence', 'ASC');
		$this->db->where('parent_id', $parent);
		$result = $this->db->get('pages')->result();
		
		$return	= array();
		foreach($result as $page)
		{
			$return[$page->id]				= $page;
			$return[$page->id]->children	= $this->get_pages($page->id);
		}
		return $return;
	}
	
	function get_page($id)
	{
		$this->db->where('id', $id);
		$result = $this->db->get('pages')->row();
		return $result;
	}
	
	function get_allpages($limit=0, $offset=0)
	{
		
		if($limit>0)
		{
			$this->db->limit($limit, $offset);
		}

		$result	= $this->db->get('pages');
		
		return $result->result();
	}
	function count_pages()
	{
		return $this->db->count_all_results('pages');
	}
	
	function get_slug($id)
	{
		$page = $this->get_page($id);
		if($page) 
		{
			return $page->slug;
		}
	}
	
	function save($data)
	{
		if($data['id'])
		{
			$this->db->where('id', $data['id']);
			$this->db->update('pages', $data);
			return $data['id'];
		}
		else
		{
			$this->db->insert('pages', $data);
			return $this->db->insert_id();
		}
	}
	
	function savefeedback($data)
	{
		if($data['id'])
		{
			$this->db->where('id', $data['id']);
			$this->db->update('pages', $data);
			return $data['id'];
		}
		else
		{
			$this->db->insert('tbl_feedback', $data);
			return $this->db->insert_id();
		}
	}
	
	function delete_page($id)
	{
		//delete the page
		$this->db->where('id', $id);
		$this->db->delete('pages');
	
	}
	
	function get_page_by_slug($slug)
	{
		$this->db->where('slug', $slug);
		$result = $this->db->get('pages')->row();
		
		return $result;
	}
}