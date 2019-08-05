<?php
/**
 * Tab Models
 *
 * @category Model
 * @package  Tab
 * @author   Athi
 * Created at:  8-Aug-2018
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Tab_model extends CI_Model
{
    private $table_name = 'tab';
    private $table_tab_text_full_width = 'tab_text_full_width';
    private $table_tab_text_image = 'tab_text_image';
    private $table_setting = 'setting';
    
    /**
     * Get Tab
     * return output as stdClass Object array
     */
    function get_tab($website_id, $page_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
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
    
    // Get Tab by id
    
    function get_tab_by_id($page_id, $id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'page_id' => $page_id,
            'id' => $id
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Insert Update Tab
    
    function insert_update_tab($website_id, $page_id, $id = NULL)
    {
        $status = $this->input->post('status');
        $status = (isset($status)) ? '1' : '0';
        
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'tab_name' => htmlspecialchars_decode(trim(htmlentities($this->input->post('tab_name')))),
                'tab_color' => $this->input->post('tab_color'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Tab
            $this->db->insert($this->table_name, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'tab_name' => htmlspecialchars_decode(trim(htmlentities($this->input->post('tab_name')))),
                'tab_color' => $this->input->post('tab_color'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Tab
            $this->db->where(array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'id' => $id
            ));
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    
    // Get Tab Text Full Width by Tab ID
    function get_tab_text_full_width_by_tab_id($tab_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'tab_id' => $tab_id
        ));
        $query   = $this->db->get($this->table_tab_text_full_width);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Get Tab Text Image
    function get_tab_text_image($tab_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'tab_id' => $tab_id,
            'is_deleted' => 0
        ));
        $query   = $this->db->get($this->table_tab_text_image);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Insert Update Tab Text Image
    function insert_update_tab_text_image($tab_id, $id = NULL)
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
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $image    = str_replace($find_url, "", $image);
        
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'tab_id' => $tab_id,
                'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'image' => $image,
                'image_title' => $this->input->post('image_title'),
                'image_alt' => $this->input->post('image_alt'),
                'template' => $this->input->post('template'),
                'image_position' => $this->input->post('image_pos'),
                'image_size' => $this->input->post('image_size'),
                'text' => $this->input->post('text'),
                'content_title_color' => $this->input->post('content_title_color'),
                'content_title_position' => $this->input->post('content_title_position'),
                'content_color' => $this->input->post('content_color'),
                'background_color' => $this->input->post('background_color'),
                'readmore_btn' => $readmore_btn,
                'button_type' => $this->input->post('button_type'),
                'btn_background_color' => $this->input->post('btn_background_color'),
                'readmore_label' => $this->input->post('readmore_label'),
                'label_color' => $this->input->post('label_color'),
                'readmore_url' => $this->input->post('readmore_url'),
                'open_new_tab' => $open_new_tab,
                'background_hover' => $this->input->post('background_hover'),
                'text_hover' => $this->input->post('text_hover'),
                'readmore_character' => $this->input->post('readmore_character'),
                'border' => $border,
                'border_size' => $this->input->post('border_size'),
                'border_color' => $this->input->post('border_color'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Tab Text Image
            $this->db->insert($this->table_tab_text_image, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'image' => $image,
                'image_title' => $this->input->post('image_title'),
                'image_alt' => $this->input->post('image_alt'),
                'template' => $this->input->post('template'),
                'image_position' => $this->input->post('image_pos'),
                'image_size' => $this->input->post('image_size'),
                'text' => $this->input->post('text'),
                'content_title_color' => $this->input->post('content_title_color'),
                'content_title_position' => $this->input->post('content_title_position'),
                'content_color' => $this->input->post('content_color'),
                'background_color' => $this->input->post('background_color'),
                'readmore_btn' => $readmore_btn,
                'button_type' => $this->input->post('button_type'),
                'btn_background_color' => $this->input->post('btn_background_color'),
                'readmore_label' => $this->input->post('readmore_label'),
                'label_color' => $this->input->post('label_color'),
                'readmore_url' => $this->input->post('readmore_url'),
                'open_new_tab' => $open_new_tab,
                'background_hover' => $this->input->post('background_hover'),
                'text_hover' => $this->input->post('text_hover'),
                'readmore_character' => $this->input->post('readmore_character'),
                'border' => $border,
                'border_size' => $this->input->post('border_size'),
                'border_color' => $this->input->post('border_color'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Tab Text Image
            $this->db->where(array(
                'tab_id' => $tab_id,
                'id' => $id
            ));
            return $this->db->update($this->table_tab_text_image, $update_data);
        endif;
    }
    
    /**
     * Get Tab setting Details
     * return output as stdClass Object array
     */
    function get_tab_setting_details($website_id, $page_id, $code)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
            'code' => $code,
            'page_id' => $page_id
        ));
        $query   = $this->db->get($this->table_setting);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Insert Update Tab Title
    function insert_update_tab_title($page_id, $id = NULL)
    {
		$website_folder_name = $this->admin_header->website_folder_name();
		$httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('tab_background_color');
		$image = $this->input->post('image');
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$tab_background = str_replace($find_url, "", $image);
		else :
			$tab_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;		

		

		
		
		
        $key        = array(
            'tab_title',
            'title_color',
            'title_position',
           'component_background',
			'tab_background',
            'status'
        );
        $website_id = $this->input->post('website_id');
        $value[]    = $this->input->post('tab_title');
        $value[]    = $this->input->post('title_color');
        $value[]    = $this->input->post('title_position');
		$value[]    = $component_background;
        $value[]    = $tab_background;
        $status     = $this->input->post('status');
        $value[]    = (isset($status)) ? '1' : '0';
        
        // Convert to JSON data
        
        $keyJSON   = json_encode($key);
        $valueJSON = json_encode($value);
        $tabs      = $this->get_tab_setting_details($website_id, $page_id, 'tab');
        if (empty($tabs)):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'code' => 'tab',
                'key' => $keyJSON,
                'value' => $valueJSON
            );
            $this->db->insert($this->table_setting, $insert_data);
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
                'code' => 'tab',
                'page_id' => $page_id
            ));
		
            $this->session->set_flashdata('success', 'Successfully Updated');
            return $this->db->update($this->table_setting, $update_data);
        endif;
    }
    
    // Get Tab Text Image by ID
    function get_tab_text_image_by_id($id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'id' => $id
        ));
        $query   = $this->db->get($this->table_tab_text_image);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Delete Tab Text Image
    
    function delete_tab_text_image($tab_id)
    {
        $id = $this->input->post('id');
        $this->db->where(array(
            'id' => $id,
            'tab_id' => $tab_id
        ));
        return $this->db->update($this->table_tab_text_image, array(
            'is_deleted' => 1
        ));
    }
    
    // Delete mulitple Tab Text Image
    
    function delete_multiple_tab_text_image()
    {
        $text_images = $this->input->post('table_records');
        $tab_id      = $this->input->post('tab_id');
        foreach ($text_images as $text_image):
            $this->db->where(array(
                'id' => $text_image,
                'tab_id' => $tab_id
            ));
            $this->db->update($this->table_tab_text_image, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    // Insert Update Tab Component
    
    function insert_update_tab_component($website_id, $page_id, $tab_id)
    {
        $tab_components = ($this->input->post('tab_components') != '') ? implode(',', $this->input->post('tab_components')) : '';
        
        // Update data
        
        $update_data = array(
            'tab_components' => $tab_components
        );
        
        // Update into Tab
        
        $this->db->where(array(
            'website_id' => $website_id,
            'page_id' => $page_id,
            'id' => $tab_id
        ));
        return $this->db->update($this->table_name, $update_data);
    }
    
    //Inser Update Tab Text Full Width
    function insert_update_tab_text_full_width($id = NULL)
    {
        $tab_id = $this->input->post('tab_id');
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'tab_id' => $tab_id,
                'title' => $this->input->post('text_full_width_title'),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'full_text' => htmlspecialchars_decode(trim(htmlentities($this->input->post('full_text')))),
                'content_title_color' => $this->input->post('content_title_color'),
                'content_title_position' => $this->input->post('content_title_position'),
                'content_color' => $this->input->post('content_color'),
                'content_position' => $this->input->post('content_position'),
                'background_color' => $this->input->post('background_color'),
                'created_at' => date('m-d-Y')
            );
        // Insert into Tab Text Full Width Text
            return $this->db->insert($this->table_tab_text_full_width, $insert_data);
        else:
            // Update data
            $update_data = array(
                'title' => $this->input->post('text_full_width_title'),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'full_text' => htmlspecialchars_decode(trim(htmlentities($this->input->post('full_text')))),
                'content_title_color' => $this->input->post('content_title_color'),
                'content_title_position' => $this->input->post('content_title_position'),
                'content_color' => $this->input->post('content_color'),
                'content_position' => $this->input->post('content_position'),
                'background_color' => $this->input->post('background_color')
            );
            // Update into Tab Text Full Width Text
            $this->db->where(array(
                'tab_id' => $tab_id,
                'id' => $id
            ));
            return $this->db->update($this->table_tab_text_full_width, $update_data);
        endif;
    }
    
    // Update Tab Text Image Sort Order
    function update_text_image_sort_order($tab_id, $row_sort_orders)
    {
        if (!empty($row_sort_orders)):
            $i = 1;
            foreach ($row_sort_orders as $row_sort_order):
                $this->db->where(array(
                    'tab_id' => $tab_id,
                    'id' => $row_sort_order
                ));
                $this->db->update($this->table_tab_text_image, array(
                    'sort_order' => $i
                ));
                $i++;
            endforeach;
        endif;
    }
    
    // Update Tab Sort Order
    function update_sort_order($page_id, $row_sort_orders)
    {
        if (!empty($row_sort_orders)):
            $i = 1;
            foreach ($row_sort_orders as $row_sort_order):
                $this->db->where(array(
                    'page_id' => $page_id,
                    'id' => $row_sort_order
                ));
                $this->db->update('tab', array(
                    'sort_order' => $i
                ));
                $i++;
            endforeach;
        endif;
    }
    
    // Delete Tab
    
    function delete_tab($page_id)
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
    
    // Delete mulitple Tab
    
    function delete_multiple_tab()
    {
        $tabs    = $this->input->post('table_records');
        $page_id = $this->input->post('page_id');
        foreach ($tabs as $tab):
            $this->db->where(array(
                'id' => $tab,
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
        $this->db->update($this->table_tab_text_image, $remove_image);
    }
}