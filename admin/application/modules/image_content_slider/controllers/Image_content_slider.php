<?php
/**
 * Image Content Slider
 *
 * @category class
 * @package  Image Content Slider
 * @author   Velu
 * Created at:  17-Dec-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Image_content_slider extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->session_data = $this->session->userdata('logged_in');
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Image_content_slider_model');
		$this->load->module('admin_header');
		$this->load->module('color');
		$this->load->helper('text');
	}

	function image_content_slider_index($page_id)
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		
		// Image content slider customization
		$data['image_content_slider_title_data'] = $this->Image_content_slider_model->get_image_content_slider_setting_details($this->admin_header->website_id() , $page_id, 'Image_content_slider_title');
		
		if (!empty($data['image_content_slider_title_data'])):
			$keys = json_decode($data['image_content_slider_title_data'][0]->key);
			$values = json_decode($data['image_content_slider_title_data'][0]->value);
			$i = 0;
			foreach($keys as $key):
				$data[$key] = $values[$i];
				$i++;
			endforeach;
		else:
			$data['image_content_slider_title'] = '';
			$data['image_content_slider_content'] = '';
			$data['image_content_slider_title_status'] = '';
		endif;

		// Get Image content slider details in setting table

		$data['image_content_slider_customize'] = $this->Image_content_slider_model->get_image_content_slider_setting_details($this->admin_header->website_id() , $page_id, 'Image_content_slider_customize');
	
		if (!empty($data['image_content_slider_customize'])):
			$keys = json_decode($data['image_content_slider_customize'][0]->key);
			$values = json_decode($data['image_content_slider_customize'][0]->value);
			$i = 0;
			foreach($keys as $key):
				$data[$key] = $values[$i];
				$i++;
			endforeach;
		else:
			$data['title_color'] = '';
			$data['title_position'] = '';
			$data['content_title_color'] = '';
			$data['content_title_position'] = '';
			$data['content_color'] = '';
			$data['content_position'] = '';
			$data['image_content_slider_position']='';
			$data['row_count'] = '';
			$data['component_background'] = '';
			$data['image_content_background'] = '';
			$data['readmore_btn'] = '';
			$data['button_type'] = '';
			$data['button_position'] = '';
			$data['btn_background_color'] = '';
			$data['readmore_label'] = '';
			$data['readmore_label_color'] = '';
			$data['readmore_url'] = '';
			$data['open_new_tab'] = '';
			$data['btn_background_hover'] = '';
			$data['btn_label_hover'] = ''; 
		endif;
		
		$data['title'] = "Image Content Slider | Administrator";
		$data['heading'] = 'Image Content Slider';
		$data['page_id'] = $page_id;
		$data['table'] = $this->get_table($page_id);
		$this->load->view('template/meta_head', $data);
		$this->load->view('image_content_slider_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Get Table
	function get_table($page_id)
	{
		$website_id = $this->admin_header->website_id();
		$ImageUrl = $this->admin_header->image_url();
		$website_folder_name = $this->admin_header->website_folder_name();
		$image_content_slider_datas = $this->Image_content_slider_model->get_image_content($website_id, $page_id);
		if (isset($image_content_slider_datas) && $image_content_slider_datas != ""):
			foreach($image_content_slider_datas as $image_content_slider_data):
				$image_content_slider = json_decode($image_content_slider_data->content);
				$anchor_edit = anchor('image_content_slider/add_edit_image_content_slider/' . $page_id . '/' . $image_content_slider_data->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $image_content_slider_data->id . ', \'' . base_url('image_content_slider/delete_image_content_slider/' . $page_id) . '\')'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_delete
				);
				if ($image_content_slider->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($image_content_slider->image != '')
				{
					$image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image_content_slider->image;
					$image = img(array(
						'src' => $image,
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

				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $image_content_slider_data->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $image_content_slider_data->id . '">', ucwords($image_content_slider->title_image) , $image, $image_content_slider->sort_order, $status, $cell);
			endforeach;
		endif;

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

	// Insert Update Image content slider - Title customization
	function insert_update_image_content_slider_title()
	{
		$page_id = $this->input->post('page_id');
		$this->Image_content_slider_model->insert_update_image_content_slider_title($page_id);
		redirect('image_content_slider/image_content_slider_index/' . $page_id);
	}

	// Insert Update Image Content slider - Customization
	function insert_image_content_slider_customize()
	{
		$page_id = $this->input->post('page_id');
		$this->Image_content_slider_model->insert_update_image_content_slider_customize($page_id);
		redirect('image_content_slider/image_content_slider_index/' . $page_id);
	}

	// Add & Edit Image Content Slider
	function add_edit_image_content_slider($page_id, $id = null)
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['page_id'] = $page_id;
		$data['add_edit_image'] = $this->Image_content_slider_model->get_image_content_slider_by_id($data['website_id'], $id);
		if (!empty($data['add_edit_image'])):
			$data['image_content_slider_id'] = $data['add_edit_image'][0]->id;
			$data['contents'] = json_decode($data['add_edit_image'][0]->content);
			foreach($data['contents'] as $key => $val)
			{
				$data[$key] = $val;
			}
			else:
				$data['image_content_slider_id'] = '';
				$data['image'] = '';
				$data['image_title'] = '';
				$data['image_alt'] = '';
				$data['title_image'] = '';
				$data['text'] = '';
				$data['title_color'] = '';
				$data['title_position'] = '';
				$data['content_color'] = '';
				$data['content_position'] = '';
				$data['background_color'] = '';
				$data['sort_order'] = '';
				$data['status'] = '';
			endif;

			$data['httpUrl'] = $this->admin_header->host_url();
			$data['ImageUrl'] = $this->admin_header->image_url();
			$data['website_folder_name'] = $this->admin_header->website_folder_name();
			$data['title'] = ($data['add_edit_image'] != null) ? 'Edit Image Content Slider' : 'Add Image Content Slider' . ' | Administrator';
			$data['heading'] = (($data['add_edit_image'] != null) ? 'Edit' : 'Add') . ' Image Content Slider';
			$this->load->view('template/meta_head', $data);
			$this->load->view('image_content_slider_header');
			$this->admin_header->index();
			$this->load->view('add_edit_image', $data);
			$this->load->view('template/footer_content');
			$this->load->view('script');
			$this->load->view('template/footer');
		}

		// Insert Update Image Content Slider
		function insert_update_add_edit_image_content_slider()
		{
			$page_id = $this->input->post('page_id');
			$website_id = $this->input->post('website_id');
			$image_content_slider_id = $this->input->post('image_content_slider_id');
			$continue = $this->input->post('btn_continue');
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
				)
			);
			$this->form_validation->set_rules($error_config);
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('error', validation_errors());
				if (empty($image_content_slider_id))
				{
					redirect('image_content_slider/add_edit_image_content_slider/' . $page_id);
				}
				else
				{
					redirect('image_content_slider/add_edit_image_content_slider/' . $page_id . '/' . $image_content_slider_id);
				}
			}
			else
			{
				if (empty($image_content_slider_id))
				{
					$insert_id = $this->Image_content_slider_model->insert_update_image_content_slider($page_id);
					$this->session->set_flashdata('success', 'Image Content Slider Successfully Created');
					if (isset($continue) && $continue === "Add & Continue")
					{
						$url = 'image_content_slider/add_edit_image_content_slider/' . $page_id;
					}
					else
					{
						$url = 'image_content_slider/image_content_slider_index/' . $page_id;
					}
				}
				else
				{
					$this->Image_content_slider_model->insert_update_image_content_slider($page_id, $image_content_slider_id);
					$this->session->set_flashdata('success', 'Image Content Slider Successfully updated.');
					if (isset($continue) && $continue === "Update & Continue")
					{
						$url = 'image_content_slider/add_edit_image_content_slider/' . $page_id . '/' . $image_content_slider_id;
					}
					else
					{
						$url = 'image_content_slider/image_content_slider_index/' . $page_id;
					}
				}

				redirect($url);
			}
		}

		// Delete Image content slider
		function delete_image_content_slider($page_id)
		{
			$this->Image_content_slider_model->delete_image_content_slider($page_id);
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('image_content_slider/image_content_slider_index/' . $page_id);
		}

		// Delete Multiple Image Content slider
		function delete_multiple_image_content_slider()
		{
			$page_id = $this->input->post('page_id');
			$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
				'required' => 'You must select at least one row!'
			));
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('error', validation_errors());
				redirect('image_content_slider/image_content_slider_index/' . $page_id);
			}
			else
			{
				$this->Image_content_slider_model->delete_multiple_image_content_slider();
				$this->session->set_flashdata('success', 'Successfully Deleted');
				redirect('image_content_slider/image_content_slider_index/' . $page_id);
			}
		}

		// Remove Image
		function remove_image()
		{
			$website_id = $this->input->post('website_id');
			$id = $this->input->post('id');
			$image_content_slider = $this->Image_content_slider_model->get_image_content_slider_by_id($website_id, $id);

			if (!empty($image_content_slider)) :
				$image_content_slider_data = json_decode($image_content_slider[0]->content);

				$remove_image_array = array(
					'image' => "",
					'image_title' => $image_content_slider_data->image_title,
					'image_alt' => $image_content_slider_data->image_alt,
					'title_image' => $image_content_slider_data->title_image,
					'title_color' => $image_content_slider_data->title_color,
					'title_position' => $image_content_slider_data->title_position,
					'text' => $image_content_slider_data->text,
					'content_color' => $image_content_slider_data->content_color,
					'content_position' => $image_content_slider_data->content_position,
					'background_color' => $image_content_slider_data->background_color,
					'sort_order' => $image_content_slider_data->sort_order,
					'status' => $image_content_slider_data->status
				);

				$remove_image_array = json_encode($remove_image_array);
				
				$this->Image_content_slider_model->remove_image($website_id, $id, $remove_image_array);
				echo '1';
				
			endif;
			
		}
	}

?>