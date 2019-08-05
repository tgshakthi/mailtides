<?php
/**
 * Admin Social media feed
 *
 * @category Model
 * @package  Social media feed
 * @author   Siva
 * Created at:  27-11-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Social_media_feed_model extends CI_Model
{
  /**
   * Get Admin User Roles
   * return output as stdClass Object array
   */

  function get_social_media_feed()
  {
    //$this->db->select(array('user_role_id', 'user_role_name', 'active'));
    //$this->db->where_not_in('user_role_id', array('1'));
    //$this->db->where('status', '1');
    //$this->db->order_by('user_role_id', 'desc');
    $query = $this->db->get('social_media_feed');
    $records = array();

    if ($query->num_rows() > 0) :
      foreach ($query->result() as $row) :
        $records[] = $row;
      endforeach;
    endif;

    return $records;
  }

  // Get social Media Feed using id
  function get_social_media_us_id($id)
  {
    $this->db->select('*');
    $this->db->where(array('id' => $id));
    $query = $this->db->get('social_media_feed');
    $records = array();

    if ($query->num_rows() > 0) :
      foreach ($query->result() as $row) :
        $records[] = $row;
      endforeach;
    endif;

    return $records;
  }

  //Inser Update social Media Feed
  function insert_update_social_media_feed($id = NULL)
  {
	  $check_status   = $this->input->post('status');
	  $status   = (isset($check_status)) ? '1' : '0';
    
		
     if ($id == NULL) :

      // insert data
  		$insert_data = array(
  			'media_name' 		 => $this->input->post('media_name'),
  			'media_url'  		 => $this->input->post('media_url'),
			'media_feed_text'  	 => $this->input->post('media_feed_text'),
			'status'          	 => $status,
  			'created_date' 		 => date('m-d-Y')
  		);

      // Insert into social Media Feed
      return $this->db->insert('social_media_feed', $insert_data);

    else :

      // Update data
  		$update_data = array(
  			'media_name' 		 => $this->input->post('media_name'),
  			'media_url'  		 => $this->input->post('media_url'),
			'media_feed_text'  	 => $this->input->post('media_feed_text'),
			'status'          	 => $status
  		);
			
      // Update into social Media Feed
			$this->db->where('id', $id);
			return $this->db->update('social_media_feed', $update_data);

    endif;
  }

  // Delete social Media Feed
  /* function delete_social_media_feed()
  {
		$id = $this->input->post('id');
    $data = array(
      'is_deleted' => '1'
    );
    $this->db->where('id', $id);
		return $this->db->update('social_media_feed', $data);
  } */

  // Delete mulitple Admin user Role
/*   function delete_multiple_user_role()
  {
    $user_role_ids = $this->input->post('table_records');
    foreach ($user_role_ids as $user_role_id) :
      $data = array(
        'is_deleted' => '1'
      );
      $this->db->where('id', $user_role_id);
      $this->db->update('admin_user_role', $data);
    endforeach;
  } */
}
