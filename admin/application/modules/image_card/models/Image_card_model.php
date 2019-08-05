<?php
/**
 * Image Card Models
 *
 * @category Model
 * @package  Image Card
 * @author   Saravana
 * Created at:  27-Jun-2018
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Image_card_model extends CI_Model
{
    private $table_name = 'image_card';
    private $setting_table = 'setting';
    
    /**
     * Get Image Card setting Details
     * return output as stdClass Object array
     */
    
    function get_image_card_setting_details($website_id, $page_id, $code)
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
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        
        return $records;
    }
    
    // Update Image Card Sort Order
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
    
    /**
     * Get Image Card Details
     * return output as stdClass Object array
     */
    
    function get_image_card($page_id)
    {
        $this->db->select(array(
            'id',
            'page_id',
            'image',
            'title',
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
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Get Image Card By Id
    function get_image_card_by_id($page_id, $id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('page_id', $page_id);
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Insert Update Image Card Title Details
    
    function insert_update_image_card_title_data($page_id, $id = NULL)
    {
        $title_color = $this->input->post('title-color');
        $key         = array(
            'image_card_title',
            'image_card_title_color',
            'image_card_title_position',
            'image_card_title_status'
        );
        
        $website_id = $this->input->post('website_id');
        $value[]    = $this->input->post('image_card_title');
        $value[]    = ($title_color == '') ? 'black-text' : $title_color;
        $value[]    = $this->input->post('image_card_title_position');
        $status     = $this->input->post('image_card_title_status');
        $value[]    = (isset($status)) ? '1' : '0';
        
        // Convert to JSON data
        $keyJSON   = json_encode($key);
        $valueJSON = json_encode($value);
        
        $image_cards = $this->get_image_card_setting_details($website_id, $page_id, 'image_card_title');
        
        if (empty($image_cards)):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'code' => 'image_card_title',
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
                'code' => 'image_card_title',
                'page_id' => $page_id
            ));
            $this->session->set_flashdata('success', 'Successfully Updated');
            return $this->db->update($this->setting_table, $update_data);
        endif;
    }
    
    // Insert Update Image Card Customization
    
    function insert_update_image_card_customize_data($page_id)
    {
        
        $website_folder_name  = $this->admin_header->website_folder_name();
        $website_id           = $this->input->post('website_id');
        $httpUrl              = $this->input->post('httpUrl');
        $component_background = $this->input->post('component-background');
        $color                = $this->input->post('image_card_background_color');
        $image                = $this->input->post('image');
        if (isset($image) && !empty($image) && $component_background == 'image'):
        // Remove Host URL in image
            
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;            
            $find_url            = $httpUrl . '/images/' . $website_folder_name . '/';
            $circular_background = str_replace($find_url, "", $image);
        else:
            $circular_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
        endif;
        $key = array(
            'row_count',
            'component_background',
            'image_card_background'
        );
        
        $value[] = $this->input->post('image_card_row_count');
        $value[] = $this->input->post('component-background');
        $value[] = $circular_background;
        
        // Convert to JSON data
        $keyJSON   = json_encode($key);
        $valueJSON = json_encode($value);
        
        $image_cards = $this->get_image_card_setting_details($website_id, $page_id, 'image_card_customize');
        
        if (empty($image_cards)):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'code' => 'image_card_customize',
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
                'code' => 'image_card_customize',
                'page_id' => $page_id
            ));
            $this->session->set_flashdata('success', 'Successfully Updated');
            return $this->db->update($this->setting_table, $update_data);
        endif;
    }
    
    // Insert Update Image Card
    
    function insert_update_image_card_data($page_id, $id = NULL)
    {
        
        $website_folder_name = $this->admin_header->website_folder_name();
        $readmore_btn        = $this->input->post('readmore_btn');
        $open_new_tab        = $this->input->post('open_new_tab');
        $border              = $this->input->post('border_status');
        $status              = $this->input->post('status');
        $readmore_btn        = (isset($readmore_btn)) ? '1' : '0';
        $open_new_tab        = (isset($open_new_tab)) ? '1' : '0';
        $border              = (isset($border)) ? '1' : '0';
        $status              = (isset($status)) ? '1' : '0';
        $image               = $this->input->post('image');
        $httpUrl             = $this->input->post('httpUrl');
        
        // Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url               = $httpUrl . '/images/' . $website_folder_name . '/';
        $image                  = str_replace($find_url, "", $image);
        $title_color            = $this->input->post('title_color');
        $title_hover_color      = $this->input->post('title_hover_color');
        $desc_hover_color       = $this->input->post('desc_hover_color');
        $desc_bg_hover_color    = $this->input->post('desc_bg_hover_color');
        $desc_title_color       = $this->input->post('desc_title_color');
        $desc_title_hover_color = $this->input->post('desc_title_hover_color');
        $desc_color             = $this->input->post('desc_color');
        $btn_background_color   = $this->input->post('btn_background_color');
        $readmore_label_color   = $this->input->post('readmore_label_color');
        $btn_background_hover   = $this->input->post('btn_background_hover');
        $btn_label_hover        = $this->input->post('btn_label_hover');
        $background_color       = $this->input->post('background_color');
        if ($id == NULL):
        // Insert data
            $insert_data = array(
                'page_id' => $page_id,
                'image' => $image,
                'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
                'title_color' => ($title_color == '') ? 'black-text' : $title_color,               
                'description' => $this->input->post('long_desc'),
                'description_title_color' => ($desc_title_color == '') ? 'black-text' : $desc_title_color,               
                'description_title_position' => $this->input->post('desc_title_position'),
                'description_color' => ($desc_color == '') ? 'black-text' : $desc_color,
                'description_position' => $this->input->post('desc_position'),
                'readmore_btn' => $readmore_btn,
                'button_type' => $this->input->post('button_type'),
                'btn_background_color' => ($btn_background_color == '') ? 'white' : $btn_background_color,
                'readmore_label' => $this->input->post('readmore_label'),
                'readmore_label_color' => ($readmore_label_color == '') ? 'black-text' : $readmore_label_color,
                'readmore_url' => $this->input->post('readmore_url'),
                'open_new_tab' => $open_new_tab,
                'btn_hover_color' => ($btn_background_hover == '') ? 'white' : $btn_background_hover,
                'btn_label_hover_color' => ($btn_label_hover == '') ? 'black-text' : $btn_label_hover,
                'background_color' => ($background_color == '') ? 'white' : $background_color,
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Image Card
            $this->db->insert($this->table_name, $insert_data);
            return $this->db->insert_id();
        else:
            // Update Data
            $update_data = array(
                'image' => $image,
                'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
                'title_color' => ($title_color == '') ? 'black-text' : $title_color,
                'description' => $this->input->post('long_desc'),
                'description_title_color' => ($desc_title_color == '') ? 'black-text' : $desc_title_color,
                'description_title_position' => $this->input->post('desc_title_position'),
                'description_color' => ($desc_color == '') ? 'black-text' : $desc_color,
                'description_position' => $this->input->post('desc_position'),
                'readmore_btn' => $readmore_btn,
                'button_type' => $this->input->post('button_type'),
                'btn_background_color' => ($btn_background_color == '') ? 'white' : $btn_background_color,
                'readmore_label' => $this->input->post('readmore_label'),
                'readmore_label_color' => ($readmore_label_color == '') ? 'black-text' : $readmore_label_color,
                'readmore_url' => $this->input->post('readmore_url'),
                'open_new_tab' => $open_new_tab,
                'btn_hover_color' => ($btn_background_hover == '') ? 'white' : $btn_background_hover,
                'btn_label_hover_color' => ($btn_label_hover == '') ? 'black-text' : $btn_label_hover,
                'background_color' => ($background_color == '') ? 'white' : $background_color,
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Text Image
            $this->db->where('id', $id);
            $this->db->where('page_id', $page_id);
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    
    // Delete Image Card
    
    function delete_image_card($page_id)
    {
        $id = $this->input->post('id');
        
        $this->db->where(array(
            'id' => $id,
            'page_id' => $page_id
        ));
        
        $this->db->update($this->table_name, array(
            'is_deleted' => 1
        ));
    }
    
    // Delete mulitple Image Card
    
    function delete_multiple_image_card_data()
    {
        $image_cards = $this->input->post('table_records');
        $page_id     = $this->input->post('page_id');
        foreach ($image_cards as $image_card):
            $this->db->where(array(
                'id' => $image_card,
                'page_id' => $page_id
            ));
            $this->db->update($this->table_name, array(
                'is_deleted' => 1
            ));
        endforeach;
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