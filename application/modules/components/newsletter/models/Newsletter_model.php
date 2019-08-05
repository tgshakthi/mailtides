<?php
/**
 * Newsletter Model
 * 
 * @author Saravana
 * Created at : 01-March-2019
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter_model extends CI_Model
{
	private $table_name = 'newsletter';
	private $table_setting = 'setting';
	
	// Insert Newsletter
	function insert_newsletter($website_id)
	{
		$json_array = array(
			'name' => $this->input->post('newsletter-name'),
			'email' => $this->input->post('newsletter-email')
		);

		// Convert into JSON
		$valueJson = json_encode($json_array);

		$insert_data = array(
			'website_id' => $website_id,
			'value' => $valueJson
		);

		$this->db->insert($this->table_name, $insert_data);
	}
}
?>
