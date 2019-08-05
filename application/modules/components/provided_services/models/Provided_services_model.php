<?php
/**
 * Provided Services Models
 *
 * @category Model
 * @package  Provided Services
 * @author   Saravana
 * Created at:  08-Dec-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Provided_services_model extends CI_Model
{
	private $table_name = 'provided_services';
	private $setting_table	= 'setting';

	/**
	 * Get Provided Services
	 * return output as stdClass Object array
	 */
	function get_provided_services($page_id)
	{
		$sql_query = "SELECT
				a.title,
				a.url,
				c.title_color
		FROM
				".$this->db->dbprefix('pages')." a,
				".$this->db->dbprefix('cities')." b,
				".$this->db->dbprefix('provided_services')." c
		WHERE
			FIND_IN_SET(a.id, c.new_page_id)
		AND
			a.status = '1'
		AND
			a.is_deleted = '0'
		AND
			c.page_id = $page_id
		AND
			b.id = c.city_id";

		$query = $this->db->query($sql_query);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}
}
