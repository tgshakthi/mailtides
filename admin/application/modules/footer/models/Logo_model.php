<?php
/**
 * Logo Models
 *
 * @category Model
 * @package  Logo
 * @author   shiva
 * Created at:  07-june-2018
 * 
 * Modified By : Saravana
 * Modified Date : 18-Feb-2019
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Logo_model extends CI_Model
{
    function get_logo($website_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'website_id' => $website_id,
            'code' => 'footer-logo'
        ));
        $query   = $this->db->get('setting');
        $records = array();        
        if ($query->num_rows() > 0):
            $records = $query->result();            
        endif;        
        return $records;
    }
    /**
     * Get Logo and Logo Details
     * return output as stdClass Object array
     */
    function get_logo_details($website_id)
    {
        $this->db->select(array(
            'id',
            'website_name',
            'website_url',
            'logo',
            'status',
            'is_deleted'
        ));
        $this->db->where(array(
            'id' => $website_id,
            'is_deleted' => 0,
            'status' => 1
        ));
        $query   = $this->db->get('websites');
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
    }
    
    /**
     * Get  Logo Details insert and update operation
     * return output as stdClass Object array
     */
    function insert_update_logo()
    {
        $website_folder_name = $this->admin_header->website_folder_name();
		$website_id = $this->input->post('website_id');
        $logo_img    = $this->input->post('logo');
		$httpUrl = $this->input->post('httpUrl');

		// Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $logo_image = str_replace($find_url, "", $logo_img);

        $key        = array(
            'footer_logo_image',
            'footer_logo_size',
            'footer_logo_status'
        );
        $value[] = $logo_image;
		$value[]    = $this->input->post('logo-size');
		$status     = $this->input->post('status');
        $value[]    = (isset($status)) ? '1' : '0';

        
        $keyJSON   = json_encode($key);
        $valueJSON = json_encode($value);
        
        $logo = $this->get_logo($website_id);
        
        if (empty($logo)) {
            // insert data
            $insert_data = array(
                'website_id' => $website_id,
                'code' => 'footer-logo',
                'key' => $keyJSON,
                'value' => $valueJSON
            );

			
            // Insert 
			$this->db->insert('setting', $insert_data);
			
            return $this->session->set_flashdata('success', 'Logo details Successfully Inserted.');
        } else {
            // Update data
            $update_data = array(
                'key' => $keyJSON,
                'value' => $valueJSON
			);
			
			$this->db->where(array(
				'website_id' => $website_id,
				'code' => 'footer-logo'
			));

			$this->db->update('setting', $update_data);

			return $this->session->set_flashdata('success', 'Logo details Successfully Updated.');
        }
        
    }
    /**
     * Get Logo and Logo Details
     * return output as stdClass Object array
     */
    function get_logo_settings_details($website_id, $logo_val = 'footer-logo')
    {
        $this->db->select(array(
            'id',
            'code',
            'key',
            'value'
        ));
        $this->db->where(array(
            'website_id' => $website_id,
            'code' => $logo_val
        ));
        $query   = $this->db->get('setting');
        $records = array();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $records[] = $row;
            endforeach;
        endif;
        return $records;
	}
	
}