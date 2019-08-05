<?php
/**
 * Provided Services
 *
 * @category class
 * @package  Provided Services
 * @author   Saravana
 * Created at:  08-Dec-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Provided_services extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Provided_services_model');
		$this->load->module('setting');
	}

	/* Get Provided Services */
	function view($page_id)
	{
		// Provided Services Title
		$data_title_settings = $this->setting->get_setting('page_id', $page_id, 'provided_services_title');

		if (!empty($data_title_settings)) :
			$data['provided_services_title'] = $data_title_settings['provided_services_title'];
			$data['provided_services_title_color'] = $data_title_settings['provided_services_title_color'];
			$data['provided_services_title_position'] = $data_title_settings['provided_services_title_position'];
			$data['provided_services_title_status'] = $data_title_settings['provided_services_title_status'];
		else :
			$data['provided_services_title'] = '';
			$data['provided_services_title_color'] = '';
			$data['provided_services_title_position'] = '';
			$data['provided_services_title_status'] = '';
		endif;

		// Provided Services Customized data
		$data_customize_from_setting = $this->setting->get_setting('page_id', $page_id, 'provided_services_customize');

		if (!empty($data_customize_from_setting)) :
			$data['count'] = $data_customize_from_setting['row_count'];
			$data['component_background'] = $data_customize_from_setting['component_background'];
			$data['provided_services_background'] = $data_customize_from_setting['provided_services_background'];
		else :
			$data['count'] = '';
			$data['component_background'] = '';
			$data['provided_services_background'] = '';
		endif;
		$data['image_url'] = $this->setting->image_url();

		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['provided_services_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['provided_services_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;		

		$data['provided_services'] = $this->Provided_services_model->get_provided_services($page_id);

		$this->load->view('provided_services', $data);
	}
}
