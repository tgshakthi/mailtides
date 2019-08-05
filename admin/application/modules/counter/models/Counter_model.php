<?php
/**
 * Counter
 * Created at : 29-Oct-2018
 * Author : Velu
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Counter_model extends CI_Model
{
    private $table_name = 'counter';
    private $table_setting = 'setting';
    private $table_number = 'numbers';
    
    // Get Counter Details
    function get_counter($page_id)
    {
        $this->db->select('*');
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
    
    // Insert Update counter
    function insert_update_counter($page_id, $id = NULL)
    {
        $status  = $this->input->post('status');
        $status  = (isset($status)) ? '1' : '0';
        $image   = $this->input->post('image');
        $httpUrl = $this->input->post('httpUrl');
        $image   = str_replace($httpUrl . '/', "", $image);
        if ($id == NULL):
            // insert data
            $insert_data = array(
                'page_id' => $page_id,
                'count_number' => $this->input->post('count_number'),
                'count_number_color' => $this->input->post('count_number_color'),
                'counter_title' => $this->input->post('counter_title'),
                'counter_title_color' => $this->input->post('counter_title_color'),
                'counter_icon' => $this->input->post('counter_icon'),
                'counter_icon_color' => $this->input->post('counter_icon_color'),
                'status' => $status
            );
            // Insert into Counter
            $this->db->insert('counter', $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'count_number' => $this->input->post('count_number'),
                'count_number_color' => $this->input->post('count_number_color'),
                'counter_title' => $this->input->post('counter_title'),
                'counter_title_color' => $this->input->post('counter_title_color'),
                'counter_icon' => $this->input->post('counter_icon'),
                'counter_icon_color' => $this->input->post('counter_icon_color'),
                'status' => $status
            );
            // Update into Counter
            $this->db->where('id', $id);
            $this->db->where('page_id', $page_id);
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    
    // Get Counter by id
    function get_counter_by_id($page_id, $id)
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
    
    // Get Counter Settings
    function get_setting_counter($page_id, $website_id, $code)
    {
        $this->db->select('*');
        $this->db->where(array(
            'page_id' => $page_id,
            'website_id' => $website_id,
            'code' => $code
        ));
        $query   = $this->db->get($this->table_setting);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Insert Update Counter Background image & Customization
    function insert_update_counter_image()
    {	
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$counter_id                = $this->input->post('counter_id');
        $page_id                   = $this->input->post('page_id');
		$httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('counter_background_color');
		$image = $this->input->post('image');
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$counter_background = str_replace($find_url, "", $image);
		else :
			$counter_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;		
       
        $counter_title             = $this->input->post('counter_title');
        $counter_title_color       = $this->input->post('counter_title_color');
        $counter_title_position    = $this->input->post('counter_title_position');
        $counter_title_font_size   = $this->input->post('counter_title_font_size');
        $counter_title_font_weight = $this->input->post('counter_title_font_weight');
        $counter_title_status      = $this->input->post('counter_title_status');
        $counter_title_status      = (isset($counter_title_status)) ? '1' : '0';
        
        $counter_image = $this->get_setting_counter($page_id, $website_id, 'counter_image');
        
        $image   = $this->input->post('counter_background_image');              
        // Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $image    = str_replace($find_url, "", $image);
        
        $values = array(
            $counter_title,
            $counter_title_color,
            $counter_title_position,
            $counter_title_font_size,
            $counter_title_font_weight,
            $counter_title_status,
			$component_background,
			$counter_background
        );
        
        // Convert to JSON data
        $keyJSON   = json_encode(array(
            'counter_title_customize',
            'counter_title_color_customize',
            'counter_title_position_customize',
            'counter_title_font_size_customize',
            'counter_title_font_weight_customize',
            'counter_title_status_customize',
			'component_background',
			'counter_background'
        ));
        $valueJSON = json_encode($values);
        
        if (empty($counter_image)):
            $insert_data = array(
                'page_id' => $page_id,
                'website_id' => $website_id,
                'code' => 'counter_image',
                'key' => $keyJSON,
                'value' => $valueJSON
            );
            $this->db->insert($this->table_setting, $insert_data);
            $this->session->set_flashdata('success', 'Counter Customization Successfully Created.');
        else:
            $update_data = array(
                'key' => $keyJSON,
                'value' => $valueJSON
            );
            $this->db->where(array(
                'page_id' => $page_id,
                'website_id' => $website_id,
                'code' => 'counter_image'
            ));
            $this->db->update($this->table_setting, $update_data);
            $this->session->set_flashdata('success', 'Counter Customization Successfully Updated.');
        endif;
    }
    
    // Delete Counter
    function delete_counter($page_id)
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
    
    //Delete Multiple Counter
    function delete_multiple_counter()
    {
        $counters = $this->input->post('table_records');
        $page_id  = $this->input->post('page_id');
        foreach ($counters as $counter):
            $this->db->where(array(
                'id' => $counter,
                'page_id' => $page_id
            ));
            $this->db->update($this->table_name, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    // Get Numbers
    function get_numbers()
    {
        $this->db->select('*');
        $this->db->limit(60, 13);
        $query   = $this->db->get($this->table_number);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
}