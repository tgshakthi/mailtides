<?php
/**
 * Image Card
 *
 * @category class
 * @package  Image Card
 * @author   Saravana
 * Created at:  28-Jun-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Image_card extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Image_card_model');
		$this->load->module('setting');
	}

	/* Get Image Card */
	function view($page_id)
	{
		// Page URL
		$data['page_url'] = $this->setting->page_url();

		// Image Card Title
		$data_title_settings = $this->setting->get_setting('page_id', $page_id, 'image_card_title');

		if (!empty($data_title_settings)) :
			$data['image_card_title'] 			= $data_title_settings['image_card_title'];
			$data['image_card_title_color'] 	= $data_title_settings['image_card_title_color'];
			$data['image_card_title_position'] 	= $data_title_settings['image_card_title_position'];
			$data['image_card_title_status'] 	= $data_title_settings['image_card_title_status'];
		else :
			$data['image_card_title'] = '';
			$data['image_card_title_color'] = '';
			$data['image_card_title_position'] = '';
			$data['image_card_title_status'] = '';
		endif;

		// Image Card Customized data
		$data_customize_from_setting = $this->setting->get_setting('page_id', $page_id, 'image_card_customize');
		

		if (!empty($data_customize_from_setting)) :
			$data['count'] = $data_customize_from_setting['row_count'];
			$data['component_background'] = $data_customize_from_setting['component_background'];
			$data['image_card_background'] = $data_customize_from_setting['image_card_background'];
		else :
			$data['count'] = '';
			$data['component_background'] = '';
			$data['image_card_background'] = '';
		endif;
     	// Image Url
		$data['image_url'] = $this->setting->image_url();
		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['image_card_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['image_card_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;		
		$data['image_cards'] = $this->Image_card_model->get_image_card($page_id);
		$this->load->view('image_card', $data);
	}
}
