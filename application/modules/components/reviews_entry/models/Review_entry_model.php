<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Review_entry_model extends MX_Controller
{
    function insert_update_review_entry_data()
    {
        $page_url = $this->input->post('page_url');
        
        $insert_data = array(
            'website_id' => $this->input->post('website_id'),
            'page_id' => $this->input->post('page_id'),
            'review_user_id'=>$this->input->post('review_user_id'),
            'name' => $this->input->post('review_name'),
            'email' => $this->input->post('review_email'),
            'review' => $this->input->post('comments'),
            'rating' => $this->input->post('ratings'),
            'source_url' => base_url()
        );
        // Insert into Image Card
        $this->db->insert('reviews_entry', $insert_data);
        return $this->db->insert_id();
    }
    
    function get_review_entry($website_id, $page_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
            'page_id' => $page_id,
            'publish' => '1'
        ));
        $this->db->order_by('rating', 'desc');
        $query   = $this->db->get('reviews_entry');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
	}
	
	function update_feedback($id, $route)
    {
        // Update Email Blast
		$this->db->where('track_id', $id);
        $this->db->update('email_track', array($route => 1));
        return $this->db->insert_id();
    }
	
	// Get Users
	function get_users($id)
	{
		$this->db->select('*');
		$this->db->where(
			array(
				'id' => $id
			)
		);
		$query = $this->db->get('email_track');
		$records = array();
		if ($query->num_rows() > 0 ) :
		  $records = $query->result();
		endif;
		return $records;		
	}
}