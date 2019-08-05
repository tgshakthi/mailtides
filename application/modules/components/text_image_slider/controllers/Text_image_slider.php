<?php
/**
 * Text Image Slider
 * Created at : 11-Dec-2018
 * Author : Karthika
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Text_image_slider extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Text_image_slider_model');
		$this->load->module('setting');
	}

	/* Get Text Image */
	function view($page_id)
	{
		$data['image_url'] = $this->setting->image_url();
	 //Text Image Slider
	 $data_title_settings = $this->setting->get_setting('page_id', $page_id, 'text_image_slider_title');

	 if (!empty($data_title_settings)) :
		 $data['text_image_slider_title'] = $data_title_settings['text_image_slider_title'];
		 $data['text_image_slider_title_color'] = $data_title_settings['text_image_slider_title_color'];
		 $data['text_image_slider_title_position'] = $data_title_settings['text_image_slider_title_position'];
		 $data['text_image_slider_title_status'] = $data_title_settings['text_image_slider_title_status'];
	 else :
		 $data['text_image_slider_title'] = '';
		 $data['text_image_slider_title_color'] = '';
		 $data['text_image_slider_title_position'] = '';
		 $data['text_image_slider_title_status'] = '';
	 endif;

	 // Text Image Slider Customized data
	 $customize = $this->setting->get_setting('page_id', $page_id, 'text_image_slider_customize');

	 if (!empty($customize)) :

		// $data['background_type'] = $customize['text_image_slider_background'];
		 $data['color']     =  $customize['text_image_slider_background_color'];
		// $data['image']     = $customize['text_image_slider_background_image'];
	 else :
		// $data['background_type'] = '';
		 $data['color'] ='';
		// $data['image'] ='';
	 endif;

		$data['text_images'] = $this->Text_image_slider_model->get_text_image_slider($page_id);

		$this->load->view('text_image_slider', $data);

	}
}

?>
