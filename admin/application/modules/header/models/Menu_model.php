<?php
/**
 * Menu Models
 *
 * @category Model
 * @package  Menu Model
 * @author   Athi
 * Created at:  30-Apr-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Menu_model extends CI_Model
{
	private $table_name = 'menu';
	private $table_setting = 'setting';
	private $table_page = 'pages';

	// Get menu
	function get_menu_data($website_id)
	{
		$this->db->select('menu');
		$this->db->where('website_id', $website_id);
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Get Parent Menu
	function get_parent_menu($website_id, $id)
	{
		$this->db->select('title');
		$this->db->where(array(
			'website_id' => $website_id,
			'id' => $id
		));
		$query = $this->db->get($this->table_page);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	/**
	 * Get Menu from Setting
	 * return output as stdClass Object array
	 */
	function get_menu_setting($website_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => 'menu'
		));
		$query = $this->db->get($this->table_setting);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Get Selected Menu
	function get_selected_menu($website_id)
	{
		$query = $this->db->query("
			SELECT
				b.id,title
			FROM
				" . $this->db->dbprefix('menu_group') . " a
			JOIN
			 	" . $this->db->dbprefix('pages') . " b
			ON
				b.id = a.page_id
			WHERE
				b.website_id = " . $website_id . "
			AND
				a.parent_id = 0
			ORDER BY
				a.sort_order");
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get UnSelected Menu
	function get_unselected_menu($website_id, $selected_menu_id)
	{
		if (!empty($selected_menu_id)):
			$join = "AND id NOT IN (" . implode(',', $selected_menu_id) . ")";
		else:
			$join = '';
		endif;
		$query = $this->db->query("
			SELECT
				id, title
			FROM
				" . $this->db->dbprefix($this->table_page) . "
			WHERE
				website_id = " . $website_id . "
			 AND
				status = 1
			 AND
			 	is_deleted = 0
			 	$join
			 ORDER BY
			 	id");
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Insert Update Menu & Customization
	function insert_menu($website_id, $data)
	{
		$key = array(
			'menu_position',
			'main_menu_text_color',
			'sub_menu_text_color',
			'main_menu_text_hover_color',
			'sub_menu_text_hover_color',
			'main_menu_bg_color',
			'sub_menu_bg_color',
			'main_menu_bg_hover_color',
			'sub_menu_bg_hover_color',
			'status'
		);
		$value[] = $this->input->post('position');
		$value[] = $this->input->post('main_menu_text_color');
		$value[] = $this->input->post('sub_menu_text_color');
		$value[] = $this->input->post('main_menu_text_hover_color');
		$value[] = $this->input->post('sub_menu_text_hover_color');
		$value[] = $this->input->post('main_menu_bg_color');
		$value[] = $this->input->post('sub_menu_bg_color');
		$value[] = $this->input->post('main_menu_bg_hover_color');
		$value[] = $this->input->post('sub_menu_bg_hover_color');
		$status = $this->input->post('status');
		$value[] = (isset($status)) ? '1' : '0';
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		$menus = $this->get_menu_data($website_id);
		if (empty($menus))
		{
			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'menu',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Insert into Menu

			$this->db->insert($this->table_setting, $insert_data);
			$this->db->insert_id();
		}
		else
		{
			// Update data
			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Update
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'menu'
			));
			$this->db->update($this->table_setting, $update_data);
		}

		$menu = $this->get_menu_data($website_id);
		if (empty($menu)):
			$insert_array = array(
				'website_id' => $website_id,
				'menu' => $data
			);
			$this->db->insert($this->table_name, $insert_array);
		else:
			$update_data = array(
				'menu' => $data
			);
			$this->db->where('website_id', $website_id);
			$this->db->update($this->table_name, $update_data);
		endif;
	}
}