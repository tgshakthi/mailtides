<?php
/**
 * Website
 *
 * @category class
 * @package  Websites
 * @author   Saravana
 * Created at:  05-Apr-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Website extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Website_model');
		$this->load->module('admin_header');
		$this->load->module('export_website');
		$this->form_validation->CI = & $this;
		$this->load->library('upload');
	}

	// Display all websites in a table

	function index()
	{
		$data['table'] = $this->get_table();
		$data['title'] = "Websites | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('website_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table

	function get_table()
	{
		$websites = $this->Website_model->get_websites();
		if (isset($websites) && $websites != "")
		{
			foreach($websites as $website)
			{
				$anchor_component = anchor('website/choose_components/' . $website->id, '<span class="glyphicon glyphicon-th" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Components'
				));

				$anchor_edit = anchor('website/add_edit_website/' . $website->id, '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'data-original-title' => 'Edit'
				));

				$anchor_delete = anchor(
					'',
					'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
					array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record('.$website->id.', \''.base_url('website/delete_website').'\')'
				));

				$anchor_export = anchor('website/export/' . $website->id, '<span class="glyphicon glyphicon-export" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'data-original-title' => 'Export Website'
				));
				if ($website->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$cell = array(
					'class' => 'last',
					'data' => $anchor_component . ' ' . $anchor_edit . ' ' . $anchor_export . ' ' . $anchor_delete
				);

				if ($website->logo != "")
				{
					$logo_img = $this->admin_header->image_url() . 'images' . DIRECTORY_SEPARATOR . $website->folder_name . DIRECTORY_SEPARATOR . $website->logo;
					
					$logo = img(array(
						'src' => $logo_img,
						'alt' => $website->website_name,
						'id' => 'image_preview',
						'style' => 'width:100px;'
					));
				}
				else
				{
					$logo = img(array(
						'src' => $this->admin_header->image_url() . 'images/no-logo.png',
						'alt' => 'nologo',
						'id' => 'image_preview',
						'style' => 'width:100px;'
					));
				}

				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $website->id . '">', ucwords($website->website_name) , $website->website_url, $logo, $status, $cell);
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

		$this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Website name', 'Website Url', 'Logo', 'Status', 'Action');
		return $this->table->generate();
	}

	// Add Edit Website

	function add_edit_website($id = null)
	{
		$data['websites'] = $this->Website_model->get_websites();
		if ($id != null)
		{
			$website = $this->Website_model->get_websiteby_id($id);
			$data['heading'] = 'Edit Website';
			$data['id'] = $website[0]->id;
			$data['websiteName'] = $website[0]->website_name;
			$data['folder_name'] = $website[0]->folder_name;
			$data['websiteUrl'] = $website[0]->website_url;
			$data['favicon'] = $website[0]->favicon;
			$data['logo'] = $website[0]->logo;
			$data['status'] = $website[0]->status;
		}
		else
		{
			$data['heading'] = 'Add Website';
			$data['id'] = '';
			$data['websiteName'] = '';
			$data['folder_name'] = '';
			$data['websiteUrl'] = '';
			$data['favicon'] = '';
			$data['logo'] = '';
			$data['status'] = '';
		}

		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['title'] = ($id != null) ? 'Edit Website | Administrator' : 'Add Website | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('website_header');
		$this->admin_header->index();
		$this->load->view('add_edit_website', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert Update website

	function insert_update_website()
	{
		$id = $this->input->post('id');
		$clone_website = $this->input->post('clone_website');
		$continue = $this->input->post('btn_continue');
		$website_name = $this->input->post('website-name');	
		$favicon = $this->input->post('favicon');
		$logo = $this->input->post('logo');

		// Configure Folder path for image upload for respective websites.
		$app_path = APPPATH;
		$find_path = 'admin' . DIRECTORY_SEPARATOR . 'application';
		$replace_path = 'assets' . DIRECTORY_SEPARATOR . 'images';
		$file_path = str_ireplace($find_path, $replace_path, $app_path);

		if (empty($id)) :

			// Create folder name
			$folder_name = str_ireplace(' ', '-', strtolower(trim(strip_tags($website_name))));

			// Create Folder
			if (!file_exists($file_path.$folder_name)) :
				mkdir($file_path.$folder_name);
				$upload_path = $file_path . $folder_name;
			else :
				$upload_path = $file_path . $folder_name;
			endif;

		else :
			// Get folder name from database - so if they change website name the folder will remain same.
			$website_folder_name = $this->Website_model->get_websiteby_id($id);
			$folder_name = $website_folder_name[0]->folder_name;
			$upload_path = $file_path . $folder_name;

		endif;

		// Create Favicon Folder 
		$favicon_upload_path = $upload_path . DIRECTORY_SEPARATOR . 'favicon';
		if (!file_exists($favicon_upload_path)) :
			mkdir($favicon_upload_path);
		endif;

		// Create Logo Folder
		$logo_upload_path = $upload_path . DIRECTORY_SEPARATOR . 'logo';
		if (!file_exists($logo_upload_path)) :
			mkdir($logo_upload_path);
		endif;	

		// Favicon 
		if (empty($favicon)) :		

			// Configure Upload library
			$config['upload_path'] = $favicon_upload_path;
			$config['allowed_types'] = 'image/x-icon|jpg|png';	
			$this->upload->initialize($config);
			
			if ($this->upload->do_upload('favicon')) :
				$favicon_name = $this->upload->data('file_name');
				// Favicon folder path					
				$favicon = 'favicon' . DIRECTORY_SEPARATOR . $favicon_name;
			endif;

		endif;

		// Logo
		if (empty($logo)) :					

			// Configure Upload library
			$config['upload_path'] = $logo_upload_path;
			$config['allowed_types'] = 'jpeg|jpg|png';	
			$this->upload->initialize($config);

			if ($this->upload->do_upload('logo')) :
				$logo_name = $this->upload->data('file_name');	
				// Logo folder path				
				$logo = 'logo' . DIRECTORY_SEPARATOR . $logo_name;
			endif;

		endif;	

		$website_configuration = array(
			'favicon' => $favicon,
			'logo' => $logo,
			'folder_name' => $folder_name
		);

		$error_config = array(
			array(
				'field' => 'website-name',
				'label' => 'Website Name',
				'rules' => 'required'
			) ,
			array(
				'field' => 'website-url',
				'label' => 'Website Url',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($id))
			{
				redirect('website/add_edit_website');
			}
			else
			{
				redirect('website/add_edit_website/' . $id);
			}
		}
		else
		{
			if (empty($id))
			{
				$website_datas = $this->Website_model->get_data('websites', 'id', $clone_website);
				if (!empty($website_datas))
				{
					$components = $website_datas[0]->components;
					$source_folder = $website_datas[0]->folder_name;
				}
				else
				{
					$components = '';
					$source_folder = "";
				}

				$insert_id = $this->Website_model->insert_update_website_data($website_configuration, $components);
				if ($clone_website != '')
				{

					//Copy Files from Parent website
					if (!empty($source_folder)) :
						$this->xcopy($file_path . $source_folder, $file_path . $folder_name);
					endif;

					$get_setting_datas = $this->Website_model->get_data_two_where('setting', 'website_id', $clone_website, 'page_id', 0);
					if (!empty($get_setting_datas))
					{
						foreach($get_setting_datas as $get_setting_data)
						{
							foreach($get_setting_data as $key => $value)
							{
								if ($key == 'website_id')
								{
									$insert_data[$key] = $insert_id;
								}
								elseif ($key != 'id')
								{
									$insert_data[$key] = $value;
								}
							}

							$this->Website_model->insert_data('setting', $insert_data);
							$insert_data = array();
						}
					}

					$clone_datas = array(
						array(
							'table_name' => 'pages',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'website_id',
							'temp' => 1
						) ,
						array(
							'table_name' => 'contact_information',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'website_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'social_media',
							'primary_key' => 'media_id',
							'clone_website' => $clone_website,
							'id1' => 'website_id',
							'temp' => 0
						),
						array(
							'table_name' => 'newsletter',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'website_id',
							'temp' => 0
						) , 
					);
					$clone_datas1 = array(
						array(
							'table_name' => 'page_components',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'introduction',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'banner',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'conclusion',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'counter',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,						
						array(
							'table_name' => 'our_service',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'text_full_width',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'text_image',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'text_icon',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'image_card',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'circular_image',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'gallery_category',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'website_id',
							'temp' => 2
						) ,
						array(
							'table_name' => 'event_calendar',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'website_id',
							'id2' => 'page_id',
							'temp' => 4
						) ,
						array(
							'table_name' => 'setting',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'website_id',
							'id2' => 'page_id',
							'temp' => 4
						) ,
						array(
							'table_name' => 'tab',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'website_id',
							'id2' => 'page_id',
							'temp' => 3
						)
					);
					$clone_datas2 = array(
						array(
							'table_name' => 'gallery',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'page_id',
							'id2' => 'category_id',
							'temp' => 0
						) ,
						array(
							'table_name' => 'tab_text_full_width',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'tab_id',
							'id2' => '',
							'temp' => 31
						) ,
						array(
							'table_name' => 'tab_text_image',
							'primary_key' => 'id',
							'clone_website' => $clone_website,
							'id1' => 'tab_id',
							'id2' => '',
							'temp' => 31
						)
					);

					foreach($clone_datas as $clone_data)
					{
						$table_name = $clone_data['table_name'];
						$primary_key = $clone_data['primary_key'];
						$clone_website = $clone_data['clone_website'];
						$id1 = $clone_data['id1'];
						$temp = $clone_data['temp'];
						$get_datas = $this->Website_model->get_data($table_name, $id1, $clone_website);

						if (!empty($get_datas))
						{
							foreach($get_datas as $get_data)
							{
								foreach($get_data as $key => $value)
								{
									if ($key == $id1)
									{
										$insert_data[$key] = $insert_id;
									}
									elseif ($key != $primary_key)
									{
										$insert_data[$key] = $value;
									}
								}

								$insert_data_id = $this->Website_model->insert_data($table_name, $insert_data);
								$insert_data = array();
								if ($temp == 1)
								{
									foreach($clone_datas1 as $clone_data1)
									{
										$table_name1 = $clone_data1['table_name'];
										$primary_key1 = $clone_data1['primary_key'];
										$clone_website1 = $clone_data1['clone_website'];
										$id11 = $clone_data1['id1'];
										$temp1 = $clone_data1['temp'];
										if ($temp1 == 0)
										{
											$get_datas1 = $this->Website_model->get_data($table_name1, $id11, $get_data->id);
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

													$insert_data_id1 = $this->Website_model->insert_data($table_name1, $insert_data1);
													$insert_data1 = array();
												}
											}
										}
										elseif ($temp1 == 2)
										{
											$get_datas1 = $this->Website_model->get_data($table_name1, $id11, $clone_website);
											$check_datas = $this->Website_model->get_data($table_name1, $id11, $insert_id);
											if (!empty($get_datas1))
											{
												foreach($get_datas1 as $get_data1)
												{
													if (count($get_datas1) != count($check_datas))
													{
														foreach($get_data1 as $key1 => $value1)
														{
															if ($key1 == $id11)
															{
																$insert_data1[$key1] = $insert_id;
															}
															elseif ($key1 != $primary_key1)
															{
																$insert_data1[$key1] = $value1;
															}
														}

														$insert_data_id1 = $this->Website_model->insert_data($table_name1, $insert_data1);
														$insert_data1 = array();
													}

													foreach($clone_datas2 as $clone_data2)
													{
														$table_name2 = $clone_data2['table_name'];
														$primary_key2 = $clone_data2['primary_key'];
														$clone_website2 = $clone_data2['clone_website'];
														$id12 = $clone_data2['id1'];
														$id22 = $clone_data2['id2'];
														$temp2 = $clone_data2['temp'];
														if ($temp2 != 31)
														{
															$get_datas2 = $this->Website_model->get_data_two_where($table_name2, $id12, $get_data->id, $id22, $get_data1->id);
															if (!empty($get_datas2))
															{
																foreach($get_datas2 as $get_data2)
																{
																	foreach($get_data2 as $key2 => $value2)
																	{
																		if ($key2 == $id12)
																		{
																			$insert_data2[$key2] = $insert_data_id;
																		}
																		elseif ($key2 == $id22)
																		{
																			$insert_data2[$key2] = $insert_data_id1;
																		}
																		elseif ($key2 != $primary_key2)
																		{
																			$insert_data2[$key2] = $value2;
																		}
																	}

																	$insert_data_id2 = $this->Website_model->insert_data($table_name2, $insert_data2);
																	$insert_data2 = array();
																}
															}
														}
													}
												}
											}
										}
										elseif ($temp1 == 3 || $temp1 == 4)
										{
											$id21 = $clone_data1['id2'];
											$get_datas1 = $this->Website_model->get_data_two_where($table_name1, $id11, $clone_website, $id21, $get_data->id);
											$check_datas = $this->Website_model->get_data_two_where($table_name1, $id11, $insert_id, $id21, $insert_data_id);
											if (!empty($get_datas1))
											{
												foreach($get_datas1 as $get_data1)
												{
													if (count($get_datas1) != count($check_datas))
													{
														foreach($get_data1 as $key1 => $value1)
														{
															if ($key1 == $id11)
															{
																$insert_data1[$key1] = $insert_id;
															}
															elseif ($key1 == $id21)
															{
																$insert_data1[$key1] = $insert_data_id;
															}
															elseif ($key1 != $primary_key1)
															{
																$insert_data1[$key1] = $value1;
															}
														}

														$insert_data_id1 = $this->Website_model->insert_data($table_name1, $insert_data1);
														$insert_data1 = array();
													}

													foreach($clone_datas2 as $clone_data2)
													{
														$table_name2 = $clone_data2['table_name'];
														$primary_key2 = $clone_data2['primary_key'];
														$clone_website2 = $clone_data2['clone_website'];
														$id12 = $clone_data2['id1'];
														$id22 = $clone_data2['id2'];
														$temp2 = $clone_data2['temp'];
														if ($temp2 == 31 && $temp1 != 4)
														{
															$get_datas2 = $this->Website_model->get_data($table_name2, $id12, $get_data1->id);
															if (!empty($get_datas2))
															{
																foreach($get_datas2 as $get_data2)
																{
																	foreach($get_data2 as $key2 => $value2)
																	{
																		if ($key2 == $id12)
																		{
																			$insert_data2[$key2] = $insert_data_id1;
																		}
																		elseif ($key2 != $primary_key2)
																		{
																			$insert_data2[$key2] = $value2;
																		}
																	}

																	$insert_data_id2 = $this->Website_model->insert_data($table_name2, $insert_data2);
																	$insert_data2 = array();
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
					}
				}

				$this->session->set_flashdata('success', 'Website successfully Created.');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'website/add_edit_website';
				}
				else
				{
					$url = 'website';
				}
			}
			else
			{
				$this->Website_model->insert_update_website_data($website_configuration, $components = '', $id);
				$this->session->set_flashdata('success', 'Website Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'website/add_edit_website/' . $id;
				}
				else
				{
					$url = 'website';
				}
			}

			redirect($url);
		}
	}

	// Validate Favicon

	function validate_favicon()
	{
		$check = TRUE;
		$favicon = $this->input->post('favicon');
		$httpUrl = $this->input->post('httpUrl');
		$image_url = $this->input->post('image_url');
		$favicon = str_replace($httpUrl . '/', "", $favicon);
		list($width, $height) = getimagesize($image_url . $favicon);
		if ($width > 16 || $height > 16)
		{
			$this->form_validation->set_message('validate_favicon', 'Image Should be 16x16 in Size');
			$check = FALSE;
		}

		return $check;
	}



	// Choose Components for Website

	function choose_components($id)
	{
		$data['top_header_components'] = $this->Website_model->get_top_header_components();
		$data['header_components'] = $this->Website_model->get_header_components();
		$data['component'] = $this->Website_model->get_components();
		$data['common_component'] = $this->Website_model->get_common_components();
		$data['footer_components'] = $this->Website_model->get_footer_components();
		$data['selected_components'] = $this->Website_model->get_selected_components($id);
		$data['id'] = $id;
		$data['heading'] = 'Choose Components';
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['title'] = 'Website Components | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('website_header');
		$this->admin_header->index();
		$this->load->view('choose_components', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Selected Components

	function selected_components()
	{
		$id = $this->input->post('id');
		$continue = $this->input->post('btn_continue');
		$this->Website_model->insert_update_selected_components($id);
		$this->session->set_flashdata('success', 'Components Successfully Updated');
		$url = (isset($continue) && $continue === "Update & Continue") ? 'website/choose_components/' . $id : 'website';
		redirect($url);
	}

	// Delete website by id

	function delete_website()
	{
		$this->Website_model->delete_website();
		$this->session->set_flashdata('success', 'Website Successfully Deleted.');
	}

	// Delete multiple websites

	function delete_selected_website()
	{
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('website');
		}
		else
		{
			$this->Website_model->delete_multiple_website();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('website');
		}
	}

	/**
	 * Export Website
	 */
	function export()
	{
		$this->export_website->index();
	}

	// Copy Files and folders
	function xcopy($source, $dest, $permissions = 0755)
	{
		// Check for symlinks
		if (is_link($source)) {
			return symlink(readlink($source), $dest);
		}

		// Simple copy for a file
		if (is_file($source)) {
			return copy($source, $dest);
		}

		// Make destination directory
		if (!is_dir($dest)) {
			mkdir($dest, $permissions);
		}

		// Loop through the folder
		$dir = dir($source);
		while (false !== $entry = $dir->read()) {

			// Skip pointers
			if ($entry == '.' || $entry == '..' || $entry == 'favicon' || $entry == 'logo' ) {
				continue;
			}

			// Deep copy directories
			$this->xcopy($source . DIRECTORY_SEPARATOR . $entry, $dest . DIRECTORY_SEPARATOR . $entry, $permissions);
		}

		// Clean up
		$dir->close();
		return true;
	}
}