<?php
/**
 * Text Image Model
 * Created at : 08-June-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Text_image_slider_model extends CI_Model
{
	private $table_name = 'text_image_slider';
	private $setting_table	= 'setting';
	/* Get Text Image Data */
  	function get_text_image_slider($page_id)
  	{
		$this->db->select('*');
		$this->db->where(array('page_id' => $page_id, 'status' => 1, 'is_deleted' => 0));
		$this->db->order_by('sort_order', 'ASC');
		$query   = $this->db->get($this->table_name);
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
