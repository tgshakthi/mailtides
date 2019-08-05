<?php
/**
 * Header Models
 *
 * @category Model
 * @package  Header Model
 * @author   Athi
 * Created at:  29-Apr-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Header_model extends CI_Model
{
	private $table_setting = 'setting';
	private $table_websites = 'websites';
	private $table_header_components = 'header_components';

	/**
	* Get Header
	* return output as stdClass Object array
	*/
	function get_header($website_id)
	{
		$this->db->select(array("$this->table_header_components.id", "$this->table_header_components.name",  "$this->table_header_components.url"));
		$this->db->from($this->table_header_components);
		$this->db->join($this->table_websites, 'FIND_IN_SET(' . $this->db->dbprefix($this->table_header_components) . '.id, ' . $this->db->dbprefix($this->table_websites) . '.header_components) > 0');
		$this->db->where("$this->table_websites.id", $website_id);
		$query = $this->db->get();
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	}

	/**
	 * Get Customized header data from setting table
	 * return output as stdClass Object array
	 */
	function get_setting_header($website_id, $code)
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

	function insert_update_header_customization()
	{
		$website_id = $this->input->post('website_id');
		$header_customization = $this->get_setting_header($website_id, 'header_background');

		$values = array(
			$this->input->post('header_background_color'),
		);

		// Convert to JSON data
		$keyJSON = json_encode(array( 'header_background_color' ));
		$valueJSON = json_encode($values);

		if(empty($header_customization)) :
			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'header_background',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->table_setting, $insert_data);
			$this->session->set_flashdata('success', 'Header Customization Successfully Created.');
		else:
			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'header_background'
			));
			$this->db->update($this->table_setting, $update_data);
			$this->session->set_flashdata('success', 'Header Customization Successfully Updated.');
		endif;
	}
}
