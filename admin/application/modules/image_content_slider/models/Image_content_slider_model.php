<?php
/**
 * Image Content Slider
 *
 * @category class
 * @package  Image Content Slider
 * @author   Velu
 * Created at:  17-Dec-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Image_content_slider_model extends CI_Model
{
	private $table_name = 'image_content_slider';
	private $table_setting = 'setting';

	// Get Image Content slider info

	function get_image_content($website_id, $page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'page_id' => $page_id,
			'is_deleted' => 0
		));
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Get Image Content Slider by Id

	function get_image_content_slider_by_id($website_id, $id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'id' => $id
		));
		$query = $this->db->get($this->table_name);

		// echo $query = $this->db->get_compiled_select($this->table_name);

		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Insert Update Image content slider - setting

	function get_image_content_slider_setting_details($website_id, $page_id, $code)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));
		$query = $this->db->get($this->table_setting);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Insert Update Image content slider - title

	function insert_update_image_content_slider_title($page_id, $id = NULL)
	{
	
		$key = array(
			'image_content_slider_title',
			'image_content_slider_content',
			'image_content_slider_title_status',
		);
		$website_id = $this->input->post('website_id');
		$value[] = $this->input->post('image_content_slider_title');
		$value[] = $this->input->post('text');
		$status = $this->input->post('image_content_slider_status');
		$value[] = (isset($status)) ? '1' : '0';

		// Convert to JSON data

		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		$image_slider_service = $this->get_image_content_slider_setting_details($website_id, $page_id, 'Image_content_slider_title');
		if (empty($image_slider_service)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'Image_content_slider_title',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->table_setting, $insert_data);
			$this->session->set_flashdata('success', 'Successfully Created');
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'Image_content_slider_title',
				'page_id' => $page_id
			));
			$this->session->set_flashdata('success', 'Successfully Updated');
			return $this->db->update($this->table_setting, $update_data);
		endif;
	}

	// Insert Update Image Content Slider - Customization

	function insert_update_image_content_slider_customize($page_id, $id = NULL)
	{
	
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$httpUrl = $this->input->post('httpUrl');
	   $component_background = $this->input->post('component-background');
		$color = $this->input->post('image_content_background_color');
		$image = $this->input->post('image');
		$key = array(
			'title_color',
			'title_position',
			'content_title_color',
			'content_title_position',
			'content_color',
			'content_position',
			'image_content_slider_position',
			'row_count',
			'component_background',
			'image_content_background',
			'readmore_btn',
			'button_type',
			'button_position',
			'btn_background_color',
			'readmore_label',
			'readmore_label_color',
			'readmore_url',
			'open_new_tab',
			'btn_background_hover',
			'btn_label_hover',
		);
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$circular_background = str_replace($find_url, "", $image);
		else :
			$circular_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;
		$value[] = $this->input->post('title_color');
		$value[] = $this->input->post('title_position');
		$value[] = $this->input->post('content_title_color');
		$value[] = $this->input->post('content_title_position');
		$value[] = $this->input->post('content_color');
		$value[] = $this->input->post('content_position');
		$value[] = $this->input->post('image_content_slider_position');
		$value[] = $this->input->post('row_count');
		$value[] = $this->input->post('component-background');
		$value[] = $circular_background;

		$readmore_btn = $this->input->post('readmore_btn');
		$value[] = (isset($readmore_btn)) ? '1' : '0';
		$value[] = $this->input->post('button_type');
		$value[] = $this->input->post('button_position');
		$value[] = $this->input->post('btn_background_color');
		$value[] = $this->input->post('readmore_label');
		$value[] = $this->input->post('readmore_label_color');
		$value[] = $this->input->post('readmore_url');
		$open_new_tab = $this->input->post('open_new_tab');
		$value[] = (isset($open_new_tab)) ? '1' : '0';
		$value[] = $this->input->post('btn_background_hover');
		$value[] = $this->input->post('btn_label_hover');

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		$image_slider_customize = $this->get_image_content_slider_setting_details($website_id, $page_id, 'Image_content_slider_customize');
		if (empty($image_slider_customize)):
			// insert data
			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'Image_content_slider_customize',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->table_setting, $insert_data);
			$this->session->set_flashdata('success', 'Successfully Created');
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'Image_content_slider_customize',
				'page_id' => $page_id
			));
			$this->session->set_flashdata('success', 'Successfully Updated');
			return $this->db->update($this->table_setting, $update_data);
		endif;
	}

	// Image Content Slider - Insert Update

	function insert_update_image_content_slider($page_id, $id = null)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		$image = $this->input->post('image');
		$httpUrl = $this->input->post('httpUrl');

		// Remove Host URL in image
		// $find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;

		$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
		$image = str_replace($find_url, "", $image);
		$key = array(
			'image' => $image,
			'image_title' => $this->input->post('image-title') ,
			'image_alt' => $this->input->post('image-alt') ,
			'title_image' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))) ,
			'title_color' => $this->input->post('title-color') ,
			'title_position' => $this->input->post('title_position') ,
			'text' => $this->input->post('text') ,
			'content_color' => $this->input->post('content_color') ,
			'content_position' => $this->input->post('content_position') ,
			'background_color' => $this->input->post('background_color') ,
			'sort_order' => $this->input->post('sort_order') ,
			'status' => $status
		);

		// Convert to JSON data

		$keyJSON = json_encode($key);
		$add_edit_image_slider = $this->get_image_content_slider_by_id($website_id, $page_id);
		if (empty($id)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'content' => $keyJSON,
			);
			$this->db->insert($this->table_name, $insert_data);
			$this->session->set_flashdata('success', 'Successfully Created');
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'content' => $keyJSON,
			);
			$this->db->where(array(
				'website_id' => $website_id,
				'id' => $id,
				'page_id' => $page_id
			));
			$this->session->set_flashdata('success', 'Successfully Updated');
			return $this->db->update($this->table_name, $update_data);
		endif;
	}

	// Delete Image content slider by ID

	function delete_image_content_slider($page_id)
	{
		$id = $this->input->post('id');
		$this->db->where(array(
			'id' => $id,
			'page_id' => $page_id
		));
		return $this->db->update($this->table_name, array(
			'is_deleted' => 1
		));
	}

	// Delete Multiple Image Content slider

	function delete_multiple_image_content_slider()
	{
		$image_contents = $this->input->post('table_records');
		$page_id = $this->input->post('page_id');
		foreach($image_contents as $image_content):
			$this->db->where(array(
				'id' => $image_content,
				'page_id' => $page_id
			));
			$this->db->update($this->table_name, array(
				'is_deleted' => 1
			));
		endforeach;
	}

	// Remove Image

	function remove_image($website_id, $id, $data)
	{
		$remove_image_array = array(
			'content' => $data
		);
		$this->db->where(array(
			'website_id' => $website_id,
			'id' => $id
		));
		$this->db->update($this->table_name, $remove_image_array);
	}
}

?>