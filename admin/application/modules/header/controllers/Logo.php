<?php
/**
 * Header Logo
 *
 * @category class
 * @package  Logo
 * @author   Shiva
 * Created at:  30-May-2018
 * 
 * Modified By : Saravana
 * Modified Date : 18-Feb-2019
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Logo extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Logo_model');
		$this->load->module('admin_header');
		$this->load->module('Color');
		$this->form_validation->CI = & $this;
	}

	/**
	 *Logo Deatsils
	 * get table data from get table method
	 */
	function index()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$website_id = $data['website_id'];
		$logo_details = $this->Logo_model->get_logo_details($website_id);
		if (!empty($logo_details))
		{
			foreach($logo_details as $logo_single_details)
			{
				$data['id'] = $logo_single_details->id;
				$data['website_name'] = $logo_single_details->website_name;
				$data['website_url'] = $logo_single_details->website_url;
				$data['logo'] = $logo_single_details->logo;
			}
		}

		$get_logo_settings_details = $this->Logo_model->get_logo_settings_details($website_id, 'logo');
		if (!empty($get_logo_settings_details))
		{
			foreach($get_logo_settings_details as $get_logo_single_details)
			{
				$data['code'] = $get_logo_single_details->code;
				$data['key'] = $get_logo_single_details->key;
				$jsn_logo_value = $get_logo_single_details->value;
				$js_logo_single_val = json_decode($jsn_logo_value, true);
			}
		}
		else
		{
			$data['code'] = "";
			$data['key'] = "";
			$jsn_logo_value = "";
			$js_logo_single_val = "";
		}

		if (!empty($js_logo_single_val[0]))
		{
			$data['js_logo_position'] = $js_logo_single_val[0];
			$data['js_logo_size'] = $js_logo_single_val[1];
		}
		else
		{
			$data['js_logo_position'] = "";
			$data['js_logo_size'] = "";
		}

		$data['heading'] = 'Logo';
		$data['title'] = "Logo | Administrator";
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$this->load->view('template/meta_head', $data);
		$this->load->view('logo_header');
		$this->admin_header->index();
		$this->load->view('logo_view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script_logo');
		$this->load->view('template/footer');
	}

	/**
	 * Logo insert and Update
	 */
	function insert_update_logo()
	{
		$continue = $this->input->post('btn_continue');
		$insert_id = $this->Logo_model->insert_update_logo();

		if (isset($continue) && $continue === "Add & Continue" || $continue === "Update & Continue")
		{
			$url = 'header/logo';
		}
		else
		{
			$url = 'header';
		}	

		redirect($url);
	}

	// Remove Logo Image
	function remove_logo_image()
	{
		$this->Logo_model->remove_logo();
		echo '1';
	}
}