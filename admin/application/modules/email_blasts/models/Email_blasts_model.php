<?php
/**
 * Email Blast Model
 * Created at : 23-July-2019
 * Author : Saravana
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_blasts_model extends CI_Model
{
    private $table_name = 'email_blast_users';
    private $table_track = 'email_tracks';
    private $table_campaign = 'campaigns';
    private $table_campaign_users = 'campaign_users';
	private $table_campaign_type = 'campaign_type';
    private $table_template ='email_templates';
	private $table_sms_gateway = 'sms_gateway';
	private $table_campaign_category_import_data = 'campaign_category_import_data';
	private $table_sms_template = 'sms_template';
	private $table_campaign_category = "campaign_category";

    // Get Users
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
	// Get Users by id
    function get_users_by_id($id)
    {
        $this->db->select('*');
        $this->db->where(array(
							'id' => $id,
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
             "is_deleted", '0'
         );
        $query = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }

    /**
     * Insert Email blast users
     */
    
    function insert($data)
    {
       $this->db->insert_batch($this->table_name, $data);
    }

    // Get Campaign
    function get_campaign()
    {
        $this->db->select('*');
        $this->db->where(array(
           'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_campaign);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    function get_campaign_name_Bi_reports($campaign_category_id)
    {
        $this->db->select('*');
        $this->db->where(array(
			'category_id' => $campaign_category_id,
            'status'=>'1',
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_campaign);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	 // Get Campaign
    function get_campaign_name()
    {
        $this->db->select('campaign_name');
        $this->db->where(array(
           'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_campaign);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }

    // Get Campaign users
    function get_campaign_users()
    {
        $this->db->select('*');
        $query   = $this->db->get($this->table_campaign_users);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }

    // Insert Campaign
    function insert_campaign($data)
    {
        $this->db->insert_batch($this->table_campaign, $data);
        return $this->db->insert_id();
    }

    // Insert Campaign Users
    function insert_campaign_users($data)
    {
        $this->db->insert_batch($this->table_campaign_users, $data);
    }

    // Get Campaign By Id
    function get_campaign_by_id($id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'id' => $id,
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_campaign);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }

//check_campaign_name
   function check_campaign_name($campaign_name)
   {
     $this->db->select('*');
     $this->db->where(array(
         'campaign_name'=>$campaign_name,
         'is_deleted'=>'0'
     ));
     $query   = $this->db->get($this->table_campaign);
     $records = array();
     if ($query->num_rows() > 0):
         $records = $query->result();
     endif;
     return $records;
   }
    // Get Existing Campaign Users
    function get_existing_campaign_users()
    {
         $this->db->select("email");
        $query = $this->db->get($this->table_campaign_users);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }

    // Update Campaign Users
    function update_campaign($data)
    {
        $this->db->update_batch($this->table_campaign, $data, 'id');
    }

    // Get Campaign Details
    function get_campaign_detials($campaign_type)
    {
        $this->db->select('id, campaign_name,template_id','campaign_type');
        $this->db->where(array(
			'campaign_type' => $campaign_type,
            'status'=>'1',
            'is_deleted'=>'0'
       ));
       $query   = $this->db->get($this->table_campaign);
       $records = array();
       if ($query->num_rows() > 0):
           $records = $query->result();
       endif;
       return $records;
    }
	
	// Get Campaign Details
    function get_sms_campaign_detials()
    {
        $this->db->select('id, campaign_name,template_id','campaign_type');
        $this->db->where(array(
			'campaign_type' => 'sms',
            'status'=>'1',
            'is_deleted'=>'0'
       ));
       $query   = $this->db->get($this->table_campaign);
       $records = array();
       if ($query->num_rows() > 0):
           $records = $query->result();
       endif;
       return $records;
    }
	
    // Get Campaign Template
    function get_campaign_template($campaign_id)
    {
        $this->db->select('template_id');
        $this->db->where(array(
            'id' => $campaign_id,
			'campaign_type' => 'email',
            'is_deleted' => '0',
            'status' => '1'
        ));
        $query = $this->db->get($this->table_campaign);
        $records = array();
        if ($query->num_rows() > 0 ) :
          $records = $query->result();
        endif;
        return $records;
    }
	 function get_campaign_sms_template($campaign_id)
    {
        $this->db->select('template_id');
        $this->db->where(array(
            'id' => $campaign_id,
			'campaign_type' => 'sms',
            'is_deleted' => '0',
            'status' => '1'
        ));
        $query = $this->db->get($this->table_campaign);
        $records = array();
        if ($query->num_rows() > 0 ) :
          $records = $query->result();
        endif;
        return $records;
    }

    // Get Campaign users By Campaign ID
    function get_campaign_users_by_campaign_id($id)
    {
        $this->db->select('*');
        $this->db->where(
            array(
                'id' => $id
            )
        );
        $query = $this->db->get($this->table_campaign);
        $records = array();
        if ($query->num_rows() > 0 ) :
          $records = $query->result();
        endif;
        return $records;
    }

     // Get Email Track Users
     function get_email_track_users()
     {
         $this->db->select('*');
         $this->db->where(array(
             'status' => '0'
         ));
         $query = $this->db->get($this->table_track);
         $records = array();
         if ($query->num_rows() > 0 ) :
           $records = $query->result();
         endif;
         return $records;
     }

    //
    //check_campaign type name
   function check_campaign_type_name($campaign_name,$website_id)
   {
     $this->db->select('*');
     $this->db->where(array(
         'website_id'=>$website_id,
         'campaign_type'=>$campaign_name,

         'is_deleted'=>'0'
     ));
     $query   = $this->db->get($this->table_campaign_type);
     $records = array();
     if ($query->num_rows() > 0):
         $records = $query->result();
     endif;
     return $records;
   }

    /**
     * Get users
     */
    function get_blast_users()
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
    
    /**
     * Get users by id
     */
    function get_blast_users_by_id($id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'id' => $id,
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    
     
     function get_template_id_by_campaign($id)
     {
         $this->db->select('template_id');
         $this->db->where(
             array(
                 'id'=>$id,
                 'status'=>'1',
                 'is_deleted'=>'0'
             )
         );
         $query   = $this->db->get('campaign');
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
    
    function get_email_track_data()
    {
        $this->db->select('*');
		$this->db->where(array(
            'type' => 'email'
        ));
        $query   = $this->db->get('email_tracks');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	 function get_sms_track_data()
    {
        $this->db->select('*');
		$this->db->where(array(
            'type' => 'sms'
        ));
        $query   = $this->db->get('email_tracks');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    function get_email_track_data_by_campaign_id($campaign_id, $campaign_type)
    {
        $this->db->select('*');
        $this->db->where(array(
            'campaign_id' => $campaign_id,
			'type' => $campaign_type
        ));
        $query   = $this->db->get('email_tracks');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    // Get Mail Config
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
    
    // Track 
    function insert_track($campaign_id, $id, $name, $email, $phone_no, $visited_date, $track_code, $subject, $from_name, $from_email,$type)
    {
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
		if($type == 'email'){
			$email_sent_date = $date->format('m/d/Y');
		}else{
			$email_sent_date = '';
		}
		if($type == 'sms'){
			$sms_sent_date = $date->format('m/d/Y');
		}else{
			$sms_sent_date = '';
		}
        $insert_array = array(
            'campaign_id' => $campaign_id,
            'track_id' => $id,
            'name' => $name,
            'email' => $email,
			'phone_number' => $phone_no,
            'visited_date' => $visited_date,
            'track_code' => $track_code,
            'subject' => $subject,
            'from_name' => $from_name,
            'from_email' => $from_email,
			'type' => $type,
			'email_sent_date' => $email_sent_date,
			'sms_sent_date' => $sms_sent_date,
            'status' => '0'
        );
        
        $this->db->insert($this->table_track, $insert_array);
    }
    
    // Update Track Code
    function update_track_code($track_code)
    {
        $update_data = array(
            'status' => '1'
        );       
        
        $this->db->where('track_code', $track_code);
        $this->db->update($this->table_track, $update_data);
    }
	// Update Send Email Status
    function update_send_email_status($campaign_id,$user_id)
    {
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
        $update_data = array(
			'email_sent_date' => $date->format('m/d/Y'),
            'email_status' => '1'
        );       
        // print_r($update_data);die;
        $this->db->where('campaign_id', $campaign_id);
		$this->db->where('user_id', $user_id);
		$this->db->where('campaign_type', 'email');
        $this->db->update($this->table_campaign_category_import_data, $update_data);
    }
    
    function get_review_comments($id)
    {
        $this->db->select('review_user_id');
        $this->db->where('review_user_id', $id);
        $query   = $this->db->get('reviews_entry');
        $records = array();
        
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;        
        return $records;
    }
    

   
    function delete_campaign_data()
    {
        $id   = $this->input->post('id');
        $data = array(
            'is_deleted' => '1'
        );
        $this->db->where('id', $id);
        return $this->db->update($this->table_campaign, $data);
    }
    
    // Delete multiple user
    function delete_multiple_campaign_data()
    {
        $ids = $this->input->post('table_records');
        foreach ($ids as $media_id):
            $data = array(
                'is_deleted' => '1'
            );
            $this->db->where('id', $media_id);
            $this->db->update($this->table_campaign, $data);
        endforeach;
    }

    function insert_update_campaign($id=null)
    {
      
     
        $status = $this->input->post('status');
		$status = (isset($status)) ? '1' : '0';
		if ($id == NULL):

			// insert data

			$insert_data = array(
			
				'name' => $this->input->post('name') ,
                 'description'=>$this->input->post('description'),
                 'template_id'=>$this->input->post('template_id'),
				'status' => $status
			);
          $this->db->insert($this->table_campaign, $insert_data);
          return $this->db->insert_id();
           else:

			// Update data

			$update_data = array(
				
				'name' => $this->input->post('name') ,
                 'description'=>$this->input->post('description'),
                 'template_id'=>$this->input->post('template_id'),
				'status' => $status
			);
  	// Update

			$this->db->where('id', $id);
			return $this->db->update($this->table_campaign, $update_data);
		endif;

    }
    
    function get_users_by_campaign_id($campaign)
    {
        $this->db->select('*');
        $this->db->where('FIND_IN_SET('.$campaign.',campaign_id)>0');
        $this->db->where(
            array(
             'status'=>'1',
            'is_deleted'=>'0' 
        ));
        $query  = $this->db->get($this->table_name); 
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }

    function get_email_track($email)
    {
        $this->db->select('*');
        $this->db->where(
            array(
                'email' => $email
            )
        );
        $this->db->limit(1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->table_track);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
	function get_campaign_data($id)
    {
		$this->db->select('campaign_users');
        $where = "FIND_IN_SET('".$id."', campaign_users)";  
		$this->db->where($where);     
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->table_campaign);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	
     // Get Template
     function get_email_template()
     {
         $this->db->select('*');
         $this->db->where(array(
            'is_deleted' => '0'
         ));
         $query   = $this->db->get($this->table_template);
         $records = array();
         if ($query->num_rows() > 0):
             $records = $query->result();
         endif;
         return $records;
     }
	  // Get Sms Template
     function get_sms_template()
     {
         $this->db->select('*');
         $this->db->where(array(
            'is_deleted' => '0'
         ));
         $query   = $this->db->get($this->table_sms_template);
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
        $query   = $this->db->get($this->table_template);

        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	
	  // Get Campaign By Id
    function get_sms_template_by_id($id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'id' => $id,
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_sms_template);

        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	function delete_sms_template_data()
     {
         $id   = $this->input->post('id');
         $data = array(
             'is_deleted' => '1'
         );
         $this->db->where('id', $id);
         return $this->db->update($this->table_sms_template, $data);
     }
     // Delete multiple user
     function delete_multiple_sms_template_data()
     {
         $ids = $this->input->post('table_records');
         foreach ($ids as $media_id):
             $data = array(
                 'is_deleted' => '1'
             );
             $this->db->where('id', $media_id);
             $this->db->update($this->table_sms_template, $data);
         endforeach;
     }
     function delete_template_data()
     {
         $id   = $this->input->post('id');
         $data = array(
             'is_deleted' => '1'
         );
         $this->db->where('id', $id);
         return $this->db->update($this->table_template, $data);
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
             $this->db->update($this->table_template, $data);
         endforeach;
     }
 

       // Remove Image
    
    function remove_email_template_image()
    {
        $id           = $this->input->post('id');
        $remove_image = array(
            'image' => ""
        );
        $this->db->where('id', $id);
        $this->db->update($this->table_template, $remove_image);
    }
     function insert_update_email_template($id=null)
     {
       
        $website_folder_name = $this->admin_header->website_folder_name();
        $status              = $this->input->post('status');
        $status              = (isset($status)) ? '1' : '0';
        $image               = $this->input->post('image');
        $httpUrl             = $this->input->post('httpUrl');
         // Remove Host URL in image
        //$find_url = $httpUrl . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR;
        
        $find_url = $httpUrl . '/images/' . $website_folder_name . '/';
        $image    = str_replace($find_url, "", $image);
        
         if ($id == NULL):
 
             // insert data
 
             $insert_data = array(
             
                 'template_name' => $this->input->post('template_name') ,
                  'template'=>$this->input->post('template'),
                  'image'=>$image,
               
                 'status' => $status
             );
           $this->db->insert($this->table_template, $insert_data);
           return $this->db->insert_id();
            else:
 
             // Update data
 
             $update_data = array(
                 
                 'template_name' => $this->input->post('template_name') ,
                  'template'=>$this->input->post('template'),
                  'image'=>$image,
                  'status' => $status
             );
       // Update
 
             $this->db->where('id', $id);
             return $this->db->update($this->table_template, $update_data);
         endif;
 
     }
	 
	  function insert_update_sms_template($id=null)
     {
       
        $website_folder_name = $this->admin_header->website_folder_name();
        $status              = $this->input->post('status');
        $status              = (isset($status)) ? '1' : '0';
      
         if ($id == NULL):
 
             // insert data
 
             $insert_data = array(
             
                 'template_name' => $this->input->post('template_name') ,
                 'status' => $status
             );
           $this->db->insert($this->table_sms_template, $insert_data);
           return $this->db->insert_id();
            else:
 
             // Update data
 
             $update_data = array(
                 
                 'template_name' => $this->input->post('template_name') ,
                  'status' => $status
             );
       // Update
 
             $this->db->where('id', $id);
             return $this->db->update($this->table_sms_template, $update_data);
         endif;
 
     }
	 
	 // Get Campaign Type
    function get_campaign_type($website_id)
    {
        $this->db->select('*');
        $this->db->where(array(
						    'website_id' => $website_id,
							'is_deleted' => '0'
						));
        $query   = $this->db->get($this->table_campaign_type);
		 $records = array();
         if ($query->num_rows() > 0):
             $records = $query->result();
         endif;
         return $records;
    }
    
    	 // Get Campaign Type  status
         function get_campaign_type_status($website_id)
         {
             $this->db->select('*');
             $this->db->where(array(
                                 'website_id' => $website_id,
                                 'status'=>'1',
                                 'is_deleted' => '0'
                             ));
             $query   = $this->db->get($this->table_campaign_type);
              $records = array();
              if ($query->num_rows() > 0):
                  $records = $query->result();
              endif;
              return $records;
         }

         //camapign users
         function  select_campaign_user($campaign_type)
         {
             $this->db->select('campaign_users');
             $this->db->where(array(
                 'campaign_type'=>$campaign_type,
                 'status'=>'1',
                 'is_deleted'=>'0'
             ));
             $query   = $this->db->get($this->table_campaign);
             $records = array();
             if ($query->num_rows() > 0):
                 $records = $query->result();
             endif;
             return $records;
         }
	 // Get Campaign By Id
    function get_campaign_type_by_id($id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'id' => $id,
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_campaign_type);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }

	 function insert_update_campaign_type($id=null)
     {
		$website_id =  $this->input->post('website_id');
        $status = $this->input->post('status');
        $status = (isset($status)) ? '1' : '0';
         if ($id == NULL):
 
             // insert data 
             $insert_data = array(
				 'website_id' => $website_id,
                 'campaign_type' => $this->input->post('campaign_type') ,            
                 'status' => $status
             );
           $this->db->insert($this->table_campaign_type, $insert_data);
           return $this->db->insert_id();
            else:
 
             // Update data
 
             $update_data = array(                
                 'campaign_type' => $this->input->post('campaign_type'),
                 'status' => $status
             );
       // Update
 
             $this->db->where(array('id'=>$id,'website_id'=>$website_id));
             return $this->db->update($this->table_campaign_type, $update_data);
         endif;
 
     }
	 
	 function delete_campaign_type()
     {
         $id   = $this->input->post('id');
         $data = array(
             'is_deleted' => '1'
         );
         $this->db->where('id', $id);
         return $this->db->update($this->table_campaign_type, $data);
     }
     
     // Delete multiple user
     function delete_multiple_campaign_type()
     {
         $campaign_type = $this->input->post('table_records');
         foreach ($campaign_type as $campaign_type_id):
             $data = array(
                 'is_deleted' => '1'
             );
             $this->db->where('id', $campaign_type_id);
             $this->db->update($this->table_campaign_type, $data);
         endforeach;
     }

	function imported_campaign_user_data($campaign_id, $campaign_category_id)
	{
		$this->db->select('user_id');
        $this->db->where(array(
			'campaign_id' => $campaign_id,
            'campaign_category_id' => $campaign_category_id
        ));
        $query   = $this->db->get($this->table_campaign_category_import_data);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
	
    // Insert Campaign Data
    function insert_import_campaign_data()
    {
		$campaign_category_id  = $this->input->post('campaign_category_id');
        $campaign_id = $this->input->post('campaign_id');       
        $campaign_name = $this->input->post('campaign_name');
        $campaign_desc = $this->input->post('campaign_desc');
        $campaign_type = $this->input->post('campaign_type');
        $send_date = $this->input->post('send_date');
        $campaign_users = $this->input->post('user_id');
        $email_template = $this->input->post('email_template');
		
        if (!empty($campaign_id)) {
			$imported_campaign_user_datas =  $this->imported_campaign_user_data($campaign_id, $campaign_category_id);
			$array_data= $this->flatten($imported_campaign_user_datas);	
			$existing_import_datas = array_diff($campaign_users, $array_data);			
			$update_campaign_data =  array(
								'category_id' => $campaign_category_id,
								'campaign_name' => $campaign_name,
								'description' => $campaign_desc,
								'campaign_type' => $campaign_type,
								'send_date' => $send_date,
								'template_id' => $email_template
							);
			$this->db->where('id', $campaign_id);
			$this->db->update($this->table_campaign, $update_campaign_data);
			
			if(!empty($existing_import_datas)):
				foreach($existing_import_datas as $existing_import_data):
					$insert_array = array(
										'campaign_category_id' => $campaign_category_id,										
										'campaign_id' => $campaign_id,
										'user_id' => $existing_import_data,
										'campaign_type' => $campaign_type
									);
					$this->db->insert($this->table_campaign_category_import_data, $insert_array);
				endforeach;
			endif; 
			return $campaign_id;			
        } else {
			$insert_campaign_data =  array(
								'category_id' => $campaign_category_id,
								'campaign_name' => $campaign_name,
								'description' => $campaign_desc,
								'campaign_type' => $campaign_type,
								'send_date' => $send_date,
								'template_id' => $email_template
							);
			$this->db->insert($this->table_campaign, $insert_campaign_data);
			return $this->db->insert_id();
        }     
    }
	function flatten(array $array) {
		$return = array();
		array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
		return $return;
	}
    // //campaign users
    // function  campaign_type_users($campign_type,$campaign_users)
    // {
    //  $this->db->select('campaign_type,campaign_users');
    //  $this->db->where(array(
    //      'campaign_type'=>$campign_type,
    //      'campaign_users'=>$campaign_users
    //  ));
    //  $query = $this->db->get($this->table_campaign);
    //  $records = array();
    //  if ($query->num_rows() > 0 ) :
    //    $records = $query->result();
    //  endif;
    //  return $records;
    // }

    // Get Campaign Type - Campaign (By Status)
    function get_campaign_type_by_status($website_id)
    {
        $this->db->select('*');
        $this->db->where(
            array(
                'website_id' => $website_id,
                'status' => '1',
                'is_deleted' => '0'
            )            
        );
        $query = $this->db->get($this->table_campaign_type);
        $records = array();
        if ($query->num_rows() > 0 ) :
          $records = $query->result();
        endif;
        return $records;
    }

    // Get Email Template - campaign (By Status)
    function get_email_template_by_status()
    {
        $this->db->select('*');
        $this->db->where(array(
            'status' => '1',
            'is_deleted' => '0'
        ));
        $query = $this->db->get($this->table_template);
        $records = array();
        if ($query->num_rows() > 0 ) :
          $records = $query->result();
        endif;
        return $records;        
    }
	 // Get SMS Template - campaign (By Status)
    function get_sms_template_by_status()
    {
        $this->db->select('*');
        $this->db->where(array(
            'status' => '1',
            'is_deleted' => '0'
        ));
        $query = $this->db->get($this->table_sms_template);
        $records = array();
        if ($query->num_rows() > 0 ) :
          $records = $query->result();
        endif;
        return $records;        
    }
    function get_campaign_users_by_campaign_type($id)
    {
        $this->db->select('name,email');
        $this->db->where(array(
            'id'=>$id,
            'is_deleted'=>'0'
        ));
       $query= $this->db->get($this->table_name);
       $records = array();
       if ($query->num_rows() > 0 ) :
         $records = $query->result();
       endif;
       return $records; 
    }
	// Get Phone Numbers
    function get_patient_phone_numbers()
    {
        $this->db->select('*');
		 $this->db->where(array(
            'status' => '0',
            'invalid_no' => '0'
        ));
        $query   = $this->db->get($this->table_sms_gateway);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	// Get Phone Numbers by campaign id
    function get_patient_phone_numbers_by_campaign_id($campaign)
    {
        $this->db->select('*');
		 $this->db->where(array(
			'campaign_id' => $campaign,
			'campaign_type' => 'sms',
            'sms_status' => '0'           
        ));
        $query   = $this->db->get($this->table_campaign_category_import_data);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	// Get Phone Numbers by campaign id
    function get_campaign_user_data_Bi_reports($campaign, $campaign_type)
    {
        $this->db->select('*');
		 $this->db->where(array(
			'campaign_id' => $campaign,
			'campaign_type' => $campaign_type
        ));
        $query   = $this->db->get($this->table_campaign_category_import_data);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	function insert_sms_gateway_status($user_id,$campaign)
	{
		$data = array(
			 'sms_sent_date' => date("m/d/Y"),
			 'sms_status' => '1'
		 );
		 $this->db->where('user_id', $user_id);
		 $this->db->where('campaign_id', $campaign);
		 $this->db->where('campaign_type', 'sms');
		 $this->db->update($this->table_campaign_category_import_data, $data);
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
		if (!empty($id)) 
		{
            $update_array = array(
								'website_id' => $this->input->post('website_id'),
								'category' => $this->input->post('category_name'),
								'sort_order' => $this->input->post('sort_order')
							);

            $this->db->where('id', $id);
            $this->db->update('zcms_campaign_category', $update_array);

        } else {
            $insert_array = array(
								'website_id' => $this->input->post('website_id'),
								'category' => $this->input->post('category_name'),
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
	 
	 /**
	 * Get Selected Campaign Category
	 * return output as stdClass Object array
	 */
	function selected_category($category_id)
	{
		$this->db->select(array('id', 'category'));
		$this->db->where('id', $category_id);
		$query = $this->db->get('zcms_campaign_category');
		$records = array();
		if ($query->num_rows() > 0):		
			$records= $query->result();			
		endif;
		return $records;
	}
	
	// Insert Campaign Category
	function insert_campaign_category()
	{		
		$insert_data = array(
							'website_id' => $this->input->post('website_id'),
							'category' => $this->input->post('category_name'),
							'sort_order' => $this->input->post('sort_order')
						);

		// Insert into Event Category

		$this->db->insert('zcms_campaign_category', $insert_data);
	}
	
	/**
	 * Get Select Event Category
	 * return output as stdClass Object array
	 */
	function select_campaign_category($website_id, $search)
	{
		$sql_data = "SELECT * FROM " . $this->db->dbprefix('zcms_campaign_category') . " WHERE name LIKE '%".$search."%' AND website_id = '".$website_id."' AND is_deleted = 0";
		$query = $this->db->query($sql_data);
		$records = array();
		if ($query->num_rows() > 0):			
				$records= $query->result();		
		endif;
		return $records;
	}
	function get_campaign_users_by_campaign_data($campaign_id)
	{
		$this->db->select('*');
        $this->db->where(
            array(
                'campaign_id' => $campaign_id,
				'email_status' => '0'
            )
        );
        $query = $this->db->get($this->table_campaign_category_import_data);
        $records = array();
        if ($query->num_rows() > 0 ) :
          $records = $query->result();
        endif;
        return $records;
	}
	
	function get_patient_users($user_id)
	{
		$this->db->select('*');
        $this->db->where(
            array(
                'id' => $user_id,
				'is_deleted' => '0'
            )
        );
        $query = $this->db->get($this->table_name);
        $records = array();
        if ($query->num_rows() > 0 ) :
          $records = $query->result();
        endif;
        return $records;
	}
	
	// Get Campaign Category
    function get_campaign_category_data()
    {
        $this->db->select('*');
        $this->db->where(array(
            'is_deleted' => '0'
        ));
        $query   = $this->db->get($this->table_campaign_category);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	
	// Get Dynamic Email Template
    function get_dynamic_email_template()
	{
        $this->db->select('*');
        $this->db->where(array(
							'is_deleted' => '0'
						 ));
        $query   = $this->db->get('email_template');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
	
	function insert_sms_data($user_id,$patient_first_name,$email,$phone_number,$sms_address)
	{
		$insert_data = array(
							'user_id' => $user_id,
							'patient_name' => $patient_first_name,
							'email' => $email,
							'phone_number' => $phone_number,
							'sms_data_email' => $sms_address,
							'created_at' => date("d/m/Y")
						);

		// Insert into Sms Data

		$this->db->insert('zcms_sms_data', $insert_data);
	}
	
	function check_patient_phone_number()
	{
		$phone_number = $this->input->post('phone_number');
		$this->db->select('*');
        $this->db->where(array(
							'phone_number' => $phone_number,
							'is_deleted' => '0'
						 ));
        $query   = $this->db->get('email_blast_users');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
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
							'review' => $this->input->post('review'),
							'carrier' => $this->input->post('carrier_data'),
							'created_at' => date("d/m/Y")
						);
		// Insert into Sms Data
		 //echo '<pre>';
		 //print_r($insert_data);die;
		$this->db->insert('zcms_new_patient_data', $insert_data);
    }
    
    function insert_new_patients_master_table()
	{
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $patient_name =  $last_name.','. $first_name;
		$insert_data = array(
							'name' => $patient_name,
							'email' => $this->input->post('patient_email'),
							'phone_number' => $this->input->post('phone_number'),
							'visited_date' => $this->input->post('visit_date'),
							'provider_name' => $this->input->post('provider_name'),
							'facility_name' => $this->input->post('facility_name'),
							// 'review' => $this->input->post('review'),
							//'carrier' => $this->input->post('carrier_data'),
							'created_at' => date("d/m/Y")
						);
		// Insert into Sms Data
		$this->db->insert('zcms_email_blast_users', $insert_data);
	}
	
	function get_campaign_category_import_data()
	{
		$campaign_type = $this->input->post('campaign_type_name');
		
        $this->db->select('*');
		if($campaign_type == 'sms'):
			$this->db->where(array(
									'campaign_type' => $campaign_type,
									'sms_status' => '0'           
								));
		elseif($campaign_type == 'email'):
			$this->db->where(array(
								'campaign_type' => $campaign_type,
								'email_status' => '0'           
							));
		endif;
		 
        $query   = $this->db->get($this->table_campaign_category_import_data);
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;      
    }
	
	function get_email_template_by_id($id)
	{
		$this->db->select('*');
        $this->db->where(array(
							'id' => $id
						 ));
        $query   = $this->db->get('zcms_email_template');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
	}
	
	function insert_update_email_templates()
	{
		$email_template = $this->input->post('template');
		$insert_data = array(
							'template' => $email_template,
							'status' => '1'
						);
		// Insert into Email Template Data
		$this->db->insert('zcms_email_template', $insert_data);
	}
}