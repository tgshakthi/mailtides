<?php
/**
 * Circular Image
 *
 * @category class
 * @package  Circular Image
 * @author   Saravana
 * Created at:  05-Jul-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Circular_image extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Circular_image_model');
		$this->load->module('setting');
	}

	/* Get Circular Image */
	function view($page_id)
	{
		// Circular Image Title
		$data_title_settings = $this->setting->get_setting('page_id', $page_id, 'circular_image_title');

		if (!empty($data_title_settings)) :
			$data['circular_image_title'] = $data_title_settings['circular_image_title'];
			$data['circular_image_title_color'] = $data_title_settings['circular_image_title_color'];
			$data['circular_image_title_position'] = $data_title_settings['circular_image_title_position'];
			$data['circular_image_title_status'] = $data_title_settings['circular_image_title_status'];
		else :
			$data['circular_image_title'] = '';
			$data['circular_image_title_color'] = '';
			$data['circular_image_title_position'] = '';
			$data['circular_image_title_status'] = '';
		endif;

		// Circular Image Customized data
		$data_customize_from_setting = $this->setting->get_setting('page_id', $page_id, 'circular_image_customize');

		if (!empty($data_customize_from_setting)) :
			$data['count'] = $data_customize_from_setting['row_count'];
			$data['component_background'] = $data_customize_from_setting['component_background'];
			$data['circular_image_background'] = $data_customize_from_setting['circular_image_background'];
		else :
			$data['count'] = '';
			$data['component_background'] = '';
			$data['circular_image_background'] = '';
		endif;

		// Image Url
		$data['image_url'] = $this->setting->image_url();

		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['circular_image_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['circular_image_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;		
		
		$data['circular_images'] = $this->Circular_image_model->get_circular_image($page_id);
		$this->load->view('circular_image', $data);
	}
}