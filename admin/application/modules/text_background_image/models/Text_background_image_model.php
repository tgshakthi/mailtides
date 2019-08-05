<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Text_background_image_model extends CI_Model
{
	
	/**
	 * Get Text Background Image
	 * return output as stdClass Object array
	 */
	function get_text_background_image($page_id)
	{
		$this->db->select(array(
			'id',
			'page_id',
			'title',
			'sort_order',
			'status'
		));
		$this->db->where(array(
			'page_id' => $page_id,
			'is_deleted' => 0
		));
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('text_background_image');
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Get Text Image by id

	function get_text_background_image_by_id($page_id, $id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->where('page_id', $page_id);
		$query = $this->db->get('text_background_image');
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}
	
	// Insert Update Text Image

	function insert_update_text_background_image_data($page_id, $id = NULL)
	{
		$readmore_btn = $this->input->post('readmore_btn');
		$open_new_tab = $this->input->post('open_new_tab');
		$status = $this->input->post('status');
		$readmore_btn = (isset($readmore_btn)) ? '1' : '0';
		$open_new_tab = (isset($open_new_tab)) ? '1' : '0';
		$status = (isset($status)) ? '1' : '0';
		$website_folder_name = $this->admin_header->website_folder_name();
	    $image   = $this->input->post('image');
	    // $background_image = $this->input->post('image');    
	    $httpUrl = $this->input->post('httpUrl');
	  
	    $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
	    $background_image    = str_replace($find_url, "", $image);

		// Background 
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('text_bg_image_background_color');

		if (isset($background_image) && !empty($background_image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$text_image_background = str_replace($find_url, "", $background_image);
		else :
			$text_image_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;
		// Text and Background Image Background
        $text_image_background_bg = array(
            'component_background' => $component_background,
            'text_bg_image_background' => $text_image_background
        );
		
		
		if ($id == NULL):

			// insert data

			$insert_data = array(
				'page_id' => $page_id,
				'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
				'title_color' => $this->input->post('title-color') ,
				'title_position' => $this->input->post('title_position') ,
				'text' => $this->input->post('text') ,
				'content_title_color' => $this->input->post('content-title-color') ,
				'content_title_position' => $this->input->post('content_title_position') ,
				'content_color' => $this->input->post('content-color') ,
				'content_position' => $this->input->post('content_position') ,
				'background' => json_encode($text_image_background_bg),
				'text_position' => $this->input->post('text_position') ,
				'readmore_btn' => $readmore_btn,
				'button_type' => $this->input->post('button_type') ,
				'btn_background_color' => $this->input->post('btn_background_color') ,
				'readmore_label' => $this->input->post('readmore_label') ,
				'label_color' => $this->input->post('label_color') ,
				'readmore_url' => $this->input->post('readmore_url') ,
				'open_new_tab' => $open_new_tab,
				'background_hover' => $this->input->post('background_hover') ,
				'text_hover' => $this->input->post('text_hover'),
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Insert into Text Image

			$this->db->insert('text_background_image', $insert_data);
			return $this->db->insert_id();

		else:
			// Update data

			$update_data = array(
				'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))) ,
				'title_color' => $this->input->post('title-color') ,
				'title_position' => $this->input->post('title_position') ,
				'text' => $this->input->post('text') ,
				'content_title_color' => $this->input->post('content-title-color') ,
				'content_title_position' => $this->input->post('content_title_position') ,
				'content_color' => $this->input->post('content-color') ,
				'content_position' => $this->input->post('content_position') ,
				'background' => json_encode($text_image_background_bg),
				'text_position' => $this->input->post('text_position') ,
				'readmore_btn' => $readmore_btn,
				'button_type' => $this->input->post('button_type') ,
				'btn_background_color' => $this->input->post('btn_background_color') ,
				'readmore_label' => $this->input->post('readmore_label') ,
				'label_color' => $this->input->post('label_color') ,
				'readmore_url' => $this->input->post('readmore_url') ,
				'open_new_tab' => $open_new_tab,
				'background_hover' => $this->input->post('background_hover') ,
				'text_hover' => $this->input->post('text_hover') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Update into Text Image

			$this->db->where('id', $id);
			$this->db->where('page_id', $page_id);
			return $this->db->update('text_background_image', $update_data);
		endif;
	}
	
	// Delete Text Image

	function delete_text_background_image($page_id)
	{
		$id = $this->input->post('id');
		$this->db->where(array(
			'id' => $id,
			'page_id' => $page_id
		));
		return $this->db->update('text_background_image', array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple Text Image
	function delete_multiple_text_background_image()
	{
		$text_background_images = $this->input->post('table_records');
		$page_id = $this->input->post('page_id');
		foreach($text_background_images as $text_background_image):
			$this->db->where(array(
				'id' => $text_background_image,
				'page_id' => $page_id
			));
			$this->db->update('text_background_image', array(
				'is_deleted' => 1
			));
		endforeach;
	}	
}
?>