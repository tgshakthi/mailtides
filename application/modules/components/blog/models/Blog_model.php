<?php
/**
 * Blog Model
 * Created at : 23-July-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends CI_Model
{
	function __construct()
  	{
    	parent::__construct();
  	}
	
	/* Get Blog Data */
  	function get_blog($website_id, $page_id)
  	{
		$query = $this->db->query("
			SELECT
				a.*
		  	FROM
				".$this->db->dbprefix("numbers")." c
			INNER JOIN 
				".$this->db->dbprefix("blog_pages")." b
			ON 
				CHAR_LENGTH(b.blog_id) - CHAR_LENGTH(REPLACE(b.blog_id, ',', '')) >= c.n - 1 
            INNER JOIN 
				".$this->db->dbprefix("blog")." a 
			ON 
				SUBSTRING_INDEX(SUBSTRING_INDEX(b.blog_id, ',', c.n), ',', -1) = a.id 
           	WHERE 
				a.website_id = ".$website_id." 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			AND 
				b.website_id = ".$website_id." 
			AND 
				b.page_id = ".$page_id."
		");
  
		$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get All Blog Data */
  	function get_all_blog($website_id)
  	{
		$this->db->select(array('*', '(SELECT name FROM '.$this->db->dbprefix('blog_category').' WHERE id = '.$this->db->dbprefix('blog').'.category_id) as name'));    
    	$this->db->where(array('website_id' => $website_id, 'status' => 1, 'is_deleted' => 0));  
		$this->db->order_by('sort_order', 'ASC');      
    	$query = $this->db->get('blog');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Blog Category Data */
  	function get_blog_category($website_id, $page_id)
  	{
		$query = $this->db->query("
			SELECT
				a.id,
				a.name
		  	FROM
				".$this->db->dbprefix("numbers")." c
			INNER JOIN 
				".$this->db->dbprefix("blog_pages")." b
			ON 
				CHAR_LENGTH(b.blog_category) - CHAR_LENGTH(REPLACE(b.blog_category, ',', '')) >= c.n - 1 
            INNER JOIN 
				".$this->db->dbprefix("blog_category")." a 
			ON 
				SUBSTRING_INDEX(SUBSTRING_INDEX(b.blog_category, ',', c.n), ',', -1) = a.id 
           	WHERE 
				a.website_id = ".$website_id." 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			AND 
				b.website_id = ".$website_id." 
			AND 
				b.page_id = ".$page_id."
		");
  
		$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Blog By Category id Data */
  	function get_blog_by_category_id($website_id, $category_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id, 'category_id' => $category_id,'status' => 1, 'is_deleted' => 0));  
		$this->db->order_by('sort_order', 'ASC');      
    	$query = $this->db->get('blog');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Blog Page Data */
  	function get_blog_page($website_id, $page_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('page_id' => $page_id, 'website_id' => $website_id,'status' => 1));  
    	$query = $this->db->get('blog_pages');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Blog Data Using URL @param */
  	function get_blog_by_url($website_id, $blog_url)
  	{
		$this->db->select(array('*', '(SELECT name FROM '.$this->db->dbprefix('blog_category').' WHERE id = '.$this->db->dbprefix('blog').'.category_id) as name'));    
    	$this->db->where(array('website_id' => $website_id,'blog_url' => $blog_url,'status' => 1, 'is_deleted' => 0));  
		$this->db->order_by('sort_order', 'ASC');      
    	$query = $this->db->get('blog');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Blog Rating Data */
  	function get_blog_rating($website_id, $blog_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id, 'blog_id' => $blog_id, 'parent_id' => 0, 'status' => 1, 'is_deleted' => 0));  
		$this->db->order_by('sort_order', 'ASC');      
    	$query = $this->db->get('blog_rating');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Blog Reply Data */
  	function get_blog_reply($website_id, $blog_id, $parent_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id, 'blog_id' => $blog_id, 'parent_id' => $parent_id, 'status' => 1, 'is_deleted' => 0));  
		$this->db->order_by('sort_order', 'DESC');      
    	$query = $this->db->get('blog_rating');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Blog Rating Form Data */
  	function get_blog_rating_form($website_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id, 'status' => 1));  
    	$query = $this->db->get('blog_rating_form');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Insert Blog Rating */
	function insert_blog_rating()
	{
		$insert_data = array(
			'website_id' => $this->input->post('website_id'),
			'blog_id' => $this->input->post('blog_id'),
			'parent_id' => $this->input->post('parent_id'),
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'rating' => $this->input->post('rating'),
			'comment' => $this->input->post('comment'),
			'created_at' => date('m-d-Y')
		);

		// Insert into Blog Rating

		$this->db->insert('blog_rating', $insert_data);
	}
	
	// Get Mail Configure
	function get_mail_configure($website_id)
	{
		$this->db->select('*');    
    	$this->db->where('website_id' , $website_id);        
    	$query = $this->db->get('rating_mail_configure');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}
}
?>
