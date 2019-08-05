<?php
/**
 * Gallery Models
 *
 * @category Model
 * @package  Gallery
 * @author   Saravana
 * Created at:  13-Jul-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_model extends CI_Model
{
	private $table_name = 'gallery';
	private $category_table = 'gallery_category';
	private $setting_table	= 'setting';

	/**
	 * Get Gallery
	 * return output as stdClass Object array
	 */
	function get_gallery_settings($page_id, $code)
	{
		$this->db->select(array('key', 'value'));
		$this->db->where(array('page_id' => $page_id, 'code' => $code));
		$query = $this->db->get($this->setting_table);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get Gallery
	 * return output as stdClass Object array
	 */
	function get_gallery($page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'page_id' => $page_id,
			'status' => 1,
			'is_deleted' => 0
		));
		$this->db->order_by('sort_order', 'ASC');
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	/**
	 * Get Gallery
	 * return output as stdClass Object array
	 */
	function get_gallery_category($website_id, $page_id)
	{
		$this->db->select(array('category_name', 'gallery_category.id'));
		$this->db->from('gallery_category');
		$this->db->join('gallery', 'gallery_category.id = gallery.category_id');
		$this->db->where('page_id', $page_id);
		$this->db->where('website_id', $website_id);
		$this->db->where('gallery_category.is_deleted', '0');
		$this->db->order_by('gallery_category.sort_order', 'ASC');
		$this->db->group_by('gallery.category_id');
		$query = $this->db->get();
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	function get_tab_gallery_images($page_id, $category_id)
	{
		$sql_query = "SELECT a.* FROM " . $this->db->dbprefix($this->table_name) . " a, " . $this->db->dbprefix($this->category_table) . " b WHERE a.category_id = ".$category_id." AND b.id = ".$category_id." AND a.page_id = ".$page_id." AND a.is_deleted = '0'";
		$query = $this->db->query($sql_query);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
}
?>
