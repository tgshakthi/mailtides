<?php
/**
 * Gallery Model
 *
 * @category Model
 * @package  Gallery
 * @author   Saravana
 * Created at:  11-Jul-2018
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Gallery_model extends CI_Model
{
    private $table_name = 'gallery';
    private $category_table = 'gallery_category';
    private $setting_table = 'setting';
    /**
     * Get Gallery setting Details
     * return output as stdClass Object array
     */
    function get_gallery_setting_details($website_id, $page_id, $code)
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
     * Get Gallery
     * return output as stdClass Object array
     */
    function get_gallery($page_id)
    {
        $this->db->select(array(
            'id',
            'page_id',
            'image',
            'sort_order',
            'status'
        ));
        $this->db->where(array(
            'page_id' => $page_id,
            'is_deleted' => 0
        ));
        $this->db->order_by('id', 'desc');
        $query   = $this->db->get('gallery');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Get Gallery Category
    
    function get_gallery_category($website_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
            'is_deleted' => 0
        ));
        $query   = $this->db->get($this->category_table);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Get Gallery Category By ID
    
    function get_gallery_category_by_id($category_id, $website_id)
    {
        $this->db->select('*');
        $this->db->where('id', $category_id);
        $this->db->where('website_id', $website_id);
        $query   = $this->db->get($this->category_table);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Insert Update Gallery Category Data
    
    function insert_update_gallery_category_data($website_id, $id = NULL)
    {
        $status = $this->input->post('status');
        $status = (isset($status)) ? '1' : '0';
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'category_name' => $this->input->post('category_name'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Gallery Category
            $this->db->insert($this->category_table, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'category_name' => $this->input->post('category_name'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Gallery Category
            $this->db->where('id', $id);
            $this->db->where('website_id', $website_id);
            return $this->db->update($this->category_table, $update_data);
        endif;
    }
    
    // Check Gallery Category Duplicate
    
    function check_category_duplicate()
    {
        $category_name = $this->input->post('name');
        $website_id    = $this->input->post('web_id');
        $this->db->select('*');
        $this->db->where(array(
            'category_name' => $category_name,
            'website_id' => $website_id
        ));
        $query   = $this->db->get($this->category_table);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // / Delete Single Category
    
    function delete_category()
    {
        $id = $this->input->post('id');
        $this->db->where(array(
            'id' => $id
        ));
        return $this->db->update($this->category_table, array(
            'is_deleted' => 1
        ));
    }
    
    // Delete Multiple Category
    
    function delete_multiple_category()
    {
        $categories = $this->input->post('table_records');
        $website_id = $this->input->post('website_id');
        foreach ($categories as $category_id):
            $this->db->where(array(
                'id' => $category_id,
                'website_id' => $website_id
            ));
            $this->db->update($this->category_table, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    /**
     * Get Select Blog Category
     * return output as stdClass Object array
     */
    function select_gallery_category($website_id, $search)
    {
        $sql_data = "SELECT * FROM " . $this->db->dbprefix('gallery_category') . " WHERE category_name LIKE '%" . $search . "%' AND website_id = '" . $website_id . "' AND is_deleted = 0";
        $query    = $this->db->query($sql_data);
        $records  = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    /**
     * Get Selected Blog Category
     * return output as stdClass Object array
     */
    function selected_category($category_id)
    {
        $this->db->select(array(
            'id',
            'category_name'
        ));
        $this->db->where('id', $category_id);
        $query   = $this->db->get($this->category_table);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Get Gallery by id
    
    function get_gallery_by_id($page_id, $id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('page_id', $page_id);
        $query   = $this->db->get('gallery');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    // Insert Update Gallery Title Details
    
    function insert_update_gallery_title_data($page_id, $id = NULL)
    {
        $key        = array(
            'gallery_title',
            'gallery_title_color',
            'gallery_title_position',
            'gallery_title_status'
        );
        $website_id = $this->input->post('website_id');
        $value[]    = $this->input->post('gallery_title');
        $value[]    = $this->input->post('title-color');
        $value[]    = $this->input->post('gallery_title_position');
        $status     = $this->input->post('gallery_title_status');
        $value[]    = (isset($status)) ? '1' : '0';
        
        // Convert to JSON data
        
        $keyJSON   = json_encode($key);
        $valueJSON = json_encode($value);
        $gallerys  = $this->get_gallery_setting_details($website_id, $page_id, 'gallery_title');
        if (empty($gallerys)):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'code' => 'gallery_title',
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
                'code' => 'gallery_title',
                'page_id' => $page_id
            ));
            $this->session->set_flashdata('success', 'Successfully Updated');
            return $this->db->update($this->setting_table, $update_data);
        endif;
    }
    
    // Insert Update Gallery Customization
    
    function insert_update_gallery_customize_data($page_id)
    {
        $website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$httpUrl = $this->input->post('httpUrl');
		echo $component_background = $this->input->post('component-background');
		$color = $this->input->post('gallery_image_background_color');
		$image = $this->input->post('image');
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$gallery_background = str_replace($find_url, "", $image);
		else :
			$gallery_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;		
		
		
		
		
      $key = array(
			'row_count',
			'component_background',
			'gallery_image_background'
		);
        $value[]    = $this->input->post('gallery_row_count');
        $value[]    = $component_background;
		$value[]    = $gallery_background;
        
        // Convert to JSON data
        
        $keyJSON   = json_encode($key);
        $valueJSON = json_encode($value);
        $gallerys  = $this->get_gallery_setting_details($website_id, $page_id, 'gallery_customize');
        if (empty($gallerys)):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'code' => 'gallery_customize',
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
                'code' => 'gallery_customize',
                'page_id' => $page_id
            ));
		
            $this->session->set_flashdata('success', 'Successfully Updated');
            return $this->db->update($this->setting_table, $update_data);
        endif;
    }
    
    // Insert Update Gallery
    
    function insert_update_gallery_data($page_id, $id = NULL)
    {
        $website_folder_name = $this->admin_header->website_folder_name();
        $status              = $this->input->post('status');
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
                'page_id' => $page_id,
                'category_id' => $this->input->post('category'),
                'image' => $image,
                'image_title' => $this->input->post('image-title'),
                'image_alt' => $this->input->post('image-alt'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Gallery
            $this->db->insert($this->table_name, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'category_id' => $this->input->post('category'),
                'image' => $image,
                'image_title' => $this->input->post('image-title'),
                'image_alt' => $this->input->post('image-alt'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Gallery
            $this->db->where('id', $id);
            $this->db->where('page_id', $page_id);
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    
    // Delete Gallery
    
    function delete_gallery($page_id)
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
    
    // Delete mulitple Gallery
    
    function delete_multiple_gallery()
    {
        $gallerys = $this->input->post('table_records');
        $page_id  = $this->input->post('page_id');
        foreach ($gallerys as $gallery):
            $this->db->where(array(
                'id' => $gallery,
                'page_id' => $page_id
            ));
            $this->db->update($this->table_name, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    // Update Gallery Sort Order
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
    
    // Update Gallery Category Sort Order
    function update_category_sort_order($page_id, $row_sort_orders)
    {
        if (!empty($row_sort_orders)):
            $i = 1;
            foreach ($row_sort_orders as $row_sort_order):
                $this->db->where('id', $row_sort_order);
                $this->db->update($this->category_table, array(
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