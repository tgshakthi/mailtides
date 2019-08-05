<?php
/**
 * Text Icon Models
 *
 * @category Model
 * @package  Text Icon
 * @author   Saravana
 * Created at:  25-Jun-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Text_icon_model extends CI_Model
{
	private $table_name = 'text_icon';
	/**
	 * Get Text Icon
	 * return output as stdClass Object array
	 */
	function get_text_icon($page_id)
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
			$records[] = $query->result();
		endif;
		return $records;
	}
}