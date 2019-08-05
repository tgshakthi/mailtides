<?php
/**
 * Table Grid Models
 *
 * @category Model
 * @package  Table Grid
 * @author   Saravana
 * Created at:  17-Jul-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Table_grid_model extends CI_Model
{
	private $table_name = 'table_grid';
	private $setting_table	= 'setting';

	/**
	 * Get Table Grid
	 * return output as stdClass Object array
	 */

	function get_table_grid($page_id)
	{
		$this->db->select('*');
		$this->db->where('page_id', $page_id);
		$query = $this->db->get($this->table_name);
		$records = array();

		if ($query->num_rows() > 0) :
				foreach ($query->result() as $row) :
					$records[] = $row;
				endforeach;
		endif;

		return $records;
	}



	/**
	 * Get Table Grid setting Details
	 * return output as stdClass Object array
	 */

	function get_table_grid_setting_details($website_id, $page_id, $code)
	{
		$this->db->select('*');

		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code,
			'page_id' => $page_id
		));

		$query = $this->db->get($this->setting_table);
		$records = array();

		if ($query->num_rows() > 0) :
				foreach ($query->result() as $row) :
					$records[] = $row;
				endforeach;
		endif;

		return $records;
	}

	// Insert Update Table Grid Title Details

	function insert_update_table_grid_title_data($page_id, $id = NULL)
	{
		$key = array(
			'table_grid_title',
			'table_grid_title_color',
			'table_grid_title_position',
			'table_grid_title_status'
		);

		$website_id = $this->input->post('website_id');
		$value[] = $this->input->post('table_grid_title');
		$value[] = $this->input->post('title-color');
		$value[] = $this->input->post('table_grid_title_position');
		$status	= $this->input->post('table_grid_title_status');
		$value[]	= (isset($status)) ? '1' : '0';

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$table_grids = $this->get_table_grid_setting_details($website_id, $page_id, 'table_grid_title');

		if (empty($table_grids)):
			// insert data
			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'table_grid_title',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			$this->db->insert($this->setting_table, $insert_data);
			$this->session->set_flashdata('success', 'Successfully Created');
			return $this->db->insert_id();
		else :
			// Update data
  		$update_data = array(
				'key'   => $keyJSON,
				'value'   => $valueJSON
			);

			$this->db->where(array('website_id' => $website_id, 'code' => 'table_grid_title', 'page_id' => $page_id));
			$this->session->set_flashdata('success', 'Successfully Updated');
      return $this->db->update($this->setting_table, $update_data);
		endif;
	}

	// Insert Update Table Grid Customization

	function insert_update_table_grid_customize_data($page_id)
	{
		//$website_id = $this->input->post('website_id');
		
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$httpUrl = $this->input->post('httpUrl');
		echo $component_background = $this->input->post('component-background');
		$color = $this->input->post('table_grid_background_color');
		$image = $this->input->post('image');
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$table_grid_background = str_replace($find_url, "", $image);
		else :
			$table_grid_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;		
		
		$key = array(
			
			'component_background',
			'table_grid_background'
		);

		
		$value[] = $this->input->post('component-background');
		$value[] = $table_grid_background;

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$table_grids = $this->get_table_grid_setting_details($website_id, $page_id, 'table_grid_customize');

		if (empty($table_grids)):
			// insert data
			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'table_grid_customize',
				'key' => $keyJSON,
				'value' => $valueJSON
			);
			
			$this->db->insert($this->setting_table, $insert_data);
			$this->session->set_flashdata('success', 'Successfully Created');
			return $this->db->insert_id();
		else :
			// Update data
  		$update_data = array(
				'key'   => $keyJSON,
				'value'   => $valueJSON
			);
	
			$this->db->where(array('website_id' => $website_id, 'code' => 'table_grid_customize', 'page_id' => $page_id));
			$this->session->set_flashdata('success', 'Successfully Updated');
      return $this->db->update($this->setting_table, $update_data);
		endif;
	}

	function create_table()
	{
		$id = $this->input->post('id');
		$page_id = $this->input->post('page_id');
		$table_data = $this->input->post('table_data');

		if (empty($id)) :
			$insert_data = array(
				'page_id' => $page_id,
				'no_of_rows' => $this->input->post('no_of_rows'),
				'no_of_cols' => $this->input->post('no_of_cols'),
				'table_content' => $table_data,
				'status' => '1',
				'created_date' => date('m-d-Y')
			);

			$this->db->insert($this->table_name, $insert_data);
		else :
			$updata_data = array(
				'no_of_rows' => $this->input->post('no_of_rows'),
				'no_of_cols' => $this->input->post('no_of_cols'),
				'table_content' => $table_data,
				'status' => '1'
			);

			$this->db->where(array(
				'id' => $id,
				'page_id' => $page_id
			));
			$this->db->update($this->table_name, $updata_data);
		endif;
	}

}
