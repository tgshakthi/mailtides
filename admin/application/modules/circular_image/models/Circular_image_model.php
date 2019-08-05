<?php
/**
 * Circular Image Models
 *
 * @category Model
 * @package  Circular Image
 * @author   Saravana
 * Created at:  27-Jun-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Circular_image_model extends CI_Model
{
	private $table_name = 'circular_image';
	private $setting_table	= 'setting';

	/**
	 * Get Circular Image setting Details
	 * return output as stdClass Object array
	 */

	function get_circular_image_setting_details($website_id, $page_id, $code)
	{
		$this->db->select('*');

		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));

		$query = $this->db->get($this->setting_table);
		$records = array();

		if ($query->num_rows() > 0) :
				foreach ($query->result() as $row) :
					$records[] = $row;
				endforeach;
		endif;

		return $records;
	}

	/**
	 * Get Circular Image Details
	 * return output as stdClass Object array
	 */

	function get_circular_image($page_id)
	{
		$this->db->select(array(
			'id',
			'page_id',
			'image',
			'title',
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

	// Get Circular Image By Id
	function get_circular_image_by_id($page_id, $id)
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

	// Insert Update Circular Image Title Details

	function insert_update_circular_image_title_data($page_id, $id = NULL)
	{
		$key = array(
			'circular_image_title',
			'circular_image_title_color',
			'circular_image_title_position',
			'circular_image_title_status'
		);

		$website_id = $this->input->post('website_id');
		$value[] = $this->input->post('circular_image_title');
		$value[] = $this->input->post('title-color');
		$value[] = $this->input->post('circular_image_title_position');
		$status	= $this->input->post('circular_image_title_status');
		$value[]	= (isset($status)) ? '1' : '0';
		
		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$circular_images = $this->get_circular_image_setting_details($website_id, $page_id, 'circular_image_title');
		if (empty($circular_images)):
			// insert data
			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'circular_image_title',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			$this->db->insert($this->setting_table, $insert_data);
			$this->session->set_flashdata('success', 'Successfully Created');
			return $this->db->insert_id();
		else :
			// Update data
  		$update_data = array(
				'key'   => $keyJSON,
				'value'   => $valueJSON
			);

			$this->db->where(array('website_id' => $website_id, 'code' => 'circular_image_title', 'page_id' => $page_id));
			$this->session->set_flashdata('success', 'Successfully Updated');
		return $this->db->update($this->setting_table, $update_data);
		endif;
	}

	// Insert Update Circular Image Customization

	function insert_update_circular_image_customize_data($page_id)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('circular_image_background_color');
		$image = $this->input->post('image');
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$circular_background = str_replace($find_url, "", $image);
		else :
			$circular_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;		

		$key = array(
			'row_count',
			'component_background',
			'circular_image_background'
		);

		$value[] = $this->input->post('circular_image_row_count');
		$value[] = $this->input->post('component-background');
		$value[] = $circular_background;

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$circular_images = $this->get_circular_image_setting_details($website_id, $page_id, 'circular_image_customize');

		if (empty($circular_images)):
			// insert data
			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'circular_image_customize',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			$this->db->insert($this->setting_table, $insert_data);
			$this->session->set_flashdata('success', 'Successfully Created');		
			return $this->db->insert_id();
		else :
			// Update data
  			$update_data = array(
				'key'   => $keyJSON,
				'value'   => $valueJSON
			);

			$this->db->where(array('website_id' => $website_id, 'code' => 'circular_image_customize', 'page_id' => $page_id));			
			$this->db->update($this->setting_table, $update_data);
			return $this->session->set_flashdata('success', 'Successfully Updated');
		endif;
	}

	// Insert Update Circular Image

	function insert_update_circular_image_data($page_id, $id = NULL)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$redirect = $this->input->post('redirect');
		$open_new_tab = $this->input->post('open_new_tab');
		$status = $this->input->post('status');
		$redirect = (isset($redirect)) ? '1' : '0';
		$open_new_tab = (isset($open_new_tab)) ? '1' : '0';
		$status = (isset($status)) ? '1' : '0';
		$image = $this->input->post('image');
		$httpUrl = $this->input->post('httpUrl');

		// Remove Host URL in image
		//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
		
		$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
    $image    = str_replace($find_url, "", $image);

		if ($id == NULL) :
			// Insert data
			$insert_data = array(
				'page_id' => $page_id,
				'image' => $image,
				'image_position' => $this->input->post('image_position'),
				'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
				'title_color' => $this->input->post('title_color'),
				'title_hover_color' => $this->input->post('title_hover_color') ,
				'title_position' => $this->input->post('title_position') ,
				'content' => htmlspecialchars_decode(trim(htmlentities($this->input->post('content')))) ,
				'content_title_color' => $this->input->post('content_title_color'),
				'content_title_position' => $this->input->post('content_title_position'),
				'content_color' => $this->input->post('content_color'),
				'content_position' => $this->input->post('content_position'),
				'redirect' => $redirect,
				'redirect_url' => $this->input->post('redirect_url') ,
				'open_new_tab' => $open_new_tab ,
				'background_hover_color' => $this->input->post('background_hover'),
				'hover_title_color' => $this->input->post('title_hover_color'),
				'content_title_hover_color' => $this->input->post('content_title_hover_color'),
				'content_hover_color' => $this->input->post('content_hover_color'),
				'background_color' => $this->input->post('background_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

				// Insert into Circular Image

				$this->db->insert($this->table_name, $insert_data);
				return $this->db->insert_id();
		else :
			// Update Data
			$update_data = array(
				'image' => $image,
				'image_position' => $this->input->post('image_position'),
				'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
				'title_color' => $this->input->post('title_color'),
				'title_hover_color' => $this->input->post('title_hover_color') ,
				'title_position' => $this->input->post('title_position') ,
				'content' => htmlspecialchars_decode(trim(htmlentities($this->input->post('content')))) ,
				'content_title_color' => $this->input->post('content_title_color'),
				'content_title_position' => $this->input->post('content_title_position'),
				'content_color' => $this->input->post('content_color'),
				'content_position' => $this->input->post('content_position'),
				'redirect' => $redirect,
				'redirect_url' => $this->input->post('redirect_url') ,
				'open_new_tab' => $open_new_tab ,
				'background_hover_color' => $this->input->post('background_hover'),
				'hover_title_color' => $this->input->post('title_hover_color'),
				'content_title_hover_color' => $this->input->post('content_title_hover_color'),
				'content_hover_color' => $this->input->post('content_hover_color'),
				'background_color' => $this->input->post('background_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Update into Text Image

			$this->db->where('id', $id);
			$this->db->where('page_id', $page_id);
			return $this->db->update($this->table_name, $update_data);
		endif;
	}

	// Delete Circular Image

	function delete_circular_image($page_id)
	{
		$id = $this->input->post('id');

		$this->db->where(array(
			'id' => $id,
			'page_id' => $page_id
		));

		$this->db->update($this->table_name, array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple Circular Image

	function delete_multiple_circular_image_data()
	{
		$circular_images = $this->input->post('table_records');
		$page_id = $this->input->post('page_id');
		foreach($circular_images as $circular_image):
			$this->db->where(array(
				'id' => $circular_image,
				'page_id' => $page_id
			));
			$this->db->update($this->table_name, array(
				'is_deleted' => 1
			));
		endforeach;
	}
	
	// Update Circular Image Sort Order
	function update_sort_order($page_id, $row_sort_orders)
	{
		if(!empty($row_sort_orders)):
		
			$i = 1;
			foreach($row_sort_orders as $row_sort_order):
			
				$this->db->where('id', $row_sort_order);
				$this->db->update($this->table_name, array('sort_order' => $i));
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
}