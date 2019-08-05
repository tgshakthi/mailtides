<?php
/**
 * Conclusion
 * Created at : 21-May-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Conclusion extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Conclusion_model');
	}

	/* Get Conclusion */
	function view($page_id)
	{
		$conclusions = $this->Conclusion_model->get_conclusion($page_id);
		if (!empty($conclusions))
		{
			foreach($conclusions as $conclusion)
			{
				$data['title'] = $conclusion->title;
				$data['title_position'] = $conclusion->title_position;
				$data['text'] = $conclusion->text;
				$data['content_position'] = $conclusion->content_position;
				$data['title_color'] = $conclusion->title_color;
				$data['content_color'] = $conclusion->content_color;
				$data['background'] = $conclusion->background;
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
		if (!empty($conclusions)) :
			$conclusion_bg = json_decode($conclusions[0]->background);
			if (!empty($conclusion_bg->component_background) && $conclusion_bg->component_background == 'image') :
				$data['bg_image'] = $data['image_url'] . $conclusion_bg->conclusion_background;
				$data['bg_color'] = "";
			elseif (!empty($conclusion_bg->component_background) && $conclusion_bg->component_background == 'color') :
				$data['bg_color'] = $conclusion_bg->conclusion_background;
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;
		$this->load->view('conclusion', $data);
	}
}

?>
