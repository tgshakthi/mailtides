<?php
/**
 * City Models
 *
 * @category Model
 * @package  City
 * @author   Saravana
 * Created at:  25-Jan-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class City_model extends CI_Model
{
	private $table_name = 'cities';

	/**
	 * Get City
	 * return output as stdClass Object array
	 */

	function get_cities()
	{
		$this->db->select('*');	
		$this->db->where(array(
							'is_deleted' => 0
						));
		$this->db->order_by('sort_order', 'desc');
		$query = $this->db->get($this->table_name);

		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;

		return $records;
	}

	/**
	 * Get City by @param
	 * return output as stdClass Object array
	 */
	function get_city_by_id($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	}

	// Inser Update Banner

	function insert_update_city($id = NULL)
	{		
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		
		if ($id == NULL):

			// insert data

			$insert_data = array(
				'name' => $this->input->post('city-name'),
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Insert into City

			return $this->db->insert($this->table_name, $insert_data);
		else:

			// Update data

			$update_data = array(
				'name' => $this->input->post('city-name'),
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Update into City

			$this->db->where('id', $id);
			return $this->db->update($this->table_name, $update_data);
		endif;
	}

	// Delete City

	function delete_city()
	{
		$id = $this->input->post('id');
		$this->db->where(array(
			'id' => $id,
		));
		return $this->db->update($this->table_name, array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple Banner

	function delete_multiple_city()
	{
		$citys = $this->input->post('table_records');
		$page_id = $this->input->post('page_id');
		foreach($citys as $city):
			$this->db->where(array(
				'id' => $city
			));
			$this->db->update('cities', array(
				'is_deleted' => 1
			));
		endforeach;
	}
}
