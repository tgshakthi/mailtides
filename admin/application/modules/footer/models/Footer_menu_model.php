<?php
/**
 * Footer Menu
 *
 * @category class
 * @package  Footer Menu
 * @author   shiva
 * Created at:  07-June-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Footer_menu_model extends CI_Model
{
  	/**
   	* Get Menu from Setting
   	* return output as stdClass Object array
   	*/

  	function get_menu($website_id)
  	{
    	$this->db->select('*');   
		$this->db->where(array('website_id' => $website_id, 'code' => 'footer-menu'));
    	$query = $this->db->get('setting');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
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
				".$this->db->dbprefix('footer_menu_group')." a 
			JOIN 
			 	".$this->db->dbprefix('pages')." b 
			ON 
				b.id = a.page_id 
			WHERE 
				b.website_id = ".$website_id."  
			AND 
				a.parent_id = 0 
			ORDER BY 
				a.sort_order"
		);
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	// Get UnSelected Menu
	function get_unselected_menu($website_id)
  	{
    	$query = $this->db->query("
			SELECT 
				id, title 
			FROM 
				".$this->db->dbprefix('pages')."
			WHERE 
				website_id = ".$website_id." 
			 AND 
				status = 1 
			 AND 
			 	is_deleted = 0
			 AND 
				id NOT IN (SELECT page_id FROM ".$this->db->dbprefix('footer_menu_group').") 
			 ORDER BY 
			 	id"
		);
		
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	// Get Child Menu List
	function get_child_menu_list($website_id, $parent_id)
	{
		$query = $this->db->query("
			SELECT 
				b.id,title 
			FROM 
				".$this->db->dbprefix('footer_menu_group')." a 
			JOIN 
			 	".$this->db->dbprefix('pages')." b 
			ON 
				b.id = a.page_id 
			WHERE 
				b.website_id = ".$website_id."  
			AND 
				a.parent_id = ".$parent_id." 
			ORDER BY 
				a.sort_order"
		);
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}
	
	// Insert Assign Menu
	function insert_assign_menu($website_id, $page_id, $parent_id, $sort_order)
	{
		$field_types = array(
			'website_id' => $website_id,
			'page_id' => $page_id,
			'parent_id' => $parent_id,
			'sort_order' => $sort_order
		);
		$this->db->insert('footer_menu_group', $field_types);
	}
	
	// Delete Assign Menu
	function delete_assign_menu($website_id)
	{
		$this->db->where('website_id', $website_id);
		$this->db->delete('footer_menu_group');
	}
	
	// Insert Update Menu
	function insert_update_menu($website_id)
	{
		$key	= array('column','main_menu_text_color','sub_menu_text_color','main_menu_hover_color',
		                'sub_menu_hover_color','status' );
		$value[]	= $this->input->post('position');
		$value[]	= $this->input->post('main_menu_text_color');
		$value[]	= $this->input->post('sub_menu_text_color');
		$value[]	= $this->input->post('main_menu_hover_color');
		$value[]	= $this->input->post('sub_menu_hover_color');
		$status	= $this->input->post('status');
      	$value[]	= (isset($status)) ? '1' : '0';
		
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		
		$menus = $this->get_menu($website_id);

		if(empty($menus))
		{
			// insert data
			$insert_data = array(
				'website_id'   => $website_id,
				'website_id'   => $website_id,
				'code'  	=> 'footer-menu',
				'key'   => $keyJSON,  
				'value'   => $valueJSON
			);
			
			// Insert into Menu
			$this->db->insert('setting', $insert_data);
			return $this->db->insert_id();
		}
		else
		{
			// Update data
  			$update_data = array(
				'key'   => $keyJSON,  
				'value'   => $valueJSON  			            
			);
		// 	echo"<pre>";
		//   print_r($update_data);
		//   die;
        	// Update into Banner
			$this->db->where(array('website_id' => $website_id, 'code' => 'footer-menu'));
        	return $this->db->update('setting', $update_data);
		}
	}
}
