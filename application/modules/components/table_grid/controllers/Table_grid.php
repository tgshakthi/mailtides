<?php
/**
 * Table Grid
 *
 * @category class
 * @package  Table Grid
 * @author   Saravana
 * Created at:  30-Aug-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Table_grid extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Table_grid_model');
		$this->load->module('setting');
	}

	/* Get Table Grid */
	function view($page_id)
	{
		// Table Grid Title
		$data_title_settings = $this->setting->get_setting('page_id', $page_id, 'table_grid_title');

		if (!empty($data_title_settings)) :
			$data['table_grid_title'] = $data_title_settings['table_grid_title'];
			$data['table_grid_title_color'] = $data_title_settings['table_grid_title_color'];
			$data['table_grid_title_position'] = $data_title_settings['table_grid_title_position'];
			$data['table_grid_title_status'] = $data_title_settings['table_grid_title_status'];
		else :
			$data['table_grid_title'] = '';
			$data['table_grid_title_color'] = '';
			$data['table_grid_title_position'] = '';
			$data['table_grid_title_status'] = '';
		endif;

		// Table Grid Customized data
		$data_customize_from_setting = $this->setting->get_setting('page_id', $page_id, 'table_grid_customize');

		if (!empty($data_customize_from_setting)) :
			//$data['background_color'] = $data_customize_from_setting['background_color'];
			$data['component_background'] = $data_customize_from_setting['component_background'];
			$data['table_grid_background'] = $data_customize_from_setting['table_grid_background'];
		else :
			//$data['background_color'] = '';
			$data['component_background'] = '';
			$data['table_grid_background'] = '';
		endif;
		
		// Image Url
		$data['image_url'] = $this->setting->image_url();

		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['table_grid_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['table_grid_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;
		
		$data['table_grids'] = $this->Table_grid_model->get_table_grid($page_id);
		$this->load->view('table_grid', $data);
	}
}
