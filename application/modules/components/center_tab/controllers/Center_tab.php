<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Center_tab extends MX_Controller

{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Center_tab_model');
		$this->load->module('setting');
		$this->load->module('header');
		$this->load->module('footer');
	}

	/* Get Center Tab */
	function view($page_id)
	{
		$data['website_id'] = $this->setting->website_id();
		$data['image_url'] = $this->setting->image_url();

		// Tab Title

		$data_title_settings = $this->setting->get_setting('page_id', $page_id, 'center_tab');
		if (!empty($data_title_settings))
		{
			$data['tab_title'] = $data_title_settings['tab_title'];
			$data['title_color'] = $data_title_settings['title_color'];
			$data['title_position'] = $data_title_settings['title_position'];
			$data['component_background'] = $data_title_settings['component_background'];
			$data['center_tab_background'] = $data_title_settings['center_tab_background'];
			$data['status'] = $data_title_settings['status'];
		}
		else
		{
			$data['tab_title'] = '';
			$data['title_color'] = '';
			$data['title_position'] = '';
			$data['component_background'] = '';
			$data['center_tab_background'] = '';
			$data['status'] = '';
		}

		// Background

		if ($data['component_background'] != ''):
			if ($data['component_background'] == 'image'):
				$data['bg_image'] = $data['image_url'] . $data['center_tab_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color'):
				$data['bg_color'] = $data['center_tab_background'];
				$data['bg_image'] = "";
			else:
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;
		$data['page_id'] = $page_id;
		$data['center_tabs'] = $this->Center_tab_model->get_center_tab($data['website_id'], $page_id);
		$this->load->view('center_tab', $data);
	}
}

?>