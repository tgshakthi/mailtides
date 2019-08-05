<?php
/**
 * Text icon
 *
 * @category class
 * @package  Text icon
 * @author   Saravana
 * Created at:  25-Jun-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Text_icon extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Text_icon_model');
		$this->load->module('setting');
	}

	/* Get Text Icon */
	function view($page_id)
	{

		// Text Icon Title

		$data_title_settings = $this->setting->get_setting('page_id', $page_id, 'text_icon_title');
		if (!empty($data_title_settings)):
			$data['text_icon_title'] = $data_title_settings['text_icon_title'];
			$data['text_icon_title_color'] = $data_title_settings['text_icon_title_color'];
			$data['text_icon_title_position'] = $data_title_settings['text_icon_title_position'];
			$data['text_icon_title_status'] = $data_title_settings['text_icon_title_status'];
		else:
			$data['text_icon_title'] = '';
			$data['text_icon_title_color'] = '';
			$data['text_icon_title_position'] = '';
			$data['text_icon_title_status'] = '';
		endif;

		// Text Icon Customized data

		$data_customize_from_setting = $this->setting->get_setting('page_id', $page_id, 'text_icon_customize');
		if (!empty($data_customize_from_setting)):
			$data['count'] = $data_customize_from_setting['row_count'];
			$data['component_background'] = $data_customize_from_setting['component_background'];
			$data['text_icon_background'] = $data_customize_from_setting['text_icon_background'];
		else:
			$data['count'] = '';
			$data['component_background'] = '';
			$data['text_icon_background'] = '';
		endif;
		$data['image_url'] = $this->setting->image_url();
		if ($data['component_background'] != ''):
			if ($data['component_background'] == 'image'):
				$data['bg_image'] = $data['image_url'] . $data['text_icon_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color'):
				$data['bg_color'] = $data['text_icon_background'];
				$data['bg_image'] = "";
			else:
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;
		$text = $this->Text_icon_model->get_text_icon($page_id);
		foreach($text as $texts):
			$data['text_icons'] = $texts;
		endforeach;
		$this->load->view('text_icon', $data);
	}
}