<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sitemap_model extends CI_Model

{
	private $table_name = 'pages';

	function page_details($website_id)
	{
		$this->db->select(array(
			'url',
			'updated_at'
		));
		$this->db->where(array(
			'website_id' => $website_id,
			'status' => '1'
		));
		$query = $this->db->get($this->table_name);
		$records = array();

		if($query->num_rows() > 0) :
			$records = $query->result();
		endif;

		return $records;
	}


}

?>
