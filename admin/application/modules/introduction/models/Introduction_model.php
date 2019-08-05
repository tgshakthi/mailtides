<?php
/**
 * Introduction Models
 *
 * @category Model
 * @package  Introduction
 * @author   Athi
 * Created at:  23-Apr-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Introduction_model extends CI_Model
{
	private $table_name = 'introduction';
	private $table_pages = 'pages';
	/**
   	* Get Introduction
   	* return output as stdClass Object array
   	*/

  	function get_introduction($id)
  	{
		$this->db->select('*');    
    	$this->db->where('page_id', $id);        
    	$query = $this->db->get($this->table_name);
    	$records = array();
		if ($query->num_rows() > 0) :
			$records = $query->result();      		
    	endif;
    	return $records;
  	}
	
	/**
   	* Check SEO Title
   	* return output as stdClass Object array
   	*/
	
	function check_seo_title($id)
  	{
		$this->db->select('*');    
    	$this->db->where('page_id', $id);        
    	$query = $this->db->get($this->table_pages);
    	$records = array();
    	if ($query->num_rows() > 0) :      		
        	$records = $query->result();      		
    	endif;
    	return $records;
  	}
	
	//Inser Update Introduction
  function insert_update_introduction($id = NULL)
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
		$color = $this->input->post('introduction_background_color');

		if (isset($background_image) && !empty($background_image) && $component_background == 'image') :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$introduction_detail_background = str_replace($find_url, "", $background_image);
		else :
			$introduction_detail_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : 'white';
		endif;
		// Blog Detail Background
        $introduction_detail_bg = array(
            'component_background' => $component_background,
            'introduction_background' => $introduction_detail_background
        );
		
      if ($id == NULL) :
        
		// insert data
        $insert_data = array(
			'page_id'	=> $page_id,
          	'title'	=> $this->input->post('introduction-title'),
  			'title_color'	=> $this->input->post('title-color'),
			'title_position'	=> $this->input->post('title-position'),
  			'text'	=> htmlspecialchars_decode(trim(htmlentities($this->input->post('text')))),
			'content_color'	=> $this->input->post('content-color'),
			'content_position'	=> $this->input->post('content-position'),
			'background' => json_encode($introduction_detail_bg)
        );
        
		// Insert into Introduction
        return $this->db->insert($this->table_name, $insert_data);
      
	  else :
        
		// Update data
  		$update_data = array(
          	'title'	=> $this->input->post('introduction-title'),
  			'title_color'	=> $this->input->post('title-color'),
			'title_position'	=> $this->input->post('title-position'),
  			'text'	=> htmlspecialchars_decode(trim(htmlentities($this->input->post('text')))),			
			'content_color'	=> $this->input->post('content-color'),
			'content_position'	=> $this->input->post('content-position'),
			'background' => json_encode($introduction_detail_bg)  			            
        );
        
		// Update into Introduction
        $this->db->where('id', $id);
		$this->db->where('page_id', $page_id);
        return $this->db->update($this->table_name, $update_data);
      
	  endif;
  }
}