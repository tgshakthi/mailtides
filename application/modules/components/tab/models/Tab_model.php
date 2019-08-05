<?php
/**
 * Tab Model
 * Created at : 10-Aug-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tab_model extends CI_Model
{
	function __construct()
  	{
    	parent::__construct();
  	}
	
	/* Get Tab Data */
  	function get_tab($website_id, $page_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id, 'page_id' => $page_id,'status' => 1, 'is_deleted' => 0));  
		$this->db->order_by('sort_order', 'ASC');      
    	$query = $this->db->get('tab');
  
		$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Setting Data */
  	function get_setting($website_id, $page_id, $code)
  	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id, 'page_id' => $page_id, 'code' => $code));  
    	$query = $this->db->get('setting');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get All Text Full Width by Tab ID */
  	function get_tab_text_full_width($tab_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('tab_id' => $tab_id));  
    	$query = $this->db->get('tab_text_full_width');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get All Text Image by Tab ID */
  	function get_tab_text_image($tab_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('tab_id' => $tab_id, 'status' => 1, 'is_deleted' => 0));  
    	$query = $this->db->get('tab_text_image');
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
