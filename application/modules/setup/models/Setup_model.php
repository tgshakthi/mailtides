<?php
/**
 * Setup Model
 * Created at : 12-Mar-2018
 * Author : Saravana
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Setup_model extends CI_Model
{
    function CreateTable()
    {
        $this->load->dbforge();

        // Create Tables
        // Admin user Table

        $adminfields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default' => NULL
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default' => NULL
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => NULL
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => NULL
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => NULL
            ),
            'user_image' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => NULL
            ),
            'gender' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => NULL
            ),
            'user_role_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'website_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => NULL
            ),
            'is_deleted' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP'
            )
        );
        $this->dbforge->add_field($adminfields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("admin_user", TRUE);

        // Website Table

        $website_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'website_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => NULL
            ),
            'website_url' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => NULL
            ),
            'favicon' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'logo' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'components' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'theme' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => 2,
                'default' => 0
            ),
            'is_deleted' => array(
                'type' => 'TINYINT',
                'constraint' => 2,
                'default' => 0
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($website_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("websites", TRUE);

        // Admin User Role Table

        $admin_groupfields = array(
            'user_role_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'user_role_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => NULL
            ),
            'user_role' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => TRUE,
                'default' => NULL
            ),
            'add' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'edit' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'view' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'delete' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'publish' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'active' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'is_deleted' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($admin_groupfields);

        // define primary key

        $this->dbforge->add_key('user_role_id', TRUE);

        // create table

        $this->dbforge->create_table("admin_user_role", TRUE);

        // Admin menu table

        $admin_menu_fields = array(
            'menu_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'website_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ),
            'menu_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => NULL
            ),
            'menu_icon' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'default' => NULL
            ),
            'menu_url' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'default' => NULL
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => 2,
                'default' => 0
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'default' => 0
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($admin_menu_fields);

        // define primary key

        $this->dbforge->add_key('menu_id', TRUE);

        // create table

        $this->dbforge->create_table("admin_menu", TRUE);

        // Admin menu group Table

        $admin_menu_group_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'user_role_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'menu_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'parent_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'sort_order' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            )
        );
        $this->dbforge->add_field($admin_menu_group_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("admin_menu_group", TRUE);

        // Admin User Log Table

        $admin_user_log_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'website_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'session_id' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'login_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($admin_user_log_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("admin_user_log", TRUE);

        // Banner Table

        $banner_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default' => NULL
            ),
            'title_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default' => NULL
            ),
            'text' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'text_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'image' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'image_alt' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'image_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'text_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'readmore_btn' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'button_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => NULL
            ),
            'btn_background_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'readmore_label' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'label_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'readmore_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'open_new_tab' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'background_hover' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'text_hover' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'readmore_character' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'border' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'border_size' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'border_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'sort_order' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'is_deleted' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($banner_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("banner", TRUE);

        // Color Table

        $color_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'color_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'color_class' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'color_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($color_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("color", TRUE);

        // Components Table

        $components_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => '0'
            ),
            'created_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($components_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("components", TRUE);

        // Conclusion Table

        $conclusion_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'text' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'title_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'title_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'content_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'content_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'background_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($conclusion_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("conclusion", TRUE);

        // Introduction Table

        $introduction_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'text' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'title_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'title_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'content_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'content_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => NULL
            ),
            'background_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($introduction_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("introduction", TRUE);

        // Pages Table

        $pages_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'website_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default' => NULL
            ),
            'url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'component_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => '0'
            ),
            'publish' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => '0'
            ),
            'is_deleted' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => '0'
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($pages_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("pages", TRUE);

        // Page Components Table

        $page_components_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'component_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'default' => NULL
            ),
            'component_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'sort_order' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => '0'
            )
        );
        $this->dbforge->add_field($page_components_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("page_components", TRUE);

        // SEO Table

        $seo_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'h1_tag' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'h2_tag' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'page_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'meta_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'meta_description' => array(
                'type' => 'VARCHAR',
                'constraint' => '250',
                'default' => NULL
            ),
            'meta_keyword' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'meta_misc' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($seo_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("seo", TRUE);

        // Setting Table

        $setting_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'website_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'code' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'key' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'value' => array(
                'type' => 'TEXT',
                'default' => NULL
            )
        );
        $this->dbforge->add_field($setting_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("setting", TRUE);


        // Text Full Width Table

        $text_full_width_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => '0'
            ),
            'title_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'title_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'full_text' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'content_title_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'content_title_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'content_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'content_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'background_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($text_full_width_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("text_full_width", TRUE);

        // Text Image Table

        $text_image_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'title_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'title_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'text' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'content_title_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'content_title_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'content_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'background_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'image' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'image_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'image_alt' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'template' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'image_position' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'image_size' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'readmore_btn' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'button_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'btn_background_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'readmore_label' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'label_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'readmore_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'open_new_tab' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => '0'
            ),
            'background_hover' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'text_hover' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => '0'
            ),
            'readmore_character' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'border' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => '0'
            ),
            'border_size' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'border_color' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => NULL
            ),
            'sort_order' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => '0'
            ),
            'is_deleted' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => '0'
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($text_image_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("text_image", TRUE);

        // Header Table

        $mail_configuration_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'host' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => '0'
            ),
            'port_no' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'mail_from' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => 0
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($mail_configuration_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("mail_configuration", TRUE);

        // Header Table

        $header_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'website_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => 0
            )
        );
        $this->dbforge->add_field($header_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("header", TRUE);

        // Footer Table

        $footer_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'website_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '2',
                'default' => 0
            )
        );
        $this->dbforge->add_field($footer_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("footer", TRUE);

        // Header menu group Table

        $menu_group_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'website_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'parent_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'sort_order' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            )
        );
        $this->dbforge->add_field($menu_group_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("menu_group", TRUE);

        // Footer menu group Table

        $footer_menu_group_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'website_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'page_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'parent_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            ),
            'sort_order' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0'
            )
        );
        $this->dbforge->add_field($footer_menu_group_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("footer_menu_group", TRUE);

        // Theme Table

        $theme_fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => NULL
            ),
            'image' => array(
                'type' => 'TEXT',
                'default' => NULL
            ),
            'created_at' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => NULL
            ),
            'updated_at' => array(
                'type' => 'TIMESTAMP'
            )
        );
        $this->dbforge->add_field($theme_fields);

        // define primary key

        $this->dbforge->add_key('id', TRUE);

        // create table

        $this->dbforge->create_table("theme", TRUE);

    }
}
