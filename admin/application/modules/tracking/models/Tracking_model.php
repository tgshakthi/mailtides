<?php
/**
 * Tracking Model
 * 
 * @category Model
 * @package Tracking 
 * @author Saravana
 * Created at: 12-Feb-2019
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Tracking_model extends CI_Model
{
    private $table_name = 'tracking_mail_config';
    private $table_page_not_found = 'page_not_found';
    
    function get_tracking_mail_config($website_id)
    {
        $this->db->select('*');
        $this->db->where('website_id', $website_id);
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    function insert_update_mail_config()
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
        
        $tracking_mail_config_data = array(
            'mail_subject'    => $this->input->post('mail_subject'),
            'from_name'       => $this->input->post('from_name'),
            'message_content' => $this->input->post('message_content'),
            'to_address' 	  => $to_address,
            'cc'       	      => $carbon_copy,
            'bcc'    	 	  => $blind_carbon_copy,
            'status'    	  => $status
        );
    
        $keyJSON = json_encode($tracking_mail_config_data);

        $tracking_mail_config = $this->get_tracking_mail_config($website_id);
        
        if (empty($tracking_mail_config)):

			// insert data

			$insert_data = array(
				'website_id' => $website_id,
				'mail_config' => $keyJSON
            );
            $this->db->insert($this->table_name, $insert_data);
			return $this->session->set_flashdata('success', 'Tracking Mail Configuration Successfully Added.');
		else:

			// Update data

			$update_data = array(
				'mail_config' => $keyJSON,
			);
			$this->db->where(array(
				'website_id' => $website_id
			));
            $this->db->update($this->table_name, $update_data);
            return $this->session->set_flashdata('success', 'Tracking Mail Configuration Successfully Updated.');
		endif;        
       
    }

    /**
     * Get Mail Configuration
     */
	function get_mail_configuration($website_id)
	{
		$this->db->select('*');  
		$this->db->where('website_id', $website_id);  
    	$query = $this->db->get('mail_configuration');
        $records = array();
        
        if ($query->num_rows() > 0) :
            $records = $query->result();      		
    	endif;

    	return $records;
    }
    
    /**
     * Get Page not found
     */
    function get_page_not_found($website_id)
    {
        $this->db->select('*');
        $this->db->where('website_id', $website_id);
        $this->db->where('created_at >=', date('Y-m-d'));
        $query = $this->db->get($this->table_page_not_found);         
        $records = array();

        if($query->num_rows() > 0) :
            $records = $query->result();
        endif;

        return $records;
    }
}