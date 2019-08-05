<?php
/**
 * UserAuthentication Models
 *
 * @category Model
 * @package  UserAuthentication
 * @author   Saravana
 * Created at:  09-Mar-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');
class UserAuthentication extends CI_Model
{
  /**
   * Validate login information with database
   * @param username
   * @param password
   * if success returns result as array
   * if not return false
   */

  function login($username, $password)
  {
    $this->db->select(array('id', 'username', 'password', 'first_name', 'last_name'));
    $this->db->from('admin_user');
    $this->db->where(array('username' => $username,'password' => md5($password), 'is_deleted' => '0'));
		$this->db->limit(1);

    $query = $this->db->get();

    if ($query->num_rows() == 1) :
      return $query->result();
    else :
      return false;
    endif;
  }

  /**
   * Get Admin user Details
   * @param user_id
   * get user role using join
   * if success returns result as array
   * if not return false
   */
  function get_admin_user_details($id)
  {
    $this->db->select(array('id', 'first_name', 'last_name', 'user_role', 'user_image'));
    $this->db->join('admin_user_role', 'admin_user_role.user_role_id = admin_user.user_role_id');
    $this->db->where(array('id' => $id, 'admin_user.is_deleted' => '0'));
    $query = $this->db->get('admin_user');

    if ($query->num_rows() == 1) :
      return $query->result();
    else :
      return false;
    endif;
  }

  // Get website id from Admin user
  function getWebsit_id($id)
  {
    $this->db->select('website_id');
    $this->db->from('admin_user');
    $this->db->where(array('id' => $id, 'is_deleted' => '0'));
    $query = $this->db->get();

    if ($query->num_rows() == 1) :
      return $query->result();
    else :
      return false;
    endif;
  }

  // Get website details
  function get_websites($web_id)
  {
    $this->db->select(array('id', 'website_name', 'website_url'));
    $this->db->from('websites');
    $this->db->where(array('id' => $web_id, 'is_deleted' => '0'));
    $this->db->order_by('id', 'DESC');
    $query = $this->db->get();

    if ($query->num_rows() == 1) :
      return $query->result();
    else :
      return false;
    endif;
  }

}
