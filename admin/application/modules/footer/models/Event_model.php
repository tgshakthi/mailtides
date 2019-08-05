<?php
/**
 * Event Models
 *
 * @category Model
 * @package  Event
 * @author   Athi
 * Created at:  18-Aug-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Event_model extends CI_Model
{
	/**
	 * Get Event 
	 * return output as stdClass Object array
	 */
	function get_event_setting($website_id, $code)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code
		));
		$query = $this->db->get('setting');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
	
	// Unselected Events
	function get_event_unselected($website_id, $event_id = "")
	{
		$event_qry = "
			SELECT 
				a.id, a.title 
			FROM 
				".$this->db->dbprefix('event')." a
			WHERE 
				a.website_id = ".$website_id." 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			AND
				!FIND_IN_SET(a.id, '".$event_id."')";
				
		$query = $this->db->query($event_qry);
		
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
	
	// Selected Events
	function get_event_selected($website_id, $event_id)
	{
		$events_id = count(explode(',', $event_id));
  		$query = $this->db->query("
			SELECT
				a.id,
				a.title
		  	FROM
				".$this->db->dbprefix("numbers")." c
            INNER JOIN 
				".$this->db->dbprefix("event")." a 
			ON 
				SUBSTRING_INDEX(SUBSTRING_INDEX('".$event_id."', ',', c.n), ',', -1) = a.id 
           	WHERE 
				a.website_id = ".$website_id." 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			LIMIT 
				".$events_id
			);
  
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * insert and update Footer Contact
	 * return output as stdClass Object array
	 */
	function insert_update_footer_event($website_id, $id = NULL)
	{
		$data_array = $this->input->post('output_update');
		$result = json_decode($data_array);

		$status = $this->input->post('status');
		
		$key = array(
			'event_id',
			'status'
		);
		
		$value[] = (!empty($result)) ? implode(',', array_column($result, 'id')): '';
		$value[] = (isset($status)) ? '1' : '0';
		
		// Convert to JSON data

		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_id'	=> $website_id,
				'code'	=> 'footer_event',
				'key'	=> $keyJSON,
				'value'	=> $valueJSON
			);

			// Insert into Footer Blog

			$this->db->insert('setting', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'key'	=> $keyJSON,
				'value'	=> $valueJSON
			);

			// Update into Footer Blog

			$this->db->where(array('website_id' => $website_id, 'code' => 'footer_event'));
			return $this->db->update('setting', $update_data);
		endif;
	}
}
