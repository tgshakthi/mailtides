<?php
/**
 * Text Icon Models
 *
 * @category Model
 * @package  Text Icon
 * @author   Saravana
 * Created at:  23-Jun-2018
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Text_icon_model extends CI_Model
{
    private $table_name = 'text_icon';
    private $setting_table = 'setting';
    
    /**
     * Get Text Icon setting Details
     * return output as stdClass Object array
     */
    
    function get_text_icon_setting_details($website_id, $page_id, $code)
    {
        $this->db->select('*');
        
        $this->db->where(array(
            'website_id' => $website_id,
            'code' => $code,
            'page_id' => $page_id
        ));
        $query   = $this->db->get($this->setting_table);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        
        return $records;
    }
    
    /**
     * Get Text Icon Details
     * return output as stdClass Object array
     */
    
    function get_text_icon($page_id)
    {
        $this->db->select(array(
            'id',
            'page_id',
            'icon',
            'title',
            'icon_shape',
            'sort_order',
            'status'
        ));
        
        $this->db->where(array(
            'page_id' => $page_id,
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
    
    // Get Text Icon By Id
    function get_text_icon_by_id($page_id, $id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('page_id', $page_id);
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Insert Update Text Icon Title Details
    
    function insert_update_text_icon_title_data($page_id, $id = NULL)
    {
        $key = array(
            'text_icon_title',
            'text_icon_title_color',
            'text_icon_title_position',
            'text_icon_title_status'
        );
        
        $website_id = $this->input->post('website_id');
        $value[]    = $this->input->post('text_icon_title');
        $value[]    = $this->input->post('title-color');
        $value[]    = $this->input->post('text_icon_title_position');
        $status     = $this->input->post('icon_status');
        $value[]    = (isset($status)) ? '1' : '0';
        
        // Convert to JSON data
        $keyJSON   = json_encode($key);
        $valueJSON = json_encode($value);
        
        $text_icons = $this->get_text_icon_setting_details($website_id, $page_id, 'text_icon_title');
        
        if (empty($text_icons)):
            // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'code' => 'text_icon_title',
                'key' => $keyJSON,
                'value' => $valueJSON
            );
            $this->db->insert($this->setting_table, $insert_data);
            $this->session->set_flashdata('success', 'Text Icon successfully Created');
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'key' => $keyJSON,
                'value' => $valueJSON
            );
            $this->db->where(array(
                'website_id' => $website_id,
                'code' => 'text_icon_title',
                'page_id' => $page_id
            ));
            $this->session->set_flashdata('success', 'Text Icon successfully Updated');
            return $this->db->update($this->setting_table, $update_data);
        endif;
    }
    
    // Insert Update Text Icon Customization
    
    function insert_update_text_icon_customize_data($page_id)
    {
        $website_folder_name  = $this->admin_header->website_folder_name();
        $website_id           = $this->input->post('website_id');
        $httpUrl              = $this->input->post('httpUrl');
        $component_background = $this->input->post('component-background');
        $color                = $this->input->post('text_icon_background_color');
        $image                = $this->input->post('image');
        
        if (isset($image) && !empty($image) && $component_background == 'image'):
        // Remove Host URL in image
            
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;            
            $find_url             = $httpUrl . '/images/' . $website_folder_name . '/';
            $text_icon_background = str_replace($find_url, "", $image);
        else:
            $text_icon_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
        endif;   
        
        $key = array(
            'row_count',
            'component_background',
            'text_icon_background'
        );
        
        $value[] = $this->input->post('icon_row_count');
        $value[] = $this->input->post('component-background');
        $value[] = $text_icon_background;        
        
        // Convert to JSON data
        $keyJSON   = json_encode($key);
        $valueJSON = json_encode($value);
        
        $text_icons = $this->get_text_icon_setting_details($website_id, $page_id, 'text_icon_customize');
        
        if (empty($text_icons)):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'code' => 'text_icon_customize',
                'key' => $keyJSON,
                'value' => $valueJSON
            );
            $this->db->insert($this->setting_table, $insert_data);
            $this->session->set_flashdata('success', 'Successfully Created');
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'key' => $keyJSON,
                'value' => $valueJSON
            );
            $this->db->where(array(
                'website_id' => $website_id,
                'code' => 'text_icon_customize',
                'page_id' => $page_id
            ));
            $this->session->set_flashdata('success', 'Successfully Updated');
            return $this->db->update($this->setting_table, $update_data);
        endif;
    }
    
    // Insert Update Text Icon
    
    function insert_update_text_icon_data($page_id, $id = NULL)
    {
        $redirect     = $this->input->post('redirect');
        $open_new_tab = $this->input->post('open_new_tab');
        $status       = $this->input->post('status');
        
        $redirect     = (isset($redirect)) ? '1' : '0';
        $open_new_tab = (isset($open_new_tab)) ? '1' : '0';
        $status       = (isset($status)) ? '1' : '0';
        
        if ($id == NULL):
            $insert_data = array(
                'page_id' => $page_id,
                'icon' => $this->input->post('icon'),
                'icon_color' => $this->input->post('icon_color'),
                'icon_position' => $this->input->post('icon_position'),
                'icon_shape' => $this->input->post('icon_shape'),
                'icon_background_color' => $this->input->post('icon_background_color'),
                'icon_hover_color' => $this->input->post('icon_hover_color'),
                'icon_hover_background' => $this->input->post('icon_hover_background'),
                'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
                'content' => htmlspecialchars_decode(trim(htmlentities($this->input->post('content')))),
                'title_color' => $this->input->post('title-color'),
                'title_position' => $this->input->post('title_position'),
                'content_title_color' => $this->input->post('content-title-color'),
                'content_title_position' => $this->input->post('content_title_position'),
                'content_color' => $this->input->post('content-color'),
                'content_position' => $this->input->post('content_position'),
                'redirect' => $redirect,
                'redirect_url' => $this->input->post('redirect_url'),
                'open_new_tab' => $open_new_tab,
                'background_hover_color' => $this->input->post('background_hover'),
                'hover_title_color' => $this->input->post('hover_title_color'),
                'content_title_hover' => $this->input->post('content_title_hover'),
                'text_hover_color' => $this->input->post('text_hover'),
                'background_color' => $this->input->post('background-color'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Text Icon
            $this->db->insert($this->table_name, $insert_data);
            return $this->db->insert_id();
        else:
            $update_data = array(
                'icon' => $this->input->post('icon'),
                'icon_color' => $this->input->post('icon_color'),
                'icon_position' => $this->input->post('icon_position'),
                'icon_shape' => $this->input->post('icon_shape'),
                'icon_background_color' => $this->input->post('icon_background_color'),
                'icon_hover_color' => $this->input->post('icon_hover_color'),
                'icon_hover_background' => $this->input->post('icon_hover_background'),
                'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
                'content' => htmlspecialchars_decode(trim(htmlentities($this->input->post('content')))),
                'title_color' => $this->input->post('title-color'),
                'title_position' => $this->input->post('title_position'),
                'content_title_color' => $this->input->post('content-title-color'),
                'content_title_position' => $this->input->post('content_title_position'),
                'content_color' => $this->input->post('content-color'),
                'content_position' => $this->input->post('content_position'),
                'redirect' => $redirect,
                'redirect_url' => $this->input->post('redirect_url'),
                'open_new_tab' => $open_new_tab,
                'background_hover_color' => $this->input->post('background_hover'),
                'hover_title_color' => $this->input->post('hover_title_color'),
                'content_title_hover' => $this->input->post('content_title_hover'),
                'text_hover_color' => $this->input->post('text_hover'),
                'background_color' => $this->input->post('background-color'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Text Icon
            $this->db->where('id', $id);
            $this->db->where('page_id', $page_id);
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    
    // Delete Text Icon
    
    function delete_text_icon($page_id)
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
    
    // Delete mulitple Text Icon
    
    function delete_multiple_text_icon_data()
    {
        $text_icons = $this->input->post('table_records');
        $page_id    = $this->input->post('page_id');
        foreach ($text_icons as $text_icon):
            $this->db->where(array(
                'id' => $text_icon,
                'page_id' => $page_id
            ));
            $this->db->update($this->table_name, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    // Update Text Icon Sort Order
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
}