<?php
/**
 * Conclusion Models
 *
 * @category Model
 * @package  Conclusion
 * @author   Athi
 * Created at:  25-Apr-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Conclusion_model extends CI_Model
{
	/**
   	* Get Conclusion
   	* return output as stdClass Object array
   	*/

  	function get_conclusion($id)
  	{
		$this->db->select('*');    
    	$this->db->where('page_id', $id);        
    	$query = $this->db->get('conclusion');
    	$records = array();

    	if ($query->num_rows() > 0) :      		
			$records = $query->result();
    	endif;
    	return $records;
  	}
	
	//Inser Update Conclusion
	function insert_update_conclusion($id = NULL)
	{
	    $page_id	= $this->input->post('page-id');
	    $website_folder_name = $this->admin_header->website_folder_name();
	    $image   = $this->input->post('image');
	    // $background_image = $this->input->post('image');    
	    $httpUrl = $this->input->post('httpUrl');
	  
	    $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
	    $background_image    = str_replace($find_url, "", $image);

		// Background 
		$component_background = $this->input->post('component-background');
		$color = $this->input->post('conclusion_background_color');

		if (isset($background_image) && !empty($background_image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$conclusion_detail_background = str_replace($find_url, "", $background_image);
		else :
			$conclusion_detail_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;
		// Blog Detail Background
        $conclusion_detail_bg = array(
            'component_background' => $component_background,
            'conclusion_background' => $conclusion_detail_background
        );
	  
      if ($id == NULL) :
	  
        // insert data
        $insert_data = array(
			'page_id'	=> $page_id,
          	'title'	=> $this->input->post('conclusion-title'),
  			'title_color'	=> $this->input->post('title-color'),
			'title_position'	=> $this->input->post('title-position'),
  			'text'	=> htmlspecialchars_decode(trim(htmlentities($this->input->post('text')))),
			'content_position'	=> $this->input->post('content-position'),
			'content_color'	=> $this->input->post('content-color'),
			'background' => json_encode($conclusion_detail_bg),
  			'created_at'	=> date('m-d-Y')
        );
		
        // Insert into Conclusion
        return $this->db->insert('conclusion', $insert_data);
		
      else :
	  
        // Update data
  		$update_data = array(
          	'title'	=> $this->input->post('conclusion-title'),
  			'title_color'	=> $this->input->post('title-color'),
			'title_position'	=> $this->input->post('title-position'),
  			'text'	=> htmlspecialchars_decode(trim(htmlentities($this->input->post('text')))),	
			'content_position'	=> $this->input->post('content-position'),		
			'content_color'	=> $this->input->post('content-color'),
			'background' => json_encode($conclusion_detail_bg),			            
        );
		
        // Update into Conclusion
        $this->db->where('id', $id);
		$this->db->where('page_id', $page_id);
        return $this->db->update('conclusion', $update_data);
      endif;
  }
}