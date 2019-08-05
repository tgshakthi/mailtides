<?php
/**
 * H1and H2 Model
 * Created at : 30-Nov-2018
 * Author : Karthika
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class H1andh2_model extends CI_Model
{
	private $table_name = 'h1_and_h2';
	private $setting_table = 'setting';

	function __construct()
  	{
    	parent::__construct();
  	}
	
	/* Get H! and H2 customization  Data */
	function get_h1_and_h2_customization($website_id, $page_id, $code)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));
		$query = $this->db->get($this->setting_table);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
	function get_h1andh2($page_id)
	{
		$this->db->select('*');
		$this->db->where('page_id', $page_id);
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
?>
