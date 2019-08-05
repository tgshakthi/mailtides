<?php
/**
 * Setting Model
 * Created at : 05-June-2018
 * Author : Athi
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model
{
	private $table_name = 'setting';

	// Get Website ID
	public function get_website_id()
	{
		$query = $this->db->query("
			SELECT
		  		id, SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(website_url, '/', 3), 'www.', -1), '/', -1) as url, is_deleted as deleted, status
			FROM
				".$this->db->dbprefix('websites')."
			HAVING
				url = '".str_replace('www.', '', $_SERVER['HTTP_HOST'])."'
			AND
				deleted = 0
			AND
				status = 1"
		);
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}

	// Get Theme
	public function get_theme()
	{
		$query = $this->db->query("
			SELECT
		  		name
			FROM
				".$this->db->dbprefix('theme ')."
			WHERE
				id = ( SELECT
						theme
					   FROM
					   	".$this->db->dbprefix('websites')."
					   WHERE
					   	website_url = '".base_url()."' )"
		);
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}

	// Get Page ID
	public function get_page_id($website_id, $page_url)
	{
		$this->db->select(array('id'));
    	$this->db->where(array('website_id' => $website_id, 'url' => $page_url, 'status' => 1, 'is_deleted' => 0));
    	$query = $this->db->get('pages');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}

	// Get Favicon
	public function get_favicon($website_id)
	{
		$this->db->select(array('favicon'));
    	$this->db->where('id', $website_id);
    	$query = $this->db->get('websites');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}

	// Get Data from setting
	function get_settings_data($field, $id, $code)
	{
		$this->db->select(array('key', 'value'));
		$this->db->where(array($field => $id, 'code' => $code));
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get Website Folder
	function get_website_folder($website_id)
	{
		$this->db->select('folder_name');
		$this->db->where(array(
			'id' => $website_id,
			'status' => '1',
			'is_deleted' => '0'
		));
		$query = $this->db->get('websites');
		$records = array();
		if ($query->num_rows() > 0 ) :
		  $records = $query->result();
		endif;
		return $records;
	}

}
