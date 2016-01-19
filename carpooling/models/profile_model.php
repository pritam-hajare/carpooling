<?php
Class Profile_model extends CI_Model
{
		
	// we will store the group discount formula here
	// and apply it to product prices as they are fetched 
	
	
	function __construct()
	{
		parent::__construct();
		
		
	}
	
	
	
	
	

	


	function get_profile($id)
	{
		$result	= $this->db->get_where('tbl_provider', array('prodid'=>$prodid));
		return $result->row();
	}

	

	
	function save($product, $options=false, $categories=false)
	{
		if ($product['id'])
		{
			$this->db->where('id', $product['id']);
			$this->db->update('products', $product);

			$id	= $product['id'];
		}
		else
		{
			$this->db->insert('products', $product);
			$id	= $this->db->insert_id();
		}

		//loop through the product options and add them to the db
		if($options !== false)
		{
			$obj =& get_instance();
			$obj->load->model('Option_model');

			// wipe the slate
			$obj->Option_model->clear_options($id);

			// save edited values
			$count = 1;
			foreach ($options as $option)
			{
				$values = $option['values'];
				unset($option['values']);
				$option['product_id'] = $id;
				$option['sequence'] = $count;

				$obj->Option_model->save_option($option, $values);
				$count++;
			}
		}
		
		if($categories !== false)
		{
			if($product['id'])
			{
				//get all the categories that the product is in
				$cats	= $this->get_product_categories($id);
				
				//generate cat_id array
				$ids	= array();
				foreach($cats as $c)
				{
					$ids[]	= $c->id;
				}

				//eliminate categories that products are no longer in
				foreach($ids as $c)
				{
					if(!in_array($c, $categories))
					{
						$this->db->delete('category_products', array('product_id'=>$id,'category_id'=>$c));
					}
				}
				
				//add products to new categories
				foreach($categories as $c)
				{
					if(!in_array($c, $ids))
					{
						$this->db->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
					}
				}
			}
			else
			{
				//new product add them all
				foreach($categories as $c)
				{
					$this->db->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
				}
			}
		}
		
		//return the product id
		return $id;
	}
	
	function delete_product($id)
	{
		// delete product 
		$this->db->where('id', $id);
		$this->db->delete('products');

		//delete references in the product to category table
		$this->db->where('product_id', $id);
		$this->db->delete('category_products');
		
		// delete coupon reference
		$this->db->where('product_id', $id);
		$this->db->delete('coupons_products');

	}

	

	
}