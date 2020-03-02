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
	
	function insert_sms_data($user_id, $patient_first_name,$patient_email,$phone_number,$sms_address)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York'));
		$insert_data = array(
							'user_id' => $user_id,
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
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
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
							'created_at' => $date->format('m/d/Y')
						);
		// Insert into Sms Data
		$this->db->insert('zcms_new_patient_data', $insert_data);
    }
    
    function insert_new_patients_master_table($tiny_url)
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
							'sms_tiny_url' => $tiny_url,
							'sms_sent_date' => $date->format('m/d/Y')
						);
		// Insert into Sms Data
		$this->db->insert($this->table_name, $insert_data);
	}
	
	function get_campaign_category($website_id)
	{
		$this->db->select('*');
		 $this->db->where(array(
			'website_id' => $website_id,
			'status' => '1',
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
								'mail_content' => $this->input->post('mail_content'),
								'campaign_type' => $this->input->post('campaign_type_name'),
								'send_email' => $this->input->post('user_email'),
								'password' => $this->input->post('password'),
								'provider_name' => $this->input->post('provider_name'),
								'facility_name' => $this->input->post('facility_name'),
								'template' => $this->input->post('template'),
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
								'mail_content' => $this->input->post('mail_content'),
								'campaign_type' => $this->input->post('campaign_type_name'),
								'send_email' => $this->input->post('user_email'),
								'password' => $this->input->post('password'),
								'provider_name' => $this->input->post('provider_name'),
								'facility_name' => $this->input->post('facility_name'),
								'template' => $this->input->post('template'),
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
			
			$import_fb_email_sms_status = 'import_fb_email_status';
			$fb_email_sms_sent = 'fb_email_sent_status';
			
			$import_dldc_email_sms_status = 'import_dldc_email_status';
			$dldc_sent_email_sms_status = 'dldc_sent_email_status';
		elseif($campaign_type == 'sms'):
			$import_email_sms_status = 'import_sms_status';
			$sent = 'sms_sent';	
			
			$import_fb_email_sms_status = 'import_fb_status';
			$fb_email_sms_sent = 'fb_sent_status';
			
			$import_dldc_email_sms_status = 'import_dldc_sms_status';
			$dldc_sent_email_sms_status = 'dldc_sms_sent_status';			
		endif;
		
		
		if($provider_name == 'facebook'){
			
			$sql_data = "SELECT * FROM `zcms_email_sms_blast_users` where `".$import_fb_email_sms_status."` = '1' and `".$fb_email_sms_sent."` = '1' and `is_deleted` = '0'";
			$query = $this->db->query($sql_data);
			$records = array();
			if($query->num_rows() > 0):
				$records = $query->result();
			endif;
			return $records;
			
		}elseif($provider_name == 'txgidocs'){
			
			$sql_data = "SELECT * FROM `zcms_email_sms_blast_users` where `".$import_dldc_email_sms_status."` = '1' and `".$dldc_sent_email_sms_status."` = '1' and `is_deleted` = '0'";
			$query = $this->db->query($sql_data);
			$records = array();
			if($query->num_rows() > 0):
				$records = $query->result();
			endif;
			return $records;
			
		}else{
			
			$sql_data = "SELECT * FROM `zcms_email_sms_blast_users` where `provider_name` like '".$provider_name."%' and `".$import_email_sms_status."` = '1' and `".$sent."` = '1' ORDER BY `provider_name` ASC";
			$query = $this->db->query($sql_data);
			$records = array();
			if($query->num_rows() > 0):
				$records = $query->result();
			endif;
			return $records;
		}
	}
	
	function insert_master_resend_table_sms_data($user_id,$tiny_url)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_array = array(
								'sms_sent_date' => $date->format('m/d/Y'),
								'sms_tiny_url'  => $tiny_url
							);
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, $insert_array);
	}
	
	function update_email_resend_in_master_table($user_id,$tiny_url)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_array = array(
								'email_sent_date' => $date->format('m/d/Y'),
								'email_tiny_url'  => $tiny_url
							);
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, $insert_array);
	}
	
	// Get Not Send Facebook Patient  Users
    function get_not_send_facebook_users()
    {
        $this->db->select('*');
        $this->db->where(array(
			'import_fb_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	
	function imported_fb_campaign_user_data()
	{
		$this->db->select('id');
        $this->db->where(array(
			'import_fb_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function insert_import_fb_campaign_data()
	{
		$campaign_users = $this->input->post('user_id');		
        if (!empty($campaign_users)) 
		{
			$imported_campaign_user_datas =  $this->imported_fb_campaign_user_data();
			$array_data= $this->flatten($imported_campaign_user_datas);	
			$existing_import_datas = array_diff($campaign_users, $array_data);
			
			if(!empty($existing_import_datas)):
				foreach($existing_import_datas as $existing_import_data):
					$insert_array = array(
										'import_fb_status' => '1'
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
	
	function get_fb_patient_users()
	{
		$this->db->select('*');
        $this->db->where(array(
			'import_fb_status' => '1',
			'fb_sent_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function update_fb_sms_sent_in_master_table($user_id,$tiny_url)
	{
		
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_array = array(
								'fb_sent_status' => '1',
								'fb_sent_date' => $date->format('m/d/Y'),
								'fb_tiny_url'  => $tiny_url
							);
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, $insert_array);
	}
	
	function get_facebook_sms_track_data()
	{
		$this->db->select('*');
        $this->db->where(array(
			'fb_sent_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	// Get Not Send Facebook Email Patient  Users
    function get_not_send_email_facebook_users()
    {
        $this->db->select('*');
        $this->db->where(array(
			'import_fb_email_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	
	function insert_import_fb_email_campaign_data()
	{
		$campaign_users = $this->input->post('user_id');		
        if (!empty($campaign_users)) 
		{
			$imported_campaign_user_datas =  $this->imported_fb_email_campaign_user_data();
			$array_data= $this->flatten($imported_campaign_user_datas);	
			$existing_import_datas = array_diff($campaign_users, $array_data);
			
			if(!empty($existing_import_datas)):
				foreach($existing_import_datas as $existing_import_data):
					$insert_array = array(
										'import_fb_email_status' => '1'
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
	
	function imported_fb_email_campaign_user_data()
	{
		$this->db->select('id');
        $this->db->where(array(
			'import_fb_email_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function get_fb_email_patient_users()
	{
		$this->db->select('*');
        $this->db->where(array(
			'import_fb_email_status' => '1',
			'fb_email_sent_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function update_fb_email_sent_in_master_table($user_id,$tiny_url)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_array = array(
								'fb_email_sent_status' => '1',
								'fb_email_sent_date' => $date->format('m/d/Y'),
								'fb_email_tiny_url'  => $tiny_url
							);
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, $insert_array);
	}
	
	function get_facebook_email_track_data()
	{
		$this->db->select('*');
        $this->db->where(array(
			'fb_email_sent_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function get_not_send_txgidocs_email_users()
	{
		$this->db->select('*');
        $this->db->where(array(
			'import_dldc_email_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
	}
	
	function insert_import_dldc_email_campaign_data()
	{
		$campaign_users = $this->input->post('user_id');		
        if (!empty($campaign_users)) 
		{
			$imported_campaign_user_datas =  $this->imported_dldc_email_campaign_user_data();
			$array_data= $this->flatten($imported_campaign_user_datas);	
			$existing_import_datas = array_diff($campaign_users, $array_data);
			
			if(!empty($existing_import_datas)):
				foreach($existing_import_datas as $existing_import_data):
					$insert_array = array(
										'import_dldc_email_status' => '1'
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
	
	function imported_dldc_email_campaign_user_data()
	{
		$this->db->select('id');
        $this->db->where(array(
			'import_dldc_email_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function get_dldc_email_patient_users()
	{
		$this->db->select('*');
        $this->db->where(array(
			'import_dldc_email_status' => '1',
			'dldc_sent_email_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function update_dldc_email_sent_in_master_table($user_id,$tiny_url)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_array = array(
								'dldc_sent_email_status' => '1',
								'dldc_sent_email_date' => $date->format('m/d/Y'),
								'dldc_email_tiny_url'  => $tiny_url
							);
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, $insert_array);	
	}
	
	function get_txgidocs_email_track_data()
	{
		$this->db->select('*');
        $this->db->where(array(
			'dldc_sent_email_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function get_not_send_txgidocs_users()
	{
		$this->db->select('*');
        $this->db->where(array(
			'import_dldc_sms_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records; 
	}
	
	function insert_import_dldc_sms_campaign_data()
	{
		$campaign_users = $this->input->post('user_id');		
        if (!empty($campaign_users)) 
		{
			$imported_campaign_user_datas =  $this->imported_dldc_sms_campaign_user_data();
			$array_data= $this->flatten($imported_campaign_user_datas);	
			$existing_import_datas = array_diff($campaign_users, $array_data);
			
			if(!empty($existing_import_datas)):
				foreach($existing_import_datas as $existing_import_data):
					$insert_array = array(
										'import_dldc_sms_status' => '1'
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
	
	function imported_dldc_sms_campaign_user_data()
	{
		$this->db->select('id');
        $this->db->where(array(
			'import_dldc_sms_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function get_dldc_sms_patient_users()
	{
		$this->db->select('*');
        $this->db->where(array(
			'import_dldc_sms_status' => '1',
			'dldc_sms_sent_status' => '0',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
	function update_dldc_sms_sent_in_master_table($user_id, $tiny_url)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_array = array(
								'dldc_sms_sent_status' => '1',
								'dldc_sms_sent_date' => $date->format('m/d/Y'),
								'dldc_sms_tiny_url'  => $tiny_url
							);
		$this->db->where('id', $user_id);
		$this->db->update($this->table_name, $insert_array);	
	}
	
	function get_txgidocs_sms_track_data()
	{
		$this->db->select('*');
        $this->db->where(array(
			'dldc_sms_sent_status' => '1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
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
	function get_import_send_user_datass($id,$provider_name,$facility_name)
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
	
	function update_send_email_sms_filter_data($user_id,$campaign_category_id,$track_code)
	{
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		$insert_array = array(
								'link_open' => '0',
								'sent_date' => $date->format('m/d/Y'),
								'open_date'  => ''
							);
		$this->db->where(array(
						'user_id' =>$user_id,
						'campaign_category_id' => $campaign_category_id,
						'track_code' => $track_code
						));
		$this->db->update('import_data', $insert_array);
	}
	function get_graphics_data($campaign_type)
	{
		$this->db->select('*');
        $this->db->where(array(
			'campaign_type' => $campaign_type,
            'is_deleted' => '0'
        ));
        $query   = $this->db->get('campaign_category');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records; 
	}
	
    
    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData){
        $this->_get_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Count all records
     */
    function countAll(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
     function _get_datatables_query($postData){         
        $this->db->from($this->table); 
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($this->column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	
	function get_patient_user_data()
	{
		$sql           = "SELECT *";
        $sql          .= " FROM zcms_email_sms_blast_users WHERE is_deleted = 0 ORDER BY `name` ASC";
        $query         = $this->db->query($sql);        
        $totalData     = $query->num_rows();
		return $totalData;
	}
	
	
    function setName($name) {
        $this->_name = $name;
    }    
    function setStartDate($startDate) {
        $this->_startDate = $startDate;
    }
   
	// get Orders List
    function getOrders() {        
         $this->db->select('*');
      //'id,product_name,product_price,product_image,status,created_at'
	   $this->db->from($this->table_name);
	    $this->db->where(array(
					'is_deleted' => '0'
	   ));
        if(!empty($this->_startDate)){
            $this->db->where(array(
					'visited_date' => $this->_startDate
				));
          $this->db->last_query();
	   }            
        if(!empty($this->_name)){            
            $this->db->like('name', $this->_name, 'both');
        }       
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_date_range_graphical_report($campaign_name_data_id,$graphics_min,$graphics_max)
	{
		$sql = "SELECT * from `zcms_import_data` where `campaign_category_id` = ".$campaign_name_data_id." AND `sent_date` BETWEEN ".$graphics_min." AND ".$graphics_max."";
		$query         = $this->db->query($sql);        
        $totalData     = $query->num_rows();
		 return $query->result_array();
	}
}