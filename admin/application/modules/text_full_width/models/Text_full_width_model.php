<?php
/**
 * Text Full Width Models
 *
 * @category Model
 * @package  Text Full Width
 * @author   Athi
 * Created at:  24-Apr-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Text_full_width_model extends CI_Model
{
	/**
   	* Get Text Full Width
   	* return output as stdClass Object array
   	*/

  	function get_text_full_width($page_id)
  	{
    	$this->db->select('*');    
    	$this->db->where('page_id', $page_id);       
    	$query = $this->db->get('text_full_width');
    	$records = array();

    	if ($query->num_rows() > 0) :
       		$records =$query->result();
    	endif;

    	return $records;
  	}
  	
	//Inser Update Text Full Width
	function insert_update_text_full_width($id = NULL)
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
		$color = $this->input->post('text_full_width_background_color');

		if (isset($background_image) && !empty($background_image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$text_full_width_detail_background = str_replace($find_url, "", $background_image);
		else :
			$text_full_width_detail_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;
		// Blog Detail Background
        $text_full_width_detail_bg = array(
            'component_background' => $component_background,
            'text_full_width_background' => $text_full_width_detail_background
        );
		
		if ($id == NULL) :
		  
		  // insert data
		  $insert_data = array(
			  'page_id'	=> $page_id,
			  'title'	=> $this->input->post('text-full-width-title'),
			  'title_color'	=> $this->input->post('title-color'),
			  'title_position'	=> $this->input->post('title-position'),
			  'full_text'	=> htmlspecialchars_decode(trim(htmlentities($this->input->post('full-text')))),
			  'content_title_color'	=> $this->input->post('content-title-color'),
			  'content_title_position'	=> $this->input->post('content-title-position'),
			  'content_color'	=> $this->input->post('content-color'),
			  'content_position'	=> $this->input->post('content-position'),
			  'background' => json_encode($text_full_width_detail_bg),
			  'created_at'	=> date('m-d-Y')
		  );
		  
		  // Insert into Text Full Width Text
		  return $this->db->insert('text_full_width', $insert_data);
		
		else :
		  
		  // Update data
		  $update_data = array(
			  'title'	=> $this->input->post('text-full-width-title'),
			  'title_color'	=> $this->input->post('title-color'),
			  'title_position'	=> $this->input->post('title-position'),
			  'full_text'	=> htmlspecialchars_decode(trim(htmlentities($this->input->post('full-text')))),
			  'content_title_color'	=> $this->input->post('content-title-color'),
			  'content_title_position'	=> $this->input->post('content-title-position'),
			  'content_color'	=> $this->input->post('content-color'),
			  'content_position'	=> $this->input->post('content-position'),
			  'background' => json_encode($text_full_width_detail_bg), 			            
		  );
		  
		  // Update into Text Full Width Text
		  $this->db->where('id', $id);
		  $this->db->where('page_id', $page_id);
		  return $this->db->update('text_full_width', $update_data);
		  
		endif;
	}
  
}