<?php
/**
 * Text Image Slider
 *
 * @category class
 * @package  Text Image Slider
 * @author   Karthika
 * Created at:  11-Dec-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Text_image_slider extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Text_image_slider_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	// Display all slider Image in a table

	function text_image_slider_index($page_id)
	{
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['text_image_slider_title_data'] = $this->Text_image_slider_model->get_text_image_slider_setting_details_data($this->admin_header->website_id() , $page_id, 'text_image_slider_title');

		// Get customized text& image slider   details from settings

		$data['text_image_slider_customize_data'] = $this->Text_image_slider_model->get_text_image_slider_setting_details_data($this->admin_header->website_id() , $page_id, 'text_image_slider_customize');

		// text& image slider title details from settings

		if (!empty($data['text_image_slider_title_data']))
		{
			$keys = json_decode($data['text_image_slider_title_data'][0]->key);
			$values = json_decode($data['text_image_slider_title_data'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['text_image_slider_title'] = '';
			$data['text_image_slider_title_color'] = '';
			$data['text_image_slider_title_position'] = '';
			$data['text_image_slider_title_status'] = '';
		}

		// text & image slider Customize details from settings

		if (!empty($data['text_image_slider_customize_data']))
		{
			$keys = json_decode($data['text_image_slider_customize_data'][0]->key);
			$values = json_decode($data['text_image_slider_customize_data'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			//  $data['text_image_slider_background'] = '';
			$data['text_image_slider_background_color'] = '';
			//   $data['text_image_slider_background_image'] = '';
		}

		$data['table'] = $this->get_table($page_id);
		$data['heading'] = 'Text Image Slider';
		$data['title'] = "Text Image Slider | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('text_image_slider_header');
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
		$slider_images = $this->Text_image_slider_model->get_text_image_slider($page_id);
		if (isset($slider_images) && $slider_images != "")
		{
			foreach($slider_images as $slider_image)
			{
				$anchor_edit = anchor('text_image_slider/add_edit_text_image_slider/' . $page_id . '/' . $slider_image->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $slider_image->id . ', \'' . base_url('text_image_slider/delete_text_image_slider/' . $page_id) . '\')'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_delete
				);
				if ($slider_image->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($slider_image->image != '')
				{	
					$slider_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $slider_image->image;

					$image = img(array(
						'src' => $slider_img,
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

				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $slider_image->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $slider_image->id . '">', ucwords($slider_image->title) , $image, $slider_image->sort_order, $status, $cell);
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
			id="datatable-responsive"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">',
			//'tbody_open' => '<tbody id = "table_row_sortable">'
		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading(array(
			'<input type="checkbox" id="check-all" class="flat">',
			'Title',
			'Slider Image',
			'Sort Order',
			'Status',
			'Action'
		));
		return $this->table->generate();
	}

	/**
	 * Update Text Image  Slider Sort Order
	 */
	function update_sort_order()
	{
		$page_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Text_image_slider_model->update_sort_order($page_id, $row_sort_order);
	}

	// Add & Edit Text Image Slider

	function add_edit_text_image_slider($page_id, $id = null)
	{
		$data['page_id'] = $page_id;
		if ($id != null)
		{
			$slider_image = $this->Text_image_slider_model->get_text_image_slider_by_id($page_id, $id);
			$data['slider_image_id'] = $slider_image[0]->id;
			$data['slider_image_title'] = $slider_image[0]->title;
			$data['title_color'] = $slider_image[0]->title_color;
			$data['title_position'] = $slider_image[0]->title_position;
			$data['text'] = $slider_image[0]->text;
			$data['content_title_color'] = $slider_image[0]->content_title_color;
			$data['content_title_position'] = $slider_image[0]->content_title_position;
			$data['content_color'] = $slider_image[0]->content_color;
			$data['image'] = $slider_image[0]->image;
			$data['image_title'] = $slider_image[0]->image_title;
			$data['image_alt'] = $slider_image[0]->image_alt;
			$data['image_position'] = $slider_image[0]->image_position;
			$data['readmore_btn'] = $slider_image[0]->readmore_btn;
			$data['button_type'] = $slider_image[0]->button_type;
			$data['btn_background_color'] = $slider_image[0]->btn_background_color;
			$data['readmore_label'] = $slider_image[0]->readmore_label;
			$data['label_color'] = $slider_image[0]->label_color;
			$data['readmore_url'] = $slider_image[0]->readmore_url;
			$data['open_new_tab'] = $slider_image[0]->open_new_tab;
			$data['background_hover'] = $slider_image[0]->background_hover;
			$data['text_hover'] = $slider_image[0]->text_hover;
			$data['readmore_character'] = $slider_image[0]->readmore_character;
			$data['border'] = $slider_image[0]->border;
			$data['border_size'] = $slider_image[0]->border_size;
			$data['border_color'] = $slider_image[0]->border_color;
			$data['sort_order'] = $slider_image[0]->sort_order;
			$data['status'] = $slider_image[0]->status;
		}
		else
		{
			$data['slider_image_id'] = "";
			$data['slider_image_title'] = "";
			$data['title_color'] = "";
			$data['title_position'] = "";
			$data['text'] = "";
			$data['content_title_color'] = "";
			$data['content_title_position'] = "";
			$data['content_color'] = "";
			$data['image'] = "";
			$data['image_title'] = "";
			$data['image_alt'] = "";
			$data['image_position'] = "";
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

		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['title'] = ($id != null) ? 'Edit Text Image Slider' : 'Add Text Image Slider' . ' | Administrator';
		$data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Text Image Slider';
		$this->load->view('template/meta_head', $data);
		$this->load->view('text_image_slider_header');
		$this->admin_header->index();
		$this->load->view('add_edit_text_image_slider', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Text Image Slider

	function insert_update_text_image_slider()
	{
		$page_id = $this->input->post('page-id');
		$slider_image_id = $this->input->post('slider-image-id');
		$continue = $this->input->post('btn_continue');
		$error_config = array(
			array(
				'field'	=> 'image',
				'label'	=> 'Image',
				'rules'	=> 'required'
			),
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
			if (empty($slider_image_id))
			{
				redirect('text_image_slider/add_edit_text_image_slider/' . $page_id);
			}
			else
			{
				redirect('text_image_slider/add_edit_text_image_slider/' . $page_id . '/' . $slider_image_id);
			}
		}
		else
		{
			if (empty($slider_image_id))
			{
				$insert_id = $this->Text_image_slider_model->insert_update_text_image_slider_data($page_id);
				$this->session->set_flashdata('success', 'Text Image  Slider successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'text_image_slider/add_edit_text_image_slider/' . $page_id;
				}
				else
				{
					$url = 'text_image_slider/text_image_slider_index/' . $page_id;
				}
			}
			else
			{
				$this->Text_image_slider_model->insert_update_text_image_slider_data($page_id, $slider_image_id);
				$this->session->set_flashdata('success', 'Slider Image Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'text_image_slider/add_edit_text_image_slider/' . $page_id . '/' . $slider_image_id;
				}
				else
				{
					$url = 'text_image_slider/text_image_slider_index/' . $page_id;
				}
			}

			redirect($url);
		}

		die;
	}

	function insert_update_text_image_slider_title()
	{
		$page_id = $this->input->post('page-id');		
		$this->Text_image_slider_model->insert_update_text_image_slider_title_data($page_id);
		redirect('text_image_slider/text_image_slider_index/' . $page_id);
	}

	// Insert & Update Text Image Slider Customization

	function insert_update_text_image_slider_customize()
	{
		$page_id = $this->input->post('page-id');
		$this->Text_image_slider_model->insert_update_text_image_slider_customize_data($page_id);
		redirect('text_image_slider/text_image_slider_index/' . $page_id);
	}

	// Delete Slider Image

	function delete_text_image_slider($page_id)
	{
		$this->Text_image_slider_model->delete_text_image_slider($page_id);
		$this->session->set_flashdata('success', 'Slider Image Successfully Deleted.');
		redirect('text_image_slider/text_image_slider_index/' . $page_id);
	}

	// Delete multiple Slider Image

	function delete_multiple_text_image_slider()
	{
		$page_id = $this->input->post('page_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('text_image_slider/text_image_slider_index/' . $page_id);
		}
		else
		{
			$this->Text_image_slider_model->delete_multiple_text_image_slider();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('text_image_slider/text_image_slider_index/' . $page_id);
		}
	}

	// Remove Image

	function remove_image()
	{
		$this->Text_image_slider_model->remove_images();
		echo '1';
	}
}