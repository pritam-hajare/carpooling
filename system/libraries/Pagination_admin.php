<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html 
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		Rick Ellis
 * @link		http://www.codeigniter.com/user_guide/libraries/pagination.html
 */
class CI_Pagination_admin {

	var $base_url			= ''; // The page we are linking to
	var $total_rows  		= ''; // Total number of items (database results)
	var $per_page     		= 10; // Max number of items you want shown per page
	var $num_links    		=  3; // Number of "digit" links to show before/after the currently viewed page
	var $cur_page     		=  0; // The current page being viewed
	var $first_link   		= '<i class="fa fa-chevron-left"></i>';
	var $next_link			= '<i class="fa fa-chevron-right"></i>';
	var $prev_link			= '<i class="fa fa-chevron-left"></i>';
	var $last_link    		= '<i class="fa fa-chevron-right"></i>';
	var $uri_segment		= 3;
	var $full_tag_open		= '<ul class="pagination pull-right"> ';
	var $full_tag_close		= '</ul>';
	var $first_tag_open		= '<li>';
	var $first_tag_close	= '</li>';
	var $last_tag_open		= '<li>';
	var $last_tag_close		= '</li>';
	var $cur_tag_open		= '<li class="active"><a>';
	var $cur_tag_close		= '</a></li>';
	var $next_tag_open		= '<li>';
	var $next_tag_close		= '</li>';
	var $prev_tag_open		= '<li>';
	var $prev_tag_close		= '</li>';
	var $num_tag_open		= '<li>';
	var $num_tag_close		= '</li>';
	var $is_ajax_paging     = FALSE;
	var $query_string_segment = 'per_page'; 
    var $paging_function    = '';
	var $action_id          = '';
	 var $show_count      = FALSE;
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
    function CI_Pagination($params = array())
    {    
		if (count($params) > 0)
		{
			$this->initialize($params);		
		}
		
		log_message('debug', "Pagination Class Initialized");
    }
	
	// --------------------------------------------------------------------
	
	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
    function initialize($params = array())
    {    
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}		
		}
    }
	
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */	
    function create_links()
    {  
	
	
		// If our item count or per-page total is zero there is no need to continue.
        if ($this->total_rows == 0 OR $this->per_page == 0)
        {
           return '';
    	}
    	
		// Calculate the total number of pages
        $num_pages = intval($this->total_rows / $this->per_page);
        
		// Use modulus to see if our division has a remainder.If so, add one to our page number.
        if ($this->total_rows % $this->per_page) 
        {
            $num_pages++;
        }
 
		// Is there only one page? Hm... nothing more to do here then. 
        if ($num_pages == 1)
        {
            return '';
        }
        if($this->is_ajax_paging == TRUE)
        {
		
		//echo $paging_function ;
	  
          $paging_function = 'onclick="javascript:'.$this->paging_function.'();return false;" ';
			//$paging_function = 'onclick="javascript:'.$paging_function.'();return false;"';
        }
        else{
            $paging_function = '';
        }  
		// Determine the current page number.		
		
		$obj =& get_instance();	
		if ($obj->uri->segment($this->uri_segment) != 0)
		{
			$this->cur_page = $obj->uri->segment($this->uri_segment);
		}
		
		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}
		
		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);
   
		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
        $start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
        $end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;
        
		// Add a trailing slash to the base URL if needed
		$this->base_url = preg_replace("/(.+?)\/*$/", "\\1/",  $this->base_url);
		
  		// And here we go...
        $output = '';
		
			// SHOWING LINKS
      if ($this->show_count)
      {
         $curr_offset = $obj->uri->segment($this->uri_segment);
         $info = '<div class="results"><span>' . ( $curr_offset + 1 ) . ' - ' ;

         if( ( $curr_offset + $this->per_page ) < ( $this->total_rows -1 ) )
            $info .= $curr_offset + $this->per_page;
         else
            $info .= $this->total_rows;

         $info .= ' of ' . $this->total_rows . ' Listings </span></div>';

         $output .= $info;
      }
	
 
		// Render the "First" link
        if  ($this->cur_page > $this->num_links)
        {
          //  $output .= $this->first_tag_open.'<a  onclick="'.$this->paging_function.'(0);" href="Javascript:void(0);">'.$this->first_link.'</a>'.$this->first_tag_close;
			
			 $output .= $this->first_tag_open.'<a  onclick="'.$this->paging_function.'(0);" href="Javascript:void(0);">1</a>'.$this->first_tag_close;
        }
 
		// Render the "previous" link
        if  (($this->cur_page - $this->num_links) >= 0)
        {
        	$i = $uri_page_number - $this->per_page;  
        	if ($i == 0) $i = '';
           // $output .= $this->prev_tag_open.'<a '.$paging_function.'href="'.$this->base_url.$i.'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
		   
		    if($this->action_id!=""){
				if($i=="")
					$pg_prev = 0;
				else 
					$pg_prev = $i;
				$output .= $this->prev_tag_open.'<a onclick="'.$this->paging_function.'('.$pg_prev.','.$this->action_id.');" href="Javascript:void(0);" class="prev"><span>'.$this->prev_link.'</span></a>'.$this->prev_tag_close;
			}
			else{
		     	$output .= $this->prev_tag_open.'<a onclick="'.$this->paging_function.'('.$i.');" href="Javascript:void(0);" class="prev"><span>'.$this->prev_link.'</span></a>'.$this->prev_tag_close;
			}
		   
        }
        
		// Write the digit links
        for ($loop = $start -1; $loop <= $end; $loop++) 
        {
			$i = ($loop * $this->per_page) - $this->per_page;
					
			if ($i >= 0)
			{
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
				}
				else
				{
					$n = ($i == 0) ? '' : $i;
				//	$output .= $this->num_tag_open.'<a '.$paging_function.'href="'.$this->base_url.$n.'">'.$loop.'</a>'.$this->num_tag_close;
					
					if($this->action_id!=""){
					if($n=="")
						$pg = 0;
					else 
						$pg = $n;
					$output .= $this->num_tag_open.'<a onclick="'.$this->paging_function.'('.$pg.','.$this->action_id.');" href="Javascript:void(0);"><span>'.$loop.'</span></a>'.$this->num_tag_close;
					}
					else{
					$output .= $this->num_tag_open.'<a onclick="'.$this->paging_function.'('.$n.');" href="Javascript:void(0);"><span>'.$loop.'</span></a>'.$this->num_tag_close;
					}
				}
			}
        } 

		// Render the "next" link
        if ($this->cur_page < $num_pages)
        {  
        //    $output .= $this->next_tag_open.'<a  '.$paging_function.'href="'.$this->base_url.($this->cur_page * $this->per_page).'">'.$this->next_link.'</a>'.$this->next_tag_close;        
     	if($this->action_id!="")
			$output .= $this->next_tag_open.'<a  onclick="'.$this->paging_function.'('.($this->cur_page * $this->per_page).','.$this->action_id.');" href="Javascript:void(0);" class="next"><span>'.$this->next_link.'</span></a>'.$this->next_tag_close;	
		else
    		$output .= $this->next_tag_open.'<a  onclick="'.$this->paging_function.'('.($this->cur_page * $this->per_page).');" href="Javascript:void(0);" class="next"><span>'.$this->next_link.'</span></a>'.$this->next_tag_close;
	    }

		// Render the "Last" link
        if (($this->cur_page + $this->num_links) < $num_pages)
        {
            $i = (($num_pages * $this->per_page) - $this->per_page);
         //   $output .= $this->last_tag_open.'<a '.$paging_function.'href="'.$this->base_url.$i.'">'.$this->last_link.'</a>'.$this->last_tag_close;
			
			//$output .= $this->last_tag_open.'<a onclick="'.$this->paging_function.'('.$i.');" href="Javascript:void(0);">'.$this->last_link.'</a>'.$this->last_tag_close;
			
			$output .= $this->last_tag_open.'<a onclick="'.$this->paging_function.'('.$i.');" href="Javascript:void(0);">'.$num_pages.'</a>'.$this->last_tag_close;
        }
    
	
	
		// Kill double slashes.  Note: Sometimes we can end up with a double slash 
		// in the penultimate link so we'll kill all double shashes.
		//$output = preg_replace("#([^:])//+#", "\\1/", $output);  

		// Add the wrapper HTML if exists
	$output = $this->full_tag_open.$output.$this->full_tag_close;
	
	
		
		return $output;		
    }
}
// END Pagination Class
?>