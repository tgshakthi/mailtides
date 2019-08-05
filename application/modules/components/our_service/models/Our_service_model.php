<?php
/**
 * Our Service Model
 * Created at : 29-Oct-2018
 * Author : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Our_service_model extends CI_Model
{
	private $table_name = 'our_service';

	/* Get Our Service Data */
	function get_our_service($page_id)
	{
		$this->db->select('*');
		$this->db->where(array('page_id' => $page_id, 'status' => '1', 'is_deleted' => '0'));
		$this->db->order_by('sort_order', 'ASC');
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):			
			$records = $query->result();			
		endif;
		return $records;
	}
}

?>