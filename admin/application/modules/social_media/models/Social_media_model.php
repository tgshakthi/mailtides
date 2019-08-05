<?php
/**
 * Social Media Models
 *
 * @category Model
 * @package  Social media
 * @author   karthika
 * Created at: 19-sep-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Social_media_model extends CI_Model
{
	private $table_name = "social_media";
	/**
	 * Get social media
	 * return output as stdClass Object array
	 */
	function get_social_medias($website_id)
	{
		$this->db->select(array(
			'media_id',
			'media_name',
			'media_url',
			'icon',
			'sort_order',
			'status'
		));
		$this->db->where(
			array(
				'website_id' => $website_id,
				'is_deleted' => '0'
			));
		$this->db->order_by('media_id', 'desc');
		$query = $this->db->get($this->table_name);
		 $records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;

		return $records;
	}

	// Get Social media by id

	function get_media_by_id($id)
	{
		$this->db->select('*');
		$this->db->where('media_id', $id);
		$query = $this->db->get('social_media');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	function insert_update_media_data($media_id = NULL)
	{
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		if ($media_id == NULL):

			// insert data

			$insert_data = array(
				'website_id' => $this->input->post('website_id'),
				'media_name' => $this->input->post('media_title') ,
				'media_url' => $this->input->post('media_url') ,
				'icon' => $this->input->post('icon') ,
				'icon_color' => $this->input->post('media_icon_color') ,
				'icon_hover_color' => $this->input->post('media_icon_hover_color') ,
				'background_color' => $this->input->post('background_color') ,
				'background_hover_color' => $this->input->post('background_hover_color') ,
				'sort_order'   =>$this->input->post('sort_order'),
				'status' => $status
			);

			// Insert data

			 return $this->db->insert('social_media', $insert_data);
           else:

			// Update data

			$update_data = array(
				'website_id' => $this->input->post('website_id'),
				'media_name' => $this->input->post('media_title') ,
				'media_url' => $this->input->post('media_url') ,
				'icon' => $this->input->post('icon') ,
				'icon_color' => $this->input->post('media_icon_color') ,
				'icon_hover_color' => $this->input->post('media_icon_hover_color') ,
				'background_color' => $this->input->post('background_color') ,
				'background_hover_color' => $this->input->post('background_hover_color') ,
				'sort_order'   =>$this->input->post('sort_order'),
				'status' => $status
			);

			// Update

			$this->db->where('media_id', $media_id);
			return $this->db->update('social_media', $update_data);
		endif;
	}
	//Delete social media by id

	function delete_social_media_data()
	{
		$media_id = $this->input->post('id');
		$data = array(
			'is_deleted' => '1'
		);
		$this->db->where('media_id', $media_id);
		return $this->db->update('social_media', $data);
	}

	// Delete mulitple data Using CheckBoxes(Social media)

	function delete_multiple_social_data()
	{
		$media_ids = $this->input->post('table_records');
			foreach($media_ids as $media_id):
				$data = array(
					'is_deleted' => '1'
				);
				$this->db->where('media_id', $media_id);
				$this->db->update('social_media', $data);
			endforeach;
	}


}

?>
