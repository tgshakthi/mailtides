<?php
/**
 * Hover Image
 *
 * @category class
 * @package  Hover Image
 * @author   Velu Samy
 * Created at:  05-Apr-2019
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Hover_image extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Hover_image_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}
	
	/**
	 * Hover Image Details
	 * Display All Hover Image in a table
	 */
	public function hover_image_index($page_id)
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		
		// Get Hover Image details from settings
		$data['hover_image_customize_data'] = $this->Hover_image_model->get_hover_image_setting_details($data['website_id'] ,$page_id,'hover_image_customize');
		
		// Hover Image Customize details from settings
		if (!empty($data['hover_image_customize_data']))
		{
			$keys = json_decode($data['hover_image_customize_data'][0]->key);
			$values = json_decode($data['hover_image_customize_data'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['hover_image_row_count'] = '';
		}
		
		// All Hover Image  in a table
		$data['table'] = $this->get_table($page_id);
		
		$data['heading'] = 'Hover Image';
		$data['title'] = "Hover Image | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('hover_image_header');
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
		$hover_images = $this->Hover_image_model->get_hover_image($page_id);
		if (isset($hover_images) && $hover_images != "")
		{
			foreach($hover_images as $hover_image)
			{
				$hover_image_details = json_decode($hover_image->hover_image_details);
				$anchor_edit = anchor(
					'hover_image/add_edit_hover_image/' . $page_id . '/' . $hover_image->id,
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
						'onclick' => 'return delete_record(' . $hover_image->id . ', \'' . base_url('hover_image/delete_hover_image/' . $page_id) . '\')'
					)
				);

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_delete
				);

				if ($hover_image->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($hover_image_details->primary_image != '')
				{
					$primary_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $hover_image_details->primary_image;

					$primary_image = img(array(
						'src' => $primary_img,
						'style' => 'width:145px; height:86px'
					));
				}
				else
				{
					$primary_image = img(array(
						'src' => $ImageUrl . 'images/noimage.png',
						'style' => 'width:145px; height:86px'
					));
				}
				
				if ($hover_image_details->secondary_image != '')
				{
					$secondary_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $hover_image_details->secondary_image;

					$secondary_image = img(array(
						'src' => $secondary_img,
						'style' => 'width:145px; height:86px'
					));
				}
				else
				{
					$secondary_image = img(array(
						'src' => $ImageUrl . 'images/noimage.png',
						'style' => 'width:145px; height:86px'
					));
				}

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $hover_image->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $hover_image->id . '">',
					ucwords($hover_image_details->hover_image_title) ,
					$primary_image,
					$secondary_image,
					$hover_image->sort_order,
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
			'Primary Image',
			'Secondary Image',
			'Sort Order',
			'Status',
			'Action'
		));
		return $this->table->generate();
	}
	
	// Insert & Update Hover Image Customization

	function insert_update_hover_image_customize()
	{
		$page_id = $this->input->post('page-id');
		$this->Hover_image_model->insert_update_hover_image_customize_data($page_id);
		redirect('hover_image/hover_image_index/' . $page_id);
	}
	
	// Add & Edit Hover Image

	function add_edit_hover_image($page_id, $id = NULL)
	{
		$data['hover_images'] = $this->Hover_image_model->get_hover_image_details($id, $page_id);
		$data['hover_image_id'] = $id;
		if(!empty($data['hover_images'])):
			
			$data['hover_image_details'] = json_decode($data['hover_images'][0]->hover_image_details);
			foreach($data['hover_image_details'] as $hover_image_detail => $val)
			{					
				$data[$hover_image_detail] = $val;
			}
			$data['sort_order'] = $data['hover_images'][0]->sort_order;
			$data['status'] = $data['hover_images'][0]->status;
		else:
			$data['hover_image_id'] = "";
			$data['primary_image'] = "";
			$data['secondary_image'] = "";
			$data['hover_image_title'] = "";
			$data['title_color'] = "";
			$data['title_hover_color'] = "";
			$data['title_background_color'] = "";
			$data['title_bg_hover_color'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
			
		endif;
	
		$data['page_id'] = $page_id;
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();		
		$data['title'] = ($id != null) ? 'Edit Hover Image' : 'Add Hover Image' . ' | Administrator';
		$data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Hover Image';
		$this->load->view('template/meta_head', $data);
		$this->load->view('hover_image_header');
		$this->admin_header->index();
		$this->load->view('add_edit_hover_image', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Insert Update Hover Image
	function insert_update_hover_image()
	{
		$page_id = $this->input->post('page_id');
		$continue	= $this->input->post('btn_continue');
		$hover_image_id	= $this->input->post('hover_image_id');
		$website_id	= $this->input->post('website_id');
	   
		$error_config = array(
							
							array(
								'field'	=> 'content',
								'label'	=> 'Title',
								'rules'	=> 'required'
								) 
							);
		$this->form_validation->set_rules($error_config);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($hover_image_id))
			{
				redirect('hover_image/add_edit_hover_image/' . $page_id);
			}
			else
			{
				redirect('hover_image/add_edit_hover_image/' . $page_id . '/' . $hover_image_id);
			}
		}
		else
		{
			if (empty($hover_image_id))
			{
				$insert_id	= $this->Hover_image_model->insert_update_hover_image_model($page_id);
				$this->session->set_flashdata('success', 'Hover Image Successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'hover_image/add_edit_hover_image/' . $page_id;
				}
				else
				{
					$url = 'hover_image/hover_image_index/' . $page_id;
				}
			}
			else
			{
				$this->Hover_image_model->insert_update_hover_image_model($page_id, $hover_image_id);
				$this->session->set_flashdata('success', 'Hover Image Successfully updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'hover_image/add_edit_hover_image/' . $page_id . '/' . $hover_image_id;
				}
				else
				{
					$url = 'hover_image/hover_image_index/'.$page_id;
				}
			}
			redirect($url);
		}
	}

	// Delete Hover Image

	function delete_hover_image($page_id)
	{
		$this->Hover_image_model->delete_hover_image($page_id);
		$this->session->set_flashdata('success', 'Successfully Deleted');
	}

	// Delete multiple Hover Image

	function delete_multiple_hover_image()
	{
		$page_id = $this->input->post('page_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('hover_image/hover_image_index/' . $page_id);
		}
		else
		{
			$this->Hover_image_model->delete_multiple_hover_image_data();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('hover_image/hover_image_index/' . $page_id);
		}
	}
		

}