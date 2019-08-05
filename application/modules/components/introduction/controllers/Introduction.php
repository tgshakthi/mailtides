<?php
/**
 * Introduction
 * Created at : 18-May-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Introduction extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Introduction_model');
	}

	/* Get Introduction */
	function view($page_id)
	{
		$introductions = $this->Introduction_model->get_introduction($page_id);
		if (!empty($introductions))
		{
			foreach($introductions as $introduction)
			{
				$data['title'] = $introduction->title;
				$data['title_position'] = $introduction->title_position;
				$data['text'] = $introduction->text;
				$data['content_position'] = $introduction->content_position;
				$data['title_color'] = $introduction->title_color;
				$data['content_color'] = $introduction->content_color;
				$data['background'] = $introduction->background;
			}
		}
		else
		{
			$data['title'] = '';
			$data['title_position'] = '';
			$data['text'] = '';
			$data['content_position'] = '';
			$data['title_color'] = '';
			$data['content_color'] = '';
			$data['background'] = '';
		}
		
		$data['image_url'] = $this->setting->image_url();
		
		// Background
		if (!empty($introductions)) :
			$introduction_bg = json_decode($introductions[0]->background);
			if (!empty($introduction_bg->component_background) && $introduction_bg->component_background == 'image') :
				$data['bg_image'] = $data['image_url'] . $introduction_bg->introduction_background;
				$data['bg_color'] = "";
			elseif (!empty($introduction_bg->component_background) && $introduction_bg->component_background == 'color') :
				$data['bg_color'] = $introduction_bg->introduction_background;
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;
		$this->load->view('introduction', $data);
	}
}

?>