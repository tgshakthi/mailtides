<?php
/**
 * Blog Models
 *
 * @category Model
 * @package  Blog
 * @author   Athi
 * Created at:  20-Jul-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Blog_model extends CI_Model
{
	/**
	 * Get Blog 
	 * return output as stdClass Object array
	 */
	function get_blog_setting($website_id, $code)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code
		));
		$query = $this->db->get('setting');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
	
	// Unselected Blogs
	function get_blog_unselected($website_id, $blog_id = "")
	{
		$query = $this->db->query('
			SELECT 
				a.id, (SELECT name FROM '.$this->db->dbprefix("blog_category").' WHERE id = a.category_id) as name, a.title 
			FROM 
				'.$this->db->dbprefix('blog').' a
			WHERE 
				a.website_id = '.$website_id.' 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			AND
				!FIND_IN_SET(a.id, "'.$blog_id.'")'
			);
		
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
	
	// Selected Blogs
	function get_blog_selected($website_id, $blog_id)
	{
		$blogs_id = count(explode(',', $blog_id));
  		$query = $this->db->query("
			SELECT
				a.id,
            	(SELECT name FROM ".$this->db->dbprefix("blog_category")." WHERE id = a.category_id) as name,
				a.title
		  	FROM
				".$this->db->dbprefix("numbers")." c
            INNER JOIN 
				".$this->db->dbprefix("blog")." a 
			ON 
				SUBSTRING_INDEX(SUBSTRING_INDEX('".$blog_id."', ',', c.n), ',', -1) = a.id 
           	WHERE 
				a.website_id = ".$website_id." 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			LIMIT 
				".$blogs_id
			);
  
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * insert and update Footer Contact
	 * return output as stdClass Object array
	 */
	function insert_update_footer_blog($website_id, $id = NULL)
	{
		$data_array = $this->input->post('output_update');
		$result = json_decode($data_array);

		$status = $this->input->post('status');
		
		$key = array(
			'blog_id',
			'status'
		);
		
		$value[] = (!empty($result)) ? implode(',', array_column($result, 'id')): '';
		$value[] = (isset($status)) ? '1' : '0';
		
		// Convert to JSON data

		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_id'	=> $website_id,
				'code'	=> 'footer_blog',
				'key'	=> $keyJSON,
				'value'	=> $valueJSON
			);

			// Insert into Footer Blog

			$this->db->insert('setting', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'key'	=> $keyJSON,
				'value'	=> $valueJSON
			);

			// Update into Footer Blog

			$this->db->where(array('website_id' => $website_id, 'code' => 'footer_blog'));
			return $this->db->update('setting', $update_data);
		endif;
	}
}
