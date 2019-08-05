<?php
/**
 * Gallery
 *
 * @category class
 * @package  Gallery
 * @author   Saravana
 * Created at:  10-Jul-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Gallery_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	// Display all Gallery in a table

	function gallery_index($page_id)
	{
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['table'] = $this->get_table($page_id);

		// Get Gallery details from settings

		$data['gallery_title_data'] = $this->Gallery_model->get_gallery_setting_details(
			$this->admin_header->website_id() ,
			$page_id,
			'gallery_title'
		);

		// Get Gallery details from settings

		$data['gallery_customize_data'] = $this->Gallery_model->get_gallery_setting_details(
			$this->admin_header->website_id() ,
			$page_id,
			'gallery_customize'
		);
		
		// Gallery title details from settings

		if (!empty($data['gallery_title_data']))
		{
			$keys = json_decode($data['gallery_title_data'][0]->key);
			$values = json_decode($data['gallery_title_data'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['gallery_title'] = '';
			$data['gallery_title_color'] = '';
			$data['gallery_title_position'] = '';
			$data['gallery_title_status'] = '';
		}

		// Gallery Customize details from settings

		if (!empty($data['gallery_customize_data']))
		{
			$keys = json_decode($data['gallery_customize_data'][0]->key);
			$values = json_decode($data['gallery_customize_data'][0]->value);
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
			$data['gallery_image_background'] = '';
		}

		$data['heading'] = 'Gallery';
		$data['title'] = "Gallery | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('gallery_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Gallery Category

	function category($page_id)
	{
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['table'] = $this->get_category_table($page_id, $data['website_id']);
		$data['heading'] = 'Gallery Category';
		$data['title'] = "Gallery - Category | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('gallery_header');
		$this->admin_header->index();
		$this->load->view('view_category', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Get Gallery Category Table

	function get_category_table($page_id, $website_id)
	{
		$gallery_categories = $this->Gallery_model->get_gallery_category($website_id);
		if (isset($gallery_categories) && $gallery_categories != "")
		{
			foreach($gallery_categories as $gallery_category)
			{
				$anchor_edit = anchor(
					'gallery/add_edit_category/' . $page_id . '/' . $website_id . '/' . $gallery_category->id,
					'<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>',
					array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_delete = anchor('',
				'<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>',
				array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $gallery_category->id . ', \'' . base_url('gallery/delete_category/' . $website_id) . '\')'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_delete
				);
				if ($gallery_category->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $gallery_category->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $gallery_category->id . '">',
					$gallery_category->category_name,
					$gallery_category->sort_order,
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
			'Category',
			'Sort Order',
			'Status',
			'Action'
		));
		return $this->table->generate();
	}

	// Add & Edit Category

	function add_edit_category($page_id, $website_id, $category_id = null)
	{
		if ($category_id != null)
		{
			$category = $this->Gallery_model->get_gallery_category_by_id($category_id, $website_id);
			$data['category_id'] = $category[0]->id;
			$data['category_name'] = $category[0]->category_name;
			$data['sort_order'] = $category[0]->sort_order;
			$data['status'] = $category[0]->status;
		}
		else
		{
			$data['category_id'] = "";
			$data['category_name'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
		}

		$data['page_id'] = $page_id;
		$data['website_id'] = $website_id;
		$data['title'] = ($category_id != null) ? 'Edit Gallery Category' : 'Add Gallery Category' . ' | Administrator';
		$data['heading'] = (($category_id != null) ? 'Edit' : 'Add') . ' Gallery Category';
		$this->load->view('template/meta_head', $data);
		$this->load->view('gallery_header');
		$this->admin_header->index();
		$this->load->view('add_edit_category', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert Update Gallery Category

	function insert_update_gallery_category()
	{
		$category_id = $this->input->post('category_id');
		$page_id = $this->input->post('page-id');
		$website_id = $this->input->post('website_id');
		$continue = $this->input->post('btn_continue');

		$quick_category = $this->input->post('quick_category');

		if(!empty($quick_category))
		{
			$gallery_id = $this->input->post('gallery_id');
			$this->Gallery_model->insert_update_gallery_category_data($website_id);
			redirect('gallery/add_edit_gallery/' . $page_id . '/' . $gallery_id);
			exit();
		}

		$error_config = array(
			array(
				'field' => 'category_name',
				'label' => 'Category Name',
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
			if (empty($category_id))
			{
				redirect('gallery/add_edit_category/' . $page_id . '/' . $website_id);
			}
			else
			{
				redirect('gallery/add_edit_category/' . $page_id . '/' . $website_id . '/' . $category_id);
			}
		}
		else
		{
			if (empty($category_id))
			{
				$insert_id = $this->Gallery_model->insert_update_gallery_category_data($website_id);
				$this->session->set_flashdata('success', 'Gallery successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'gallery/add_edit_category/' . $page_id . '/' . $website_id;
				}
				else
				{
					$url = 'gallery/category/' . $page_id;
				}
			}
			else
			{
				$this->Gallery_model->insert_update_gallery_category_data($website_id, $category_id);
				$this->session->set_flashdata('success', 'Gallery Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'gallery/add_edit_category/' . $page_id . '/' . $website_id . '/' . $category_id;
				}
				else
				{
					$url = 'gallery/category/' . $page_id;
				}
			}

			redirect($url);
		}
	}
	
	/**
	 * Update Gallery Category Sort Order
	 */
	function update_category_sort_order()
	{
		$page_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Gallery_model->update_category_sort_order($page_id, $row_sort_order);
	}

	// Check Gallery Category Duplicates

	function check_category_name()
	{
		$data = $this->Gallery_model->check_category_duplicate();
		if (empty($data))
		{
			echo '0';
		}
		else
		{
			echo '1';
		}
	}

	// Delete Category By Id

	function delete_category()
	{
		$this->Gallery_model->delete_category();
		echo '1';
	}

	// Delete Multiple Category

	function delete_multiple_category()
	{
		$page_id = $this->input->post('page_id');
		$website_id = $this->input->post('website_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('gallery/category/' . $website_id);
		}
		else
		{
			$this->Gallery_model->delete_multiple_category();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('gallery/category/' . $website_id);
		}
	}

	function select_gallery_category()
	{
		$website_id = $this->admin_header->website_id();
		$search = strip_tags(trim($_GET['q']));
		$page   = $_GET['page'];
		$resultCount = 25;
		$offset = ($page - 1) * $resultCount;
		$gallery_categories = $this->Gallery_model->select_gallery_category($website_id, $search);
		if(!empty($gallery_categories))
		{
			foreach($gallery_categories as $gallery_category)
			{
				$answer[] = array("id" => $gallery_category->id, "text" => $gallery_category->category_name);
			}
		} else {
			$answer[] = array("id" => "", "text" => "No Results Found..");
		}
		$count = count($gallery_categories);
		$morePages = $resultCount <= $count;

		$results = array(
		  	"results" => $answer,
		  	"pagination" => array(
				"more" => $morePages
		  	),
		);
		echo json_encode($results);
	}

	// Category Selected Value
	function selected_category()
	{
		$data = '';
		$category_id = $_POST['categoryid'];
		$selected_categories = $this->Gallery_model->selected_category($category_id);
		if (!empty($selected_categories))
		{
			foreach ($selected_categories as $selected_category)
			{
				$data .= '<option selected value="'.$selected_category->id.'">'.$selected_category->category_name.'</option>';
			}
		}
		echo $data;
	}

	// Table

	function get_table($page_id)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$ImageUrl = $this->admin_header->image_url();
		$gallerys = $this->Gallery_model->get_gallery($page_id);
		if (isset($gallerys) && $gallerys != "")
		{
			foreach($gallerys as $gallery)
			{
				$anchor_edit = anchor('gallery/add_edit_gallery/' . $page_id . '/' . $gallery->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $gallery->id . ', \'' . base_url('gallery/delete_gallery/' . $page_id) . '\')'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_delete
				);
				if ($gallery->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($gallery->image != '')
				{
					$gallery_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $gallery->image;

					$image = img(array(
						'src' => $gallery_img ,
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

				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $gallery->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $gallery->id . '">', $image, $gallery->sort_order, $status, $cell);
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
			'Image',
			'Sort Order',
			'Status',
			'Action'
		));
		return $this->table->generate();
	}
	
	/**
	 * Update Gallery Sort Order
	 */
	function update_sort_order()
	{
		$page_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Gallery_model->update_sort_order($page_id, $row_sort_order);
	}

	// Insert & Update Gallery Title

	function insert_update_gallery_title()
	{
		$page_id = $this->input->post('page-id');		
		$this->Gallery_model->insert_update_gallery_title_data($page_id);
		redirect('gallery/gallery_index/' . $page_id);
	}

	// Insert & Update Gallery Customization

	function insert_update_gallery_customize()
	{
		$page_id = $this->input->post('page-id');
		$this->Gallery_model->insert_update_gallery_customize_data($page_id);
		redirect('gallery/gallery_index/' . $page_id);
	}

	// Add & Edit Gallery

	function add_edit_gallery($page_id, $id = null)
	{
		if ($id != null)
		{
			$gallery = $this->Gallery_model->get_gallery_by_id($page_id, $id);
			$data['gallery_id'] = $gallery[0]->id;
			$data['category_id'] = $gallery[0]->category_id;
			$data['image'] = $gallery[0]->image;
			$data['image_title'] = $gallery[0]->image_title;
			$data['image_alt'] = $gallery[0]->image_alt;
			$data['sort_order'] = $gallery[0]->sort_order;
			$data['status'] = $gallery[0]->status;
		}
		else
		{
			$data['gallery_id'] = "";
			$data['category_id'] = "";
			$data['image'] = "";
			$data['image_title'] = "";
			$data['image_alt'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
		}

		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['title'] = ($id != null) ? 'Edit Gallery' : 'Add Gallery' . ' | Administrator';
		$data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Gallery';
		$this->load->view('template/meta_head', $data);
		$this->load->view('gallery_header');
		$this->admin_header->index();
		$this->load->view('add_edit_gallery', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Gallery

	function insert_update_gallery()
	{
		$gallery_id = $this->input->post('gallery_id');
		$page_id = $this->input->post('page-id');
		$continue = $this->input->post('btn_continue');
		$error_config = array(
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
			if (empty($gallery_id))
			{
				redirect('gallery/add_edit_gallery/' . $page_id);
			}
			else
			{
				redirect('gallery/add_edit_gallery/' . $page_id . '/' . $gallery_id);
			}
		}
		else
		{
			if (empty($gallery_id))
			{
				$insert_id = $this->Gallery_model->insert_update_gallery_data($page_id);
				$this->session->set_flashdata('success', 'Gallery successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'gallery/add_edit_gallery/' . $page_id;
				}
				else
				{
					$url = 'gallery/gallery_index/' . $page_id;
				}
			}
			else
			{
				$this->Gallery_model->insert_update_gallery_data($page_id, $gallery_id);
				$this->session->set_flashdata('success', 'Gallery Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'gallery/add_edit_gallery/' . $page_id . '/' . $gallery_id;
				}
				else
				{
					$url = 'gallery/gallery_index/' . $page_id;
				}
			}

			redirect($url);
		}
	}

	// Delete Gallery

	function delete_gallery($page_id)
	{
		$this->Gallery_model->delete_gallery($page_id);
		$this->session->set_flashdata('success', 'Gallery Successfully Deleted.');
		redirect('gallery/gallery_index/' . $page_id);
	}

	// Delete multiple Gallery

	function delete_multiple_gallery()
	{
		$page_id = $this->input->post('page_id');
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('gallery/gallery_index/' . $page_id);
		}
		else
		{
			$this->Gallery_model->delete_multiple_gallery();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('gallery/gallery_index/' . $page_id);
		}
	}

	// Remove Image

	function remove_image()
	{
		$this->Gallery_model->remove_image();
		echo '1';
	}
}
