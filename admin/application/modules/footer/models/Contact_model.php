<?php
/**
 * Contact Models
 *
 * @category Model
 * @package  Contact
 * @author   Athi
 * Created at:  20-Jul-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contact_model extends CI_Model
{
	/**
	 * Get Contact 
	 * return output as stdClass Object array
	 */
	function get_contact_setting($website_id, $code)
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

	/**
	 * insert and update Footer Contact
	 * return output as stdClass Object array
	 */
	function insert_update_footer_contact($website_id, $id = NULL)
	{
		$common_components	= (!empty($this->input->post('common_components'))) ? $this->input->post('common_components'): array();
		$status = $this->input->post('status');
		
		$key = array(
			'contact_us',
			'contact_information',
			'status'
		);
		
		$value[] = (in_array('contact_us', $common_components)) ? 1: 0;
		$value[] = (in_array('contact_information', $common_components)) ? 1: 0;
		$value[] = (isset($status)) ? '1' : '0';
		
		// Convert to JSON data

		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_id'	=> $website_id,
				'code'	=> 'footer_contact',
				'key'	=> $keyJSON,
				'value'	=> $valueJSON
			);

			// Insert into Footer Contact

			$this->db->insert('setting', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'key'	=> $keyJSON,
				'value'	=> $valueJSON
			);

			// Update into Footer Contact

			$this->db->where(array('website_id' => $website_id, 'code' => 'footer_contact'));
			return $this->db->update('setting', $update_data);
		endif;
	}
}
