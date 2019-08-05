<?php
/**
 * Testimonial Models
 *
 * @category Model
 * @package  Testimonial
 * @author   Athi
 * Created at:  14-Aug-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Testimonial_model extends CI_Model
{
	/**
	 * Get Testimonial
	 * return output as stdClass Object array
	 */
	function get_testimonial($website_id)
	{
		$this->db->select(array(
			'id',
			'website_id',
			'author',
			'image',
			'sort_order',
			'status'
		));
		$this->db->where(array('website_id' => $website_id, 'is_deleted' => 0));
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('testimonial');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get Testimonial by @param
	 * return output as stdClass Object array
	 */
	function get_testimonial_by_id($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('testimonial');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get Testimonial Page by @param
	 * return output as stdClass Object array
	 */
	function get_testimonial_page_by_id($website_id, $page_id)
	{
		$this->db->select('*');
		$this->db->where(array('website_id' => $website_id, 'page_id' => $page_id));
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('testimonial_pages');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Unselected Testimonials
	function get_testimonial_unselected($website_id, $page_id)
	{
		$query = $this->db->query('
			SELECT
				a.id, a.author, a.content
			FROM
				'.$this->db->dbprefix('testimonial').' a, '.$this->db->dbprefix('testimonial_pages').' b
			WHERE
				b.page_id = '. $page_id .' AND
				a.website_id = '.$website_id.' AND
				a.status = 1 AND
				a.is_deleted = 0 AND
				b.website_id = '.$website_id.' AND
				!FIND_IN_SET(a.id, b.testimonial)'
		);

		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Selected Testimonials
	function get_testimonial_selected($website_id, $page_id)
	{
  		$query = $this->db->query("
			SELECT
				a.id, a.author, a.content
		  	FROM
				".$this->db->dbprefix("numbers")." c
			INNER JOIN
				".$this->db->dbprefix("testimonial_pages")." b
			ON
				CHAR_LENGTH(b.testimonial) - CHAR_LENGTH(REPLACE(b.testimonial, ',', '')) >= c.n - 1
            INNER JOIN
				".$this->db->dbprefix("testimonial")." a
			ON
				SUBSTRING_INDEX(SUBSTRING_INDEX(b.testimonial, ',', c.n), ',', -1) = a.id
           	WHERE
				a.website_id = ".$website_id."
			AND
				a.status = 1
			AND
				a.is_deleted = 0
			AND
				b.website_id = ".$website_id."
			AND
				b.page_id = ".$page_id."
		");

		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Insert Update Testimonial
	function insert_update_testimonial($id = NULL)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id	= $this->input->post('website_id');
		$open_new_tab	= $this->input->post('open_new_tab');
		$redirect	= $this->input->post('redirect');
		$status	= $this->input->post('status');

		$open_new_tab	= (isset($open_new_tab)) ? '1' : '0';
		$redirect	= (isset($redirect)) ? '1' : '0';
		$status	= (isset($status)) ? '1' : '0';

		$image = $this->input->post('image');
		$httpUrl = $this->input->post('httpUrl');
		// Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $image    = str_replace($find_url, "", $image);

		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'image' => $image,
				'image_alt' => $this->input->post('image_alt'),
				'image_title' => $this->input->post('image_title'),
				'image_type' => $this->input->post('image_type'),
				'author' => htmlspecialchars_decode(trim(htmlentities($this->input->post('author')))),
				'author_color' => $this->input->post('author_color'),
				'author_hover' => $this->input->post('author_hover') ,
				'designation' => $this->input->post('designation') ,
				'designation_color' => $this->input->post('designation_color') ,
				'designation_hover' => $this->input->post('designation_hover') ,
				'content' => htmlspecialchars_decode(trim(htmlentities($this->input->post('content')))) ,
				'content_title_color' => $this->input->post('content_title_color'),
				'content_title_position' => $this->input->post('content_title_position'),
				'content_color' => $this->input->post('content_color'),
				'content_position' => $this->input->post('content_position'),
				'redirect' => $redirect,
				'redirect_url' => $this->input->post('redirect_url') ,
				'open_new_tab' => $open_new_tab ,
				'background_hover_color' => $this->input->post('background_hover'),
				'content_title_hover_color' => $this->input->post('content_title_hover_color'),
				'content_hover_color' => $this->input->post('content_hover_color'),
				'background_color' => $this->input->post('background_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Insert into Testimonial

			$this->db->insert('testimonial', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'image' => $image,
				'image_alt' => $this->input->post('image_alt'),
				'image_title' => $this->input->post('image_title'),
				'image_type' => $this->input->post('image_type'),
				'author' => htmlspecialchars_decode(trim(htmlentities($this->input->post('author')))),
				'author_color' => $this->input->post('author_color'),
				'author_hover' => $this->input->post('author_hover') ,
				'designation' => $this->input->post('designation') ,
				'designation_color' => $this->input->post('designation_color') ,
				'designation_hover' => $this->input->post('designation_hover') ,
				'content' => htmlspecialchars_decode(trim(htmlentities($this->input->post('content')))) ,
				'content_title_color' => $this->input->post('content_title_color'),
				'content_title_position' => $this->input->post('content_title_position'),
				'content_color' => $this->input->post('content_color'),
				'content_position' => $this->input->post('content_position'),
				'redirect' => $redirect,
				'redirect_url' => $this->input->post('redirect_url') ,
				'open_new_tab' => $open_new_tab ,
				'background_hover_color' => $this->input->post('background_hover'),
				'content_title_hover_color' => $this->input->post('content_title_hover_color'),
				'content_hover_color' => $this->input->post('content_hover_color'),
				'background_color' => $this->input->post('background_color') ,
				'sort_order' => $this->input->post('sort_order') ,
				'status' => $status
			);

			// Update into Testimonial

			$this->db->where(array('id' => $id, 'website_id' => $website_id));
			return $this->db->update('testimonial', $update_data);
		endif;
	}

	// Insert Update Testimonial Page
	function insert_update_testimonial_page($id = NULL)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('testimonial_background_color');
		$image = $this->input->post('image');
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$testimonial_background = str_replace($find_url, "", $image);
		else :
			$testimonial_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;		

		$background_ary = array(
			
			'component_background' => $component_background,
			'testimonial_background' => $testimonial_background
		);
		$json_decode_background_value = json_encode($background_ary);
		$data_array = $this->input->post('output_update');
		$result = json_decode($data_array);

		$testimonials = (!empty($result)) ? implode(',', array_column($result, 'id')): '';

		$website_id	= $this->input->post('website_id');
		$page_id	= $this->input->post('page_id');
		$status	= $this->input->post('status');
		$status	= (isset($status)) ? '1' : '0';

		if($id == NULL):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'testimonial' => $testimonials,
				'title' => $this->input->post('title'),
				'title_color' => $this->input->post('title_color'),
				'title_position' => $this->input->post('title_position'),
				'testimonial_per_row' => $this->input->post('testimonial_per_row'),
				'background' => $json_decode_background_value,
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Insert into Testimonial Page

			$this->db->insert('testimonial_pages', $insert_data);
			return $this->db->insert_id();

		else:

			// Update data

			$update_data = array(
				'testimonial' => $testimonials,
				'title' => $this->input->post('title'),
				'title_color' => $this->input->post('title_color'),
				'title_position' => $this->input->post('title_position'),
				'testimonial_per_row' => $this->input->post('testimonial_per_row'),
				//'background_color' => $this->input->post('background_color'),
				'background' => $json_decode_background_value,
				'status' => $status
			);
			
		
			// Update into Testimonial Page

			$this->db->where(array('id' => $id, 'website_id' => $website_id, 'page_id' => $page_id));
			return $this->db->update('testimonial_pages', $update_data);

		endif;
	}

	// Update Testimonial Sort Order
	function update_sort_order($website_id, $row_sort_orders)
	{
		if(!empty($row_sort_orders)):

			$i = 1;
			foreach($row_sort_orders as $row_sort_order):

				$this->db->where(array('id' => $row_sort_order, 'website_id' => $website_id));
				$this->db->update('testimonial', array('sort_order' => $i));
				$i++;

			endforeach;

		endif;
	}

	// Delete Testimonial
	function delete_testimonial()
	{
		$id = $this->input->post('id');
		$this->db->where(array(
			'id' => $id
		));
		return $this->db->update('testimonial', array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple Testimonial

	function delete_multiple_testimonial()
	{
		$testimonials = $this->input->post('table_records');
		$website_id = $this->input->post('website_id');
		foreach($testimonials as $testimonial):
			$this->db->where(array(
				'id' => $testimonial,
				'website_id' => $website_id
			));
			$this->db->update('testimonial', array(
				'is_deleted' => 1
			));
		endforeach;
	}

	// Remove Image
	function remove_testimonial_image()
	{
		$id = $this->input->post('id');
		$remove_image = array(
			'image' => ""
		);
		$this->db->where('id', $id);
		$this->db->update('testimonial', $remove_image);
	}
}
