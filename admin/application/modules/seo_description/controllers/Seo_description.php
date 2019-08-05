<?php
/**
 * Seo Description
 *
 * @category class
 * @package  Seo Description
 * @author   Saravana
 * Created at:  28-Jan-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Seo_description extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Seo_description_model');
		$this->load->module('admin_header');
		$this->form_validation->CI = & $this;
	}

	/**
	 * Display all Seo Description in a table
	 * get table data from get table method
	 */
	function index()
	{
		$data['table'] = $this->get_table();
		$data['heading'] = 'Seo Description';
		$data['title'] = "Seo Description | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('seo_description_header');
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
		$website_id = $this->admin_header->website_id();
		$seo_descriptions = $this->Seo_description_model->get_seo_descriptions($website_id);
		if (!empty($seo_descriptions))
		{
			foreach($seo_descriptions as $seo_description)
			{
				$anchor_edit = anchor(
					site_url('seo_description/add_edit_seo_description/' . $seo_description->id) , 
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
					'onclick' => 'return delete_record(' . $seo_description->id . ', \'' . base_url('seo_description/delete_seo_description') . '\')'
				));

				if ($seo_description->status === '1')
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
				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $seo_description->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $seo_description->id . '">', ucwords($seo_description->category) , $seo_description->sort_order, $status, $cell);
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

		$this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Category', 'Sort Order', 'Status', 'Action');
		return $this->table->generate();
	}

	/**
	 * Add and Edit Seo Descirption
	 */
	function add_edit_seo_description($id = null)
	{
		if ($id != null)
		{
			$seo_description = $this->Seo_description_model->get_seo_description_by_id($id);
			$data['id'] = $seo_description[0]->id;
			$data['category'] = $seo_description[0]->category;
			$data['content'] = $seo_description[0]->content;
			$data['sort_order'] = $seo_description[0]->sort_order;
			$data['status'] = $seo_description[0]->status;
		}
		else
		{
			$data['id'] = "";
			$data['category'] = "";
			$data['content'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
		}

		$data['website_id'] = $this->admin_header->website_id();
		$data['heading'] = (($id != null) ? 'Edit' : 'Add').' Seo Description';
		$data['title'] = (($id != null) ? 'Edit' : 'Add') . ' Seo Description | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('seo_description_header');
		$this->admin_header->index();
		$this->load->view('add_edit_seo_description', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update City

	function insert_update_seo_description()
	{
		$id = $this->input->post('seo-description-id');
		$continue = $this->input->post('btn_continue');
		
		$error_config = array(
			array(
				'field' => 'category',
				'label' => 'Category',
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
				redirect('seo_description/add_edit_seo_description');
			}
			else
			{
				redirect('seo_description/add_edit_seo_description/' . $id);
			}
		}
		else
		{
			if (empty($id))
			{
				$this->Seo_description_model->insert_update_seo_description();
				$this->session->set_flashdata('success', 'Seo Description successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'seo_description/add_edit_seo_description';
				}
				else
				{
					$url = 'seo_description';
				}
			}
			else
			{
				$this->Seo_description_model->insert_update_seo_description($id);
				$this->session->set_flashdata('success', 'Seo Description Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'seo_description/add_edit_seo_description/' . $id;
				}
				else
				{
					$url = 'seo_description';
				}
			}

			redirect($url);
		}
	}

	// Delete City

	function delete_seo_description()
	{
		$this->Seo_description_model->delete_seo_description();
	}

	// Delete multiple Banner

	function delete_multiple_seo_description()
	{
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('seo_description');
		}
		else
		{
			$this->Seo_description_model->delete_multiple_seo_description();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('seo_description');
		}
	}
}