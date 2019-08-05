<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Event_calendar_model extends CI_Model
{
	private $table_name = "event_calendar";
	private $setting_table = "setting";

	function get_event_calendar_setting_details($website_id, $page_id, $code)
	{
		$this->db->select('*');

		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));

		$query = $this->db->get($this->setting_table);
		$records = array();

		if ($query->num_rows() > 0) :
					$records = $query->result();
		endif;

		return $records;
	}
	function get_event_calendar($page_id,$web_id)
	{
		$this->db->select(array(
				'id',
				'event_date_time',
				'event_name',
				'event_details',
				'status'
		));
		$this->db->where(array(
			'website_id' => $web_id,
			'is_deleted' => '0'
		));
		$this->db->order_by('id', 'desc');
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
		
				$records =$query->result();
		
		endif;

		return $records;
	}
	function get_event_calendar_by_id($page_id, $id,$web_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'id' => $id,
			'website_id' => $web_id,
			'is_deleted' => '0'
		));
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
		
				$records = $query->result();
			
		endif;
		return $records;
	}
	function insert_update_event_calendar_title_model($page_id, $id = NULL)
	{
		$key = array(
			'event_calendar_title',
			'event_calendar_title_color',
			'event_calendar_title_position',
			'event_calendar_background_color',
			'event_calendar_status'
			);

		$website_id = $this->input->post('website_id');
		$value[] 	= $this->input->post('event_calendar_title');
		$value[] 	= $this->input->post('event_calendar_title_color');
		$value[] 	= $this->input->post('event_calendar_title_position');
		$value[] 	= $this->input->post('event_calendar_background_color');
		$status	 	= $this->input->post('event_calendar_status');
		$value[]	= (isset($status)) ? '1' : '0';

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$event_calendar = $this->get_event_calendar_setting_details($website_id, $page_id, 'event_calendar_title');
		if (empty($event_calendar)):
			// insert data
			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'event_calendar_title',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			$this->db->insert($this->setting_table, $insert_data);
			$this->session->set_flashdata('success', 'Successfully Created');
			return $this->db->insert_id();
		else :
			// Update data
  		$update_data = array(
				'key'   => $keyJSON,
				'value'   => $valueJSON
			);

			$this->db->where(array('website_id' => $website_id, 'code' => 'event_calendar_title', 'page_id' => $page_id));
			$this->session->set_flashdata('success', 'Successfully Updated');
      return $this->db->update($this->setting_table, $update_data);
		endif;
	}
	function insert_update_event_calendar_model($page_id, $id = NULL)
	{
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		if ($id == NULL):
			// insert data
			$insert_data = array(
				'page_id'           => $page_id,
				'website_id' 		=> $this->input->post('website_id'),
				'event_date_time'	=> $this->input->post('date_time') ,
				'event_name' 		=> $this->input->post('event_name') ,
				'event_details'   	=> $this->input->post('event_details'),
				'status'	 		=> $status
			);
			// Insert data
			 return $this->db->insert($this->table_name, $insert_data);
           else:
			// Update data
			$update_data = array(
				'page_id' 	      => $page_id,
				'website_id' 	  => $this->input->post('website_id'),
				'event_date_time' => $this->input->post('date_time') ,
				'event_name' 	  => $this->input->post('event_name') ,
				'event_details'   => $this->input->post('event_details') ,
				'status'	 	  => $status
			);
			// Update
			$this->db->where('id', $id);
			return $this->db->update($this->table_name, $update_data);
		endif;
	}
	function delete_event_calendar_model($page_id)
	{
		$id = $this->input->post('id');
		$data = array(
			'is_deleted' => '1',
			'page_id' => $page_id
		);
		$this->db->where('id', $id);
		return $this->db->update($this->table_name, $data);
	}

	function delete_multiple_event_calendar_model($page_id)
	{
		$id = $this->input->post('table_records');
			foreach($id as $expend_id):
				$data = array(
					'is_deleted' => '1',
					'page_id' => $page_id
				);
				$this->db->where('id', $expend_id);
				$this->db->update($this->table_name, $data);
			endforeach;
	}
}
?>
