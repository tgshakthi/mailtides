<?php
/**
 * H1 and H2 Models
 *
 * @category Model
 * @package  H! and H2 tag
 * @author   Karthika
 * Created at:  30-Nov-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class H1andh2_model extends CI_Model
{
	private $table_name = 'h1_and_h2';
	private $setting_table = 'setting';

	/**
	 * Get H1 and H2
	 * return output as stdClass Object array
	 */
	function get_h1andh2($id)
	{
		$this->db->select('*');
		$this->db->where('page_id', $id);
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

  // H1 and H2 customization
	function get_h1_and_h2_customization($website_id, $page_id, $code)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));
		$query = $this->db->get($this->setting_table);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Inser Update H1 and H2

	function insert_update_h1andh2($website_id, $id = NULL)
	{
		$page_id = $this->input->post('page-id');

		$this->insert_update_h1_and_h2_customization($website_id, $page_id);

		if ($id == NULL):

			// insert data

			$insert_data = array(
				'page_id' => $page_id,
				'h1_tag' => $this->input->post('h1-tag') ,
				'h2_tag' => $this->input->post('h2-tag')
			);

			return $this->db->insert($this->table_name, $insert_data);

		else:

			// Update data

			$update_data = array(
				'h1_tag' => $this->input->post('h1-tag') ,
				'h2_tag' => $this->input->post('h2-tag')
			);

			$this->db->where('id', $id);
			$this->db->where('page_id', $page_id);
			return $this->db->update($this->table_name, $update_data);
		endif;
	}

	function insert_update_h1_and_h2_customization($website_id, $page_id)
	{
		$key = array(
			'h1_title_color',
			'h2_title_color',
			'h1_title_position',
			'h2_title_position',
			'background_color'
		);

		$value[] = $this->input->post('h1-title-color');
		$value[] = $this->input->post('h2-title-color');
		$value[] = $this->input->post('h1-title-position');
		$value[] = $this->input->post('h2-title-position');
		$value[] = $this->input->post('background-color');

		// Convert to JSON data

		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$h1andh2_setting = $this->get_h1_and_h2_customization($website_id, $page_id, 'h1_and_h2');

		if (empty($h1andh2_setting)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'h1_and_h2',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->setting_table, $insert_data);

		else:

			// Update data

			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'h1_and_h2',
				'page_id' => $page_id
			));

			return $this->db->update($this->setting_table, $update_data);
		endif;
	}
}
