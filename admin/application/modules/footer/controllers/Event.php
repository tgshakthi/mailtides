<?php
/**
 * Event
 *
 * @category class
 * @package  Event
 * @author   Athi
 * Created at:  18-Aug-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Event extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Event_model');
		$this->load->module('admin_header');
		$this->load->module('Color');
	}

	/**
	 * Footer Event
	 * get table data from get table method
	 */

	function index()
	{
		
		$data['website_id'] = $this->admin_header->website_id();
		$data['events_unselected'] = $this->Event_model->get_event_unselected($data['website_id']);

		$events = $this->Event_model->get_event_setting($data['website_id'], 'footer_event');	
		
		
		if (!empty($events))
		{
			$data['setting_id'] = $events[0]->id;
			$keys = json_decode($events[0]->key);
			$values = json_decode($events[0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
			$data['events_unselected'] = $this->Event_model->get_event_unselected($data['website_id'], $data['event_id']);
			
			$data['events_selected'] = ($data['event_id'] != '') ? $this->Event_model->get_event_selected($data['website_id'], $data['event_id']): array();
		}
		else
		{
			$data['setting_id'] = '';
			$data['event_id'] 	= '';
			$data['status']	= '';
		}

		$data['heading']	= 'Footer Event';
		$data['title']	= "Footer Event | Administrator";		
		$this->load->view('template/meta_head', $data);
		$this->load->view('event_header');
		$this->admin_header->index();
		$this->load->view('event', $data);
		$this->load->view('template/footer_content');
		$this->load->view('event_script');
		$this->load->view('template/footer');
	}


	/**
	 *	Blog insert and Update
	 *  get table data from get table method
	 */

	function insert_update_footer_event()
	{
		$setting_id	= $this->input->post('setting_id');
		$website_id	= $this->input->post('website_id');

		$continue	= $this->input->post('btn_continue');

		if (empty($setting_id))
		{
			$insert_id	= $this->Event_model->insert_update_footer_event($website_id);
			$this->session->set_flashdata('success', 'Footer Event Successfully Created.');
		}
		else
		{
			$this->Event_model->insert_update_footer_event($website_id , $setting_id);
			$this->session->set_flashdata('success', 'Footer Event Successfully Updated.');
		}
		if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
		{
			$url = 'footer/event';
		}
		else
		{
			$url = 'footer';
		}
		redirect($url);
	}
}
