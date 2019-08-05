<?php
/**
 * Image Card Models
 *
 * @category Model
 * @package  Image Card
 * @author   Saravana
 * Created at:  28-Jun-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Image_card_model extends CI_Model
{
	private $table_name = 'image_card';
	private $setting_table	= 'setting';

	/**
	 * Get Image Card
	 * return output as stdClass Object array
	 */
	function get_image_card($page_id)
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
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
}
