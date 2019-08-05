<?php
/**
 * Top Header
 *
 * @category class
 * @package  Top Header
 * @author   Velu
 * Created at:  21-Sep-18
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Top_header extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Header_model');
		$this->load->model('Top_header_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	// Display all Header Part in a table

	function index()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$top_header_customization_data = $this->Top_header_model->get_setting_top_header($data['website_id'], 'top_header_background');

		if(!empty($top_header_customization_data)) :
			$keys = json_decode($top_header_customization_data[0]->key);
			$values = json_decode($top_header_customization_data[0]->value);
			$i = 0;
			foreach($keys as $key) :

				$data[$key] = $values[$i];
				$i++;

			endforeach;
		else:
			$data['top_header_background_color'] = "";
			$data['top_header_status'] = "";
		endif;

		$data['table'] = $this->table($data['website_id']);
		$data['heading'] = "Top header";
		$data['title']	= "Top Header | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('header');
		$this->admin_header->index();
		$this->load->view('top_header_view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script_top_header_contact');
		$this->load->view('template/footer');
	}

	// Generate Table

	function table($website_id)
	{
		$records = $this->Top_header_model->get_top_header($website_id);
		if (isset($records) && $records != "")
		{
			$i = 1;
			foreach($records as $record)
			{
				$anchor_edit = anchor('header/' . $record->url, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit
				);
				$this->table->add_row($i, $record->name, $cell);
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
			'S.NO',
			'Name',
			'Action'
		));
		return $this->table->generate();
	}

	// insert update top header background color customization
	function insert_update_top_header_customize()
	{
		$this->Top_header_model->insert_update_top_header_customize_data();
		redirect('header/top_header');
	}

	// Get top header contact info
	function contact()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['top_header_contact_info_data'] = $this->Top_header_model->get_setting_top_header($data['website_id'], 'top_header_contact_info');

		if(!empty($data['top_header_contact_info_data'])) :
			$keys = json_decode($data['top_header_contact_info_data'][0]->key);
			$values = json_decode($data['top_header_contact_info_data'][0]->value);
			$i = 0;
			foreach($keys as $key) :

				$data[$key] = $values[$i];
				$i++;

			endforeach;
		else:
			$data['top_header_contact_info'] = [];
			$data['top_header_contact_info_position'] = "";
			$data['top_header_contact_info_status'] = "";
		endif;

		$data['contact_informations'] = $this->Top_header_model->get_data_contact_information($data['website_id']);
		$data['heading'] = "Contact Information";
		$data['title'] = "Top Header | Contact | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('header');
		$this->admin_header->index();
		$this->load->view('contact', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// insert update top header contact info
	function insert_update_top_header_contact_info()
	{
		$continue = $this->input->post('btn_continue');
		$this->Top_header_model->insert_update_top_header_contact_info_data();

		if (isset($continue) && $continue === "Add & Continue")
		{
			$url = 'header/top_header/contact';
		}
		else if (isset($continue) && $continue === "Update & Continue")
		{
			$url = 'header/top_header/contact';
		}
		else
		{
			$url = 'header/top_header';
		}
		redirect($url);
	}

  //Get top header social Media info
	function social_media()
	{
		$data['website_id'] = $this->admin_header->website_id();

		$data['top_header_social_media'] = $this->Top_header_model->get_setting_top_header($data['website_id'], 'top_header_social_media_info');

		if(!empty($data['top_header_social_media'])) :
			$keys = json_decode($data['top_header_social_media'][0]->key);
			$values = json_decode($data['top_header_social_media'][0]->value);
			$i = 0;
			foreach($keys as $key) :

				$data[$key] = $values[$i];
				$i++;

			endforeach;
		else:
			$data['top_header_social_info_position'] = '';
			$data['top_header_social_info_status'] = '';
		endif;

		$data['heading'] = 'Social Media';
		$data['title'] = 'Top Header | Social Media | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('header');
		$this->admin_header->index();
		$this->load->view('social_media', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// insert update top header social media info
	function insert_update_top_header_social_info()
	{
		$continue = $this->input->post('btn_continue');
		$this->Top_header_model->insert_update_top_header_social_info_data();

		if (isset($continue) && $continue === "Add & Continue")
		{
			$url = 'header/top_header/social_media';
		}
		else if (isset($continue) && $continue === "Update & Continue")
		{
			$url = 'header/top_header/social_media';
		}
		else
		{
			$url = 'header/top_header';
		}
		redirect($url);
	}
}
