<?php
/**
 * Header
 *
 * @category class
 * @package  Footer
 * @author   Shiva
 * Created at:  29-Apr-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Footer extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Footer_model');
		$this->load->module('admin_header');
		$this->load->module('color');
    }

    // Display all Header Part in a table
    function index()
    {
	  	$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_id'] = $this->admin_header->website_id();
		$footer_customization_data = $this->Footer_model->get_setting_footer($data['website_id'], 'footer_status_and_background');
			
		if(!empty($footer_customization_data)) :
			$keys = json_decode($footer_customization_data[0]->key);
			$values = json_decode($footer_customization_data[0]->value);
			$i = 0;
			foreach($keys as $key) :
				$data[$key] = $values[$i];
				$i++;

			endforeach;
		else:
			$data['component_background'] = '';
			$data['footer_background'] = '';
			$data['footer_status'] ="";
		endif;
		$data['table']	= $this->get_table();
		$data['heading']= 'Footer';
		$data['title']	= "Footer | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('footer');
		$this->admin_header->index();
		$this->load->view('footer_view', $data);
		$this->load->view('template/footer_content');
    $this->load->view('footer_script');
		$this->load->view('template/footer');
	}

	// Table
	function get_table()
	{
		$website_id = $this->admin_header->website_id();
		$footer_components	= $this->Footer_model->get_footer($website_id);

		if (isset($footer_components) && $footer_components != "")
		{
			$i = 1;
			foreach ($footer_components as $footer_component)
			{
				$anchor_edit = anchor(
					$footer_component->url,
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
					$footer_component->name,		
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
			'S.NO',
			'Title',
			'Action'
		));

		return $this->table->generate();
	}
	function contact_information()
	{
	
		$data['website_id'] = $this->admin_header->website_id();
		$data['footer_contact_info_data'] = $this->Footer_model->get_setting_footer($data['website_id'], 'footer_contact_info');

		if(!empty($data['footer_contact_info_data'])) :
			$keys = json_decode($data['footer_contact_info_data'][0]->key);
			$values = json_decode($data['footer_contact_info_data'][0]->value);
			$i = 0;
			foreach($keys as $key) :

				$data[$key] = $values[$i];
				$i++;

			endforeach;
		else:
			$data['footer_contact_info'] = [];
			$data['footer_contact_info_position'] = "";
			$data['footer_contact_info_status'] = "";
		endif;

		$data['contact_informations'] = $this->Footer_model->get_data_contact_information($data['website_id']);
		$data['heading'] = "Footer Contact Information";
		$data['title'] = "Top Footer | Contact | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('footer');
		$this->admin_header->index();
		$this->load->view('footer_contact', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	function insert_update_footer_contact_info()
	{
		$continue = $this->input->post('btn_continue');
		$this->Footer_model->insert_update_footer_contact_info_data();

		if (isset($continue) && $continue === "Add & Continue")
		{
			$url = 'footer/contact_information';
		}
		else if (isset($continue) && $continue === "Update & Continue")
		{
			$url = 'footer/contact_information';
		}
		else
		{
			$url = 'footer';
		}
		redirect($url);
	}
	// insert update top header background color customization
	function insert_update_footer_customize()
	{
		
		$this->Footer_model->insert_update_footer_customize_data();
		redirect('footer');
	}
	function remove_image()
	{
		$this->Footer_model->remove_image();
		echo '1';
	}
}
