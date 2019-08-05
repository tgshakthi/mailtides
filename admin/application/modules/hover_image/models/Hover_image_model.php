<?php
/**
 * Hover Image Models
 *
 * @h Model
 * @package  Hover Image
 * @author   Velu Samy
 * Created at:  05-Apr-2019
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Hover_image_model extends CI_Model
{
	private $table_name = 'hover_image';
	private $setting_table	= 'setting';
	
	/**
	 * Get Hover Image  Details
	 * return output as stdClass Object array
	 */

	function get_hover_image($page_id)
	{
		$this->db->select('*');

		$this->db->where(array(
							'page_id' => $page_id,
							'is_deleted' => 0
						));

		$query = $this->db->get($this->table_name);
		$records = array();

		if ($query->num_rows() > 0) :
				foreach ($query->result() as $row) :
					$records[] = $row;
				endforeach;
		endif;

		return $records;
	}

	/**
	 * Get Hover Image setting Details
	 * return output as stdClass Object array
	 */

	function get_hover_image_setting_details($website_id, $page_id, $code)
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
			foreach ($query->result() as $row) :
				$records[] = $row;
			endforeach;
		endif;

		return $records;
	}
	
	/**
	 * Get Hover Image setting Details
	 * return output as stdClass Object array
	 */

	function get_hover_image_details($id,$page_id)
	{
		$this->db->select('*');

		$this->db->where(array(
							'id' => $id,
							'page_id' => $page_id
						));

		$query = $this->db->get($this->table_name);
		$records = array();

		if ($query->num_rows() > 0) :
				foreach ($query->result() as $row) :
					$records[] = $row;
				endforeach;
		endif;

		return $records;
	}
	
	// Insert Update Hover Image Customization

	function insert_update_hover_image_customize_data($page_id)
	{
		$website_id = $this->input->post('website_id');
		
		$key = array(
				'hover_image_row_count'
			);

		$value[] = $this->input->post('hover_image_row_count');
		
		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$hover_images = $this->get_hover_image_setting_details($website_id, $page_id, 'hover_image_customize');

		if (empty($hover_images)):
			// insert data
			$insert_data = array(
							'website_id' => $website_id,
							'page_id' => $page_id,
							'code' => 'hover_image_customize',
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

			$this->db->where(array('website_id' => $website_id, 'code' => 'hover_image_customize', 'page_id' => $page_id));			
			$this->db->update($this->setting_table, $update_data);
			return $this->session->set_flashdata('success', 'Successfully Updated');
		endif;
	}
	
	// Insert Update Circular Image Customization

	function insert_update_hover_image_model($page_id)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$hover_image_id = $this->input->post('hover_image_id');
		$httpUrl = $this->input->post('httpUrl');
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		$primary_image = $this->input->post('primary_image');
		$secondary_image = $this->input->post('secondary_image');
		
		// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$primary_images = str_replace($find_url, "", $primary_image);
			$secondary_images = str_replace($find_url, "", $secondary_image);	

		$hover_image_details = array(
									'primary_image' => $primary_images,
									'secondary_image' => $secondary_images,
									'hover_image_title' => $this->input->post('content'),
									'title_color' => $this->input->post('title_color'),
									'title_hover_color' => $this->input->post('title_hover_color'),
									'title_background_color' => $this->input->post('title_background_color'),
									'title_bg_hover_color' => $this->input->post('title_bg_hover_color'),
							
								);
		$hover_images = $this->get_hover_image_details($hover_image_id,$page_id);

		if (empty($hover_images)):
			// insert data
			$insert_data = array(
				'page_id' => $page_id,
				'hover_image_details' => json_encode($hover_image_details),
				'sort_order' => $this->input->post('sort_order'),
				'status' => $status
			);

			$this->db->insert($this->table_name, $insert_data);
			$this->session->set_flashdata('success', 'Successfully Created');		
			return $this->db->insert_id();
		else :
			// Update data
  			$update_data = array(
								'hover_image_details' => json_encode($hover_image_details),
								'sort_order' => $this->input->post('sort_order'),
								'status' => $status
							);

			$this->db->where(array('id' => $hover_image_id,'page_id' => $page_id));			
			$this->db->update($this->table_name, $update_data);
			return $this->session->set_flashdata('success', 'Successfully Updated');
		endif;
	}

	// Delete Hover Image

	function delete_hover_image($page_id)
	{
		$id = $this->input->post('id');

		$this->db->where(array(
			'id' => $id,
			'page_id' => $page_id
		));

		$this->db->update($this->table_name, array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple Hover Image

	function delete_multiple_hover_image_data()
	{
		$hover_images = $this->input->post('table_records');
		$page_id = $this->input->post('page_id');
		foreach($hover_images as $hover_image):
			$this->db->where(array(
									'id' => $hover_image,
									'page_id' => $page_id
								));
			$this->db->update($this->table_name, array(
				'is_deleted' => 1
			));
		endforeach;
	}

}