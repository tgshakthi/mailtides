<?php
/**
 * Circular Image
 *
 * @category class
 * @package  Circular Image
 * @author   Saravana
 * Created at:  05-Jul-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Circular_image extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Circular_image_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	/**
	 * Circular Image Details
	 * Display Circular Image Title details
	 * Display Circular Image Customization details
	 * Display All Circular Image in a table
	 */
	public function circular_image_index($page_id)
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();

		// All Circular in a table
		$data['table'] = $this->get_table($page_id);

		// Get Circular Image details from settings

		$data['circular_image_title_data'] = $this->Circular_image_model->get_circular_image_setting_details(
			$this->admin_header->website_id() ,
			$page_id,
			'circular_image_title'
		);

		// Get Circular Image details from settings

		$data['circular_image_customize_data'] = $this->Circular_image_model->get_circular_image_setting_details(
			$this->admin_header->website_id() ,
			$page_id,
			'circular_image_customize'
		);

		// Circular Image title details from settings

		if (!empty($data['circular_image_title_data']))
		{
			$keys = json_decode($data['circular_image_title_data'][0]->key);
			$values = json_decode($data['circular_image_title_data'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['circular_image_title'] = '';
			$data['circular_image_title_color'] = '';
			$data['circular_image_title_position'] = '';
			$data['circular_image_title_status'] = '';
		}

		// Circular Image Customize details from settings

		if (!empty($data['circular_image_customize_data']))
		{
			$keys = json_decode($data['circular_image_customize_data'][0]->key);
			$values = json_decode($data['circular_image_customize_data'][0]->value);
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
			$data['circular_image_background'] = '';
		}

		$data['heading'] = 'Circular Image';
		$data['title'] = "Circular Image | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('circular_image_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table

	function get_table($page_id)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$ImageUrl = $this->admin_header->image_url();
		$circular_images = $this->Circular_image_model->get_circular_image($page_id);
		if (isset($circular_images) && $circular_images != "")
		{
			foreach($circular_images as $circular_image)
			{
				$anchor_edit = anchor(
					'circular_image/add_edit_circular_image/' . $page_id . '/' . $circular_image->id,
					'<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>',
					array(
						'data-toggle' => 'tooltip',
						'data-placement' => 'left',
						'data-original-title' => 'Edit'
					)
				);

				$anchor_delete = anchor(
					'',
					'<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>',
					array(
						'data-toggle' => 'tooltip',
						'data-placement' => 'right',
						'data-original-title' => 'Delete',
						'onclick' => 'return delete_record(' . $circular_image->id . ', \'' . base_url('circular_image/delete_circular_image/' . $page_id) . '\')'
					)
				);

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_delete
				);

				if ($circular_image->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($circular_image->image != '')
				{
					$circular_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $circular_image->image;

					$image = img(array(
						'src' => $circular_img,
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

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $circular_image->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $circular_image->id . '">',
					ucwords($circular_image->title) ,
					$image,
					$circular_image->sort_order,
					$status,
					$cell
				);
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

	// Insert & Update Circular Image Title

	function insert_update_circular_image_title()
	{
		$page_id = $this->input->post('page-id');		
		$this->Circular_image_model->insert_update_circular_image_title_data($page_id);
		redirect('circular_image/circular_image_index/' . $page_id);
	}

	// Insert & Update Circular Image Customization

	function insert_update_circular_image_customize()
	{
		$page_id = $this->input->post('page-id');
		$this->Circular_image_model->insert_update_circular_image_customize_data($page_id);
		redirect('circular_image/circular_image_index/' . $page_id);
	}

	// Add & Edit Circular Image

	function add_edit_circular_image($page_id, $id = NULL)
	{
		if ($id != null)
		{
			$circular_image = $this->Circular_image_model->get_circular_image_by_id($page_id, $id);
			$data['circular_image_id'] = $circular_image[0]->id;
			$data['image'] = $circular_image[0]->image;
			$data['image_position'] = $circular_image[0]->image_position;
			$data['circular_image_title'] = $circular_image[0]->title;
			$data['content'] = $circular_image[0]->content;
			$data['title_color'] = $circular_image[0]->title_color;
			$data['title_position'] = $circular_image[0]->title_position;
			$data['content_title_color'] = $circular_image[0]->content_title_color;
			$data['content_title_position'] = $circular_image[0]->content_title_position;
			$data['content_color'] = $circular_image[0]->content_color;
			$data['content_position'] = $circular_image[0]->content_position;
			$data['title_hover_color'] = $circular_image[0]->title_hover_color;
			$data['content_title_hover_color'] = $circular_image[0]->content_title_hover_color;
			$data['content_hover_color'] = $circular_image[0]->content_hover_color;
			$data['redirect'] = $circular_image[0]->redirect;
			$data['redirect_url'] = $circular_image[0]->redirect_url;
			$data['open_new_tab'] = $circular_image[0]->open_new_tab;
			$data['background_hover_color'] = $circular_image[0]->background_hover_color;
			$data['background_color'] = $circular_image[0]->background_color;
			$data['sort_order'] = $circular_image[0]->sort_order;
			$data['status'] = $circular_image[0]->status;
		}
		else
		{
			$data['circular_image_id'] = "";
			$data['image'] = "";
			$data['image_position'] = "";
			$data['circular_image_title'] = "";
			$data['content'] = "";
			$data['title_color'] = "";
			$data['title_position'] = "";
			$data['content_title_color'] = "";
			$data['content_title_position'] = "";
			$data['content_color'] = "";
			$data['content_position'] = "";
			$data['title_hover_color'] = "";
			$data['content_title_hover_color'] = "";
			$data['content_hover_color'] = "";
			$data['background_hover_color'] = "";
			$data['redirect'] = "";
			$data['redirect_url'] = "";
			$data['open_new_tab'] = "";
			$data['background_color'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
		}

		$data['page_id'] = $page_id;
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();		
		$data['title'] = ($id != null) ? 'Edit Circular Image' : 'Add Circular Image' . ' | Administrator';
		$data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Circular Image';
		$this->load->view('template/meta_head', $data);
		$this->load->view('circular_image_header');
		$this->admin_header->index();
		$this->load->view('add_edit_circular_image', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	/**
	 * Update Circular Image Sort Order
	 */
	function update_sort_order()
	{
		$page_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Circular_image_model->update_sort_order($page_id, $row_sort_order);
	}

	// Insert Update Circular Image

	function insert_update_circular_image()
	{
		$circular_image_id = $this->input->post('circular_image_id');
		$page_id = $this->input->post('page_id');
		$continue = $this->input->post('btn_continue');
		$redirect = $this->input->post('redirect');
		$image = $this->input->post('image');
		$redirect = (isset($redirect)) ? '1' : '0';
		$error_config = array(
			array(
				'field' => 'image',
				'label' => 'Image',
				'rules' => 'required'
			) ,
			array(
				'field' => 'sort_order',
				'label' => 'Sort Order',
				'rules' => 'required'
			) ,
		);
		$readerror_config = array(
			array(
				'field' => 'redirect_url',
				'label' => 'Redirect URL',
				'rules' => 'required'
			)
		);
		if ($redirect == 1)
		{
			$error_config = array_merge($error_config, $readerror_config);
		}

		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($circular_image_id))
			{
				redirect('circular_image/add_edit_circular_image/' . $page_id);
			}
			else
			{
				redirect('circular_image/add_edit_circular_image/' . $page_id . '/' . $circular_image_id);
			}
		}
		else
		{
			if (empty($circular_image_id))
			{
				$insert_id = $this->Circular_image_model->insert_update_circular_image_data($page_id);
				$this->session->set_flashdata('success', 'Circular Image successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'circular_image/add_edit_circular_image/' . $page_id;
				}
				else
				{
					$url = 'circular_image/circular_image_index/' . $page_id;
				}
			}
			else
			{
				$this->Circular_image_model->insert_update_circular_image_data($page_id, $circular_image_id);
				$this->session->set_flashdata('success', 'Circular Image Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'circular_image/add_edit_circular_image/' . $page_id . '/' . $circular_image_id;
				}
				else
				{
					$url = 'circular_image/circular_image_index/' . $page_id;
				}
			}

			redirect($url);
		}
	}

	// Delete Circular Image

	function delete_circular_image($page_id)
	{
		$this->Circular_image_model->delete_circular_image($page_id);
		$this->session->set_flashdata('success', 'Successfully Deleted');
	}

	// Delete multiple Circular Image

	function delete_multiple_circular_image()
	{
		$page_id = $this->input->post('page_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('circular_image/circular_image_index/' . $page_id);
		}
		else
		{
			$this->Circular_image_model->delete_multiple_circular_image_data();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('circular_image/circular_image_index/' . $page_id);
		}
	}

	// Remove Image

	function remove_image()
	{
		$this->Circular_image_model->remove_image();
		echo '1';
	}
}