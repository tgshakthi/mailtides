<?php
/**
 * Admin Header model
 *
 * @category Model
 * @package  Admin Header
 * @author   Saravana
 * Created at:  23-Mar-2018
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_header_model extends CI_Model
{
    private $table_admin_user = 'admin_user';
    private $table_website = 'websites';
    private $table_admin_menu = 'admin_menu';
    private $table_admin_menu_group = 'admin_menu_group';
    private $table_color = 'color';
    /**
     * Get Admin User Details
     * return output as stdClass Object array
     * created at : 23-Mar-2018
     * modified at :
     * modified by : Saravana
     */
    function get_admin_user_details($id)
    {
        $this->db->select(array(
            'id',
            'first_name',
            'last_name',
            'email',
            'user_image',
            'website_id'
        ));
        $this->db->where('id', $id);
        $query   = $this->db->get($this->table_admin_user);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Get Website details
    function get_website_details($id)
    {
        $this->db->select(array(
            'id',
            'website_name',
            'folder_name',
            'website_url',
            'logo'
        ));
        $this->db->where('id', $id);
        $query   = $this->db->get($this->table_website);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Get Sidebar Details
    function sidebar_parent_menu($id)
    {
        $query   = $this->db->query("
      SELECT
      " . $this->db->dbprefix($this->table_admin_menu) . ".menu_id, menu_name,menu_icon, menu_url, parent_id, user_role_id
      FROM
      " . $this->db->dbprefix($this->table_admin_menu_group) . "
      JOIN
      " . $this->db->dbprefix($this->table_admin_menu) . "
      ON
      " . $this->db->dbprefix($this->table_admin_menu) . ".menu_id = " . $this->db->dbprefix($this->table_admin_menu_group) . ".menu_id
      WHERE
      user_role_id
      IN
      (SELECT
        user_role_id
      FROM
        " . $this->db->dbprefix($this->table_admin_user) . "
      WHERE
        id = " . $id . ")
        AND
          parent_id = '0'
        ORDER BY sort_order ASC");
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Admin Sidebar Child Menu
    function sidebar_child_menu($user_role_id, $parent_id)
    {
        $this->db->select(array(
            $this->table_admin_menu . '.menu_id',
            'menu_name',
            'parent_id',
            'menu_url'
        ));
        $this->db->from($this->table_admin_menu_group);
        $this->db->join($this->table_admin_menu, $this->table_admin_menu . '.menu_id = ' . $this->table_admin_menu_group . '.menu_id');
        $this->db->where(array(
            'parent_id' => $parent_id,
            'user_role_id' => $user_role_id
        ));
        $this->db->order_by('sort_order', 'ASC');
        $query   = $this->db->get();
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Get Colors
    function get_color()
    {
        $this->db->select('*');
        $query   = $this->db->get($this->table_color);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
}