<?php
/**
 * Contact
 *
 * @category class
 * @package  Contact
 * @author   Athi
 * Created at:  20-Jul-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Contact extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Contact_model');
		$this->load->module('admin_header');
		$this->load->module('Color');
	}

	/**
	 * Footer Contact
	 * get table data from get table method
	 */

	function index()
	{
		$data['website_id'] = $this->admin_header->website_id();
		
		$contact_us = $this->Contact_model->get_contact_setting($data['website_id'], 'footer_contact');
		if (!empty($contact_us))
		{
			$data['setting_id'] = $contact_us[0]->id;
			$keys = json_decode($contact_us[0]->key);
			$values = json_decode($contact_us[0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['setting_id'] = '';
			$data['contact_us'] 	= '';
			$data['contact_information']	= '';
			$data['status']	= '';
		}

		$data['heading']	= 'Footer Contact';
		$data['title']	= "Footer Contact | Administrator";
		
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_header');
		$this->admin_header->index();
		$this->load->view('contact', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}


	/**
	 *	Contact insert and Update
	 *  get table data from get table method
	 */

	function insert_update_footer_contact()
	{
		$setting_id	= $this->input->post('setting_id');
		$website_id	= $this->input->post('website_id');

		$continue	= $this->input->post('btn_continue');

		if (empty($setting_id))
		{
			$insert_id	= $this->Contact_model->insert_update_footer_contact($website_id);
			$this->session->set_flashdata('success', 'Footer Contact Successfully Created.');
		}
		else
		{
			$this->Contact_model->insert_update_footer_contact($website_id , $setting_id);
			$this->session->set_flashdata('success', 'Footer Contact Successfully Updated.');
		}
		if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
		{
			$url = 'footer/contact';
		}
		else
		{
			$url = 'footer';
		}
		redirect($url);

	}
}
