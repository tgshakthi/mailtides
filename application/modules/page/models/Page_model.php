<?php
/**
 * Page Model
 * Created at : 04-June-2018
 * Author : Athi
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model
{
	private $table_page_not_found = 'page_not_found';

	// Get Page Components
	public function get_page_components($page_id)
	{
		$this->db->select('component_name as name');    
    	$this->db->where(array('page_id' => $page_id, 'status' => 1));  
		$this->db->order_by('sort_order', 'ASC');      
    	$query = $this->db->get('page_components');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}

	/**
	 * Get Error Page Path
	 */
	function get_error_page($website_id)
	{
		$url = $_POST['url'];
		$insert_data = array(
			'website_id' => $website_id,
			'url' => $url
		);

		$this->db->insert($this->table_page_not_found, $insert_data);
	}
}
