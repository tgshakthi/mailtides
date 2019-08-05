<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Counter_model extends CI_Model
{
	private $table_name	= 'counter';
	private $setting_table	= 'setting';	
	function __construct()
  	{
    	parent::__construct();
  	}	
  	function get_counter($page_id)
  	{
		$this->db->select('*');
		$this->db->where(array('page_id' => $page_id, 'status' => 1, 'is_deleted' => 0));
		$query   = $this->db->get($this->table_name);
    	$records = array();
		if ($query->num_rows() > 0) :		
			$records = $query->result();			
		endif;
    	return $records;
  	}
}
?>
