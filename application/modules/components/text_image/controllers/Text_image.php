<?php
/**
 * Text Image
 * Created at : 08-June-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Text_image extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Text_image_model');
		$this->load->module('Setting');
	}

	/* Get Text Image */
	function view($page_id)
	{
		$data['image_url'] = $this->setting->image_url();
		$text_image_background_data = $this->setting->get_setting('page_id', $page_id, 'text_image_background');
		
		if (!empty($text_image_background_data)) :
			$data['component_background'] = $text_image_background_data['component_background'];
			$data['text_image_background'] = $text_image_background_data['text_image_background'];
		else :	
			$data['component_background'] = "";
			$data['text_image_background'] = "";
		endif;
		
		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['text_image_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['text_image_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		else :
			$data['bg_color'] = '';
			$data['bg_image'] = '';
		endif;	
		$data['text_images'] = $this->Text_image_model->get_text_image($page_id);
		$this->load->view('text_image', $data);
	}
}

?>
