<?php
/**
 * Provided Services Models
 *
 * @category Model
 * @package  Provided Services
 * @author   Karthika
 * Created at:  03-Dec-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Provided_services_model extends CI_Model
{
	private $setting_table	= 'setting';
	private $table_name = 'provided_services';
	private $cities_table = 'cities';
	private $page_table = 'pages';
	private $page_component_table = 'page_components';
	private $text_full_width_table = 'text_full_width';

	// Get All Cities

	function get_cities()
	{
		$this->db->select("*");
		$this->db->where('is_deleted', '0');
		$query = $this->db->get($this->cities_table);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Get Page Url

	function get_page_url($page_id)
	{
		$this->db->select(array(
			'title',
			'url'
		));
		$this->db->where(array(
			'id' => $page_id,
			'status' => '1',
			'is_deleted' => '0'
		));
		$query = $this->db->get($this->page_table);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Get City by Id

	function get_city_by_id($id)
	{
		$this->db->select(array(
			'id',
			'name'
		));
		$this->db->where(array(
			'id' => $id
		));
		$query = $this->db->get($this->cities_table);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	// Insert update Provided Services

	function insert_update_provided_services($website_id)
	{
		$page_id = $this->input->post('page_id');
		$title_color = $this->input->post('title_color');

		$provided_services = $this->get_provided_services($website_id, $page_id);

		$page_data = $this->get_page_url($page_id);
		$page_url = $page_data[0]->url;
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		$cities = $this->input->post('cities');

		$i = 0;

		foreach($cities as $city):
			$city_name = $this->get_city_by_id($city);
			$u = explode('.html', $page_url);
			$r = $u[0] . '-in-' . str_ireplace(' ', '-', strtolower($city_name[0]->name)) . '.html';
			$insert_page_data = array(
				'website_id' => $website_id,
				'title' => $page_data[0]->title . ' in ' . str_replace(' ', '-', $city_name[0]->name),
				'url' => $r,
				'component_id' => '3',
				'status' => $status
			);
			$this->db->insert($this->page_table, $insert_page_data);
			$last_page_id = $this->db->insert_id();
			$insert_page_component_data = array(
				'page_id' => $last_page_id,
				'component_name' => 'Text Full Width',
				'component_id' => '3',
				'status' => '1'
			);
			$this->db->insert($this->page_component_table, $insert_page_component_data);
			$insert_text_full_width_data = array(
				'page_id' => $last_page_id,
				'title' => $page_data[0]->title . ' in ' . str_replace(' ', '-', $city_name[0]->name),
				'title_color' => 'black-text',
				'title_position' => 'left-align',
				'full_text' => $this->input->post('content') ,
				'content_title_color' => 'black-text',
				'content_title_position' => 'left-align',
				'content_color' => 'black-text',
				'content_position' => 'left-align',
			);
			$this->db->insert($this->text_full_width_table, $insert_text_full_width_data);

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'new_page_id' => $last_page_id ,
				'city_id' => $city,
				'title_color' => $title_color,
				'status' => $status
			);

			// Insert into  provided services
			$this->db->insert($this->table_name, $insert_data);

			$i++;
		endforeach;
	}

	// Get Table Data

	function get_page_cities_url($page_id)
	{
		$sql_query = "SELECT
				a.title,
				a.url,
				a.status,
				b.name,
				b.id
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

	// Get Provided Services
	function get_provided_services($website_id, $page_id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'page_id' => $page_id,
			'website_id' => $website_id
		));
		$query = $this->db->get($this->table_name);
		$records = array();
		if ($query->num_rows() > 0):
			$records = $query->result();
		endif;
		return $records;
	}

	function get_Provided_services_setting_details($website_id, $page_id, $code)
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
			$records = $query->result();
		endif;

		return $records;
	}
	// provided Services settings details
	function get_Provided_services_setting_details_data($website_id, $page_id, $code)
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
	// Insert Update Image Card Title Details

	function insert_update_provided_service_title_data($page_id, $id = NULL)
	{
		$key = array(
			'provided_services_title',
			'provided_services_title_color',
			'provided_services_title_position',
			'provided_services_title_status'
		);

		$website_id = $this->input->post('website_id');
		$value[] = $this->input->post('provided_services_title');
		$value[] = $this->input->post('provided_services_title_color');
		$value[] = $this->input->post('provided_services_title_position');
		$status	= $this->input->post('provided_services_title_status');
		$value[]	= (isset($status)) ? '1' : '0';

		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$provided_service = $this->get_Provided_services_setting_details_data($website_id, $page_id, 'provided_services_title');

		if (empty($provided_service)):
			// insert data
			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'provided_services_title',
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

			$this->db->where(array('website_id' => $website_id, 'code' => 'provided_services_title', 'page_id' => $page_id));
			$this->session->set_flashdata('success', 'Successfully Updated');
      return $this->db->update($this->setting_table, $update_data);
		endif;
	}

	// Insert Update Image Card Customization

	function insert_update_provided_service_customize_data($page_id)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
		$httpUrl = $this->input->post('httpUrl');
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('provided_services_background_color');
		$image = $this->input->post('image');
		
		if (isset($image) && !empty($image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$provided_background = str_replace($find_url, "", $image);
		else :
			$provided_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;		

		$key = array(
			'row_count',
			'component_background',
			'provided_services_background'
		);

		$value[] = $this->input->post('provided_services_row_count');
		$value[] = $this->input->post('component-background');
		$value[] = $provided_background;


		// Convert to JSON data
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$provided_service = $this->get_Provided_services_setting_details_data($website_id, $page_id, 'provided_services_customize');

		if (empty($provided_service)):
			// insert data
			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'provided_services_customize',
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

			$this->db->where(array('website_id' => $website_id, 'code' => 'provided_services_customize', 'page_id' => $page_id));
			$this->session->set_flashdata('success', 'Successfully Updated');
      return $this->db->update($this->setting_table, $update_data);
		endif;
	}

	// Update Provided service Sort Order
	function update_sort_order($page_id, $row_sort_orders)
	{
		if(!empty($row_sort_orders)):

			$i = 1;
			foreach($row_sort_orders as $row_sort_order):

				$this->db->where('id', $row_sort_order);
				$this->db->update($this->table_name, array('sort_order' => $i));
				$i++;

			endforeach;

		endif;
	}
	function remove_image()
	{
		$id = $this->input->post('id');
		$remove_image = array(
			'image' => ""
		);
		$this->db->where('id', $id);
		$this->db->update($this->table_name, $remove_image);
	}
}
