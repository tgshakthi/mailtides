<?php
/**
 * Banner Models
 *
 * @category Model
 * @package  Banner
 * @author   Saravana
 * Created at:  24-Apr-2018
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Banner_model extends CI_Model
{
    private $table_name = 'banner';
    
    /**
     * Get Banner
     * return output as stdClass Object array
     */
    function get_banners($id)
    {
        $this->db->select(array(
            'id',
            'page_id',
            'title',
            'image',
            'sort_order',
            'status'
        ));
        $this->db->where(array(
            'page_id' => $id,
            'is_deleted' => 0
        ));
        $this->db->order_by('id', 'desc');
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    /**
     * Get Banners by @param
     * return output as stdClass Object array
     */
    function get_bannerby_id($page_id, $id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Inser Update Banner
    
    function insert_update_banner($page_id, $id = NULL)
    {
        $website_folder_name = $this->admin_header->website_folder_name();
        $status              = $this->input->post('status');
        $status              = (isset($status)) ? '1' : '0';
        $readmore_btn        = $this->input->post('readmore_btn');
        $readmore_btn        = (isset($readmore_btn)) ? '1' : '0';
        $open_new_tab        = $this->input->post('open_new_tab');
        $open_new_tab        = (isset($open_new_tab)) ? '1' : '0';
        $image               = $this->input->post('image');
        $httpUrl             = $this->input->post('httpUrl');
        
        // Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $image    = str_replace($find_url, "", $image);
        
        $text = trim(html_entity_decode($this->input->post('text')));
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'page_id' => $page_id,
                'image_title' => $this->input->post('banner-image-title'),
                'image_alt' => $this->input->post('banner-image-alt'),
                'image' => $image,
                'title' => $this->input->post('banner-title'),
                'text' => $text,
                'title_color' => $this->input->post('title_color'),
                'text_color' => $this->input->post('text_color'),
                'text_position' => $this->input->post('text-position'),
                'title_font_size' => $this->input->post('title_font_size'),
                'title_font_weight' => $this->input->post('title_font_weight'),
                'btn_background_color' => $this->input->post('btn_background_color'),
                'background_transparent_color' => $this->input->post('bg_transparent_color'),
                'readmore_label' => $this->input->post('readmore_label'),
                'label_color' => $this->input->post('label_color'),
                'readmore_btn' => $readmore_btn,
                'button_type' => $this->input->post('button_type'),
                'button_position' => $this->input->post('button_position'),
                'readmore_url' => str_ireplace(' ', '-', $this->input->post('readmore_url')),
                'open_new_tab' => $open_new_tab,
                'background_hover' => $this->input->post('background_hover'),
                'text_hover' => $this->input->post('text_hover'),                
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Banner
            $this->db->insert($this->table_name, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'image_title' => $this->input->post('banner-image-title'),
                'image_alt' => $this->input->post('banner-image-alt'),
                'image' => $image,
                'title' => $this->input->post('banner-title'),
                'text' => $text,
                'title_color' => $this->input->post('title_color'),
                'text_color' => $this->input->post('text_color'),
                'text_position' => $this->input->post('text-position'),
                'title_font_size' => $this->input->post('title_font_size'),
                'title_font_weight' => $this->input->post('title_font_weight'),
                'btn_background_color' => $this->input->post('btn_background_color'),
                'background_transparent_color' => $this->input->post('bg_transparent_color'),
                'readmore_label' => $this->input->post('readmore_label'),
                'label_color' => $this->input->post('label_color'),
                'readmore_btn' => $readmore_btn,
                'button_type' => $this->input->post('button_type'),
                'button_position' => $this->input->post('button_position'),
                'readmore_url' => str_ireplace(' ', '-', $this->input->post('readmore_url')),
                'open_new_tab' => $open_new_tab,
                'background_hover' => $this->input->post('background_hover'),
                'text_hover' => $this->input->post('text_hover'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Banner
            $this->db->where('id', $id);
            $this->db->where('page_id', $page_id);
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    
    // Delete Banner
    
    function delete_banner($page_id)
    {
        $id = $this->input->post('id');
        $this->db->where(array(
            'id' => $id,
            'page_id' => $page_id
        ));
        return $this->db->update($this->table_name, array(
            'is_deleted' => 1
        ));
    }
    
    // Delete mulitple Banner
    
    function delete_multiple_banner()
    {
        $banners = $this->input->post('table_records');
        $page_id = $this->input->post('page_id');
        foreach ($banners as $banner):
            $this->db->where(array(
                'id' => $banner,
                'page_id' => $page_id
            ));
            $this->db->update($this->table_name, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    // Update Banner Sort Order
    function update_sort_order($page_id, $row_sort_orders)
    {
        if (!empty($row_sort_orders)):
            $i = 1;
            foreach ($row_sort_orders as $row_sort_order):
                $this->db->where('id', $row_sort_order);
                $this->db->update($this->table_name, array(
                    'sort_order' => $i
                ));
                $i++;
            endforeach;
        endif;
    }
    
    function get_numbers()
    {
        $this->db->select('*');
        $this->db->limit(60, 13);
        $query   = $this->db->get('numbers');
        $records = array();
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Remove Image
    
    function remove_image()
    {
        $id           = $this->input->post('id');
        $remove_image = array(
            'image' => ""
        );
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $remove_image);
    }
}