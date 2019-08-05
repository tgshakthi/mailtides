<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Counter extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Counter_model');
		$this->load->module('setting');
	}
	function view($page_id)
	{
		$data['image_url'] = $this->setting->image_url();		
		$counter_data = $this->setting->get_setting('page_id', $page_id, 'counter_image');
		if (!empty($counter_data)) :
			$data['counter_title_customize'] = $counter_data['counter_title_customize'];
			$data['counter_title_color_customize'] = $counter_data['counter_title_color_customize'];
			$data['counter_title_position_customize'] = $counter_data['counter_title_position_customize'];
			$data['counter_title_font_size_customize'] = $counter_data['counter_title_font_size_customize'];
			$data['counter_title_font_weight_customize'] = $counter_data['counter_title_font_weight_customize'];
			$data['component_background'] = $counter_data['component_background'];
			$data['counter_background'] = $counter_data['counter_background'];
			$data['counter_title_status_customize'] = $counter_data['counter_title_status_customize'];
		else :
			$data['background_image'] = "";
			$data['counter_title_customize'] = "";
			$data['counter_title_color_customize'] = "";
			$data['counter_title_position_customize'] = "";
			$data['counter_title_font_size_customize'] = "";
			$data['counter_title_font_weigh_customize'] = "";
			$data['component_background'] = "";
			$data['counter_background'] = "";
			$data['counter_title_status_customize'] = "";
		endif;		
		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['counter_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['counter_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;		
		$data['counters'] = $this->Counter_model->get_counter($page_id);
		$this->load->view('counter', $data);
	}
}

?>
