<?php
/**
 * City
 *
 * @category class
 * @package  City
 * @author   Saravana
 * Created at:  25-Jan-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class City extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('City_model');
		$this->load->module('admin_header');
		$this->form_validation->CI = & $this;
	}

	/**
	 * Display all Cities in a table
	 * get table data from get table method
	 */
	function index()
	{
		$data['table'] = $this->get_table();
		$data['heading'] = 'City';
		$data['title'] = "City | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('city_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	/**
	 * Table
	 * get all data from model
	 * generate data table
	 * with multiple delete option
	 */
	function get_table()
	{
		$cities = $this->City_model->get_cities();
		if (!empty($cities))
		{
			foreach($cities as $city)
			{
				$anchor_edit = anchor(
					site_url('city/add_edit_city/' . $city->id) , 
					'<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', 
					array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));

				$anchor_delete = anchor(
					'',
					'<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', 
					array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $city->id . ', \'' . base_url('city/delete_city') . '\')'
				));

				if ($city->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . ' ' . $anchor_delete
				);
				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $city->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $city->id . '">', ucwords($city->name) , $city->sort_order, $status, $cell);
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
            id="datatable-checkbox"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">',

			// 'tbody_open' => '<tbody id = "table_row_sortable">'

		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'City Name', 'Sort Order', 'Status', 'Action');
		return $this->table->generate();
	}

	/**
	 * Add and Edit Banner
	 */
	function add_edit_city($id = null)
	{
		if ($id != null)
		{
			$city = $this->City_model->get_city_by_id($id);
			$data['id'] = $city[0]->id;
			$data['name'] = $city[0]->name;
			$data['sort_order'] = $city[0]->sort_order;
			$data['status'] = $city[0]->status;
		}
		else
		{
			$data['id'] = "";
			$data['name'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
		}

		$data['heading'] = (($id != null) ? 'Edit' : 'Add').' City';
		$data['title'] = (($id != null) ? 'Edit' : 'Add') . ' City | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('city_header');
		$this->admin_header->index();
		$this->load->view('add_edit_city', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update City

	function insert_update_city()
	{
		$id = $this->input->post('city-id');
		$continue = $this->input->post('btn_continue');
		
		$error_config = array(
			array(
				'field' => 'city-name',
				'label' => 'City Name',
				'rules' => 'required'
			) ,
			array(
				'field' => 'sort_order',
				'label' => 'Sort Order',
				'rules' => 'required'
			) ,
		);		

		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($id))
			{
				redirect('city/add_edit_city');
			}
			else
			{
				redirect('city/add_edit_city/' . $id);
			}
		}
		else
		{
			if (empty($id))
			{
				$this->City_model->insert_update_city();
				$this->session->set_flashdata('success', 'City successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'city/add_edit_city';
				}
				else
				{
					$url = 'city';
				}
			}
			else
			{
				$this->City_model->insert_update_city($id);
				$this->session->set_flashdata('success', 'City Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'city/add_edit_city/' . $id;
				}
				else
				{
					$url = 'city';
				}
			}

			redirect($url);
		}
	}

	// Delete City

	function delete_city()
	{
		$this->City_model->delete_city();
		$this->session->set_flashdata('success', 'City Successfully Deleted.');
		redirect('city');
	}

	// Delete multiple City
	function delete_multiple_city()
	{
		$page_id = $this->input->post('page_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('city');
		}
		else
		{
			$this->City_model->delete_multiple_city();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('city');
		}
	}

}