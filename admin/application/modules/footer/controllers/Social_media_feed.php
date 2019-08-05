<?php
/**
 * Social_media_feed
 *
 * @category class
 * @package  Social_media_feed
 * @author   Shiva
 * Created at:  07-12-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Social_media_feed extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Social_media_feed_model');
		$this->load->module('admin_header');
		$this->load->module('Color');
	}

	/**
	 * Footer Social_media_feed
	 * get table data from get table method
	 */

	function index()
	{
		
		$data['website_id'] = $this->admin_header->website_id();

		$footer_social_media_feed = $this->Social_media_feed_model->get_footer_social_media_feed_setting($data['website_id'], 'footer_social_media_feed');
		
		
		
		if (!empty($footer_social_media_feed))
		{
			$data['setting_id'] = $footer_social_media_feed[0]->id;
			$keys = json_decode($footer_social_media_feed[0]->key);
			$values = json_decode($footer_social_media_feed[0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
			//$data['events_unselected'] = $this->Event_model->get_event_unselected($data['website_id'], $data['event_id']);
			
			//$data['events_selected'] = ($data['event_id'] != '') ? $this->Event_model->get_event_selected($data['website_id'], $data['event_id']): array();
		}
		else
		{
			$data['setting_id'] = '';
			$data['event_id'] 	= '';
			$data['status']	= '';
		}

		$data['heading']	= 'Footer Social Media Feed';
		$data['title']	= "Footer Social Media Feed | Administrator";		
		$this->load->view('template/meta_head', $data);
		$this->load->view('social_media_feed_header');
		$this->admin_header->index();
		$this->load->view('social_media_feed', $data);
		$this->load->view('template/footer_content');
		$this->load->view('social_media_feed_script');
		$this->load->view('template/footer');
	}


	/**
	 *	social_media_feed insert and Update
	 *  get table data from get table method
	 */

	function insert_update_footer_social_media_feed()
	{
		$setting_id	= $this->input->post('setting_id');
		$website_id	= $this->input->post('website_id');

		$continue	= $this->input->post('btn_continue');

		if (empty($setting_id))
		{
			$insert_id	= $this->Social_media_feed_model->insert_update_footer_social_media_feed($website_id);
			$this->session->set_flashdata('success', 'Footer social media feed Successfully Created.');
		}
		else
		{
			$this->Social_media_feed_model->insert_update_footer_social_media_feed($website_id , $setting_id);
			$this->session->set_flashdata('success', 'Footer social media feed Successfully Updated.');
		}
		if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
		{
			$url = 'footer/social_media_feed';
		}
		else
		{
			$url = 'footer';
		}
		redirect($url);
	}
}
