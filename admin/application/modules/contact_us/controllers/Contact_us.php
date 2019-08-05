<?php
/**
 * Contact Us
 *
 * @category class
 * @package  Contact Us
 * @author   Athi
 * Created at:  20-Jun-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact_us extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Contact_us_model');
		$this->load->module('admin_header');
		$this->load->module('color');
		$this->load->dbforge();
	}

	// View Contact Form Field

	function index()
	{
		$data['website_id'] = $this->session->userdata('website_id');

		/**
		 * Get Contact us form 
		 * if form is not present redirect to contact customization 
		 */
		$contact_forms = $this->Contact_us_model->get_contact_form($data['website_id']);
		if (empty($contact_forms) || $contact_forms[0]->contact_customize == '' || $contact_forms[0]->contact_form_field == '')
		{
			redirect('contact_us/contact_customize');
		}

		$data['contact_form_fields'] = $this->Contact_us_model->get_contact_form_field($data['website_id']);
	
		$choose_field = json_decode($data['contact_form_fields'][0]->contact_form_field);
		$data['contact_choose_fields'] = $choose_field->label_name;
		$data['contact_enable_fields'] = $this->Contact_us_model->get_enable_label_name($data['website_id']);

		$is_show = json_decode($data['contact_form_fields'][0]->is_show);

		if(!empty($is_show)) :
			$data['is_show'] = $is_show;
		else :
			$data['is_show'] = array();
		endif;

		
		$data['table'] = $this->get_table();
		$data['heading'] = 'Contact Us';
		$data['title'] = "Contact Us | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_us_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table

	function get_table()
	{
		$website_id = $this->session->userdata('website_id');
		$contact_uss = $this->Contact_us_model->get_contact($website_id);
		$contact_form_fields = $this->Contact_us_model->get_contact_form_field($website_id);
		$contact_form_enable_fields = $this->Contact_us_model->get_enable_label_name($website_id);
		$choose_fields = (!empty($contact_form_fields) && $contact_form_fields[0]->is_show != '') ? json_decode($contact_form_fields[0]->is_show): array();

		if (!empty($contact_uss) && !empty($choose_fields))
		{
			foreach($contact_uss as $contact_us)
			{
				$contact_names = json_decode($contact_us->key);
				$contact_values = json_decode($contact_us->value);
			
				$anchor_edit = anchor('contact_us/edit_contact_us/' . $contact_us->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', 
				array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_delete = anchor(
					'',
					'<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>',
					array(
						'data-toggle'         => 'tooltip',
						'data-placement'      => 'right',
						'data-original-title' => 'Delete',
						'onclick' => 'return delete_record('.$contact_us->id.', \''.base_url('contact_us/delete_contact_us').'\')'
					)
				);
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . $anchor_delete
				);
				
				$tbl_record = array(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $contact_us->id . '">'
				);
				
				$i = 0;
				foreach($contact_names as $contact_name)
				{
					if(in_array($contact_names[$i], $choose_fields) && in_array($contact_names[$i], $contact_form_enable_fields))
					{
						$tbl_record[] = (count($contact_values) > $i) ? $contact_values[$i]: '';
					}
					$i++;
				}
				$tbl_record[] = $contact_us->created_at;
				$tbl_record[] = $cell;

				$this->table->add_row($tbl_record);
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
		$tbl_field = array(
			'<input type="checkbox" id="check-all" class="flat">'
		);
		
		if (!empty($choose_fields)) 
		{
			if(!empty($contact_form_fields) && $contact_form_fields[0]->contact_form_field != '')
			{
				$field_names = json_decode($contact_form_fields[0]->contact_form_field);

				foreach($field_names->label_name as $label_name)
				{
					if(in_array($label_name, $choose_fields) && in_array($label_name, $contact_form_enable_fields))
					{
						$tbl_field[] = $label_name;
					}
				}
			}
		}
		
		$tbl_field[] = 'Created Date';
		$tbl_field[] = 'Action';
		
		// Table heading row
		$this->table->set_heading($tbl_field);
		return $this->table->generate();
	}

	// Contact Us Page

	function contact_page($page_id)
	{
		$data['website_id'] = $this->session->userdata('website_id');
		
		$contact_us = $this->Contact_us_model->get_contact_setting($data['website_id'], 'contact_page', $page_id);
		if (!empty($contact_us))
		{
			$keys = json_decode($contact_us[0]->key);
			$values = json_decode($contact_us[0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['contact_us'] 	= '';
			$data['contact_info_page']	= '';
			
		}
		
		$data['page_id'] = $page_id;
		$data['heading'] = 'Contact Us Pages';
		$data['title'] = "Contact Us Pages | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_us_header');
		$this->admin_header->index();
		$this->load->view('contact_page', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert Update Contact Page

	function insert_update_contact_page()
	{
		$website_id = $this->input->post('website_id');
		$page_id = $this->input->post('page_id');
		$continue = $this->input->post('btn_continue');
		$this->Contact_us_model->insert_update_contact_page($website_id, $page_id);
		if (isset($continue) && ($continue === "Save & Continue"))
		{
			$url = 'contact_us/contact_page/' . $page_id;
		}
		else
		{
			$url = 'page/page_details/' . $page_id;
		}

		$this->session->set_flashdata('success', 'Contact Page Successfully Updated.');
		redirect($url);
	}

	// Edit Contact Us

	function edit_contact_us($id)
	{
		$data['id'] = $id;
		$data['website_id'] = $this->session->userdata('website_id');
		$data['contact_form_label_names'] = $this->Contact_us_model->get_contact_form_label_name($data['website_id']);
		$data['contact_form_enable_label_names'] = $this->Contact_us_model->get_enable_label_name($data['website_id']);
		$data['contact_form_choose_fields'] = $this->Contact_us_model->get_contact_form_choose_field($data['website_id']);
		$data['contact_form_requireds'] = $this->Contact_us_model->get_contact_form_required($data['website_id']);
		$data['single_contact_us'] = $this->Contact_us_model->get_single_contact_us($id);
		
		$data['heading']  		 = 'Contact Us';
		$data['title']		   = "Contact Us | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_us_header');
		$this->admin_header->index();
		$this->load->view('edit_contact_us', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Update Contact Us
	function update_contact_us()
	{
		$id = $this->input->post('id');
		$website_id = $this->input->post('website_id');
		$continue = $this->input->post('btn_continue');
		
		$this->Contact_us_model->update_contact_us($id, $website_id);
		$this->session->set_flashdata('success', 'Contact Us Successfully Updated.');
		if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
		{
			$url = 'contact_us/edit_contact_us/'.$id;
		}
		else
		{
			$url = 'contact_us';
		}
		redirect($url);
	}

	// Delete Contact Us
	function delete_contact_us()
	{
		$website_id = $this->session->userdata('website_id');
		$contact_forms = $this->Contact_us_model->contact_form($website_id);
		$this->Contact_us_model->delete_contact_us();
		$this->session->set_flashdata('success', 'Successfully Deleted');
		redirect('contact_us');
		
	}

	// Delete Multiple Contact Us
	function delete_multiple_contact_us()
	{
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('contact_us');
		}
		else
		{
			$this->Contact_us_model->delete_multiple_contact_us();
		
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('contact_us');
		}
	}

	// Contact Layout

	function contact_layout($page_id)
	{
		$data['website_id'] = $this->session->userdata('website_id');

		$contact_forms = $this->Contact_us_model->contact_form($data['website_id'], 'contact_page', $page_id);
		$contact_page_layout = $this->Contact_us_model->contact_form($data['website_id'], 'contact_page_layout', $page_id);
		if (!empty($contact_forms))
		{
			
			$keys = json_decode($contact_forms[0]->key);
			$values = json_decode($contact_forms[0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['contact_us'] 	= '';
			$data['contact_info_page']	= '';
		}

		if(!empty($contact_page_layout)) :
			$keys = json_decode($contact_page_layout[0]->key);
			$values = json_decode($contact_page_layout[0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		else:
			$data['contact_row'] = '';
			$data['contact_column'] = '';
		endif;
		
		$data['heading'] = 'Contact Layout';
		$data['title'] = "Contact Layout | Administrator";
		$data['page_id'] = $page_id;
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_us_header');
		$this->admin_header->index();
		$this->load->view('contact_layout', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Update Contact Layout

	function update_contact_layout()
	{
		$website_id = $this->session->userdata('website_id');
		$page_id = $this->input->post('page_id');
		$row = $this->input->post('row');
		$row_column_no = $this->input->post('row_column_no');
		$rcs = 1;
		$row_column_nos = array();
		for ($rc = 0; $rc < count($row_column_no); $rc++)
		{
			if (!empty($row_column_no[$rc]))
			{
				$row_column_now = explode("-", $row_column_no[$rc]);
				$row_column_nos[] = $rcs . 'r-' . $row_column_now[1];
				$rcs++;
			}
		}

		$row_column_nos = (!empty($row_column_nos)) ? implode('/', $row_column_nos) : '';
		$this->Contact_us_model->update_contact_layout($website_id, $page_id, $row, $row_column_nos);
		$this->session->set_flashdata('success', ' Successfully Updated');
		redirect('contact_us/contact_layout/'.$page_id);
	}





	// Remove Form Field

	function contact_form_field_remove()
	{
		$website_id = $this->session->userdata('website_id');
		$remove_id = $this->input->post('remove_id');
		$this->Contact_us_model->contact_form_field_remove($website_id, $remove_id);
		$this->session->set_flashdata('success', ' Successfully Deleted');
	}


	// Edit Form Field

	function edit_form_field($field_id)
	{
		$data['store_id'] = $this->session->userdata('website_id');
		$contact_form_fields = $this->Contact_us_model->contact_form_field($data['website_id'], $field_id);
		if (!empty($contact_form_fields))
		{
			foreach($contact_form_fields as $contact_form_field)
			{
				$data['id'] = $contact_form_field->id;
				$data['label_name'] = $contact_form_field->label_name;
				$data['field_type'] = $contact_form_field->field;
				$data['field_attributes'] = $contact_form_field->field_attributes;
				$data['placeholder'] = $contact_form_field->placeholder;
				$data['validation'] = $contact_form_field->validation;
				$data['required'] = $contact_form_field->required;
				$data['icon'] = $contact_form_field->icon;
			}
		}
		else
		{
			$data['id'] = '';
			$data['label_name'] = '';
			$data['field_type'] = '';
			$data['field_attributes'] = '';
			$data['placeholder'] = '';
			$data['validation'] = '';
			$data['required'] = '';
			$data['icon'] = '';
		}

		$data['heading'] = 'Contact Form Field';
		$data['title'] = "Contact Form Field | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_us_header');
		$this->admin_header->index();
		$this->load->view('contact_form_field', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Update Form Field

	function update_form_field()
	{
		$data['website_id'] = $this->session->userdata('website_id');
		$field_id = $this->input->post('id');
		$field_type = $this->input->post('field_type');
		$old_label_name = $this->input->post('old_label_name');
		$label_name = $this->input->post('label_name');
		$placeholder = $this->input->post('placeholder');
		$validation = $this->input->post('validation');
		$required = $this->input->post('required');
		$icon = $this->input->post('icon');
		$continue = $this->input->post('btn_continue');
		if ($field_id != '')
		{
			if ($field_type == 'dropdown')
			{
				$options = $this->input->post('options');
				$field_attributes = ($options != "") ? implode(",", $options) : '';
			}
			elseif ($field_type == 'checkbox')
			{
				$chk_options = $this->input->post('chk_options');
				$field_attributes = ($chk_options != "") ? implode(",", $chk_options) : '';
			}
			elseif ($field_type == 'radio')
			{
				$radio_option = $this->input->post('radio_options');
				$field_attributes = ($radio_option != "") ? implode(",", $radio_option) : '';
			}
			else
			{
				$field_attributes = '';
			}

			$this->Contact_us_model->update_form_field($data['website_id'], $field_id, $label_name, $field_attributes, $placeholder, $validation, $required, $icon);
		}

		$contact_forms = $this->Contact_us_model->get_contact_form($data['website_id'], $field_id);
		if (!empty($contact_forms))
		{
			$tablefield = $this->db->list_fields($contact_forms[0]->tbl_name);
			if (in_array($old_label_name, $tablefield))
			{
				$character_out = array(
					'& ',
					' '
				);
				$character_in = array(
					'',
					'_'
				);
				$label_name = str_replace($character_out, $character_in, $label_name);
				if ($field_type == 'textarea')
				{
					$fields = array(
						$old_label_name => array(
							'name' => strtolower($label_name) ,
							'type' => 'TEXT',
							'default' => NULL
						)
					);
				}
				else
				{
					$fields = array(
						$old_label_name => array(
							'name' => strtolower($label_name) ,
							'type' => 'VARCHAR',
							'constraint' => 255,
							'default' => NULL
						)
					);
				}

				$this->dbforge->modify_column($contact_forms[0]->tbl_name, $fields);
			}
		}

		if (isset($continue) && $continue === "Update & Continue")
		{
			$url = 'contact_us/edit_form_field/' . $field_id;
		}
		else
		{
			$url = 'contact_us/form_layout';
		}

		redirect($url);
	}

	// Number To Alphabet for Table Name

	function NumtoAlpha($data)
	{
		$alphabet = array(
			'a',
			'b',
			'c',
			'd',
			'e',
			's',
			'm',
			'h',
			'i',
			'n',
		);
		$return_value = '';
		$length = strlen($data);
		for ($i = 0; $i < $length; $i++)
		{
			$return_value.= $alphabet[$data[$i]];
		}

		return $return_value;
	}


	// Contact Form Field

	function contact_form_field()
	{
		$data['website_id'] = $this->admin_header->website_id();
		
		$data['contact_form_fields'] = $this->Contact_us_model->get_contact_form_field_details($data['website_id']);
		if (!empty($data['contact_form_fields']) && $data['contact_form_fields'][0]->contact_form_field != '')
		{
			$data['contact_us_form'] = json_decode($data['contact_form_fields'][0]->contact_form_field);
			
			foreach($data['contact_us_form'] as $key => $val)
			{
				$data[$key] = $val;
			}
		}
		else
		{
			$data['id']	= "";
			$data['label_name'] = "";
			$data['is_deleted'] = "";
			$data['choosefield'] = "";
			$data['field_attributes'] = "";
			$data['icon'] = "";
			$data['placeholder'] = "";
			$data['sort_order'] = "";
			$data['validation'] = "";
			$data['required'] = "";
		}

		$data['heading'] = 'Contact Form Field';
		$data['title'] = "Contact Form Field | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_us_header');
		$this->admin_header->index();
		$this->load->view('add_edit_contact_form_field', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}


	// Insert & Update Contact Form Field

	function insert_update_contact_form_field()
	{
	 $continue = $this->input->post('btn_continue');
	 $website_id = $this->admin_header->website_id();

		$this->Contact_us_model->insert_update_contact_form_field($website_id);
		$this->session->set_flashdata('success', ' Successfully Added');

		if (isset($continue) && ($continue === "Update & Continue" || $continue === "Save & Continue"))
		{
			$url = 'contact_us/contact_form_field';
		}
		else
		{
			$url = 'contact_us';
		}

		redirect($url);
	}
	
	// Remove Contact Field

	function contact_field_remove()
	{
		$website_id = $this->input->post('website_id');
		$remove_name = $this->input->post('remove_name');
		$this->Contact_us_model->contact_field_remove($website_id, $remove_name);
		$this->session->set_flashdata('success', ' Successfully Deleted');
	}

	// Mail Configure

	function mail_configure()
	{
		$data['website_id'] = $this->session->userdata('website_id');
		
		$contact_mail_configure = $this->Contact_us_model->get_contact_mail_form_field($data['website_id']);
		if (!empty($contact_mail_configure) && $contact_mail_configure[0]->contact_form_field != '' && $contact_mail_configure[0]->contact_mail_config != '')
		{
			$data['contact_form_fields'] = json_decode($contact_mail_configure[0]->contact_form_field);
			$data['contact_form_enable_fields'] = $this->Contact_us_model->get_enable_label_name($data['website_id']);
			
			$contact_mail_config = json_decode($contact_mail_configure[0]->contact_mail_config);
			foreach($contact_mail_config as $key => $val)
			{
				$data[$key] = $val;
			}
			
			$data['contact_mail_form_fields'] = $data['contact_form_fields']->label_name;
			$data['label_check'] = ($data['label_check'] != '') ? explode(',', $data['label_check']): array();
		}
		elseif(!empty($contact_mail_configure) && $contact_mail_configure[0]->contact_form_field != '')
		{
			$data['contact_form_fields'] = json_decode($contact_mail_configure[0]->contact_form_field);
			$data['contact_mail_form_fields'] = $data['contact_form_fields']->label_name;
			$data['contact_form_enable_fields'] = $this->Contact_us_model->get_enable_label_name($data['website_id']);
			
			$data['mail_subject'] = '';
			$data['from_name'] = '';
			$data['message_content'] = '';
			$data['success_title'] = '';
			$data['success_message'] = '';
			$data['send_mail_to'] = '';
			$data['to_address'] = '';
			$data['ccid'] = '';
			$data['bccid'] = '';
			$data['label_check'] = array();
			$data['sort_label_name'] = '';
			$data['status'] = '';
		}
		else
		{
			$data['contact_form_fields'] = array();
			$data['contact_mail_form_fields'] = array();
			$data['contact_form_enable_fields'] = array();
			$data['mail_subject'] = '';
			$data['from_name'] = '';
			$data['message_content'] = '';
			$data['success_title'] = '';
			$data['success_message'] = '';
			$data['send_mail_to'] = '';
			$data['to_address'] = '';
			$data['ccid'] = '';
			$data['bccid'] = '';
			$data['label_check'] = array();
			$data['sort_label_name'] = '';
			$data['status'] = '';
		}

		$data['heading'] = 'Contact Mail Configure';
		$data['title'] = "Contact Mail Configure | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_us_header');
		$this->admin_header->index();
		$this->load->view('contact_mail_configure', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	function insert_update_contact_mail_configure()
	{
		$id = $this->input->post('id');
		$website_id = $this->input->post('website_id');
		$continue = $this->input->post('btn_continue');
		if (empty($id))
		{
			$insert_id = $this->Contact_us_model->insert_update_contact_mail_configure($website_id);
			$this->session->set_flashdata('success', 'Mail Configure successfully Created');
			if (isset($continue) && $continue === "Save & Continue")
			{
				$url = 'contact_us/mail_configure';
			}
			else
			{
				$url = 'contact_us/contact_form_field';
			}
		}
		else
		{
			$this->Contact_us_model->insert_update_contact_mail_configure($website_id, $id);
			$this->session->set_flashdata('success', 'Mail Configure Successfully Updated.');
			if (isset($continue) && $continue === "Update & Continue")
			{
				$url = 'contact_us/mail_configure';
			}
			else
			{
				$url = 'contact_us/contact_form_field';
			}
		}

		redirect($url);
	}


	// Contact Customize

	function contact_customize()
	{
		$website_id = $this->admin_header->website_id();
		$data['contact_form'] = $this->Contact_us_model->get_contact_form($website_id);
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		if (!empty($data['contact_form']))
		{
			$keys = json_decode($data['contact_form'][0]->contact_customize);
			//$i = 0;
		    foreach($keys as $key=>$value)
			{
				$data[$key]= $value;
			//	$i++;

			}
		}
		else
		{
			$data['form_title'] = '';
			$data['title_color'] = '';
			$data['title_position'] = '';
			$data['label_color'] = '';
			$data['captcha'] = '';
			$data['choose_captcha'] = '';
			$data['google_site_key'] = '';
			$data['google_secret_key'] = '';
			$data['image_captcha_height'] = '';
			$data['image_captcha_width'] = '';
			$data['image_captcha_word_length'] = '';
			$data['image_captcha_font_size'] = '';
			$data['button_label'] = '';
			$data['button_type'] = '';
			$data['button_label_color'] = '';
			$data['hover_label_color'] = '';
			$data['button_background_color'] = '';
			$data['hover_background_color'] = '';
			$data['border'] = '';
			$data['border_size'] = '';
			$data['border_color'] = '';
			$data['component_background'] = '';
			$data['contact_us_background'] = '';
			$data['status'] = '';
		}

		$data['heading'] = 'Contact Us Customize';
		$data['title'] = "Contact Us Customize | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_us_header');
		$this->admin_header->index();
		$this->load->view('contact_customize', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert Update Contact Customize

	function insert_update_contact_customize()
	{
	    $website_id = $this->admin_header->website_id();
        $continue = $this->input->post('btn_continue');
		$error_config = array(
			array(
				'field' => 'form_title',
				'label' => 'Form Title',
				'rules' => 'required'
			) ,
			array(
				'field' => 'button_label',
				'label' => 'Button Label',
				'rules' => 'required'
			) ,
		);
		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('contact_us/contact_customize');
		}
		else
		{
			$insert_id = $this->Contact_us_model->insert_update_contact_customize($website_id);
			$this->session->set_flashdata('success', 'Contact Us successfully Created');
			if (isset($continue) && $continue === "Save & Continue")
			{
				$url = 'contact_us/contact_customize';
			}
			else
			{
				$url = 'contact_us';
			}

			redirect($url);
		}
	}


	// Update Choose Field

	function update_choose_field()
	{
		$website_id = $this->input->post('website_id');
		$this->Contact_us_model->update_choose_field($website_id);
		$this->session->set_flashdata('success', 'Successfully Selected');
		redirect('contact_us');
	}
    // Form Layout

	function form_layout()
	{
		$data['website_id'] = $this->session->userdata('website_id');
		$data['contact_form_fields'] = $this->Contact_us_model->get_contact_form_field($data['website_id']);
		if(!empty($data['contact_form_fields']) && $data['contact_form_fields'][0]->contact_form_field != '' && $data['contact_form_fields'][0]->contact_form_layout != '')
		{
			$contact_choose_field = json_decode($data['contact_form_fields'][0]->contact_form_field);
			$contact_form = json_decode($data['contact_form_fields'][0]->contact_form_layout);
			$data['contact_label_names'] = $contact_choose_field->label_name;
			$data['contact_enable_label_names'] = $this->Contact_us_model->get_enable_label_name($data['website_id']);
			$data['contact_row'] = $contact_form->row;
			$data['contact_columns'] = $contact_form->column;
		}
		elseif(!empty($data['contact_form_fields']) && $data['contact_form_fields'][0]->contact_form_field != '' && $data['contact_form_fields'][0]->contact_form_layout == '')
		{
			$contact_choose_field = json_decode($data['contact_form_fields'][0]->contact_form_field);
			$data['contact_label_names'] = $contact_choose_field->label_name;
			$data['contact_enable_label_names'] = $this->Contact_us_model->get_enable_label_name($data['website_id']);
			$data['contact_row'] = '';
			$data['contact_columns'] = '';
		}
		else
		{
			$data['contact_label_names'] = '';
			$data['contact_enable_label_names'] = array();
			$data['contact_row'] = '';
			$data['contact_columns'] = '';
		}

		$data['heading'] = 'Contact Form Layout';
		$data['title'] = "Contact Form Layout | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('contact_us_header');
		$this->admin_header->index();
		$this->load->view('contact_form_layout', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert Update Contact Form Layout

	function insert_update_contact_form_layout()
	{
		$website_id = $this->session->userdata('website_id');
		$row = $this->input->post('row');
		$row_column_no = $this->input->post('row_column_no');
		$rcs = 1;
		$row_column_nos = array();
		for ($rc = 0; $rc < count($row_column_no); $rc++)
		{
			if ($row_column_no[$rc] != '')
			{
				
				$row_column_now = explode("-", $row_column_no[$rc]);
				$row_column_nos[] = $rcs . 'r-' . $row_column_now[1];
				$rcs++;
			}
		}
		$row_column_nos = (!empty($row_column_nos)) ? implode('/', $row_column_nos) : '';
		$this->Contact_us_model->update_contact_form_layout($website_id, $row, $row_column_nos);
		$this->session->set_flashdata('success', ' Successfully Updated');
		redirect('contact_us/form_layout');
	}

}
