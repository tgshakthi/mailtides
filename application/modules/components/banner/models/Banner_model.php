<?php
/**
 * Banner Model
 * Created at : 07-June-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner_model extends CI_Model
{
	function __construct()
  	{
    	parent::__construct();
  	}
	
	/* Get Banner Data */
  	function get_banner($page_id)
  	{
		$this->db->select('*');
		$this->db->where(array('page_id' => $page_id, 'status' => 1, 'is_deleted' => 0));
		$this->db->order_by('sort_order', 'ASC');
		$query   = $this->db->get('banner');
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
