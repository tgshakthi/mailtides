<?php
/**
 * Page Model
 *
 * @category Model
 * @package  Page
 * @author   Saravana
 * Created at:  20-Apr-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Page_model extends CI_Model
{
	private $setting_table = 'setting';
	
	/**
	 * Page Cloning
	 */
	function get_data($table_name, $id1, $id2)
	{
		$this->db->select('*');
		$this->db->where($id1, $id2);
		$query = $this->db->get($table_name);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	function get_data_two_where($table_name, $id1, $id2, $id3, $id4)
	{
		$this->db->select('*');
		$this->db->where(array(
			$id1 => $id2,
			$id3 => $id4
		));
		$query = $this->db->get($table_name);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Page Cloning Insert Data
	 */
	function insert_data($table_name, $insert_data)
	{
		$this->db->insert($table_name, $insert_data);
		return $this->db->insert_id();
	}

	/**
	 * Get all Pages
	 * return output as stdClass Object array
	 */
	function get_pages($web_id)
	{
		$this->db->select(array(
			'id',
			'title',
			'url',
			'status',
			'publish'
		));
		$this->db->where(array(
			'website_id' => $web_id,
			'is_deleted' => '0'
		));
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('pages');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get all Components
	 * return output as stdClass Object array
	 */
	function get_components()
	{
		$this->db->select(array(
			'id',
			'name'
		));
		$this->db->where('status', '1');
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('components');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get All Common Components
	 * return output as stdClass Object array
	 */
	function get_common_components()
	{
		$this->db->select(array(
			'id',
			'code',
			'name'
		));
		$this->db->where('status', '1');
		$query = $this->db->get('common_components');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get web Components id
	 * return output as stdClass Object array
	 */
	function get_web_components_id($id)
	{
		$this->db->select('components.id');
		$this->db->from('components');
		$this->db->join('websites', 'FIND_IN_SET(' . $this->db->dbprefix("components") . '.id, ' . $this->db->dbprefix("websites") . '.components) > 0');
		$this->db->where('websites.id', $id);
		$query = $this->db->get();
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result_array() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get web Components id
	 * return output as stdClass Object array
	 */
	function get_web_common_components_id($id)
	{
		$this->db->select('common_components.code as id');
		$this->db->from('common_components');
		$this->db->join('websites', 'FIND_IN_SET(' . $this->db->dbprefix("common_components") . '.code, ' . $this->db->dbprefix("websites") . '.components) > 0');
		$this->db->where('websites.id', $id);
		$query = $this->db->get();
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result_array() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get Page record by @param
	 * return output as stdClass Object array
	 */
	function get_pageby_id($id, $web_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'id' => $id,
			'website_id' => $web_id,
			'is_deleted' => '0'
		));
		$query = $this->db->get('pages');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	function clone_insert_data()
	{
		$page_url = $this->input->post('page-url');
		// if(strpos($page_url,'.html')) :
		// 	$page_url = $page_url;
		// else :
		// 	$page_url = $page_url . '.html';
		// endif;

		$status = $this->input->post('page-status');
		if (isset($status)):
			$status = '1';
		else:
			$status = '0';
		endif;
		$website_id = $this->session->userdata('website_id');
		$website_id = (isset($website_id) ? $website_id : '0');

		// insert data

		$insert_data = array(
			'website_id' => $website_id,
			'title' => $this->input->post('page-title') ,
			'url' =>  $page_url,
			'status' => $status,
			'created_at' => date('m-d-Y')
		);

		// Insert into Pages

		$this->db->insert('pages', $insert_data);
		return $this->db->insert_id();
	}

	function clone_update_data($insert_page_id, $component_ids)
	{
		$website_id = $this->session->userdata('website_id');
		$data = array(
			'component_id' => $component_ids
		);
		$this->db->where(array(
			'website_id' => $website_id,
			'id' => $insert_page_id
		));
		$this->db->update('pages', $data);
	}

	/**
	 * Insert Update Page records
	 */
	function insert_update_page_data($id = NULL)
	{
		$components = $this->input->post('components');
		$common_components = $this->input->post('common_components');
		$page_url = $this->input->post('page-url');

		// if(strpos($page_url,'.html')) :
		// 	$page_url = $page_url;
		// else :
		// 	$page_url = $page_url . '.html';
		// endif;

		$components = (!empty($common_components)) ? array_merge($components, $common_components) : $components;
		$status = $this->input->post('page-status');
		if (isset($status)):
			$status = '1';
		else:
			$status = '0';
		endif;
		$website_id = $this->session->userdata('website_id');
		$website_id = (isset($website_id) ? $website_id : '0');
		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'title' => $this->input->post('page-title') ,
				'url' => $page_url ,
				'component_id' => implode(',', $components) ,
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Insert into Pages

			$this->db->insert('pages', $insert_data);
			$id = $this->db->insert_id();
			foreach($components as $component)
			{
				$tbl_components = $this->get_componentsby_id($component);
				$tbl_common_components = $this->get_common_componentsby_id($component);
				if (!empty($tbl_components))
				{
					foreach($tbl_components as $component_result)
					{
						$page_component_data = array(
							"page_id" => $id,
							"component_name" => $component_result->name,
							"component_id" => $component_result->id,
						);
						$this->db->insert('page_components', $page_component_data);
					}
				}
				elseif (!empty($tbl_common_components))
				{
					foreach($tbl_common_components as $component_result)
					{
						$page_component_data = array(
							"page_id" => $id,
							"component_name" => $component_result->name,
							"component_id" => $component_result->code,
						);
						$this->db->insert('page_components', $page_component_data);
					}
				}
			}
			else:

				// Update data

				$update_data = array(
					'website_id' => $website_id,
					'title' => $this->input->post('page-title') ,
					'url' => $page_url ,
					'component_id' => implode(',', $components) ,
					'status' => $status,
					'created_at' => date('m-d-Y')
				);

				// Update into Pages

				$this->db->where('id', $id);
				$this->db->update('pages', $update_data);
				$this->db->where('page_id', $id);
				$this->db->delete('page_components');
				foreach($components as $component)
				{
					$tbl_components = $this->get_componentsby_id($component);
					$tbl_common_components = $this->get_common_componentsby_id($component);
					if (!empty($tbl_components))
					{
						foreach($tbl_components as $component_result)
						{
							$page_component_data = array(
								"page_id" => $id,
								"component_name" => $component_result->name,
								"component_id" => $component_result->id,
							);
							$this->db->insert('page_components', $page_component_data);
						}
					}
					elseif (!empty($tbl_common_components))
					{
						foreach($tbl_common_components as $component_result)
						{
							$page_component_data = array(
								"page_id" => $id,
								"component_name" => $component_result->name,
								"component_id" => $component_result->code,
							);
							$this->db->insert('page_components', $page_component_data);
						}
					}
				}

			endif;
		}

		/**
		 * Delete Page by @param
		 */
		function delete_page()
		{
			$id = $this->input->post('id');
			$data = array(
				'is_deleted' => '1'
			);
			$this->db->where('id', $id);
			return $this->db->update('pages', $data);
		}

		/**
		 * Delete multiple page record by @param
		 */
		function delete_multiple_page()
		{
			$page_ids = $this->input->post('table_records');
			foreach($page_ids as $page_id):
				$data = array(
					'is_deleted' => '1'
				);
				$this->db->where('id', $page_id);
				$this->db->update('pages', $data);
			endforeach;
		}

		/**
		 * Get Page Details tab records by @param
		 * return output as stdClass Object array
		 */
		function get_page_details($page_id)
		{
			$this->db->select(array(
				'id',
				'title',
				'url',
				'component_id'
			));
			$this->db->where(array(
				'id' => $page_id,
				'status' => '1',
				'is_deleted' => '0'
			));
			$query = $this->db->get('pages');
			$records = array();
			if ($query->num_rows() > 0):
				foreach($query->result() as $row):
					$records[] = $row;
				endforeach;
			endif;
			return $records;
		}

		/**
		 * Get Page components by @param
		 * return output as stdClass Object array
		 */
		function get_page_components($page_id, $component_name = NULL)
		{
			$this->db->select("*");
			if ($component_name === NULL)
			{
				$this->db->where(array(
					'page_id' => $page_id
				));
			}
			else
			{
				$this->db->where(array(
					'page_id' => $page_id,
					'component_name' => $component_name
				));
			}

			$this->db->order_by('sort_order');
			$query = $this->db->get('page_components');
			$records = array();
			if ($query->num_rows() > 0):
				foreach($query->result() as $row):
					$records[] = $row;
				endforeach;
			endif;
			return $records;
		}

		/**
		 * Get Components by @param
		 * return output as stdClass Object array
		 */
		function get_componentsby_id($id)
		{
			$this->db->select('*');
			$this->db->where(array(
				'id' => $id,
				'status' => '1'
			));
			$query = $this->db->get('components');
			$records = array();
			if ($query->num_rows() > 0):
				foreach($query->result() as $row):
					$records[] = $row;
				endforeach;
			endif;
			return $records;
		}

		/**
		 * Get Common Components by @param
		 * return output as stdClass Object array
		 */
		function get_common_componentsby_id($code)
		{
			$this->db->select('*');
			$this->db->where(array(
				'code' => $code,
				'status' => '1'
			));
			$query = $this->db->get('common_components');
			$records = array();
			if ($query->num_rows() > 0):
				foreach($query->result() as $row):
					$records[] = $row;
				endforeach;
			endif;
			return $records;
		}

		/**
		 * Get SEO record by @param
		 * return output as stdClass Object array
		 */
		function get_seo($page_id, $tbl_name)
		{
			$this->db->select("*");
			$this->db->where(array(
				'page_id' => $page_id
			));
			$query = $this->db->get($tbl_name);
			$records = array();
			if ($query->num_rows() > 0):
				foreach($query->result() as $row):
					$records[] = $row;
				endforeach;
			endif;
			return $records;
		}

		/**
		 * Insert Update Page Detail tab
		 */
		function insert_update_page_details()
		{
			$id = $this->input->post('id');
			$row_order = $this->input->post('row_order');
			$chk_com = $this->input->post('chk_com');
			if (!empty($id))
			{
				$page_comp = $this->get_page_components($id);
				$row_order = explode(",", $row_order);
				$row_order = array_filter($row_order);
				if (isset($page_comp) && $page_comp != "")
				{
					for ($i = 0; $i < count($row_order); $i++)
					{
						$page_sort = $this->get_page_components($id, $row_order[$i]);
						if (!empty($page_sort))
						{
							$pagecomponent_updata = array(
								"sort_order" => $i,
							);
							$this->db->where('page_id', $id);
							$this->db->where('component_name', $row_order[$i]);
							$this->db->update('page_components', $pagecomponent_updata);
						}
					}

					if (!empty($chk_com))
					{
						foreach($page_comp as $page_component)
						{
							if (in_array($page_component->component_name, $chk_com))
							{
								$update_status = array(
									"status" => '1',
								);
								$this->db->where('page_id', $id);
								$this->db->where('component_name', $page_component->component_name);
								$this->db->update('page_components', $update_status);
							}
							else
							{
								$update_status = array(
									"status" => '0',
								);
								$this->db->where('page_id', $id);
								$this->db->where('component_name', $page_component->component_name);
								$this->db->update('page_components', $update_status);
							}
						}
					}
					else
					{
						$update_status_res = array(
							"status" => '0',
						);
						$this->db->where('page_id', $id);
						$this->db->update('page_components', $update_status_res);
					}
				}
			}
		}

		/**
		 * Insert Update SEO tab data
		 */
		function insert_update_seo_data()
		{
			$page_id = $this->input->post('page_id');
			$query = $this->db->select('page_id')->where('page_id', $page_id)->get('seo');
			if ($query->num_rows() > 0):
				$update_data = array(
					'h1_tag' => $this->input->post('h1_tag') ,
					'h2_tag' => $this->input->post('h2_tag') ,
					'meta_title' => $this->input->post('meta-title') ,
					'meta_description' => $this->input->post('meta-description') ,
					'meta_keyword' => $this->input->post('meta-keyword') ,
					'meta_misc' => $this->input->post('meta-misc')
				);
				$this->db->where('page_id', $page_id);
				$this->db->update('seo', $update_data);
			else:
				$insert_data = array(
					'page_id' => $page_id,
					'h1_tag' => $this->input->post('h1_tag') ,
					'h2_tag' => $this->input->post('h2_tag') ,
					'meta_title' => $this->input->post('meta-title') ,
					'meta_description' => $this->input->post('meta-description') ,
					'meta_keyword' => $this->input->post('meta-keyword') ,
					'meta_misc' => $this->input->post('meta-misc') ,
					'created_at' => date('m-d-Y')
				);
				$this->db->insert('seo', $insert_data);
			endif;
		}

		/**
		 * Check Duplicate URL
		 */
		function check_url_data($url)
		{
			$this->db->select('url');
			$this->db->where('url', $url);
			$query = $this->db->get('pages');
			if ($query->num_rows() > 0):
				echo '1';
			endif;
		}

		/*
		* Insert Update Seo Screen Formula
		*/
		function insert_update_seo_screen_formula($page_id)
		{
			$page_id = $this->input->post('page_id');
			$id = $this->input->post('seo_screen_formula_id');
			$title_cities = $this->input->post('title_cities');
			$title_city = json_encode($title_cities);
			$keyword_cities = $this->input->post('keyword_cities');
			$keyword_city = json_encode($keyword_cities);
			$description_cities = $this->input->post('description_cities');
			$description_city = json_encode($description_cities);
			$savegen = $this->input->post('generate');

			// $saveseo   = $this->input->post('saveseo');

			$publish = $this->input->post('publish');

			// $get_seoresult = $this->get_seo_data('seo_result');

			$get = $this->get_seo_data('seo_screen_formula');
			$get_seo = $this->get_seo($page_id, 'seo');
			$get_h1_h2 = $this->get_seo($page_id, 'h1_and_h2');
			$seodata = array(
				'page_id' => $page_id,
				'main_keyword' => $this->input->post('main_keyword') ,
				'secondary_keyword' => $this->input->post('secondary_keyword') ,
				'main_service' => $this->input->post('main_service') ,
				'secondary_service' => $this->input->post('secondary_service') ,
				'service3' => $this->input->post('3rd_service') ,
				'service4' => $this->input->post('4th_service') ,
				'service5' => $this->input->post('5th_service') ,
				'service6' => $this->input->post('6th_service') ,
				'service7' => $this->input->post('7th_service') ,
				'service8' => $this->input->post('8th_service') ,
				'title_cities' => $title_city,
				'keyword_cities' => $keyword_city,
				'description_cities' => $description_city,
				'description_category' => $this->input->post('description_category') ,
				'description' => $this->input->post('description')
			);

			// echo '<pre>';
			// print_r($seodata);die;

			$seo_data = array(
				'page_id' => $page_id,
				'h1_tag' => $this->input->post('h1_value') ,
				'h2_tag' => $this->input->post('h2_value') ,
				'meta_title' => $this->input->post('title') ,
				'meta_description' => $this->input->post('seodesc') ,
				'meta_keyword' => $this->input->post('keywords')
			);
			$seo_h1_h2 = array(
				'page_id' => $page_id,
				'h1_tag' => $this->input->post('h1_value') ,
				'h2_tag' => $this->input->post('h2_value')
			);
			if ($savegen != "")
			{
				if (!empty($id))
				{
					$this->db->where('page_id', $page_id);
					$this->db->update('seo_screen_formula', $seodata);
				}
				else
				{
					$this->db->insert('seo_screen_formula', $seodata);
				}

				$redirect_path = "page/page_details/" . $page_id;
			}

			if ($publish != "")
			{
				if (!empty($get_seo))
				{
					$this->db->where('page_id', $page_id);
					$this->db->update('seo', $seo_data);
				}
				else
				{
					$this->db->insert('seo', $seo_data);
				}

				if (!empty($get_h1_h2))
				{
					$this->db->where('page_id', $page_id);
					$this->db->update('h1_and_h2', $seo_h1_h2);
				}
				else
				{
					$this->db->insert('h1_and_h2', $seo_h1_h2);
				}

				$redirect_path = "page/page_details/" . $page_id;
			}

			$this->session->set_flashdata('success', 'Content Successfully Updated');
			redirect($redirect_path, 'location');
		}

		function get_seo_data($tbl_name)
		{
			$this->db->select("*");
			$this->db->where(array(
				'status' => '1',
				'is_deleted' => '0'
			));
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get($tbl_name);
			$records = array();
			if ($query->num_rows() > 0):
				foreach($query->result() as $row):
					$records[] = $row;
				endforeach;
			endif;
			return $records;
		}

		/**
		 * Get Website Url
		 * @param website_id
		 */
		function get_website_url($website_id)
		{
			$this->db->select('website_url');
			$this->db->where(array(
				'id' => $website_id,
				'status' => '1',
				'is_deleted' => '0'
			));
			$query = $this->db->get('websites');
			$records = array();
			if ($query->num_rows() > 0):
				$records = $query->result();
			endif;
			return $records;
		}

		/**
		 * Insert Update Menu Content
		 */
		function insert_update_menu_content($website_id, $page_id)
		{
			$website_folder_name = $this->admin_header->website_folder_name();
			$page_id = $this->input->post('page_id');
			$image = $this->input->post('image');
			$httpUrl = $this->input->post('httpUrl');
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$image    = str_replace($find_url, "", $image);

			$text = trim(html_entity_decode($this->input->post('menu_content')));
			$status = $this->input->post('menu_status');
			$status = (isset($status)) ? '1' : '0';
			$key = array(
				'page_menu_image',
				'page_menu_content',
				'page_menu_status'
			);
			$value = array(
				$image,
				$text,
				$status
			);

			// Convert to JSON data

			$keyJSON = json_encode($key);
			$valueJSON = json_encode($value);
			$page_menu_details = $this->get_page_menu_setting_details($website_id, $page_id, 'page_menu_content');
			if (empty($page_menu_details)):

				// insert data

				$insert_data = array(
					'website_id' => $website_id,
					'page_id' => $page_id,
					'code' => 'page_menu_content',
					'key' => $keyJSON,
					'value' => $valueJSON
				);
				$this->db->insert($this->setting_table, $insert_data);
				$this->session->set_flashdata('success', 'Menu Content Successfully Created');
			else:

				// Update data

				$update_data = array(
					'key' => $keyJSON,
					'value' => $valueJSON
				);
				$this->db->where(array(
					'website_id' => $website_id,
					'code' => 'page_menu_content',
					'page_id' => $page_id
				));
				$this->session->set_flashdata('success', 'Menu Content Successfully Updated');
				return $this->db->update($this->setting_table, $update_data);
			endif;
		}

		/**
		 * Get Menu Content setting Details
		 * return output as stdClass Object array
		 */
		function get_page_menu_setting_details($website_id, $page_id, $code)
		{
			$this->db->select('*');
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => $code,
				'page_id' => $page_id
			));
			$query = $this->db->get($this->setting_table);
			$records = array();
			if ($query->num_rows() > 0):
				foreach($query->result() as $row):
					$records[] = $row;
				endforeach;
			endif;
			return $records;
		}

		// Publish Page
		function publish_page($id)
		{
			$update_data = array(
				'publish' => '1'
			);

			$this->db->where('id', $id);
			$this->db->update('pages', $update_data);
		}
	}