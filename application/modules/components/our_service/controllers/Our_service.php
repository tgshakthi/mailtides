<?php
/**
 * Our Service
 * Created at : 29-Oct-18
 * Author : saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Our_service extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Our_service_model');
		$this->load->module('setting');
	}

	function view($page_id)
	{
		$get_our_service_customization = $this->setting->get_setting('page_id', $page_id, 'our_service_customize');

		if (!empty($get_our_service_customization)) :
			$data['our_service_title'] = $get_our_service_customization['our_service_title'];
			$data['our_service_title_color'] = $get_our_service_customization['our_service_title_color'];
			$data['our_service_title_position'] = $get_our_service_customization['our_service_title_position'];
			$data['our_service_content'] = $get_our_service_customization['our_service_content'];
			$data['our_service_content_color'] = $get_our_service_customization['our_service_content_color'];
			$data['our_service_content_position'] = $get_our_service_customization['our_service_content_position'];
			$data['our_service_row_count'] = $get_our_service_customization['our_service_row_count'];
			$data['component_background'] = $get_our_service_customization['component_background'];
			$data['our_service_background'] = $get_our_service_customization['our_service_background'];
			$data['our_service_status'] = $get_our_service_customization['our_service_status'];
		else :
			$data['our_service_title'] = "";
			$data['our_service_title_color'] = "";
			$data['our_service_title_position'] = "";
			$data['our_service_content'] = "";
			$data['our_service_content_color'] = "";
			$data['our_service_content_position'] = "";
			$data['our_service_row_count'] = "";
			$data['component_background']  ="";
			$data['our_service_background'] = "";
			$data['our_service_status'] = "";
		endif;

		// Image Url
		$data['image_url'] = $this->setting->image_url();
		
		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['our_service_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['our_service_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;	

		$data['our_services'] = $this->Our_service_model->get_our_service($page_id);
		$this->load->view('our_service', $data);
	}
}
?>