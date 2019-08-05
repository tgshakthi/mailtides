<?php
/**
 * Our Service Models
 *
 * @category Model
 * @package  Our Service
 * @author   Saravana
 * Created at:  27-Jun-2018
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Our_service_model extends CI_Model
{
    private $table_name = 'our_service';
    private $setting_table = 'setting';
    /**
     * Get Our Service setting Details
     * return output as stdClass Object array
     */
    function get_our_service_setting_details($website_id, $page_id, $code)
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
     * Get Our Service Details
     * return output as stdClass Object array
     */
    function get_our_service($page_id)
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
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Get Our Service By Id
    
    function get_our_service_by_id($page_id, $id)
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
    
    // Insert Update Our Service Customization
    
    function insert_update_our_service_customize_data($page_id)
    {
        $website_id = $this->input->post('website_id');
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('our_service_background_color');
		$image = $this->input->post('image');
        $status     = $this->input->post('status');
        $status     = (isset($status)) ? '1' : '0';
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$our_services_background = str_replace($find_url, "", $image);
		else :
			$our_services_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;
		
        $key        = array(
            'our_service_title',
            'our_service_title_color',
            'our_service_title_position',
            'our_service_content',
            'our_service_content_color',
            'our_service_content_position',
            'our_service_row_count',
			'component_background',
			'our_service_background',
            'our_service_status'
        );
        $value[]    = $this->input->post('title');
        $value[]    = $this->input->post('title-color');
        $value[]    = $this->input->post('title_position');
        $value[]    = $this->input->post('content');
        $value[]    = $this->input->post('content-color');
        $value[]    = $this->input->post('content_position');
        $value[]    = $this->input->post('our_service_row_count');
		$value[]    = $this->input->post('component-background');
		$value[] 	= $our_services_background;
        $value[]    = $status;
        
        // Convert to JSON data
        
        $keyJSON      = json_encode($key);
        $valueJSON    = json_encode($value);
        $our_services = $this->get_our_service_setting_details($website_id, $page_id, 'our_service_customize');
        if (empty($our_services)):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'code' => 'our_service_customize',
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
                'code' => 'our_service_customize',
                'page_id' => $page_id
            ));
            $this->session->set_flashdata('success', 'Successfully Updated');
            return $this->db->update($this->setting_table, $update_data);
        endif;
    }
    
    // Insert Update Our Service
    
    function insert_update_our_service_data($page_id, $id = NULL)
    {
        $website_folder_name = $this->admin_header->website_folder_name();
        $redirect            = $this->input->post('redirect');
        $open_new_tab        = $this->input->post('open_new_tab');
        $status              = $this->input->post('status');
        $redirect            = (isset($redirect)) ? '1' : '0';
        $open_new_tab        = (isset($open_new_tab)) ? '1' : '0';
        $status              = (isset($status)) ? '1' : '0';
        $image               = $this->input->post('image');
        $httpUrl             = $this->input->post('httpUrl');
        
        // Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $image    = str_replace($find_url, "", $image);
        
        if ($id == NULL):
        // Insert data
            $insert_data = array(
                'page_id' => $page_id,
                'image' => $image,
                'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
                'title_color' => $this->input->post('title_color'),
                'redirect' => $redirect,
                'redirect_url' => str_ireplace(' ', '-', $this->input->post('redirect_url')),
                'open_new_tab' => $open_new_tab,
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
        // Insert into Our Service
            $this->db->insert($this->table_name, $insert_data);
            return $this->db->insert_id();
        else:
            // Update Data
            $update_data = array(
                'image' => $image,
                'title' => htmlspecialchars_decode(trim(htmlentities($this->input->post('title')))),
                'title_color' => $this->input->post('title_color'),
                'redirect' => $redirect,
                'redirect_url' => str_ireplace(' ', '-', $this->input->post('redirect_url')),
                'open_new_tab' => $open_new_tab,
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Text Image
            $this->db->where('id', $id);
            $this->db->where('page_id', $page_id);
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    
    // Delete Our Service
    
    function delete_our_service($page_id)
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
    
    // Delete mulitple Our Service
    
    function delete_multiple_our_service_data()
    {
        $our_services = $this->input->post('table_records');
        $page_id      = $this->input->post('page_id');
        foreach ($our_services as $our_service):
            $this->db->where(array(
                'id' => $our_service,
                'page_id' => $page_id
            ));
            $this->db->update($this->table_name, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    // Update Our Service Sort Order
    
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