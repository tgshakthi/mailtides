<?php
/**
 * Testimonial
 * Created at : 17-Aug-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Testimonial extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();
		$this->load->library('session');
		$this->load->model('Testimonial_model');
		$this->load->module('setting');
		$this->load->module('header');
		$this->load->module('footer');
  	}

	/* Get Testimonial */
  	function view($page_id)
  	{
		
		
		$data['website_id'] = $this->setting->website_id();
		$data['image_url'] = $this->setting->image_url();
		$data['page_id'] = $page_id;
		$data['page_url'] = $this->setting->page_url();
		$data['controller'] = $this;
		$data['testimonials'] = $this->Testimonial_model->get_testimonial($data['website_id'], $page_id);
		$data['testimonial_pages'] = $this->Testimonial_model->get_testimonial_page($data['website_id'], $page_id);
		if(!empty($data['testimonial_pages'][0]->background)):
			
				$decode_background 		 = $data['testimonial_pages'][0]->background;
				$decode_background_value = json_decode($decode_background);
				
				if ($decode_background_value != '') :
					if ($decode_background_value->component_background == 'image') :
						$data['bg_image'] = $data['image_url'] . $decode_background_value->testimonial_background;
						$data['bg_color'] = "";
					elseif ($decode_background_value->component_background == 'color') :
						$data['bg_color'] = $decode_background_value->testimonial_background;
						$data['bg_image'] = "";
					else :
						$data['bg_color'] = '';
						$data['bg_image'] = '';
					endif;
				endif;
			endif;
		$this->load->view('testimonial', $data);
  	}

	// Subpage
	// function subpage()
	// {
	// 	$data['website_id'] = $this->setting->website_id();
	// 	$data['image_url'] = $this->setting->image_url();
	// 	$data['url'] = $this->setting->page_url();
	// 	$testimonial_url = str_replace('testimonial/', '', $data['url']);

	// 	$testimonial_page = $this->Testimonial_model->get_testimonial_by_url($data['website_id'], $testimonial_url);

	// 	if(!empty($testimonial_page))
	// 	{
	// 		$data['testimonial_id'] = $testimonial_page[0]->id;
	// 		$data['testimonial_image'] = $testimonial_page[0]->image;
	// 		$data['image_alt'] = $testimonial_page[0]->image_alt;
	// 		$data['image_title'] = $testimonial_page[0]->image_title;
	// 		$data['image_type'] = $testimonial_page[0]->image_type;
	// 		$data['author'] = $testimonial_page[0]->author;
	// 		$data['author_color'] = $testimonial_page[0]->author_color;
	// 		$data['author_hover'] = $testimonial_page[0]->author_hover;
	// 		$data['designation'] = $testimonial_page[0]->designation;
	// 		$data['designation_color'] = $testimonial_page[0]->designation_color;
	// 		$data['designation_hover'] = $testimonial_page[0]->designation_hover;
	// 		$data['content'] = $testimonial_page[0]->content;
	// 		$data['content_title_color'] = $testimonial_page[0]->content_title_color;
	// 		$data['content_title_position'] = $testimonial_page[0]->content_title_position;
	// 		$data['content_color'] = $testimonial_page[0]->content_color;
	// 		$data['content_position'] = $testimonial_page[0]->content_position;
	// 		$data['content_title_hover_color'] = $testimonial_page[0]->content_title_hover_color;
	// 		$data['content_hover_color'] = $testimonial_page[0]->content_hover_color;
	// 		$data['background_color'] = $testimonial_page[0]->background_color;
	// 	}
	// 	else
	// 	{
	// 		$data['testimonial_id'] = "";
	// 		$data['testimonial_image'] = "";
	// 		$data['image_alt'] = "";
	// 		$data['image_title'] = "";
	// 		$data['image_type'] = "";
	// 		$data['author'] = "";
	// 		$data['author_color'] = "";
	// 		$data['author_hover'] = "";
	// 		$data['designation'] = "";
	// 		$data['designation_color'] = "";
	// 		$data['designation_hover'] = "";
	// 		$data['content'] = "";
	// 		$data['content_title_color'] = "";
	// 		$data['content_title_position'] = "";
	// 		$data['content_color'] = "";
	// 		$data['content_position'] = "";
	// 		$data['content_title_hover_color'] = "";
	// 		$data['content_hover_color'] = "";
	// 	}

	// 	$this->header->index();
	// 	$this->load->view('testimonial_detail', $data);
	// 	$this->footer->index();
	// }
}
?>
