<?php
/**
 * Slider Image Models
 *
 * @category Model
 * @package  Slider Image Model
 * @author   Karthika
 * Created at:  12-Dec-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Text_image_slider_model extends CI_Model
{
	private $setting_table = 'setting';
	private $table_name = 'text_image_slider';
	/**
	 * Get Text Image Slider
	 * return output as stdClass Object array
	 */
	function get_text_image_slider($page_id)
	{
		$this->db->select(array(
			'id',
			'page_id',
			'title',
			'image',
			'sort_order',
			'status'
		));
		$this->db->where(array(
			'page_id' => $page_id,
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

	// Get Text Image Slider by id

	function get_text_image_slider_by_id($page_id, $id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->where('page_id', $page_id);
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Insert Update Text Image Slider

	function insert_update_text_image_slider_data($page_id, $id = NULL)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$readmore_btn = $this->input->post('readmore_btn');
		$open_new_tab = $this->input->post('open_new_tab');
		$border = $this->input->post('border_status');
		$status = $this->input->post('status');
		$readmore_btn = (isset($readmore_btn)) ? '1' : '0';
		$open_new_tab = (isset($open_new_tab)) ? '1' : '0';
		$border = (isset($border)) ? '1' : '0';
		$status = (isset($status)) ? '1' : '0';
		$image = $this->input->post('image');
		$httpUrl = $this->input->post('httpUrl');
		// Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $image    = str_replace($find_url, "", $image);
		if ($id == NULL):

			// insert data

			$insert_data = array(
				'page_id' => $page_id,
				'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))) ,
				'title_color' => $this->input->post('title-color') ,
				'title_position' => $this->input->post('title_position') ,
				'image' => $image,
				'image_title' => $this->input->post('image-title') ,
				'image_alt' => $this->input->post('image-alt') ,
				'image_position' => $this->input->post('image_position') ,
				'text' => $this->input->post('text') ,
				'content_title_color' => $this->input->post('content-title-color') ,
				'content_title_position' => $this->input->post('content_title_position') ,
				'content_color' => $this->input->post('content-color') ,
				'readmore_btn' => $readmore_btn,
				'button_type' => $this->input->post('button_type') ,
				'btn_background_color' => $this->input->post('btn_background_color') ,
				'readmore_label' => $this->input->post('readmore_label') ,
				'label_color' => $this->input->post('label_color') ,
				'readmore_url' => $this->input->post('readmore_url') ,
				'open_new_tab' => $open_new_tab,
				'background_hover' => $this->input->post('background_hover') ,
				'text_hover' => $this->input->post('text_hover') ,
				'readmore_character' => $this->input->post('readmore_character') ,
				'border' => $border,
				'border_size' => $this->input->post('border_size') ,
				'border_color' => $this->input->post('border_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Insert into Text Image SLider

			$this->db->insert($this->table_name, $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))) ,
				'title_color' => $this->input->post('title-color') ,
				'title_position' => $this->input->post('title_position') ,
				'image' => $image,
				'image_title' => $this->input->post('image-title') ,
				'image_alt' => $this->input->post('image-alt') ,
				'image_position' => $this->input->post('image_position') ,
				'text' => $this->input->post('text') ,
				'content_title_color' => $this->input->post('content-title-color') ,
				'content_title_position' => $this->input->post('content_title_position') ,
				'content_color' => $this->input->post('content-color') ,
				'readmore_btn' => $readmore_btn,
				'button_type' => $this->input->post('button_type') ,
				'btn_background_color' => $this->input->post('btn_background_color') ,
				'readmore_label' => $this->input->post('readmore_label') ,
				'label_color' => $this->input->post('label_color') ,
				'readmore_url' => $this->input->post('readmore_url') ,
				'open_new_tab' => $open_new_tab,
				'background_hover' => $this->input->post('background_hover') ,
				'text_hover' => $this->input->post('text_hover') ,
				'readmore_character' => $this->input->post('readmore_character') ,
				'border' => $border,
				'border_size' => $this->input->post('border_size') ,
				'border_color' => $this->input->post('border_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Update into Text Image Slider

			$this->db->where('id', $id);
			$this->db->where('page_id', $page_id);
			return $this->db->update($this->table_name, $update_data);
		endif;
	}

	// Delete Text Image Slder

	function delete_text_image_slider($page_id)
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

	// Delete mulitple Text Image Slider

	function delete_multiple_text_image_slider()
	{
		$text_images = $this->input->post('table_records');
		$page_id = $this->input->post('page_id');
		foreach($text_images as $text_image):
			$this->db->where(array(
				'id' => $text_image,
				'page_id' => $page_id
			));
			$this->db->update($this->table_name, array(
				'is_deleted' => 1
			));
		endforeach;
	}

	// text image slider settings details

	function get_text_image_slider_setting_details_data($website_id, $page_id, $code)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));
		$query = $this->db->get($this->setting_table);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Insert Update text & image slider Title Details

	function insert_update_text_image_slider_title_data($page_id, $id = NULL)
	{
		$key = array(
			'text_image_slider_title',
			'text_image_slider_title_color',
			'text_image_slider_title_position',
			'text_image_slider_title_status'
		);
		$website_id = $this->input->post('website_id');
		$value[] = $this->input->post('text_image_slider_title');
		$value[] = $this->input->post('text_image_slider_title_color');
		$value[] = $this->input->post('text_image_slider_title_position');
		$status = $this->input->post('text_image_slider_title_status');
		$value[] = (isset($status)) ? '1' : '0';

		// Convert to JSON data

		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		$text_image_slider = $this->get_text_image_slider_setting_details_data($website_id, $page_id, 'text_image_slider_title');
		if (empty($text_image_slider)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'text_image_slider_title',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert($this->setting_table, $insert_data);
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
				'code' => 'text_image_slider_title',
				'page_id' => $page_id
			));
			$this->session->set_flashdata('success', 'Successfully Updated');
			return $this->db->update($this->setting_table, $update_data);
		endif;
	}

	// Insert Update text & image slider Customization

	function insert_update_text_image_slider_customize_data($page_id)
	{
		

		$keys = array(
			//'text_image_slider_background',
			'text_image_slider_background_color'
			//'text_image_slider_background_image'
		);

		$website_id = $this->input->post('website_id');
        // $image = $this->input->post('text_image_slider_background_image');
		// $httpUrl = $this->input->post('httpUrl');
		// $image = str_replace($httpUrl . '/', "", $image);

	//	$value[] = $this->input->post('text_image_slider_background');
		$value[] = $this->input->post('text_image_slider_background_color');
   // $value[] = $image;

		// Convert to JSON data

		$keyJSON = json_encode($keys);
		$valueJSON = json_encode($value);
		$provided_service = $this->get_text_image_slider_setting_details_data($website_id, $page_id, 'text_image_slider_customize');


		if (empty($provided_service)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'text_image_slider_customize',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			$this->db->insert($this->setting_table, $insert_data);
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
				'code' => 'text_image_slider_customize',
				'page_id' => $page_id
			));
			$this->session->set_flashdata('success', 'Successfully Updated');
			return $this->db->update($this->setting_table, $update_data);
		endif;
	}

	// Update Text Image  Slider Sort Order

	function update_sort_order($page_id, $row_sort_orders)
	{
		if (!empty($row_sort_orders)):
			$i = 1;
			foreach($row_sort_orders as $row_sort_order):
				$this->db->where('id', $row_sort_order);
				$this->db->update($this->table_name, array(
					'sort_order' => $i
				));
				$i++;
			endforeach;
		endif;
	}

	// Remove Image

	function remove_image()
	{
		$id = $this->input->post('id');
		$remove_image = array(
			'image' => ""
		);
		$this->db->where('id', $id);
		$this->db->update($this->table_name, $remove_image);
	}

	function remove_images()
	{
		$page_id = $this->input->post('id');
		$remove_images = array(
			'value' => ""
		);
		$this->db->where(array(
			'page_id' => $page_id,
			'code' => 'text_image_slider_background_image'
		));
		$this->db->update($this->table_setting, $remove_images);
	}
}
