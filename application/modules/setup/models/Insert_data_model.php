<?php
/**
 * Insert Data Model
 * Created at : 03-Nov-2018
 * Author : Saravana
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Insert_data_model extends CI_Model
{
  // Insert Data

	function insertData()
	{
			// Admin user Table

			$insert_admin_user = array(
					array(
							'id' => '1',
							'first_name' => 'Super',
							'last_name' => 'Admin',
							'username' => 'superadmin',
							'password' => '048ba696c5534315fe409b62e564da7a',
							'email' => 'athinarayanan@desss.com',
							'user_image' => '',
							'gender' => '',
							'user_role_id' => '1',
							'website_id' => '0',
							'created_at' => date('m-d-Y')
					),
					array(
							'id' => '2',
							'first_name' => 'Developer',
							'last_name' => 'Php',
							'username' => 'php',
							'password' => 'e1bfd762321e409cee4ac0b6e841963c',
							'email' => 'saravana@desss.com',
							'user_image' => '',
							'gender' => '',
							'user_role_id' => '3',
							'website_id' => '1',
							'created_at' => date('m-d-Y')
					)
			);
			$this->db->insert_batch('admin_user', $insert_admin_user);

			// Admin Group Tables

			$insert_admin_user_role = array(
					array(
							'user_role_id' => '1',
							'user_role_name' => 'Super Admin',
							'user_role' => 'super_admin',
							'add' => '1',
							'edit' => '1',
							'view' => '1',
							'delete' => '1',
							'publish' => '1',
							'active' => '1',
							'created_at' => date('m-d-Y')
					),
					array(
							'user_role_id' => '2',
							'user_role_name' => 'Admin',
							'user_role' => 'admin',
							'add' => '1',
							'edit' => '1',
							'view' => '1',
							'delete' => '1',
							'publish' => '1',
							'active' => '1',
							'created_at' => date('m-d-Y')
					),
					array(
							'user_role_id' => '3',
							'user_role_name' => 'Developer',
							'user_role' => 'developer',
							'add' => '1',
							'edit' => '1',
							'view' => '1',
							'delete' => '1',
							'publish' => '1',
							'active' => '1',
							'created_at' => date('m-d-Y')
					)
			);
			$this->db->insert_batch('admin_user_role', $insert_admin_user_role);

			// Components Tables

			$insert_components = array(
					array(
							'name' => 'Introduction',
							'url' => 'introduction/introduction_index',
							'status' => '1'
					),
					array(
							'name' => 'Text & Image',
							'url' => 'text_image/text_image_index',
							'status' => '1'
					),
					array(
							'name' => 'Text Full Width',
							'url' => 'text_full_width/text_full_width_index',
							'status' => '1'
					),
					array(
							'name' => 'Banner',
							'url' => 'banner/banner_index',
							'status' => '1'
					),
					array(
							'name' => 'Conclusion',
							'url' => 'conclusion/conclusion_index',
							'status' => '1'
					)
			);
			$this->db->insert_batch('components', $insert_components);

			// Page Components
			$insert_page_components = array(
					array(
							'page_id' => '1',
							'component_name' => 'Introduction',
							'component_id' => '1',
							'sort_order' => '0',
							'status' => '1'
					),
					array(
							'page_id' => '1',
							'component_name' => 'Text & Image',
							'component_id' => '2',
							'sort_order' => '0',
							'status' => '1'
					),
					array(
							'page_id' => '1',
							'component_name' => 'Text Full Width',
							'component_id' => '3',
							'sort_order' => '0',
							'status' => '1'
					),
					array(
							'page_id' => '1',
							'component_name' => 'Banner',
							'component_id' => '4',
							'sort_order' => '1',
							'status' => '1'
					),
					array(
							'page_id' => '1',
							'component_name' => 'Conclusion',
							'component_id' => '5',
							'sort_order' => '0',
							'status' => '1'
					)
			);
			$this->db->insert_batch('page_components', $insert_page_components);

			// Page Detail
			$insert_pages_detail = array(
					'website_id' => '1',
					'title' => 'index',
					'url' => 'index.html',
					'component_id' => '1,2,3,4,5',
					'status' => '1',
					'publish' => '0',
					'is_deleted' => '0',
					'created_at' => date('m-d-Y')
			);
			$this->db->insert('pages', $insert_pages_detail);

			// Header
			$insert_header = array(
					array(
							'website_id' => '1',
							'title' => 'Logo',
							'url' => 'logo',
							'status' => '1'
					),
					array(
							'website_id' => '1',
							'title' => 'Menu',
							'url' => 'menu',
							'status' => '1'
					)
			);
			$this->db->insert('header', $insert_header);

			// Footer
			$insert_footer = array(
					array(
							'website_id' => '1',
							'title' => 'Logo',
							'url' => 'logo',
							'status' => '1'
					),
					array(
							'website_id' => '1',
							'title' => 'Footer Menu',
							'url' => 'footer_menu',
							'status' => '1'
					),
					array(
							'website_id' => '1',
							'title' => 'Footer Copyrights',
							'url' => 'copyrights',
							'status' => '1'
					)
			);
			$this->db->insert('footer', $insert_footer);
	}
}
