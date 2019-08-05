<?php
/**
 * Conclusion Model
 * Created at : 21-May-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Conclusion_model extends CI_Model
{
	function __construct()
  	{
    	parent::__construct();
  	}
	
	/* Get Conclusion Data */
  	function get_conclusion($page_id)
  	{
		$this->db->select('*');
		$this->db->where('page_id', $page_id);
		$query   = $this->db->get('conclusion');
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
