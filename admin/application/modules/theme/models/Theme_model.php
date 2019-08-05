<?php
/**
 * Theme Models
 *
 * @category Model
 * @package  Theme
 * @author   Athi
 * Created at:  12-May-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Theme_model extends CI_Model
{
	/**
   	* Get Theme
   	* return output as stdClass Object array
   	*/
	
	function get_theme($website_id)
  	{
		$query = $this->db->query("
      	SELECT 
			* 
		FROM 
			".$this->db->dbprefix('theme')." 
			WHERE 
				id = (SELECT theme FROM ".$this->db->dbprefix('websites')." WHERE id = ".$website_id.") 
		UNION 
		SELECT
			* 
		FROM 
			".$this->db->dbprefix('theme')." 
			WHERE 
				id != (SELECT theme FROM ".$this->db->dbprefix('websites')." WHERE id = ".$website_id.")");
				
	  	$records = array();

	  	if ($query->num_rows() > 0) :
			foreach ($query->result() as $row) :
		  		$records[] = $row;
			endforeach;
	  	endif;

	  	return $records;
  	}
	
	// Active Theme
  	function active_theme($id, $website_id)
  	{
		// Update data
		$update_data = array(
			'theme' => $id
		);
		
		// Update into Website
		$this->db->where('id', $website_id);
		return $this->db->update('websites', $update_data);
  	}
		
	// Check Theme
  	function check_theme($theme)
  	{
		$this->db->select('*');    
		$this->db->where('name', $theme);
    	$query = $this->db->get('theme');
    	$records = array();

    	if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;

    	return $records;
  	}
	
	//Inser Theme
  	function insert_theme($theme, $image)
  	{
		// insert data
        $insert_data = array(
			'name'	=> $theme,
          	'image'	=> $image,
  			'status'	=> '0',
  			'created_at'	=> date('m-d-Y')
        );
        
		// Insert into Theme
        return $this->db->insert('theme', $insert_data);
  }
}