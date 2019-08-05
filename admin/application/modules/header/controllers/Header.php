<?php
/**
 * Header
 *
 * @category class
 * @package  Header
 * @author   Athi
 * Created at:  29-Apr-2018
 * 
 * Modified By : Saravana
 * Modified Date : 18-Feb-2019
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Header extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Header_model');
		$this->load->module('admin_header');
		$this->load->module('color');
    }

    // Display all Header Part in a table
    function index()
    {
			$data['website_id'] = $this->admin_header->website_id();
			$header = $this->Header_model->get_setting_header($data['website_id'], 'header_background');

			if(!empty($header)) :
				$keys = json_decode($header[0]->key);
				$values = json_decode($header[0]->value);
				$i = 0;
				foreach($keys as $key) :
					$data[$key] = $values[$i];
					$i++;
				endforeach;
			else :
				$data['header_background_color'] = '';
			endif;

			$data['table']	= $this->get_table($data['website_id']);
			$data['heading']	= 'Header';
			$data['title']	= "Header | Administrator";
			$this->load->view('template/meta_head', $data);			
			$this->load->view('header');	
			$this->admin_header->index();		
			$this->load->view('view', $data);
			$this->load->view('template/footer_content');
			$this->load->view('script');
			$this->load->view('template/footer');
	}

	// Table
	function get_table($website_id)
	{
		$header_components	= $this->Header_model->get_header($website_id);

		if (isset($header_components) && $header_components != "")
		{
			$i = 1;
			foreach ($header_components as $header_component)
			{
				$anchor_edit = anchor(
					$header_component->url,
					'<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>',
					array(
						'data-toggle'         => 'tooltip',
						'data-placement'      => 'left',
						'data-original-title' => 'Edit'
					)
				);
				
				$cell = array(
					'class' => 'last',
					'data'  => $anchor_edit
                );

				$this->table->add_row(
					$i,
					$header_component->name,					
					$cell
				);
				$i++;
			}
		}

		// Table open
		$template = array(
			'table_open' => '<table
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" id="datatable-responsive">'
		);

		$this->table->set_template($template);
		// Table heading row
		$this->table->set_heading(array(
			'S.No',
			'Name',
			'Action'
		));

		return $this->table->generate();
	}

	// Header Background Color
	function insert_update_header_customize()
	{
		$this->Header_model->insert_update_header_customization();
		redirect('header');
	}

}
