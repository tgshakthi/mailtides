<?php
/**
 * Logo Models
 *
 * @category Model
 * @package  Logo
 * @author   shiva
 * Created at:  30-May-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Logo_model extends CI_Model
{
	/**
	 * Get Logo and Logo Details
	 * return output as stdClass Object array
	 */

	function get_logo_details($website_id)
	{
		$this->db->select(array(
			'id',
			'website_name',
			'website_url',
			'logo',
			'status',
			'is_deleted'
		));
		$this->db->where(array(
			'id' => $website_id,
			'is_deleted' => 0,
			'status' => 1
		));
		$query = $this->db->get('websites');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get  Logo Details insert and update operation
	 * return output as stdClass Object array
	 */
	function insert_update_logo()
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$logo    = $this->input->post('logo');
		$httpUrl = $this->input->post('httpUrl');
		$logo_position = $this->input->post('logo-position');
		$logo_size = $this->input->post('logo-size');

		 // Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $logo    = str_replace($find_url, "", $logo);

		$key_logo_size_postion = array(
			'logo_position',
			'logo_size'
		);
		$key_logo_size_postion_name = json_encode($key_logo_size_postion);
		$my_logo_size_postion = array(
			$logo_position,
			$logo_size
		);
		$logo_size_postion = json_encode($my_logo_size_postion);

		$logo_settings = $this->get_logo_settings_details($website_id, 'logo');

		if (empty($logo_settings)) :

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => "0",
				'code' => 'logo',
				'key' => $key_logo_size_postion_name,
				'value' => $logo_size_postion
			);

			// Update Logo
			$update_logo_data = array(
				'logo' => $logo
			);

			// Insert into Logo details

			$this->db->insert('setting', $insert_data);
			$this->db->where('id', $website_id);
			$this->db->update('websites', $update_logo_data);
			return $this->session->set_flashdata('success', 'Logo details Successfully Inserted.');
		else:

			// Update data

			$update_data = array(
				'key' => $key_logo_size_postion_name,
				'value' => $logo_size_postion
			);

			// Update Logo
			$update_logo_data = array(
				'logo' => $logo
			);

			// Update into Setting
			$this->db->where(array(
				'code' => 'logo',
				'website_id' => $website_id
			));
			$this->db->update('setting', $update_data);
			
			// Update into Website
			$this->db->where('id', $website_id);
			$this->db->update('websites', $update_logo_data);
			return $this->session->set_flashdata('success', 'Logo details Successfully Updated.');
		endif;
	}

	/**
	 * Get Logo and Logo Details
	 * return output as stdClass Object array
	 */
	function get_logo_settings_details($website_id, $logo_val = 'logo')
	{
		$this->db->select(array(
			'code',
			'key',
			'value'
		));
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $logo_val
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

	// Remove Logo
	function remove_logo()
	{
	 $id = $this->input->post('id');
	  $remove_image = array(
			'logo' => ""
	  );
	  $this->db->where('id', $id);
	  $this->db->update('websites', $remove_image);
	}
}
