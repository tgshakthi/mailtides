<?php
/**
 * Color Models
 *
 * @category Model
 * @package  Color
 * @author   Athi
 * Created at:  23-Apr-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Color_model extends CI_Model
{
	/**
   	* Get Color
   	* return output as stdClass Object array
   	*/

  	function get_color()
  	{
		$this->db->select('*');    
    	$query = $this->db->get('color');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/**
   	* Get Color Name
   	* return output as stdClass Object array
   	*/

  	function get_color_name($title_color)
  	{
		$this->db->select('color_name'); 
		$this->db->where('color_class',$title_color);    
    	$query = $this->db->get('color');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	/**
   	* Insert Update colors
	* @author Saravana	 
	* Created at:  25-May-2018
   	* return output as stdClass Object array
   	*/
	
	function insert_update_colors($id = NULL)
	{
		if ($id == NULL) :
			// insert data
			$insert_data = array(
				'color_name' => $this->input->post('color_name'),
				'color_class' => $this->input->post('color_class'),
				'color_code' => $this->input->post('color_code'),
				'created_at' => date('m-d-Y')
			);
			// Insert into Admin user role
			$this->db->insert('color', $insert_data);	
		else :
			// Update data
			$update_data = array(
				'color_name' => $this->input->post('color_name'),
				'color_class' => $this->input->post('color_class'),
				'color_code' => $this->input->post('color_code')
			);
			// Update into Color
			$this->db->where('id', $id);
			$this->db->update('color', $update_data);	
		endif;
		
	}
	
	/**
   	 * Search Color
	 * @author Saravana	 
	 * Created at:  26-May-2018
   	 * return output as stdClass Object array
   	 */
	
	function color_search()
	{
		$search_text = $this->input->post('search_text');
		$this->db->like('color_name', $search_text);
		$this->db->or_like('color_class', $search_text);
		$this->db->or_like('color_code', $search_text);
		$query = $this->db->get('color');
		$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
	}
}