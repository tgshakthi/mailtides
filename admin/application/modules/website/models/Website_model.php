<?php
/**
 * Website Model
 *
 * @category Model
 * @package  Website
 * @author   Saravana
 * Created at:  05-Apr-2018
 * 
 * Modified Date : 21-Feb-2019
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Website_model extends CI_Model
{
	private $table_name = 'websites';
	private $components_table = 'components';
	private $common_components_table = 'common_components';
	private $top_header_components_table = 'top_header';
	private $header_components_table = 'header_components';
	private $footer_components_table = 'footer_components';

	/**
	 * Get all websites
	 * return output as stdClass Object array
	 */
	function get_websites()
	{
		$this->db->select(array(
			'id',
			'website_name',
			'folder_name',
			'website_url',
			'logo',
			'status'
		));
		$this->db->where('is_deleted', '0');
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0 ) :
		  $records = $query->result();
		endif;
		return $records;
	}

	/**
	 * Website Cloning
	 */
	function get_data($table_name, $id1, $id2)
	{
		$this->db->select('*');
		$this->db->where($id1, $id2);
		$query = $this->db->get($table_name);
		$records = array();
		if ($query->num_rows() > 0 ) :
		  $records = $query->result();
		endif;
		return $records;
	}

	function get_data_two_where($table_name, $id1, $id2, $id3, $id4)
	{
		$this->db->select('*');
		$this->db->where(array(
			$id1 => $id2,
			$id3 => $id4
		));
		$query = $this->db->get($table_name);
		$records = array();
		if ($query->num_rows() > 0 ) :
		  $records = $query->result();
		endif;
		return $records;
	}

	/**
	 * Website Cloning Insert Data
	 */
	function insert_data($table_name, $insert_data)
	{
		$this->db->insert($table_name, $insert_data);
		return $this->db->insert_id();
	}

	// Get website by id

	function get_websiteby_id($id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'id' => $id,
			'is_deleted' => '0'
		));
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0 ) :
		  $records = $query->result();
		endif;
		return $records;
	}

	// Inser Update user

	function insert_update_website_data($website_configuration, $components, $id = NULL)
	{
		$status = $this->input->post('website-status');
		$status = (isset($status)) ? '1' : '0';

		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_name' => $this->input->post('website-name'),
				'website_url' => $this->input->post('website-url') ,
				'components' => $components,
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Merge website configuration array
			$insert_data = array_merge($insert_data, $website_configuration);

			// Insert into Websites

			$this->db->insert($this->table_name, $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'website_name' => $this->input->post('website-name') ,
				'website_url' => $this->input->post('website-url') ,
				'status' => $status,
			);

			$update_data = array_merge($update_data, $website_configuration);

			// Update into websites

			$this->db->where('id', $id);
			return $this->db->update($this->table_name, $update_data);
		endif;
	}

	// Delete website

	function delete_website()
	{
		$id = $this->input->post('id');
		$data = array(
			'is_deleted' => '1'
		);
		$this->db->where('id', $id);
		return $this->db->update($this->table_name, $data);
	}

	// Delete mulitple website

	function delete_multiple_website()
	{
		$website_ids = $this->input->post('table_records');
		foreach($website_ids as $website_id):
			$data = array(
				'is_deleted' => '1'
			);
			$this->db->where('id', $website_id);
			$this->db->update($this->table_name, $data);
		endforeach;
	}

	// Get Components

	function get_components()
	{
		$this->db->select('*');
		$this->db->where('status', 1);
		$query = $this->db->get($this->components_table);
		$records = array();
		if ($query->num_rows() > 0 ) :
		  $records = $query->result();
		endif;
		return $records;
	}

	// Get Common Components

	function get_common_components()
	{
		$this->db->select('*');
		$this->db->where('status', 1);
		$query = $this->db->get($this->common_components_table);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Insert Update Selected Components

	function insert_update_selected_components($id)
	{
		$top_header_components = $this->input->post('top_header_component_records');
		$header_components = $this->input->post('header_component_records');
		$components = $this->input->post('component_records');
		$footer_components = $this->input->post('footer_component_records');
		$top_header_component = (!empty($top_header_components)) ? implode(',', $top_header_components) : '';
		$header_component = (!empty($header_components)) ? implode(',', $header_components) : '';
		$component = (!empty($components)) ? implode(',', $components) : '';
		$footer_component = (!empty($footer_components)) ? implode(',', $footer_components) : '';

		//

		$component_data = array(
			'top_header_components' => $top_header_component,
			'header_components' => $header_component,
			'components' => $component,
			'footer_components' => $footer_component
		);
		$this->db->where('id', $id);
		$this->db->update($this->table_name, $component_data);
	}

	// Get Selected Components

	function get_selected_components($id)
	{
		$this->db->select(array(
			'top_header_components',
			'header_components',
			'components',
			'footer_components'
		));
		$this->db->where('id', $id);
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0 ) :
		  $records = $query->result();
		endif;
		return $records;
	}

	// Get Top Header components

	function get_top_header_components()
	{
		$this->db->select('*');
		$query = $this->db->get($this->top_header_components_table);
		$records = array();
		if ($query->num_rows() > 0 ) :
		  $records = $query->result();
		endif;
		return $records;
	}

	// Get Header components

	function get_header_components()
	{
		$this->db->select('*');
		$query = $this->db->get($this->header_components_table);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Get Footer components

	function get_footer_components()
	{
		$this->db->select('*');
		$query = $this->db->get($this->footer_components_table);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}
}