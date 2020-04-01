<?php
/**
 * Email SMS Blast
 * Created at : 09-Jan-2020
 * Author : Velusamy
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_sms_blast_model extends CI_Model
{
	private $table_name = 'email_sms_blast_users';
	private $_name;
   // private $_city;
    private $_startDate;
   
	function __construct() {
        // Set table name
        $this->table = 'email_sms_blast_users';
        // Set orderable column fields
        $this->column_order = array(null, 'name','email','phone_number','provider_name','facility_name','visited_date');
        // Set searchable column fields
        $this->column_search = array('name','email','phone_number','provider_name','facility_name','visited_date');
        // Set default order
        $this->order = array('name' => 'asc');
    }
	
	// Get Patient  Users
    function get_users_data($provider_name, $facility_name)
    {
        $this->db->select('id');
        $this->db->where(array(
            'is_deleted' => '0'
        ));
		$this->db->like('provider_name', $provider_name);
		$this->db->like('facility_name', $facility_name);
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	
	// Get Patient  Users by Id
    function get_users_by_id($user_id)
    {
        $this->db->select('*');
        $this->db->where(array(
			'id' => $user_id,
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	
	// Get Existing Users
    function get_existing_users()
    {
         $this->db->select("email");
         $this->db->where(
             "is_deleted",'0'
         );
        $query = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	
	
	/**
     * Insert Email Sms blast users
     */
    
    function insert($data)
    {
       $this->db->insert_batch($this->table_name, $data);
    }
	
	
	
		
	function get_campaign_category_by_id($id)
	{
		$this->db->select('*');
		$this->db->where(array(
							'id' => $id,
							'is_deleted' => '0'
						));
        $query   = $this->db->get('zcms_campaign_category');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;  
	}
	
	function get_users_data($id)
	{
		$this->db->select('*');
		$this->db->where(array(
							'id' => $id,
							'is_deleted' => '0'
						));
        $query   = $this->db->get('zcms_campaign_category');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;  
	}
	
	
	
	function insert_update_email_templates($id = null)
	{
		$email_template = $this->input->post('template');
		$template_name = $this->input->post('template_name');
		if(!empty($id)){
			$update_array = array(
							'template_name' => $template_name,
							'template' => $email_template,
							'status' => '1'
						);

            $this->db->where('id', $id);
            $this->db->update('zcms_email_template', $update_array);
		}else{
			
		$insert_data = array(
							'template_name' => $template_name,
							'template' => $email_template,
							'status' => '1'
						);
		// Insert into Email Template Data
		$this->db->insert('zcms_email_template', $insert_data);
		}		
	}
	
	// Get Dynamic Email Template
    function get_dynamic_email_template()
	{
        $this->db->select('*');
        $this->db->where(array(
							'status' => '1',
							'is_deleted' => '0'
						 ));
        $query   = $this->db->get('email_template');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	
	 // Get Campaign By Id
    function get_email_template_by_id($id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'id' => $id,
            'is_deleted' => '0'
        ));
        $query   = $this->db->get('email_template');

        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	
	function delete_template_data()
     {
         $id   = $this->input->post('id');
         $data = array(
             'is_deleted' => '1'
         );
         $this->db->where('id', $id);
         return $this->db->update('email_template', $data);
     }
     
    // Delete multiple user
    function delete_multiple_template_data()
    {
        $ids = $this->input->post('table_records');
        foreach ($ids as $media_id):
            $data = array(
                 'is_deleted' => '1'
             );
            $this->db->where('id', $media_id);
            $this->db->update('email_template', $data);
        endforeach;
    }
	 
	function insert_send_email_sms_filter_data($user_id,$campaign_category_id,$track_code)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_data = array(
							'user_id' => $user_id,
							'campaign_category_id' => $campaign_category_id,
							'track_code' => $track_code,
							'sent_date' => $date->format('m/d/Y')
						);
		// Insert into Import Data
		$this->db->insert('zcms_import_data', $insert_data);		
	}
	
	function get_import_send_data($id)
	{
		$this->db->select('user_id');
        $this->db->where(array(
							'campaign_category_id' => $id
						 ));
        $query   = $this->db->get('import_data');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
	}
	function get_import_send_user_data($id)
	{
		$this->db->select('*');
        $this->db->where(array(
							'campaign_category_id' => $id
						 ));
        $query   = $this->db->get('import_data');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
	}
	
	function check_diff_multi($array1, $array2)
	{	
		if(!empty($array1))
		{
			foreach($array1 as $aV)
			{
				$av = json_decode(json_encode($aV));
				$aTmp1[] = $av->id;
			}
		}else{
			$aTmp1 = array();
		}
		if(!empty($array2)){
			foreach($array2 as $aV)
			{
				$av = json_decode(json_encode($aV));
				$aTmp2[] = $av->user_id;
			}
		}else{
			$aTmp2 = array();		
		}		
		$new_array = array_diff($aTmp1,$aTmp2);
		return $new_array;
	}
}