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
	
	// Get Patient  Users
    function get_users()
    {
        $this->db->select('*');
        $this->db->where(array(
            'is_deleted' => '0'
        ));
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
	
	// Get Existing Users
    function get_patient_exist_users($email)
    {
         $this->db->select("email");
         $this->db->where(array(
				"email" => $email,
				"email_sent" => '1',
				"is_deleted" =>'0'
         ));
        $query = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	
	// Get Existing Users
    function get_patient_sms_exist_users($phone_number)
    {
         $this->db->select("phone_number");
         $this->db->where(array(
				"phone_number" => $phone_number,
				"sms_sent" => '1',
				"is_deleted" =>'0'
         ));
        $query = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	
	// Delete
    function delete_user_data()
    {
        $id   = $this->input->post('id');
        $data = array(
            'is_deleted' => '1'
        );
        $this->db->where('id', $id);
        return $this->db->update($this->table_name, $data);
    }
    
    // Delete multiple user
    function delete_multiple_user_data()
    {
        $ids = $this->input->post('table_records');
        foreach ($ids as $media_id):
            $data = array(
                'is_deleted' => '1'
            );
            $this->db->where('id', $media_id);
            $this->db->update($this->table_name, $data);
        endforeach;
    }
	
	/**
     * Insert Email Sms blast users
     */
    
    function insert($data)
    {
       $this->db->insert_batch($this->table_name, $data);
    }
	
	// Get Not Send Email Patient  Users
    function get_not_send_email_users()
    {
        $this->db->select('*');
        $this->db->where(array(
			'import_email_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	
	// Get Not Send Sms Patient  Users
    function get_not_send_sms_users()
    {
        $this->db->select('*');
        $this->db->where(array(
			'import_sms_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	
	function imported_campaign_user_data()
	{
		$this->db->select('id');
        $this->db->where(array(
			'import_email_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function flatten(array $array) 
	{
		$return = array();
		array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
		return $return;
	}
	
	// Insert Campaign Data
    function insert_import_campaign_data()
    {
        $campaign_users = $this->input->post('user_id');
		
        if (!empty($campaign_users)) 
		{
			$imported_campaign_user_datas =  $this->imported_campaign_user_data();
			$array_data= $this->flatten($imported_campaign_user_datas);	
			$existing_import_datas = array_diff($campaign_users, $array_data);
			
			if(!empty($existing_import_datas)):
				foreach($existing_import_datas as $existing_import_data):
					$insert_array = array(
										'import_email_status' => '1'
									);
					$this->db->where('id', $existing_import_data);
					$this->db->update($this->table_name, $insert_array);
				endforeach;
				return '1';
			else:
				return '0';
			endif;
			
        } 
    }
	
	// Get Mail Configuration
    function get_mail_configuration($website_id)
    {
        $this->db->select('*');
        $this->db->where('website_id', $website_id);
        $query   = $this->db->get('mail_configuration');
        $records = array();
        
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        
        return $records;
    }
	
	function get_email_patient_users()
	{
		$this->db->select('*');
        $this->db->where(array(
			'import_email_status' => '1',
			'email_sent' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function update_email_sent_in_master_table($user_id,$tiny_url)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_array = array(
								'email_sent' => '1',
								'email_sent_date' => $date->format('m/d/Y'),
								'email_tiny_url'  => $tiny_url
							);
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, $insert_array);
		
	}
	
	function update_sms_sent_in_master_table($user_id,$tiny_url)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_array = array(
								'sms_sent' => '1',
								'sms_sent_date' => $date->format('m/d/Y'),
								'sms_tiny_url'  => $tiny_url
							);
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, $insert_array);
		
	}
	
	function get_email_track_data()
	{
		$this->db->select('*');
        $this->db->where(array(
			'email_sent' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function imported_sms_campaign_user_data()
	{
		$this->db->select('id');
        $this->db->where(array(
			'import_sms_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function insert_import_sms_campaign_data()
	{
		$campaign_users = $this->input->post('user_id');		
        if (!empty($campaign_users)) 
		{
			$imported_campaign_user_datas =  $this->imported_sms_campaign_user_data();
			$array_data= $this->flatten($imported_campaign_user_datas);	
			$existing_import_datas = array_diff($campaign_users, $array_data);
			
			if(!empty($existing_import_datas)):
				foreach($existing_import_datas as $existing_import_data):
					$insert_array = array(
										'import_sms_status' => '1'
									);
					$this->db->where('id', $existing_import_data);
					$this->db->update($this->table_name, $insert_array);
				endforeach;
				return '1';
			else:
				return '0';
			endif;
			
        } 
	}
	
	function get_sms_patient_users()
	{
		$this->db->select('*');
        $this->db->where(array(
			'import_sms_status' => '1',
			'sms_sent' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function get_sms_data247_data($phone_number)
	{
		$this->db->select('*');
        $this->db->where(array(
			'phone_number' => $phone_number
        ));
        $query   = $this->db->get('zcms_sms_data');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function insert_sms_data($patient_first_name,$patient_email,$phone_number,$sms_address)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York'));
		$insert_data = array(
							'patient_name' => $patient_first_name,
							'email' => $patient_email,
							'phone_number' => $phone_number,
							'sms_data_email' => $sms_address,
							'created_at' => $date->format('m/d/Y')
						);
		// Insert into Sms Data
		$this->db->insert('zcms_sms_data', $insert_data);
	}
	
	function get_sms_track_data()
	{
		$this->db->select('*');
        $this->db->where(array(
			'sms_sent' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function check_patient_phone_number()
	{
		$phone_number = $this->input->post('phone_number');
		$this->db->select('*');
        $this->db->where(array(
							'phone_number' => $phone_number,
							'is_deleted' => '0'
						 ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
        return $records;
    }
    
    function check_patient_phone_number_sms_data($phone_number)
	{
		$phone_number = $this->input->post('phone_number');
		$this->db->select('*');
        $this->db->where(array(
							'phone_number' => $phone_number
						 ));
        $query   = $this->db->get('sms_data');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }

    function check_new_patient_phone_number($phone_number)
	{
		$phone_number = $this->input->post('phone_number');
		$this->db->select('*');
        $this->db->where(array(
							'phone_number' => $phone_number
						 ));
        $query   = $this->db->get('new_patient_data');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
	}
	
	function get_carrier_247data($phone_number)
	{
		$this->db->select('*');
        $this->db->where(array(
							'phone_number' => $phone_number
						 ));
        $query   = $this->db->get('sms_data');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
	}
	
	function insert_new_patients()
	{
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $patient_name =  $last_name.','. $first_name;
		$insert_data = array(
							'patient_name' => $patient_name,
							'patient_email' => $this->input->post('patient_email'),
							'phone_number' => $this->input->post('phone_number'),
							'visited_date' => $this->input->post('visit_date'),
							'provider_name' => $this->input->post('provider_name'),
							'facility_name' => $this->input->post('facility_name'),
							'review' =>'',
							'carrier' => $this->input->post('carrier_data'),
							'created_at' => date("d/m/Y")
						);
		// Insert into Sms Data
		$this->db->insert('zcms_new_patient_data', $insert_data);
    }
    
    function insert_new_patients_master_table()
	{
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $patient_name =  $last_name.','. $first_name;
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		
		$insert_data = array(
							'name' => $patient_name,
							'email' => $this->input->post('patient_email'),
							'phone_number' => $this->input->post('phone_number'),
							'visited_date' => $this->input->post('visit_date'),
							'provider_name' => $this->input->post('provider_name'),
							'facility_name' => $this->input->post('facility_name'),
							'sms_sent' => '1',
							'import_sms_status' => '1',
							'sms_sent_date' => $date->format('m/d/Y'),
							'created_at' => date("d/m/Y")
						);
		// Insert into Sms Data
		$this->db->insert($this->table_name, $insert_data);
	}
	
	function get_campaign_category($website_id)
	{
		$this->db->select('*');
		 $this->db->where(array(
			'website_id' => $website_id,
            'is_deleted' => '0'
        ));
        $query   = $this->db->get('zcms_campaign_category');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;  
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
	
	function insert_update_campaign_category($id = null)
	{
		$status              = $this->input->post('status');
        $status              = (isset($status)) ? '1' : '0';
		if (!empty($id)) 
		{
            $update_array = array(
								'website_id' => $this->input->post('website_id'),
								'category' => $this->input->post('category_name'),
								'web_url' => $this->input->post('web_url'),
								'tiny_url' => $this->input->post('tiny_url'),
								'status' => $status,
								'sort_order' => $this->input->post('sort_order')
							);

            $this->db->where('id', $id);
            $this->db->update('zcms_campaign_category', $update_array);

        } else {
            $insert_array = array(
								'website_id' => $this->input->post('website_id'),
								'category' => $this->input->post('category_name'),
								'web_url' => $this->input->post('web_url'),
								'tiny_url' => $this->input->post('tiny_url'),
								'status' => $status,
								'sort_order' => $this->input->post('sort_order')
							);
    
            $this->db->insert('zcms_campaign_category', $insert_array);
            return $this->db->insert_id();
        }      
	}
	
	function delete_campaign_category()
     {
         $id   = $this->input->post('id');
         $data = array(
						'is_deleted' => '1'
					);
         $this->db->where('id', $id);
         return $this->db->update('zcms_campaign_category', $data);
     }
     
     // Delete multiple user
	 function delete_multiple_campaign_category()
	 {
		 $campaign_categorys = $this->input->post('table_records');
		 foreach ($campaign_categorys as $campaign_category):
			 $data = array(
							'is_deleted' => '1'
						);
			 $this->db->where('id', $campaign_category);
			 $this->db->update('zcms_campaign_category', $data);
		 endforeach;
	 }
	 
	function get_provider_name_by_user($provider_name)
	{	
		$campaign_type = $this->input->post('campaign_type');
		if($campaign_type == 'email'):
			$import_email_sms_status = 'import_email_status';
			$sent = 'email_sent';			
		elseif($campaign_type == 'sms'):
			$import_email_sms_status = 'import_sms_status';
			$sent = 'sms_sent';			
		endif;
		
		$sql_data = "SELECT * FROM `zcms_email_sms_blast_users` where `provider_name` like '".$provider_name."%' and `".$import_email_sms_status."` = '1' and `".$sent."` = '1' ORDER BY `provider_name` ASC";
	
        $query = $this->db->query($sql_data);
		$records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;  
	}
}