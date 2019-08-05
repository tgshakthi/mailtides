<?php
	/**
	* Top header Contact info view
	 *
	 * @category Model
	 * @package  contact information
	 * @author   Velu
	 * Created at:  21-Sep-18
	 */
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Contact_information_model extends CI_Model
{
	private $table_name = "contact_information";

	function get_contact_info($website_id)
	{
		$this->db->select('*');
		$this->db->where('website_id', $website_id);
		$query = $this->db->get($this->table_name);
		$records = array();
		if($query->num_rows() > 0) :
			$records = $query->result();
		endif;
		return $records;
	}

	/**
	 *	Contact information insert and Update
	 */
	function insert_update_contact_info_data($website_id, $id = NULL)
	{
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		
		if($id == NULL) :
			$insert_data = array(
				'website_id' => $website_id,
				'title' => $this->input->post('title'),
				'title_color' => $this->input->post('title_color'),
				'title_position' => $this->input->post('title_position'),
				'phone_no' => $this->input->post('phone_no'),
				'phone_no_title_color' => $this->input->post('phone_no_title_color'),
				'phone_title_hover_color' => $this->input->post('phone_title_hover_color'),
				'phone_icon' => $this->input->post('phone_icon'),
				'phone_icon_color' => $this->input->post('phone_icon_color'),
				'phone_icon_hover_color' => $this->input->post('phone_icon_hover_color'),
				'email' => $this->input->post('email'),
				'email_title_color' => $this->input->post('email_title_color'),
				'email_title_hover_color' => $this->input->post('email_title_hover_color'),
				'email_icon' => $this->input->post('email_icon'),
				'email_icon_color' => $this->input->post('email_icon_color'),
				'email_icon_hover_color' => $this->input->post('email_icon_hover_color'),
				'address' => $this->input->post('address'),
				'address_title_color' => $this->input->post('address_title_color'),
				'address_title_hover_color' => $this->input->post('address_title_hover_color'),
				'address_icon' => $this->input->post('address_icon'),
				'address_icon_color' => $this->input->post('address_icon_color'),
				'address_icon_hover_color' => $this->input->post('address_icon_hover_color'),
				'status' => $status
			);
	
			$this->db->insert($this->table_name, $insert_data);

		else:

			$update_data = array(
				'phone_no' => $this->input->post('phone_no'),
				'title' => $this->input->post('title'),
				'title_color' => $this->input->post('title_color'),
				'title_position' => $this->input->post('title_position'),
				'phone_icon' => $this->input->post('phone_icon'),
				'phone_no_title_color' => $this->input->post('phone_no_title_color'),
				'phone_title_hover_color' => $this->input->post('phone_title_hover_color'),
				'phone_icon_color' => $this->input->post('phone_icon_color'),
				'phone_icon_hover_color' => $this->input->post('phone_icon_hover_color'),
				'email' => $this->input->post('email'),
				'email_title_color' => $this->input->post('email_title_color'),
				'email_title_hover_color' => $this->input->post('email_title_hover_color'),
				'email_icon' => $this->input->post('email_icon'),
				'email_icon_color' => $this->input->post('email_icon_color'),
				'email_icon_hover_color' => $this->input->post('email_icon_hover_color'),
				'address' => $this->input->post('address'),
				'address_title_color' => $this->input->post('address_title_color'),
				'address_title_hover_color' => $this->input->post('address_title_hover_color'),
				'address_icon' => $this->input->post('address_icon'),
				'address_icon_color' => $this->input->post('address_icon_color'),
				'address_icon_hover_color' => $this->input->post('address_icon_hover_color'),
				'status' => $status
			);

			$this->db->where(array(
				'website_id' => $website_id,
				'id' => $id
			));

			$this->db->update($this->table_name, $update_data);
		endif;
	}
}
?>
