<?php
/**
 * Seo Description Models
 *
 * @category Model
 * @package  Seo Description
 * @author   Saravana
 * Created at:  28-Jan-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Seo_description_model extends CI_Model
{
	private $table_name = 'description_content';

	/**
	 * Get Seo Descriptions
	 * return output as stdClass Object array
	 */

	function get_seo_descriptions($website_id)
	{
		$this->db->select('*');		
		$this->db->where('is_deleted', '0');
		$this->db->order_by('sort_order', 'desc');
		$query = $this->db->get($this->table_name);

		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;

		return $records;
	}

	/**
	 * Get Seo Description by @param
	 * return output as stdClass Object array
	 */
	function get_seo_description_by_id($id)
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

	// Inser Update Seo Description

	function insert_update_seo_description($id = NULL)
	{		
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		
		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_id' => $this->input->post('website_id'), 
				'category' => $this->input->post('category'),
				'content' => $this->input->post('content'),
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Insert into seo description

			return $this->db->insert($this->table_name, $insert_data);
		else:

			// Update data

			$update_data = array(
				'category' => $this->input->post('category'),
				'content' => $this->input->post('content'),
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Update into seo description

			$this->db->where(array(
				'id' => $id,
				'website_id' => $this->input->post('website_id')
			));
			return $this->db->update($this->table_name, $update_data);
		endif;
	}

	// Delete Seo description

	function delete_seo_description()
	{

		$id = $this->input->post('id');
		$this->db->where(array(
			'id' => $id,
		));
		$this->db->update($this->table_name, array(
			'is_deleted' => 1
		));

		return $this->session->set_flashdata('success', 'Seo Description Successfully Deleted.');
	}

	// Delete mulitple seo description

	function delete_multiple_seo_description()
	{
		$seo_descriptions = $this->input->post('table_records');

		foreach($seo_descriptions as $seo_description):
			$this->db->where(array(
				'id' => $seo_description,
			));
			$this->db->update($this->table_name, array(
				'is_deleted' => 1
			));
		endforeach;
	}
}
