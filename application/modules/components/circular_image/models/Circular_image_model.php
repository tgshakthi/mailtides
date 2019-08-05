<?php
/**
 * Circular Image Models
 *
 * @category Model
 * @package  Circular Image
 * @author   Saravana
 * Created at:  28-Jun-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Circular_image_model extends CI_Model
{
	private $table_name = 'circular_image';

	/**
	 * Get Circular Image
	 * return output as stdClass Object array
	 */
	function get_circular_image($page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'page_id' => $page_id,
			'status' => 1,
			'is_deleted' => 0
		));
		$this->db->order_by('sort_order', 'ASC');
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):			
			$records = $query->result();			
		endif;
		return $records;
	}
}