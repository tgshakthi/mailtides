<?php
/**
 * Newsletter Models
 *
 * @category Model
 * @package  Newsletter
 * @author   Karthika
 * Created at:  27-Oct-2018
 * 
 * Modified Date : 01-March-2019
 * Modified by : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Newsletter_model extends CI_Model
{
	private $table_name = 'newsletter';
	private $table_setting = 'setting';

	/**
	 * Get newsletter
	 * return output as stdClass Object array
	 */
	function get_newsletter($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'is_deleted' => '0'
		));
		$this->db->order_by('id', 'desc');
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Get newsletter customization from setting
	function get_newsletter_customiztion($website_id, $page_id, $code) 
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));
		$query = $this->db->get($this->table_setting);
		$records = array();
		if ($query->num_rows() > 0) :				
			$records = $query->result();				
		endif;
		return $records;
	}

	// Insert Update Newsletter Customization

	function insert_update_newsletter_data($website_id)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('newsletter_background_color');
		$image = $this->input->post('image');
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$newsletter_background = str_replace($find_url, "", $image);
		else :
			$newsletter_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;		
		
		$key = array(
					'newsletter_title',
					'newsletter_content',
					'newsletter_title_color',
					'newsletter_title_position',
					'newsletter_content_color',
					'newsletter_content_position',
					'label_color',
					'button_type',
					'btn_background_color',
					'component_background',
					'newsletter_background',
					'status'
				);
			
		$page_id = $this->input->post('page-id');
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';

		$value[] = $this->input->post('newsletter-title');
		$value[] = htmlspecialchars_decode(trim(htmlentities($this->input->post('text'))));
		$value[] = $this->input->post('title-color');
		$value[] = $this->input->post('title-position');
		$value[] = $this->input->post('content-color');
		$value[] = $this->input->post('content-position');
		$value[] = $this->input->post('label_color');
		$value[] = $this->input->post('button_type');
		$value[] = $this->input->post('btn_background_color');
		// $value[] = $this->input->post('background-color');
		$value[] = $this->input->post('component-background');
		$value[] = $newsletter_background;
		$value[] = $status;

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$newsletter = $this->get_newsletter_customiztion($website_id, $page_id, 'newsletter-customization');

		if (empty($newsletter)) :
			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'newsletter-customization',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->table_setting, $insert_data);
			return $this->session->set_flashdata('success', 'Successfully Created');
		else :
			// Update data
			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			$this->db->where(array('website_id' => $website_id, 'code' => 'newsletter-customization', 'page_id' => $page_id));
			$this->db->update($this->table_setting, $update_data);			
			return $this->session->set_flashdata('success', 'Successfully Updated');
		endif;
	}

	// Delete newsletter

	function delete_newsletter($website_id)
	{
		$id = $this->input->post('id');
		$this->db->where(array(
			'id' => $id,
			'website_id' => $website_id			
		));

		$this->db->update($this->table_name, array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple newsletter

	function delete_multiple_newsletter()
	{
		$newsletters = $this->input->post('table_records');		
		foreach($newsletters as $newsletter):
			$this->db->where(array(
				'id' => $newsletter
			));
			$this->db->update($this->table_name, array(
				'is_deleted' => 1
			));
		endforeach;
	}

	// Get Mail config
	function get_newsletter_mail_config($website_id, $code) 
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code
		));
		$query = $this->db->get($this->table_setting);
		$records = array();
		if ($query->num_rows() > 0) :				
			$records = $query->result();				
		endif;
		return $records;
	}

	// Insert Update Newsletter Mail config
	function insert_update_newsletter_mail_config()
	{
		$website_id = $this->input->post('website_id');
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';

		$to_address = $this->input->post('to_address');
        $carbon_copy = $this->input->post('carbon_copy');
        $blind_carbon_copy = $this->input->post('blind_carbon_copy');
        
		$to_address  = ($to_address != '') ? implode(",",$to_address): '';
		$carbon_copy  = ($carbon_copy != '') ? implode(",",$carbon_copy): '';
        $blind_carbon_copy = ($blind_carbon_copy != '') ? implode(",",$blind_carbon_copy): '';

		$key = array(
			'mail_subject',
			'from_name',
			'message_content',
			'success_title',
			'success_message',
			'to_address',
			'cc',
			'bcc',
			'status'
		);

		$value = array(
			$this->input->post('mail_subject'),
			$this->input->post('from_name'),
			$this->input->post('message_content'),
			$this->input->post('success_title'),
			$this->input->post('success_message'),
			$to_address,
			$carbon_copy,
			$blind_carbon_copy,
			$status
		);

		// Convert to JSON
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$newsletter_mail_config = $this->get_newsletter_mail_config($website_id, 'newsletter-mail-config');

		if (empty($newsletter_mail_config)) :

			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'newsletter-mail-config',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Insert 
			$this->db->insert($this->table_setting, $insert_data);
			return $this->session->set_flashdata('success', 'Successfully Created');

		else :

			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Update
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'newsletter-mail-config'
			));
			$this->db->update($this->table_setting, $update_data);
			return $this->session->set_flashdata('success', 'Successfully Updated');
			
		endif;
	}
}