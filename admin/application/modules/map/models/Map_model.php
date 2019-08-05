<?php
/**
 * Map Models
 *
 * @category Model
 * @package  Map
 * @author   Karthika
 * Created at:  30-Nov-2018
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Map_model extends CI_Model {
    private $table_name = "map";
    private $setting_table = "setting";
    function get_map_setting_details($website_id, $page_id, $code) {
        $this->db->select('*');
        $this->db->where(array('website_id' => $website_id, 'code' => $code, 'page_id' => $page_id));
        $query = $this->db->get($this->setting_table);
        $records = array();
        if ($query->num_rows() > 0):
          $records= $query->result();
          endif;
        return $records;
    }
    /**
     * Get Map
     * return output as stdClass Object array
     */
    function get_map($page_id) {
        $this->db->select('*');
        $this->db->where(array('page_id' => $page_id, 'is_deleted' => 0));
        $query = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
          $records= $query->result();
        endif;
        return $records;
    }
    /* Get Map details by id */
    function get_map_by_id($page_id, $id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('page_id', $page_id);
        $query = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
           $records= $query->result();
        endif;
        return $records;
    }
    // Inser Update Map
    function insert_update_map($id = NULL) {
        $page_id = $this->input->post('page-id');
        $key['title_color'] = $this->input->post('title_color');
        $key['title_position'] = $this->input->post('title_position');
        $key['address_color'] = $this->input->post('address_color');
        $key['address_position'] = $this->input->post('address_position');
        $key['map_position'] = $this->input->post('map_position');
        $key['background_color'] = $this->input->post('background_color');
        $customize_data = json_encode($key);
        $status = $this->input->post('status');
        $status = (isset($status)) ? '1' : '0';

        $website_folder_name = $this->admin_header->website_folder_name();
        $image = $this->input->post('image');
		$httpUrl = $this->input->post('httpUrl');
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
		$image    = str_replace($find_url, "", $image);

        if ($id == NULL):
            // insert data
            $insert_data = array(
                'page_id' => $page_id, 
                'image' => $image,
                'title' => $this->input->post('title'), 
                'address' => $this->input->post('address'), 
                'customization' => $customize_data, 
                'sort_order' => $this->input->post('sort_order'), 
                'status' => $status
            );
            // Insert into Map
            $this->db->insert($this->table_name, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array('image' => $image, 'title' => $this->input->post('title'), 'address' => $this->input->post('address'), 'customization' => $customize_data, 'sort_order' => $this->input->post('sort_order'), 'status' => $status);
            // Update  into map
            $this->db->where('id', $id);
            $this->db->where('page_id', $page_id);
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    // delete map
    function delete_map($page_id) {
        $id = $this->input->post('id');
        $this->db->where(array('id' => $id, 'page_id' => $page_id));
        return $this->db->update($this->table_map, array('is_deleted' => 1));
    }
    // Delete mulitple Map
    function delete_multiple_map() {
        $maps = $this->input->post('table_records');
        $page_id = $this->input->post('page_id');
        foreach ($maps as $map):
            $this->db->where(array('id' => $map, 'page_id' => $page_id));
            $this->db->update($this->table_name, array('is_deleted' => 1));
        endforeach;
    }
    // Insert Update Map Title Details
    function insert_update_map_title_data($page_id, $id = NULL) {
        $key = array('map_title', 'map_title_color', 'map_title_position', 'map_title_status');
        $website_id = $this->input->post('website_id');
        $value[] = $this->input->post('map_title');
        $value[] = $this->input->post('title-color');
        $value[] = $this->input->post('map_title_position');
        $status = $this->input->post('map_title_status');
        $value[] = (isset($status)) ? '1' : '0';
        // Convert to JSON data
        $keyJSON = json_encode($key);
        $valueJSON = json_encode($value);
        $maps = $this->get_map_setting_details($website_id, $page_id, 'map_title');
        if (empty($maps)):
            // insert data
            $insert_data = array('website_id' => $website_id, 'page_id' => $page_id, 'code' => 'map_title', 'key' => $keyJSON, 'value' => $valueJSON);
            $this->db->insert($this->setting_table, $insert_data);
            $this->session->set_flashdata('success', 'Successfully Created');
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array('key' => $keyJSON, 'value' => $valueJSON);
            $this->db->where(array('website_id' => $website_id, 'code' => 'map_title', 'page_id' => $page_id));
            $this->session->set_flashdata('success', 'Successfully Updated');
            return $this->db->update($this->setting_table, $update_data);
        endif;
    }
    // Insert Update Map Customization
    function insert_update_map_customize_data($page_id) {
        $website_folder_name = $this->admin_header->website_folder_name();
        $website_id = $this->input->post('website_id');
        $httpUrl = $this->input->post('httpUrl');
        $component_background = $this->input->post('component-background');
        $color = $this->input->post('map_background_color');
        $image = $this->input->post('image');
        if (isset($image) && !empty($image) && $component_background == 'image'):
            // Remove Host URL in image
            //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
            $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
            $map_background = str_replace($find_url, "", $image);
        else:
            $map_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
        endif;
        $key = array('row_count', 'component_background', 'map_background');
        $value[] = $this->input->post('map_row_count');
        $value[] = $this->input->post('component-background');
        $value[] = $map_background;
        // Convert to JSON data
        $keyJSON = json_encode($key);
        $valueJSON = json_encode($value);
        $maps = $this->get_map_setting_details($website_id, $page_id, 'map_customize');
        if (empty($maps)):
            // insert data
            $insert_data = array('website_id' => $website_id, 'page_id' => $page_id, 'code' => 'map_customize', 'key' => $keyJSON, 'value' => $valueJSON);
            $this->db->insert($this->setting_table, $insert_data);
            $this->session->set_flashdata('success', 'Successfully Created');
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array('key' => $keyJSON, 'value' => $valueJSON);
            $this->db->where(array('website_id' => $website_id, 'code' => 'map_customize', 'page_id' => $page_id));
            $this->session->set_flashdata('success', 'Successfully Updated');
            return $this->db->update($this->setting_table, $update_data);
        endif;
    }
}
