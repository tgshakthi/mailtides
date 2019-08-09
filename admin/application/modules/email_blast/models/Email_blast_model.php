<?php
/**
 * Email Blast Model
 * Created at : 23-July-2019
 * Author : Saravana
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_blast_model extends CI_Model
{
    private $table_name = 'email_blast_users';
    private $table_track = 'email_track';
    private $table_campaign = 'campaign';
    private $table_campaign_users = 'campaign_users';
	private $table_campaign_type = 'campaign_type';
    private $table_template ='email_template';

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
    function get_campaign_name__Bi_reports()
    {
        $this->db->select('*');
        $this->db->where(array(
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
    function get_campaign_detials()
    {
        $this->db->select('id, campaign_name,template_id');
        $this->db->where(array(
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
        $query   = $this->db->get('email_track');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result();
        endif;
        return $records;
    }
    
    function get_email_track_data_by_campaign_id($campaign_id)
    {
        $this->db->select('*');
        $this->db->where(array(
            'campaign_id' => $campaign_id
        ));
        $query   = $this->db->get('email_track');
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
    function insert_track($campaign_id, $id, $name, $email, $visited_date, $track_code, $subject, $from_name, $from_email)
    {
        $insert_array = array(
            'campaign_id' => $campaign_id,
            'track_id' => $id,
            'name' => $name,
            'email' => $email,
            'visited_date' => $visited_date,
            'track_code' => $track_code,
            'subject' => $subject,
            'from_name' => $from_name,
            'from_email' => $from_email,
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


    // Insert Campaign Data
    function insert_import_campaign_data()
    {
        $campaign_id = $this->input->post('campaign_id');       
        $campaign_name = $this->input->post('campaign_name');
        $campaign_desc = $this->input->post('campaign_desc');
        $campaign_type = $this->input->post('campaign_type');
        $send_date = $this->input->post('send_date');
        $campaign_users = implode(',', $this->input->post('user_id'));
        $email_template = $this->input->post('email_template');

        if (!empty($campaign_id)) {

            $update_array = array(
                'campaign_name' => $campaign_name,
                'description' => $campaign_desc,
                'campaign_type' => $campaign_type,
                'send_date' => $send_date,
                'campaign_users' => $campaign_users,
                'template_id' => $email_template
            );

            $this->db->where('id', $campaign_id);
            $this->db->update($this->table_campaign, $update_array);

        } else {
            $insert_array = array(
                'campaign_name' => $campaign_name,
                'description' => $campaign_desc,
                'campaign_type' => $campaign_type,
                'send_date' => $send_date,
                'campaign_users' => $campaign_users,
                'template_id' => $email_template
            );
    
            $this->db->insert($this->table_campaign, $insert_array);
            return $this->db->insert_id();
        }        
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
}