<?php
/**
 * Top header Model
 *
 * @category Model
 * @package  Top header Model
 * @author   Velu
 * Created at:  21-Sep-18
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Top_header_model extends CI_Model
{
	private $table_name = 'top_header';
	private $table_setting = 'setting';
	private $table_header = 'header';
	private $table_websites = 'websites';

	/**
	* Get Top Header
	* return output as stdClass Object array
	*/
	function get_top_header($website_id)
	{
		$this->db->select(array("$this->table_name.id", "$this->table_name.name",  "$this->table_name.url"));
		$this->db->from($this->table_name);
		$this->db->join($this->table_websites, 'FIND_IN_SET(' . $this->db->dbprefix($this->table_name) . '.id, ' . $this->db->dbprefix($this->table_websites) . '.top_header_components) > 0');
		$this->db->where("$this->table_websites.id", $website_id);
		$query = $this->db->get();
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	}
	
	function get_top_header_status($website_id)
	{
		$this->db->select(array('id', 'title', 'url','status'));
		$this->db->where(array(
			'url' => 'top_header',
			'website_id' => $website_id
		));
		$query = $this->db->get($this->table_header);
		$records = array();

		if ($query->num_rows() > 0) :
				foreach ($query->result() as $row) :
					$records[] = $row;
				endforeach;
		endif;
		return $records;
	}

	/**
	 * Get Customized top header data from setting table
	 * return output as stdClass Object array
	 */
	function get_setting_top_header($website_id, $code)
	{
		$this->db->select('*');
		$this->db->where(
			array(
				'website_id' => $website_id,
				'code' => $code
			)
		);
		$query = $this->db->get($this->table_setting);
		$records = array();
		if($query->num_rows() > 0) :
			$records = $query->result();
		endif;
		return $records;
	}

	/**
	 * Insert update top header customization
	 * Background color
	 */
	function insert_update_top_header_customize_data()
	{
		$id = $this->input->post('id');
		$website_id = $this->input->post('website_id');
		$status = $this->input->post('status');
		$status = isset($status) ? '1' : '0';
		$top_header_customization = $this->get_setting_top_header($website_id, 'top_header_background');

		$values = array(
			$this->input->post('top_header_background_color'),
			$status
		);

		// Convert to JSON data
		$keyJSON = json_encode(array( 'top_header_background_color', 'top_header_status' ));
		$valueJSON = json_encode($values);

		if(empty($top_header_customization)) :
			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'top_header_background',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->table_setting, $insert_data);
			$this->session->set_flashdata('success', 'Top Header Customization Successfully Created.');
		else:
			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'top_header_background'
			));
			$this->db->update($this->table_setting, $update_data);
			$this->session->set_flashdata('success', 'Top Header Customization Successfully Updated.');
		endif;
	}

	/**
	 * Get Contact information for customization
	 * return output as stdClass Object array
	 */
	function get_data_contact_information($website_id)
	{
		$this->db->select(array(
			'phone_no',
			'email',
			'address'
		));
		$this->db->where('website_id', $website_id);
		$query = $this->db->get('contact_information');

		$records = array();
		if($query->num_rows() > 0) :
			$records = $query->result_array();
		endif;

		return $records;
	}

	/**
	 * Insert Update Top header contact info
	 * In settings table
	 */
	function insert_update_top_header_contact_info_data()
	{
		
		$website_id = $this->input->post('website_id');
		$top_header_contact_info = $this->get_setting_top_header($website_id, 'top_header_contact_info');

		$key = array(
			'top_header_contact_info',
			'top_header_contact_info_position',
			'top_header_contact_info_status'
		);
		$contact_info = $this->input->post('contact_info');
		$values[] = (isset($contact_info)) ? $contact_info: [];
		$values[] = $this->input->post('position');
		$status	= $this->input->post('status');
		$values[]	= (isset($status)) ? '1' : '0';

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($values);

		if(empty($top_header_contact_info)) :
			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'top_header_contact_info',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->table_setting, $insert_data);
			$this->session->set_flashdata('success', 'Contact information Customization Successfully Created.');
		else:
			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'top_header_contact_info'
			));
			$this->db->update($this->table_setting, $update_data);
			$this->session->set_flashdata('success', 'Contact information Customization Successfully Updated.');
		endif;
	}

	/**
	 * Insert Update Top header Social Media
	 * In Setting table
	 */
	function insert_update_top_header_social_info_data()
	{
		$website_id = $this->input->post('website_id');
		$top_header_contact_info = $this->get_setting_top_header($website_id, 'top_header_social_media_info');

		$key = array(
			'top_header_social_info_position',
			'top_header_social_info_status'
		);

		$values[] = $this->input->post('position');
		$status	= $this->input->post('status');
		$values[]	= (isset($status)) ? '1' : '0';

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($values);

		if(empty($top_header_contact_info)) :
			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'top_header_social_media_info',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->table_setting, $insert_data);
			$this->session->set_flashdata('success', 'Top Header Social Media Customization Successfully Created.');
		else:
			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'top_header_social_media_info'
			));
			$this->db->update($this->table_setting, $update_data);
			$this->session->set_flashdata('success', 'Top Header Social Media Customization Successfully Updated.');
		endif;
	}

}
