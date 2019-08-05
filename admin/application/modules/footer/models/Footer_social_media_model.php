<?php
/**
 * Footer Social Media
 *
 * @category class
 * @package  Footer Social Media
 * @author   Saravana
 * Created at:  27-Sep-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Footer_social_media_model extends CI_Model
{
	private $table_setting = 'setting';

	/**
	 * Get Customized footer data from setting table
	 * return output as stdClass Object array
	 */
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

	/**
	 * Insert Update Footer Social Media
	 * In Setting table
	 */
	function insert_update_footer_social_info_data()
	{
		$website_id = $this->input->post('website_id');
		$footer_contact_info = $this->get_setting_footer($website_id, 'footer_social_media_info');

		$key = array(
			'footer_social_info_position',
			'footer_social_info_status'
		);

		$values[] = $this->input->post('position');
		$status	= $this->input->post('status');
		$values[]	= (isset($status)) ? '1' : '0';

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($values);

		if(empty($footer_contact_info)) :
			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'footer_social_media_info',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			// echo"<pre>";
			// print_r($insert_data);
			// die;
			$this->db->insert($this->table_setting, $insert_data);
			$this->session->set_flashdata('success', 'Footer Social Media Customization Successfully Created.');
		else:
			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'footer_social_media_info'
			));
			$this->db->update($this->table_setting, $update_data);
			$this->session->set_flashdata('success', 'Footer Social Media Customization Successfully Updated.');
		endif;
	}

}
