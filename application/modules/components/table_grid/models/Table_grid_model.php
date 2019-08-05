<?php
/**
 * Table Grid Models
 *
 * @category Model
 * @package  Table Grid
 * @author   Saravana
 * Created at:  30-Aug-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Table_grid_model extends CI_Model
{
	private $table_name = 'table_grid';
	private $setting_table	= 'setting';

	/**
	 * Get Table Grid
	 * return output as stdClass Object array
	 */
	function get_table_grid($page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'page_id' => $page_id,
			'status' => 1
		));
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
