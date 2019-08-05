<?php
/**
 * Export Website Model
 *
 * @category Model
 * @package Export Website Model
 * @author Saravana
 * created at : 13-Feb-2019
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed !');
class Export_website_model extends CI_Model
{
    function export($website_id)
    {
        $this->get_main_table_with_data(array(
            array(
                'table' => 'pages',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'admin_menu',
                'where' => array()
            ),
            array(
                'table' => 'admin_menu_group',
                'where' => array()
            ),
            array(
                'table' => 'admin_user_log',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'admin_user_role',
                'where' => array()
            ),
            array(
                'table' => 'blog',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'blog_category',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'blog_pages',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'blog_rating',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'center_tab',
                'where' => array(
                    'website_id' => $website_id
                )
            ) ,
            array(
                'table' => 'cities',
                'where' => array()
            ),
            array(
                'table' => 'color',
                'where' => array()
            ),
            array(
                'table' => 'common_components',
                'where' => array()
            ),
            array(
                'table' => 'components',
                'where' => array()
            ),
            array(
                'table' => 'contact_information',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'contact_us',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'contact_us_form',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'description_content',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'event',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'event_calendar',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'event_category',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'event_pages',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'footer',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'footer_menu_group',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'gallery_category',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'header',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'image_content_slider',
                'where' => array(
                    'website_id' => $website_id
                )
            ) ,
            array(
                'table' => 'mail_configuration',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'menu_group',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'numbers',
                'where' => array()
            ),
            array(
                'table' => 'provided_services',
                'where' => array(
                    'website_id' => $website_id
                )
            ) ,
            array(
                'table' => 'setting',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'social_media',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'tab',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'testimonial',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'testimonial_pages',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'theme',
                'where' => array()
            ),
            array(
                'table' => 'top_header',
                'where' => array(
                    'website_id' => $website_id
                )
            ),
            array(
                'table' => 'vertical_tab',
                'where' => array(
                    'website_id' => $website_id
                )
            ) ,
            array(
                'table' => 'websites',
                'where' => array(
                    'id' => $website_id
                )
            )
        ));
    }
    
    function get_main_table_with_data($table_content)
    {
        $content = '';
        
        if (!empty($table_content)) {
            foreach ($table_content as $data) {
                $this->db->select('*');
                if (!empty($data['where'])):
                    $this->db->where($data['where']);
                endif;
                $result     = $this->db->get($data['table']);
                $rows       = $result->result_array();
                $res        = $this->db->query("SHOW CREATE TABLE `" . $this->db->dbprefix($data['table']) . "`");
                $TableMLine = $res->result_array();
                $content    = (!isset($content) ? '' : $content) . "\n\n" . $TableMLine[0]['Create Table'] . ";\n\n";
                foreach ($rows as $row) {
                    $content .= "INSERT INTO `" . $this->db->dbprefix($data['table']) . "` ( `" . implode('`, `', array_keys($row)) . "` ) VALUES ( '" . implode('\', \'', array_values($row)) . "' );\n";
                }
                
                $content .= "\n\n\n";
            }
        }
        
        $file_name = "database-backup-one.sql";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$file_name."\"");  
        echo $content; exit;
        
    }
    
    function export_test($website_id)
    {
        $this->test('pages', 'id', $website_id, array(
            array(
                'table' => 'banner',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'center_tab_text_image',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'circular_image',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'conclusion',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'counter',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'gallery',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'h1_and_h2',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'image_card',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'introduction',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'map',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'newsletter',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'our_service',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'page_components',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'seo',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'seo_result',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'seo_screen_formula',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'table_grid',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'tab_text_full_width',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'tab_text_image',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'text_full_width',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'text_icon',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'text_image',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'text_image_slider',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'vertical_tab_text_full_width',
                'where' => array(
                    'page_id'
                )
            ),
            array(
                'table' => 'vertical_tab_text_image',
                'where' => array(
                    'page_id'
                )
            )
            
        ));
    }
    
    function test($table, $main_table_where_cond, $website_id, $datas)
    {
        $content = '';
        
        if (!empty($datas)) {
            foreach ($datas as $data) {
                $this->db->select('*');
                if (is_array($data['where'])) {
                    foreach ($data['where'] as $where) {
                        $this->db->join($data['table'], "'" . $this->db->dbprefix($table) . "." . $main_table_where_cond . " = " . $this->db->dbprefix($data['table']) . '.' . $where . "'");
                    }
                }
                $this->db->where('website_id', $website_id);
                $result = $this->db->get($table);
                
                $res        = $this->db->query("SHOW CREATE TABLE `" . $this->db->dbprefix($data['table']) . "`");
                $TableMLine = $res->result_array();
                $content    = (!isset($content) ? '' : $content) . "\n\n" . $TableMLine[0]['Create Table'] . ";\n\n";
                
                if ($result->num_rows() > 0) {
                    $rows = $result->result_array();
                    foreach ($rows as $row) {
                        $content .= "INSERT INTO `" . $this->db->dbprefix($data['table']) . "` ( `" . implode('`, `', array_keys($row)) . "` ) VALUES ( '" . implode('\', \'', array_values($row)) . "' );\n";
                    }
                }
                
                $content .= "\n\n";
            }
        }

        $file_name = "database-backup-two.sql";
                
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$file_name."\"");  
        echo $content; exit;
    }
}