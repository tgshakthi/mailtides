<?php
/**
 * Tab
 *
 * @category class
 * @package  Tab
 * @author   Athi
 * Created at:  8-Aug-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Tab extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Tab_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	// Display all Tab in a table

	function tab_index($page_id)
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		
		$data['website_id'] = $this->admin_header->website_id();

		// Get Tab details from settings

		$data['tab_title_data'] = $this->Tab_model->get_tab_setting_details($data['website_id'], $page_id, 'tab');

		// Tab title details from settings

		if (!empty($data['tab_title_data']))
		{
			$keys = json_decode($data['tab_title_data'][0]->key);
			$values = json_decode($data['tab_title_data'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['tab_title'] = '';
			$data['title_color'] = '';
			$data['title_position'] = '';
			//$data['background_color'] = '';
			
			$data['component_background'] = '';
			$data['tab_background'] = '';
			
			$data['status'] = '';
		}

		$data['page_id'] = $page_id;
		$data['table'] = $this->get_table($page_id);
		$data['heading'] = 'Tab';
		$data['title'] = "Tab | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('tab_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table

	function get_table($page_id)
	{
		$website_id = $this->admin_header->website_id();
		$tabs = $this->Tab_model->get_tab($website_id, $page_id);
		if (!empty($tabs))
		{
			foreach($tabs as $tab)
			{
				$anchor_edit = anchor('tab/add_edit_tab/' . $page_id . '/' . $tab->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_edit_tab_content = anchor(site_url('tab/tab_component/' . $page_id . '/' . $tab->id) , '<span class="glyphicon c_pagecontent_icon glyphicon-duplicate" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'data-original-title' => 'Edit Tab Content'
				));
				$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $tab->id . ', \'' . base_url('tab/delete_tab/' . $page_id) . '\')'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_edit_tab_content . $anchor_delete
				);
				if ($tab->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $tab->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $tab->id . '">', ucwords($tab->tab_name) , $tab->sort_order, $status, $cell);
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
			id="datatable-checkbox"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">',
			//'tbody_open' => '<tbody id = "table_row_sortable">'
		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading(array(
			'<input type="checkbox" id="check-all" class="flat">',
			'Title',
			'Sort Order',
			'Status',
			'Action'
		));
		return $this->table->generate();
	}

	// Insert & Update Tab Title

	function insert_update_tab_title()
	{
		$page_id = $this->input->post('page_id');
		$this->Tab_model->insert_update_tab_title($page_id);
		redirect('tab/tab_index/' . $page_id);
	}

	// Add & Edit Tab

	function add_edit_tab($page_id, $id = null)
	{
		if ($id != null)
		{
			$tab = $this->Tab_model->get_tab_by_id($page_id, $id);
			$data['tab_id'] = $tab[0]->id;
			$data['tab_name'] = $tab[0]->tab_name;
			$data['tab_color'] = $tab[0]->tab_color;
			$data['sort_order'] = $tab[0]->sort_order;
			$data['status'] = $tab[0]->status;
		}
		else
		{
			$data['tab_id'] = '';
			$data['tab_name'] = '';
			$data['tab_color'] = '';
			$data['sort_order'] = '';
			$data['status'] = '';
		}

		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['title'] = ($id != null) ? 'Edit Tab' : 'Add Tab' . ' | Administrator';
		$data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Tab';
		$this->load->view('template/meta_head', $data);
		$this->load->view('tab_header');
		$this->admin_header->index();
		$this->load->view('add_edit_tab', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Tab

	function insert_update_tab()
	{
		$website_id = $this->input->post('website_id');
		$tab_id = $this->input->post('tab_id');
		$page_id = $this->input->post('page_id');
		$continue = $this->input->post('btn_continue');
		$error_config = array(
			array(
				'field' => 'tab_name',
				'label' => 'Tab Name',
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
			if (empty($tab_id))
			{
				redirect('tab/add_edit_tab/' . $page_id);
			}
			else
			{
				redirect('tab/add_edit_tab/' . $page_id . '/' . $tab_id);
			}
		}
		else
		{
			if (empty($tab_id))
			{
				$insert_id = $this->Tab_model->insert_update_tab($website_id, $page_id);
				$this->session->set_flashdata('success', 'Tab successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'tab/add_edit_tab/' . $page_id;
				}
				else
				{
					$url = 'tab/tab_index/' . $page_id;
				}
			}
			else
			{
				$this->Tab_model->insert_update_tab($website_id, $page_id, $tab_id);
				$this->session->set_flashdata('success', 'Tab Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'tab/add_edit_tab/' . $page_id . '/' . $tab_id;
				}
				else
				{
					$url = 'tab/tab_index/' . $page_id;
				}
			}

			redirect($url);
		}
	}

	// Edit Tab Component

	function tab_component($page_id, $tab_id)
	{
		$tab = $this->Tab_model->get_tab_by_id($page_id, $tab_id);
		$data['tab_name'] = $tab[0]->tab_name;
		$data['tab_components'] = ($tab[0]->tab_components != '') ? explode(',', $tab[0]->tab_components) : array();
		$data['website_id'] = $this->admin_header->website_id();
		$data['page_id'] = $page_id;
		$data['tab_id'] = $tab_id;
		$data['heading'] = 'Tab Content';
		$data['title'] = "Tab Content | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('tab_header');
		$this->admin_header->index();
		$this->load->view('tab_component', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Tab Content

	function insert_update_tab_component()
	{
		$website_id = $this->input->post('website_id');
		$tab_id = $this->input->post('tab_id');
		$page_id = $this->input->post('page_id');
		$continue = $this->input->post('btn_continue');
		$this->Tab_model->insert_update_tab_component($website_id, $page_id, $tab_id);
		$this->session->set_flashdata('success', 'Tab Successfully Updated.');
		if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
		{
			$url = 'tab/tab_component/' . $page_id . '/' . $tab_id;
		}
		else
		{
			$url = 'tab/tab_index/' . $page_id;
		}

		redirect($url);
	}

	//  Tab Text Full Width

	function tab_text_full_width($page_id, $tab_id)
	{
		$text_full_width = $this->Tab_model->get_tab_text_full_width_by_tab_id($tab_id);
		if (!empty($text_full_width))
		{
			$data['text_full_width_id'] = $text_full_width[0]->id;
			$data['text_full_width_title'] = $text_full_width[0]->title;
			$data['full_text'] = $text_full_width[0]->full_text;
			$data['title_color'] = $text_full_width[0]->title_color;
			$data['title_position'] = $text_full_width[0]->title_position;
			$data['content_title_color'] = $text_full_width[0]->content_title_color;
			$data['content_title_position'] = $text_full_width[0]->content_title_position;
			$data['content_color'] = $text_full_width[0]->content_color;
			$data['content_position'] = $text_full_width[0]->content_position;
			$data['background_color'] = $text_full_width[0]->background_color;
		}
		else
		{
			$data['text_full_width_id'] = "";
			$data['text_full_width_title'] = "";
			$data['full_text'] = "";
			$data['title_color'] = "";
			$data['title_position'] = "";
			$data['content_title_color'] = "";
			$data['content_title_position'] = "";
			$data['content_color'] = "";
			$data['content_position'] = "";
			$data['background_color'] = "";
		}

		$data['tab_id'] = $tab_id;
		$data['page_id'] = $page_id;
		$data['heading'] = 'Tab Text Full Width';
		$data['title'] = "Tab Text Full Width | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('tab_header');
		$this->admin_header->index();
		$this->load->view('tab_text_full_width', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Tab Text Full Width

	function insert_update_tab_text_full_width()
	{
		$text_full_width_id = $this->input->post('text_full_width_id');
		$tab_id = $this->input->post('tab_id');
		$page_id = $this->input->post('page_id');
		$continue = $this->input->post('btn_continue');
		$error_config = array(
			array(
				'field' => 'full_text',
				'label' => 'Content',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('tab/tab_text_full_width/' . $page_id . '/' . $tab_id);
		}
		else
		{
			if (empty($text_full_width_id))
			{
				$this->Tab_model->insert_update_tab_text_full_width();
				$this->session->set_flashdata('success', 'Tab Text Full Width successfully Added');
			}
			else
			{
				$this->Tab_model->insert_update_tab_text_full_width($text_full_width_id);
				$this->session->set_flashdata('success', 'Tab Text Full Width Successfully Updated.');
			}

			if (isset($continue) && ($continue === "Add & Continue" || $continue === "Update & Continue"))
			{
				$url = 'tab/tab_text_full_width/' . $page_id . '/' . $tab_id;
			}
			else
			{
				$url = 'tab/tab_component/' . $page_id . '/' . $tab_id;
			}

			redirect($url);
		}
	}

	//  Tab Text Image

	function tab_text_image($page_id, $tab_id)
	{
		$data['tab_id'] = $tab_id;
		$data['page_id'] = $page_id;
		$data['table'] = $this->get_text_image_table($page_id, $tab_id);
		$data['heading'] = 'Tab Text Image';
		$data['title'] = "Tab Text Image | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('tab_header');
		$this->admin_header->index();
		$this->load->view('view_tab_text_image', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Get Tab Text Image Table

	function get_text_image_table($page_id, $tab_id)
	{
		$ImageUrl = $this->admin_header->image_url();
		$website_folder_name = $this->admin_header->website_folder_name();
		$tab_text_images = $this->Tab_model->get_tab_text_image($tab_id);
		if (!empty($tab_text_images))
		{
			foreach($tab_text_images as $tab_text_image)
			{
				$anchor_edit = anchor('tab/add_edit_tab_text_image/' . $page_id . '/' . $tab_id . '/' . $tab_text_image->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $tab_text_image->id . ', \'' . base_url('tab/delete_tab_text_image/' . $page_id . '/' . $tab_id) . '\')'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_delete
				);
				if ($tab_text_image->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($tab_text_image->image != '')
				{
					$tab_text_image_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $tab_text_image->image;
					$image = img(array(
						'src' => $tab_text_image_img,
						'style' => 'width:145px; height:86px'
					));
				}
				else
				{
					$image = img(array(
						'src' => $ImageUrl . 'images/noimage.png',
						'style' => 'width:145px; height:86px'
					));
				}

				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $tab_text_image->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $tab_text_image->id . '">', ucwords($tab_text_image->title) , $image, $tab_text_image->sort_order, $status, $cell);
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
			id="datatable-responsive"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">',

			// 'tbody_open' => '<tbody id = "table_row_sortable">'

		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading(array(
			'<input type="checkbox" id="check-all" class="flat">',
			'Title',
			'Image',
			'Sort Order',
			'Status',
			'Action'
		));
		return $this->table->generate();
	}

	//  Tab Add Edit Text Image

	function add_edit_tab_text_image($page_id, $tab_id, $id = null)
	{
		if ($id != null)
		{
			$text_image = $this->Tab_model->get_tab_text_image_by_id($id);
			$data['text_image_id'] = $text_image[0]->id;
			$data['text_image_title'] = $text_image[0]->title;
			$data['title_color'] = $text_image[0]->title_color;
			$data['title_position'] = $text_image[0]->title_position;
			$data['text'] = $text_image[0]->text;
			$data['content_title_color'] = $text_image[0]->content_title_color;
			$data['content_title_position'] = $text_image[0]->content_title_position;
			$data['content_color'] = $text_image[0]->content_color;
			$data['background_color'] = $text_image[0]->background_color;
			$data['image'] = $text_image[0]->image;
			$data['image_title'] = $text_image[0]->image_title;
			$data['image_alt'] = $text_image[0]->image_alt;
			$data['template'] = $text_image[0]->template;
			$data['image_position'] = $text_image[0]->image_position;
			$data['image_size'] = $text_image[0]->image_size;
			$data['readmore_btn'] = $text_image[0]->readmore_btn;
			$data['button_type'] = $text_image[0]->button_type;
			$data['btn_background_color'] = $text_image[0]->btn_background_color;
			$data['readmore_label'] = $text_image[0]->readmore_label;
			$data['label_color'] = $text_image[0]->label_color;
			$data['readmore_url'] = $text_image[0]->readmore_url;
			$data['open_new_tab'] = $text_image[0]->open_new_tab;
			$data['background_hover'] = $text_image[0]->background_hover;
			$data['text_hover'] = $text_image[0]->text_hover;
			$data['readmore_character'] = $text_image[0]->readmore_character;
			$data['border'] = $text_image[0]->border;
			$data['border_size'] = $text_image[0]->border_size;
			$data['border_color'] = $text_image[0]->border_color;
			$data['sort_order'] = $text_image[0]->sort_order;
			$data['status'] = $text_image[0]->status;
		}
		else
		{
			$data['text_image_id'] = "";
			$data['text_image_title'] = "";
			$data['title_color'] = "";
			$data['title_position'] = "";
			$data['text'] = "";
			$data['content_title_color'] = "";
			$data['content_title_position'] = "";
			$data['content_color'] = "";
			$data['background_color'] = "";
			$data['image'] = "";
			$data['image_title'] = "";
			$data['image_alt'] = "";
			$data['template'] = "";
			$data['image_position'] = "";
			$data['image_size'] = "";
			$data['readmore_btn'] = "";
			$data['button_type'] = "";
			$data['btn_background_color'] = "";
			$data['readmore_label'] = "";
			$data['label_color'] = "";
			$data['readmore_url'] = "";
			$data['open_new_tab'] = "";
			$data['background_hover'] = "";
			$data['text_hover'] = "";
			$data['readmore_character'] = "";
			$data['border'] = "";
			$data['border_size'] = "";
			$data['border_color'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
		}

		$data['website_id'] = $this->admin_header->website_id();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['page_id'] = $page_id;
		$data['tab_id'] = $tab_id;
		$data['heading'] = 'Tab Text Image';
		$data['title'] = "Tab Text Image | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('tab_header');
		$this->admin_header->index();
		$this->load->view('tab_text_image', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Tab Text Image

	function insert_update_tab_text_image()
	{
		$text_image_id = $this->input->post('text_image_id');
		$tab_id = $this->input->post('tab_id');
		$page_id = $this->input->post('page_id');
		$continue = $this->input->post('btn_continue');
		$error_config = array(
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
			if (empty($text_image_id))
			{
				redirect('tab/add_edit_tab_text_image/' . $page_id . '/' . $tab_id);
			}
			else
			{
				redirect('tab/add_edit_tab_text_image/' . $page_id . '/' . $tab_id . '/' . $text_image_id);
			}
		}
		else
		{
			if (empty($text_image_id))
			{
				$insert_id = $this->Tab_model->insert_update_tab_text_image($tab_id);
				$this->session->set_flashdata('success', 'Text Image successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'tab/add_edit_tab_text_image/' . $page_id . '/' . $tab_id;
				}
				else
				{
					$url = 'tab/tab_text_image/' . $page_id . '/' . $tab_id;
				}
			}
			else
			{
				$this->Tab_model->insert_update_tab_text_image($tab_id, $text_image_id);
				$this->session->set_flashdata('success', 'Text Image Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'tab/add_edit_tab_text_image/' . $page_id . '/' . $tab_id . '/' . $text_image_id;
				}
				else
				{
					$url = 'tab/tab_text_image/' . $page_id . '/' . $tab_id;
				}
			}

			redirect($url);
		}
	}

	/**
	 * Update Tab Text Image Sort Order
	 */
	function update_text_image_sort_order()
	{
		$tab_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Tab_model->update_text_image_sort_order($tab_id, $row_sort_order);
	}

	/**
	 * Update Tab Sort Order
	 */
	function update_sort_order()
	{
		$page_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Tab_model->update_sort_order($page_id, $row_sort_order);
	}

	// Delete Text Image

	function delete_tab_text_image($page_id, $tab_id)
	{
		$this->Tab_model->delete_tab_text_image($tab_id);
		$this->session->set_flashdata('success', 'Text Image Successfully Deleted.');
		redirect('tab/tab_text_image/' . $page_id . '/' . $tab_id);
	}

	// Delete multiple Tab Text Image

	function delete_multiple_tab_text_image()
	{
		$page_id = $this->input->post('page_id');
		$tab_id = $this->input->post('tab_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('tab/tab_text_image/' . $page_id . '/' . $tab_id);
		}
		else
		{
			$this->Tab_model->delete_multiple_tab_text_image();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('tab/tab_text_image/' . $page_id . '/' . $tab_id);
		}
	}

	// Delete Tab

	function delete_tab($page_id)
	{
		$this->Tab_model->delete_tab($page_id);
		$this->session->set_flashdata('success', 'Tab Successfully Deleted.');
		redirect('tab/tab_index/' . $page_id);
	}

	// Delete multiple Tab

	function delete_multiple_tab()
	{
		$page_id = $this->input->post('page_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('tab/tab_index/' . $page_id);
		}
		else
		{
			$this->Tab_model->delete_multiple_tab();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('tab/tab_index/' . $page_id);
		}
	}

	// Remove Image

	function remove_image()
	{
		$this->Tab_model->remove_image();
		echo '1';
	}
}