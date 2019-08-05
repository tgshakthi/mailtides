<?php
/**
 * Tab
 * Created at : 10-Aug-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tab extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();
		$this->load->library('session');
		$this->load->model('Tab_model');
		$this->load->module('setting');
		$this->load->module('header');
		$this->load->module('footer');
  	}

	/* Get Tab */
  	function view($page_id)
  	{
		$data['website_id'] = $this->setting->website_id();
		$data['image_url'] = $this->setting->image_url();
		// Tab Title
		$data_title_settings = $this->setting->get_setting('page_id', $page_id, 'tab');
		
		if (!empty($data_title_settings))
		{
			$data['tab_title'] = $data_title_settings['tab_title'];
			$data['title_color'] = $data_title_settings['title_color'];
			$data['title_position'] = $data_title_settings['title_position'];
			
			
			$data['component_background'] = $data_title_settings['component_background'];
			$data['tab_background'] = $data_title_settings['tab_background'];
			
			$data['status'] = $data_title_settings['status'];
		}
		else
		{
			$data['tab_title'] = '';
			$data['title_color'] = '';
			$data['title_position'] = '';
			
			
			$data['component_background'] = '';
			$data['tab_background'] = '';
			
			$data['status'] = '';
		}
		
	

		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['tab_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['tab_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;	
		
		$data['page_id'] = $page_id;
		$data['tabs'] = $this->Tab_model->get_tab($data['website_id'], $page_id);
		$this->load->view('tab', $data);
  	}
}
?>
