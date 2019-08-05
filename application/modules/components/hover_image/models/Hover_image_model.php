<?php
/**
 * Hover Image Model
 * Created at : 05-Apr-2019
 * Author : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hover_image_model extends CI_Model
{
	private $table_name = 'hover_image';
	/* Get Introduction Data */
  	function get_hover_image($page_id)
  	{
		$this->db->select('*');
		$this->db->where(array(
			'page_id' => $page_id,
			'status' => '1',
			'is_deleted' => '0'
		));
		$query   = $this->db->get($this->table_name);
    	$records = array();
		if ($query->num_rows() > 0) :			
			$records = $query->result();			
		endif;
    	return $records;
  	}
}
?>