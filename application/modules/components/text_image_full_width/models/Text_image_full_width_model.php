<?php
/**
 * Text Image Model
 * Created at : 08-June-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Text_image_full_width_model extends CI_Model
{
	function __construct()
  	{
    	parent::__construct();
  	}
	
	/* Get Text Image Data */
  	function get_text_image_full_width($page_id)
  	{
		$this->db->select('*');
		$this->db->where(array('page_id' => $page_id, 'status' => 1, 'is_deleted' => 0));
		$this->db->order_by('sort_order', 'ASC');
		$query   = $this->db->get('text_image_full_width');
    	$records = array();

		if ($query->num_rows() > 0) :
			$records = $query->result();
		endif;

    	return $records;
  	}
}
?>
