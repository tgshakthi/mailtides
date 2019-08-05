<?php
/**
 * Contact Us Models
 *
 * @category Model
 * @package  Contact Us
 * @author   Athi
 * Created at:  20-Jun-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contact_us_model extends CI_Model
{
	private $table_name = 'contact_us';
	private $table_contact_us_form = 'contact_us_form';

	/**
	 * Get Contact Us
	 * return output as stdClass Object array
	 */
	function get_contact($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'is_deleted' => 0
		));
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Get Contact Form

	function get_contact_form($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id
		));
		$query = $this->db->get($this->table_contact_us_form);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	}

	function edit_contact_form($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id
		));
		$query = $this->db->get('contact_us_form');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	function get_contact_us($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id
		));
		$query = $this->db->get('contact_us_form');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Separate Value for Contact us

	function get_single_contact_us($id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'id' => $id,
			'is_deleted' => 0
		));
		$query = $this->db->get('contact_us');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Update Contact Us

	function update_contact_us($id, $website_id)
	{
		$out = array(
			' '
		);
		$in = array(
			'_'
		);
		$update_data = array();
		$contact_form_label_names = $this->get_contact_form_label_name($website_id);
		$contact_form_choose_fields = $this->get_contact_form_choose_field($website_id);
		if (!empty($contact_form_label_names))
		{
			foreach($contact_form_label_names as $key => $val)
			{
				$label_name = str_replace($out, $in, $contact_form_label_names[$key]);
				if ($contact_form_choose_fields[$key] == 'textbox' || $contact_form_choose_fields[$key] == 'textarea' || $contact_form_choose_fields[$key] == 'datepicker' || $contact_form_choose_fields[$key] == 'radio' || $contact_form_choose_fields[$key] == 'dropdown')
				{
					$update_data[] = $this->input->post($label_name);
				}
				elseif ($contact_form_choose_fields[$key] == 'checkbox')
				{
					$namechk = implode(',', $this->input->post($label_name));
					$update_data[] = $namechk;
				}
			}
		}

		// Update into Contact Us

		$this->db->where('id', $id);
		return $this->db->update('contact_us', array(
			'value' => json_encode($update_data)
		));
	}

	// Delete Contact Us

	function delete_contact_us()
	{
		$id = $this->input->post('id');
		$this->db->where('id', $id);
		return $this->db->update('contact_us', array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple Text Image

	function delete_multiple_contact_us()
	{
		$contact_us = $this->input->post('table_records');
		foreach($contact_us as $contact):
			$this->db->where('id', $contact);
			$this->db->update('contact_us', array(
				'is_deleted' => 1
			));
		endforeach;
	}

	// Get Contact Form Field

	function get_contact_form_field($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id
		));
		$query = $this->db->get('contact_us_form');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get Contact Form Field Label

	function get_contact_form_field_label($website_id)
	{
		$this->db->select(array(
			'GROUP_CONCAT(LOWER(REPLACE(REPLACE(label_name, "& ", ""), " ", "_")) ORDER BY sort_order ASC) as label_name'
		));
		$this->db->where(array(
			'website_id' => $website_id
		));
		$this->db->order_by('sort_order', 'ASC');
		$query = $this->db->get('contact_form_field');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get Separate Form Field

	function contact_form_field($website_id, $field_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'id' => $field_id,
			'website_id' => $website_id,
			'is_deleted' => 0
		));
		$query = $this->db->get('contact_form_field');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Contact Form Field Remove

	function contact_form_field_remove($website_id, $id)
	{

		// Remove data

		$remove_data = array(
			'is_deleted' => 1
		);

		// Update into Form Field

		$this->db->where(array(
			'id' => $id,
			'website_id' => $website_id
		));
		return $this->db->update('contact_form_field', $remove_data);
	}

	// Get Contact Title Table

	function contact_form($website_id, $code, $page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));
		$query = $this->db->get('setting');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Contact Page

	function contact_page($website_id, $page_id)
	{
		$this->db->select(array(
			'id',
			'code'
		));
		$this->db->where(array(
			'website_id' => $website_id,
			'page_id' => $page_id,
			'status' => 1
		));
		$query = $this->db->get('contact_pages');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Check Contact Page

	function check_contact_page($website_id, $page_id)
	{
		$this->db->select(array(
			'id',
			'code'
		));
		$this->db->where(array(
			'website_id' => $website_id,
			'page_id' => $page_id
		));
		$query = $this->db->get('contact_pages');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Insert Contact Pages

	function insert_contact_pages($website_id, $page_id)
	{
		$contacts = $this->input->post('contact');
		$common_components = $this->input->post('common_components');
		foreach($contacts as $contact)
		{
			if (in_array($contact, $common_components))
			{

				// insert data

				$insert_data = array(
					'website_id' => $website_id,
					'page_id' => $page_id,
					'code' => $contact,
					'status' => 1
				);
			}
			else
			{

				// insert data

				$insert_data = array(
					'website_id' => $website_id,
					'page_id' => $page_id,
					'code' => $contact,
					'status' => 0
				);
			}

			// Insert into Contact Page

			$this->db->insert('contact_pages', $insert_data);
		}
	}

	// Update Contact Pages

	function update_contact_pages($website_id, $page_id)
	{
		$contacts = $this->input->post('contact');
		$common_components = $this->input->post('common_components');
		foreach($contacts as $contact)
		{
			if (in_array($contact, $common_components))
			{

				// update data

				$update_data = array(
					'status' => 1
				);
			}
			else
			{

				// update data

				$update_data = array(
					'status' => 0
				);
			}

			// Update into Contact Page

			$this->db->where(array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => $contact
			));
			$this->db->update('contact_pages', $update_data);
		}
	}

	// Insert Update Contact Customize

	function insert_update_contact_customize($website_id, $id = Null)
	{
		$captcha = $this->input->post('captcha');
		$border = $this->input->post('border');
		$status = $this->input->post('status');
		$captcha = (isset($captcha)) ? '1' : '0';
		$border = (isset($border)) ? '1' : '0';
		$status = (isset($status)) ? '1' : '0';
		$website_folder_name = $this->admin_header->website_folder_name();
		$httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('contact_us_background_color');
		$image = $this->input->post('image');
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$contact_us_background = str_replace($find_url, "", $image);
		else :
			$contact_us_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;	
		
		$key = array(
			'form_title' => $this->input->post('form_title') ,
			'title_color' => $this->input->post('title_color') ,
			'title_position' => $this->input->post('title_position') ,
			'label_color' => $this->input->post('label_color') ,
			'button_label' => $this->input->post('button_label') ,
			'captcha' => $captcha,
			'choose_captcha' => $this->input->post('choose_captcha') ,
			'button_type' => $this->input->post('button_type') ,
			'button_label_color' => $this->input->post('button_label_color') ,
			'hover_label_color' => $this->input->post('hover_label_color') ,
			'button_background_color' => $this->input->post('button_background_color') ,
			'hover_background_color' => $this->input->post('hover_background_color') ,
			'border' => $border,
			'border_size' => $this->input->post('border_size') ,
			'border_color' => $this->input->post('border_color') ,
			'google_site_key' => $this->input->post('google_site_key') ,
			'google_secret_key' => $this->input->post('google_secret_key') ,
			'image_captcha_width' => $this->input->post('image_captcha_width') ,
			'image_captcha_height' => $this->input->post('image_captcha_height') ,
			'image_captcha_word_length' => $this->input->post('image_captcha_word_length') ,
			'image_captcha_font_size' => $this->input->post('image_captcha_font_size') ,
			'component_background' => $component_background,
			'contact_us_background' => $contact_us_background,
			'status' => $status
		);
		$keyJSON = json_encode($key);
		$contact_us = $this->get_contact_form($website_id);
		if (empty($contact_us)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'contact_customize' => $keyJSON
			);

			// Insert into contact form

			return $this->db->insert('contact_us_form', $insert_data);
		else:
			$update_data = array(
				'contact_customize' => $keyJSON
			);
			$this->db->where(array(
				'website_id' => $website_id
			));
			return $this->db->update('contact_us_form', $update_data);
		endif;
	}

	// Insert Contact Form

	function insert_contact_form($website_id, $title, $table)
	{

		// insert data

		$insert_data = array(
			'website_id' => $website_id,
			'title' => $title,
			'tbl_name' => $table,
			'created_at' => date('m-d-Y')
		);

		// Insert into Form Field

		return $this->db->insert('contact_form_layout', $insert_data);
	}

	// Update Contact Form

	function update_contact_form($website_id, $title, $table)
	{

		// update data

		$update_data = array(
			'website_id' => $website_id,
			'title' => $title,
			'tbl_name' => $table,
		);

		// Update into Form Field

		$this->db->where('website_id', $website_id);
		return $this->db->update('contact_form_layout', $update_data);
	}

	// Update Form Field

	function update_form_field($website_id, $id, $label, $field_attributes, $placeholder, $validation, $required, $icon)
	{

		// Update data

		$update_data = array(
			'website_id' => $website_id,
			'label_name' => $label,
			'field_attributes' => $field_attributes,
			'icon' => $icon,
			'placeholder' => $placeholder,
			'validation' => $validation,
			'required' => $required
		);

		// Update into Form Field

		$this->db->where(array(
			'id' => $id,
			'website_id' => $website_id
		));
		return $this->db->update('contact_form_field', $update_data);
	}

	function get_contact_form_field_details($website_id)
	{
		$this->db->select(array(
			'id',
			'contact_form_field'
		));
		$this->db->where(array(
			'website_id' => $website_id
		));
		$query = $this->db->get('contact_us_form');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	function get_contact_form_fields($website_id)
	{
		$records = array();
		$contact_forms = $this->get_contact_form($website_id);
		if (!empty($contact_forms) && $contact_forms[0]->contact_form_field != '')
		{
			$records = json_decode($contact_forms[0]->contact_form_field);
		}

		return $records;
	}

	function get_contact_form_label_name($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields))
		{
			$records = $contact_form_fields->label_name;
		}

		return $records;
	}

	function get_contact_form_old_label_name($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields))
		{
			$records = $contact_form_fields->old_label_name;
		}

		return $records;
	}

	/**
	 * Get Enable Label Name
	 */
	function get_enable_label_name($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields) && !empty($contact_form_fields->label_name) && !empty($contact_form_fields->is_deleted))
		{
			$i = 0;
			foreach($contact_form_fields->label_name as $label_name)
			{
				if ($contact_form_fields->is_deleted[$i] == 0)
				{
					$records[] = $label_name;
				}

				$i++;
			}
		}

		return $records;
	}

	function get_contact_form_choose_field($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields))
		{
			$records = $contact_form_fields->choosefield;
		}

		return $records;
	}

	function get_contact_form_icon($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields))
		{
			$records = $contact_form_fields->icon;
		}

		return $records;
	}

	function get_contact_form_placeholder($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields))
		{
			$records = $contact_form_fields->placeholder;
		}

		return $records;
	}

	function get_contact_form_sort_order($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields))
		{
			$records = $contact_form_fields->sort_order;
		}

		return $records;
	}

	function get_contact_form_validation($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields))
		{
			$records = $contact_form_fields->validation;
		}

		return $records;
	}

	function get_contact_form_required($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields))
		{
			$records = $contact_form_fields->required;
		}

		return $records;
	}

	function get_contact_form_is_deleted($website_id)
	{
		$records = array();
		$contact_form_fields = $this->get_contact_form_fields($website_id);
		if (!empty($contact_form_fields))
		{
			$records = $contact_form_fields->is_deleted;
		}

		return $records;
	}

	function get_contact_form_mail_configure($website_id)
	{
		$records = array();
		$contact_forms = $this->get_contact_form($website_id);
		if (!empty($contact_forms) && $contact_forms[0]->contact_mail_config != '')
		{
			$records = json_decode($contact_forms[0]->contact_mail_config);
		}

		return $records;
	}

	function get_contact_form_layout($website_id)
	{
		$records = array();
		$contact_forms = $this->get_contact_form($website_id);
		if (!empty($contact_forms) && $contact_forms[0]->contact_form_layout != '')
		{
			$records = json_decode($contact_forms[0]->contact_form_layout);
		}

		return $records;
	}

	function get_contact_form_shows($website_id)
	{
		$records = array();
		$contact_forms = $this->get_contact_form($website_id);
		if (!empty($contact_forms) && $contact_forms[0]->is_show != '')
		{
			$records = json_decode($contact_forms[0]->is_show);
		}

		return $records;
	}










	// Insert Update Contact Form Field

	function insert_update_contact_form_field($website_id)
	{

		// echo '<pre>';
		// print_r($_POST);
		// die;

		$label_names = $this->input->post('label_name');
		$old_label_names = $this->input->post('old_label_name');
		$change_label_checks = array();
		if ($label_names != $old_label_names)
		{
			$old_label_names = (empty($old_label_names)) ? array() : $old_label_names;
			$diff_label_names = array_diff($label_names, $old_label_names);
			$i = 0;
			if (!empty($old_label_names))
			{
				foreach($diff_label_names as $key => $value)
				{
					$old_label_name = $old_label_names[$key];
					$mail_configures = $this->get_contact_form_mail_configure($website_id);
					if (!empty($mail_configures))
					{
						$label_checks = ($mail_configures->label_check != '') ? explode(',', $mail_configures->label_check) : array();
						$label_checks = ($i != 0) ? $change_label_checks : $label_checks;
						$get_label_check_key = array_search($old_label_name, $label_checks);
						if (is_numeric($get_label_check_key))
						{
							$a1 = array(
								$get_label_check_key => $value
							);
							$change_label_checks = array_replace($label_checks, $a1);
						}
						else
						{
							$change_label_checks = $label_checks;
						}

						$change_label_checks1 = array(
							'label_check' => implode(',', $change_label_checks)
						);
						$std_obj_to_array = json_decode(json_encode($mail_configures) , True);
						$label_check_change_data = array_replace($std_obj_to_array, $change_label_checks1);
						$sort_label_names = ($mail_configures->sort_label_name != '') ? explode(',', $mail_configures->sort_label_name) : array();
						$sort_label_names = ($i != 0) ? $change_sort_label_names : $sort_label_names;
						$get_label_check_key = array_search($old_label_name, $sort_label_names);
						if (is_numeric($get_label_check_key))
						{
							$a1 = array(
								$get_label_check_key => $value
							);
							$change_sort_label_names = array_replace($sort_label_names, $a1);
						}
						else
						{
							$change_sort_label_names = $sort_label_names;
						}

						$change_sort_label_names1 = array(
							'sort_label_name' => implode(',', $change_sort_label_names)
						);
						$sort_label_name_change_data = array_replace($label_check_change_data, $change_sort_label_names1);
						$this->db->where('website_id', $website_id);
						$this->db->update('contact_us_form', array(
							'contact_mail_config' => json_encode($sort_label_name_change_data)
						));
					}

					$contact_form_layouts = $this->get_contact_form_layout($website_id);
					if (!empty($contact_form_layouts))
					{
						$data_res = array();
						$columns = $contact_form_layouts->column;
						$slash_columns = explode('/', $columns);
						foreach($slash_columns as $slash_column)
						{
							$dash_columns = explode('-', $slash_column);
							$comma_columns = explode(',', $dash_columns[1]);
							$get_columns = array_search($old_label_name, $comma_columns);
							if (is_numeric($get_columns))
							{
								$a1 = array(
									$get_columns => $value
								);
								$change_columns = array_replace($comma_columns, $a1);
								$data_res[] = $dash_columns[0] . '-' . implode(',', $change_columns);
							}
							else
							{
								$data_res[] = $dash_columns[0] . '-' . $dash_columns[1];
							}
						}

						$change_columns1 = array(
							'column' => implode('/', $data_res)
						);
						$std_obj_to_array_column = json_decode(json_encode($contact_form_layouts) , True);
						$column_change_data = array_replace($std_obj_to_array_column, $change_columns1);
						$this->db->where('website_id', $website_id);
						$this->db->update('contact_us_form', array(
							'contact_form_layout' => json_encode($column_change_data)
						));
					}

					$contact_form_shows = $this->get_contact_form_shows($website_id);
					if (!empty($contact_form_shows))
					{
						$get_shows = array_search($old_label_name, $contact_form_shows);
						if (is_numeric($get_shows))
						{
							$a1 = array(
								$get_shows => $value
							);
							$change_shows = array_replace($contact_form_shows, $a1);
							$this->db->where('website_id', $website_id);
							$this->db->update('contact_us_form', array(
								'is_show' => json_encode($change_shows)
							));
						}
					}

					$i++;
				}
			}
		}

		$contact_form_field = $this->get_contact_form_field_details($website_id);
		$data['label_name'] = $this->input->post('label_name');
		$data['old_label_name'] = $this->input->post('old_label_name');
		$data['choosefield'] = $this->input->post('choosefield');
		$data['icon'] = $this->input->post('icon');
		$data['placeholder'] = $this->input->post('placeholder');
		$data['sort_order'] = $this->input->post('sort_order');
		$data['validation'] = $this->input->post('validation');
		$data['required'] = $this->input->post('required');
		$data['is_deleted'] = $this->input->post('is_deleted');
		if (empty($contact_form_field)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'contact_form_field' => json_encode($data) ,
			);
			$this->db->insert('contact_us_form', $insert_data);
		else:

			// Update data

			$update_data = array(
				'contact_form_field' => json_encode($data) ,
			);
			$this->db->where(array(
				'website_id' => $website_id
			));
			$this->db->update('contact_us_form', $update_data);
		endif;
		$label_name = $this->input->post('label_name');
		$get_contact = $this->get_contact($website_id);
		if (!empty($get_contact))
		{
			$update_data = array(
				'key' => json_encode($label_name) ,
			);
			$this->db->where(array(
				'website_id' => $website_id
			));
			$this->db->update('contact_us', $update_data);
		}
	}













	/**
	 * Remove Contact Field
	 */
	function contact_field_remove($website_id, $remove_name)
	{
		$label_names = $this->get_contact_form_label_name($website_id);
		$is_deleteds = $this->get_contact_form_is_deleted($website_id);
		if (!empty($label_names))
		{
			$i = 0;
			foreach($label_names as $label_name)
			{
				$remove_data[] = ($label_name == $remove_name) ? 1 : $is_deleteds[$i];
				$i++;
			}
		}
		else
		{
			$remove_data = $is_deleteds;
		}

		$data['label_name'] = $this->get_contact_form_label_name($website_id);
		$data['old_label_name'] = $this->get_contact_form_old_label_name($website_id);
		$data['choosefield'] = $this->get_contact_form_choose_field($website_id);
		$data['icon'] = $this->get_contact_form_icon($website_id);
		$data['placeholder'] = $this->get_contact_form_placeholder($website_id);
		$data['sort_order'] = $this->get_contact_form_sort_order($website_id);
		$data['validation'] = $this->get_contact_form_validation($website_id);
		$data['required'] = $this->get_contact_form_required($website_id);
		$data['is_deleted'] = $remove_data;

		// Update into Form Field

		$this->db->where(array(
			'website_id' => $website_id
		));
		return $this->db->update('contact_us_form', array(
			'contact_form_field' => json_encode($data)
		));
	}

	// Get Contact Mail Form Field

	function get_contact_mail_form_field($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id
		));
		$query = $this->db->get('contact_us_form');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Insert Update Contact Mail Configure

	function insert_update_contact_mail_configure($website_id, $id = NULL)
	{
		$send_mail_to = $this->input->post('send_mail_to');
		$status = $this->input->post('status');
		$carbon_copy_to = $this->input->post('carbon_copy_to');
		$carbon_copy_cc = $this->input->post('carbon_copy_cc');
		$carbon_copy_bcc = $this->input->post('carbon_copy_bcc');
		$sort_label_name = $this->input->post('sort_label_name');
		$label_check = $this->input->post('label_check');
		$label_check = ($label_check != '') ? implode(',', $label_check) : '';
		$sort_label_name = ($sort_label_name != '') ? implode(',', $sort_label_name) : '';
		$send_mail_to = (isset($send_mail_to)) ? '1' : '0';
		$status = (isset($status)) ? '1' : '0';
		$carbon_copy_to = ($carbon_copy_to != '') ? implode(",", $carbon_copy_to) : '';
		$carbon_copy_cc = ($carbon_copy_cc != '') ? implode(",", $carbon_copy_cc) : '';
		$carbon_copy_bcc = ($carbon_copy_bcc != '') ? implode(",", $carbon_copy_bcc) : '';
		$contact_mail_form = array(
			'mail_subject' => $this->input->post('mail_subject') ,
			'from_name' => $this->input->post('from_name') ,
			'message_content' => $this->input->post('message_content') ,
			'success_title' => $this->input->post('success_title') ,
			'success_message' => $this->input->post('success_message') ,
			'send_mail_to' => $send_mail_to,
			'to_address' => $carbon_copy_to,
			'ccid' => $carbon_copy_cc,
			'bccid' => $carbon_copy_bcc,
			'label_check' => $label_check,
			'sort_label_name' => $sort_label_name,
			'status' => $status,
		);
		$keyJSON = json_encode($contact_mail_form);
		$contact_mail_configure = $this->get_contact_mail_form_field($website_id);
		if (empty($contact_mail_configure)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'contact_mail_config' => $keyJSON,
			);
			return $this->db->insert('contact_us_form', $insert_data);
		else:

			// Update data

			$update_data = array(
				'contact_mail_config' => $keyJSON,
			);
			$this->db->where(array(
				'website_id' => $website_id
			));
			return $this->db->update('contact_us_form', $update_data);
		endif;
	}

	// Update Choose Field

	function update_choose_field($website_id)
	{
		$contact_form_fields = $this->get_contact_form_field($website_id);
		if (!empty($contact_form_fields))
		{
			$update_data = array(
				'is_show' => json_encode($this->input->post('field_id'))
			);
			$this->db->where(array(
				'website_id' => $website_id
			));
			$this->db->update('contact_us_form', $update_data);
		}
	}

	// Update Contact Form Layout

	function update_contact_form_layout($website_id, $row, $column)
	{
		$key = array(
			'row' => $row,
			'column' => $column
		);
		$keyJSON = json_encode($key);
		$contact_form = $this->get_contact_form_fields($website_id);
		if (empty($contact_form)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'contact_form_layout' => $keyJSON
			);
			return $this->db->insert('contact_us_form', $insert_data);
		else:

			// Update data

			$update_data = array(
				'contact_form_layout' => $keyJSON
			);
			$this->db->where(array(
				'website_id' => $website_id
			));
			return $this->db->update('contact_us_form', $update_data);
		endif;
	}

	// Update Contact Layout

	function update_contact_layout($website_id, $page_id, $row, $row_column_nos)
	{
		$key = array(
			'contact_row',
			'contact_column'
		);
		$value[] = $row;
		$value[] = $row_column_nos;

		// Convert to JSON data

		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		$contact = $this->get_contact_setting($website_id, 'contact_page_layout', $page_id);
		if (empty($contact)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'contact_page_layout',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Insert into Contact page

			$this->db->insert('setting', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Update into Contact page

			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'contact_page_layout',
				'page_id' => $page_id
			));
			return $this->db->update('setting', $update_data);
		endif;
	}

	function get_contact_setting($website_id, $code, $page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));
		$query = $this->db->get('setting');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Insert Contact Pages

	function insert_update_contact_page($website_id, $page_id)
	{
		$contact_info = $this->input->post('contact_information');
		$contact_us = $this->input->post('contact_us');
		$key = array(
			'contact_us',
			'contact_info_page'
		);
		$value[] = (isset($contact_us) ? '1' : '0');
		$value[] = (isset($contact_info) ? '1' : '0');

		// Convert to JSON data

		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		$contact = $this->get_contact_setting($website_id, 'contact_page', $page_id);
		if (empty($contact)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'contact_page',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Insert into Contact page

			$this->db->insert('setting', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Update into Contact page

			$this->db->where(array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'contact_page'
			));
			return $this->db->update('setting', $update_data);
		endif;
	}
}