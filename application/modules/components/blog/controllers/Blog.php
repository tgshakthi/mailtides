<?php
/**
 * Blog
 * Created at : 23-July-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Blog extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();	
		$this->load->library('session');
		$this->load->model('Blog_model');
		$this->load->module('setting');
		$this->load->module('header');
		$this->load->module('footer');
		$this->load->module('mail');
  	}
	
	/* Get Blog */
  	function view($page_id)
  	{
		$data['website_id'] = $this->setting->website_id();
		$data['page_id'] = $page_id;
		$data['page_url'] = $this->setting->page_url(); 
		$data['controller'] = $this;
		$data['blogs'] = $this->Blog_model->get_blog($data['website_id'], $page_id);
		$data['all_blogs'] = $this->Blog_model->get_all_blog($data['website_id']);
		$data['blog_pages'] = $this->Blog_model->get_blog_page($data['website_id'], $page_id);
		$data['blog_categories'] = $this->Blog_model->get_blog_category($data['website_id'], $page_id);
		
		// Image Url
		$data['image_url'] = $this->setting->image_url();

		// Background
		if (!empty($data['blog_pages'])) :
			$blog_bg = json_decode($data['blog_pages'][0]->background);
			if (!empty($blog_bg->component_background) && $blog_bg->component_background == 'image') :
				$data['bg_image'] = $data['image_url'] . $blog_bg->blog_background;
				$data['bg_color'] = "";
			elseif (!empty($blog_bg->component_background) && $blog_bg->component_background == 'color') :
				$data['bg_color'] = $blog_bg->blog_background;
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;
		
		$this->load->view('blog', $data);
  	}
	
	// Subpage
	function subpage()
	{
		$data['website_id'] = $this->setting->website_id();
		$data['image_url'] = $this->setting->image_url();
		$data['url'] = $this->setting->page_url();
		$blog_url = str_replace('blog/', '', $data['url']);
		
		$blog_page = $this->Blog_model->get_blog_by_url($data['website_id'], $blog_url);
		if(!empty($blog_page))
		{
			$data['blog_id'] = $blog_page[0]->id; 
			$data['category_id'] = $blog_page[0]->category_id;
			$data['category_name'] = $blog_page[0]->name;
			$data['meta_title'] = $blog_page[0]->meta_title;
			$data['meta_keyword'] = $blog_page[0]->meta_keyword;
			$data['meta_description'] = $blog_page[0]->meta_description;
			$data['title'] = $blog_page[0]->title;
			$data['title_color'] = $blog_page[0]->title_color;
			$data['title_hover_color'] = $blog_page[0]->title_hover_color;
			$data['title_position'] = $blog_page[0]->title_position;
			$data['image'] = $blog_page[0]->image;
			$data['image_title'] = $blog_page[0]->image_title;
			$data['image_alt'] = $blog_page[0]->image_alt;
			$data['description'] = $blog_page[0]->description;
			$data['description_title_color'] = $blog_page[0]->description_title_color;
			$data['description_title_position'] = $blog_page[0]->description_title_position;
			$data['description_color'] = $blog_page[0]->description_color;
			$data['description_position'] = $blog_page[0]->description_position;
			$data['description_title_hover_color'] = $blog_page[0]->description_title_hover_color;
			$data['description_hover_color'] = $blog_page[0]->description_hover_color;
			$data['description_background_hover_color'] = $blog_page[0]->description_background_hover_color;
			$data['date'] = $blog_page[0]->date;
			$data['date_color'] = $blog_page[0]->date_color;
			$data['background_color'] = $blog_page[0]->background_color;
			$data['background_image'] = $blog_page[0]->background_image;
			$data['created_by'] = $blog_page[0]->created_by;
			
			$data['blog_ratings'] = $this->Blog_model->get_blog_rating($data['website_id'], $blog_page[0]->id);
		}
		else
		{
			$data['blog_ratings'] = array();
			$data['blog_id'] = ''; 
			$data['category_id'] = '';
			$data['category_name'] = '';
			$data['meta_title'] = '';
			$data['meta_keyword'] = '';
			$data['meta_description'] = '';
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
			$data['description_background_hover_color'] = '';
			$data['date'] = '';
			$data['date_color'] = '';
			$data['background_color'] = '';
			$data['background_image'] = '';
			$data['created_by'] = '';
		}
		
		$blog_rating_forms = $this->Blog_model->get_blog_rating_form($data['website_id']);
		if(!empty($blog_rating_forms))
		{
			$data['rating_form_id'] = $blog_rating_forms[0]->id;
			$data['rating_form_title'] = $blog_rating_forms[0]->title;
			$data['rating_form_title_color'] = $blog_rating_forms[0]->title_color;
			$data['rating_form_title_position'] = $blog_rating_forms[0]->title_position;
			$data['rating_form_title_hover'] = $blog_rating_forms[0]->title_hover;
			$data['label_color'] = $blog_rating_forms[0]->label_color;
			$data['comment_name_color'] = $blog_rating_forms[0]->comment_name_color;
			$data['label_hover'] = $blog_rating_forms[0]->label_hover;
			$data['comment_text_color'] = $blog_rating_forms[0]->comment_text_color;
			$data['button_label'] = $blog_rating_forms[0]->button_label;
			$data['button_type'] = $blog_rating_forms[0]->button_type;
			$data['button_position'] = $blog_rating_forms[0]->button_position;
			$data['button_background_color'] = $blog_rating_forms[0]->button_background_color;
			$data['button_label_color'] = $blog_rating_forms[0]->button_label_color;
			$data['button_background_hover'] = $blog_rating_forms[0]->button_background_hover;
			$data['button_label_hover'] = $blog_rating_forms[0]->button_label_hover;
			$data['border'] = $blog_rating_forms[0]->border;
			$data['border_size'] = $blog_rating_forms[0]->border_size;
			$data['border_color'] = $blog_rating_forms[0]->border_color;
			$data['border_hover'] = $blog_rating_forms[0]->border_hover;
		}
		else
		{
			$data['rating_form_id'] = '';
			$data['rating_form_title'] = '';
			$data['rating_form_title_color'] = '';
			$data['rating_form_title_position'] = '';
			$data['rating_form_title_hover'] = '';
			$data['label_color'] = '';
			$data['comment_name_color'] = '';
			$data['label_hover'] = '';
			$data['comment_text_color'] = '';
			$data['button_label'] = '';
			$data['button_type'] = '';
			$data['button_position'] = '';
			$data['button_background_color'] = '';
			$data['button_label_color'] = '';
			$data['button_background_hover'] = '';
			$data['button_label_hover'] = '';
			$data['border'] = '';
			$data['border_size'] = '';
			$data['border_color'] = '';
			$data['border_hover'] = '';
		}

		// Background
		if (!empty($data['background'])) :
			$blog_detail_bg = json_decode($data['background'][0]->background);
			if (!empty($blog_detail_bg->component_background) && $blog_detail_bg->component_background == 'image') :
				$data['bg_detail_image'] = $data['image_url'] . $blog_detail_bg->blog_background;
				$data['bg_detail_color'] = "";
			elseif (!empty($blog_detail_bg->component_background) && $blog_detail_bg->component_background == 'color') :
				$data['bg_detail_color'] = $blog_detail_bg->blog_background;
				$data['bg_detail_image'] = "";
			else :
				$data['bg_detail_color'] = '';
				$data['bg_detail_image'] = '';
			endif;
		endif;
		
		$this->header->index();
		$this->load->view('blog_detail', $data);
		$this->footer->index();
	}
	
	// Insert Blog Rating
	function insert_blog_rating()
	{
		$this->Blog_model->insert_blog_rating();
		$url = $this->input->post('url');
		
		$mailvalue = array();
		$website_id = $this->input->post('website_id');
		$mailvalue[1] = $this->input->post('name');
		$mailvalue[2] = $this->input->post('email');
		$mailvalue[3] = $this->input->post('comment');
		$mailvalue[4] = 
		(is_numeric($this->input->post('rating')) ? $this->input->post('rating').'/5': ($this->input->post('rating') != '' ? $this->input->post('rating'): ''));
		
		$rating_name = $this->input->post('rating_name');
		$rating_email = $this->input->post('rating_email');
		
		$mailvalue = implode(',', $mailvalue);
		
		$rating_mail_configures = $this->Blog_model->get_mail_configure($website_id);
		if(!empty($rating_mail_configures))
		{
			$mailvalueto = ($rating_mail_configures[0]->send_mail_to == 1) ? $this->input->post('email'): '';
		
			$send_mail = $this->mail->blog_rating_mail($website_id, $mailvalueto, $mailvalue);
			if(isset($rating_name) && isset($rating_email))
			{
				$this->mail->blog_rating_reply_mail($website_id, $rating_name, $rating_email);
			}
			
			if($send_mail == '')
			{
				$data['title'] = $rating_mail_configures[0]->success_title;
				$data['message'] = $rating_mail_configures[0]->success_message;
				$data['type'] = 'success';
				$data['code'] = 1;
				$data['page_url'] = $url;
				
				echo json_encode($data);
			}
			else
			{
				echo $url;
			}
		}
		else
		{
			echo $url;
		}
		
	}
}
?>