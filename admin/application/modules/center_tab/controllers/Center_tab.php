<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Center_tab extends MX_Controller

{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Center_tab_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	// Display all Center Tab in a table

	function center_tab_index($page_id)
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_id'] = $this->admin_header->website_id();

		// Get Center Tab details from settings

		$data['center_tab_title_data'] = $this->Center_tab_model->get_center_tab_setting_details($data['website_id'], $page_id, 'center_tab');

		// Center Tab title details from settings

		if (!empty($data['center_tab_title_data']))
		{
			$keys = json_decode($data['center_tab_title_data'][0]->key);
			$values = json_decode($data['center_tab_title_data'][0]->value);
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
			$data['component_background'] = '';
			$data['center_tab_background'] = '';
			$data['status'] = '';
		}

		$data['page_id'] = $page_id;
		$data['table'] = $this->get_table($page_id);
		$data['heading'] = 'Center Tab';
		$data['title'] = "Center Tab | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('center_tab_header');
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
		$center_tabs = $this->Center_tab_model->get_center_tab($website_id, $page_id);
		if (!empty($center_tabs))
		{
			$i = 0;
			foreach($center_tabs as $center_tab)
			{
				$anchor_edit = anchor('center_tab/add_edit_center_tab/' . $page_id . '/' . $center_tab->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $center_tab->id . ', \'' . base_url('center_tab/delete_center_tab/' . $page_id) . '\')'
				));
				if ($center_tab->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$text_images = $this->Center_tab_model->get_center_tab_text_image($page_id, $center_tab->id);
				if (!empty($text_images)):
					$edit_url = 'center_tab/add_edit_center_tab_text_image/' . $page_id . '/' . $center_tab->id . '/' . $text_images[0]->id;
				else:
					$edit_url = 'center_tab/add_edit_center_tab_text_image/' . $page_id . '/' . $center_tab->id;
				endif;
				$anchor_edit_center_tab_text_image = anchor($edit_url, '<span class="glyphicon c_pagecontent_icon glyphicon-duplicate" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'data-original-title' => 'Edit Center Tab Text Image'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_edit_center_tab_text_image . $anchor_delete
				);
				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $center_tab->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $center_tab->id . '">', ucwords($center_tab->tab_name) , $center_tab->sort_order, $status, $cell);
				$i++;
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
				id="datatable-responsive"
				class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
				width="100%" cellspacing="0">',
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

	function insert_update_center_tab_title()
	{
		$page_id = $this->input->post('page_id');
		$this->Center_tab_model->insert_update_center_tab_title($page_id);
		redirect('center_tab/center_tab_index/' . $page_id);
	}

	function add_edit_center_tab($page_id, $id = null)
	{
		if ($id != null)
		{
			$center_tab = $this->Center_tab_model->get_center_tab_by_id($page_id, $id);
			$data['center_tab_id'] = $center_tab[0]->id;
			$data['tab_name'] = $center_tab[0]->tab_name;
			$data['tab_color'] = $center_tab[0]->tab_color;
			$data['sort_order'] = $center_tab[0]->sort_order;
			$data['status'] = $center_tab[0]->status;
		}
		else
		{
			$data['center_tab_id'] = '';
			$data['tab_name'] = '';
			$data['tab_color'] = '';
			$data['sort_order'] = '';
			$data['status'] = '';
		}

		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['title'] = ($id != null) ? 'Edit Center Tab' : 'Add Center Tab' . ' | Administrator';
		$data['heading'] = (($id != null) ? 'Edit' : 'Add') . 'Center Tab';
		$this->load->view('template/meta_head', $data);
		$this->load->view('center_tab_header');
		$this->admin_header->index();
		$this->load->view('add_edit_center_tab', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	function insert_update_center_tab()
	{
		$website_id = $this->input->post('website_id');
		$center_tab_id = $this->input->post('center_tab_id');
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
			if (empty($center_tab_id))
			{
				redirect('center_tab/add_edit_center_tab/' . $page_id);
			}
			else
			{
				redirect('center_tab/add_edit_center_tab/' . $page_id . '/' . $center_tab_id);
			}
		}
		else
		{
			if (empty($center_tab_id))
			{
				$insert_id = $this->Center_tab_model->insert_update_center_tab($website_id, $page_id);
				$this->session->set_flashdata('success', 'Center Tab successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'center_tab/add_edit_center_tab/' . $page_id;
				}
				else
				{
					$url = 'center_tab/center_tab_index/' . $page_id;
				}
			}
			else
			{
				$this->Center_tab_model->insert_update_center_tab($website_id, $page_id, $center_tab_id);
				$this->session->set_flashdata('success', 'Center Tab Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'center_tab/add_edit_center_tab/' . $page_id . '/' . $center_tab_id;
				}
				else
				{
					$url = 'center_tab/center_tab_index/' . $page_id;
				}
			}

			redirect($url);
		}
	}

	function delete_center_tab($page_id)
	{
		$this->Center_tab_model->delete_center_tab($page_id);
		$this->session->set_flashdata('success', 'Center Tab Successfully Deleted.');
		redirect('center_tab/center_tab_index/' . $page_id);
	}

	// Delete multiple Tab

	function delete_multiple_center_tab()
	{
		$page_id = $this->input->post('page_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('center_tab/center_tab_index/' . $page_id);
		}
		else
		{
			$this->Center_tab_model->delete_multiple_center_tab();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('center_tab/center_tab_index/' . $page_id);
		}
	}

	function add_edit_center_tab_text_image($page_id, $center_tab_id, $id = null)
	{
		if ($id != null)
		{
			$text_image = $this->Center_tab_model->get_center_tab_text_image_by_id($id);
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
		$data['center_tab_id'] = $center_tab_id;
		$data['heading'] = 'Center Tab Text Image';
		$data['title'] = "Center_Tab Text Image | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('center_tab_header');
		$this->admin_header->index();
		$this->load->view('center_tab_text_image', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	function insert_update_center_tab_text_image()
	{
		$text_image_id = $this->input->post('text_image_id');
		$center_tab_id = $this->input->post('center_tab_id');
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
				redirect('center_tab/add_edit_center_tab_text_image/' . $page_id . '/' . $center_tab_id);
			}
			else
			{
				redirect('center_tab/add_edit_center_tab_text_image/' . $page_id . '/' . $center_tab_id . '/' . $text_image_id);
			}
		}
		else
		{
			if (empty($text_image_id))
			{
				$insert_id = $this->Center_tab_model->insert_update_center_tab_text_image($center_tab_id, $page_id);
				$this->session->set_flashdata('success', 'Text Image successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'center_tab/add_edit_center_tab_text_image/' . $page_id . '/' . $center_tab_id;
				}
				else
				{
					$url = 'center_tab/center_tab_index/' . $page_id;
				}
			}
			else
			{
				$this->Center_tab_model->insert_update_center_tab_text_image($center_tab_id, $page_id, $text_image_id);
				$this->session->set_flashdata('success', 'Text Image Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'center_tab/add_edit_center_tab_text_image/' . $page_id . '/' . $center_tab_id . '/' . $text_image_id;
				}
				else
				{
					$url = 'center_tab/center_tab_index/' . $page_id;
				}
			}

			redirect($url);
		}
	}

	function remove_image()
	{
		$this->Center_tab_model->remove_image();
		echo '1';
	}
}

?>