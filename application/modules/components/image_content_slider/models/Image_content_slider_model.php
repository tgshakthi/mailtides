<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Image_content_slider_model extends CI_Model
	{
		private $table_name = 'image_content_slider';

		/**
		 * Get image content slider
		 * return stdObject data
		 */

		function get_image_slider_content($page_id)
		{
			$this->db->select("content");
			$this->db->where(array(
				'page_id' => $page_id,
				'is_deleted' => '0'
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
