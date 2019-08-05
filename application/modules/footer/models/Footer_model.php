<?php
/**
 * Footer Model
 * Created at : 09-June-2018
 * Author : Athi
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Footer_model extends CI_Model
{
	private $table_contact_info = "contact_information";
	private $table_social_media = "social_media";
	private $table_events = "event";
	private $table_blog = "blog";

	// Get Websites
	public function get_websites($website_id)
	{
		$this->db->select(array('logo', 'website_name', 'website_url'));
    	$this->db->where('id', $website_id);
    	$query = $this->db->get('websites');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}
	
	// Get Menu
	public function get_menu($website_id)
	{
		$query = $this->db->query("
			SELECT
				a.id, a.title, a.url
			FROM
				".$this->db->dbprefix('pages')." a, ".$this->db->dbprefix('footer_menu_group')." b
			WHERE
				a.id = b.page_id
			AND
				b.website_id = ".$website_id."
			AND
				b.parent_id = 0
			ORDER BY
				b.sort_order"
		);
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}

	// Get Sub Menu
	public function get_sub_menu($website_id, $menu_id)
	{
		$query = $this->db->query("
			SELECT
				a.title, a.url
			FROM
				".$this->db->dbprefix('pages')." a, ".$this->db->dbprefix('footer_menu_group')." b
			WHERE
				a.id = b.page_id
			AND
				b.website_id = ".$website_id."
			AND
				b.parent_id = ".$menu_id."
			ORDER BY
				b.sort_order"
		);
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}

	// Get Menu Customize
	public function get_menu_customize($website_id)
	{
		$this->db->select(array('key', 'value'));
    	$this->db->where(array('website_id' => $website_id, 'code' => 'footer-menu'));
    	$query = $this->db->get('setting');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}

	// Footer Contact info
	function get_footer_contact_information($code, $website_id)
	{
		if(in_array('phone_no', $code)) :
			$fetch_data[] = "phone_no";
			$fetch_data[] = "phone_icon";
			$fetch_data[] = "phone_icon_color";
			$fetch_data[] = "phone_icon_hover_color";
		endif;

		if(in_array('email', $code)) :
			$fetch_data[] = "email";
			$fetch_data[] = "email_icon";
			$fetch_data[] = "email_icon_color";
			$fetch_data[] = "email_icon_hover_color";
		endif;

		if(in_array('address', $code)) :
			$fetch_data[] = "address";
			$fetch_data[] = "address_icon";
			$fetch_data[] = "address_icon_color";
			$fetch_data[] = "address_icon_hover_color";
		endif;

		$this->db->select($fetch_data);
		$this->db->where(array(
			'website_id' => $website_id,
			'status' => '1'
		));
		$query = $this->db->get($this->table_contact_info);

		$records = array();
		if($query->num_rows() > 0) :
			$records = $query->result();
		endif;
		return $records;
	}

	function get_footer_social_media($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'status' => '1',
			'is_deleted' => '0'
		));
		$this->db->order_by('sort_order', 'ASC');
		$query = $this->db->get($this->table_social_media);

		$records = array();
		if($query->num_rows() > 0) :
			$records = $query->result();
		endif;
		return $records;
	}
	
	
	
	function get_event_details($website_id, $event_id)
	{
		//$this->db->select(array('logo', 'website_name', 'website_url'));
    	$this->db->where(array('website_id' =>$website_id,'status' => '1','is_deleted' => '0','id' => $event_id));
		
    	$query = $this->db->get($this->table_events);
    	$records = array();
		if ($query->num_rows() > 0) :
			$records = $query->result();
    	endif;
    	return $records;
	}
	
	function get_blog_details($website_id,$blog_id)
	{
    	$this->db->where(array('website_id' =>$website_id,'status' => '1','is_deleted' => '0','id'=>$blog_id  ));
    	$query = $this->db->get($this->table_blog);
    	$records = array();
		if ($query->num_rows() > 0) :
			$records = $query->result();      		
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
	// Get Footer Social Feed
	function get_social_feed()
	{
		$this->db->select(array('media_feed_text'));
    	$this->db->where(array('status' => '1'));
    	$query = $this->db->get('social_media_feed');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}
}
