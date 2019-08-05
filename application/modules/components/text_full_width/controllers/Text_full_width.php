<?php
/**
 * Text Full Width
 * Created at : 21-May-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Text_full_width extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();
		
		$this->load->model('Text_full_width_model');
  	}
	
	/* Get Text Full Width */
  	function view($page_id)
  	{
		$text_full_widths = $this->Text_full_width_model->get_text_full_width($page_id);
		
		if (!empty($text_full_widths))
		{
			foreach ($text_full_widths as $text_full_width)
			{
				$data['title']	= $text_full_width->title;
				$data['title_color']	= $text_full_width->title_color;
				$data['title_position']	= $text_full_width->title_position;
				$data['full_text']	= $text_full_width->full_text;
				$data['content_title_color']	= $text_full_width->content_title_color;
				$data['content_title_position']	= $text_full_width->content_title_position;
				$data['content_color']	= $text_full_width->content_color;
				$data['content_position']	= $text_full_width->content_position;
				$data['background'] = $text_full_width->background;
			}
		}
		else
		{
			$data['title']	= '';
			$data['title_color']	= '';
			$data['title_position']	= '';
			$data['full_text']	= '';
			$data['content_title_color']	= '';
			$data['content_title_position']	= '';
			$data['content_color']	= '';
			$data['content_position']	= '';
			$data['background'] = '';
		}
		
		$data['image_url'] = $this->setting->image_url();
		
		// Background
		if (!empty($text_full_widths)) :
			$text_full_width_bg = json_decode($text_full_widths[0]->background);
			if (!empty($text_full_width_bg->component_background) && $text_full_width_bg->component_background == 'image') :
				$data['bg_image'] = $data['image_url'] . $text_full_width_bg->text_full_width_background;
				$data['bg_color'] = "";
			elseif (!empty($text_full_width_bg->component_background) && $text_full_width_bg->component_background == 'color') :
				$data['bg_color'] = $text_full_width_bg->text_full_width_background;
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;
		
		$this->load->view('text_full_width', $data);
  	}
}
?>
