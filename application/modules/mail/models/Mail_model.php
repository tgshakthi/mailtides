<?php
/**
 * Mail Model
 * Created at : 03-July-2018
 * Author : Athi
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mail_model extends CI_Model
{
	// Get Mail Configuration
	function get_mail_configuration($website_id)
	{
		$this->db->select('*');  
		$this->db->where('website_id', $website_id);  
    	$query = $this->db->get('mail_configuration');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
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
	
	// Get Register Form Mail Configure

	function register_form_mail_configure($website_id)
	{
		$records = array();
		// $contact_forms = $this->contact_form($website_id);
		// if(!empty($contact_forms) && $contact_forms[0]->contact_mail_config != ''):
			
			// $records = json_decode($contact_forms[0]->contact_mail_config);
			
			// return $records;
			
		// endif;
		
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id
		));
		$query = $this->db->get('register_mail_configure');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
		
		
	}
	
	//Mail form fieldss
	function get_register_mail_form_field($website_id)
	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id, 'mail_status' => 1));       
		$this->db->order_by('mail_sort_order', 'ASC');      
    	$query = $this->db->get('register_form_field');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}
	
	
	// Get Mail Form Field
	function get_mail_form_field($website_id)
	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id, 'mail_status' => 1));       
		$this->db->order_by('mail_sort_order', 'ASC');      
    	$query = $this->db->get('contact_form_field');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}
	
	// Rating Mail Configure
	function rating_mail_configure($website_id)
	{
		$this->db->select('*');    
    	$this->db->where(array('website_id' => $website_id));        
    	$query = $this->db->get('rating_mail_configure');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}
}
