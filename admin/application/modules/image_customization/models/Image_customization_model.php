<?php
/**
 * Image customization Models
 *
 * @category Model
 * @package  Image Customization
 * @author   Athi
 * Created at:  22-Oct-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Image_customization_model extends CI_Model
{
	private $table_name = 'image_customize';
	private $setting	= 'setting';
	
	/**
	 * Get Image Html Data
	 * return output as stdClass Object array
	 */

	function get_image_html($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'is_deleted' => 0
		));

		$this->db->order_by('id', 'desc');
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
	
	/**
	 * Get Image Html Data
	 * return output as stdClass Object array
	 */

	function get_image_html_by_pages($website_id, $i)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'pages' => $i,
			'is_deleted' => 0
		));

		$this->db->order_by('id', 'desc');
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
	
	/**
	 * Get Image Customization Detting Data
	 * return output as stdClass Object array
	 */

	function get_image_customize_setting_details($website_id, $code)
	{
		$this->db->select('*');

		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
		));

		$query = $this->db->get($this->setting);
		$records = array();

		if ($query->num_rows() > 0) :
				foreach ($query->result() as $row) :
					$records[] = $row;
				endforeach;
		endif;

		return $records;
	}
	
	//Insert Update Image Customization
	function insert_update_image_html($website_id)
	{
		$make_images = $_POST['make_image_html'];
		
		if(!empty($make_images))
		{
			$i = 1;
			foreach($make_images as $make_image)
			{
				$image_html = $this->get_image_html_by_pages($website_id, $i);
				if(!empty($image_html))
				{
					// Update data
					$update_data = array(
						'custom_html'	=> $make_image			            
					);
					
					// Update into Image Customization
					$this->db->where(array('website_id' => $website_id, 'pages' => $i));
					$this->db->update($this->table_name, $update_data);
				}
				else
				{
					// insert data
					$insert_data = array(
						'website_id'	=> $website_id,
						'pages'	=> $i,
						'custom_html'	=> $make_image,
						'created_at'	=> date('m-d-Y')
					);
					
					// Insert into Image Customization
					$this->db->insert($this->table_name, $insert_data);
				}
				
				$i++;
			}
		}
	}
	
	//Insert Update Image Customization Setting
	function insert_update_setting($website_id)
	{
		$active_page = $_POST['active_page'];
		$page_count = $_POST['page_count'];
		
		$key = array(
			'active_page',
			'page_count',
		);

		$value[] = $_POST['active_page'];
		$value[] = $_POST['page_count'];

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		
		$image_customizations = $this->get_image_customize_setting_details($website_id, 'image_customization');

		if (empty($image_customizations)):
			
			// insert data
			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'image_customization',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			$this->db->insert($this->setting, $insert_data);
			$this->session->set_flashdata('success', 'Image Customization successfully Saved');
			$this->db->insert_id();
			
		else :
			
			// Update data
  			$update_data = array(
				'key'   => $keyJSON,
				'value'   => $valueJSON
			);

			$this->db->where(array('website_id' => $website_id, 'code' => 'image_customization'));
			$this->session->set_flashdata('success', 'Image Customization successfully Updated');
      		$this->db->update($this->setting, $update_data);
			
		endif;
	}
}
