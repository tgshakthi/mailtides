<?php
/**
 * Image Card
 *
 * @category class
 * @package  Image Card
 * @author   Saravana
 * Created at:  26-Jun-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Image_card extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Image_card_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	/**
	 * Image Card Details
	 * Display Image Card Title details
	 * Display Image Card Customization details
	 * Display All Image Cards in a table
	 */
	public

	function image_card_index($page_id)
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();

		// All Image Card in a table

		$data['table'] = $this->get_table($page_id);

		// Get Image Card details from settings

		$data['image_card_title_data'] = $this->Image_card_model->get_image_card_setting_details(
			$this->admin_header->website_id() ,
			$page_id,
			'image_card_title'
		);

		// Get Image Card details from settings

		$data['image_card_customize_data'] = $this->Image_card_model->get_image_card_setting_details(
			$this->admin_header->website_id() ,
			$page_id,
			'image_card_customize'
		);
	 
		// Image Card title details from settings

		if (!empty($data['image_card_title_data']))
		{
			$keys = json_decode($data['image_card_title_data'][0]->key);
			$values = json_decode($data['image_card_title_data'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['image_card_title'] = '';
			$data['image_card_title_color'] = '';
			$data['image_card_title_position'] = '';
			$data['image_card_title_status'] = '';
		}

		// Image Card Customize details from settings
        //echo"<pre>";
		if (!empty($data['image_card_customize_data']))
		{
			$keys = json_decode($data['image_card_customize_data'][0]->key);
			$values = json_decode($data['image_card_customize_data'][0]->value);
			
			$i = 0;
			
			foreach($keys as $key)
			{   
				// print_r($key);
				// print_r($values);
		
				$data[$key] = $values[$i];
				$i++;
			}
		
		}
	
		else
		{
			$data['row_count'] = '';
			$data['component_background'] = '';
			$data['image_card_background'] = '';
		}

		$data['heading'] = 'Image Card';
		$data['title'] = "Image Card | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('image_card_header');
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
		$image_cards = $this->Image_card_model->get_image_card($page_id);
		if (isset($image_cards) && $image_cards != "")
		{
			foreach($image_cards as $image_card)
			{
				$anchor_edit = anchor(
					'image_card/add_edit_image_card/' . $page_id . '/' . $image_card->id,
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
						'onclick' => 'return delete_record(' . $image_card->id . ', \'' . base_url('image_card/delete_image_card/' . $page_id) . '\')'
					)
				);

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_delete
				);

				if ($image_card->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($image_card->image != '')
				{

					$image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image_card->image;

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

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $image_card->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $image_card->id . '">',
					ucwords($image_card->title) ,
					$image,
					$image_card->sort_order,
					$status,
					$cell
				);
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
			'Image',
			'Sort Order',
			'Status',
			'Action'
		));
		return $this->table->generate();
	}
	
	/**
	 * Update Image Card Sort Order
	 */
	function update_sort_order()
	{
		$page_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Image_card_model->update_sort_order($page_id, $row_sort_order);
	}

	// Insert & Update Image Card Title

	function insert_update_image_card_title()
	{
		$page_id = $this->input->post('page-id');		
		$this->Image_card_model->insert_update_image_card_title_data($page_id);
		redirect('image_card/image_card_index/' . $page_id);
	}

	// Insert & Update Image Card Customization

	function insert_update_image_card_customize()
	{
	
		$page_id = $this->input->post('page-id');
		$this->Image_card_model->insert_update_image_card_customize_data($page_id);
		redirect('image_card/image_card_index/' . $page_id);
	}

	// Add & Edit Image Card

	function add_edit_image_card($page_id, $id = NULL)
	{
		if ($id != null)
		{
			$image_card = $this->Image_card_model->get_image_card_by_id($page_id, $id);
			$data['image_card_id'] = $image_card[0]->id;
			$data['image'] = $image_card[0]->image;
			$data['image_card_title'] = $image_card[0]->title;
	        $data['description'] = $image_card[0]->description;
			$data['title_color'] = $image_card[0]->title_color;	
			$data['title_position'] = $image_card[0]->title_position;
		    $data['desc_title_color'] = $image_card[0]->description_title_color;
			$data['desc_title_position'] = $image_card[0]->description_title_position;
			$data['desc_color'] = $image_card[0]->description_color;
			$data['desc_position'] = $image_card[0]->description_position;
			$data['readmore_btn'] = $image_card[0]->readmore_btn;
			$data['button_type'] = $image_card[0]->button_type;
			$data['btn_background_color'] = $image_card[0]->btn_background_color;
			$data['readmore_label'] = $image_card[0]->readmore_label;
			$data['readmore_label_color'] = $image_card[0]->readmore_label_color;
			$data['readmore_url'] = $image_card[0]->readmore_url;
			$data['open_new_tab'] = $image_card[0]->open_new_tab;
			$data['btn_background_hover'] = $image_card[0]->btn_hover_color;
			$data['btn_label_hover_color'] = $image_card[0]->btn_label_hover_color;
		    $data['background_color'] = $image_card[0]->background_color;
			$data['sort_order'] = $image_card[0]->sort_order;
			$data['status'] = $image_card[0]->status;
		}
		else
		{
			$data['image_card_id'] = "";
			$data['image'] = "";
			$data['image_card_title'] = "";
		    $data['description'] = "";
			$data['title_color'] = "";
			$data['title_position'] = "";
		    $data['desc_title_color'] = "";
			$data['desc_title_position'] = "";
			$data['desc_color'] = "";
			$data['desc_position'] = "";
			$data['readmore_btn'] = "";
			$data['button_type'] = "";
	        $data['btn_background_color'] = "";
			$data['readmore_label'] = "";
			$data['readmore_label_color'] = "";
			$data['readmore_url'] = "";
			$data['open_new_tab'] = "";
			$data['btn_background_hover'] = "";
			$data['btn_label_hover_color'] = "";
		    $data['background_color'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
		}

		$data['page_id'] = $page_id;
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['title'] = ($id != null) ? 'Edit Image Card' : 'Add Image Card' . ' | Administrator';
		$data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Image Card';
		$this->load->view('template/meta_head', $data);
		$this->load->view('image_card_header');
		$this->admin_header->index();
		$this->load->view('add_edit_image_card', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert Update Image Card

	function insert_update_image_card()
	{
		
		$image_card_id = $this->input->post('image_card_id');
		$page_id = $this->input->post('page_id');
		$continue = $this->input->post('btn_continue');
		$readmore_btn = $this->input->post('readmore_btn');
		$image = $this->input->post('image');
		$readmore_btn = (isset($readmore_btn)) ? '1' : '0';
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
				'field' => 'readmore_url',
				'label' => 'Readmore URL',
				'rules' => 'required'
			)
		);
		if ($readmore_btn == 1)
		{
			$error_config = array_merge($error_config, $readerror_config);
		}

		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($image_card_id))
			{
				redirect('image_card/add_edit_image_card/' . $page_id);
			}
			else
			{
				redirect('image_card/add_edit_image_card/' . $page_id . '/' . $image_card_id);
			}
		}
		else
		{
			if (empty($image_card_id))
			{
				$insert_id = $this->Image_card_model->insert_update_image_card_data($page_id);
				$this->session->set_flashdata('success', 'Image Card successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'image_card/add_edit_image_card/' . $page_id;
				}
				else
				{
					$url = 'image_card/image_card_index/' . $page_id;
				}
			}
			else
			{
				$this->Image_card_model->insert_update_image_card_data($page_id, $image_card_id);
				$this->session->set_flashdata('success', 'Image Card Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'image_card/add_edit_image_card/' . $page_id . '/' . $image_card_id;
				}
				else
				{
					$url = 'image_card/image_card_index/' . $page_id;
				}
			}

			redirect($url);
		}
	}

	// Delete Image Card

	function delete_image_card($page_id)
	{
		$this->Image_card_model->delete_image_card($page_id);
		$this->session->set_flashdata('success', 'Successfully Deleted');
	}

	// Delete multiple Image Card

	function delete_multiple_image_card()
	{
		$page_id = $this->input->post('page_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('image_card/image_card_index/' . $page_id);
		}
		else
		{
			$this->Image_card_model->delete_multiple_image_card_data();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('image_card/image_card_index/' . $page_id);
		}
	}

	// Remove Image

	function remove_image()
	{
		$this->Image_card_model->remove_image();
		echo '1';
	}
}
