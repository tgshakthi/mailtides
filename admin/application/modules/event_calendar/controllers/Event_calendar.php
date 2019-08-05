<?php
/**
 * Event calendar
 *
 * @category class
 * @package  Event calendar
 * @author   Velu Samy
 * Created at:  28-Sep-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Event_calendar extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Event_calendar_model');
		$this->load->module('admin_header');
		$this->load->module('color');

	}
	function event_calendar_index($page_id)
	{
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['title'] = "Event | Administrator";
		$data['heading'] = 'Event Calendar';
		$data['table'] = $this->get_table($page_id);

		$data['event_calendar_title'] = $this->Event_calendar_model->get_event_calendar_setting_details(
			$this->admin_header->website_id() ,
			$page_id,
			'event_calendar_title'
		);

		if (!empty($data['event_calendar_title']))
		{
			$keys = json_decode($data['event_calendar_title'][0]->key);
			$values = json_decode($data['event_calendar_title'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['event_calendar_title'] = '';
			$data['event_calendar_title_color'] = '';
			$data['event_calendar_title_position'] = '';
			$data['event_calendar_background_color'] = '';
			$data['event_calendar_status'] = '';
		}
		$this->load->view('template/meta_head', $data);
		$this->load->view('event_calendar_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	function get_table($page_id)
	{
		$event_calendars = $this->Event_calendar_model->get_event_calendar($page_id, $this->admin_header->website_id());
		if (isset($event_calendars) && $event_calendars != "")
		{
			foreach($event_calendars as $event_calendar)
			{
				$anchor_edit = anchor(site_url('event_calendar/add_edit_event_calendar/'.$page_id.'/'. $event_calendar->id) , '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>',
				 array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $event_calendar->id . ', \'' . base_url('event_calendar/delete_event_calendar/'.$page_id) . '\')'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . ' ' . $anchor_delete
				);

				if($event_calendar->status == 1) :
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				else:
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				endif;

				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $event_calendar->id . '">', ucwords($event_calendar->event_date_time) , $event_calendar->event_name, $status, $cell);
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
			id="datatable-checkbox"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">'
		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading(array(
			'<input type="checkbox" id="check-all" class="flat">',
			'Event Date&Time',
			'Event Title',
			'Status',
			'Action'
		));
		return $this->table->generate();

	}
	function insert_update_event_calendar_title()
	{
		$page_id = $this->input->post('page_id');
		$this->Event_calendar_model->insert_update_event_calendar_title_model($page_id);
		redirect('event_calendar/event_calendar_index/'.$page_id);
	}
	
	function add_edit_event_calendar($page_id, $id = Null)
	{
	 $data['page_id'] = $page_id;

		if ($id != Null)
		{
			$event_calendar = $this->Event_calendar_model->get_event_calendar_by_id($page_id, $id, $this->admin_header->website_id());

			$data['id'] 			= $event_calendar[0]->id;
			$data['date_time'] 	 	= $event_calendar[0]->event_date_time;
			$data['event_name'] 	= $event_calendar[0]->event_name;
			$data['event_details']  = $event_calendar[0]->event_details;
			$data['status']     	= $event_calendar[0]->status;
		}
		else
		{
			$data['id']            = "";
			$data['date_time']     = "";
			$data['event_name']    = "";
			$data['event_details'] = "";
			$data['status']        = "";
		}
		$data['title'] = ($id != Null) ? 'Edit Event Calendar' : 'Add Event Calendar' . ' | Administrator';
		$data['heading'] = (($id != Null) ? 'Edit' : 'Add') . ' Event Calendar';
		$data['website_id'] = $this->admin_header->website_id();
		$this->load->view('template/meta_head',$data);
		$this->load->view('event_calendar_header');
		$this->admin_header->index();
		$this->load->view('add_edit_event_calendar',$data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	function insert_update_event_calendar()
	{
		$id = $this->input->post('id');
		$page_id  = $this->input->post('page_id');
		$continue = $this->input->post('btn_continue');
		$error_config = array(
			array(
				'field' => 'date_time',
				'label' => 'Date && Time',
				'rules' => 'required'
			) ,
			array(
				'field' => 'event_name',
				'label' => 'Event Name',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('event_calendar/add_edit_event_calendar');
		}
		else
		{
			if (empty($id))
			{
				$this->Event_calendar_model->insert_update_event_calendar_model($page_id);
				$this->session->set_flashdata('success', 'Event successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'event_calendar/add_edit_event_calendar/'.$page_id;
				}
				else
				{
					$url = 'event_calendar/event_calendar_index/'.$page_id;
				}
			}
			else
			{
				$this->Event_calendar_model->insert_update_event_calendar_model($page_id, $id);
				$this->session->set_flashdata('success', 'Event Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'event_calendar/add_edit_event_calendar/'.$page_id.'/'. $id;
				}
				else
				{
					$url = 'event_calendar/event_calendar_index/'.$page_id;
				}
			}

			redirect($url);
		}
	}
	function delete_event_calendar()
	{
		$this->Event_calendar_model->delete_event_calendar_model($page_id);
		$this->session->set_flashdata('success', 'Successfully Deleted');
	}

	function delete_multiple_event_calendar($page_id)
	{

		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('event_calendar/event_calendar_index/'.$page_id);
		}
		else
		{
			$this->Event_calendar_model->delete_multiple_event_calendar_model($page_id);
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('event_calendar/event_calendar_index/'.$page_id);
		}
	}
}
?>
