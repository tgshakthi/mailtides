<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model
{
    private $table_name = 'page_not_found';

    function get_page_not_found($website_id)
    {
        $this->db->select('*');
        $this->db->where('website_id', $website_id);
        $query = $this->db->get($this->table_name); 
        $records = array();

        if($query->num_rows() > 0) :
            $records = $query->result();
        endif;

        return $records;
    }

}
