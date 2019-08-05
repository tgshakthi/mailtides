<?php
/**
 * Text Full Width Model
 * Created at : 21-May-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Text_full_width_model extends CI_Model
{
	function __construct()
  	{
    	parent::__construct();
  	}
	
	/* Get Text Full Width Data */
  	function get_text_full_width($page_id)
  	{
		$this->db->select('*');
		$this->db->where('page_id', $page_id);
		$query   = $this->db->get('text_full_width');
    	$records = array();
		if ($query->num_rows() > 0) :
			$records = $query->result();
		endif;
    	return $records;
  	}
}
?>
