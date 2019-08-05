<?php
/**
 * Admin Menu Models
 *
 * @category Model
 * @package  Admin Menu
 * @author   Saravana
 * Created at:  09-Apr-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_menu_model extends CI_Model
{
  /**
   * Get Admin Menu
   * return output as stdClass Object array
   */

  function get_admin_menus()
  {
    $this->db->select(array('menu_id', 'menu_name', 'menu_icon', 'status'));
    $this->db->order_by('menu_id', 'desc');
    $query = $this->db->get('admin_menu');
    $records = array();

    if ($query->num_rows() > 0) :
      foreach ($query->result() as $row) :
        $records[] = $row;
      endforeach;
    endif;

    return $records;
  }

  // Get Admin menu by id
  function get_menu_by_id($id)
  {
    $this->db->select('*');
    $this->db->where('menu_id', $id);
    $query = $this->db->get('admin_menu');
    $records = array();

    if ($query->num_rows() > 0) :
      foreach ($query->result() as $row) :
        $records[] = $row;
      endforeach;
    endif;

    return $records;
  }

  //Inser Update Admin Menu
  function insert_update_menu_data($id = NULL)
  {
      $status = $this->input->post('menu-status');
      $status = (isset($status)) ? '1' : '0';

      if ($id == NULL) :
        // insert data
        $insert_data = array(
          'menu_name'   => $this->input->post('menu-name'),
  			  'menu_url'  	=> $this->input->post('menu-url'),
  			  'menu_icon'   => $this->input->post('menu-icon'),
  			  'status'      => $status,
  			  'created_at'  => date('m-d-Y')
        );
        // Insert into Admin user role
        return $this->db->insert('admin_menu', $insert_data);
      else :
        // Update data
  			$update_data = array(
            'menu_name' => $this->input->post('menu-name'),
            'menu_url'  => $this->input->post('menu-url'),
            'menu_icon' => $this->input->post('menu-icon'),
            'status'    => $status,
				);
				
        // Update into Admin User Role
        $this->db->where('menu_id', $id);
        return $this->db->update('admin_menu', $update_data);
      endif;
  }

  // Delete Admin Menu
  function delete_admin_menu()
  {
		$id = $this->input->post('id');
    $this->db->where('menu_id', $id);
    return $this->db->delete('admin_menu');
  }

  // Delete mulitple Admin menu
  function delete_multiple_menu()
  {
    $menu_ids = $this->input->post('table_records');
    foreach ($menu_ids as $menu_id) :
      $this->db->where('menu_id', $menu_id);
      $this->db->delete('admin_menu');
    endforeach;
  }

  // Get Admin Menu Unselected List

  function get_admin_unselected_menu_list($user_role_id)
  {
    $query = $this->db->query("
      SELECT
        `a`.`menu_id`, `a`.`menu_name`
      FROM
        ".$this->db->dbprefix('admin_menu')." a
      WHERE
        `a`.`menu_id`
      NOT IN
        ( SELECT
            menu_id
          FROM
            ".$this->db->dbprefix('admin_menu_group')."
          WHERE
            user_role_id = '".$user_role_id."'
          AND
            menu_id NOT IN ('0'))
      ORDER BY
        menu_name"
    );

    $records = array();

    if ($query->num_rows() > 0) :
      foreach ($query->result() as $row) :
        $records[] = $row;
      endforeach;
    endif;

    return $records;
  }

  // Get Admin Menu Selected List
  function get_admin_selected_menu_list($user_role_id)
  {
    $this->db->select(array('admin_menu.menu_id', 'menu_name', 'parent_id'));
    $this->db->from('admin_menu_group');
    $this->db->join('admin_menu', 'admin_menu.menu_id = admin_menu_group.menu_id');
    $this->db->where(
      array(
        'user_role_id'  => $user_role_id,
        'parent_id'     => '0'
      )
    );
    $this->db->order_by('sort_order', 'ASC');
    $query = $this->db->get();
    $records = array();

    if ($query->num_rows() > 0) :
      foreach ($query->result() as $row) :
        $records[] = $row;
      endforeach;
    endif;

    return $records;
  }

  function get_child_menu_list($user_role_id, $parent_id)
  {
    $this->db->select(array('admin_menu.menu_id', 'menu_name', 'parent_id'));
    $this->db->from('admin_menu_group');
    $this->db->join('admin_menu', 'admin_menu.menu_id = admin_menu_group.menu_id');
    $this->db->where(array(
      'parent_id'     => $parent_id,
      'user_role_id'  => $user_role_id
    ));
    $this->db->order_by('sort_order', 'ASC');
    $query = $this->db->get();
    $records = array();

    if ($query->num_rows() > 0) :
      foreach ($query->result() as $row) :
        $records[] = $row;
      endforeach;
    endif;

    return $records;
  }
}
