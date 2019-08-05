<?php
/**
 * Event Calendar
 * Created at : 03-Oct-2018
 * Author : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Event_calendar_model extends CI_Model
{
	private $table_name = "event_calendar";

	/* Get Event Calendar Data */
	function get_event_calender($page_id)
	{
		$this->db->select('*');
		$this->db->where(array('page_id' => $page_id, 'status' => 1, 'is_deleted' => 0));
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			//foreach($query->result() as $row):
				$records = $query->result();
			//endforeach;
		endif;
		return $records;
	}
}

?>
