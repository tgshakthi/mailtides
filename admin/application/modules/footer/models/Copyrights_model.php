<?php
/**
 * Copyrights Models
 *
 * @category Model
 * @package  Copyrights
 * @author   shiva
 * Created at:  14-june-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Copyrights_model extends CI_Model
{
	
	/**
	 * Get  Copyrights Details to insert and update 
	 * return output as stdClass Object array
	 */
	function insert_update_copyrights()
	{
		$website_id = $this->input->post('website_id');
		$key	= array('copyrights_content','copyrights_text_color','copyrights_bg_color','copyright_status' );
		$value[]	= $this->input->post('copyrights_content');
		$value[]	= $this->input->post('copyrights_text_color');
		$value[]	= $this->input->post('copyrights_bg_color');
		$status	= $this->input->post('copyright_status');
      	$value[]	= (isset($status)) ? '1' : '0';
		
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		
		$footer_copyrights = $this->get_copyrights_details($website_id, 'footer-copyrights');
		if(empty($footer_copyrights)) :
		
			// insert data
			$insert_data = array(
				'website_id'   => $website_id,
				'website_id'   => $website_id,
				'code'  	=> 'footer-copyrights',
				'key'   => $keyJSON,  
				'value'   => $valueJSON
			);
			
			// Insert into Menu
			
			return $this->db->insert('setting', $insert_data);
			
		else:

			// Update data

			$update_data = array(
				'key'   => $keyJSON,  
				'value'   => $valueJSON  			            
			);
		
        	// Update into Banner
			$this->db->where(array('website_id' => $website_id, 'code' => 'footer-copyrights'));
        	return $this->db->update('setting', $update_data);
		endif;
	}

	/**
	 * Get Logo and Logo Details
	 * return output as stdClass Object array
	 */
	function get_copyrights_details($website_id, $logo_val = 'footer-copyrights')
	{
		$this->db->select(array(
			'id',
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
}
