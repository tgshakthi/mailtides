<?php
/**
 * Google Analytic
 *
 * @category Model
 * @package  Google Analytics
 * @author   Saravana
 * Created at:  02-Feb-19
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Google_analytic_model extends CI_Model
{
    private $table_name = "analytics";

    /**
     * Get Google Anlaytics Data
     */

     function get_google_analytics($website_id)
     {
         $this->db->select();
         $this->db->where('website_id', $website_id);
         $query = $this->db->get($this->table_name);

         $records = array();

         if ($query->num_rows() > 0) :
            $records = $query->result();
         endif;

         return $records;
     }

    /**
     * Insert Update Google Analytics
     */

     function insert_update($data)
     {
         $id = $this->input->post('analytic-id');
         $status = $this->input->post('status');
         $status = (isset($status)) ? '1' : '0';


         if(empty($id)) :
            // Insert Data
            $insert_data = array(
                'website_id' => $data['website_id'],
                'analytic_code' => $this->input->post('google-analytic-code'),
                'key_json_file' => $data['upload_data']['file_name'],
                'status' => $status
            );

            $this->db->insert($this->table_name, $insert_data);
            return $this->session->set_flashdata('success', "Successfully Added");
         else :
            // Update Data
            $update_data = array(
                'analytic_code' => $this->input->post('google-analytic-code'),
                'key_json_file' => $data['upload_data']['file_name'],
                'status' => $status
            );

            $this->db->where(
                array(
                    'website_id' => $data['website_id'],
                    'id' => $id
                )
            );

            $this->db->update($this->table_name, $update_data);
            return $this->session->set_flashdata('success', "Successfully Updated");
         endif;
     }

     // Get Key File
     function get_key_file($website_id)
     {
         $this->db->select(array('created_at', 'key_json_file'));
         $this->db->where(
             array(
                 'website_id' => $website_id,
                 'status' => 1
             )
         );
         $query = $this->db->get($this->table_name);
         $records = array();
         if($query->num_rows() > 0) :
            $records = $query->result();
         endif;
         return $records;
     }
}