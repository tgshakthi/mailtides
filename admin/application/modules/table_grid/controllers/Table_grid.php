<?php
/**
 * Table Grid
 *
 * @category class
 * @package Table Grid
 * @author Saravana
 * Created at: 17-Jul-18
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Table_grid extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Table_grid_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	/**
	 * Table Grid Details
	 * Display Table Grid Title Details
	 * Display Table Grid Customization Details
	 * Display All Table Grid in a Table
	 */
	function table_grid_index($page_id)
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();

		// Get Table Grid details from settings

		$data['table_grid_title_data'] = $this->Table_grid_model->get_table_grid_setting_details(
			$this->admin_header->website_id() ,
			$page_id,
			'table_grid_title'
		);

		// Get Table Grid details from settings

		$data['table_grid_customize_data'] = $this->Table_grid_model->get_table_grid_setting_details(
			$this->admin_header->website_id() ,
			$page_id,
			'table_grid_customize'
		);

		// Table Grid details from settings

		if (!empty($data['table_grid_title_data']))
		{
			$keys = json_decode($data['table_grid_title_data'][0]->key);
			$values = json_decode($data['table_grid_title_data'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['table_grid_title'] = '';
			$data['table_grid_title_color'] = '';
			$data['table_grid_title_position'] = '';
			$data['table_grid_title_status'] = '';
		}

		// Table Grid Customize details from setting

		if (!empty($data['table_grid_customize_data']))
		{
			$keys 	= json_decode($data['table_grid_customize_data'][0]->key);
			$values = json_decode($data['table_grid_customize_data'][0]->value);
			$i = 0;
			foreach ($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
		
			$data['component_background'] = '';
			$data['table_grid_background'] = '';
		}

		// Get Table Grid
		$table_grid_datas = $this->Table_grid_model->get_table_grid($page_id);

		if (!empty($table_grid_datas)) :
			$data['id'] = $table_grid_datas[0]->id;
			$data['row'] = $table_grid_datas[0]->no_of_rows;
			$data['col'] = $table_grid_datas[0]->no_of_cols;
			$data['table'] = $table_grid_datas[0]->table_content;
		else :
			$data['id'] = '';
			$data['row'] = "";
			$data['col'] = "";
			$data['table'] = "";
		endif;

		$data['httpUrl'] = $this->admin_header->host_url();
		$data['heading'] = 'Table Grid';
		$data['title'] = 'Table Grid | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('table_grid_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Table Grid Title

	function insert_update_table_grid_title()
	{
		$page_id = $this->input->post('page-id');		
		$this->Table_grid_model->insert_update_table_grid_title_data($page_id);
		redirect('table_grid/table_grid_index/' . $page_id);		
	}

	// Insert & Update Table Grid Customization

	function insert_update_table_grid_customize()
	{
		$page_id = $this->input->post('page-id');
		$this->Table_grid_model->insert_update_table_grid_customize_data($page_id);
		redirect('table_grid/table_grid_index/' . $page_id);
	}

	// Create Table

	function create_table()
	{
		$this->Table_grid_model->create_table();
	}

}
