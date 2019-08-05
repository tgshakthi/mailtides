<?php
/**
 * Event Models
 *
 * @category Model
 * @package  Event
 * @author   Athi
 * Created at:  10-Jul-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Event_model extends CI_Model
{
	/**
	 * Get Event
	 * return output as stdClass Object array
	 */
	function get_event($website_id)
	{
		$this->db->select(array(
			'id',
			'category_id',
			'(SELECT name FROM '.$this->db->dbprefix('event_category').' WHERE id = '.$this->db->dbprefix('event').'.category_id) as name',
			'title',
			'image',
			'sort_order',
			'status'
		));
		$this->db->where(array('website_id' => $website_id, 'is_deleted' => 0));
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('event');
		$records = array();
		if ($query->num_rows() > 0):
		
				$records= $query->result();
		
		endif;
		return $records;
	}

	/**
	 * Get Event by @param
	 * return output as stdClass Object array
	 */
	function get_event_by_id($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('event');
		$records = array();
		if ($query->num_rows() > 0):
			
				$records = $query->result();
			
		endif;
		return $records;
	}
		
	/**
	 * Get Event Page by @param
	 * return output as stdClass Object array
	 */
	function get_event_page_by_id($website_id, $page_id)
	{
		$this->db->select('*');
		$this->db->where(array('website_id' => $website_id, 'page_id' => $page_id));
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('event_pages');
		$records = array();
		if ($query->num_rows() > 0):
		
				$records= $query->result();
		
		endif;
		return $records;
	}
	
	// Unselected Events
	function get_event_unselected($website_id, $page_id)
	{
		$query = $this->db->query('
			SELECT 
				a.id, (SELECT name FROM '.$this->db->dbprefix("event_category").' WHERE id = a.category_id) as name, a.title 
			FROM 
				'.$this->db->dbprefix('event').' a, '.$this->db->dbprefix('event_pages').' b 
			WHERE 
				b.page_id = '.$page_id.' AND
				a.website_id = '.$website_id.' AND 
				a.status = 1 AND 
				a.is_deleted = 0 AND 
				b.website_id = '.$website_id.' AND 
				!FIND_IN_SET(a.id, b.event_id)'
		);
		
		$records = array();
		if ($query->num_rows() > 0):
		
				$records= $query->result();
			
		endif;
		return $records;
	}
	
	// Selected Events
	function get_event_selected($website_id, $page_id)
	{
  		$query = $this->db->query("
			SELECT
				a.id,
            	(SELECT name FROM ".$this->db->dbprefix("event_category")." WHERE id = a.category_id) as name,
				a.title
		  	FROM
				".$this->db->dbprefix("numbers")." c
			INNER JOIN 
				".$this->db->dbprefix("event_pages")." b
			ON 
				CHAR_LENGTH(b.event_id) - CHAR_LENGTH(REPLACE(b.event_id, ',', '')) >= c.n - 1 
            INNER JOIN 
				".$this->db->dbprefix("event")." a 
			ON 
				SUBSTRING_INDEX(SUBSTRING_INDEX(b.event_id, ',', c.n), ',', -1) = a.id 
           	WHERE 
				a.website_id = ".$website_id." 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			AND 
				b.website_id = ".$website_id." 
			AND 
				b.page_id = ".$page_id."
		");
  
		$records = array();
		if ($query->num_rows() > 0):
			
				$records=$query->result();
			
		endif;
		return $records;
	}
	
	// Unselected Events Category
	function get_event_category_unselected($website_id, $page_id)
	{
		$query = $this->db->query('
			SELECT 
				a.id, a.name
			FROM 
				'.$this->db->dbprefix('event_category').' a, '.$this->db->dbprefix('event_pages').' b 
			WHERE 
				b.page_id = '.$page_id.' AND
				a.website_id = '.$website_id.' AND 
				a.status = 1 AND 
				a.is_deleted = 0 AND 
				b.website_id = '.$website_id.' AND 
				!FIND_IN_SET(a.id, b.event_category)'
		);
		
		$records = array();
		if ($query->num_rows() > 0):
			
				$records=$query->result();
		
		endif;
		return $records;
	}
	
	// Selected Events Category
	function get_event_category_selected($website_id, $page_id)
	{
  		$query = $this->db->query("
			SELECT
				a.id,
				a.name
		  	FROM
				".$this->db->dbprefix("numbers")." c
			INNER JOIN 
				".$this->db->dbprefix("event_pages")." b
			ON 
				CHAR_LENGTH(b.event_category) - CHAR_LENGTH(REPLACE(b.event_category, ',', '')) >= c.n - 1 
            INNER JOIN 
				".$this->db->dbprefix("event_category")." a 
			ON 
				SUBSTRING_INDEX(SUBSTRING_INDEX(b.event_category, ',', c.n), ',', -1) = a.id 
           	WHERE 
				a.website_id = ".$website_id." 
			AND 
				a.status = 1 
			AND 
				a.is_deleted = 0 
			AND 
				b.website_id = ".$website_id." 
			AND 
				b.page_id = ".$page_id."
		");
  
		$records = array();
		if ($query->num_rows() > 0):
		
				$records= $query->result();
			
		endif;
		return $records;
	}
	
	// Insert Update Event
	function insert_update_event($id = NULL)
	{
	
	
		$website_folder_name = $this->admin_header->website_folder_name();
		$website_id	= $this->input->post('website_id');
	
		$border	= $this->input->post('border');
		$border	= (isset($border)) ? '1' : '0';

		$status	= $this->input->post('status');
		$status	= (isset($status)) ? '1' : '0';

		$external_btn = $this->input->post('external_btn');
		$external_btn = (isset($external_btn)) ? '1' : '0';

		$open_new_tab	= $this->input->post('open_new_tab');
		$open_new_tab	= (isset($open_new_tab)) ? '1' : '0';
	
		
	
		
		
		$image = $this->input->post('image');
		$background_image = $this->input->post('background-image');   
		$httpUrl = $this->input->post('httpUrl');
		// Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
		$image    = str_replace($find_url, "", $image);
		  // Background Image
		  if (isset($background_image) && !empty($background_image)) :
			// Remove Host URL in image
			//$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;			
			$find_url = $httpUrl . '/images/' . $website_folder_name . '/';
			$event_detail_background_image = str_replace($find_url, "", $background_image);
        endif;
		$title_color=$this->input->post('title_color');
	//   $short_description_title_color=$this->input->post('short_description_title_color');
		$short_description_color=$this->input->post('short_description_color');
	    //$description_title_color=$this->input->post('description_title_color');
		$description_color=$this->input->post('description_color');
		$date_color=$this->input->post('date_color');
		$location_color=$this->input->post('location_color');
		$date_hover=$this->input->post('date_hover');
		$location_hover=$this->input->post('location_hover');
		$title_hover_color=$this->input->post('title_hover_color');
	//	$short_description_title_hover_color= $this->input->post('short_description_title_hover_color');
		//$short_description_hover_color=$this->input->post('short_description_hover_color');
		//$description_title_hover_color= $this->input->post('description_title_hover_color');
		//$description_hover_color=$this->input->post('description_hover_color');
		$background_color=$this->input->post('background_color');
		$background_hover=$this->input->post('background_hover');

		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'category_id' => $this->input->post('category'),
				'image' => $image,
				'image_title' => $this->input->post('image_title'),
				'image_alt' => $this->input->post('image_alt'),
				'title' => $this->input->post('title'),
				'short_description' => $this->input->post('short_description'),
				'description' => $this->input->post('description'),
				'date' => $this->input->post('create_date'),
				'location' => $this->input->post('location'),
				'title_color' =>($title_color=='')?'black-text':$title_color ,
				'title_position' => $this->input->post('title_position'),
			//	'short_description_title_color' =>($short_description_title_color=='')?'black-text':$short_description_title_color ,
			//	'short_description_title_position' => $this->input->post('short_description_title_position'),
				'short_description_color' =>($short_description_color=='')?'black-text':$short_description_color ,
				'short_description_position' => $this->input->post('short_description_position'),
				//'description_title_color' => ($description_title_color=='')?'black-text':$description_title_color,
				//'description_title_position' => $this->input->post('description_title_position'),
				'description_color' =>($description_color=='')?'black-text':$description_color ,
				'description_position' => $this->input->post('description_position'),
				'date_color' => ($date_color=='')?'black-text':$date_color,
				'location_color' => ($location_color=='')?'black-text':$location_color,
				'date_hover' => ($date_hover=='')?'black-text':$date_hover,
				'location_hover' =>($location_hover=='')?'black-text':$location_hover ,
				'title_hover_color' => ($title_hover_color=='')?'black-text':$title_hover_color,
				//'short_description_title_hover_color' =>($short_description_title_hover_color=='')?'black-text':$short_description_title_hover_color,
			     'short_description_hover_color' =>($short_description_hover_color=='')?'black-text':$short_description_hover_color ,
				//'description_title_hover_color' =>($description_title_hover_color=='')?'black-text':$description_title_hover_color,
				'description_hover_color' => ($description_hover_color=='')?'black-text':$description_hover_color,
				'event_url' => $this->input->post('event_url'),
				'open_new_tab' => $open_new_tab,
				'background_color' =>($background_color=='')?'white':$background_color ,
				'background_image' => $event_detail_background_image,
				'background_hover' =>($background_hover=='')?'white':$background_hover ,
				'external_btn' => $external_btn,
				
				'sort_order' => $this->input->post('sort_order'),
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Insert into Event

			$this->db->insert('event', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'category_id' => $this->input->post('category'),
				'image' => $image,
				'image_title' => $this->input->post('image_title'),
				'image_alt' => $this->input->post('image_alt'),
				'title' => $this->input->post('title'),
				'short_description' => $this->input->post('short_description'),
				'description' => $this->input->post('description'),
				'date' => $this->input->post('create_date'),
				'location' => $this->input->post('location'),
				'title_color' =>($title_color=='')?'black-text':$title_color ,
				'title_position' => $this->input->post('title_position'),
				//'short_description_title_color' =>($short_description_title_color=='')?'black-text':$short_description_title_color ,
				//'short_description_title_position' => $this->input->post('short_description_title_position'),
				'short_description_color' =>($short_description_color=='')?'black-text':$short_description_color ,
				'short_description_position' => $this->input->post('short_description_position'),
			//	'description_title_color' => ($description_title_color=='')?'black-text':$description_title_color,
				//'description_title_position' => $this->input->post('description_title_position'),
				'description_color' =>($description_color=='')?'black-text':$description_color ,
				'description_position' => $this->input->post('description_position'),
				'date_color' => ($date_color=='')?'black-text':$date_color,
				'location_color' => ($location_color=='')?'black-text':$location_color,
				'date_hover' => ($date_hover=='')?'black-text':$date_hover,
				'location_hover' =>($location_hover=='')?'black-text':$location_hover ,
				'title_hover_color' => ($title_hover_color=='')?'black-text':$title_hover_color,
				//'short_description_title_hover_color' =>($short_description_title_hover_color=='')?'black-text':$short_description_title_hover_color,
				'short_description_hover_color' =>($short_description_hover_color=='')?'black-text':$short_description_hover_color ,
			//	'description_title_hover_color' =>($description_title_hover_color=='')?'black-text':$description_title_hover_color,
				'description_hover_color' => ($description_hover_color=='')?'black-text':$description_hover_color,
				'event_url' => $this->input->post('event_url'),
				'open_new_tab' => $open_new_tab,
				'background_color' =>($background_color=='')?'white':$background_color ,
				'background_image' => $event_detail_background_image,
				'background_hover' =>($background_hover=='')?'white':$background_hover ,
				'external_btn' => $external_btn,
				'sort_order' => $this->input->post('sort_order'),
				'status' => $status
			);

			// Update into Event

			$this->db->where(array('id' => $id, 'website_id' => $website_id));
			return $this->db->update('event', $update_data);
		endif;
	}
	 //settings
	 function get_review_setting($website_id, $code, $page_id)
	 {
		 $this->db->select('*');
		 $this->db->where(array(
			 'website_id' => $website_id,
			 'code' => $code,
			 'page_id' => $page_id
		 ));
		 $query = $this->db->get('setting');
		 $records = array();
		 if ($query->num_rows() > 0):
			 foreach($query->result() as $row):
				 $records[] = $row;
			 endforeach;
		 endif;
		 return $records;
	 }
	
	// Insert Update Event Page
	function insert_update_event_page($id = NULL)
	{
		$website_folder_name  = $this->admin_header->website_folder_name();
        $httpUrl              = $this->input->post('httpUrl');
        $component_background = $this->input->post('component-background');
        $color                = $this->input->post('event_background_color');
        $image                = $this->input->post('image');
        
        if (isset($image) && !empty($image) && $component_background == 'image'):
        // Remove Host URL in image
            
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;            
            $find_url        = $httpUrl . '/images/' . $website_folder_name . '/';
            $event_background = str_replace($find_url, "", $image);
        else:
            $event_background = (isset($color) && !empty($color) && $component_background == 'color') ? $color : '';
		endif;
		 // Event Background
		 $event_bg = array(
            'component_background' => $component_background,
            'event_background' => $event_background
        );
		$show_event = $this->input->post('show_event');
		if($show_event == 'event'):
		
			$data_array = $this->input->post('output_update');
			$result = json_decode($data_array);
			
		else:
		
			$data_array = $this->input->post('output_category_update');
			$result = json_decode($data_array);
		
		endif;
		
		$events = (!empty($result)) ? implode(',', array_column($result, 'id')): '';
		
		$website_id	= $this->input->post('website_id');
		$page_id	= $this->input->post('page_id');
		$status	= $this->input->post('status');
		$status	= (isset($status)) ? '1' : '0';
		$title_color=$this->input->post('title_color');
		
		if($id == NULL):
		
			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'event' => $this->input->post('show_event'),
				'title' => $this->input->post('title'),
				'title_color' =>($title_color=='')?'black-text':$title_color ,
				'title_position' => $this->input->post('title_position'),
				'event_per_row' => $this->input->post('event_per_row'),
				'background' => json_encode($event_bg),
				'status' => $status,
				'created_at' => date('m-d-Y')
			);
			if($show_event == 'event'):
				
				$insert_data =  array_merge($insert_data, array('event_id' => $events));
				
			else:
			
				$insert_data =  array_merge($insert_data, array('event_category' => $events));
				
			endif;
			//review component
			$this->insert_update_review_component( $website_id, $page_id);
			// Insert into Event Page

			$this->db->insert('event_pages', $insert_data);
			return $this->db->insert_id();
		
		else:
		
			// Update data

			$update_data = array(
				'event' => $this->input->post('show_event'),
				'title' => $this->input->post('title'),
				'title_color' => ($title_color=='')?'black-text':$title_color,
				'title_position' => $this->input->post('title_position'),
				'event_per_row' => $this->input->post('event_per_row'),
				'background' => json_encode($event_bg),
				'status' => $status
			);

			if($show_event == 'event'):
				
				$update_data =  array_merge($update_data, array('event_id' => $events));
				
			else:
			
				$update_data =  array_merge($update_data, array('event_category' => $events));
				
			endif;
			
			//review component
			$this->insert_update_review_component( $website_id, $page_id);
			
			// Update into Event Page

			$this->db->where(array('id' => $id, 'website_id' => $website_id, 'page_id' => $page_id));
			return $this->db->update('event_pages', $update_data);
		
		endif;
	}
	
	//review component
	function insert_update_review_component($website_id,$page_id)
    {
      
        $review_component = $this->input->post('event_review_component');
        $key = array(
            'event_review_component',
            'event_review_title',
            'event_review_title_color',
            'event_review_bg_color'
		);
        $value[] = (isset($review_component) ? '1' : '0');
        $value[]=$this->input->post('event_review_title');;
        $value[]=$this->input->post('event_review_title_color');;
        $value[]=$this->input->post('event_review_bg_color');;
        $review_component = $this->get_review_setting($website_id, 'event_review_component', $page_id);
      
        $keyJSON = json_encode($key);
		$valueJSON = json_encode($value);
		if (empty($review_component)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'event_review_component',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Insert into Contact page

			$this->db->insert('setting', $insert_data);
            return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Update into Contact page

			$this->db->where(array(
				'website_id' => $website_id,
				'page_id' => $page_id,
				'code' => 'event_review_component'
			));
			return $this->db->update('setting', $update_data);
		endif;
       
    }

	// Inser Update Event Category
	function insert_update_event_category($id = NULL)
	{
		$website_id = $this->input->post('website_id');
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		
		if ($id == NULL):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'name' => $this->input->post('name'),
				'sort_order' => $this->input->post('sort_order'),
				'status' => $status,
				'created_at' => date('m-d-Y')
			);

			// Insert into Event Category

			$this->db->insert('event_category', $insert_data);
			return $this->db->insert_id();
		else:

			// Update data

			$update_data = array(
				'name' => $this->input->post('name'),
				'sort_order' => $this->input->post('sort_order'),
				'status' => $status
			);

			// Update into Event Category

			$this->db->where(array('id' => $id, 'website_id' => $website_id));
			return $this->db->update('event_category', $update_data);
		endif;
	}
	
	/**
	 * Get Check Event Category ID by @param
	 * return output as stdClass Object array
	 */
	function check_event($id)
	{
		$this->db->select('*');
		$this->db->where(array(
							'category_id' => $id,
							'is_deleted' => '0'
							));
		$query = $this->db->get('event');
		$records = array();
		if ($query->num_rows() > 0):
			
				$records= $query->result();
		endif;		
        return $records;
	}
	
	// Check Event Category Duplicate

	function check_category_duplicate()
	{
		$category_name = $this->input->post('name');
		$website_id = $this->input->post('web_id');
		$this->db->select('*');
		$this->db->where(array(
			'name' => $category_name,
			'website_id' => $website_id
		));
		$query = $this->db->get('event_category');
		$records = array();
		if ($query->num_rows() > 0):
		
				$records=$query->result();
			
		endif;
		return $records;
	}
	
	// Update Event Sort Order
	function update_sort_order($website_id, $row_sort_orders)
	{
		if(!empty($row_sort_orders)):
		
			$i = 1;
			foreach($row_sort_orders as $row_sort_order):
			
				$this->db->where(array('id' => $row_sort_order, 'website_id' => $website_id));
				$this->db->update('event', array('sort_order' => $i));
				$i++;
				
			endforeach;
		
		endif;
	}
	
	// Delete Event

	function delete_event()
	{
		$id = $this->input->post('id');
		$this->db->where(array(
			'id' => $id
		));
		return $this->db->update('event', array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple Event

	function delete_multiple_event()
	{
		$event_categories = $this->input->post('table_records');
		$website_id = $this->input->post('website_id');
		foreach($event_categories as $event_category):
			$this->db->where(array(
				'id' => $event_category,
				'website_id' => $website_id
			));
			$this->db->update('event', array(
				'is_deleted' => 1
			));
		endforeach;
	}
	
	/**
	 * Get Event Category
	 * return output as stdClass Object array
	 */
	function get_event_category($website_id)
	{
		$this->db->select(array(
			'id',
			'name',
			'sort_order',
			'status'
		));
		$this->db->where(array('website_id' => $website_id, 'is_deleted' => 0));
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('event_category');
		$records = array();
		if ($query->num_rows() > 0):
			
				$records=$query->result();
			
		endif;
		return $records;
	}
	
	/**
	 * Get Select Event Category
	 * return output as stdClass Object array
	 */
	function select_event_category($website_id, $search)
	{
		$sql_data = "SELECT * FROM " . $this->db->dbprefix('event_category') . " WHERE name LIKE '%".$search."%' AND website_id = '".$website_id."' AND is_deleted = 0";
		$query = $this->db->query($sql_data);
		$records = array();
		if ($query->num_rows() > 0):
			
				$records= $query->result();
		
		endif;
		return $records;
	}
	
	/**
	 * Get Selected Event Category
	 * return output as stdClass Object array
	 */
	function selected_category($category_id)
	{
		$this->db->select(array('id', 'name'));
		$this->db->where('id', $category_id);
		$query = $this->db->get('event_category');
		$records = array();
		if ($query->num_rows() > 0):
		
				$records= $query->result();
			
		endif;
		return $records;
	}
	
	/**
	 * Get Event Category by @param
	 * return output as stdClass Object array
	 */
	function get_event_category_by_id($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('event_category');
		$records = array();
		if ($query->num_rows() > 0):
		
				$records= $query->result();
			
		endif;
		return $records;
	}
	
	// Update Event Category Sort Order
	function update_sort_order_two($website_id, $row_sort_orders)
	{
		if(!empty($row_sort_orders)):
		
			$i = 1;
			foreach($row_sort_orders as $row_sort_order):
			
				$this->db->where(array('id' => $row_sort_order, 'website_id' => $website_id));
				$this->db->update('event_category', array('sort_order' => $i));
				$i++;
				
			endforeach;
		
		endif;
	}
	
	// Insert Category
	function insert_category()
	{
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		
		$insert_data = array(
			'website_id' => $this->input->post('website_id'),
			'name' => $this->input->post('name'),
			'sort_order' => $this->input->post('sort_order'),
			'status' => $status,
			'created_at' => date('m-d-Y')
		);

		// Insert into Event Category

		$this->db->insert('event_category', $insert_data);
	}
	
	/**
	 * Get Check Event Category ID by @param
	 * return output as stdClass Object array
	 */
	function check_event_category()
	{
		$event_categories = implode(',', $this->input->post('table_records'));
		$sql_data = "SELECT * FROM " . $this->db->dbprefix('event') . " WHERE category_id IN (".$event_categories.")";
		$query = $this->db->query($sql_data);
		$records = array();
		if ($query->num_rows() > 0):
			
				$records = $query->result();
			
		endif;
		return $records;
	}

	// Delete Event Category

	function delete_event_category()
	{
		$id = $this->input->post('id');
		$this->db->where(array(
			'id' => $id
		));
		return $this->db->update('event_category', array(
			'is_deleted' => 1
		));
	}

	// Delete mulitple Event Category

	function delete_multiple_event_category()
	{
		$event_categories = $this->input->post('table_records');
		$website_id = $this->input->post('website_id');
		foreach($event_categories as $event_category):
			$this->db->where(array(
				'id' => $event_category,
				'website_id' => $website_id
			));
			$this->db->update('event_category', array(
				'is_deleted' => 1
			));
		endforeach;
	}

	// Remove Image

	function remove_event_image()
	{
		$id = $this->input->post('id');
		$remove_image = array(
			'image' => ""
		);
		$this->db->where('id', $id);
		$this->db->update('event', $remove_image);
	}
}
