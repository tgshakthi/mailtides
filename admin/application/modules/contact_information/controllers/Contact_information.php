<?php
	/**
	 * Top header Contact info view
	 *
	 * @category class
	 * @package  contact information
	 * @author   Velu
	 * Created at:  21-Sep-18
	 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contact_information extends MX_Controller

{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Contact_information_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	function index()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$contact_info = $this->Contact_information_model->get_contact_info($data['website_id']);
		if (!empty($contact_info))
		{
			foreach($contact_info as $contact_information) :
				$data['id'] = $contact_information->id;
				$data['info_title'] = $contact_information->title;
				$data['title_color'] = $contact_information->title_color;
				$data['title_position'] = $contact_information->title_position;
				$data['phone_no'] = $contact_information->phone_no;
				$data['phone_no_title_color'] = $contact_information->phone_no_title_color;
				$data['phone_title_hover_color'] = $contact_information->phone_title_hover_color;
				$data['phone_icon'] = $contact_information->phone_icon;
				$data['phone_icon_color'] = $contact_information->phone_icon_color;
				$data['phone_icon_hover_color'] = $contact_information->phone_icon_hover_color;
				$data['email'] = $contact_information->email;
				$data['email_title_color'] = $contact_information->email_title_color;
				$data['email_title_hover_color'] = $contact_information->email_title_hover_color;
				$data['email_icon'] = $contact_information->email_icon;
				$data['email_icon_color'] = $contact_information->email_icon_color;
				$data['email_icon_hover_color'] = $contact_information->email_icon_hover_color;
				$data['address'] = $contact_information->address;
				$data['address_title_color'] = $contact_information->address_title_color;
				$data['address_title_hover_color'] = $contact_information->address_title_hover_color;
				$data['address_icon'] = $contact_information->address_icon;
				$data['address_icon_color'] = $contact_information->address_icon_color;
				$data['address_icon_hover_color'] = $contact_information->address_icon_hover_color;
				$data['status'] = $contact_information->status;
			endforeach;
		}
		else
		{
			$data['id'] = "";
			$data['info_title'] = "";
			$data['title_color'] = "";
			$data['title_position'] = "";
			$data['phone_no'] = "";
			$data['phone_no_title_color'] = "";
			$data['phone_title_hover_color'] = "";
			$data['phone_icon'] = "";
			$data['phone_icon_color'] = "";
			$data['phone_icon_hover_color'] = "";
			$data['email'] = "";
			$data['email_title_color'] = "";
			$data['email_title_hover_color'] = "";
			$data['email_icon'] = "";
			$data['email_icon_color'] = "";
			$data['email_icon_hover_color'] = "";
			$data['address'] = "";
			$data['address_title_color'] = "";
			$data['address_title_hover_color'] = "";
			$data['address_icon'] = "";
			$data['address_icon_color'] = "";
			$data['address_icon_hover_color'] = "";
			$data['status'] = "";
		}

		$data['title'] = 'Contact Information';
		$data['heading'] = 'Contact Information';
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_information_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	/**
	 *	Contact information insert and Update
	 */
	function insert_update_contact_info()
	{
		$id = $this->input->post('contact_id');
		$continue = $this->input->post('btn_continue');

		// $error_config = array(
		// 	// array(
		// 	// 	'field' => 'phone_no',
		// 	// 	'label' => 'Phone No',
		// 	// 	'rules' => 'required'
		// 	// ) ,
		// 	// array(
		// 	// 	'field' => 'email',
		// 	// 	'label' => 'Email',
		// 	// 	'rules' => 'required'
		// 	// ) ,
		// 	// array(
		// 	// 	'field' => 'address',
		// 	// 	'label' => 'Address',
		// 	// 	'rules' => 'required'
		// 	// ) ,
		// );

		// $this->form_validation->set_rules($error_config);

		// if ($this->form_validation->run() == FALSE)
		// {
		// 	$this->session->set_flashdata('error', validation_errors());
		// 	redirect('contact_information');
		// }
		// else
		// {
			if (empty($id) && empty($website_id))
			{
				$insert_id = $this->Contact_information_model->insert_update_contact_info_data($this->admin_header->website_id());
				$this->session->set_flashdata('success', 'Contact Information successfully Created');
				$url = 'contact_information';

			}
			else
			{
				$this->Contact_information_model->insert_update_contact_info_data($this->admin_header->website_id(), $id);
				$this->session->set_flashdata('success', 'Contact Information Successfully Updated.');
				$url = 'contact_information';
			}
			redirect($url);
		// }
	}
}
