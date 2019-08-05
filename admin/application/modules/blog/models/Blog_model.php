<?php
/**
 * Blog Models
 *
 * @category Model
 * @package  Blog
 * @author   Athi
 * Created at:  10-Jul-2018
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Blog_model extends CI_Model
{
    private $table_name = 'blog';
    private $table_blog_category = 'blog_category';
    private $table_blog_pages = 'blog_pages';
    private $table_blog_rating = 'blog_rating';
    private $table_blog_rating_form = 'blog_rating_form';
    private $table_numbers = 'numbers';
    private $table_rating_mail_configure = 'rating_mail_configure';
    
    /**
     * Get Blog
     * return output as stdClass Object array
     */
    function get_blog($website_id)
    {
        $this->db->select(array(
            'id',
            'category_id',
            '(SELECT name FROM ' . $this->db->dbprefix($this->table_blog_category) . ' WHERE id = ' . $this->db->dbprefix($this->table_name) . '.category_id) as name',
            'title',
            'image',
            'sort_order',
            'status'
        ));
        $this->db->where(array(
            'website_id' => $website_id,
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
    
    /**
     * Get Blog by @param
     * return output as stdClass Object array
     */
    function get_blog_by_id($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    /**
     * Get Blog Page
     * return output as stdClass Object array
     */
    function get_blog_page($website_id, $page_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
            'page_id' => $page_id
        ));
        $this->db->order_by('id', 'desc');
        $query   = $this->db->get($this->table_blog_pages);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    /**
     * Get Blog Page by @param
     * return output as stdClass Object array
     */
    function get_blog_page_by_id($website_id, $page_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
            'page_id' => $page_id
        ));
        $this->db->order_by('id', 'desc');
        $query   = $this->db->get($this->table_blog_pages);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    /**
     * Get Blog Rating
     * return output as stdClass Object array
     */
    function get_blog_rating($website_id, $blog_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
            'blog_id' => $blog_id,
            'is_deleted' => 0
        ));
        $this->db->order_by('id', 'desc');
        $query   = $this->db->get($this->table_blog_rating);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    /**
     * Get Blog Rating by @param
     * return output as stdClass Object array
     */
    function get_blog_rating_by_id($blog_id, $id, $website_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'blog_id' => $blog_id,
            'id' => $id,
            'website_id' => $website_id
        ));
        $query   = $this->db->get($this->table_blog_rating);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    /**
     * Get Blog Rating Form
     * return output as stdClass Object array
     */
    function blog_rating_form($website_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
            'status' => 1
        ));
        $query   = $this->db->get($this->table_blog_rating_form);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Unselected Blogs
    function get_blog_unselected($website_id, $page_id)
    {
        $query = $this->db->query('
            SELECT 
                a.id, (SELECT name FROM ' . $this->db->dbprefix($this->table_blog_category) . ' WHERE id = a.category_id) as name, a.title 
            FROM 
                ' . $this->db->dbprefix($this->table_name) . ' a, ' . $this->db->dbprefix($this->table_blog_pages) . ' b 
            WHERE 
                b.page_id = ' . $page_id . ' AND
                a.website_id = ' . $website_id . ' AND 
                a.status = 1 AND 
                a.is_deleted = 0 AND 
                b.website_id = ' . $website_id . ' AND 
                !FIND_IN_SET(a.id, b.blog_id)');
        
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Selected Blogs
    function get_blog_selected($website_id, $page_id)
    {
        $query = $this->db->query("
            SELECT
                a.id,
                (SELECT name FROM " . $this->db->dbprefix($this->table_blog_category) . " WHERE id = a.category_id) as name,
                a.title
              FROM
                " . $this->db->dbprefix($this->table_numbers) . " c
            INNER JOIN 
                " . $this->db->dbprefix($this->table_blog_pages) . " b
            ON 
                CHAR_LENGTH(b.blog_id) - CHAR_LENGTH(REPLACE(b.blog_id, ',', '')) >= c.n - 1 
            INNER JOIN 
                " . $this->db->dbprefix($this->table_name) . " a 
            ON 
                SUBSTRING_INDEX(SUBSTRING_INDEX(b.blog_id, ',', c.n), ',', -1) = a.id 
               WHERE 
                a.website_id = " . $website_id . " 
            AND 
                a.status = 1 
            AND 
                a.is_deleted = 0 
            AND 
                b.website_id = " . $website_id . " 
            AND 
                b.page_id = " . $page_id . "
        ");
        
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Unselected Blogs Category
    function get_blog_category_unselected($website_id, $page_id)
    {
        $query = $this->db->query('
            SELECT 
                a.id, a.name
            FROM 
                ' . $this->db->dbprefix($this->table_blog_category) . ' a, ' . $this->db->dbprefix($this->table_blog_pages) . ' b 
            WHERE 
                b.page_id = ' . $page_id . ' AND
                a.website_id = ' . $website_id . ' AND 
                a.status = 1 AND 
                a.is_deleted = 0 AND 
                b.website_id = ' . $website_id . ' AND 
                !FIND_IN_SET(a.id, b.blog_category)');
        
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Selected Blogs Category
    function get_blog_category_selected($website_id, $page_id)
    {
        $query = $this->db->query("
            SELECT
                a.id,
                a.name
              FROM
                " . $this->db->dbprefix($this->table_numbers) . " c
            INNER JOIN 
                " . $this->db->dbprefix($this->table_blog_pages) . " b
            ON 
                CHAR_LENGTH(b.blog_category) - CHAR_LENGTH(REPLACE(b.blog_category, ',', '')) >= c.n - 1 
            INNER JOIN 
                " . $this->db->dbprefix($this->table_blog_category) . " a 
            ON 
                SUBSTRING_INDEX(SUBSTRING_INDEX(b.blog_category, ',', c.n), ',', -1) = a.id 
               WHERE 
                a.website_id = " . $website_id . " 
            AND 
                a.status = 1 
            AND 
                a.is_deleted = 0 
            AND 
                b.website_id = " . $website_id . " 
            AND 
                b.page_id = " . $page_id . "
        ");
        
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Insert Update Blog
    function insert_update_blog_rating_customize($id = NULL)
    {
        $website_id = $this->input->post('website_id');
        $border     = $this->input->post('border');
        $status     = $this->input->post('status');
        
        $border = (isset($border)) ? '1' : '0';
        $status = (isset($status)) ? '1' : '0';
        
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'title' => $this->input->post('title'),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'title_hover' => $this->input->post('title_hover'),
                'label_color' => $this->input->post('label_color'),
                'comment_name_color' => $this->input->post('comment_name_color'),
                'label_hover' => $this->input->post('label_hover'),
                'comment_text_color' => $this->input->post('comment_text_color'),
                'button_label' => $this->input->post('button_label'),
                'button_type' => $this->input->post('button_type'),
                'button_position' => $this->input->post('button_position'),
                'button_background_color' => $this->input->post('button_background_color'),
                'button_label_color' => $this->input->post('button_label_color'),
                'button_background_hover' => $this->input->post('button_background_hover'),
                'button_label_hover' => $this->input->post('button_label_hover'),
                'border' => $border,
                'border_size' => $this->input->post('border_size'),
                'border_color' => $this->input->post('border_color'),
                'border_hover' => $this->input->post('border_hover'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Blog
            $this->db->insert($this->table_blog_rating_form, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'title' => $this->input->post('title'),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'title_hover' => $this->input->post('title_hover'),
                'label_color' => $this->input->post('label_color'),
                'comment_name_color' => $this->input->post('comment_name_color'),
                'label_hover' => $this->input->post('label_hover'),
                'comment_text_color' => $this->input->post('comment_text_color'),
                'button_label' => $this->input->post('button_label'),
                'button_type' => $this->input->post('button_type'),
                'button_position' => $this->input->post('button_position'),
                'button_background_color' => $this->input->post('button_background_color'),
                'button_label_color' => $this->input->post('button_label_color'),
                'button_background_hover' => $this->input->post('button_background_hover'),
                'button_label_hover' => $this->input->post('button_label_hover'),
                'border' => $border,
                'border_size' => $this->input->post('border_size'),
                'border_color' => $this->input->post('border_color'),
                'border_hover' => $this->input->post('border_hover'),
                'status' => $status
            );
            // Update into Blog
            $this->db->where(array(
                'id' => $id,
                'website_id' => $website_id
            ));
            return $this->db->update($this->table_blog_rating_form, $update_data);
        endif;
    }
    
    // Insert Update Blog
    function insert_update_blog($id = NULL)
    {
        $website_folder_name = $this->admin_header->website_folder_name();
        $website_id          = $this->input->post('website_id');
        $readmore_btn        = $this->input->post('readmore_btn');
        $open_new_tab        = $this->input->post('open_new_tab');
        $border              = $this->input->post('border');
        $status              = $this->input->post('status');
        
        $readmore_btn = (isset($readmore_btn)) ? '1' : '0';
        $open_new_tab = (isset($open_new_tab)) ? '1' : '0';
        $border       = (isset($border)) ? '1' : '0';
        $status       = (isset($status)) ? '1' : '0';
        
        $image   = $this->input->post('image');
        $background_image = $this->input->post('background-image');        
        $httpUrl = $this->input->post('httpUrl');
        
        // Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $image    = str_replace($find_url, "", $image);

        // Background Image
        if (isset($background_image) && !empty($background_image)) :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$blog_detail_background_image = str_replace($find_url, "", $background_image);
        endif;
        
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'category_id' => $this->input->post('category'),
                'image' => $image,
                'image_title' => $this->input->post('image_title'),
                'image_alt' => $this->input->post('image_alt'),
                'title' => $this->input->post('title'),
                'short_description' => $this->input->post('short_description'),
                'description' => $this->input->post('description'),
                'date' => $this->input->post('create_date'),
                'created_by' => $this->input->post('created_by'),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'short_description_title_color' => $this->input->post('short_description_title_color'),
                'short_description_title_position' => $this->input->post('short_description_title_position'),
                'short_description_color' => $this->input->post('short_description_color'),
                'short_description_position' => $this->input->post('short_description_position'),
                'description_title_color' => $this->input->post('description_title_color'),
                'description_title_position' => $this->input->post('description_title_position'),
                'description_color' => $this->input->post('description_color'),
                'description_position' => $this->input->post('description_position'),
                'date_color' => $this->input->post('date_color'),
                'title_hover_color' => $this->input->post('title_hover_color'),
                'short_description_title_hover_color' => $this->input->post('short_description_title_hover_color'),
                'short_description_hover_color' => $this->input->post('short_description_hover_color'),
                'short_description_background_hover_color' => $this->input->post('short_description_background_hover_color'),
                'description_title_hover_color' => $this->input->post('description_title_hover_color'),
                'description_hover_color' => $this->input->post('description_hover_color'),
                'description_background_hover_color' => $this->input->post('description_background_hover_color'),
                'blog_url' => $this->input->post('blog_url'),
                'open_new_tab' => $open_new_tab,
                'background_color' => $this->input->post('background_color'),
                'background_image' => $blog_detail_background_image,
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            
            // Insert into Blog
            $this->db->insert($this->table_name, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'category_id' => $this->input->post('category'),
                'image' => $image,
                'image_title' => $this->input->post('image_title'),
                'image_alt' => $this->input->post('image_alt'),
                'title' => $this->input->post('title'),
                'short_description' => $this->input->post('short_description'),
                'description' => $this->input->post('description'),
                'date' => $this->input->post('create_date'),
                'created_by' => $this->input->post('created_by'),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'short_description_title_color' => $this->input->post('short_description_title_color'),
                'short_description_title_position' => $this->input->post('short_description_title_position'),
                'short_description_color' => $this->input->post('short_description_color'),
                'short_description_position' => $this->input->post('short_description_position'),
                'description_title_color' => $this->input->post('description_title_color'),
                'description_title_position' => $this->input->post('description_title_position'),
                'description_color' => $this->input->post('description_color'),
                'description_position' => $this->input->post('description_position'),
                'date_color' => $this->input->post('date_color'),
                'title_hover_color' => $this->input->post('title_hover_color'),
                'short_description_title_hover_color' => $this->input->post('short_description_title_hover_color'),
                'short_description_hover_color' => $this->input->post('short_description_hover_color'),
                'short_description_background_hover_color' => $this->input->post('short_description_background_hover_color'),
                'description_title_hover_color' => $this->input->post('description_title_hover_color'),
                'description_hover_color' => $this->input->post('description_hover_color'),
                'description_background_hover_color' => $this->input->post('description_background_hover_color'),
                'blog_url' => $this->input->post('blog_url'),
                'open_new_tab' => $open_new_tab,
                'background_color' => $this->input->post('background_color'),
                'background_image' => $blog_detail_background_image,
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Blog
            $this->db->where(array(
                'id' => $id,
                'website_id' => $website_id
            ));
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    
    // Insert Update Blog
    function insert_update_blog_page($id = NULL)
    {
        $website_folder_name  = $this->admin_header->website_folder_name();
        $httpUrl              = $this->input->post('httpUrl');
        $component_background = $this->input->post('component-background');
        $color                = $this->input->post('blog_background_color');
        $image                = $this->input->post('image');
        
        if (isset($image) && !empty($image) && $component_background == 'image'):
        // Remove Host URL in image
            
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;            
            $find_url        = $httpUrl . '/images/' . $website_folder_name . '/';
            $blog_background = str_replace($find_url, "", $image);
        else:
            $blog_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : '';
        endif;
        
        // Blog Background
        $blog_bg = array(
            'component_background' => $component_background,
            'blog_background' => $blog_background
        );
        
        $show_blog = $this->input->post('show_blog');
        if ($show_blog == 'blog'):
            $data_array = $this->input->post('output_update');
            $result     = json_decode($data_array);
        else:
            $data_array = $this->input->post('output_category_update');
            $result     = json_decode($data_array);
        endif;
        
        $blogs = (!empty($result)) ? implode(',', array_column($result, 'id')) : '';
        
        $website_id = $this->input->post('website_id');
        $page_id    = $this->input->post('page_id');
        $status     = $this->input->post('status');
        $status     = (isset($status)) ? '1' : '0';
        
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'page_id' => $page_id,
                'blog' => $this->input->post('show_blog'),
                'title' => $this->input->post('title'),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'blog_per_row' => $this->input->post('blog_per_row'),
                'background' => json_encode($blog_bg),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
            if ($show_blog == 'blog'):
                $insert_data = array_merge($insert_data, array(
                    'blog_id' => $blogs
                ));
            else:
                $insert_data = array_merge($insert_data, array(
                    'blog_category' => $blogs
                ));
            endif;
            
            
            // Insert into Blog Page
            
            $this->db->insert($this->table_blog_pages, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'blog' => $this->input->post('show_blog'),
                'title' => $this->input->post('title'),
                'title_color' => $this->input->post('title_color'),
                'title_position' => $this->input->post('title_position'),
                'blog_per_row' => $this->input->post('blog_per_row'),
                'background' => json_encode($blog_bg),
                'status' => $status
            );
            if ($show_blog == 'blog'):
                $update_data = array_merge($update_data, array(
                    'blog_id' => $blogs
                ));
            else:
                $update_data = array_merge($update_data, array(
                    'blog_category' => $blogs
                ));
            endif;
            
            // Update into Blog Page
            
            $this->db->where(array(
                'id' => $id,
                'website_id' => $website_id,
                'page_id' => $page_id
            ));
            return $this->db->update($this->table_blog_pages, $update_data);
        endif;
    }
    
    // Insert Update Blog Rating
    function insert_update_blog_rating($blog_id, $id = NULL)
    {
        $website_id = $this->input->post('website_id');
        $status     = $this->input->post('status');
        $status     = (isset($status)) ? '1' : '0';
        
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'rating' => $this->input->post('rating'),
                'comment' => $this->input->post('comment'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Blog Rating
            $this->db->insert($this->table_blog_rating, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'rating' => $this->input->post('rating'),
                'comment' => $this->input->post('comment'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Blog Rating
            $this->db->where(array(
                'id' => $id,
                'blog_id' => $blog_id,
                'website_id' => $website_id
            ));
            return $this->db->update($this->table_blog_rating, $update_data);
        endif;
    }
    
    // Insert Update Blog SEO
    function insert_update_blog_seo($id = NULL)
    {
        $website_id = $this->input->post('website_id');
        
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'meta_title' => $this->input->post('meta_title'),
                'meta_keyword' => $this->input->post('meta_keyword'),
                'meta_description' => $this->input->post('meta_description'),
                'created_at' => date('m-d-Y')
            );
        // Insert into Blog
            $this->db->insert($this->table_name, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'meta_title' => $this->input->post('meta_title'),
                'meta_keyword' => $this->input->post('meta_keyword'),
                'meta_description' => $this->input->post('meta_description')
            );
            // Update into Blog
            $this->db->where(array(
                'id' => $id,
                'website_id' => $website_id
            ));
            return $this->db->update($this->table_name, $update_data);
        endif;
    }
    
    // Inser Update Blog Category
    function insert_update_blog_category($id = NULL)
    {
        $website_id = $this->input->post('website_id');
        $status     = $this->input->post('status');
        $status     = (isset($status)) ? '1' : '0';
        
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'name' => $this->input->post('name'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status,
                'created_at' => date('m-d-Y')
            );
        // Insert into Blog Category
            $this->db->insert($this->table_blog_category, $insert_data);
            return $this->db->insert_id();
        else:
            // Update data
            $update_data = array(
                'name' => $this->input->post('name'),
                'sort_order' => $this->input->post('sort_order'),
                'status' => $status
            );
            // Update into Blog Category
            $this->db->where(array(
                'id' => $id,
                'website_id' => $website_id
            ));
            return $this->db->update($this->table_blog_category, $update_data);
        endif;
    }
    
    /**
     * Get Check Blog Category ID by @param
     * return output as stdClass Object array
     */
    function check_blog($id)
    {
        $this->db->select('*');
        $this->db->where('category_id', $id);
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Check Blog Category Duplicate
    
    function check_category_duplicate()
    {
        $category_name = $this->input->post('name');
        $website_id    = $this->input->post('web_id');
        $this->db->select('*');
        $this->db->where(array(
            'name' => $category_name,
            'website_id' => $website_id
        ));
        $query   = $this->db->get($this->table_blog_category);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Update Blog Sort Order
    function update_sort_order($website_id, $row_sort_orders)
    {
        if (!empty($row_sort_orders)):
            $i = 1;
            foreach ($row_sort_orders as $row_sort_order):
                $this->db->where(array(
                    'id' => $row_sort_order,
                    'website_id' => $website_id
                ));
                $this->db->update($this->table_name, array(
                    'sort_order' => $i
                ));
                $i++;
            endforeach;
        endif;
    }
    
    // Update Blog Rating Sort Order
    function update_rating_sort_order($blog_id, $row_sort_orders)
    {
        if (!empty($row_sort_orders)):
            $i = 1;
            foreach ($row_sort_orders as $row_sort_order):
                $this->db->where(array(
                    'id' => $row_sort_order,
                    'blog_id' => $blog_id
                ));
                $this->db->update($this->table_blog_rating, array(
                    'sort_order' => $i
                ));
                $i++;
            endforeach;
        endif;
    }
    
    // Delete Blog
    
    function delete_blog()
    {
        $id = $this->input->post('id');
        $this->db->where(array(
            'id' => $id
        ));
        return $this->db->update($this->table_name, array(
            'is_deleted' => 1
        ));
    }
    
    // Delete mulitple Blog
    
    function delete_multiple_blog()
    {
        $blog_categories = $this->input->post('table_records');
        $website_id      = $this->input->post('website_id');
        foreach ($blog_categories as $blog_category):
            $this->db->where(array(
                'id' => $blog_category,
                'website_id' => $website_id
            ));
            $this->db->update($this->table_name, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    // Delete Blog Rating
    
    function delete_blog_rating($blog_id)
    {
        $id = $this->input->post('id');
        $this->db->where(array(
            'blog_id' => $blog_id,
            'id' => $id
        ));
        return $this->db->update($this->table_blog_rating, array(
            'is_deleted' => 1
        ));
    }
    
    // Delete mulitple Blog
    
    function delete_multiple_blog_rating($blog_id)
    {
        $blog_categories = $this->input->post('table_records');
        $website_id      = $this->input->post('website_id');
        foreach ($blog_categories as $blog_category):
            $this->db->where(array(
                'id' => $blog_category,
                'blog_id' => $blog_id,
                'website_id' => $website_id
            ));
            $this->db->update($this->table_blog_rating, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    function get_admin_user_details($id)
    {
        $this->db->select('username');
        $this->db->where('id', $id);
        $query   = $this->db->get('admin_user');
        $records = array();
        
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        
        return $records;
    }
    
    /**
     * Get Blog Category
     * return output as stdClass Object array
     */
    function get_blog_category($website_id)
    {
        $this->db->select(array(
            'id',
            'name',
            'sort_order',
            'status'
        ));
        $this->db->where(array(
            'website_id' => $website_id,
            'is_deleted' => 0
        ));
        $this->db->order_by('id', 'desc');
        $query   = $this->db->get($this->table_blog_category);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    /**
     * Get Select Blog Category
     * return output as stdClass Object array
     */
    function select_blog_category($website_id, $search)
    {
        $sql_data = "SELECT * FROM " . $this->db->dbprefix($this->table_blog_category) . " WHERE name LIKE '%" . $search . "%' AND website_id = '" . $website_id . "' AND is_deleted = 0";
        $query    = $this->db->query($sql_data);
        $records  = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
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
            'name'
        ));
        $this->db->where('id', $category_id);
        $query   = $this->db->get($this->table_blog_category);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    /**
     * Get Blog Category by @param
     * return output as stdClass Object array
     */
    function get_blog_category_by_id($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query   = $this->db->get($this->table_blog_category);
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Update Blog Category Sort Order
    function update_sort_order_two($website_id, $row_sort_orders)
    {
        if (!empty($row_sort_orders)):
            $i = 1;
            foreach ($row_sort_orders as $row_sort_order):
                $this->db->where(array(
                    'id' => $row_sort_order,
                    'website_id' => $website_id
                ));
                $this->db->update($this->table_blog_category, array(
                    'sort_order' => $i
                ));
                $i++;
            endforeach;
        endif;
    }
    
    // Insert Category
    function insert_category()
    {
        $status = $this->input->post('status');
        $status = (isset($status)) ? '1' : '0';
        
        $insert_data = array(
            'website_id' => $this->input->post('website_id'),
            'name' => $this->input->post('name'),
            'sort_order' => $this->input->post('sort_order'),
            'status' => $status,
            'created_at' => date('m-d-Y')
        );
        
        // Insert into Banner
        
        $this->db->insert($this->table_blog_category, $insert_data);
    }
    
    /**
     * Get Check Blog Category ID by @param
     * return output as stdClass Object array
     */
    function check_blog_category()
    {
        $blog_categories = implode(',', $this->input->post('table_records'));
        $sql_data        = "SELECT * FROM " . $this->db->dbprefix($this->table_name) . " WHERE category_id IN (" . $blog_categories . ")";
        $query           = $this->db->query($sql_data);
        $records         = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    // Delete Blog Category
    
    function delete_blog_category()
    {
        $id = $this->input->post('id');
        $this->db->where(array(
            'id' => $id
        ));
        return $this->db->update($this->table_blog_category, array(
            'is_deleted' => 1
        ));
    }
    
    // Delete mulitple Blog Category
    
    function delete_multiple_blog_category()
    {
        $blog_categories = $this->input->post('table_records');
        $website_id      = $this->input->post('website_id');
        foreach ($blog_categories as $blog_category):
            $this->db->where(array(
                'id' => $blog_category,
                'website_id' => $website_id
            ));
            $this->db->update($this->table_blog_category, array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
    // Remove Image
    
    function remove_blog_image()
    {
        $id           = $this->input->post('id');
        $remove_image = array(
            'image' => ""
        );
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $remove_image);
    }
    
    // Get Mail Configure
    function get_mail_configure($website_id)
    {
        $this->db->select('*');
        $this->db->where('website_id', $website_id);
        $query   = $this->db->get($this->table_rating_mail_configure);
        $records = array();
        
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        
        return $records;
    }
    
    // Insert Update Rating Mail Configure
    function insert_update_rating_mail_configure($website_id, $id = NULL)
    {
        $send_mail_to    = $this->input->post('send_mail_to');
        $status          = $this->input->post('status');
        $carbon_copy_to  = $this->input->post('carbon_copy_to');
        $carbon_copy_cc  = $this->input->post('carbon_copy_cc');
        $carbon_copy_bcc = $this->input->post('carbon_copy_bcc');
        
        $send_mail_to    = (isset($send_mail_to)) ? '1' : '0';
        $status          = (isset($status)) ? '1' : '0';
        $carbon_copy_to  = ($carbon_copy_to != '') ? implode(",", $carbon_copy_to) : '';
        $carbon_copy_cc  = ($carbon_copy_cc != '') ? implode(",", $carbon_copy_cc) : '';
        $carbon_copy_bcc = ($carbon_copy_bcc != '') ? implode(",", $carbon_copy_bcc) : '';
        
        $result      = implode(',', $this->input->post('lable_id'));
        $lable_check = (!empty($this->input->post('lable_check'))) ? implode(',', $this->input->post('lable_check')) : '';
        
        if ($id == NULL):
        // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'mail_subject' => $this->input->post('mail_subject'),
                'from_name' => $this->input->post('from_name'),
                'message_content' => $this->input->post('message_content'),
                'success_title' => $this->input->post('success_title'),
                'success_message' => $this->input->post('success_message'),
                'send_mail_to' => $send_mail_to,
                'to_address' => $carbon_copy_to,
                'cc' => $carbon_copy_cc,
                'bcc' => $carbon_copy_bcc,
                'rating_field' => $result,
                'rating_field_status' => $lable_check,
                'status' => $status,
                'created_at' => date("m-d-Y")
            );
        // Insert into Mail Configure
            $this->db->insert($this->table_rating_mail_configure, $insert_data);
        else:
            // Update data
            $update_data = array(
                'mail_subject' => $this->input->post('mail_subject'),
                'from_name' => $this->input->post('from_name'),
                'message_content' => $this->input->post('message_content'),
                'success_title' => $this->input->post('success_title'),
                'success_message' => $this->input->post('success_message'),
                'send_mail_to' => $send_mail_to,
                'to_address' => $carbon_copy_to,
                'cc' => $carbon_copy_cc,
                'bcc' => $carbon_copy_bcc,
                'rating_field' => $result,
                'rating_field_status' => $lable_check,
                'status' => $status
            );
            // Update into Mail Configure
            $this->db->where(array(
                'id' => $id,
                'website_id' => $website_id
            ));
            $this->db->update($this->table_rating_mail_configure, $update_data);
        endif;
    }
}