<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Center_tab_model extends CI_Model

{
	function get_center_tab($website_id, $page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'page_id' => $page_id,
			'is_deleted' => 0
		));
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('center_tab');
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	function get_center_tab_by_id($page_id, $id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'page_id' => $page_id,
			'id' => $id
		));
		$query = $this->db->get('center_tab');
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	function insert_update_center_tab($website_id, $page_id, $id = NULL)
	{
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'tab_name' => htmlspecialchars_decode(trim(htmlentities($this->input->post('tab_name')))) ,
				'tab_color' => $this->input->post('tab_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Insert into Center Tab

			$this->db->insert('center_tab', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'tab_name' => htmlspecialchars_decode(trim(htmlentities($this->input->post('tab_name')))) ,
				'tab_color' => $this->input->post('tab_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Update into Center Tab

			$this->db->where(array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'id' => $id
			));
			return $this->db->update('center_tab', $update_data);
		endif;
	}

	function get_center_tab_setting_details($website_id, $page_id, $code)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));
		$query = $this->db->get('setting');
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	function insert_update_center_tab_title($page_id, $id = NULL)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('center_tab_background_color');
		$image = $this->input->post('image');
		if (isset($image) && !empty($image) && $component_background == 'image'):

			// Remove Host URL in image
			// $find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;

			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$center_tab_background = str_replace($find_url, "", $image);
		else:
			$center_tab_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;
		$key = array(
			'tab_title',
			'title_color',
			'title_position',
			'component_background',
			'center_tab_background',
			'status'
		);
		$website_id = $this->input->post('website_id');
		$value[] = $this->input->post('tab_title');
		$value[] = $this->input->post('title_color');
		$value[] = $this->input->post('title_position');
		$value[] = $component_background;
		$value[] = $center_tab_background;
		$status = $this->input->post('status');
		$value[] = (isset($status)) ? '1' : '0';

		// Convert to JSON data

		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		$center_tabs = $this->get_center_tab_setting_details($website_id, $page_id, 'center_tab');
		if (empty($center_tabs)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'center_tab',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			$this->db->insert('setting', $insert_data);
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
				'code' => 'center_tab',
				'page_id' => $page_id
			));
			$this->session->set_flashdata('success', 'Successfully Updated');
			return $this->db->update('setting', $update_data);
		endif;
	}

	function delete_center_tab($page_id)
	{
		$id = $this->input->post('id');
		$this->db->where(array(
			'id' => $id,
			'page_id' => $page_id
		));
		return $this->db->update('center_tab', array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple Tab

	function delete_multiple_center_tab()
	{
		$center_tabs = $this->input->post('table_records');
		$page_id = $this->input->post('page_id');
		foreach($center_tabs as $center_tab):
			$this->db->where(array(
				'id' => $center_tab,
				'page_id' => $page_id
			));
			$this->db->update('center_tab', array(
				'is_deleted' => 1
			));
		endforeach;
	}

	function get_center_tab_text_image($page_id, $center_tab_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'center_tab_id' => $center_tab_id,
			'page_id' => $page_id,
			'is_deleted' => 0
		));
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('center_tab_text_image');
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	function get_center_tab_text_image_by_id($id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'id' => $id
		));
		$query = $this->db->get('center_tab_text_image');
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	function insert_update_center_tab_text_image($center_tab_id, $page_id, $id = NULL)
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
		// $find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;

		$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
		$image = str_replace($find_url, "", $image);
		if ($id == NULL):

			// insert data

			$insert_data = array(
				'page_id' => $page_id,
				'center_tab_id' => $center_tab_id,
				'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))) ,
				'title_color' => $this->input->post('title_color') ,
				'title_position' => $this->input->post('title_position') ,
				'image' => $image,
				'image_title' => $this->input->post('image_title') ,
				'image_alt' => $this->input->post('image_alt') ,
				'template' => $this->input->post('template') ,
				'image_position' => $this->input->post('image_pos') ,
				'image_size' => $this->input->post('image_size') ,
				'text' => $this->input->post('text') ,
				'content_title_color' => $this->input->post('content_title_color') ,
				'content_title_position' => $this->input->post('content_title_position') ,
				'content_color' => $this->input->post('content_color') ,
				'background_color' => $this->input->post('background_color') ,
				'readmore_btn' => $readmore_btn,
				'button_type' => $this->input->post('button_type') ,
				'btn_background_color' => $this->input->post('btn_background_color') ,
				'readmore_label' => $this->input->post('readmore_label') ,
				'label_color' => $this->input->post('label_color') ,
				'readmore_url' => $this->input->post('readmore_url') ,
				'open_new_tab' => $open_new_tab,
				'background_hover' => $this->input->post('background_hover') ,
				'text_hover' => $this->input->post('text_hover') ,
			     'border' => $border,
				'border_size' => $this->input->post('border_size') ,
				'border_color' => $this->input->post('border_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Insert into Center Tab Text Image

			$this->db->insert('center_tab_text_image', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))) ,
				'title_color' => $this->input->post('title_color') ,
				'title_position' => $this->input->post('title_position') ,
				'image' => $image,
				'image_title' => $this->input->post('image_title') ,
				'image_alt' => $this->input->post('image_alt') ,
				'template' => $this->input->post('template') ,
				'image_position' => $this->input->post('image_pos') ,
				'image_size' => $this->input->post('image_size') ,
				'text' => $this->input->post('text') ,
				'content_title_color' => $this->input->post('content_title_color') ,
				'content_title_position' => $this->input->post('content_title_position') ,
				'content_color' => $this->input->post('content_color') ,
				'background_color' => $this->input->post('background_color') ,
				'readmore_btn' => $readmore_btn,
				'button_type' => $this->input->post('button_type') ,
				'btn_background_color' => $this->input->post('btn_background_color') ,
				'readmore_label' => $this->input->post('readmore_label') ,
				'label_color' => $this->input->post('label_color') ,
				'readmore_url' => $this->input->post('readmore_url') ,
				'open_new_tab' => $open_new_tab,
				'background_hover' => $this->input->post('background_hover') ,
				'text_hover' => $this->input->post('text_hover') ,
				'border' => $border,
				'border_size' => $this->input->post('border_size') ,
				'border_color' => $this->input->post('border_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Update into Tab Text Image

			$this->db->where(array(
				'id' => $id,
				'page_id' => $page_id
			));
			return $this->db->update('center_tab_text_image', $update_data);
		endif;
	}

	function remove_image()
	{
		$id = $this->input->post('id');
		$remove_image = array(
			'image' => ""
		);
		$this->db->where('id', $id);
		$this->db->update('center_tab_text_image', $remove_image);
	}
}

?>