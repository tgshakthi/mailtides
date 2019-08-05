<?php
/**
 * Event Model
 * Created at : 3-Aug-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Event_model extends CI_Model
{
	function __construct()
  	{
    	parent::__construct();
  	}
	
	/* Get Event Data */
  	function get_event($website_id, $page_id)
  	{
		$query = $this->db->query("
			SELECT
				a.*
		  	FROM
				".$this->db->dbprefix("numbers")." c
			INNER JOIN 
				".$this->db->dbprefix("event_pages")." b
			ON 
				CHAR_LENGTH(b.event_id) - CHAR_LENGTH(REPLACE(b.event_id, ',', '')) >= c.n - 1 
            INNER JOIN 
				".$this->db->dbprefix("event")." a 
			ON 
				SUBSTRING_INDEX(SUBSTRING_INDEX(b.event_id, ',', c.n), ',', -1) = a.id 
           	WHERE 
				a.website_id = ".$website_id." 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			AND 
				b.website_id = ".$website_id." 
			AND 
				b.page_id = ".$page_id."
		");
  
		$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get All Event Data */
  	function get_all_event($website_id)
  	{
		$this->db->select(array('*', '(SELECT name FROM '.$this->db->dbprefix('event_category').' WHERE id = '.$this->db->dbprefix('event').'.category_id) as name'));    
    	$this->db->where(array('website_id' => $website_id, 'status' => 1, 'is_deleted' => 0));  
		$this->db->order_by('sort_order', 'ASC');      
    	$query = $this->db->get('event');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Event Category Data */
  	function get_event_category($website_id, $page_id)
  	{
		$query = $this->db->query("
			SELECT
				a.id,
				a.name
		  	FROM
				".$this->db->dbprefix("numbers")." c
			INNER JOIN 
				".$this->db->dbprefix("event_pages")." b
			ON 
				CHAR_LENGTH(b.event_category) - CHAR_LENGTH(REPLACE(b.event_category, ',', '')) >= c.n - 1 
            INNER JOIN 
				".$this->db->dbprefix("event_category")." a 
			ON 
				SUBSTRING_INDEX(SUBSTRING_INDEX(b.event_category, ',', c.n), ',', -1) = a.id 
           	WHERE 
				a.website_id = ".$website_id." 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			AND 
				b.website_id = ".$website_id." 
			AND 
				b.page_id = ".$page_id."
		");
  
		$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Event By Category id Data */
  	function get_event_by_category_id($website_id, $category_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id, 'category_id' => $category_id,'status' => 1, 'is_deleted' => 0));  
		$this->db->order_by('sort_order', 'ASC');      
    	$query = $this->db->get('event');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Event Page Data */
  	function get_event_page($website_id, $page_id)
  	{
		$this->db->select('*');    
    	$this->db->where(array('page_id' => $page_id, 'website_id' => $website_id,'status' => 1));  
    	$query = $this->db->get('event_pages');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/* Get Event Data Using URL @param */
  	function get_event_by_url($website_id, $event_url)
  	{
		$this->db->select(array('*', '(SELECT name FROM '.$this->db->dbprefix('event_category').' WHERE id = '.$this->db->dbprefix('event').'.category_id) as name'));    
    	$this->db->where(array('website_id' => $website_id,'event_url' => $event_url,'status' => 1, 'is_deleted' => 0));  
		$this->db->order_by('sort_order', 'ASC');      
    	$query = $this->db->get('event');
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
