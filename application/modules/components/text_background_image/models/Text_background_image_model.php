<?php
/**
 * Text Background Image Model
 * Created at : 30-mar-2019
 * Author : Velu Samy
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Text_background_image_model extends CI_Model
{
	function __construct()
  	{
    	parent::__construct();
  	}
	
	/* Get Text Image Data */
  	function get_text_background_image($page_id)
  	{
		$this->db->select('*');
		$this->db->where(array('page_id' => $page_id, 'status' => 1, 'is_deleted' => 0));
		$this->db->order_by('sort_order', 'ASC');
		$query   = $this->db->get('text_background_image');
    	$records = array();

		if ($query->num_rows() > 0) :
			$records = $query->result();
		endif;

    	return $records;
  	}
}
?>
