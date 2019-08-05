<?php
/**
 * Provided Services
 *
 * @category class
 * @package  Provided Services
 * @author   Karthika
 * Created at:  03-Dec-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Provided_services extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Provided_services_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	/**
	 * Display all Pages in a table
	 * get table data from get table method
	 */
	function provided_service_index($page_id)
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();

			// Get provided services customize details from settings

			$data['provided_services_title_data'] = $this->Provided_services_model->get_Provided_services_setting_details_data(
				$this->admin_header->website_id() ,
				$page_id,
				'provided_services_title'
			);

			// Get customized provided service details from settings

			$data['provided_services_customize_data'] = $this->Provided_services_model->get_Provided_services_setting_details_data(
				$this->admin_header->website_id() ,
				$page_id,
				'provided_services_customize'
			);

			// Provided Services title details from settings

			if (!empty($data['provided_services_title_data']))
			{
				$keys = json_decode($data['provided_services_title_data'][0]->key);
				$values = json_decode($data['provided_services_title_data'][0]->value);
				$i = 0;
				foreach($keys as $key)
				{
					$data[$key] = $values[$i];
					$i++;
				}
			}
			else
			{
				$data['provided_services_title'] = '';
				$data['provided_services_title_color'] = '';
				$data['provided_services_title_position'] = '';
				$data['provided_services_title_status'] = '';
			}

			// Provided Services Customize details from settings

			if (!empty($data['provided_services_customize_data']))
			{
				$keys = json_decode($data['provided_services_customize_data'][0]->key);
				$values = json_decode($data['provided_services_customize_data'][0]->value);
				$i = 0;
				foreach($keys as $key)
				{
					$data[$key] = $values[$i];
					$i++;
				}
			}
			else
			{
				$data['row_count'] = '';
				$data['component_background'] = '';
				$data['provided_services_background'] = '';
			}


		$data['table'] = $this->get_table($page_id);
		$data['heading'] = "Provided services";
		$data['title'] = "provided services | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('provided_services_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	function update_sort_order()
	{
		$page_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Provided_services_model->update_sort_order($page_id, $row_sort_order);
	}

	// Insert & Update Provided Services Title

	function insert_update_provided_service_data()
	{
		$page_id = $this->input->post('page-id');
		$this->Provided_services_model->insert_update_provided_service_title_data($page_id);
		redirect('provided_services/provided_service_index/' . $page_id);		
	}

	// Insert & Update Provided Services Customization

	function insert_provided_service_customize()
	{
		$page_id = $this->input->post('page-id');
		$this->Provided_services_model->insert_update_provided_service_customize_data($page_id);
		redirect('provided_services/provided_service_index/' . $page_id);
	}


	/**
	 * Table
	 * get all data from model
	 * generate data table
	 * with multiple delete option
	 **/
	function get_table($page_id)
	{
		$provided_services = $this->Provided_services_model->get_page_cities_url($page_id);
		if (!empty($provided_services))
		{
			foreach($provided_services as $provided_service)
			{
				if ($provided_service->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$this->table->add_row(ucwords($provided_service->title) , $provided_service->url, $provided_service->name, $status);
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

		$this->table->set_heading('Title', 'Page Url', 'City', 'Page Status');
		return $this->table->generate();
	}

	/**
	 * Add Edit
	 * redirect to pages based on @param
	 */
	function add_edit_provided_service($page_id)
	{
		$data['page_id'] = $page_id;
		$website_id = $this->admin_header->website_id();
		$data['page_url'] = $this->Provided_services_model->get_page_url($page_id);
		$data['cities'] = $this->Provided_services_model->get_cities();
		$data['provided_services_data'] = $this->Provided_services_model->get_page_cities_url($page_id);

		if(!empty($data['provided_services_data'])) :
			foreach($data['provided_services_data'] as $selected_citites) :
				$data['selected_cities'][] = $selected_citites->id;
			endforeach;
		else :
			$data['page_ids'] = '';
			$data['selected_cities'] = array();
		endif;

		$data['title'] = 'Provided Service | Administrator';
		$data['heading'] = 'Provided Services';
		$this->load->view('template/meta_head', $data);
		$this->load->view('provided_services_header');
		$this->admin_header->index();
		$this->load->view('add_edit_provided_services', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	/**
	 * Insert Update Page
	 */
	function insert_update_provided_service()
	{
		$page_id = $this->input->post('page_id');
		$website_id = $this->admin_header->website_id();
		$continue = $this->input->post('btn_continue');

		$error_config = array(
			array(
				'field' => 'cities[]',
				'label' => 'Cities',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($error_config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('provided_services/add_edit_provided_service/' . $page_id);
		}
		else
		{
			$this->Provided_services_model->insert_update_provided_services($website_id);
			$this->session->set_flashdata('success', 'Provided Services successfully Added');
			if (isset($continue) && $continue === "Add & Continue")
			{
				$url = 'provided_services/add_edit_provided_service/' . $page_id;
			}
			else
			{
				$url = 'provided_services/provided_service_index/' . $page_id;
			}
		}
			redirect($url);
	}

	/**
	 * Delete record
	 * Delete record by @param
	 */
	function delete_provided_service()
	{
		$this->Provided_services_model->delete_provided_service();
		$this->session->set_flashdata('success', 'provided service Successfully Deleted.');
	}

	/**
	 * Delete multiple records
	 * Delete multiple records by @param
	 */
	function delete_selected_provided_service()
	{
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('provided_services');
		}
		else
		{
			$this->Provided_services_model->delete_multiple_provided_service();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('provided_services');
		}
	}

	/**
	 * Insert Update Page Detail tab
	 */
	function insert_update_provided_service_detail()
	{
		$id = $this->input->post('id');
		$continue = $this->input->post('btn_continue');
		$tab = $this->input->post('page-detail');
		$this->Provided_services_model->insert_update_provided_service_page_detail();
		$this->session->set_flashdata('success', 'Page Details Successfully Updated.');
		$this->session->set_flashdata('tab', $tab);
		if (isset($continue) && $continue === "Update & Continue")
		{
			$url = 'provided_services/page_details/' . $id;
		}
		else
		{
			$url = 'provided_Services';
		}

		redirect($url);
	}

	function remove_image()
	{
		$this->Provided_services_model->remove_image();
		echo '1';
	}
}
