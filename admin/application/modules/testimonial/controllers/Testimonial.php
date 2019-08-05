<?php
/**
 * Testimonial
 *
 * @category class
 * @package  Testimonial
 * @author   Athi
 * Created at:  14-Aug-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Testimonial extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->session_data = $this->session->userdata('logged_in');
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Testimonial_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	/**
	 * Display all Testimonial in a table
	 * get table data from get table method
	 */

	function index()
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		
		$data['website_id'] = $this->admin_header->website_id();
		$data['table']	= $this->get_table($data['website_id']);
		
		$data['heading']	= 'Testimonial';
		$data['title']	= "Testimonial | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('testimonial_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	/**
	 * Table
	 * get all data from model
	 * generate data table
	 * with multiple delete option
	 */

	function get_table($website_id)
	{
		$testimonials	= $this->Testimonial_model->get_testimonial($website_id);
		$ImageUrl	= $this->admin_header->image_url();
		$website_folder_name = $this->admin_header->website_folder_name();
		if (!empty($testimonials))
		{
			foreach($testimonials as $testimonial)
			{
				$anchor_edit = anchor(site_url(
					'testimonial/add_edit_testimonial/'.$testimonial->id),
					'<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>',
					array(
						'data-toggle'	=> 'tooltip',
						'data-placement'	=> 'left',
						'data-original-title'	=> 'Edit'
					)
				);

				$anchor_delete = anchor(
					'' ,
					'<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>',
					array(
					'data-toggle' 				=> 'tooltip',
					'data-placement' 			=> 'right',
					'data-original-title'	=> 'Delete',
					'onclick' => 'return delete_record('.$testimonial->id.', \''.base_url('testimonial/delete_testimonial').'\')'
				));

				if ($testimonial->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($testimonial->image != '')
				{
					$testimonial_image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $testimonial->image;

					$image	= img(array(
                    	'src'   => $testimonial_image,
                    	'style' => 'width:145px; height:86px'
                  	));
				}
				else
				{
					$image	= img(array(
                    	'src'   => $ImageUrl.'images/noimage.png',
                    	'style' => 'width:145px; height:86px'
                  	));
				}

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . ' ' . $anchor_delete
				);
				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $testimonial->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $testimonial->id . '">',
					ucwords($testimonial->author),
					$image,
					$testimonial->sort_order,
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

		$this->table->set_heading(
			'<input type="checkbox" id="check-all" class="flat">',
			'Author',
			'Image',
			'Sort Order',
			'Status',
			'Action'
		);
		return $this->table->generate();
	}
	
	// Testimonial Page
	function testimonial_page($page_id)
	{
			$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		
		$data['testimonials_unselected']	= $this->Testimonial_model->get_testimonial_unselected($data['website_id'], $page_id);
		$data['testimonials_selected']	= $this->Testimonial_model->get_testimonial_selected($data['website_id'], $page_id);
		
		$testimonial_pages	= $this->Testimonial_model->get_testimonial_page_by_id($data['website_id'], $page_id);
		if(!empty($testimonial_pages))
		{
			($testimonial_pages[0]->testimonial == '') ? $data['testimonials_unselected']	= $this->Testimonial_model->get_testimonial($data['website_id']): '';
			
			$data['testimonial_id'] 		= $testimonial_pages[0]->id;
			$data['testimonial_title'] 		= $testimonial_pages[0]->title;
			$data['title_color'] 			= $testimonial_pages[0]->title_color;
			$data['title_position'] 		= $testimonial_pages[0]->title_position;
			$data['testimonial_per_row'] 	= $testimonial_pages[0]->testimonial_per_row;
			$data['background'] 			= $testimonial_pages[0]->background;
			$data['background_js'] 		    = json_decode($data['background']);
			if(!empty($data['background_js']))
				{
					$data['component_background']   = $data['background_js']->component_background;
					$data['testimonial_background'] = $data['background_js']->testimonial_background;
				}
			else
				{
					$data['component_background']   = '';
					$data['testimonial_background'] = '';
				}
			
			
			
			
			
			$data['status'] = $testimonial_pages[0]->status;
		}
		else
		{
			$data['testimonials_unselected']	= $this->Testimonial_model->get_testimonial($data['website_id']);
			
			$data['testimonial_id'] = '';
			$data['testimonial_title'] = '';
			$data['title_color'] = '';
			$data['title_position'] = '';
			$data['testimonial_per_row'] = '';
			$data['background'] = '';
			$data['component_background']   = '';
			$data['testimonial_background'] = '';
			$data['status'] = '';
		}
		
		$data['heading']	= 'Testimonial Page';
		$data['title']	= "Testimonial Page | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('testimonial_header');
		$this->admin_header->index();
		$this->load->view('testimonial_page', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	/**
	 * Update Testimonial Sort Order
	 */
	function update_sort_order()
	{
		$website_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Testimonial_model->update_sort_order($website_id, $row_sort_order);
	}
	
	/**
	 * Add and Edit Testimonial
	 */

	function add_edit_testimonial($id = null)
	{
		$data['website_id'] = $this->admin_header->website_id();
		if ($id != null)
		{
			$testimonial = $this->Testimonial_model->get_testimonial_by_id($id);

			$data['testimonial_id'] = $testimonial[0]->id;
			$data['image'] = $testimonial[0]->image;
			$data['image_alt'] = $testimonial[0]->image_alt;
			$data['image_title'] = $testimonial[0]->image_title;
			$data['image_type'] = $testimonial[0]->image_type;
			$data['author'] = $testimonial[0]->author;
			$data['content'] = $testimonial[0]->content;
			$data['author_color'] = $testimonial[0]->author_color;
			$data['author_hover'] = $testimonial[0]->author_hover;
			$data['designation'] = $testimonial[0]->designation;
			$data['designation_color'] = $testimonial[0]->designation_color;
			$data['designation_hover'] = $testimonial[0]->designation_hover;
			$data['content_title_color'] = $testimonial[0]->content_title_color;
			$data['content_title_position'] = $testimonial[0]->content_title_position;
			$data['content_color'] = $testimonial[0]->content_color;
			$data['content_position'] = $testimonial[0]->content_position;
			$data['content_title_hover_color'] = $testimonial[0]->content_title_hover_color;
			$data['content_hover_color'] = $testimonial[0]->content_hover_color;
			$data['redirect'] = $testimonial[0]->redirect;
			$data['redirect_url'] = $testimonial[0]->redirect_url;
			$data['open_new_tab'] = $testimonial[0]->open_new_tab;
			$data['background_hover_color'] = $testimonial[0]->background_hover_color;
			$data['background_color'] = $testimonial[0]->background_color;
			$data['sort_order'] = $testimonial[0]->sort_order;
			$data['status'] = $testimonial[0]->status;
		}
		else
		{
			$data['testimonial_id'] = "";
			$data['image'] = "";
			$data['image_alt'] = "";
			$data['image_title'] = "";
			$data['image_type'] = "";
			$data['author'] = "";
			$data['content'] = "";
			$data['author_color'] = "";
			$data['author_hover'] = "";
			$data['designation'] = "";
			$data['designation_color'] = "";
			$data['designation_hover'] = "";
			$data['content_title_color'] = "";
			$data['content_title_position'] = "";
			$data['content_color'] = "";
			$data['content_position'] = "";
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
		
		$data['httpUrl']	= $this->admin_header->host_url();
		$data['ImageUrl']	= $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		
		$data['heading']	= (($id != null) ? 'Edit Testimonial' : 'Add Testimonial');
		$data['title']	= (($id != null) ? 'Edit Testimonial' : 'Add Testimonial') . ' | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('testimonial_header');
		$this->admin_header->index();
		$this->load->view('add_edit_testimonial', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Insert Update Testimonial Page
	function insert_update_testimonial_page()
	{
		$testimonial_id	= $this->input->post('testimonial_id');
		$page_id	= $this->input->post('page_id');
		$website_id	= $this->input->post('website_id');
		$continue	= $this->input->post('btn_continue');
		
		if (empty($testimonial_id))
		{
			$this->Testimonial_model->insert_update_testimonial_page();
			$this->session->set_flashdata('success', 'Testimonial Successfully Created');
		}
		else
		{
			$this->Testimonial_model->insert_update_testimonial_page($testimonial_id);
			$this->session->set_flashdata('success', 'Testimonial Successfully Updated.');
		}
		
		if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
		{
			$url = 'testimonial/testimonial_page/'.$page_id;
		}
		else
		{
			$url = 'page/page_details/'.$page_id;
		}
		
		redirect($url);
	}
	
	// Insert & Update Testimonial
	function insert_update_testimonial()
	{
		$testimonial_id	= $this->input->post('testimonial_id');
		$continue	= $this->input->post('btn_continue');
		
		$redirect	= $this->input->post('redirect');
		$redirect	= (isset($redirect)) ? '1' : '0';
		
		$error_config = array(
			array(
				'field'	=> 'sort_order',
				'label'	=> 'Sort Order',
				'rules'	=> 'required'
			)
		);
		
		if($redirect == 1)
		{
			$redirect_error_config = array(
				array(
					'field'	=> 'redirect_url',
					'label'	=> 'Redirect URL',
					'rules'	=> 'required'
				)
			);
			$error_config = array_merge($error_config, $redirect_error_config);
		}

		$this->form_validation->set_rules($error_config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($testimonial_id))
			{
				redirect('testimonial/add_edit_testimonial');
			}
			else
			{
				redirect('testimonial/add_edit_testimonial/'.$testimonial_id);
			}
		}
		else
		{
			if (empty($testimonial_id))
			{
				$insert_id	= $this->Testimonial_model->insert_update_testimonial();
				$this->session->set_flashdata('success', 'Testimonial successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'testimonial/add_edit_testimonial';
				}
				else
				{
					$url = 'testimonial';
				}
			}
			else
			{
				$this->Testimonial_model->insert_update_testimonial($testimonial_id);
				$this->session->set_flashdata('success', 'Testimonial Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'testimonial/add_edit_testimonial/'.$testimonial_id;
				}
				else
				{
					$url = 'testimonial';
				}
			}
			redirect($url);
		}
	}
	
	// Delete Testimonial
	function delete_testimonial()
	{
		$id = $this->input->post('id');
		$this->Testimonial_model->delete_testimonial($id);
		$this->session->set_flashdata('success', 'Testimonial Successfully Deleted.');
	}
	
	// Delete multiple Testimonial
	function delete_multiple_testimonial()
	{
		$this->form_validation->set_rules(
			'table_records[]',
			'Row',
			'required',
			array(
				'required' => 'You must select at least one row!'
			)
		);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('testimonial');
		}
		else
		{
			$this->Testimonial_model->delete_multiple_testimonial();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('testimonial');
		}
	}
	
	// Remove Image
	function remove_image()
	{
		$this->Testimonial_model->remove_testimonial_image();
		echo '1';
	}
}
