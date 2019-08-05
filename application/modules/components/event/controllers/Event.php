<?php
/**
 * Event
 * Created at : 3-Aug-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Event extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();	
		$this->load->library('session');
		$this->load->model('Event_model');
		$this->load->module('setting');
		$this->load->module('header');
		$this->load->module('footer');
  	}
	
	/* Get Event */
  	function view($page_id)
  	{
		$data['website_id'] = $this->setting->website_id();
		$data['image_url'] = $this->setting->image_url();
		$data['page_id'] = $page_id;
		$data['page_url'] = $this->setting->page_url(); 
		$data['controller'] = $this;
		$data['events'] = $this->Event_model->get_event($data['website_id'], $page_id);
		$data['all_events'] = $this->Event_model->get_all_event($data['website_id']);
		$data['event_pages'] = $this->Event_model->get_event_page($data['website_id'], $page_id);
		$data['event_categories'] = $this->Event_model->get_event_category($data['website_id'], $page_id);

			// Image Url
			$data['image_url'] = $this->setting->image_url();

			// Background
			if (!empty($data['event_pages'])) :
				$event_bg = json_decode($data['event_pages'][0]->background);
				if (!empty($event_bg->component_background) && $event_bg->component_background == 'image') :
					$data['bg_image'] = $data['image_url'] . $event_bg->event_background;
					$data['bg_color'] = "";
				elseif (!empty($event_bg->component_background) && $event_bg->component_background == 'color') :
					$data['bg_color'] = $event_bg->event_background;
					$data['bg_image'] = "";
				else :
					$data['bg_color'] = '';
					$data['bg_image'] = '';
				endif;
			endif;
		$this->load->view('event', $data);
  	}
	
	// Subpage
	function subpage()
	{
		$data['website_id'] = $this->setting->website_id();
		$data['image_url'] = $this->setting->image_url();
		$data['url'] = $this->setting->page_url();
		$event_url = str_replace('event/', '', $data['url']);
		
		$event_page = $this->Event_model->get_event_by_url($data['website_id'], $event_url);
		if(!empty($event_page))
		{
			$data['event_id'] = $event_page[0]->id; 
			$data['category_id'] = $event_page[0]->category_id;
			$data['category_name'] = $event_page[0]->name;
			$data['title'] = $event_page[0]->title;
			$data['title_color'] = $event_page[0]->title_color;
			$data['title_hover_color'] = $event_page[0]->title_hover_color;
			$data['title_position'] = $event_page[0]->title_position;
			$data['image'] = $event_page[0]->image;
			$data['image_title'] = $event_page[0]->image_title;
			$data['image_alt'] = $event_page[0]->image_alt;
			$data['description'] = $event_page[0]->description;
			$data['description_title_color'] = $event_page[0]->description_title_color;
			$data['description_title_position'] = $event_page[0]->description_title_position;
			$data['description_color'] = $event_page[0]->description_color;
			$data['description_position'] = $event_page[0]->description_position;
			$data['description_title_hover_color'] = $event_page[0]->description_title_hover_color;
			$data['description_hover_color'] = $event_page[0]->description_hover_color;
			$data['date'] = $event_page[0]->date;
			$data['date_color'] = $event_page[0]->date_color;
			$data['background_color'] = $event_page[0]->background_color;
			$data['background_image'] = $event_page[0]->background_image;
			$data['location'] = $event_page[0]->location;
			$data['location_color'] = $event_page[0]->location_color;
		}
		else
		{
			$data['event_id'] = ''; 
			$data['category_id'] = '';
			$data['category_name'] = '';
			$data['title'] = '';
			$data['title_color'] = '';
			$data['title_hover_color'] = '';
			$data['title_position'] = '';
			$data['image'] = '';
			$data['image_title'] = '';
			$data['image_alt'] = '';
			$data['description'] = '';
			$data['description_title_color'] = '';
			$data['description_title_position'] = '';
			$data['description_color'] = '';
			$data['description_position'] = '';
			$data['description_title_hover_color'] = '';
			$data['description_hover_color'] = '';
			$data['date'] = '';
			$data['date_color'] = '';
			$data['background_color'] = '';
			$data['background_image'] = '';
			$data['location'] = '';
			$data['location_color'] = '';
		}
			// Background
			if (!empty($data['background'])) :
				$event_detail_bg = json_decode($data['background'][0]->background);
				if (!empty($event_detail_bg->component_background) && $event_detail_bg->component_background == 'image') :
					$data['bg_detail_image'] = $data['image_url'] . $event_detail_bg->event_background;
					$data['bg_detail_color'] = "";
				elseif (!empty($event_detail_bg->component_background) && $event_detail_bg->component_background == 'color') :
					$data['bg_detail_color'] = $event_detail_bg->event_background;
					$data['bg_detail_image'] = "";
				else :
					$data['bg_detail_color'] = '';
					$data['bg_detail_image'] = '';
				endif;
			endif;
		$this->header->index();
		$this->load->view('event_detail', $data);
		$this->footer->index();
	}
}
?>
