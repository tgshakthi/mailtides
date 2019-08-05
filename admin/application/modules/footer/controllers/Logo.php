<?php
/**
 * Footer Logo
 *
 * @category class
 * @package  Logo
 * @author   Shiva
 * Created at:  07-June-2018
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
		$this->form_validation->CI =& $this;
	}

	/**
	 * Footer Logo Details
	 * get table data from get table method
	 */

	function index()
	{
		$data['website_id']	= $this->admin_header->website_id();
		$website_id 		= $data['website_id'];
		$logo_details		= $this->Logo_model->get_logo_details($website_id);

		if (!empty($logo_details))
		{
			foreach($logo_details as $logo_single_details)
			{
				$data['id'] 		  = $logo_single_details->id;
				$data['website_name'] = $logo_single_details->website_name;
				$data['website_url']  = $logo_single_details->website_url;
			}
		}

		$get_logo_settings_details    = $this->Logo_model->get_logo_settings_details($website_id,'footer-logo');
		if(!empty($get_logo_settings_details))
			{
				$keys 	= json_decode($get_logo_settings_details[0]->key);
				$values = json_decode($get_logo_settings_details[0]->value);
				$i = 0;
				foreach($keys as $key)
				{
					$data[$key] = $values[$i];
					$i++;
				}
			}
		else
			{
				$data['footer_logo_image'] = '';
				$data['footer_logo_size']   = '';
				$data['footer_logo_status'] 	= '';
			}

		$data['heading'] 	= 'Footer Logo';
		$data['title']		= "Footer Logo | Administrator";		
		$data['ImageUrl']	= $this->admin_header->image_url();
		$data['httpUrl']	= $this->admin_header->host_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$this->load->view('template/meta_head', $data);
		$this->load->view('logo_footer_header');
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
			$url = 'footer/logo';
		}
		else
		{
			$url = 'footer';
		}	

		redirect($url);
	}

}
