<?php
/**
 * Introduction Model
 * Created at : 21-May-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Introduction_model extends CI_Model
{
	private $table_name = 'introduction';
	/* Get Introduction Data */
  	function get_introduction($page_id)
  	{
		$this->db->select('*');
		$this->db->where('page_id', $page_id);
		$query   = $this->db->get($this->table_name);
    	$records = array();
		if ($query->num_rows() > 0) :			
			$records = $query->result();			
		endif;
    	return $records;
  	}
}
?>