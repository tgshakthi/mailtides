<?php
/**
 * Header Model
 * Created at : 07-June-2018
 * Author : Athi
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Header_model extends CI_Model
{
	private $table_name = "header";
	private $table_top_header = "top_header";
	private $table_contact_info = "contact_information";
	private $table_social_media = "social_media";
	private $table_google_analytics = "analytics";
	private $table_website = "websites";
	private $table_menu = "menu";
	private $table_page = "pages";
	private $table_seo = "seo";
	private $table_setting = "setting";

	// Get Websites
	function get_websites($website_id)
	{
		$this->db->select(array('logo', 'website_name', 'website_url'));
    	$this->db->where('id', $website_id);
    	$query = $this->db->get($this->table_website);
    	$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	}

	// Get Top heade Components
	function get_top_header_components($website_id) 
	{
		$this->db->select(array("$this->table_top_header.id", "$this->table_top_header.name"));
		$this->db->from($this->table_top_header);
		$this->db->join($this->table_website, 'FIND_IN_SET(' . $this->db->dbprefix($this->table_top_header) . '.id, ' . $this->db->dbprefix($this->table_website) . '.top_header_components) > 0');
		$this->db->where("$this->table_website.id", $website_id);
		$query = $this->db->get();
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	}

	// Get Top Header Contact Information
	function get_top_header_contact_information($code, $website_id)
	{
		if(in_array('phone_no', $code)) :
			$fetch_data[] = "phone_no";
			$fetch_data[] = "phone_no_title_color";
			$fetch_data[] = "phone_title_hover_color";
			$fetch_data[] = "phone_icon";
			$fetch_data[] = "phone_icon_color";
			$fetch_data[] = "phone_icon_hover_color";
		endif;

		if(in_array('email', $code)) :
			$fetch_data[] = "email";
			$fetch_data[] = "email_title_color";
			$fetch_data[] = "email_title_hover_color";
			$fetch_data[] = "email_icon";
			$fetch_data[] = "email_icon_color";
			$fetch_data[] = "email_icon_hover_color";
		endif;

		if(in_array('address', $code)) :
			$fetch_data[] = "address";
			$fetch_data[] = "address_title_color";
			$fetch_data[] = "address_title_hover_color";
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

	// Get Top header social media info
	function get_top_header_social_media($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'status' => '1',
			'is_deleted' => '0'
		));
		$this->db->order_by('sort_order', 'asc');
		$query = $this->db->get($this->table_social_media);
		$records = array();
		if($query->num_rows() > 0) :
			$records = $query->result();
		endif;
		return $records;
	}

	// Get Logo
	function get_logo($website_id)
	{
		$this->db->select(array('key', 'value'));
    	$this->db->where(array('website_id' => $website_id, 'code' => 'logo'));
    	$query = $this->db->get($this->table_setting);
    	$records = array();
		if($query->num_rows() > 0) :
			$records = $query->result();
		endif;
		return $records;
	}

	// Get meta data
	function get_meta_data($page_id)
	{
		$this->db->select(array('meta_title', 'meta_description', 'meta_keyword', 'meta_misc'));
		$this->db->where('page_id', $page_id);
		$query = $this->db->get($this->table_seo);
    	$records = array();
		if($query->num_rows() > 0) :
			$records = $query->result();
		endif;
		return $records;
	}

	// Get Blog meta data
	function get_blog_meta_data($website_id, $page_url)
	{
		$this->db->select(array('meta_title', 'meta_description', 'meta_keyword'));
		$this->db->where(array('website_id' => $website_id, 'blog_url' => $page_url));
		$query = $this->db->get('blog');
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	}

	function get_menu($website_id) {
		$this->db->select('menu');
		$this->db->where('website_id', $website_id);
		$query = $this->db->get($this->table_menu);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	}

	function get_parent_menu($website_id, $id) {
		$this->db->select(array('title', 'url'));
		$this->db->where(array(
			'website_id' => $website_id,
			'id' => $id
		));
		$query = $this->db->get($this->table_page);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	}

	/**
	 * Google Analytics
	 */

	 function google_analytics($website_id)
	 {
		 $this->db->select('analytic_code');
		 $this->db->where(
			 array(
				 'website_id' => $website_id,
				 'status' => '1'
			 )
		 );
		 $query = $this->db->get($this->table_google_analytics);
		 $records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();			
		endif;
		return $records;
	 }
}
