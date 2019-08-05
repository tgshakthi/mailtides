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

class Footer_model extends CI_Model
{
	private $table_setting = 'setting';
	private $table_websites = 'websites';
	private $table_footer_components = 'footer_components';
	private $table_name = 'contact_information';

  	/**
   	* Get Footer
   	* return output as stdClass Object array
   	*/
	

  	function get_footer($website_id)
  	{
    	$this->db->select(array("$this->table_footer_components.id", "$this->table_footer_components.name",  "$this->table_footer_components.url"));
		$this->db->from($this->table_footer_components);
		$this->db->join($this->table_websites, 'FIND_IN_SET(' . $this->db->dbprefix($this->table_footer_components) . '.id, ' . $this->db->dbprefix($this->table_websites) . '.footer_components) > 0');
		$this->db->where("$this->table_websites.id", $website_id);
		$query = $this->db->get();
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
  	}
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
	function insert_update_footer_contact_info_data()
	{

		$website_id = $this->input->post('website_id');
		$footer_contact_info = $this->get_setting_footer($website_id, 'footer_contact_info');

		$key = array(
			'footer_contact_info',
			'footer_contact_info_position',
			'footer_contact_info_status'
		);
		$contact_info = $this->input->post('contact_info');
		$values[] = (isset($contact_info)) ? $contact_info: [];
		$values[] = $this->input->post('position');
		$status	= $this->input->post('status');
		$values[]	= (isset($status)) ? '1' : '0';

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($values);

		if(empty($footer_contact_info)) :
			
			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'footer_contact_info',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->table_setting, $insert_data);
			$this->session->set_flashdata('success', 'Footer Contact information Customization Successfully Created.');
		else:
			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'footer_contact_info'
			));
			$this->db->update($this->table_setting, $update_data);
			$this->session->set_flashdata('success', 'Footer contact information Customization Successfully Updated.');
		endif;
	}
	function get_setting_footer($website_id, $code)
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
	function insert_update_footer_customize_data()
	{
		
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
	    $httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('footer_background_color');
		$image = $this->input->post('image');
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$circular_background = str_replace($find_url, "", $image);
		else :
			$circular_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;
		$footer_customization = $this->get_setting_footer($website_id, 'footer_status_and_background');
		
		$key = array(
		    'component_background',
			'footer_background',
			'footer_status'
		);
		$value[] = $this->input->post('component-background');
		$value[] = $circular_background;
	    $status	= $this->input->post('footer_status');
		$value[]= (isset($status)) ? '1' : '0';


		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		

		if(empty($footer_customization)) :
			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'footer_status_and_background',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			
		
			$this->db->insert($this->table_setting, $insert_data);
			$this->session->set_flashdata('success', 'Footer Customization Successfully Created.');
		else:
			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'footer_status_and_background'
			));
			$this->db->update($this->table_setting, $update_data);
			$this->session->set_flashdata('success', 'Footer Customization Successfully Updated.');
		endif;
	}
}
