<?php
/**
 * Blog
 *
 * @category class
 * @package  Blog
 * @author   Athi
 * Created at:  10-Jul-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->session_data = $this->session->userdata('logged_in');
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Blog_model');
		$this->load->module('admin_header');
		$this->load->module('color');
		
		$this->load->helper('text');
	}

	/**
	 * Display all Blogs in a table
	 * get table data from get table method
	 */

	function index()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['table']	= $this->get_table($data['website_id']);
		
		$data['heading']	= 'Blog';
		$data['title']	= "Blog | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('blog_header');
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
		$blogs	= $this->Blog_model->get_blog($website_id);
		$ImageUrl	= $this->admin_header->image_url();
		$website_folder_name = $this->admin_header->website_folder_name();
		if (!empty($blogs))
		{
			foreach($blogs as $blog)
			{
				$anchor_edit = anchor(site_url(
					'blog/add_edit_blog/'.$blog->id),
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
					'onclick' => 'return delete_record('.$blog->id.', \''.base_url('blog/delete_blog').'\')'
				));

				if ($blog->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($blog->image != '')
				{
					$blog_image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $blog->image;

					$image	= img(array(
                    	'src'   => $blog_image,
                    	'style' => 'width:145px; height:86px'
                  	));
				}
				else
				{
					$image	= img(array(
                    	'src'   => $ImageUrl.'images/no-logo.png',
                    	'style' => 'width:145px; height:86px'
                  	));
				}

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . ' ' . $anchor_delete
				);
				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $blog->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $blog->id . '">',
					ucwords($blog->name),
					ucwords($blog->title),
					$image,
					$blog->sort_order,
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
			'Category',
			'Title',
			'Image',
			'Sort Order',
			'Status',
			'Action'
		);
		return $this->table->generate();
	}
	
	/**
	 * Rating Table
	 * get all data from model
	 * generate data table
	 * with multiple delete option
	 */

	function get_rating_table($blog_id, $website_id)
	{
		$blog_ratings	= $this->Blog_model->get_blog_rating($website_id, $blog_id);
		if (!empty($blog_ratings))
		{
			foreach($blog_ratings as $blog_rating)
			{
				$anchor_edit = anchor(site_url(
					'blog/add_edit_blog_rating/'.$blog_id.'/'.$blog_rating->id),
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
					'onclick' => 'return delete_record('.$blog_rating->id.', \''.base_url('blog/delete_blog_rating/'.$blog_id).'\')'
				));

				if ($blog_rating->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . ' ' . $anchor_delete
				);
				if(is_numeric($blog_rating->rating))
				{
					$checked10 = ($blog_rating->rating == 5) ? "checked": "disabled";
					$checked9 = ($blog_rating->rating == 4.5) ? "checked": "disabled";
					$checked8 = ($blog_rating->rating == 4) ? "checked": "disabled";
					$checked7 = ($blog_rating->rating == 3.5) ? "checked": "disabled";
					$checked6 = ($blog_rating->rating == 3) ? "checked": "disabled";
					$checked5 = ($blog_rating->rating == 2.5) ? "checked": "disabled";
					$checked4 = ($blog_rating->rating == 2) ? "checked": "disabled";
					$checked3 = ($blog_rating->rating == 1.5) ? "checked": "disabled";
					$checked2 = ($blog_rating->rating == 1) ? "checked": "disabled";
					$checked1 = ($blog_rating->rating == 0.5) ? "checked": "disabled";
					
					$star = '<fieldset class="viewrating">
								<input type="radio" '.$checked10.'/>
								<label class="full"></label>
								<input type="radio" '.$checked9.'/>
								<label class="half"></label>
								<input type="radio" '.$checked8.'/>
								<label class="full"></label>
								<input type="radio" '.$checked7.'/>
								<label class="half"></label>
								<input type="radio" '.$checked6.'/>
								<label class="full"></label>
								<input type="radio" '.$checked5.'/>
								<label class="half"></label>
								<input type="radio" '.$checked4.'/>
								<label class="full"></label>
								<input type="radio" '.$checked3.'/>
								<label class="half"></label>
								<input type="radio" '.$checked2.'/>
								<label class="full"></label>
								<input type="radio" '.$checked1.'/>
								<label class="half"></label>
							</fieldset>';
				}
				else
				{
					$star = $blog_rating->rating;
				}
				
				
				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $blog_rating->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $blog_rating->id . '">',
					ucwords($blog_rating->name),
					$blog_rating->email,
					$blog_rating->comment,
					$star,
					$blog_rating->sort_order,
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
            width="100%" cellspacing="0">',
			'tbody_open' => '<tbody id = "table_row_sortable">'
		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading(
			'<input type="checkbox" id="check-all" class="flat">',
			'Name',
			'Email',
			'Comments',
			'Rating',
			'Sort Order',
			'Status',
			'Action'
		);
		return $this->table->generate();
	}
	
	// Blog Page
	function blog_page($page_id)
	{
		$data['page_id'] = $page_id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		
		$data['blogs_unselected']	= $this->Blog_model->get_blog_unselected($data['website_id'], $page_id);
		$data['blogs_selected']	= $this->Blog_model->get_blog_selected($data['website_id'], $page_id);
		$data['blog_categories_unselected']	= $this->Blog_model->get_blog_category_unselected($data['website_id'], $page_id);
		$data['blog_categories_selected']	= $this->Blog_model->get_blog_category_selected($data['website_id'], $page_id);
		
		$blog_pages	= $this->Blog_model->get_blog_page_by_id($data['website_id'], $page_id);
		if(!empty($blog_pages))
		{
			($blog_pages[0]->blog_id == '') ? $data['blogs_unselected']	= $this->Blog_model->get_blog($data['website_id']): '';
			($blog_pages[0]->blog_category == '') ? $data['blog_categories_unselected']	= $this->Blog_model->get_blog_category($data['website_id']): '';
			
			$data['blog_id'] = $blog_pages[0]->id;
			$data['show_blog'] = $blog_pages[0]->blog;
			$data['blog_title'] = $blog_pages[0]->title;
			$data['title_color'] = $blog_pages[0]->title_color;
			$data['title_position'] = $blog_pages[0]->title_position;
			$data['blog_per_row'] = $blog_pages[0]->blog_per_row;
			$data['background'] = $blog_pages[0]->background;
			$data['status'] = $blog_pages[0]->status;
		}
		else
		{
			$data['blogs_unselected']	= $this->Blog_model->get_blog($data['website_id']);
			$data['blog_categories_unselected']	= $this->Blog_model->get_blog_category($data['website_id']);
			
			$data['blog_id'] = '';
			$data['show_blog'] = '';
			$data['blog_title'] = '';
			$data['title_color'] = '';
			$data['title_position'] = '';
			$data['blog_per_row'] = '';
			$data['background'] = '';
			$data['status'] = '';
		}

		if (!empty($data['background'])) :
			$blog_bg = json_decode($data['background']);
			$data['component_background'] = $blog_bg->component_background;
			$data['blog_background'] = $blog_bg->blog_background;
		else :
			$data['component_background'] = "";
			$data['blog_background'] = "";
		endif;
		
		$data['heading']	= 'Blog Page';
		$data['title']	= "Blog Page | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('blog_header');
		$this->admin_header->index();
		$this->load->view('blog_page', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	/**
	 * Update Blog Sort Order
	 */
	function update_sort_order()
	{
		$website_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Blog_model->update_sort_order($website_id, $row_sort_order);
	}
	
	/**
	 * Update Blog Rating Sort Order
	 */
	function update_rating_sort_order()
	{
		$blog_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Blog_model->update_rating_sort_order($blog_id, $row_sort_order);
	}
	
	/**
	 * Add and Edit Blog
	 */

	function add_edit_blog($id = null)
	{
		$data['website_id'] = $this->admin_header->website_id();
		if ($id != null)
		{
			$blog = $this->Blog_model->get_blog_by_id($id);
			$data['table']	= $this->get_rating_table($blog[0]->id, $data['website_id']);

			$data['blog_id']	= $blog[0]->id;
			$data['category']	= $blog[0]->category_id;
			$data['meta_title']	= $blog[0]->meta_title;
			$data['meta_keyword']	= $blog[0]->meta_keyword;
			$data['meta_description']	= $blog[0]->meta_description;
			$data['blog_title']	= $blog[0]->title;
			$data['title_color']	= $blog[0]->title_color;
			$data['title_hover_color']	= $blog[0]->title_hover_color;
			$data['title_position']	= $blog[0]->title_position;
			$data['image']	= $blog[0]->image;
			$data['image_title']	= $blog[0]->image_title;
			$data['image_alt']	= $blog[0]->image_alt;
			$data['short_description']	= $blog[0]->short_description;
			$data['short_description_title_color']	= $blog[0]->short_description_title_color;
			$data['short_description_title_position']	= $blog[0]->short_description_title_position;
			$data['short_description_color']	= $blog[0]->short_description_color;
			$data['short_description_position']	= $blog[0]->short_description_position;
			$data['short_description_title_hover_color']	= $blog[0]->short_description_title_hover_color;
			$data['short_description_hover_color']	= $blog[0]->short_description_hover_color;
			$data['short_description_background_hover_color']	= $blog[0]->short_description_background_hover_color;
			$data['description']	= $blog[0]->description;
			$data['description_title_color']	= $blog[0]->description_title_color;
			$data['description_title_position']	= $blog[0]->description_title_position;
			$data['description_color']	= $blog[0]->description_color;
			$data['description_position']	= $blog[0]->description_position;
			$data['description_title_hover_color']	= $blog[0]->description_title_hover_color;
			$data['description_hover_color']	= $blog[0]->description_hover_color;
			$data['description_background_hover_color']	= $blog[0]->description_background_hover_color;
			$data['create_date'] = $blog[0]->date;
			$data['date_color']	= $blog[0]->date_color;
			$data['created_by']	= $blog[0]->created_by;
			$data['blog_url']	= $blog[0]->blog_url;
			$data['open_new_tab']	= $blog[0]->open_new_tab;
			$data['background_color'] = $blog[0]->background_color;
			$data['background_image'] = $blog[0]->background_image;
			$data['sort_order']	= $blog[0]->sort_order;
			$data['status']	= $blog[0]->status;
		}
		else
		{
			$data['table']	= '';
			$admin_details = $this->Blog_model->get_admin_user_details($this->session_data['id']);
			$data['blog_id']	= '';
			$data['category']	= '';
			$data['meta_title']	= '';
			$data['meta_keyword']	= '';
			$data['meta_description']	= '';
			$data['blog_title']	= '';
			$data['title_color']	= '';
			$data['title_hover_color']	= '';
			$data['title_position']	= '';
			$data['image']	= '';
			$data['image_title']	= '';
			$data['image_alt']	= '';
			$data['short_description']	= '';
			$data['short_description_title_color']	= '';
			$data['short_description_title_position']	= '';
			$data['short_description_color']	= '';
			$data['short_description_position']	= '';
			$data['short_description_title_hover_color']	= '';
			$data['short_description_hover_color']	= '';
			$data['short_description_background_hover_color']	= '';
			$data['description']	= '';
			$data['description_title_color']	= '';
			$data['description_title_position']	= '';
			$data['description_color']	= '';
			$data['description_position']	= '';
			$data['description_title_hover_color']	= '';
			$data['description_hover_color']	= '';
			$data['description_background_hover_color']	= '';
			$data['create_date']	= '';
			$data['date_color']	= '';
			$data['created_by']	= ucwords($admin_details[0]->username);
			$data['blog_url']	= '';
			$data['open_new_tab']	= '';
			$data['background_color'] = '';
			$data['background_image'] = '';
			$data['sort_order']	= '';
			$data['status']	= '';
		}

		$data['httpUrl']	= $this->admin_header->host_url();
		$data['ImageUrl']	= $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		
		$data['rating_heading']	= 'Rating';
		$data['seo_heading']	= 'SEO Content';
		$data['heading']	= (($id != null) ? 'Edit Blog' : 'Add Blog');
		$data['title']	= (($id != null) ? 'Edit Blog' : 'Add Blog') . ' | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('blog_header');
		$this->admin_header->index();
		$this->load->view('add_edit_blog', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	/**
	 * Add and Edit Blog Rating
	 */

	function add_edit_blog_rating($blog_id, $id = null)
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['blog_id'] = $blog_id;
		$this->session->set_flashdata('tab', 'rating');
		
		if ($id != null)
		{
			$blog_rating = $this->Blog_model->get_blog_rating_by_id($blog_id, $id, $data['website_id']);

			$data['blog_rating_id']	= $blog_rating[0]->id;
			$data['name']	= $blog_rating[0]->name;
			$data['email']	= $blog_rating[0]->email;
			$data['rating']	= $blog_rating[0]->rating;
			$data['comment']	= $blog_rating[0]->comment;
			$data['sort_order']	= $blog_rating[0]->sort_order;
			$data['status']	= $blog_rating[0]->status;
			$data['created_at']	= $blog_rating[0]->created_at;
		}
		else
		{
			$data['blog_rating_id']	= '';
			$data['name']	= '';
			$data['email']	= '';
			$data['rating']	= '';
			$data['comment']	= '';
			$data['sort_order']	= '';
			$data['status']	= '';
			$data['created_at']	= '';
		}
		

		$data['rating_heading']	= 'Rating';
		$data['heading']	= (($id != null) ? 'Edit Blog Rating' : 'Add Blog Rating');
		$data['title']	= (($id != null) ? 'Edit Blog Rating' : 'Add Blog Rating') . ' | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('blog_header');
		$this->admin_header->index();
		$this->load->view('add_edit_blog_rating', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Customize Blog Rating
	function customize_blog_rating($id)
	{
		$data['blog_id'] = $id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['blog_rating_forms'] = $this->Blog_model->blog_rating_form($data['website_id']);
		$this->session->set_flashdata('tab', 'rating');
		
		if (!empty($data['blog_rating_forms']))
		{
			$data['rating_form_id']	= $data['blog_rating_forms'][0]->id;
			$data['rating_title']	= $data['blog_rating_forms'][0]->title;
			$data['title_color']	= $data['blog_rating_forms'][0]->title_color;
			$data['title_position']	= $data['blog_rating_forms'][0]->title_position;
			$data['title_hover']	= $data['blog_rating_forms'][0]->title_hover;
			$data['label_color']	= $data['blog_rating_forms'][0]->label_color;
			$data['comment_name_color']	= $data['blog_rating_forms'][0]->comment_name_color;
			$data['label_hover']	= $data['blog_rating_forms'][0]->label_hover;
			$data['comment_text_color']	= $data['blog_rating_forms'][0]->comment_text_color;
			$data['button_label']	= $data['blog_rating_forms'][0]->button_label;
			$data['button_type']	= $data['blog_rating_forms'][0]->button_type;
			$data['button_position']	= $data['blog_rating_forms'][0]->button_position;
			$data['button_background_color']	= $data['blog_rating_forms'][0]->button_background_color;
			$data['button_label_color']	= $data['blog_rating_forms'][0]->button_label_color;
			$data['button_background_hover']	= $data['blog_rating_forms'][0]->button_background_hover;
			$data['button_label_hover']	= $data['blog_rating_forms'][0]->button_label_hover;
			$data['border']	= $data['blog_rating_forms'][0]->border;
			$data['border_size']	= $data['blog_rating_forms'][0]->border_size;
			$data['border_color']	= $data['blog_rating_forms'][0]->border_color;
			$data['border_hover']	= $data['blog_rating_forms'][0]->border_hover;
			$data['status']	= $data['blog_rating_forms'][0]->status;
		}
		else
		{
			$data['rating_form_id']	= '';
			$data['rating_title']	= '';
			$data['title_color']	= '';
			$data['title_position']	= '';
			$data['title_hover']	= '';
			$data['label_color']	= '';
			$data['comment_name_color']	= '';
			$data['label_hover']	= '';
			$data['comment_text_color']	= '';
			$data['button_label']	= '';
			$data['button_type']	= '';
			$data['button_position']	= '';
			$data['button_background_color']	= '';
			$data['button_label_color']	= '';
			$data['button_background_hover']	= '';
			$data['button_label_hover']	= '';
			$data['border']	= '';
			$data['border_size']	= '';
			$data['border_color']	= '';
			$data['border_hover']	= '';
			$data['status']	= '';
		}
		
		$data['heading']	= 'Customize Blog Rating';
		$data['title']	= 'Rating | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('blog_header');
		$this->admin_header->index();
		$this->load->view('customize_blog_rating', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
		
	// Insert Update Blog Page
	function insert_update_blog_page()
	{
		$blog_id	= $this->input->post('blog_id');
		$page_id	= $this->input->post('page_id');
		$website_id	= $this->input->post('website_id');
		$continue	= $this->input->post('btn_continue');
		
		if (empty($blog_id))
		{
			$this->Blog_model->insert_update_blog_page();
			$this->session->set_flashdata('success', 'Blog Successfully Created');
		}
		else
		{
			$this->Blog_model->insert_update_blog_page($blog_id);
			$this->session->set_flashdata('success', 'Blog Successfully Updated.');
		}
		
		if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
		{
			$url = 'blog/blog_page/'.$page_id;
		}
		else
		{
			$url = 'page/page_details/'.$page_id;
		}
		
		redirect($url);
	}
	
	// Insert Update Blog Rating Customize
	function insert_update_blog_rating_customize()
	{
		$blog_id	= $this->input->post('blog_id');
		$rating_form_id	= $this->input->post('rating_form_id');
		$continue	= $this->input->post('btn_continue');

		$this->session->set_flashdata('tab', 'rating');

		$error_config = array(
			array(
				'field'	=> 'title',
				'label'	=> 'Title',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'button_label',
				'label'	=> 'Button Label',
				'rules'	=> 'required'
			),
		);

		$this->form_validation->set_rules($error_config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('blog/customize_blog_rating/'.$blog_id);
		}
		else
		{
			if (empty($rating_form_id))
			{
				$this->Blog_model->insert_update_blog_rating_customize();
				$this->session->set_flashdata('success', 'Rating Form successfully Created');
			}
			else
			{
				$this->Blog_model->insert_update_blog_rating_customize($rating_form_id);
				$this->session->set_flashdata('success', 'Rating Form Successfully Updated.');
			}
			
			if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
			{
				$url = 'blog/customize_blog_rating/'.$blog_id;
			}
			else
			{
				$url = 'blog/add_edit_blog/'.$blog_id;
			}
			
			redirect($url);
		}
	}
	
	// Insert & Update Blog
	function insert_update_blog()
	{
		$blog_id	= $this->input->post('blog_id');
		$continue	= $this->input->post('btn_continue');
		$readmore_btn	= $this->input->post('readmore_btn');
		$readmore_btn	= (isset($readmore_btn)) ? '1' : '0';
		$tab = $this->input->post('tab');
		$this->session->set_flashdata('tab', $tab);

		$error_config = array(
			array(
				'field'	=> 'category',
				'label'	=> 'Category',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'title',
				'label'	=> 'Title',
				'rules'	=> 'required'
			)
		);
		$readerror_config = array(
			array(
				'field'	=> 'blog_url',
				'label'	=> 'Blog URL',
				'rules'	=> 'required'
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
			if (empty($blog_id))
			{
				redirect('blog/add_edit_blog');
			}
			else
			{
				redirect('blog/add_edit_blog/'.$blog_id);
			}
		}
		else
		{
			if (empty($blog_id))
			{
				$insert_id	= $this->Blog_model->insert_update_blog();
				$this->session->set_flashdata('success', 'Blog successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'blog/add_edit_blog';
				}
				else
				{
					$url = 'blog';
				}
			}
			else
			{
				$this->Blog_model->insert_update_blog($blog_id);
				$this->session->set_flashdata('success', 'Blog Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'blog/add_edit_blog/'.$blog_id;
				}
				else
				{
					$url = 'blog';
				}
			}
			redirect($url);
		}
	}
	
	// Insert & Update Blog Rating
	function insert_update_blog_rating()
	{
		$blog_id	= $this->input->post('blog_id');
		$blog_rating_id	= $this->input->post('blog_rating_id');
		$continue	= $this->input->post('btn_continue');

		$this->session->set_flashdata('tab', 'rating');

		if (empty($blog_rating_id))
		{
			$insert_id	= $this->Blog_model->insert_update_blog_rating();
			$this->session->set_flashdata('success', 'Blog Rating successfully Created');
			if (isset($continue) && $continue === "Add & Continue")
			{
				$url = 'blog/add_edit_blog_rating/'.$blog_id;
			}
			else
			{
				$url = 'blog/add_edit_blog/'.$blog_id;
			}
		}
		else
		{
			$this->Blog_model->insert_update_blog_rating($blog_id, $blog_rating_id);
			$this->session->set_flashdata('success', 'Blog Rating Successfully Updated.');
			if (isset($continue) && $continue === "Update & Continue")
			{
				$url = 'blog/add_edit_blog_rating/'.$blog_id.'/'.$blog_rating_id;
			}
			else
			{
				$url = 'blog/add_edit_blog/'.$blog_id;
			}
		}
		redirect($url);
	}
	
	// Add Category
	function insert_category()
	{
		$this->Blog_model->insert_category();
		$this->session->set_flashdata('success', 'Category successfully Created');
		redirect('blog');
	}
	
	// Delete Blog
	function delete_blog()
	{
		$id = $this->input->post('id');
		$this->Blog_model->delete_blog($id);
		$this->session->set_flashdata('success', 'Blog Successfully Deleted.');
	}
	
	// Delete multiple Blog
	function delete_multiple_blog()
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
			redirect('blog');
		}
		else
		{
			$this->Blog_model->delete_multiple_blog();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('blog');
		}
	}
	
	// Delete Blog Rating
	function delete_blog_rating($blog_id)
	{
		$this->session->set_flashdata('tab', 'rating');
		$this->Blog_model->delete_blog_rating($blog_id);
		$this->session->set_flashdata('success', 'Blog Successfully Deleted.');
	}
	
	// Delete multiple Blog Rating
	function delete_multiple_blog_rating()
	{
		$blog_id = $this->input->post('blog_id');
		$this->session->set_flashdata('tab', 'rating');
		
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
			redirect('blog/add_edit_blog/'.$blog_id);
		}
		else
		{
			$this->Blog_model->delete_multiple_blog_rating($blog_id);
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('blog/add_edit_blog/'.$blog_id);
		}
	}
	
	// Insert Update Blog SEO COntent
	function insert_update_blog_seo()
	{
		$blog_id	= $this->input->post('blog_id');
		$continue	= $this->input->post('btn_continue');
		$tab = $this->input->post('tab');
		$this->session->set_flashdata('tab', $tab);

		$error_config = array(
			array(
				'field'	=> 'meta_title',
				'label'	=> 'Meta-Title',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'meta_keyword',
				'label'	=> 'Meta-Keyword',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'meta_description',
				'label'	=> 'Meta-Description',
				'rules'	=> 'required'
			)
		);

		$this->form_validation->set_rules($error_config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($blog_id))
			{
				redirect('blog/add_edit_blog');
			}
			else
			{
				redirect('blog/add_edit_blog/'.$blog_id);
			}
		}
		else
		{
			if (empty($blog_id))
			{
				$insert_id	= $this->Blog_model->insert_update_blog_seo();
				$this->session->set_flashdata('success', 'Blog SEO successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'blog/add_edit_blog';
				}
				else
				{
					$url = 'blog';
				}
			}
			else
			{
				$this->Blog_model->insert_update_blog_seo($blog_id);
				$this->session->set_flashdata('success', 'Blog SEO Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'blog/add_edit_blog/'.$blog_id;
				}
				else
				{
					$url = 'blog';
				}
			}
			redirect($url);
		}
	}
	
	/**
	 * Display all Category Blogs in a table
	 * get table data from get table method
	 */

	function category()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['table']	= $this->get_category_table($data['website_id']);
		$data['heading']	= 'Blog Category';
		$data['title']	= "Blog Category | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('blog_header');
		$this->admin_header->index();
		$this->load->view('view_category', $data);
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

	function get_category_table($website_id)
	{
		$blog_categories	= $this->Blog_model->get_blog_category($website_id);
		if (!empty($blog_categories))
		{
			foreach($blog_categories as $blog_category)
			{
				$anchor_edit = anchor(site_url(
					'blog/add_edit_blog_category/'.$blog_category->id) ,
					'<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>',
					array(
					'data-toggle' 				=> 'tooltip',
					'data-placement' 			=> 'left',
					'data-original-title'	=> 'Edit'
				));

				$anchor_delete = anchor(
					'' ,
					'<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>',
					array(
					'data-toggle' 				=> 'tooltip',
					'data-placement' 			=> 'right',
					'data-original-title'	=> 'Delete',
					'onclick' => 'return delete_record('.$blog_category->id.', \''.base_url('blog/delete_blog_category').'\')'
				));

				if ($blog_category->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . ' ' . $anchor_delete
				);
				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $blog_category->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $blog_category->id . '">',
					ucwords($blog_category->name),
					$blog_category->sort_order,
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
            width="100%" cellspacing="0">',
			'tbody_open' => '<tbody id = "table_row_sortable">'
		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading(
			'<input type="checkbox" id="check-all" class="flat">',
			'Category',
			'Sort Order',
			'Status',
			'Action'
		);
		return $this->table->generate();
	}
	
	/**
	 * Update Blog Category Sort Order
	 */
	function update_sort_order_category()
	{
		$website_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Blog_model->update_sort_order_two($website_id, $row_sort_order);
	}
	
	function select_blog_category()
	{
		$website_id = $this->admin_header->website_id();
		$search = strip_tags(trim($_GET['q']));
		$page   = $_GET['page'];
		$resultCount = 25;
		$offset = ($page - 1) * $resultCount;
		$blog_categories = $this->Blog_model->select_blog_category($website_id, $search);
		if(!empty($blog_categories))
		{
			foreach($blog_categories as $blog_category)
			{
				$answer[] = array("id" => $blog_category->id, "text" => $blog_category->name); 
			}
		} else {
			$answer[] = array("id" => "", "text" => "No Results Found.."); 
		}
		$count = count($blog_categories);
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
		$selected_categories = $this->Blog_model->selected_category($category_id);
		if (!empty($selected_categories)) 
		{	
			foreach ($selected_categories as $selected_category)
			{
				$data .= '<option selected value="'.$selected_category->id.'">'.$selected_category->name.'</option>'; 
			}
		}
		echo $data;
	}
	
	// Add and Edit Blog Category
	function add_edit_blog_category($id = null)
	{
		if ($id != null)
		{
			$blog_category = $this->Blog_model->get_blog_category_by_id($id);

			$data['blog_category_id']	= $blog_category[0]->id;
			$data['name']	= $blog_category[0]->name;
			$data['sort_order']	= $blog_category[0]->sort_order;
			$data['status']	= $blog_category[0]->status;
		}
		else
		{
			$data['blog_category_id']	= '';
			$data['sort_order']	= '';
			$data['name']	= '';
			$data['status']	= '';
		}
		
		$data['website_id'] = $this->admin_header->website_id();

		$data['heading']	= (($id != null) ? 'Edit Blog Category' : 'Add Blog Category');
		$data['title']	= (($id != null) ? 'Edit Blog Category' : 'Add Blog Category') . ' | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('blog_header');
		$this->admin_header->index();
		$this->load->view('add_edit_blog_category', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Insert & Update Blog Category
	function insert_update_blog_category()
	{
		$blog_category_id	= $this->input->post('blog_category_id');
		$continue	= $this->input->post('btn_continue');

		$error_config = array(
			array(
				'field'	=> 'name',
				'label'	=> 'Category',
				'rules'	=> 'required'
			)
		);

		$this->form_validation->set_rules($error_config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($blog_category_id))
			{
				redirect('blog/add_edit_blog_category');
			}
			else
			{
				redirect('blog/add_edit_blog_category/'.$blog_category_id);
			}
		}
		else
		{
			if (empty($blog_category_id))
			{
				$insert_id	= $this->Blog_model->insert_update_blog_category();
				$this->session->set_flashdata('success', 'Blog Category successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'blog/add_edit_blog_category';
				}
				else
				{
					$url = 'blog/category';
				}
			}
			else
			{
				$this->Blog_model->insert_update_blog_category($blog_category_id);
				$this->session->set_flashdata('success', 'Blog Category Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'blog/add_edit_blog_category/'.$blog_category_id;
				}
				else
				{
					$url = 'blog/category';
				}
			}
			redirect($url);
		}
	}
	
	// Delete Blog Category
	function delete_blog_category()
	{
		$id = $this->input->post('id');
		$blogs = $this->Blog_model->check_blog($id);
		if(empty($blogs))
		{
			$this->Blog_model->delete_blog_category($id);
			$this->session->set_flashdata('success', 'Blog Category Successfully Deleted.');
		}
		else
		{
			$this->session->set_flashdata('error', 'oops! First Remove Blog');
		}
	}
	
	// Delete multiple Blog Category
	function delete_multiple_blog_category()
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
			redirect('blog/category');
		}
		else
		{
			$blog_categories = $this->Blog_model->check_blog_category();
			if(empty($blog_categories))
			{
				$this->Blog_model->delete_multiple_blog_category();
				$this->session->set_flashdata('success', 'Successfully Deleted');
			}
			else
			{
				$this->session->set_flashdata('error', 'oops! First Remove Blog');
			}
			
			redirect('blog/category');
		}
	}
	
	// Check BLOG Category Duplicates

	function check_category_name()
	{
		$data = $this->Blog_model->check_category_duplicate();
		if (empty($data))
		{
			echo '0';
		}
		else
		{
			echo '1';
		}
	}
	
	// Remove Image
	function remove_image()
	{
		$this->Blog_model->remove_blog_image();
		echo '1';
	}
	
	// Mail Configure
	function mail_configure($blog_id)
	{
		$data['blog_id']	= $blog_id;
		$data['website_id']   = $this->admin_header->website_id();

		$rating_mail_configures = $this->Blog_model->get_mail_configure($data['website_id']);
		if(!empty($rating_mail_configures))
		{
			foreach($rating_mail_configures as $rating_mail_configure)
			{
				$data['id']	= $rating_mail_configure->id;
				$data['mail_subject']	= $rating_mail_configure->mail_subject;
				$data['from_name']	= $rating_mail_configure->from_name;
				$data['message_content']	= $rating_mail_configure->message_content;
				$data['success_title']	= $rating_mail_configure->success_title;
				$data['success_message']	= $rating_mail_configure->success_message;
				$data['send_mail_to']	= $rating_mail_configure->send_mail_to;
				$data['to_address']	= $rating_mail_configure->to_address;
				$data['ccid']	= $rating_mail_configure->cc;
				$data['bccid']	= $rating_mail_configure->bcc;
				$data['rating_field']	= $rating_mail_configure->rating_field;
				$data['rating_field_status']	= $rating_mail_configure->rating_field_status;
				$data['status']	= $rating_mail_configure->status;
			}
		}
		else
		{
			$data['id']	= '';
			$data['mail_subject']	= '';
			$data['from_name']	= '';
			$data['message_content']	= '';
			$data['success_title']	= '';
			$data['success_message']	= '';
			$data['send_mail_to']	= '';
			$data['to_address']	= '';
			$data['ccid']	= '';
			$data['bccid']	= '';
			$data['rating_field']	= '';
			$data['rating_field_status']	= '';
			$data['status']	= '';
		}
		
		$data['heading']  = 'Mail Configure';
		$data['title']	= "Mail Configure | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('blog_header');
		$this->admin_header->index();
		$this->load->view('mail_configure', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Insert Update Rating Mail Configure
	function insert_update_rating_mail_configure()
	{
		$id = $this->input->post('id');
		$blog_id = $this->input->post('blog_id');
		$website_id = $this->input->post('website_id');
		$continue = $this->input->post('btn_continue');
		if (empty($id))
		{
			$insert_id	= $this->Blog_model->insert_update_rating_mail_configure($website_id);
			$this->session->set_flashdata('success', 'Mail Configure successfully Created');
		}
		else
		{
			$this->Blog_model->insert_update_rating_mail_configure($website_id, $id);
			$this->session->set_flashdata('success', 'Mail Configure Successfully Updated.');
		}
		if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
		{
			$url = 'blog/mail_configure/'.$blog_id;
		}
		else
		{
			$url = 'blog/customize_blog_rating/'.$blog_id;
		}
		redirect($url);
	}
}