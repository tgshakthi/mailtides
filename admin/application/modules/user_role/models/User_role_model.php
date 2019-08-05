<?php
/**
 * Admin User Role Models
 *
 * @category Model
 * @package  Admin User Role
 * @author   Saravana
 * Created at:  09-Apr-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_role_model extends CI_Model
{
  /**
   * Get Admin User Roles
   * return output as stdClass Object array
   */

  function get_all_admin_user_roles()
  {
    $this->db->select(array('user_role_id', 'user_role_name', 'active'));
    $this->db->where_not_in('user_role_id', array('1'));
    $this->db->where('is_deleted', '0');
    $this->db->order_by('user_role_id', 'desc');
    $query = $this->db->get('admin_user_role');
    $records = array();

    if ($query->num_rows() > 0) :
      foreach ($query->result() as $row) :
        $records[] = $row;
      endforeach;
    endif;

    return $records;
  }

  // Get Admin user role by id
  function get_user_role_by_id($id)
  {
    $this->db->select('*');
    $this->db->where(array('user_role_id' => $id, 'is_deleted' => '0'));
    $query = $this->db->get('admin_user_role');
    $records = array();

    if ($query->num_rows() > 0) :
      foreach ($query->result() as $row) :
        $records[] = $row;
      endforeach;
    endif;

    return $records;
  }

  //Inser Update User Role
  function insert_update_user_role_data($id = NULL)
  {
    $user_role_view     = $this->input->post('user-role-view');
    $user_role_add      = $this->input->post('user-role-add');
    $user_role_edit     = $this->input->post('user-role-edit');
    $user_role_delete   = $this->input->post('user-role-delete');
    $user_role_publish  = $this->input->post('user-role-publish');
    $user_role_status   = $this->input->post('user-role-status');

    $user_role_view     = (isset($user_role_view)) ? '1' : '0';
    $user_role_add      = (isset($user_role_add)) ? '1' : '0';
    $user_role_edit     = (isset($user_role_edit)) ? '1' : '0';
    $user_role_delete   = (isset($user_role_delete)) ? '1' : '0';
    $user_role_publish  = (isset($user_role_publish)) ? '1' : '0';
    $user_role_status   = (isset($user_role_status)) ? '1' : '0';

    if ($id == NULL) :

      // insert data
  		$insert_data = array(
  			'user_role_name'  => $this->input->post('user-role-name'),
  			'user_role'  		  => $this->input->post('user-role'),
  			'add'   		      => $user_role_add,
  			'edit'   		      => $user_role_edit,
  			'view'      		  => $user_role_view,
  			'delete'     		  => $user_role_delete,
  			'publish'         => $user_role_publish,
  			'active'          => $user_role_status,
  			'created_at' 		  => date('m-d-Y')
  		);

      // Insert into Admin user role
      return $this->db->insert('admin_user_role', $insert_data);

    else :

      // Update data
  		$update_data = array(
  			'user_role_name'  => $this->input->post('user-role-name'),
  			'user_role'  		  => $this->input->post('user-role'),
  			'add'   		      => $user_role_add,
  			'edit'   		      => $user_role_edit,
  			'view'      		  => $user_role_view,
  			'delete'     		  => $user_role_delete,
  			'publish'         => $user_role_publish,
  			'active'          => $user_role_status
  		);

      // Update into Admin User Role
			$this->db->where('user_role_id', $id);
			return $this->db->update('admin_user_role', $update_data);

    endif;
  }

  // Delete User Role
  function delete_user_role()
  {
		$id = $this->input->post('id');
    $data = array(
      'is_deleted' => '1'
    );
    $this->db->where('user_role_id', $id);
		return $this->db->update('admin_user_role', $data);
  }

  // Delete mulitple Admin user Role
  function delete_multiple_user_role()
  {
    $user_role_ids = $this->input->post('table_records');
    foreach ($user_role_ids as $user_role_id) :
      $data = array(
        'is_deleted' => '1'
      );
      $this->db->where('user_role_id', $user_role_id);
      $this->db->update('admin_user_role', $data);
    endforeach;
  }
}
