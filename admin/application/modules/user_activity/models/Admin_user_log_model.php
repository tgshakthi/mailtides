<?php
/**
 * Admin User Log model
 * @category class
 * @package  User Log Model
 * @author   Shiva
 * Created at:  14-May-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_user_log_model extends CI_Model
{
	/**
   * Get Admin User & Log  & Role details
   * return output as stdClass Object array
   */
	
function get_user_log_role_details()
	{
		$data_qry = "SELECT a.id, a.email,a.first_name,a.last_name,a.user_image, b.user_role_name,GROUP_CONCAT(c.website_name) as website_name,GROUP_CONCAT(c.website_url) as website_url FROM cms_admin_user a, cms_admin_user_role b, cms_websites c WHERE a.is_deleted = 0 AND FIND_IN_SET(c.id, a.website_id) AND a.user_role_id = b.user_role_id GROUP BY a.id";
		$query = $this->db->query($data_qry);
		$records = array();
		if ($query->num_rows() > 0) :
		  foreach ($query->result() as $row) :
			$records[] = $row;
			endforeach;
			endif;
			return $records;
	}

	
/**
   * Get Admin User & Log  search bar details
   * return output as stdClass Object array
   */
	
function get_user_search_details($searchval)
	{
		$qry_data_search = "SELECT a.id, a.email,a.first_name,a.last_name,a.user_image, b.user_role_name,GROUP_CONCAT(c.website_name) as website_name,GROUP_CONCAT(c.website_url) as website_url FROM cms_admin_user a, cms_admin_user_role b, cms_websites c WHERE a.is_deleted = 0 AND  a.first_name LIKE '%".$searchval."%' AND FIND_IN_SET(c.id, a.website_id) AND a.user_role_id = b.user_role_id GROUP BY a.id"; 
		$query = $this->db->query($qry_data_search);
		$records = array();
		if ($query->num_rows() > 0) :
		  foreach ($query->result() as $row) :
			$records[] = $row;
			endforeach;
			endif;
			return $records;
	}
	
function get_user_search_alpha_details($searchval)
	{
	
	 	$qry_data_search = "SELECT a.id, a.email,a.first_name,a.last_name,a.user_image, b.user_role_name,GROUP_CONCAT(c.website_name) as website_name,GROUP_CONCAT(c.website_url) as website_url FROM cms_admin_user a, cms_admin_user_role b, cms_websites c WHERE a.is_deleted = 0 AND a.first_name LIKE '".$searchval."%' AND FIND_IN_SET(c.id, a.website_id) AND a.user_role_id = b.user_role_id GROUP BY a.id"; 
		$query = $this->db->query($qry_data_search);
		$records = array();
		if ($query->num_rows() > 0) :
		  foreach ($query->result() as $row) :
			$records[] = $row;
			endforeach;
			endif;
			return $records;
	}
		
	
/**
   * Get CMS page count
   * return output as stdClass Object array
   */

	function cms_page_count()
	{
		$qry_data_search = "SELECT COUNT(*) as cms_page_count FROM cms_admin_user;";
		$query = $this->db->query($qry_data_search);
		$records = array();
		if ($query->num_rows() > 0) :
		  foreach ($query->result() as $row) :
			$records[] = $row;
			endforeach;
			endif;
			return $records;
	}

	
/**
   * Get Admin user Role details
   * return output as stdClass Object array
   */

	function get_admin_user_role_details($user_role_log_id)
	{
		$this->db->select('*');
		$this->db->where(array('user_role_id' => $user_role_log_id));
		$this->db->order_by('user_role_id', 'asc');
		$query = $this->db->get('cms_admin_user_role');
		$records = array();

		if ($query->num_rows() > 0) :
			foreach ($query->result() as $row) :
				$records[] = $row;
			endforeach;
		endif;

		return $records;
	}


}
