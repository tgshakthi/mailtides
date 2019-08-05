<?php
/**
 * Page
 *
 * @category class
 * @package  Page
 * @author   Saravana
 * Created at:  20-Mar-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Page extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Page_model');
		$this->load->module('admin_header');
	}

	/**
	 * Display all Pages in a table
	 * get table data from get table method
	 */
	function index()
	{
		$data['http_url'] = $this->admin_header->host_url();
		$data['table'] = $this->get_table();
		$data['heading'] = "Pages";
		$data['title'] = "Pages | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('page_header');
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
	function get_table()
	{
		$pages = $this->Page_model->get_pages($this->admin_header->website_id());
		if (!empty($pages))
		{
			foreach($pages as $page)
			{
				$anchor_edit = anchor(site_url('page/add_edit_page/' . $page->id) , '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_edit_page_content = anchor(site_url('page/page_details/' . $page->id) , '<span class="glyphicon c_pagecontent_icon glyphicon-duplicate" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'data-original-title' => 'Edit Page Content'
				));

				$anchor_publish = anchor(
					site_url('page/publish/' . $page->id),
					'<i class="fa fa-html5 c_pagecontent_icon"></i>',
					array(
						'data-toggle' => 'tooltip',
						'data-placement' => 'top',
						'data-original-title' => 'Publish'
					)
				);

				$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $page->id . ', \'' . base_url('page/delete_page') . '\')'
				));
				if ($page->status === '1')
				{
					$page_status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$page_status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($page->publish === '1')
				{
					$publish_status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$publish_status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . ' ' . $anchor_edit_page_content . ' ' . $anchor_publish . ' ' . $anchor_delete
				);
				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $page->id . '">', ucwords($page->title) , $page->url, $page_status, $publish_status, $cell);
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
            id="datatable-responsive"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">'
		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Title', 'Page Url', 'Page Status', 'Publish Status', 'Action');
		return $this->table->generate();
	}

	/**
	 * Add Edit
	 * redirect to pages based on @param
	 */
	function add_edit_page($id = null)
	{
		$data['pages'] = $this->Page_model->get_pages($this->admin_header->website_id());
		if ($id != null)
		{
			$page = $this->Page_model->get_pageby_id($id, $this->admin_header->website_id());
			$data['heading'] = 'Edit Page';
			$data['id'] = $page[0]->id;
			$data['page_title'] = $page[0]->title;
			$data['url'] = $page[0]->url;
			$data['component_id'] = $page[0]->component_id;
			$data['status'] = $page[0]->status;
		}
		else
		{
			$data['heading'] = 'Add Page';
			$data['id'] = '';
			$data['page_title'] = '';
			$data['url'] = '';
			$data['component_id'] = '';
			$data['status'] = '';
		}

		$web_component_ids = $this->Page_model->get_web_components_id($this->session->userdata('website_id'));
		$web_common_component_ids = $this->Page_model->get_web_common_components_id($this->session->userdata('website_id'));
		$data['web_component_ids'] = (!empty($web_common_component_ids)) ? array_merge($web_component_ids, $web_common_component_ids) : $web_component_ids;
		$data['components'] = $this->Page_model->get_components();
		$data['common_components'] = $this->Page_model->get_common_components();
		$data['http_url'] = $this->admin_header->host_url();
		$data['title'] = (($id != null) ? 'Edit Page' : 'Add Page') . ' | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('page_header');
		$this->admin_header->index();
		$this->load->view('add_edit_page', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	/**
	 * Edit Page Content
	 * get table data from get table method
	 */
	function page_details($page_id)
	{
		$website_id = $this->admin_header->website_id();
		$get_website_url = $this->Page_model->get_website_url($website_id);
		if (!empty($get_website_url)):
			$data['website_url'] = $get_website_url[0]->website_url;
		else:
			$data['website_url'] = "";
		endif;
		$page_details = $this->Page_model->get_page_details($page_id);
		if (!empty($page_details))
		{
			foreach($page_details as $page_detail)
			{
				$data['page_id'] = $page_detail->id;
				$data['page_title'] = $page_detail->title;
				$data['page_url'] = $page_detail->url;
				$data['component_ids'] = $page_detail->component_id;
			}
		}
		else
		{
			$data['page_id'] = $page_id;
			$data['page_title'] = '';
			$data['page_url'] = '';
			$data['component_ids'] = '';
		}

		// Menu Content

		$data['menu_contents'] = $this->Page_model->get_page_menu_setting_details($website_id, $page_id, 'page_menu_content');

		// Menu Content details from settings

		if (!empty($data['menu_contents']))
		{
			$keys = json_decode($data['menu_contents'][0]->key);
			$values = json_decode($data['menu_contents'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['page_menu_image'] = '';
			$data['page_menu_content'] = '';
			$data['page_menu_status'] = '';
		}

		$seo = $this->Page_model->get_seo($page_id, 'seo');
		if (!empty($seo))
		{
			foreach($seo as $seo_data)
			{
				$data['seo_id'] = $seo_data->id;
				$data['h1_tag'] = $seo_data->h1_tag;
				$data['h2_tag'] = $seo_data->h2_tag;
				$data['meta_title'] = $seo_data->meta_title;
				$data['meta_description'] = $seo_data->meta_description;
				$data['meta_keyword'] = $seo_data->meta_keyword;
				$data['meta_misc'] = $seo_data->meta_misc;
			}
		}
		else
		{
			$data['seo_id'] = '';
			$data['h1_tag'] = '';
			$data['h2_tag'] = '';
			$data['meta_title'] = '';
			$data['meta_description'] = '';
			$data['meta_keyword'] = '';
			$data['meta_misc'] = '';
		}

		$seo_screen_formulas = $this->Page_model->get_seo($page_id, 'seo_screen_formula');

		// $data['description_categorys'] = $this->Page_model->get_seo_data('description_content');

		if (!empty($seo_screen_formulas))
		{
			$title_cities = json_decode($seo_screen_formulas[0]->title_cities);
			$keyword_cities = json_decode($seo_screen_formulas[0]->keyword_cities);
			$description_cities = json_decode($seo_screen_formulas[0]->description_cities);
			if ((!empty($title_cities)) && (!empty($keyword_cities)) && (!empty($description_cities))):
				$all_cities = array_merge($title_cities, $keyword_cities, $description_cities);
				$data['allcities'] = array_unique($all_cities);
			endif;
			foreach($seo_screen_formulas as $seo_screen_formula)
			{
				$data['seo_screen_formula_id'] = $seo_screen_formula->id;
				$data['main_keyword'] = $seo_screen_formula->main_keyword;
				$data['secondary_keyword'] = $seo_screen_formula->secondary_keyword;
				$data['main_service'] = $seo_screen_formula->main_service;
				$data['secondary_service'] = $seo_screen_formula->secondary_service;
				$data['service3'] = $seo_screen_formula->service3;
				$data['service4'] = $seo_screen_formula->service4;
				$data['service5'] = $seo_screen_formula->service5;
				$data['service6'] = $seo_screen_formula->service6;
				$data['service7'] = $seo_screen_formula->service7;
				$data['service8'] = $seo_screen_formula->service8;
				$data['title_cities'] = $title_cities;
				$data['keyword_cities'] = $keyword_cities;
				$data['description_cities'] = $description_cities;
				$data['description_category'] = $seo_screen_formula->description_category;
				$data['description'] = $seo_screen_formula->description;
			}
		}
		else
		{
			$data['seo_screen_formula_id'] = '';
			$data['main_keyword'] = '';
			$data['secondary_keyword'] = '';
			$data['main_service'] = '';
			$data['secondary_service'] = '';
			$data['service3'] = '';
			$data['service4'] = '';
			$data['service5'] = '';
			$data['service6'] = '';
			$data['service7'] = '';
			$data['service8'] = '';
			$data['title_cities'] = '';
			$data['keyword_cities'] = '';
			$data['description_cities'] = '';
			$data['description_category'] = '';
			$data['description'] = '';
		}

		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['page_components'] = $this->Page_model->get_page_components($page_id);
		$data['cities'] = $this->Page_model->get_seo_data('cities');
		$data['description_categorys'] = $this->Page_model->get_seo_data('description_content');
		$data['title'] = 'Page Details - Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('page_header');
		$this->admin_header->index();
		$this->load->view('page_details', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	/**
	 * Insert Update Page
	 */
	function insert_update_page()
	{
		$website_id = $this->admin_header->website_id();
		$id = $this->input->post('id');
		$page_clone = $this->input->post('page_clone');
		$continue = $this->input->post('btn_continue');
		$error_config = array(
			array(
				'field' => 'page-title',
				'label' => 'Page Title',
				'rules' => 'required'
			) ,
			array(
				'field' => 'page-url',
				'label' => 'Page Url',
				'rules' => 'required'
			)
		);
		if ($page_clone == 1)
		{
			$error_config1 = array(
				array(
					'field' => 'clone_page',
					'label' => 'Clone Page',
					'rules' => 'required'
				) ,
				array(
					'field' => 'page_clone',
					'label' => 'If Page Clone',
					'rules' => 'required'
				)
			);
		}
		elseif ($page_clone == 0)
		{
			$error_config1 = array(
				array(
					'field' => 'components[]',
					'label' => 'Page Components',
					'rules' => 'required'
				)
			);
		}
		else
		{
			$error_config1 = array();
		}

		$error_config = array_merge($error_config, $error_config1);
		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($id))
			{
				redirect('page/add_edit_page');
			}
			else
			{
				redirect('page/add_edit_page/' . $id);
			}
		}
		else
		{
			if (empty($id))
			{
				if ($page_clone == 1)
				{
					$clone_page = $this->input->post('clone_page');
					if ($clone_page != '')
					{
						$insert_page_id = $this->Page_model->clone_insert_data();
						$get_cloning_pages = $this->Page_model->get_data('pages', 'id', $clone_page);
						if (!empty($get_cloning_pages))
						{
							$component_ids = $get_cloning_pages[0]->component_id;
							$this->Page_model->clone_update_data($insert_page_id, $component_ids);
							$clone_datas = array(
								array(
									'table_name' => 'page_components',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'introduction',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'banner',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'conclusion',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'counter',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'newsletter',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'our_service',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'text_full_width',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'text_image',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'text_icon',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'image_card',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'circular_image',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'gallery',
									'primary_key' => 'id',
									'id1' => 'page_id',
									'temp' => 0
								) ,
								array(
									'table_name' => 'event_calendar',
									'primary_key' => 'id',
									'id1' => 'website_id',
									'id2' => 'page_id',
									'temp' => 1
								) ,
								array(
									'table_name' => 'testimonial_pages',
									'primary_key' => 'id',
									'id1' => 'website_id',
									'id2' => 'page_id',
									'temp' => 1
								) ,
								array(
									'table_name' => 'event_pages',
									'primary_key' => 'id',
									'id1' => 'website_id',
									'id2' => 'page_id',
									'temp' => 1
								) ,
								array(
									'table_name' => 'blog_pages',
									'primary_key' => 'id',
									'id1' => 'website_id',
									'id2' => 'page_id',
									'temp' => 1
								) ,								
								array(
									'table_name' => 'setting',
									'primary_key' => 'id',
									'id1' => 'website_id',
									'id2' => 'page_id',
									'temp' => 1
								) ,
								array(
									'table_name' => 'tab',
									'primary_key' => 'id',
									'id1' => 'website_id',
									'id2' => 'page_id',
									'temp' => 2
								)
							);
							$clone_datas1 = array(
								array(
									'table_name' => 'tab_text_full_width',
									'primary_key' => 'id',
									'id1' => 'tab_id',
									'id2' => '',
									'temp' => 21
								) ,
								array(
									'table_name' => 'tab_text_image',
									'primary_key' => 'id',
									'id1' => 'tab_id',
									'id2' => '',
									'temp' => 21
								)
							);
							foreach($clone_datas as $clone_data)
							{
								$table_name = $clone_data['table_name'];
								$primary_key = $clone_data['primary_key'];
								$id1 = $clone_data['id1'];
								$temp = $clone_data['temp'];
								if ($temp == 0)
								{
									$get_datas = $this->Page_model->get_data($table_name, $id1, $clone_page);
									if (!empty($get_datas))
									{
										foreach($get_datas as $get_data)
										{
											foreach($get_data as $key => $value)
											{
												if ($key == $id1)
												{
													$insert_data[$key] = $insert_page_id;
												}
												elseif ($key != $primary_key)
												{
													$insert_data[$key] = $value;
												}
											}

											$insert_data_id = $this->Page_model->insert_data($table_name, $insert_data);
											$insert_data = array();
										}
									}
								}
								elseif ($temp == 2 || $temp == 1)
								{
									$id2 = $clone_data['id2'];
									$get_datas = $this->Page_model->get_data_two_where($table_name, $id1, $website_id, $id2, $clone_page);
									$check_datas = $this->Page_model->get_data_two_where($table_name, $id1, $website_id, $id2, $insert_page_id);
									if (!empty($get_datas))
									{
										foreach($get_datas as $get_data)
										{
											if (count($get_datas) != count($check_datas))
											{
												foreach($get_data as $key => $value)
												{
													if ($key == $id1)
													{
														$insert_data[$key] = $website_id;
													}
													elseif ($key == $id2)
													{
														$insert_data[$key] = $insert_page_id;
													}
													elseif ($key != $primary_key)
													{
														$insert_data[$key] = $value;
													}
												}

												$insert_data_id = $this->Page_model->insert_data($table_name, $insert_data);
												$insert_data = array();
											}

											foreach($clone_datas1 as $clone_data1)
											{
												$table_name1 = $clone_data1['table_name'];
												$primary_key1 = $clone_data1['primary_key'];
												$id11 = $clone_data1['id1'];
												$id21 = $clone_data1['id2'];
												$temp1 = $clone_data1['temp'];
												if ($temp1 == 21 && $temp != 1)
												{
													$get_datas1 = $this->Page_model->get_data($table_name1, $id11, $get_data->id);
													if (!empty($get_datas1))
													{
														foreach($get_datas1 as $get_data1)
														{
															foreach($get_data1 as $key1 => $value1)
															{
																if ($key1 == $id11)
																{
																	$insert_data1[$key1] = $insert_data_id;
																}
																elseif ($key1 != $primary_key1)
																{
																	$insert_data1[$key1] = $value1;
																}
															}

															$insert_data_id1 = $this->Page_model->insert_data($table_name1, $insert_data1);
															$insert_data1 = array();
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
				else
				{
					$this->Page_model->insert_update_page_data();
				}

				$this->session->set_flashdata('success', 'Page successfully Created.');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'page/add_edit_page';
				}
				else
				{
					$url = 'page';
				}
			}
			else
			{
				$this->Page_model->insert_update_page_data($id);
				$this->session->set_flashdata('success', 'Page Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'page/add_edit_page/' . $id;
				}
				else
				{
					$url = 'page';
				}
			}

			redirect($url);
		}
	}

	/**
	 * Delete record
	 * Delete record by @param
	 */
	function delete_page()
	{
		$this->Page_model->delete_page();
		$this->session->set_flashdata('success', 'Page Successfully Deleted.');
	}

	/**
	 * Delete multiple records
	 * Delete multiple records by @param
	 */
	function delete_selected_page()
	{
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('page');
		}
		else
		{
			$this->Page_model->delete_multiple_page();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('page');
		}
	}

	/**
	 * Insert Update Page Detail tab
	 */
	function insert_update_page_detail()
	{
		$id = $this->input->post('id');
		$continue = $this->input->post('btn_continue');
		$tab = $this->input->post('page-detail');
		$this->Page_model->insert_update_page_details();
		$this->session->set_flashdata('success', 'Page Details Successfully Updated.');
		$this->session->set_flashdata('tab', $tab);
		if (isset($continue) && $continue === "Update & Continue")
		{
			$url = 'page/page_details/' . $id;
		}
		else
		{
			$url = 'page';
		}

		redirect($url);
	}

	/**
	 * Insert Update SEO tab
	 */
	function insert_update_seo()
	{
		$page_id = $this->input->post('page_id');
		$seo_id = $this->input->post('seo_id');
		$continue = $this->input->post('btn_continue');
		$tab = $this->input->post('seo');
		$this->session->set_flashdata('tab', $tab);
		$error_config = array(
			array(
				'field' => 'h1_tag',
				'label' => 'H1',
				'rules' => 'required'
			) ,
			array(
				'field' => 'h2_tag',
				'label' => 'H2',
				'rules' => 'required'
			) ,

			// array(
			//				'field' => 'page_url',
			//				'label' => 'Page URL',
			//				'rules' => 'required'
			//			) ,

			array(
				'field' => 'meta-title',
				'label' => 'Meta Title',
				'rules' => 'required'
			) ,
			array(
				'field' => 'meta-description',
				'label' => 'Meta Description',
				'rules' => 'required'
			) ,
			array(
				'field' => 'meta-keyword',
				'label' => 'Meta Keyword',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('page/page_details/' . $page_id);
		}
		else
		{
			if (empty($seo_id))
			{
				$this->Page_model->insert_update_seo_data();
				$this->session->set_flashdata('success', 'SEO Data successfully Added.');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'page/page_details/' . $page_id;
				}
				else
				{
					$url = 'page';
				}
			}
			else
			{
				$this->Page_model->insert_update_seo_data($page_id);
				$this->session->set_flashdata('success', 'SEO Data Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'page/page_details/' . $page_id;
				}
				else
				{
					$url = 'page';
				}
			}

			redirect($url);
		}
	}

	/**
	 * Check URL
	 */
	function check_url()
	{
		$page_url = $this->input->post('page_url');
		return $this->Page_model->check_url_data($page_url);
	}

	/**
	 * SEO Screen Formula
	 */
	function insert_update_seo_screen_formula()
	{
		$page_id = $this->input->post('page_id');
		$seo_screen_formula_id = $this->input->post('seo_screen_formula_id');
		$continue = $this->input->post('btn_continue');
		$tab = $this->input->post('seo_screen_formula');
		$this->session->set_flashdata('tab', $tab);
		if (!empty($seo_screen_formula_id))
		{
			$this->Page_model->insert_update_seo_screen_formula($page_id);
			$this->session->set_flashdata('success', 'SEO Screen Formula Data Successfully Updated.');
			if (isset($continue) && $continue === "Update & Continue")
			{
				$url = 'page/page_details/' . $page_id;
			}
			else
			{
				$url = 'page';
			}
		}
		else
		{
			$this->Page_model->insert_update_seo_screen_formula($page_id);
			$this->session->set_flashdata('success', 'SEO Screen Formula Data successfully Added.');
			if (isset($continue) && $continue === "save & Continue")
			{
				$url = 'page/page_details/' . $page_id;
			}
			else
			{
				$url = 'page';
			}
		}

		redirect($url);
	}

	/**
	 * Menu Image & Content Insert Update
	 */
	function insert_update_menu_detail()
	{
		$website_id = $this->admin_header->website_id();
		$page_id = $this->input->post('page_id');
		$continue = $this->input->post('btn_menu_continue');

		$this->Page_model->insert_update_menu_content($website_id, $page_id);
		if (isset($continue) && $continue === "Add & Continue" || $continue === "Update & Continue")
		{
			$url = 'page/page_details/' . $page_id;
		}
		else
		{
			$url = 'page';
		}

		redirect($url);
	}

	// Publish Page By id
	function publish($id) 
	{
		$page = $this->Page_model->get_pageby_id($id, $this->admin_header->website_id());

		if (!empty($page)) :

			$url = $page[0]->url;
			$res = $this->generate_html($url);

			if (!empty($res)) :
				$this->Page_model->publish_page($id);
				$this->session->set_flashdata('success', 'Published Successfully');
			else :
				$this->session->set_flashdata('warning', 'Something Went Wrong');
			endif;
			
			redirect('page');
		else :
			$this->session->set_flashdata('warning', 'Something Went Wrong');
			redirect('page');
		endif;
	}

	// Publish Multiple Page
	function publish_all()
	{	
		$res = '';
		$page_ids = $this->input->post('page_id');
		if (!empty($page_ids)) :
			foreach($page_ids as $page_id) :
				$page = $this->Page_model->get_pageby_id($page_id, $this->admin_header->website_id());
				if (!empty($page)) :
					$url = $page[0]->url;
					$status = $page[0]->status;

					if ($status == 1) :
						$generated_res = $this->generate_html($url);
						if (!empty($generated_res)) :
							$this->Page_model->publish_page($page_id);
							$res = "1";
						else :
							$res = "2";
						endif;
					else :
						$res = "3";
					endif;
					
				else :
					$res = "4";
				endif;
			endforeach;
		else :
			$res = "5";			
		endif;

		echo $res;
	}

	// Generate HTML Page for single URL 
	private function generate_html($file_name)
	{
		$res = "";
		$path = $_SERVER['DOCUMENT_ROOT']."/";
		$host_url = $this->admin_header->host_url();

		//$url = $host_url . '/zcms/' . $file_name;
		echo $url = $host_url . $file_name; die;

		if(strpos($file_name,'.html')) :

			if(file_exists($path.$file_name)) :

				if($file_name != 'index.php') :			 	
					 unlink($path.$file_name);
				endif;
			
			endif;			

			if ($file_name == "index.php") :
				$res = file_put_contents($path.'index.html',file_get_contents($url)) or die('no permission');
			else :
				$res = file_put_contents($path.$file_name,file_get_contents($url)) or die('no permission');
			endif;

		endif;

		return $res;
	}
}