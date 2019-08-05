<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Center_tab_model extends CI_Model
{
    
    function get_setting($website_id, $page_id, $code)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
            'page_id' => $page_id,
            'code' => $code
        ));
        $query   = $this->db->get('setting');
        $records = array();
        
        if ($query->num_rows() > 0):
            $records= $query->result();
        endif;
        
        return $records;
    }
    
    /* Get Center Tab Data */
    function get_center_tab($website_id, $page_id)
    {
        $this->db->select('*');
        $this->db->from("center_tab");
        $this->db->join('center_tab_text_image', 'center_tab.id = center_tab_text_image.center_tab_id');
        $this->db->where(array(
            'center_tab.website_id' => $website_id,
            'center_tab.page_id' => $page_id,
            'center_tab.status' => 1,
            'center_tab.is_deleted' => 0,
            'center_tab_text_image.status' => 1,
            'center_tab_text_image.is_deleted' => 0
        ));
        // $this->db->order_by('sort_order', 'asc');
        $query   = $this->db->get();
        $records = array();
        
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    function get_center_tab_text_image($page_id)
    {
        $this->db->select('*');
        $this->db->from("center_tab");
        $this->db->join('center_tab_text_image', 'center_tab.id = center_tab_text_image.center_tab_id');
        $this->db->where(array(
            'center_tab.page_id' => $page_id,
            'center_tab.status' => 1,
            'center_tab.is_deleted' => 0,
            'center_tab_text_image.status' => 1,
            'center_tab_text_image.is_deleted' => 0
        ));
        $query   = $this->db->get();
        $records = array();
        
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        
        return $records;
    }
    
}
?>