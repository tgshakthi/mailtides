<?php
/**
 * Email Blast
 * Created at : 23-July-2019
 * Author : Saravana
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
	use Twilio\Rest\Client;
	
class Email_blasts extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('Email_blasts_model');
        $this->load->module('admin_header');
        $this->load->module('color');
        $this->load->library('csvimport');
        $this->load->library('email');
		$this->session_data = $this->session->userdata('logged_in');
    }
    
    // Index
    function index()
    {
		$data['admin_user_id'] = $this->session_data['id'];
        $data['website_id'] = $this->admin_header->website_id();
        $data['table']      = $this->get_table_users();
        $data['heading']    = 'Email Blast';
        $data['title']      = "Email Blast | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('view', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Get Users Table
    function get_table_users()
    {
		$website_id = $this->admin_header->website_id();
		$get_users  = $this->Email_blasts_model->get_users();
		$campaign_name_datas = $this->Email_blasts_model->get_campaign();
		$heading=array();
		$campaign=array();
      
		foreach (($get_users ? $get_users : array()) as $get_user) 
		{         
          // $anchor_edit = anchor(site_url('email_blast/add_edit_users/' . $get_user->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
          //     'data-toggle' => 'tooltip',
          //     'data-placement' => 'left',
          //     'data-original-title' => 'Edit'
          // ));
          
          $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
              'data-toggle' => 'tooltip',
              'data-placement' => 'right',
              'data-original-title' => 'Delete',
              'onclick' => 'return delete_record(' . $get_user->id . ', \'' . base_url('email_blasts/delete_user/' . $website_id) . '\')'
          ));
          
          $cell = array(
            'class' => 'last',
            'data' => $anchor_delete
          );
		  
		  $campaign_name = array();
		  $heading_data = array();
		  
		  foreach($campaign_name_datas as $campaign_user):
			$campaign_user_name = $campaign_user->campaign_users;
			$campaign_array = explode(",",$campaign_user_name);
			
			if(in_array($get_user->id,$campaign_array)):				
				$campaign_name[] = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
			else:
				$campaign_name[] = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
			endif;
		  endforeach;
		 
		  $heading_data = array('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_user->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $get_user->id . '">', $get_user->name, $get_user->email, $get_user->facility_name ,$get_user->provider_name, $get_user->phone_number, $get_user->visited_date);
		  // $heading_data = array_merge($heading_data,$campaign_name);
		  $heading_data = array_merge($heading_data,array($cell));
         
		  $this->table->add_row($heading_data);
      }
      // die;
	  foreach($campaign_name_datas as $campaign_name_data):
		$campaign_name = $campaign_name_data->campaign_name;
		$campaign[]=$campaign_name;
      endforeach;
    // echo"<pre>";
    // print_r(	$campaign);
    // die;
		$heading = array('<input type="checkbox" id="check-all" class="flat">', 'Name', 'Email', 'Facility Name', 'Provider Name' , 'Phone Number', 'Visited Date','Action');
		// $heading = array_merge($heading, $campaign);
		// $heading = array_merge($heading, array('Action'));
	
      $template = array(
          'table_open' => '<table
          id="datatable-buttons"
          class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
          width="100%" cellspacing="0">'
      );
      $this->table->set_template($template);
      
      // Table heading row
      
      $this->table->set_heading($heading);
      return $this->table->generate();
    }

    // Import Master File
    function import_master_file()
    {
      $data['page_status'] = 1;
      $data['website_id'] = $this->admin_header->website_id();
      $data['heading'] = 'Email Blast';      
      $data['title'] = "Import Patient Master File | Administrator";

      /**
       * Step 1 : Upload CSV File
       * Step 2 : Field Mapping
       */
      if (isset($_POST['import-csv-file'])) {

        $config['upload_path']   = './patient-master-file/';
        $config['allowed_types'] = 'csv';
        $config['max_size']      = '1024';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('users'))
        {
          $this->session->set_flashdata('error', $this->upload->display_errors());        
        } else {
          $upload_csv          = array('upload_data' => $this->upload->data());
          $data['file']        = $upload_csv['upload_data']['full_path'];
          $entire_data         = file_get_contents($data['file']);
          $exp_entire_data     = explode("\n", $entire_data);
          $file_column_name    = explode(",", $exp_entire_data[0]);
          $data['csv_columns'] = $file_column_name;
          $data['page_status'] = 2;
          $data['heading'] = 'Patient Master File - Field Mapping';      
          $data['title'] = "Import Patient Master File - Field Mapping | Administrator";
          $this->session->set_flashdata('error', '');   
        }
      }

      // Insert Users
      if (isset($_POST['update-users'])) 
      {
        $keys = [];
        $values = [];
        $existing_users = [];
        $insert_array = [];

        $records = $this->Email_blasts_model->get_existing_users();
        foreach ($records as $record) :
          $existing_users[] = $record->email;
        endforeach;

        // Get CSV File Data
        $file_datas = $this->csvimport->get_array($_POST['file'], "", TRUE);  
		
        foreach ( ($file_datas ? $file_datas : array()) as $file_data) 
        {
          $values = array_values($file_data);

          $i = 0;
          foreach (array_keys($file_data) as $key) {            
            // Assign CSV col value to Selected Mapping Field
            foreach ($_POST as $k => $v) {			
              if ($key == $v) {
                $result[$k] = $values[$i];
              } 

            }
            
            $i++;
          } 
			
          if (!in_array($result["email"], $existing_users)) :

            $insert_array[] = $result;

          endif;
          
        }
        if (count($insert_array) > 0)
        {
          $this->Email_blasts_model->insert($insert_array);
          $this->session->set_flashdata('success', 'Successfully Imported.');
          redirect('email_blasts');
        }
        else 
        {
          $this->session->set_flashdata('error', 'Users already exists');
          redirect('email_blasts');
        }
        
      }

      $this->load->view('template/meta_head', $data);
      $this->load->view('email_blast_header');
      $this->admin_header->index();
      $this->load->view('import_file', $data);
      $this->load->view('template/footer_content');
      $this->load->view('script');
      $this->load->view('template/footer');     
    }

    // Campaign Users
    function campaign()
    {
      $data['website_id'] = $this->admin_header->website_id();
      $data['table']      = $this->get_campaign_table();
      $data['heading']    = 'Campaign';
      $data['title']      = "Campaign | Administrator";
      $this->load->view('template/meta_head', $data);
      $this->load->view('email_blast_header');
      $this->admin_header->index();
      $this->load->view('campaign', $data);
      $this->load->view('template/footer_content');
      $this->load->view('script');
      $this->load->view('template/footer');
    }

    /**
     * Campaign - Table
     */

    function get_campaign_table()
    {        
      $website_id = $this->admin_header->website_id();
      $get_campaign_data = $this->Email_blasts_model->get_campaign();   
      
      foreach (($get_campaign_data ? $get_campaign_data : array()) as $get_campaign)
      {
          
        $anchor_edit = anchor(site_url('email_blasts/add_edit_campaign/' . $get_campaign->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
          'data-toggle' => 'tooltip',
          'data-placement' => 'left',
            'data-original-title' => 'Edit'
        ));
          
        $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
          'data-toggle' => 'tooltip',
          'data-placement' => 'right',
          'data-original-title' => 'Delete',
          'onclick' => 'return delete_record(' . $get_campaign->id . ', \'' . base_url('email_blasts/delete_campaign/' . $website_id) . '\')'
        ));
          
        if ($get_campaign->status === '1') 
        {
          $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
        } 
        else
        {
          $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
        }    
          
        $cell = array(
          'class' => 'last',
          'data' =>  $anchor_edit.' '.$anchor_delete
        );
        /* $cell = array(
          'class' => 'last',
          'data' =>  $anchor_delete
        ); */

        $date = $get_campaign->created_at;
      
        $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_campaign->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $get_campaign->id . '">', $get_campaign->campaign_name, date("m-d-Y", strtotime($date)), $status, $cell);
      }
            
      $template = array(
        'table_open' => '<table
        id="datatable-responsive"
        class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
        width="100%" cellspacing="0">'
        );

      $this->table->set_template($template);
      
      // Table heading row
      
      $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Name', 'Date', 'Status', 'Action');
      return $this->table->generate();
    }

    // Add/Edit Campaign
    function add_edit_campaign($id = null)
    {
      $data['page_status'] = 1;

      if ($id != null):
        $campaign = $this->Email_blasts_model->get_campaign_by_id($id);
		
        $data['id'] = $campaign[0]->id;
		$data['campaign_category_id'] = $campaign[0]->category_id;
        $data['campaign_name'] = $campaign[0]->campaign_name;
        $data['description'] = $campaign[0]->description;
        $data['template'] = $campaign[0]->template_id;
		$data['campaign_type'] = $campaign[0]->campaign_type;
		$data['send_date'] = $campaign[0]->send_date;
        $data['status'] = $campaign[0]->status;
      else:
        $data['id'] = "";
		$data['campaign_category_id'] = "";
        $data['campaign_name'] = "";
        $data['description'] = "";
        $data['template'] = "";
		$data['campaign_type'] = "";
		$data['send_date'] = "";
        $data['status'] = "";
      endif;
       $data['email_blast_users']=$this->Email_blasts_model->get_users();
		
       $data['website_id'] = $this->admin_header->website_id();
	   $data['campaign_categories']=$this->Email_blasts_model->get_campaign_category($data['website_id']);
       $data['campaign_types'] = $this->Email_blasts_model->get_campaign_type_by_status($data['website_id']);  
       $data['email_templates'] = $this->Email_blasts_model->get_email_template_by_status();
	   $data['sms_templates'] = $this->Email_blasts_model->get_sms_template_by_status(); 	   
       $data['title'] = ($id != null) ? 'Edit Campaign' : 'Add Campaign' . ' | Administrator';
       $data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Campaign';
       $data['ImageUrl'] = $this->admin_header->image_url();
       $data['table'] = $this->get_table_campaign_users();
      
      $this->load->view('template/meta_head', $data);
      $this->load->view('email_blast_header');
      $this->admin_header->index();
      $this->load->view('add_edit_campaign', $data);
      $this->load->view('template/footer_content');
      $this->load->view('script');
      $this->load->view('template/footer');
    }

    // Get Users Table
    function get_table_campaign_users()
    {
        $website_id = $this->admin_header->website_id();
        $get_users  = $this->Email_blasts_model->get_users();

        $i = 1;
        foreach (($get_users ? $get_users : array()) as $get_user) {
            
            // $anchor_edit = anchor(site_url('email_blast/add_edit_users/' . $get_user->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
            //     'data-toggle' => 'tooltip',
            //     'data-placement' => 'left',
            //     'data-original-title' => 'Edit'
            // ));
            
            // $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
            //     'data-toggle' => 'tooltip',
            //     'data-placement' => 'right',
            //     'data-original-title' => 'Delete',
            //     'onclick' => 'return delete_record(' . $get_user->id . ', \'' . base_url('email_blast/delete_user/' . $website_id) . '\')'
            // ));
            
            // $cell = array(
            //   'class' => 'last',
            //   'data' => $anchor_delete
            // );

            $email_track_data = $this->Email_blasts_model->get_email_track($get_user->email);

            // Clicked From
            if (!empty($email_track_data) && $email_track_data[0]->txgidocs === '1') {
                $txgidocs = 'YES';
            } else {
                $txgidocs = 'NO';
            }

            if (!empty($email_track_data) && $email_track_data[0]->google === '1') {
                $google = 'YES';
            } else {
                $google = 'NO';
            }

            if (!empty($email_track_data) && $email_track_data[0]->facebook === '1') {
                $facebook = 'YES';
            } else {
                $facebook = 'NO';
            }           
        
            $this->table->add_row($i.' <input type="hidden"  id="email_blast_user" class="hidden-user-id" name="row_sort_order[]" value="' . $get_user->id . '">', $get_user->name, $get_user->email, $get_user->visited_date, $get_user->phone_number, $get_user->provider_name, $txgidocs, $google, $facebook);

            $i++;
        }
        
        // Table open
        
        $template = array(
            'table_open' => '<table
            id="datatable-campaign-users"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">'
        );
        $this->table->set_template($template);
        
        // Table heading row
        
        $this->table->set_heading('S.No', 'Name', 'Email','Visited Date', 'Cell Phone', 'Provider Name', 'Txgidocs', 'Google', 'Facebook');
        return $this->table->generate();
    }

    // Field Mapping
    function field_map_campaign_users()
    {
      /**
       * Step 1 : Upload CSV File
       * Step 2 : Field Mapping
       */
      if (isset($_POST['field-mapping'])) {
        
        $data['campaign_id'] = $this->input->post('id');
        $data['campaign_name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['template_id'] = $this->input->post('template_id');
        $status = $this->input->post('status');
        $data['status'] = (isset($status)) ? '1' : '0';

        $config['upload_path']   = './patient-files/';
        $config['allowed_types'] = 'csv';
        $config['max_size']      = '1024';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('users'))
        {
          $this->session->set_flashdata('error', $this->upload->display_errors());        
        } else {
          $upload_csv = array('upload_data' => $this->upload->data());
          $data['file'] = $upload_csv['upload_data']['full_path'];
          $entire_data = file_get_contents($data['file']);
          $exp_entire_data     = explode("\n", $entire_data);
          $file_column_name    = explode(",", $exp_entire_data[0]);
          $data['csv_columns'] = $file_column_name;
          $data['page_status'] = 2;
          $data['heading'] = 'Patient File - Field Mapping';      
          $data['title'] = "Import Patient File - Field Mapping | Administrator";
          $this->session->set_flashdata('error', '');   
        }
      } 

      // Insert users
      if (isset($_POST['import-users'])) 
      {
        $keys = [];
        $values = [];
        $existing_users = [];
        $insert_array = [];

        if (!empty($this->input->post('campaign_id')))
        {
          $campaign_id = $this->input->post('campaign_id');
          $update_campaign_array = array(
            array(
              'id' => $campaign_id,
              'campaign_name' => $this->input->post('campaign_name'),
              'description' => $this->input->post('description'),
              'template_id' => $this->input->post('template_id'),
              'status' => $this->input->post('status')
            )          
          );
  
          $this->Email_blasts_model->update_campaign($update_campaign_array);
        } 
        else 
        {
          $insert_campaign_array = array(
            array(
              'campaign_name' => $this->input->post('campaign_name'),
              'description' => $this->input->post('description'),
              'template_id' => $this->input->post('template_id'),
              'status' => $this->input->post('status')
            )          
          );
  
          $campaign_id = $this->Email_blasts_model->insert_campaign($insert_campaign_array);
        }  

        $records = $this->Email_blasts_model->get_existing_campaign_users();
        foreach ($records as $record) :
          $existing_users[] = $record->email;
        endforeach;

        // Get CSV File Data
        $file_datas = $this->csvimport->get_array($_POST['file'], "", TRUE);  

        foreach ( ($file_datas ? $file_datas : array()) as $file_data) 
        {
          $values = array_values($file_data);
          $i = 0;
          foreach (array_keys($file_data) as $key) {            

            $searchVal = array('"', ' ', '&#65279;');
            $replaceVal = array('', '', '');
            $key = str_replace($searchVal, $replaceVal, trim($key)); 

            // Assign CSV col value to Selected Mapping Field
            foreach ($_POST as $k => $v) {

              $v = str_replace($searchVal, $replaceVal, trim($v));

              if ($key == $v) {
                $result[$k] = $values[$i];
              } 

            }           
            
            $i++;
          } 

          //if (!in_array($result["email"], $existing_users)) :

            $insert_array[] = array_merge($result, array('campaign_id' => $campaign_id));

          //endif;
          
        }

        if (count($insert_array) > 0)
        {
          $this->Email_blasts_model->insert_campaign_users($insert_array);
          $this->session->set_flashdata('success', 'Successfully Imported.');
          redirect('email_blasts/campaign');
        }
        else 
        {
          $this->session->set_flashdata('error', 'Something Went Wrong');
          redirect('email_blasts/campaign');
        }
      }
      
      $data['page_status'] = 2;
      $data['website_id'] = $this->admin_header->website_id();
      $data['title'] = 'Field Mapping | Administrator';
      $data['heading'] = 'Field Mapping';
      $data['ImageUrl'] = $this->admin_header->image_url();
      $this->load->view('template/meta_head', $data);
      $this->load->view('email_blast_header');
      $this->admin_header->index();
      $this->load->view('add_edit_campaign', $data);
      $this->load->view('template/footer_content');
      $this->load->view('script');
      $this->load->view('template/footer');
    }

    // Send Mail
    function send_email_blast_status()
    {    
      $website_id = $this->admin_header->website_id();
      $data['website_folder_name'] = $this->admin_header->website_folder_name();
      $data['httpUrl'] = $this->admin_header->host_url();
      $data['ImageUrl'] = $this->admin_header->image_url();

      $data['campaign_details'] = $this->Email_blasts_model->get_campaign_detials('email');
    
      $mail_config = $this->Email_blasts_model->get_mail_configuration($website_id );
        
       if(!empty($mail_config)):
       $data['email'] = $mail_config[0]->mail_from;
       else:
        $data['email']='';
       endif;       
        
        $data['website_id'] = $this->admin_header->website_id();
        $data['title'] = 'Send Email' . ' | Administrator';
        $data['heading'] = 'Email ';
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('send_email_blast', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');

          
        // $get_users = $this->Email_blasts_model->get_users();
        // if (!empty($get_users)):
        //     $this->send_email_blast();
        // else:
        //     $this->session->set_flashdata('error', 'Please enable the users');
        //     redirect('email_blast');
        // endif;

     }

     // Get Campaign Template
     function get_campaign_template()
     {
       $campaign_id = $this->input->post('campaign_id');
       $template = $this->Email_blasts_model->get_campaign_template($campaign_id);
       if (!empty($template)) :
        $email_template=$this->Email_blasts_model->get_email_template_by_id($template[0]->template_id);
        echo  $email_template[0]->image;
       
       else :
        echo '0';
       endif;
     }

     // Send Mail
     function send_mail_based_on_campaign()
     {     
       $campaign_id = $this->input->post('campaign');	    
       $get_users = $this->Email_blasts_model->get_campaign_users_by_campaign_data($campaign_id);		
        if (!empty($get_users)):					
			$this->send_email_blast();			        
        else:
            $this->session->set_flashdata('error', 'Please enable the users');
            redirect('email_blasts');
        endif;
     }
      // Send Email    
    function send_email_blast()
    {      
        $website_id          = $this->admin_header->website_id();
        $mail_configurations = $this->Email_blasts_model->get_mail_configuration($website_id);
        if (!empty($mail_configurations)) {

            require_once APPPATH.'third_party/PHPMailer/vendor/autoload.php';

            $mail = new PHPMailer;
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host     = $mail_configurations[0]->host;
            $mail->SMTPAuth = true;
            $mail->Username = $mail_configurations[0]->email;
            $mail->Password = $mail_configurations[0]->password;
            $mail->Port     = $mail_configurations[0]->port;
			
            $campaign_id = $this->input->post('campaign');
            $from_name = $this->input->post('from_name');
            $from_email = $this->input->post('from_email');
            $email_subject = $this->input->post('subject');
            /* $get_users = $this->Email_blasts_model->get_campaign_users_by_campaign_id($campaign_id);
			      $campaign_users = explode(",",$get_users[0]->campaign_users); */
			$get_patient_users = $this->Email_blasts_model->get_campaign_users_by_campaign_data($campaign_id);
			
			$patient_user[] = (object)array(
											'user_id' => '680'
										);
			$get_users = array_merge($get_patient_users,$patient_user);
			
            $get_template_id = $this->Email_blasts_model->get_campaign_template($campaign_id);
            $template_id= $get_template_id[0]->template_id;             
            foreach ($get_users as $get_user) :
			
				$get_user_data = $this->Email_blasts_model->get_users_by_id($get_user->user_id);
				
				if(!empty($get_user_data[0]->name)):
					$patient_names = explode(",",$get_user_data[0]->name);
					$patient_name = $patient_names[1];
					$patient = explode(" ",trim($patient_name));
					$patient_first_name = $patient[0];
				endif;
				
              
                $track_code = md5(rand());                    
                    
                    $mail->setFrom($from_email, $from_name);                    
                    $mail->Subject= $email_subject;
                    // Set email format to HTML
                    $mail->isHTML(true);

                    // Email body content
                    $mailContent = '<!DOCTYPE html
                    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                  <html>
                  
                  <head>
                    <meta charset="UTF-8">
                    <meta content="width=device-width, initial-scale=1" name="viewport">
                    <meta name="x-apple-disable-message-reformatting">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta content="telephone=no" name="format-detection">
                    <title></title>
                    <!--[if (mso 16)]>
                      <style type="text/css">
                      a {text-decoration: none;}
                      </style>
                      <![endif]-->
                    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
                    <!--[if !mso]><!-- -->
                    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i" rel="stylesheet">
                    <!--<![endif]-->
                  </head>
                  
                  <body>
                    <div class="es-wrapper-color">
                      <!--[if gte mso 9]>
                              <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                                  <v:fill type="tile" color="#f6f6f6"></v:fill>
                              </v:background>
                          <![endif]-->
                      <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td class="esd-email-paddings">
                              <table class="es-content esd-footer-popover" cellspacing="0" cellpadding="0" align="center"
                                style="border: 5px solid #603;padding: 10px;background: #fff;">
                                <tbody>
                                  <tr>
                                    <td class="esd-stripe" align="center">
                                      <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" align="center"
                                        style="border-left:3px solid transparent;">
                                        <tbody>
                  
                                          <tr>
                                            <td style="text-align: center;"><img
                                                src="https://www.txgidocs.com/assets/images/txgidocs/logo/logo%20(1).png"
                                                width="100" />
                                              <h3
                                                style="color:#003954; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; text-align:center;font-size: 25px;font-weight: 300;">
                                                Digestive & Liver Disease Consultants, P.A. </h3>
                                                <br>
                                            </td>
                                          </tr>
                  
                                          <tr>
                                            <td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
                                              <table width="100%" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                  <tr>
                                                    <td class="esd-container-frame" width="557" valign="top" align="center">
                                                      <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                          <tr>
                                                            <td align="left" class="esd-block-text es-p15b">
                                                              <h2
                                                                style="color: rgb(102, 0, 51); font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif;font-size: 21px;font-weight: 600;">
                                                                Dear '. $patient_first_name .',</h2>
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td class="esd-block-text es-p20t" align="left">
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                Thank you for visiting Digestive & Liver Disease Consultants, P.A . Your
                                                                wellbeing is very important to us. To help serve you and others more
                                                                effectively, please take a moment to let us know about your experience on <strong>'. $get_user_data[0]->visited_date .'</strong>.
                                                              </pre>
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td class="esd-block-text es-p15t" align="left">
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                Please click the link below and give your feedback.</pre>
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td align="center" esd-links-color="#ffffff" class="esd-block-text">
                                                            <br>
                                                            <table cellspacing="0" cellpadding="0">
                                                            <tr>';

                                                             if($template_id =='1'):
                                                           
                                                               $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#660033">
                                                                    <a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$get_user_data[0]->id.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
                                                                    Digestive & Liver Disease Consultants, P.A.  Reviews
                                                                    </a>
                                                                 </td>';
                                                             elseif($template_id=='2'):
                                                              $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
                                                              <a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$get_user_data[0]->id.'&type=google" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
                                                                Google
                                                              </a>
                                                           </td>';
                                                              elseif ($template_id=='7') :
                                                                $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
                                                                <a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$get_user_data[0]->id.'&type=google-hamat" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
                                                                  Google
                                                                </a>
                                                             </td>';
															 elseif ($template_id=='8') :
                                                                $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
                                                                <a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$get_user_data[0]->id.'&type=google-reddy" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
                                                                  Google
                                                                </a>
                                                             </td>';
                                                              else:
                                                                $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#3b5998">
                                                                <a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$get_user_data[0]->id.'&type=facebook" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
                                                                  Facebook
                                                                </a>
                                                             </td>';

                                                              endif;
                
                                                      $mailContent .= ' </tr>
                                                        </table>
                                                        <br>                                              
                                                             
                                                              </td>
                                                          </tr>
                                                          <tr>
                                                            <td class="esd-block-text es-p15t" align="left">
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                Thank you for taking the time to let us know how we are doing.</br>
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                <br>
                                                              </p>
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                Sincerely,</p>                                                              
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                <img
                                                src="https://www.txgidocs.com/assets/images/txgidocs/logo/logo%20(1).png"
                                                width="90" />
                                                                <h3
                                                                  style="color:#003954; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 16px;font-weight: 300;">
                                                                  Digestive &amp; Liver Disease Consultants, P.A. </h3>
                                                              </p>
                  
                                                              <p><br>
                                                              </p>
                                                            </td>
                                                          </tr>                                                          
                                                        </tbody>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <img src="' . base_url() . 'email_blasts/track_mail/track_mail_update/' . $track_code . '" width="1" height="1" style="display: none;"/>
                  </body>                  
                </html>';
				$mail->Body = $mailContent;
				$mail->clearAddresses();
				// Add a recipient
				$mail->addAddress($get_user_data[0]->email);
				$mail->addBCC('velusamy@desss.com');
				
				if(!$mail->send()){
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
				} else {
					$this->Email_blasts_model->update_send_email_status($campaign_id,$get_user_data[0]->id);	
					$this->Email_blasts_model->insert_track($campaign_id, $get_user_data[0]->id, $get_user_data[0]->name, $get_user_data[0]->email,$get_user_data[0]->phone_number, $get_user_data[0]->visited_date, $track_code, $email_subject, $from_name, $from_email,'email');						
				}
				$this->session->set_flashdata('success', 'Mail sent Successfully.');              
            endforeach;
        }
        redirect('email_blasts');
    }

    // Email Tracking Reports
    function email_tracking()
    {
        $data['website_id'] = $this->admin_header->website_id();
        $data['table']      = $this->get_email_track();
        $data['email_tracks'] = $this->Email_blasts_model->get_email_track_data();
        $data['heading']    = 'Email Tracking';
        $data['title']      = "Email Tracking | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('email_track', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }

    // Tracking Reports - Table
    function get_email_track()
    {        
        $website_id   = $this->admin_header->website_id();
        $email_tracks = $this->Email_blasts_model->get_email_track_data();
        
        foreach (($email_tracks ? $email_tracks : array()) as $email_track) {

            $campaign_name = $this->Email_blasts_model->get_campaign_by_id($email_track->campaign_id);

            if (!empty($campaign_name)) {
              $camp_name = $campaign_name[0]->campaign_name;
            } else {
              $camp_name = "";
            }
            
            if ($email_track->status === '1') {
                $status = '<span class="label label-success">Open</span>';
            } else {
                $status = '<span class="label label-danger">Not Open</span>';
            }

            $reviews_entry= $this->Email_blasts_model->get_review_comments($email_track->track_id);
            if( !empty($reviews_entry[0]->review_user_id)):
              $comment = '<span class="label label-success">Posted</span>';
            else:
              $comment = '<span class="label label-danger">Not Posted</span>';
            endif;

             // Clicked From
             if ($email_track->txgidocs === '1') {
                    $txgidocs = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $txgidocs = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                if ($email_track->google === '1') {
                    $google = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $google = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                if ($email_track->facebook === '1') {
                    $facebook = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $facebook = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }

            $this->table->add_row($email_track->name, $email_track->email, $email_track->phone_number, $camp_name, $txgidocs, $google, $facebook , $status);
        }
        
        // Table open
        
        $template = array(
            'table_open' => '<table
            id="datatable-email"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">'
        );
        $this->table->set_template($template);
        
        // Table heading row
        
        $this->table->set_heading('Name', 'Email','Cell Phone', 'Campaign Name', 'Txgidocs', 'Google', 'Facebook','Status');
        return $this->table->generate();
    }
	
	// SMS Tracking Reports
    function sms_tracking()
    {
        $data['website_id'] = $this->admin_header->website_id();
        $data['table']      = $this->get_sms_track();
        $data['sms_tracks'] = $this->Email_blasts_model->get_sms_track_data();
        $data['heading']    = 'SMS Tracking';
        $data['title']      = "SMS Tracking | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('sms_track', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
	
	 // Tracking Reports - Table
    function get_sms_track()
    {        
        $website_id   = $this->admin_header->website_id();
        $sms_tracks = $this->Email_blasts_model->get_sms_track_data();
        
        foreach (($sms_tracks ? $sms_tracks : array()) as $sms_track) {

            $campaign_name = $this->Email_blasts_model->get_campaign_by_id($sms_track->campaign_id);

            if (!empty($campaign_name)) {
              $camp_name = $campaign_name[0]->campaign_name;
            } else {
              $camp_name = "";
            }
            
            if ($sms_track->status === '1') {
                $status = '<span class="label label-success">Open</span>';
            } else {
                $status = '<span class="label label-danger">Not Open</span>';
            }

            $reviews_entry= $this->Email_blasts_model->get_review_comments($sms_track->track_id);
            if( !empty($reviews_entry[0]->review_user_id)):
              $comment = '<span class="label label-success">Posted</span>';
            else:
              $comment = '<span class="label label-danger">Not Posted</span>';
            endif;

             // Clicked From
             if ($sms_track->txgidocs === '1') {
                    $txgidocs = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $txgidocs = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                if ($sms_track->google === '1') {
                    $google = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $google = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                if ($sms_track->facebook === '1') {
                    $facebook = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $facebook = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }

            $this->table->add_row($sms_track->name, $sms_track->email, $sms_track->phone_number, $camp_name, $status);
        }
        
        // Table open
        
        $template = array(
            'table_open' => '<table
            id="datatable-sms"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">'
        );
        $this->table->set_template($template);
        
        // Table heading row
        
        $this->table->set_heading('Name', 'Email','Cell Phone', 'Campaign Name','Status');
        return $this->table->generate();
    }
	
     //Resend Mail
     function resend_mail()
     {
        $website_id          = $this->admin_header->website_id();
        $mail_configurations = $this->Email_blasts_model->get_mail_configuration($website_id);
        if (!empty($mail_configurations)) {

            require_once APPPATH.'third_party/PHPMailer/vendor/autoload.php';

            $mail = new PHPMailer;
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host     = $mail_configurations[0]->host;
            $mail->SMTPAuth = true;
            $mail->Username = $mail_configurations[0]->email;
            $mail->Password = $mail_configurations[0]->password;
            $mail->Port     = $mail_configurations[0]->port;

            // $config['protocol']     = 'smtp';
            // $config['smtp_host']    = $mail_configurations[0]->host;
            // $config['smtp_port']    = $mail_configurations[0]->port;
            // $config['smtp_timeout'] = '7';
            // $config['smtp_user']    = $mail_configurations[0]->email;
            // $config['smtp_pass']    = $mail_configurations[0]->password;
            // $config['charset']      = 'utf-8';
            // $config['newline']      = "\r\n";
            // $config['mailtype']     = 'html';
            // $config['validation']   = TRUE;
            
            //$this->email->initialize($config);
            // $campaign_id = $this->input->post('campaign');
            // $from_name = $this->input->post('from_name');
            // $from_email = $this->input->post('from_email');
            // $email_subject = $this->input->post('subject');

            $get_users = $this->Email_blasts_model->get_email_track_users();   
          
            foreach ($get_users as $get_user) :

              $template = $this->Email_blasts_model->get_template_id_by_campaign($get_user->campaign_id);

              $template_id = $template[0]->template_id;
              
              // if ($get_user->status == '1'):
                
                //$track_code = md5(rand());                    
                    
                    $mail->setFrom($get_user->from_email, $get_user->from_name);                    
                    $mail->Subject = $get_user->subject;
                    // Set email format to HTML
                    $mail->isHTML(true);

                    // Email body content
                    $mailContent = '<!DOCTYPE html
                    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                  <html>
                  
                  <head>
                    <meta charset="UTF-8">
                    <meta content="width=device-width, initial-scale=1" name="viewport">
                    <meta name="x-apple-disable-message-reformatting">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta content="telephone=no" name="format-detection">
                    <title></title>
                    <!--[if (mso 16)]>
                      <style type="text/css">
                      a {text-decoration: none;}
                      </style>
                      <![endif]-->
                    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
                    <!--[if !mso]><!-- -->
                    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i" rel="stylesheet">
                    <!--<![endif]-->
                  </head>
                  
                  <body>
                    <div class="es-wrapper-color">
                      <!--[if gte mso 9]>
                              <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                                  <v:fill type="tile" color="#f6f6f6"></v:fill>
                              </v:background>
                          <![endif]-->
                      <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td class="esd-email-paddings">
                              <table class="es-content esd-footer-popover" cellspacing="0" cellpadding="0" align="center"
                                style="border: 5px solid #603;padding: 10px;background: #fff;">
                                <tbody>
                                  <tr>
                                    <td class="esd-stripe" align="center">
                                      <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" align="center"
                                        style="border-left:3px solid transparent;">
                                        <tbody>
                  
                                          <tr>
                                            <td style="text-align: center;"><img
                                                src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/logo/logo%20(1).png"
                                                width="100" />
                                              <h3
                                                style="color:#003954; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; text-align:center;font-size: 25px;font-weight: 300;">
                                                Digestive & Liver Disease Consultants, P.A. </h3>
                                                <br>
                                            </td>
                                          </tr>
                  
                                          <tr>
                                            <td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
                                              <table width="100%" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                  <tr>
                                                    <td class="esd-container-frame" width="557" valign="top" align="center">
                                                      <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                          <tr>
                                                            <td align="left" class="esd-block-text es-p15b">
                                                              <h2
                                                                style="color: rgb(102, 0, 51); font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif;font-size: 21px;font-weight: 600;">
                                                                Dear '. $get_user->name .',</h2>
                                                            </td>
                                                          </tr>
                                                          
                                                          <tr>
                                                            <td class="esd-block-text es-p15t" align="left">
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                Please click the link below and give your feedback.</p>
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td align="center" esd-links-color="#ffffff" class="esd-block-text">
                                                            <br>
                                                            <table cellspacing="0" cellpadding="0">
                                                            <tr>';

                                                             if($template_id =='1'):
																						$mailContent .='<td class="esd-block-text es-p20t" align="left">
																							  <p
																								style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																								 Thanks for being a patient of DLDC! Pls click our link for a quick review!
																							  </pre>
																							</td>
																						   
																							<td style="border-radius:4px; padding:10px" bgcolor="#660033">
																								<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																								Digestive & Liver Disease Consultants, P.A.  Reviews
																								</a>
																							</td>';
																		 elseif($template_id=='2'):
																						$mailContent .='<td class="esd-block-text es-p20t" align="left">
																							  <p
																								style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																								 Thanks for being a patient of Dr. Reddy! Pls click our link for a quick review!
																							  </pre>
																							</td>
																							<td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																							  <a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																								Google
																							  </a>
																						   </td>';
																		  elseif ($template_id=='7') :
																						$mailContent .='<td class="esd-block-text es-p20t" align="left">
																							  <p
																								style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																								Thanks for being a patient of Dr. Hamat! Pls click our link for a quick review!
																							  </pre>
																							</td>
																							<td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																							<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google-hamat" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																							  Google
																							</a>
																						 </td>';
																		 elseif ($template_id=='8') :
																						$mailContent .='<td class="esd-block-text es-p20t" align="left">
																							  <p
																								style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																								Thanks for being a patient of Dr. Reddy! Pls click our link for a quick review!
																							  </pre>
																							</td>
																							<td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																								<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google-reddy" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																								  Google
																								</a>
																							 </td>';
																		  else:
																						$mailContent .='<td class="esd-block-text es-p20t" align="left">
																							  <p
																								style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																								Thanks for being a patient of DLDC! Pls click our link for a quick review!
																							  </pre>
																							</td>
																							<td style="border-radius:4px; padding:10px" bgcolor="#3b5998">
																							<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=facebook" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																							  Facebook
																							</a>
																						 </td>';

																		  endif;
                
                                                      $mailContent .= ' </tr>
                                                        </table>
                                                        <br>                                              
                                                            
                                                              </td>
                                                          </tr>
                                                          <tr>
                                                            <td class="esd-block-text es-p15t" align="left">
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                Thank you for taking the time to let us know how we are doing.</br>
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                <br>
                                                              </p>
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                Sincerely,</p>                                                              
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                <img
                                                src="http://txgidocs.desss-portfolio.com/assets/images/txgidocs/logo/logo%20(1).png"
                                                width="90" />
                                                                <h3
                                                                  style="color:#003954; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 16px;font-weight: 300;">
                                                                  Digestive &amp; Liver Disease Consultants, P.A. </h3>
                                                              </p>
                  
                                                              <p><br>
                                                              </p>
                                                            </td>
                                                          </tr>                                                          
                                                        </tbody>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <img src="' . base_url() . 'email_blast/track_mail/track_mail_update/' . $get_user->track_code . '" width="1" height="1" style="display: none;"/>
                  </body>                  
                  </html>';

                    $mail->Body = $mailContent;

                    $mail->clearAddresses();

                    // Add a recipient
                    $mail->addAddress($get_user->email);
                    
                    
                    // $this->email->clear();
                    // $this->email->from($from_mail);
                    //$this->email->subject('Digestive & Liver Disease Consultants, P.A - Feedback');
                    //$this->email->message($send);
                    //$this->email->to($get_user->email);

                    if(!$mail->send()){
                        echo 'Message could not be sent.';
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    } else {
						// $this->Email_blasts_model->update_send_email_status($campaign_id,$get_user_data[0]->id);	
                        // $this->Email_blasts_model->insert_track($campaign_id, $get_user_data[0]->id, $get_user_data[0]->name, $get_user_data[0]->email,$get_user_data[0]->phone_number, $get_user_data[0]->visited_date, $track_code, $email_subject, $from_name, $from_email);
						}
                    $this->session->set_flashdata('success', 'Mail sent Successfully.');
                // else:
                //     $this->session->set_flashdata('error', 'Please enable user status !');
                // endif;
            endforeach;
        }
        redirect('email_blasts/email_tracking');              
     }

     // Import Filter Data
     function import_filter_data()
     {
       $campaign_id = $this->Email_blasts_model->insert_import_campaign_data();
       echo $campaign_id;
     }

     // Insert Campaign
     function insert_campaign_data()
     {
       $this->Email_blasts_model->insert_import_campaign_data();
       $this->session->set_flashdata('success', 'Record Successfully Saved');
     }

    
    // Import users 
    function import_users()
    {
        $data['website_id'] = $this->admin_header->website_id();
        $data['campaign_details'] = $this->Email_blasts_model->get_campaign_detials('email');
        $data['heading'] = 'Email Blast';        
        $data['title'] = "Import Users | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('import_users', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    function insert_import_users()
    {
      $data = [];
      $existing_users = [];
      $records = $this->Email_blasts_model->get_existing_users();
      foreach ($records as $record) :
        $existing_users[] = $record->email;
      endforeach;
     
      if (!empty($_FILES["users"]["tmp_name"])) {
          $file_data = $this->csvimport->get_array($_FILES["users"]["tmp_name"], "", TRUE);
          foreach ($file_data as $row) {
            if (!in_array($row["email"], $existing_users)) :

              $data[] = array(
                  'campaign_id' => implode(',', $this->input->post('campaign_id')),
                  'name' => $row["Name"],
                  'email' => $row["email"],
                  'visited_date' => $row['visitDate'],
                  'status' => '1'
              );

            endif;
          } 

          if (count($data) > 0)
          {
            $this->Email_blasts_model->insert($data);
            $this->session->set_flashdata('success', 'Successfully Imported.');
            redirect('email_blasts');
          }
          else 
          {
            $this->session->set_flashdata('error', 'Users already exists');
            redirect('email_blasts');
          }
      } 
    }

    //delete
    function delete_user()
    {
        $this->Email_blasts_model->delete_user_data();
        $this->session->set_flashdata('success', 'Successfully Deleted');
    }

    //mutliple delete
    function delete_multiple_user()
    {
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('email_blasts');
        } else {
            $this->Email_blasts_model->delete_multiple_user_data();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('email_blasts');
        }
    }
    
   function graphical_campaign_id()
   {
    $sent = "";
    $opened = array();
    $not_opened = array();
    $txgidocs = array();
    $google = array();
    $facebook = array();
    $comments_posted = array();
    $comments_not_posted = array();
	$sms_link = array();
    $link = array();
	$campaign_types = '';
    $campaign_id=$this->input->post('campaign_id');
	$campaign_type=$this->input->post('campaign_type');
       
    
      $get_email_track = $this->Email_blasts_model->get_email_track_data_by_campaign_id($campaign_id, $campaign_type);

      
      foreach ( ($get_email_track ? $get_email_track : array()) as $email_track ) {

        // if status == 1
        if ($email_track->status == '1'){
          $opened[] = $email_track->status;
        } else {
          $not_opened[] = $email_track->status;
        }

        // txgidocs
        if ($email_track->txgidocs == '1') {
          $txgidocs[] = $email_track->txgidocs;
        } 

        // Google
        if ($email_track->google == '1') {
          $google[] = $email_track->google;
        }

        // Facebook
        if ($email_track->facebook == '1') {
          $facebook[] = $email_track->facebook;
        }

        //link open
        if($email_track->link_opened=='1')
        {
            $link[]=$email_track->link_opened;
        }
		//link open
        if($email_track->sms_link_opened=='1')
        {
            $sms_link[]=$email_track->sms_link_opened;
        }
        // Comments Posted
        $reviews_entry = $this->Email_blasts_model->get_review_comments($email_track->track_id);
        if( !empty($reviews_entry[0]->review_user_id)):
          $comments_posted[] = $reviews_entry[0]->review_user_id;
        else :
          $comments_not_posted[] = $email_track->id;
        endif;
        
		//Campaign Type
        if($email_track->type =='email'){
            $campaign_types = $email_track->type;
        }elseif($email_track->type =='sms'){
			$campaign_types = $email_track->type;
		}
      }

      // Sent Status
      if (!empty($get_email_track)) {
        $sent = count($get_email_track);
      }
  
      $data['opened'] = count($opened); 
      $data['not_opened'] = count($not_opened);       
      $data['txgidocs'] = count($txgidocs); 
      $data['google'] = count($google); 
      $data['facebook'] = count($facebook); 
      $data['link_open'] = count($link); 
      $data['sent'] = $sent; 
      $data['posted'] = count($comments_posted);
      $data['not_posted'] = count($comments_not_posted); 
      $data['sms_link'] = count($sms_link); 
	  $data['type'] = $campaign_types;
     echo json_encode($data);
    
   }

    // Graphical Reports
    function graphical_reports()
    {     
      $sent = "";
      $opened = array();
      $not_opened = array();
      $txgidocs = array();
      $google = array();
      $facebook = array();
      $link=array();
      $comments_posted = array();
      $comments_not_posted = array();

      $data['website_id'] = $this->admin_header->website_id();
      $data['campaign_details'] = $this->Email_blasts_model->get_campaign_detials('email');   
    
      $get_email_track = $this->Email_blasts_model->get_email_track_data();
    
      foreach ( ($get_email_track ? $get_email_track : array()) as $email_track ) {

        // if status == 1
        if ($email_track->status == '1'){
          $opened[] = $email_track->status;
        } else {
          $not_opened[] = $email_track->status;
        }

        // txgidocs
        if ($email_track->txgidocs == '1') {
          $txgidocs[] = $email_track->txgidocs;
        } 

        // Google
        if ($email_track->google == '1') {
          $google[] = $email_track->google;
        }

        // Facebook
        if ($email_track->facebook == '1') {
          $facebook[] = $email_track->facebook;
        }
      
        // Comments Posted
        $reviews_entry = $this->Email_blasts_model->get_review_comments($email_track->track_id);
        if( !empty($reviews_entry[0]->review_user_id)):
          $comments_posted[] = $reviews_entry[0]->review_user_id;
        else :
          $comments_not_posted[] = $email_track->id;
        endif;
        
      }

      // Sent Status
      if (!empty($get_email_track)) {
        $sent = count($get_email_track);
      }
  
      $data['opened'] = count($opened); 
      $data['not_opened'] = count($not_opened);
      $data['link_open']=count($link);       
      $data['txgidocs'] = count($txgidocs); 
      $data['google'] = count($google); 
      $data['facebook'] = count($facebook); 
      $data['sent'] = $sent; 
      $data['posted'] = count($comments_posted);
      $data['not_posted'] = count($comments_not_posted); 

      $data['heading']    = 'Graphical Reports';      
      $data['title'] = "Graphical Reports | Administrator";
      $this->load->view('template/meta_head', $data);
      $this->load->view('email_blast_header');
      $this->admin_header->index();
      $this->load->view('graphical_reports', $data);
      $this->load->view('template/footer_content');
      $this->load->view('script');
      $this->load->view('template/footer');      
    }
    
    function insert_update_campaign()
    {
      $id = $this->input->post('id');
      $continue = $this->input->post('btn_continue');
      if (empty($id))
			{
			  $this->Email_blasts_model->insert_update_campaign();
			   $this->session->set_flashdata('success', 'Campaign details successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'email_blasts/add_edit_campaign';
				}
				else
				{
					$url = 'email_blasts/campaign';
				}
			}
			else
			{
        
				$this->Email_blasts_model->insert_update_campaign($id);
				$this->session->set_flashdata('success', 'Campaign details Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'email_blasts/add_edit_campaign/' . $id;
				}
				else
				{
					$url = 'email_blasts/campaign';
				}
      }
      redirect($url);
    }

    function delete_campaign()
    {
      $this->Email_blasts_model->delete_campaign_data();
       $this->session->set_flashdata('success', 'Successfully Deleted');
    }


    function delete_multiple_campaign()
	 {
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('email_blasts/campaign');
		}
		else
		{
			$this->Email_blasts_model->delete_multiple_campaign_data();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('email_blasts/campaign');
		}
   }

   

   // Insert Master File
   function insert_import_master_users()
   {
     $existing_users = [];
      $records = $this->Email_blasts_model->get_existing_users();
      foreach ($records as $record) :
        $existing_users[] = $record->email;
      endforeach;
   
      if (!empty($_FILES["users"]["tmp_name"])) {
          $file_data = $this->csvimport->get_array($_FILES["users"]["tmp_name"], "", TRUE);
          foreach ($file_data as $row) {
            if (!in_array($row["email"], $existing_users)) :

              $data[] = array(
                  'name' => $row["Name"],
                  'email' => $row["email"],
                  'visited_date' => $row['visitDate'],
                  'status' => '1'
              );

            endif;
          }
          $this->Email_blasts_model->insert($data);
          $this->session->set_flashdata('success', 'Successfully Imported.');
          redirect('email_blast');
      }     
   }
	function email_template()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['table']      = $this->get_email_template();
		$data['heading']    = 'Email Template';
		$data['title']      = "Email Template | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('email_template', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
   
   function sms_template()
   {
    $data['website_id'] = $this->admin_header->website_id();
    $data['table']      = $this->get_sms_template();
    $data['heading']    = 'SMS Template';
    $data['title']      = "SMS Template | Administrator";
    $this->load->view('template/meta_head', $data);
    $this->load->view('email_blast_header');
    $this->admin_header->index();
    $this->load->view('sms_template', $data);
    $this->load->view('template/footer_content');
    $this->load->view('script');
    $this->load->view('template/footer');
   }
   
   function get_email_template()
   {
       
     $website_id = $this->admin_header->website_id();
     $website_folder_name = $this->admin_header->website_folder_name();
		$ImageUrl = $this->admin_header->image_url();
     $get_template_data = $this->Email_blasts_model->get_email_template();   
     
     foreach (($get_template_data ? $get_template_data : array()) as $get_template)
     {
         
       $anchor_edit = anchor(site_url('email_blast/add_edit_email_template/' . $get_template->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
         'data-toggle' => 'tooltip',
         'data-placement' => 'left',
           'data-original-title' => 'Edit'
       ));
         
       $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
         'data-toggle' => 'tooltip',
         'data-placement' => 'right',
         'data-original-title' => 'Delete',
         'onclick' => 'return delete_record(' . $get_template->id . ', \'' . base_url('email_blast/delete_email_template/' . $website_id) . '\')'
       ));
         
       if ($get_template->status === '1') 
       {
         $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
       } 
       else
       {
         $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
       }    

       if ($get_template->image != '')
				{
					$gallery_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $get_template->image;

					$image = img(array(
						'src' => $gallery_img ,
						'style' => 'width:145px; height:86px'
					));
				}
				else
				{
					$image = img(array(
						'src' => $ImageUrl . 'images/noimage.png',
						'style' => 'width:145px; height:86px'
					));
				}
         
       $cell = array(
         'class' => 'last',
         'data' =>  $anchor_edit.' '.$anchor_delete
       );

      
     
       $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_template->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $get_template->id . '">', $get_template->template_name,$image , $status, $cell);
     }
           
     $template = array(
       'table_open' => '<table
       id="datatable-responsive"
       class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
       width="100%" cellspacing="0">'
       );

     $this->table->set_template($template);
     
     // Table heading row
     
     $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Name', 'Image','Status', 'Action');
     return $this->table->generate();
   }
   
	function get_sms_template()
	{
       
		$website_id = $this->admin_header->website_id();
		$website_folder_name = $this->admin_header->website_folder_name();
		$ImageUrl = $this->admin_header->image_url();
		$get_template_data = $this->Email_blasts_model->get_sms_template();   
     
		foreach (($get_template_data ? $get_template_data : array()) as $get_template)
		{
         
		$anchor_edit = anchor(site_url('email_blasts/add_edit_sms_template/' . $get_template->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
			 'data-toggle' => 'tooltip',
			 'data-placement' => 'left',
			   'data-original-title' => 'Edit'
		   ));
         
		$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
			 'data-toggle' => 'tooltip',
			 'data-placement' => 'right',
			 'data-original-title' => 'Delete',
			 'onclick' => 'return delete_record(' . $get_template->id . ', \'' . base_url('email_blasts/delete_sms_template/' . $website_id) . '\')'
			));
         
       if ($get_template->status === '1') 
       {
         $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
       } 
       else
       {
         $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
       }    

      
       $cell = array(
         'class' => 'last',
         'data' =>  $anchor_edit.' '.$anchor_delete
       );

      
     
       $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_template->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $get_template->id . '">', $get_template->template_name, $status, $cell);
     }
           
     $template = array(
       'table_open' => '<table
       id="datatable-responsive"
       class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
       width="100%" cellspacing="0">'
       );

     $this->table->set_template($template);
     
     // Table heading row
     
     $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Name','Status', 'Action');
     return $this->table->generate();
	}

     // Add/Edit Campaign
     function add_edit_email_template($id = null)
     {
      
        if ($id != null):
         $template = $this->Email_blasts_model->get_email_template_by_id($id);
         $data['id'] = $template[0]->id;
         $data['template_name'] = $template[0]->template_name;
         $data['template'] = $template[0]->template;
         $data['image']=$template[0]->image;
         $data['status'] = $template[0]->status;
       else:
         $data['id'] = "";
         $data['template_name'] = "";
         $data['template'] = "";
         $data['image']="";
        $data['status'] = "";
       endif;
 
       $data['website_id'] = $this->admin_header->website_id();
       $data['httpUrl'] = $this->admin_header->host_url();
	  	$data['ImageUrl'] = $this->admin_header->image_url();
	  	$data['website_folder_name'] = $this->admin_header->website_folder_name();
       $data['title'] = ($id != null) ? 'Edit Template' : 'Add Template' . ' | Administrator';
       $data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Template';
       $data['ImageUrl'] = $this->admin_header->image_url();
       $this->load->view('template/meta_head', $data);
       $this->load->view('email_blast_header');
       $this->admin_header->index();
       $this->load->view('add_edit_email_template', $data);
       $this->load->view('template/footer_content');
       $this->load->view('script');
       $this->load->view('template/footer');
     }
	 
	  // Add/Edit SMS Template
     function add_edit_sms_template($id = null)
     {
      
        if ($id != null):
         $sms_template = $this->Email_blasts_model->get_sms_template_by_id($id);
         $data['id'] = $sms_template[0]->id;
         $data['template_name'] = $sms_template[0]->template_name;
         $data['status'] = $sms_template[0]->status;
       else:
         $data['id'] = "";
         $data['template_name'] = "";
        $data['status'] = "";
       endif;
 
       $data['website_id'] = $this->admin_header->website_id();
       $data['httpUrl'] = $this->admin_header->host_url();
	   $data['ImageUrl'] = $this->admin_header->image_url();
	   $data['website_folder_name'] = $this->admin_header->website_folder_name();
       $data['title'] = ($id != null) ? 'Edit Template' : 'Add Template' . ' | Administrator';
       $data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Template';
       $data['ImageUrl'] = $this->admin_header->image_url();
       $this->load->view('template/meta_head', $data);
       $this->load->view('email_blast_header');
       $this->admin_header->index();
       $this->load->view('add_edit_sms_template', $data);
       $this->load->view('template/footer_content');
       $this->load->view('script');
       $this->load->view('template/footer');
     }
	 
     function insert_update_email_template()
     {
       $id = $this->input->post('id');
       $continue = $this->input->post('btn_continue');
       if (empty($id))
       {
         $this->Email_blasts_model->insert_update_email_template();
          $this->session->set_flashdata('success', 'Eamil Teemplate details successfully Created');
         if (isset($continue) && $continue === "Add & Continue")
         {
           $url = 'email_blasts/add_edit_email_template';
         }
         else
         {
           $url = 'email_blasts/email_template';
         }
       }
       else
       {
         
         $this->Email_blasts_model->insert_update_email_template($id);
         $this->session->set_flashdata('success', 'Email Template details Successfully Updated.');
         if (isset($continue) && $continue === "Update & Continue")
         {
           $url = 'email_blasts/add_edit_email_template/' . $id;
         }
         else
         {
           $url = 'email_blasts/email_template';
         }
       }
       redirect($url);
     }
	function insert_update_sms_template()
     {
       $id = $this->input->post('id');
       $continue = $this->input->post('btn_continue');
       if (empty($id))
       {
         $this->Email_blasts_model->insert_update_sms_template();
          $this->session->set_flashdata('success', 'Sms Teemplate details successfully Created');
         if (isset($continue) && $continue === "Add & Continue")
         {
           $url = 'email_blasts/add_edit_sms_template';
         }
         else
         {
           $url = 'email_blasts/sms_template';
         }
       }
       else
       {
         
         $this->Email_blasts_model->insert_update_sms_template($id);
         $this->session->set_flashdata('success', 'Sms Template details Successfully Updated.');
         if (isset($continue) && $continue === "Update & Continue")
         {
           $url = 'email_blasts/add_edit_sms_template/' . $id;
         }
         else
         {
           $url = 'email_blasts/sms_template';
         }
       }
       redirect($url);
     }
	
	function delete_sms_template()
     {
       $this->Email_blasts_model->delete_sms_template_data();
        $this->session->set_flashdata('success', 'Successfully Deleted');
     }	
	
	function delete_multiple_sms_template()
    {
     $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
       'required' => 'You must select at least one row!'
     ));
     if ($this->form_validation->run() == FALSE)
     {
       $this->session->set_flashdata('error', validation_errors());
       redirect('email_blasts/sms_template');
     }
     else
     {
       $this->Email_blasts_model->delete_multiple_sms_template_data();
       $this->session->set_flashdata('success', 'Successfully Deleted');
       redirect('email_blasts/sms_template');
     }
    }
     
	 function delete_email_template()
     {
       $this->Email_blasts_model->delete_template_data();
        $this->session->set_flashdata('success', 'Successfully Deleted');
     }
 
 
     function delete_multiple_template()
    {
     $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
       'required' => 'You must select at least one row!'
     ));
     if ($this->form_validation->run() == FALSE)
     {
       $this->session->set_flashdata('error', validation_errors());
       redirect('email_blasts/email_template');
     }
     else
     {
       $this->Email_blasts_model->delete_multiple_template_data();
       $this->session->set_flashdata('success', 'Successfully Deleted');
       redirect('email_blasts/email_template');
     }
    }
  
    
	function remove_email_template_image()
	{
		$this->Email_blasts_model->remove_email_template_image();
		echo '1';
	}
	 // Campaign Type
    function campaign_type()
    {
      $data['website_id'] = $this->admin_header->website_id();
      $data['table']      = $this->get_campaign_type_table();
      $data['heading']    = 'Campaign Type';
      $data['title']      = "Campaign Type | Administrator";
      $this->load->view('template/meta_head', $data);
      $this->load->view('email_blast_header');
      $this->admin_header->index();
      $this->load->view('campaign_type', $data);
      $this->load->view('template/footer_content');
      $this->load->view('script');
      $this->load->view('template/footer');
    }

    /**
     * Campaign Type Table
     */

    function get_campaign_type_table()
    {       
      $website_id = $this->admin_header->website_id();
      $get_campaign_type_data = $this->Email_blasts_model->get_campaign_type($website_id);   
      
      foreach (($get_campaign_type_data ? $get_campaign_type_data : array()) as $get_campaign_type)
      {
          
        $anchor_edit = anchor(site_url('email_blasts/add_edit_campaign_type/' . $get_campaign_type->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
          'data-toggle' => 'tooltip',
          'data-placement' => 'left',
            'data-original-title' => 'Edit'
        ));
          
        $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
          'data-toggle' => 'tooltip',
          'data-placement' => 'right',
          'data-original-title' => 'Delete',
          'onclick' => 'return delete_record(' . $get_campaign_type->id . ', \'' . base_url('email_blasts/delete_campaign_type/' . $website_id) . '\')'
        ));
          
        if ($get_campaign_type->status === '1') 
        {
          $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
        } 
        else
        {
          $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
        }    
          
        $cell = array(
          'class' => 'last',
          'data' =>  $anchor_edit.' '.$anchor_delete
        );

        $date = $get_campaign_type->created_at;
      
        $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_campaign_type->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $get_campaign_type->id . '">', $get_campaign_type->campaign_type, date("m-d-Y", strtotime($date)), $status, $cell);
      }
            
      $template = array(
        'table_open' => '<table
        id="datatable-responsive"
        class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
        width="100%" cellspacing="0">'
        );

      $this->table->set_template($template);
      
      // Table heading row
      
      $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Campaign Type', 'Date', 'Status', 'Action');
      return $this->table->generate();
    }

    // Add/Edit Campaign Type
    function add_edit_campaign_type($id = null)
    {
      $data['page_status'] = 1;

      if ($id != null):
        $campaign_type = $this->Email_blasts_model->get_campaign_type_by_id($id);
        $data['id'] = $campaign_type[0]->id;
        $data['campaign_type'] = $campaign_type[0]->campaign_type;
        $data['status'] = $campaign_type[0]->status;
      else:
        $data['id'] = "";
        $data['campaign_type'] = "";
        $data['status'] = "";
      endif;

      $data['website_id'] = $this->admin_header->website_id();
      $data['title'] = ($id != null) ? 'Edit Campaign Type' : 'Add Campaign Type' . ' | Administrator';
      $data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Campaign Type';
   
      $this->load->view('template/meta_head', $data);
      $this->load->view('email_blast_header');
      $this->admin_header->index();
      $this->load->view('add_edit_campaign_type', $data);
      $this->load->view('template/footer_content');
      $this->load->view('script');
      $this->load->view('template/footer');
    }
	
	function insert_update_campaign_type()
	{
		$id = $this->input->post('id');
		$continue = $this->input->post('btn_continue');
		if (empty($id))
		{
			$this->Email_blasts_model->insert_update_campaign_type();
			$this->session->set_flashdata('success', 'Campaign Type details successfully Created');
			if (isset($continue) && $continue === "Add & Continue")
			{
			   $url = 'email_blasts/add_edit_campaign_type';
			}
			else
			{
			   $url = 'email_blasts/campaign_type';
			}
		}
		else
		{
         
			$this->Email_blasts_model->insert_update_campaign_type($id);
			$this->session->set_flashdata('success', 'Campaign Type details successfully Created.');
			if (isset($continue) && $continue === "Update & Continue")
			{
				 $url = 'email_blasts/add_edit_campaign_type/'.$id;
			}
			else
			{
				 $url = 'email_blasts/campaign_type';
			}
		}
		redirect($url);
	}
	
	function delete_campaign_type()
     {
       $this->Email_blasts_model->delete_campaign_type();
        $this->session->set_flashdata('success', 'Successfully Deleted');
     }
 
 
     function delete_multiple_campaign_type()
    {
     $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
       'required' => 'You must select at least one row!'
     ));
     if ($this->form_validation->run() == FALSE)
     {
       $this->session->set_flashdata('error', validation_errors());
       redirect('email_blasts/campaign_type');
     }
     else
     {
       $this->Email_blasts_model->delete_multiple_campaign_type();
       $this->session->set_flashdata('success', 'Successfully Deleted');
       redirect('email_blasts/campaign_type');
     }
    }
    function check_campaign_name()
    {
       $campaign_name=$this->input->post('campaign_name');
    
  
        $campaign=$this->Email_blasts_model->check_campaign_name($campaign_name);
       
        if(!empty($campaign)):
          echo '1';
        else:
          echo '0';
        endif;
    }

    function check_campaign_type_name()
    {
     
       $campaign_name=$this->input->post('campaign_name');
       $website_id=$this->input->post('website_id');
    
  
        $campaign=$this->Email_blasts_model->check_campaign_type_name($campaign_name,$website_id);
     
        if(!empty($campaign)):
          echo '1';
        else:
          echo '0';
        endif;
    }

    function graphical_campaign_type()
	{   
		$campaign_user=array();
		$campaign_name=array();
		$campaign_id=array();
		$campaign=array();
		$background_color="";
		$campaign_category_id = $this->input->post('campaign_category_id');
		$get_campaign_names=$this->Email_blasts_model->get_campaign_name_Bi_reports($campaign_category_id);
		
		 foreach($get_campaign_names as $get_campaign_name):
			$campaign_id = $get_campaign_name->id;
			$campaign_name[] = $get_campaign_name->campaign_name;
			$campaign_type = $get_campaign_name->campaign_type;
			$get_user_data = $this->Email_blasts_model->get_campaign_user_data_Bi_reports($campaign_id, $campaign_type);
			if(!empty($get_user_data)):
				$campaign_value = count($get_user_data);
				$campaign[] = $campaign_value;
				$background_color .='#EE82EE';
			else:
				$campaign = '0';
				$background_color .='';
			endif;
			 // for($i=0;$i<count($get_user_data);$i++):
				// $user_id = $get_user_data[$i]->user_id;
				// $get_users=$this->Email_blasts_model->get_campaign_users_by_campaign_type($campaign_id[$i]);
			// endfor;			
		endforeach;
		$data['campaign_name'] = $campaign_name;
		$data['campaign_values'] =  $campaign;
		echo json_encode($data);
		  /* foreach($get_campaign_names as $get_campaign_name):
			$campaign_name[] = $get_campaign_name->campaign_name;
			if($get_campaign_name->campaign_type== $campaign_type):
				$campaign_id []=$get_campaign_name->id;
				print_r($campaign_id);die;
				$campaign_users=explode(",",$get_campaign_name->campaign_type);
				for($i=0;$i<count($campaign_id);$i++):
					$get_users=$this->Email_blasts_model->get_campaign_users_by_campaign_type($campaign_id[$i]);
					$campaign_user[]=  $get_users[0]->name;
				endfor;
			endif;
			if(in_array($get_campaign_name->campaign_name, $campaign_id )):
				$campaign_value .=count(  $campaign_user);
				$background_color .='#EE82EE';
			else:
				$campaign_value .= '0';
				$background_color .='';
			endif;
		endforeach; 
			   
		$data['campaign_name'] = $campaign_name;
		$data['campaign_values']=  $campaign_value;
		$data['campaign_users']=count($campaign_user);
		echo json_encode($data);*/    
	}
    function  campaign_type_reports()
    {
		$campaign_users=array();
		$data['website_id'] = $this->admin_header->website_id();
		$data['campaign_type'] = $this->Email_blasts_model->get_campaign_type_status( $data['website_id']);   
		$data['get_campaign_category'] = $this->Email_blasts_model->get_campaign_category_data();
		$data['heading']    = 'BI Reports';      
		$data['title'] = "BI Reports | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('user_reports', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');  
    }
	
	function send_sms()
	{	
		$website_id = $this->admin_header->website_id();	
		$campaign = $this->input->post('campaign');
		$from_name = $this->input->post('from_name');
		$from_email = $this->input->post('from_email');
		$patient_phone_numbers = $this->Email_blasts_model->get_patient_phone_numbers_by_campaign_id($campaign);	
		         
		if(!empty($patient_phone_numbers)):
			$patient_user[] = (object)array(
											'user_id' => '680'
										);						
			$patient_phone_nos = array_merge($patient_phone_numbers,$patient_user);
			foreach($patient_phone_nos as $patient_phone_no):			
				$user_id = $patient_phone_no->user_id;
				$phone_no_campaign_users = $this->Email_blasts_model->get_patient_users($user_id);
				$get_template_id = $this->Email_blasts_model->get_campaign_sms_template($campaign);
				$template_id = $get_template_id[0]->template_id;
				
				if(!empty($phone_no_campaign_users[0]->phone_number)):
					$phone_numbers = str_replace("-","",$phone_no_campaign_users[0]->phone_number);
					$phone_id = "+1";
					$phone_number = $phone_id.''.$phone_numbers;
					if(!empty($phone_no_campaign_users[0]->name)):
						$patient_names = explode(",",$phone_no_campaign_users[0]->name);
						$patient_name = $patient_names[1];
						$patient = explode(" ",trim($patient_name));
						$patient_first_name = $patient[0];
					endif;
				endif;
				// Replace key value with your own api key					
				$url = 'https://api.data247.com/v3.0?key=262385da4166dc1dc5&api=MT&phone='.$phone_number.'';
				$result = @file_get_contents($url);
				
				if ($result)
				{
					$result = @json_decode($result, true);
					if (!empty($result['response']['status']) && $result['response']['status'] == 'OK')
					{	
						$email_subject = "";
						$track_code = md5(rand()); 				
						$sms_address = $result['response']['results'][0]['sms_address'];
						$mail_config = $this->Email_blasts_model->get_mail_configuration($website_id );
						require_once "application/third_party/PHPMailer/vendor/autoload.php"; //PHPMailer Object
						$mail = new PHPMailer();
						$mail->IsSMTP();
						$mail->CharSet="UTF-8";
						$mail->SMTPSecure = 'tls';
						$mail->Host = $mail_config[0]->host;
						$mail->Port = $mail_config[0]->port;
						$mail->Username = $mail_config[0]->email;	
						$mail->Password = $mail_config[0]->password;
						$mail->SMTPAuth = true;
						$mail->From = $from_email;
						$mail->FromName = $from_name;
						$mail->AddAddress($sms_address);
						// $mail->addBCC('7135578001@vtext.com');
						$mail->addBCC('velusamy@desss.com');	
						// $mail->addBCC('saravana@desss.com');	
						$mail->IsHTML(true);
						$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_status/'.$user_id.'/'.$template_id.'';
						$ch = curl_init();  
						$timeout = '5';  
						curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
						curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
						curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
						$data = curl_exec($ch);
						if($template_id == '1'):							 
							//Others DLDC
							$mail->Body = "".$patient_first_name.", Thanks for being a patient of DLDC!  Pls click our link for a quick review! ".$data."";
							// $mail->Body    = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/yy98b7u3';
						elseif($template_id == '2'):
							//Dr.Reddy
							$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Reddy!  Pls click our link for a quick review! ".$data."";
							// $mail->Body    = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y365rxeu';
						elseif($template_id == '3'):
							// Dr.Hamat
							$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Hamat!  Pls click our link for a quick review! ".$data."";
							// $mail->Body       = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y2g3w5du';
						endif;
						//Others
						// $mail->Body    = 'BERNADETTE, Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/yy98b7u3';
												
						if(!$mail->Send())
						{
						  echo "Mailer Error: " . $mail->ErrorInfo;
						}
						else
						{
							$this->Email_blasts_model->insert_sms_data($user_id,$patient_first_name,$phone_no_campaign_users[0]->email,$phone_no_campaign_users[0]->phone_number,$sms_address);
							$this->Email_blasts_model->insert_sms_gateway_status($user_id,$campaign);
							$this->Email_blasts_model->insert_track($campaign, $user_id, $phone_no_campaign_users[0]->name, $phone_no_campaign_users[0]->email,$phone_no_campaign_users[0]->phone_number, $phone_no_campaign_users[0]->visited_date, $track_code, $email_subject, $from_name, $from_email,'sms');
							echo "Message sent!";
						}
					}
				} 	
			endforeach;
		endif;
		redirect('email_blasts');
	}
    
	function campaign_category()
	{
		$data['admin_user_id'] = $this->session_data['id'];
        $data['website_id'] = $this->admin_header->website_id();
        $data['table']      = $this->get_table_campaign_category();
        $data['heading']    = 'Campaign Category';
        $data['title']      = "Campaign Category | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('campaign_category', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
	}
	function get_table_campaign_category()
	{
		$website_id = $this->admin_header->website_id();
	   $campaign_categorys = $this->Email_blasts_model->get_campaign_category($website_id);
	    if (!empty($campaign_categorys)) {
            foreach ($campaign_categorys as $campaign_category) {
                $anchor_edit = anchor(site_url('email_blasts/add_edit_campaign_category/' . $campaign_category->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left',
                    'data-original-title' => 'Edit'
                ));
                
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $campaign_category->id . ', \'' . base_url('email_blasts/delete_campaign_category') . '\')'
                ));
                
            
                $cell = array(
                    'class' => 'last',
                    'data' => $anchor_edit . ' ' . $anchor_delete
                );
                $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $campaign_category->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $campaign_category->id . '">', ucwords($campaign_category->category),  $campaign_category->sort_order, $cell);
            }
        }
        
        // Table open
        
        $template = array(
            'table_open' => '<table
            id="datatable-responsive"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">'
            
        );
        $this->table->set_template($template);
        
        // Table heading row
        
        $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Category', 'Sort Order', 'Action');
        return $this->table->generate();
	}
	
	function add_edit_campaign_category($id = null)
	{
		if ($id != null):
			$campaign_category = $this->Email_blasts_model->get_campaign_category_by_id($id);
			$data['campaign_category_id'] = $campaign_category[0]->id;
			$data['category'] = $campaign_category[0]->category;
			$data['sort_order'] = $campaign_category[0]->sort_order;
		else:
			$data['campaign_category_id'] = "";
			$data['category'] = "";
			$data['sort_order'] = "";
		endif;
		
		$data['admin_user_id'] = $this->session_data['id'];
        $data['website_id'] = $this->admin_header->website_id();
        
        $data['heading']    = 'Campaign Category';
        $data['title']      = "Campaign Category| Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('add_edit_campaign_category', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
	}
	
	function insert_update_campaign_category()
	{
		$campaign_category_id = $this->input->post('campaign_category_id');
		$continue = $this->input->post('btn_continue');
		if (empty($campaign_category_id))
		{
			$this->Email_blasts_model->insert_update_campaign_category();
			$this->session->set_flashdata('success', 'Campaign Category details successfully Created');
			if (isset($continue) && $continue === "Add & Continue")
			{
			   $url = 'email_blasts/add_edit_campaign_category';
			}
			else
			{
			   $url = 'email_blasts/campaign_category';
			}
		}
		else
		{
         
			$this->Email_blasts_model->insert_update_campaign_category($campaign_category_id);
			$this->session->set_flashdata('success', 'Campaign Category details successfully Created.');
			if (isset($continue) && $continue === "Update & Continue")
			{
				$url = 'email_blasts/add_edit_campaign_category/'.$campaign_category_id;
			}
			else
			{
				$url = 'email_blasts/campaign_category';
			}
		}
		redirect($url);
	}
	
	//delete
    function delete_campaign_category()
    {
        $this->Email_blasts_model->delete_campaign_category();
        $this->session->set_flashdata('success', 'Successfully Deleted');
    }

    //mutliple delete
    function delete_multiple_campaign_category()
    {
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('email_blasts/campaign_category');
        } else {
            $this->Email_blasts_model->delete_multiple_campaign_category();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('email_blasts/campaign_category');
        }
    }
	// Category Selected Value
    function selected_category()
    {
        $data                = '';
        $category_id         = $_POST['categoryid'];
        $selected_categories = $this->Email_blasts_model->selected_category($category_id);
        if (!empty($selected_categories)) {
            foreach ($selected_categories as $selected_category) {
                $data .= '<option selected value="' . $selected_category->id . '">' . $selected_category->name . '</option>';
            }
        }
        echo $data;
    }
	
	// Add Category
    function insert_campaign_category()
    {
        $this->Email_blasts_model->insert_campaign_category();
        $this->session->set_flashdata('success', 'Campaign Category Successfully Created');
        redirect('email_blasts/add_edit_campaign');
    }
	 // Select Event Category
    function select_event_category()
    {
        $website_id       = $this->admin_header->website_id();
        $search           = strip_tags(trim($_GET['q']));
        $page             = $_GET['page'];
        $resultCount      = 25;
        $offset           = ($page - 1) * $resultCount;
        $campaign_categories = $this->Email_blasts_model->select_campaign_category($website_id, $search);
        if (!empty($campaign_categories)) {
            foreach ($campaign_categories as $campaign_categorie) {
                $answer[] = array(
                    "id" => $campaign_categorie->id,
                    "text" => $campaign_categorie->name
                );
            }
        } else {
            $answer[] = array(
                "id" => "",
                "text" => "No Results Found.."
            );
        }
        $count     = count($campaign_categories);
        $morePages = $resultCount <= $count;
        
        $results = array(
            "results" => $answer,
            "pagination" => array(
                "more" => $morePages
            )
        );
        echo json_encode($results);
    }
	
	function send_sms_blast()
	{		 
		$website_id = $this->admin_header->website_id();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['campaign_details'] = $this->Email_blasts_model->get_sms_campaign_detials();   
		$mail_config = $this->Email_blasts_model->get_mail_configuration($website_id );   
		if(!empty($mail_config)):
			$data['email'] = $mail_config[0]->mail_from;
		else:
			$data['email']='';
		endif;       
        
        $data['website_id'] = $this->admin_header->website_id();
        $data['title'] = 'Send Sms' . ' | Administrator';
        $data['heading'] = 'SMS';
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('send_sms_blast', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
	}
	
	function get_campaign_by_type()
	{
		$campaign_type = $this->input->post('campaign_type');
		$get_campaigns  = $this->Email_blasts_model->get_campaign_detials($campaign_type);
		if(!empty($get_campaigns))
		{
			foreach($get_campaigns as $get_campaign):
				$options = '<option value="'.$get_campaign->id.'">'.$get_campaign->campaign_name.'</option>';
				print_r($options);
			endforeach;			
		}else{
			echo '0';
		}
	}
	
	//Dynamic Email Template Generate
	function email_template_generate()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['table']      = $this->get_dynamic_email_template();
		$data['heading']    = 'Email Template';
		$data['title']      = "Email Template | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('email_template_generate', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	function get_dynamic_email_template()
	{       
		$website_id = $this->admin_header->website_id();
		$website_folder_name = $this->admin_header->website_folder_name();
		$ImageUrl = $this->admin_header->image_url();
		$get_template_data = $this->Email_blasts_model->get_dynamic_email_template();   
     
		foreach (($get_template_data ? $get_template_data : array()) as $get_template)
		{        
			$anchor_edit = anchor(site_url('email_blast/add_edit_email_template/' . $get_template->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
								 'data-toggle' => 'tooltip',
								 'data-placement' => 'left',
								 'data-original-title' => 'Edit'
							   ));
         
			$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
								 'data-toggle' => 'tooltip',
								 'data-placement' => 'right',
								 'data-original-title' => 'Delete',
								 'onclick' => 'return delete_record(' . $get_template->id . ', \'' . base_url('email_blast/delete_email_template/' . $website_id) . '\')'
							   ));
         
			if ($get_template->status === '1') 
			{
				$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
			} 
			else
			{
				$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
			}    

			if ($get_template->image != '')
			{
				$gallery_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $get_template->image;
				$image = img(array(
					'src' => $gallery_img ,
					'style' => 'width:145px; height:86px'
				));
			}
			else
			{
				$image = img(array(
					'src' => $ImageUrl . 'images/noimage.png',
					'style' => 'width:145px; height:86px'
				));
			}
         
			$cell = array(
						 'class' => 'last',
						 'data' =>  $anchor_edit.' '.$anchor_delete
					   );

      
     
		    $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_template->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $get_template->id . '">', $get_template->template_name,$image , $status, $cell);
		}
           
		$template = array(
						   'table_open' => '<table
						   id="datatable-responsive"
						   class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
						   width="100%" cellspacing="0">'
					    );

		$this->table->set_template($template);
     
		// Table heading row
		 
		$this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Name', 'Image','Status', 'Action');
		return $this->table->generate();
	}
	
	//Add & Edit Email Template
	function add_edit_email_template_generate($id = null)
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['table']      = $this->get_dynamic_email_template();
		$data['heading']    = 'Add Edit Email Template';
		$data['title']      = "Add Edit Email Template | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('add_edit_email_template_generate', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	//Single Patient Insert 
	function new_patient()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['heading']    = 'Add New Patient';
		$data['title']      = "Add New Patient | Administrator";
		$data['email_templates'] = $this->Email_blasts_model->get_email_template();
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('add_new_patient', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	//Check and SMS patient
	function check_patient_phone_number()
	{
		$phone_number = $this->input->post('phone_number');
		if(!empty($phone_number))
		{
			$patient_phone_numbers = $this->Email_blasts_model->check_patient_phone_number();	
			$patient_phone_numbers_sms_datas = $this->Email_blasts_model->check_patient_phone_number_sms_data($phone_number);		
     
			if(!empty($patient_phone_numbers))
			{	
				foreach($patient_phone_numbers as $patient_phone_number):
					$patient_name = $patient_phone_number->name;
					$patient_names = explode(',',$patient_name);
					$data['last_name'] = $patient_names[0];
					$data['first_name'] = trim($patient_names[1]);
								
					$data['patient_email'] = $patient_phone_number->email;
					
					$patient_carrires = $this->Email_blasts_model->get_carrier_247data($phone_number);
					if(!empty($patient_carrires)):
						$data['sms_address'] = $patient_carrires[0]->sms_data_email;
					else:
						$phone_numbers = str_replace("-","",$phone_number);
						$phone_id = "+1";
						$phone_number_data = $phone_id.''.$phone_numbers;
						
						// Replace key value with your own api key					
						$url = 'https://api.data247.com/v3.0?key=262385da4166dc1dc5&api=MT&phone='.$phone_number_data.'';
						$result = @file_get_contents($url);
				
						if ($result)
						{
							$result = @json_decode($result, true);
							if (!empty($result['response']['status']) && $result['response']['status'] == 'OK')
							{				
								$data['sms_address'] = $result['response']['results'][0]['sms_address'];
							}
						}
					endif;					
					echo json_encode($data);
				endforeach;
			}
			else
			{
				$phone_numbers = str_replace("-","",$phone_number);
				$phone_id = "+1";
				$phone_number_data = $phone_id.''.$phone_numbers;
				
				// Replace key value with your own api key					
				$url = 'https://api.data247.com/v3.0?key=262385da4166dc1dc5&api=MT&phone='.$phone_number_data.'';
				$result = @file_get_contents($url);
				
				if ($result)
				{
					$result = @json_decode($result, true);
					if (!empty($result['response']['status']) && $result['response']['status'] == 'OK')
					{				
						$data['sms_address'] = $result['response']['results'][0]['sms_address'];
					}
				}
				
				echo json_encode($data);
			}
		}else
		{
			$data = '0';
			echo $data;
		}
	}
	
	//Insert New Single Patient
	function insert_new_patients()
	{
		$website_id = $this->input->post('website_id');
			
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$patient_email = $this->input->post('patient_email');
		$phone_number = $this->input->post('phone_number');
		$sms_address  = $this->input->post('carrier_data');
		$template_id  = $this->input->post('review');
		$get_patient_users = $this->Email_blasts_model->check_patient_phone_number();
		$get_new_patient_users = $this->Email_blasts_model->check_new_patient_phone_number($phone_number);
		if(empty($get_patient_users)){
			$new_patients = $this->Email_blasts_model->insert_new_patients_master_table();
		}
		if(empty($get_new_patient_users)){
			$new_patient_user = $this->Email_blasts_model->insert_new_patients();
		}

		if(!empty($first_name)):
			$patient = explode(" ",trim($first_name));
			$patient_first_name = $patient[0];
		endif;
  
		if(!empty($sms_address)):
			$mail_config = $this->Email_blasts_model->get_mail_configuration($website_id );
			require_once "application/third_party/PHPMailer/vendor/autoload.php"; //PHPMailer Object
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->CharSet="UTF-8";
			$mail->SMTPSecure = 'tls';
			$mail->Host = $mail_config[0]->host;
			$mail->Port = $mail_config[0]->port;
			$mail->Username = $mail_config[0]->email;	
			$mail->Password = $mail_config[0]->password;
			$mail->SMTPAuth = true;
			$mail->From = $mail_config[0]->mail_from;
			$mail->FromName = 'Digestive & Liver Disease Consultants , P.A';
			$mail->AddAddress($sms_address);
			$mail->addBCC('velusamy@desss.com');
			$mail->IsHTML(true);

			if($template_id == '1'):							 
				//Others DLDC
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of DLDC!  Pls click our link for a quick review! tinyurl.com/rzxelcq";
				// $mail->Body    = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/yy98b7u3';
			elseif($template_id == '2'):
				//Dr.Google
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Reddy!  Pls click our link for a quick review! tinyurl.com/y365rxeu";
				// $mail->Body    = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y365rxeu';
			elseif($template_id == '8'):
				// Dr.Reddy
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Reddy!  Pls click our link for a quick review! tinyurl.com/y365rxeu";
				// $mail->Body   = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y2g3w5du';
			elseif($template_id == '7'):
				// Dr.Hamat
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Hamat!  Pls click our link for a quick review! tinyurl.com/y2g3w5du";
				// $mail->Body  = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y2g3w5du';
			elseif($template_id == '3'):
				// Facebook
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of DLDC!  Pls click our link for a quick review! tinyurl.com/y365rxeu";
				// $mail->Body  = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y2g3w5du';
			endif;
									
			if(!$mail->Send())
			{	
			    echo "Mailer Error: " . $mail->ErrorInfo;
				echo "<script type='text/javascript'>alert('Message not sent!');window.location='email_blasts/new_patient';</script>";
			}
			else
			{
				$patient_carrires = $this->Email_blasts_model->get_carrier_247data($phone_number);
				if(empty($patient_carrires)):
					$user_id = '0';
					$this->Email_blasts_model->insert_sms_data($user_id,$patient_first_name,$patient_email,$phone_number,$sms_address);
					// $this->Email_blasts_model->insert_sms_gateway_status($user_id,$campaign);
					// $this->Email_blasts_model->insert_track($campaign, $user_id, $phone_no_campaign_users[0]->name, $phone_no_campaign_users[0]->email,$phone_no_campaign_users[0]->phone_number, $phone_no_campaign_users[0]->visited_date, $track_code, $email_subject, $from_name, $from_email,'sms');
				endif;
				// $this->Email_blasts_model->insert_sms_data($user_id,$patient_first_name,$phone_no_campaign_users[0]->email,$phone_no_campaign_users[0]->phone_number,$sms_address);
				// $this->Email_blasts_model->insert_sms_gateway_status($user_id,$campaign);
				// $this->Email_blasts_model->insert_track($campaign, $user_id, $phone_no_campaign_users[0]->name, $phone_no_campaign_users[0]->email,$phone_no_campaign_users[0]->phone_number, $phone_no_campaign_users[0]->visited_date, $track_code, $email_subject, $from_name, $from_email,'sms');
				// echo "Message sent!";
				
				echo "<script type='text/javascript'> alert('Message sent!');window.location='email_blasts/new_patient';</script>";
			}
		endif;
		// redirect('email_blasts/new_patient');
	}
	
	function send_sms_import_data_view()
	{
        $data['website_id'] = $this->admin_header->website_id();
        $data['title'] = 'Send Sms' . ' | Administrator';
        $data['heading'] = 'SMS';
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('send_sms_import_data', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
	}
	
	function send_sms_import_data()
	{
		$website_id = $this->admin_header->website_id();
		$campaign_type = $this->input->post('campaign_type_name');
		$from_name = $this->input->post('from_name');
		$from_email = $this->input->post('from_email');
		
		$get_import_campaign_datas = $this->Email_blasts_model->get_campaign_category_import_data();
		
		if(!empty($get_import_campaign_datas))
		{
			if($campaign_type == 'sms'){
				$campaign_type_data = 'sms';
			}else{
				$campaign_type_data = 'email';
			}
			$patient_user[] = (object)array(
											'user_id' => '680',
											'campaign_type' =>$campaign_type_data
										);	
			$new_user[] = (object)array(
											'user_id' => '1492',
											'campaign_type' =>$campaign_type_data
										);												
			$patient_phone_nos = array_merge($get_import_campaign_datas,$patient_user);
			$new_users = array_merge($patient_phone_nos,$new_user);
			// echo '<pre>';print_r($new_users);die;
			foreach($new_users as $get_import_campaign_data)
			{
				$user_id = $get_import_campaign_data->user_id;				
				$phone_no_campaign_users = $this->Email_blasts_model->get_patient_users($user_id);
				
				// Phone Number
				if(!empty($phone_no_campaign_users[0]->phone_number)):
					$phone_numbers = str_replace("-","",$phone_no_campaign_users[0]->phone_number);
					$phone_id = "+1";
					$phone_number = $phone_id.''.$phone_numbers;					
				endif;
				// Patient Name
				if(!empty($phone_no_campaign_users[0]->name)):
					$patient_names = explode(",",$phone_no_campaign_users[0]->name);
					$patient_name = $patient_names[1];
					$patient = explode(" ",trim($patient_name));
					$patient_first_name = $patient[0];
				endif;
				// Provider Name
				if(!empty($phone_no_campaign_users[0]->provider_name)):
					if($phone_no_campaign_users[0]->provider_name == 'REDDY, GURUNATH T' || $phone_no_campaign_users[0]->provider_name == 'REDDY' || $phone_no_campaign_users[0]->provider_name == 'reddy' || $phone_no_campaign_users[0]->provider_name == 'Reddy')
					{
						$template_id = '2';
						if($get_import_campaign_data->campaign_type == 'sms'):
							$campaign = '4';
						else:
							$campaign = '3';
						endif;
						
					}
					elseif($phone_no_campaign_users[0]->provider_name == 'HAMAT, HOWARD' || $phone_no_campaign_users[0]->provider_name == 'HAMAT' || $phone_no_campaign_users[0]->provider_name == 'Hamat' || $phone_no_campaign_users[0]->provider_name == 'hamat')
					{
						$template_id = '3';
						if($get_import_campaign_data->campaign_type == 'sms'):
							$campaign = '6';
						else:
							$campaign = '5';
						endif;
					}
					elseif($phone_no_campaign_users[0]->provider_name == 'DLDC' || $phone_no_campaign_users[0]->provider_name == 'dldc')
					{
						$template_id = '1';
						if($get_import_campaign_data->campaign_type == 'sms'):
							$campaign = '2';
						else:
							$campaign = '1';
						endif;
						
					}	
				endif;
				// Patient Email
				if(!empty($phone_no_campaign_users[0]->email)):
					$patient_email = $phone_no_campaign_users[0]->email;
				endif;
				
				if($get_import_campaign_data->campaign_type == 'sms')
				{
					// Replace key value with your own api key					
					$url = 'https://api.data247.com/v3.0?key=262385da4166dc1dc5&api=MT&phone='.$phone_number.'';
					$result = @file_get_contents($url);
					if ($result)
					{
						$result = @json_decode($result, true);			
						if (!empty($result['response']['status']) && $result['response']['status'] == 'OK')
						{	
							$email_subject = "";
							$track_code = md5(rand()); 				
							$sms_address = $result['response']['results'][0]['sms_address'];
							$mail_config = $this->Email_blasts_model->get_mail_configuration($website_id );
							require_once "application/third_party/PHPMailer/vendor/autoload.php"; //PHPMailer Object
							$mail = new PHPMailer();
							$mail->IsSMTP();
							$mail->CharSet="UTF-8";
							$mail->SMTPSecure = 'tls';
							$mail->Host = $mail_config[0]->host;
							$mail->Port = $mail_config[0]->port;
							$mail->Username = $mail_config[0]->email;	
							$mail->Password = $mail_config[0]->password;
							$mail->SMTPAuth = true;
							$mail->From = $from_email;
							$mail->FromName = $from_name;
							$mail->AddAddress($sms_address);						
							$mail->addBCC('velusamy@desss.com');							
							$mail->IsHTML(true);
							
							$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_status/'.$user_id.'/'.$template_id.'';
							$ch = curl_init();  
							$timeout = '5';  
							curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
							curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
							curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
							$data = curl_exec($ch);
							
							if($template_id == '1'):							 
								//Others DLDC
								$mail->Body = "".$patient_first_name.", Thanks for being a patient of DLDC!  Pls click our link for a quick review! ".$data."";								
							elseif($template_id == '2'):
								//Dr.Reddy
								$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Reddy!  Pls click our link for a quick review! ".$data."";								
							elseif($template_id == '3'):
								// Dr.Hamat
								$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Hamat!  Pls click our link for a quick review! ".$data."";								
							endif;
													
							if(!$mail->Send())
							{
							  echo "Mailer Error: " . $mail->ErrorInfo;
							}
							else
							{
								$patient_carrires = $this->Email_blasts_model->get_carrier_247data($phone_number);
								if(empty($patient_carrires)):
									$this->Email_blasts_model->insert_sms_data($user_id,$patient_first_name,$phone_no_campaign_users[0]->email,$phone_no_campaign_users[0]->phone_number,$sms_address);
								endif;
								$this->Email_blasts_model->insert_sms_gateway_status($user_id,$campaign);
								$this->Email_blasts_model->insert_track($campaign, $user_id, $phone_no_campaign_users[0]->name, $phone_no_campaign_users[0]->email,$phone_no_campaign_users[0]->phone_number, $phone_no_campaign_users[0]->visited_date, $track_code, $email_subject, $from_name, $from_email,$campaign_type);
								echo "Message sent!";
							}
						}
					}
				}elseif($get_import_campaign_data->campaign_type == 'email')
				{
					$mail_configurations = $this->Email_blasts_model->get_mail_configuration($website_id);
					if (!empty($mail_configurations)) {
						$email_subject = "Digestive & Liver Disease Consultants , P.A";
						require_once APPPATH.'third_party/PHPMailer/vendor/autoload.php';
						$track_code = md5(rand());
						$mail = new PHPMailer;
						// SMTP configuration
						$mail->isSMTP();
						$mail->Host     = $mail_configurations[0]->host;
						$mail->SMTPAuth = true;
						$mail->Username = $mail_configurations[0]->email;
						$mail->Password = $mail_configurations[0]->password;
						$mail->Port     = $mail_configurations[0]->port;						 							
						$mail->setFrom($from_email, $from_name);                    
						$mail->Subject= $email_subject;
						// Set email format to HTML
						$mail->isHTML(true);
						// Email body content
						$mailContent = '<!DOCTYPE html
								PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							  <html>
							  
							  <head>
								<meta charset="UTF-8">
								<meta content="width=device-width, initial-scale=1" name="viewport">
								<meta name="x-apple-disable-message-reformatting">
								<meta http-equiv="X-UA-Compatible" content="IE=edge">
								<meta content="telephone=no" name="format-detection">
								<title></title>
								<!--[if (mso 16)]>
								  <style type="text/css">
								  a {text-decoration: none;}
								  </style>
								  <![endif]-->
								<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
								<!--[if !mso]><!-- -->
								<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700,700i" rel="stylesheet">
								<!--<![endif]-->
							  </head>
							  
							  <body>
								<div class="es-wrapper-color">
								  <!--[if gte mso 9]>
										  <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
											  <v:fill type="tile" color="#f6f6f6"></v:fill>
										  </v:background>
									  <![endif]-->
								  <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
									<tbody>
									  <tr>
										<td class="esd-email-paddings">
										  <table class="es-content esd-footer-popover" cellspacing="0" cellpadding="0" align="center"
											style="border: 5px solid #603;padding: 10px;background: #fff;">
											<tbody>
											  <tr>
												<td class="esd-stripe" align="center">
												  <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" align="center"
													style="border-left:3px solid transparent;">
													<tbody>
							  
													  <tr>
														<td style="text-align: center;"><img
															src="https://www.txgidocs.com/assets/images/txgidocs/logo/logo%20(1).png"
															width="100" />
														  <h3
															style="color:#003954; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; text-align:center;font-size: 25px;font-weight: 300;">
															Digestive & Liver Disease Consultants, P.A. </h3>
															<br>
														</td>
													  </tr>
							  
													  <tr>
														<td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
														  <table width="100%" cellspacing="0" cellpadding="0">
															<tbody>
															  <tr>
																<td class="esd-container-frame" width="557" valign="top" align="center">
																  <table width="100%" cellspacing="0" cellpadding="0">
																	<tbody>
																	  <tr>
																		<td align="left" class="esd-block-text es-p15b">
																		  <h2
																			style="color: rgb(102, 0, 51); font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif;font-size: 21px;font-weight: 600;">
																			Dear '. $patient_first_name .',</h2>
																		</td>
																	  </tr>';
																		if($template_id =='1'):
																			 $mailContent .= '<tr>
																								<td class="esd-block-text es-p20t" align="left">
																								  <p
																									style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																									    Thanks for being a patient of DLDC! Pls click our link for a quick review!
																								  </pre>
																								</td>
																							  </tr>';
																		elseif($template_id=='2'):
																			$mailContent .= '<tr>
																								<td class="esd-block-text es-p20t" align="left">
																								  <p
																									style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																									   Thanks for being a patient of Dr. Reddy! Pls click our link for a quick review!
																								  </pre>
																								</td>
																							  </tr>';
																		elseif ($template_id=='3') :
																			$mailContent .= '<tr>
																								<td class="esd-block-text es-p20t" align="left">
																								  <p
																									style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																									   Thanks for being a patient of Dr. Hamat! Pls click our link for a quick review!
																								  </pre>
																								</td>
																							  </tr>';
																		/* elseif ($template_id=='8') :
																			$mailContent .= '<tr>
																								<td class="esd-block-text es-p20t" align="left">
																								  <p
																									style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																									   Thanks for being a patient of Dr. Reddy! Pls click our link for a quick review!
																								  </pre>
																								</td>
																							  </tr>';
																		else:
																			$mailContent .= '<tr>
																								<td class="esd-block-text es-p20t" align="left">
																								  <p
																									style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																									   Thanks for being a patient of Facebook Pls click our link for a quick review!
																								  </pre>
																								</td>
																							  </tr>'; */
																		endif;
																	 
																	  
																	  $mailContent .= ' <tr>
																	  </tr>
																	  <tr>
																		<td align="center" esd-links-color="#ffffff" class="esd-block-text">
																		<br>
																		<table cellspacing="0" cellpadding="0">
																		<tr>';

																		 if($template_id =='1'):
																	   
																		   $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#660033">
																								<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																								Digestive & Liver Disease Consultants, P.A.  Google Reviews
																								</a>
																							 </td>';
																		 elseif($template_id=='2'):
																		  $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																						  <a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																							Dr. Reddy Google Reviews
																						  </a>
																					   </td>';
																		  elseif ($template_id=='3') :
																			$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																								<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google-hamat" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																								Dr. Hamat Google Reviews
																								</a>
																							 </td>';
																		 /* elseif ($template_id=='8') :
																			$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																								<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google-reddy" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																								  Google
																								</a>
																							 </td>';
																		  else:
																			$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#3b5998">
																								<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=facebook" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																								  Facebook
																								</a>
																							 </td>'; */

																		  endif;
							
																  $mailContent .= ' </tr>
																	</table>
																	<br>                                              
																		 
																		  </td>
																	  </tr>
																	  <tr>
																		<td class="esd-block-text es-p15t" align="left">
																		  
																		  <p
																			style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																			<br>
																		  </p>
																		  <p
																			style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																			Sincerely,</p>                                                              
																		  <p
																			style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																			<img src="https://www.txgidocs.com/assets/images/txgidocs/logo/logo%20(1).png" width="90" />
																			<h3
																			  style="color:#003954; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 16px;font-weight: 300;">
																			  Digestive &amp; Liver Disease Consultants, P.A. </h3>
																		  </p>
							  
																		  <p><br>
																		  </p>
																		</td>
																	  </tr>                                                          
																	</tbody>
																  </table>
																</td>
															  </tr>
															</tbody>
														  </table>
														</td>
													  </tr>
													</tbody>
												  </table>
												</td>
											  </tr>
											</tbody>
										  </table>
										</td>
									  </tr>
									</tbody>
								  </table>
								</div>
								<img src="' . base_url() . 'email_blasts/track_mail/track_mail_update/' . $track_code . '" width="1" height="1" style="display: none;"/>
							  </body>                  
							</html>';
						$mail->Body = $mailContent;
						$mail->clearAddresses();
						// Add a recipient
						$mail->addAddress($patient_email);
						$mail->addBCC('velusamy@desss.com');
							
						if(!$mail->send()){
							echo 'Message could not be sent.';
							echo 'Mailer Error: ' . $mail->ErrorInfo;
						} else {
								$this->Email_blasts_model->update_send_email_status($campaign,$user_id);	
								$this->Email_blasts_model->insert_track($campaign, $user_id, $phone_no_campaign_users[0]->name, $patient_email ,$phone_no_campaign_users[0]->phone_number, $phone_no_campaign_users[0]->visited_date, $track_code, $email_subject, $from_name, $from_email,$campaign_type);						
						}
							$this->session->set_flashdata('success', 'Mail sent Successfully.');              
					}
				}
				
			}	
		}
		redirect('email_blasts/send_sms_import_data_view');
	}
	
	function test_email()
	{
		$RDmax = $this->input->post('RD');
		$IRmax = $this->input->post('IR');
		$REmax = $this->input->post('RE');
		echo '<pre>';
		print_r($_POST);die;
		
		if(array("table[data-edit]")){
			$RD = array("table[data-edit]");
		}else{
			$RD = array();
		}
		$IR = array("img");
		$RE = array("#dd-sidebar-left,#dd-sidebar-right");
		
		for($i=0; $i < $RDmax; $i++)
		{
			/* ($RD[$i]).css({
				width : '100%'
			});
			($RD[$i]).find('tr > td').css({
				padding:'',
				margin:''
			});
			
			($RD[$i]).find('table tr > td').css({
				padding:'',
				margin:''
			}); */
		}
		
		for($j=0; $j < $IRmax; $j++)
		{
			echo 'test2';
			/* ($IR[$j]).css({
				width : '100%',
				height : 'auto'
			})
			.removeAttr('class'); */
		}
		
		for($r=0; $r < $REmax; $r++)
		{
			echo 'test3';
			/* $rem = $($RE[$r]).html().trim();
			if($rem == '')
				($RE[$r]).remove();
			else{
				($RE[$r]).find('a').each(function(){
					$(this).css('text-decoration','none');
				});
			} */
		}
		die;
	}
}