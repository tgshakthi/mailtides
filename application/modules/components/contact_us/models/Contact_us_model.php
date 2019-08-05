<?php
/**
 * Contact Us Model
 * Created at : 02-July-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contact_us_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/* Get Contact Us Data */
	function get_contact_form_field($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id
		));
		$query = $this->db->get('contact_form_field');
		$records = array();
		if ($query->num_rows() > 0):
				$records = $query->result();
		endif;
		return $records;
	}

	/* Get Separate Contact Us Data */
	function get_separate_contact_form_field($website_id, $form_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'id' => $form_id,
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
	
	// Get Contact Information

	function contact_information($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'status' => 1
		));
		$query = $this->db->get('contact_information');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get Contact Title Table

	function contact_form($website_id)
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
	
	// Get Contact Form Field

	function contact_form_field($website_id)
	{
		$records = array();
		$contact_forms = $this->contact_form($website_id);
		if(!empty($contact_forms) && $contact_forms[0]->contact_form_field != ''):
			
			$records = json_decode($contact_forms[0]->contact_form_field);
			
			return $records;
			
		endif;
		
	}
	
	// Get Contact Form Label Name

	function contact_form_label_name($website_id)
	{
		$records = array();
		$contact_form_fields = $this->contact_form_field($website_id);
		if(!empty($contact_form_fields)):
			
			$records = $contact_form_fields->label_name;
			
			return $records;
			
		endif;
		
	}
	
	/**
	 * Get Enable Label Name
	 */
	 
	function get_enable_label_name($website_id)
	{
		$records = array();
		$contact_form_fields = $this->contact_form_field($website_id);
 		if(!empty($contact_form_fields) && !empty($contact_form_fields->label_name) && !empty($contact_form_fields->is_deleted))
		{
			$i = 0;
			foreach($contact_form_fields->label_name as $label_name)
			{
				if($contact_form_fields->is_deleted[$i] == 0)
				{
					$records[] = $label_name;
				}
				$i++;
			}
		}
		return $records;
	}
	
	// Get Contact Form Choose Field

	function contact_form_choose_field($website_id)
	{
		$records = array();
		$contact_form_fields = $this->contact_form_field($website_id);
		if(!empty($contact_form_fields)):
			
			$records = $contact_form_fields->choosefield;
			
			return $records;
			
		endif;
		
	}
	
	// Get Contact Form Mail Configure

	function contact_form_mail_configure($website_id)
	{
		$records = array();
		$contact_forms = $this->contact_form($website_id);
		if(!empty($contact_forms) && $contact_forms[0]->contact_mail_config != ''):
			
			$records = json_decode($contact_forms[0]->contact_mail_config);
			
			return $records;
			
		endif;
		
	}

	// Insert Contact Us

	function insert_contact_us()
	{
		$website_id = $this->input->post('website_id');
		$contact_label_names = $this->contact_form_label_name($website_id);
		$contact_choose_fields = $this->contact_form_choose_field($website_id);
		
		$out = array(
			' '
		);
		$in = array(
			'_'
		);
		
		if(!empty($contact_label_names)):
		
			for($i = 0;$i < count($contact_label_names); $i++)
			{
				$form_label[] = $contact_label_names[$i];
				$label_name = str_replace($out, $in, $contact_label_names[$i]);
				if ($contact_choose_fields[$i] == 'textbox' || $contact_choose_fields[$i] == 'textarea' || $contact_choose_fields[$i] == 'datepicker' || $contact_choose_fields[$i] == 'radio' || $contact_choose_fields[$i] == 'dropdown')
				{
					$form_values[] = htmlspecialchars_decode(trim(htmlentities($this->input->post($label_name))));
				}
				else
				if ($contact_choose_fields[$i] == 'checkbox')
				{
					$form_values[] = implode(',', htmlspecialchars_decode(trim(htmlentities($this->input->post($label_name)))));
				}
			}
			
			$key = json_encode($form_label);
			$value = json_encode($form_values);
			
			$insert_data = array(
				'website_id' => $website_id,
				'key' => $key,
				'value' => $value,
				'created_at' => date('m-d-Y')
			);
			return $this->db->insert('contact_us', $insert_data);
		endif;
	}

	// Contact Mail Configure

	function contact_mail_configure($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id
		));
		$query = $this->db->get('contact_mail_configure');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get Mail Form Field

	function get_mail_form_field($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'mail_status' => 1
		));
		$this->db->order_by('mail_sort_order', 'ASC');
		$query = $this->db->get('contact_form_field');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get Contact Pages

	function get_contact_page($website_id, $page_id)
	{
		$this->db->select('code');
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

	// Get Contact Page layout

	function get_contact_page_layout($website_id, $page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'page_id' => $page_id,
			'code' => 'contact_page_layout'
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
	
	function get_contact_pages($website_id, $page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'page_id' => $page_id,
			'code' => 'contact_page'
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
}

?>
