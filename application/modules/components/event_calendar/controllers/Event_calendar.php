<?php
/**
 * Event Calendar
 * Created at :03-Oct-2018
 * Author : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Event_calendar extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Event_calendar_model');
		$this->load->module('setting');
	}

	// Get Event Calendar
	function view($page_id)
	{
		// Event Calendar Title
		$data_title_settings = $this->setting->get_setting('page_id', $page_id, 'event_calendar_title');

		if (!empty($data_title_settings)) :
			$data['event_calendar_title'] = $data_title_settings['event_calendar_title'];
			$data['event_calendar_title_color'] = $data_title_settings['event_calendar_title_color'];
			$data['event_calendar_title_position'] = $data_title_settings['event_calendar_title_position'];
			$data['event_calendar_background_color'] = $data_title_settings['event_calendar_background_color'];
			$data['event_calendar_title_status'] = $data_title_settings['event_calendar_status'];
		else :
			$data['event_calendar_title'] = '';
			$data['event_calendar_title_color'] = '';
			$data['event_calendar_title_position'] = '';
			$data['event_calendar_background_color'] = '';
			$data['event_calendar_title_status'] = '';
		endif;

		$data['events'] = $this->Event_calendar_model->get_event_calender($page_id);
		$this->load->view('view', $data);
	}
}

?>
