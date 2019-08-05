<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Image_content_slider extends MX_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('Image_content_slider_model');
			$this->load->module('setting');
		}

		function view($page_id)
		{
			
			
			/**
			 * Get Image content slider title data
			 *	return JSON data
			 */
			$image_content_slider_title_data = $this->setting->get_setting('page_id', $page_id, 'Image_content_slider_title');

			if(!empty($image_content_slider_title_data)) :
				$data['image_content_slider_title'] = $image_content_slider_title_data['image_content_slider_title'];
				$data['image_content_slider_content'] = $image_content_slider_title_data['image_content_slider_content'];
				$data['image_content_slider_title_status'] = $image_content_slider_title_data['image_content_slider_title_status'];
			else :
				$data['image_content_slider_title'] = '';
				$data['image_content_slider_content'] = '';
				$data['image_content_slider_title_status'] = '';
			endif;

			/**
			 * Get Image content slider customization
			 * return JSON data
			*/

			$image_content_customization = $this->setting->get_setting('page_id', $page_id, 'Image_content_slider_customize');
			if(!empty($image_content_customization)) :
				$data['title_color'] = $image_content_customization['title_color'];
				$data['title_position'] = $image_content_customization['title_position'];
				$data['content_title_color'] = $image_content_customization['content_title_color'];
				$data['content_title_position'] = $image_content_customization['content_title_position'];
				$data['content_color'] = $image_content_customization['content_color'];
				$data['content_position'] = $image_content_customization['content_position'];
				$data['image_content_slider_position'] = $image_content_customization['image_content_slider_position'];
				$data['row_count'] = $image_content_customization['row_count'];
				$data['component_background'] = $image_content_customization['component_background'];
			    $data['image_content_background'] = $image_content_customization['image_content_background'];
				$data['readmore_btn'] = $image_content_customization['readmore_btn'];
				$data['button_type'] = $image_content_customization['button_type'];
				$data['button_position'] = $image_content_customization['button_position'];
				$data['btn_background_color'] = $image_content_customization['btn_background_color'];
				$data['readmore_label'] = $image_content_customization['readmore_label'];
				$data['readmore_label_color'] = $image_content_customization['readmore_label_color'];
				$data['readmore_url'] = $image_content_customization['readmore_url'];
				$data['open_new_tab'] = $image_content_customization['open_new_tab'];
				$data['btn_background_hover'] = $image_content_customization['btn_background_hover'];
				$data['btn_label_hover'] = $image_content_customization['btn_label_hover'];
			else :
				$data['title_color'] = '';
				$data['title_position'] = '';
				$data['content_title_color'] = '';
				$data['content_title_position'] = '';
				$data['content_color'] = '';
				$data['content_position'] = '';
				$data['image_content_slider_position'] = '';
				$data['row_count'] = '';
				$data['component_background'] = '';
			    $data['image_content_background'] = '';
				$data['readmore_btn'] = '';
				$data['button_type'] = '';
				$data['button_position'] = '';
				$data['btn_background_color'] = '';
				$data['readmore_label'] = '';
				$data['readmore_label_color'] = '';
				$data['readmore_url'] = '';
				$data['open_new_tab'] = '';
				$data['btn_background_hover'] = '';
				$data['btn_label_hover'] = '';
			endif;
				// Image Url
		$data['image_url'] = $this->setting->image_url();
		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['image_content_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['image_content_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;	

			$data['image_content_slider_images'] = $this->Image_content_slider_model->get_image_slider_content($page_id);

			$this->load->view('image_condent_slider', $data);
		}
	}
?>
