<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Review_entry_model extends CI_Model
{
	function get_reviews_entry($website_id,$page_id)
	{	
		$this->db->select('*');
		$this->db->where(array(
								'page_id' => $page_id,
								'website_id' => $website_id,
								'is_deleted' => '0'
							));
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('reviews_entry');
		$records = array();
		if ($query->num_rows() > 0):			
			$records = $query->result();			
		endif;
		return $records;
	}
	
	function get_reviews_entry_by_id($website_id, $id)
	{
		$this->db->select('*');
		$this->db->where(array(
								'id' => $id,
								'website_id' => $website_id
							));
		$this->db->order_by('sort_order', 'ASC');
		$query = $this->db->get('reviews_entry');
		$records = array();
		if ($query->num_rows() > 0):			
			$records = $query->result();			
		endif;
		return $records;
	}
	
	function insert_update_review_entry($website_id,$id)
	{
		$publish = $this->input->post('publish');
		$publish = (isset($publish)) ? '1' : '0';
		$page_id = $this->input->post('page_id');
		if(empty($id)):
			$insert_data = array(
						'page_id'=> $page_id,
						'website_id'=> $this->input->post('website_id'),
						'name'=> $this->input->post('name'),
						'email' => $this->input->post('email'),
						'rating' => $this->input->post('rating'),
						'review' => $this->input->post('content'),
						'source' => $this->input->post('source'),
						'source_url' => $this->input->post('source_url'),
						'publish' => $publish,
						'sort_order' => $this->input->post('sort_order')
						);
			return $this->db->insert('reviews_entry', $insert_data);
		else:
			$update_data = array(
						'name'=> $this->input->post('name'),
						'email' => $this->input->post('email'),
						'rating' => $this->input->post('rating'),
						'review' => $this->input->post('content'),
						'source' => $this->input->post('source'),
						'source_url' => $this->input->post('source_url'),
						'publish' => $publish,
						'sort_order' => $this->input->post('sort_order')
						);
			$this->db->where('id',$id);
			$this->db->where('website_id', $website_id);
			$this->db->where('page_id', $page_id);
			return $this->db->update('reviews_entry', $update_data);
		endif;
		
	}
	
	// Get Mail config
	function get_review_entry_mail_config($website_id, $code) 
	{
		$this->db->select('*');
		$this->db->where(array(
			'website_id' => $website_id,
			'code' => $code
		));
		$query = $this->db->get('setting');
		$records = array();
		if ($query->num_rows() > 0) :				
			$records = $query->result();				
		endif;
		return $records;
	}

	// Insert Update Review Event Mail config
	function insert_update_review_entry_mail_configure()
	{
		$website_id = $this->input->post('website_id');
		$status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';

		$to_address = $this->input->post('to_address');
        $carbon_copy = $this->input->post('carbon_copy');
        $blind_carbon_copy = $this->input->post('blind_carbon_copy');
        
		$to_address  = ($to_address != '') ? implode(",",$to_address): '';
		$carbon_copy  = ($carbon_copy != '') ? implode(",",$carbon_copy): '';
        $blind_carbon_copy = ($blind_carbon_copy != '') ? implode(",",$blind_carbon_copy): '';

		$key = array(
			'mail_subject',
			'from_name',
			'message_content',
			'success_title',
			'success_message',
			'to_address',
			'cc',
			'bcc',
			'status'
		);

		$value = array(
			$this->input->post('mail_subject'),
			$this->input->post('from_name'),
			$this->input->post('message_content'),
			$this->input->post('success_title'),
			$this->input->post('success_message'),
			$to_address,
			$carbon_copy,
			$blind_carbon_copy,
			$status
		);

		// Convert to JSON
		$keyJSON = json_encode($key);
		$valueJSON = json_encode($value);

		$review_entry_mail_config = $this->get_review_entry_mail_config($website_id, 'review_entry_mail_config');

		if (empty($review_entry_mail_config)) :

			$insert_data = array(
				'website_id' => $website_id,
				'code' => 'review_entry_mail_config',
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Insert 
			$this->db->insert('setting', $insert_data);
			return $this->session->set_flashdata('success', 'Successfully Created');

		else :

			$update_data = array(
				'key' => $keyJSON,
				'value' => $valueJSON
			);

			// Update
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'review_entry_mail_config'
			));
			$this->db->update('setting', $update_data);
			return $this->session->set_flashdata('success', 'Successfully Updated');
			
		endif;
	}
	
	// Delete mulitple Banner
    
    function delete_multiple_reviews_entry()
    {
        $reviews = $this->input->post('table_records');
        $page_id = $this->input->post('page_id');
        foreach ($reviews as $review):
            $this->db->where(array(
                'id' => $review,
                'page_id' => $page_id
            ));
            $this->db->update('reviews_entry', array(
                'is_deleted' => 1
            ));
        endforeach;
    }
    
}
?>