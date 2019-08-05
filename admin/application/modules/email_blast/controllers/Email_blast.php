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

class Email_blast extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('Email_blast_model');
        $this->load->module('admin_header');
        $this->load->module('color');
        $this->load->library('csvimport');
        $this->load->library('email');
    }
    
    // Index
    function index()
    {
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
        $get_users  = $this->Email_blast_model->get_users();
       
    
        foreach (($get_users ? $get_users : array()) as $get_user) {
            
            // $anchor_edit = anchor(site_url('email_blast/add_edit_users/' . $get_user->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
            //     'data-toggle' => 'tooltip',
            //     'data-placement' => 'left',
            //     'data-original-title' => 'Edit'
            // ));
            
            $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                'data-toggle' => 'tooltip',
                'data-placement' => 'right',
                'data-original-title' => 'Delete',
                'onclick' => 'return delete_record(' . $get_user->id . ', \'' . base_url('email_blast/delete_user/' . $website_id) . '\')'
            ));
            
            $cell = array(
              'class' => 'last',
              'data' => $anchor_delete
            );

            $email_track_data = $this->Email_blast_model->get_email_track($get_user->email);

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
        
            $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_user->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $get_user->id . '">', $get_user->name, $get_user->email, $get_user->visited_date, $txgidocs, $google, $facebook, $cell);
        }
        
        // Table open
        
        $template = array(
            'table_open' => '<table
            id="datatable-buttons"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">'
        );
        $this->table->set_template($template);
        
        // Table heading row
        
        $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Name', 'Email','Visited Date','Txgidocs', 'Google', 'Facebook', 'Action');
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
          $upload_csv = array('upload_data' => $this->upload->data());
          $data['file'] = $upload_csv['upload_data']['full_path'];
          $entire_data = file_get_contents($data['file']);
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

        $records = $this->Email_blast_model->get_existing_users();
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
          $this->Email_blast_model->insert($insert_array);
          $this->session->set_flashdata('success', 'Successfully Imported.');
          redirect('email_blast');
        }
        else 
        {
          $this->session->set_flashdata('error', 'Users already exists');
          redirect('email_blast');
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
      $get_campaign_data = $this->Email_blast_model->get_campaign();   
      
      foreach (($get_campaign_data ? $get_campaign_data : array()) as $get_campaign)
      {
          
        $anchor_edit = anchor(site_url('email_blast/add_edit_campaign/' . $get_campaign->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
          'data-toggle' => 'tooltip',
          'data-placement' => 'left',
            'data-original-title' => 'Edit'
        ));
          
        $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
          'data-toggle' => 'tooltip',
          'data-placement' => 'right',
          'data-original-title' => 'Delete',
          'onclick' => 'return delete_record(' . $get_campaign->id . ', \'' . base_url('email_blast/delete_campaign/' . $website_id) . '\')'
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
        $campaign = $this->Email_blast_model->get_campaign_by_id($id);
        $data['id'] = $campaign[0]->id;
        $data['campaign_name'] = $campaign[0]->campaign_name;
        $data['description'] = $campaign[0]->description;
        $data['template'] = $campaign[0]->template_id;
        $data['status'] = $campaign[0]->status;
      else:
        $data['id'] = "";
        $data['campaign_name'] = "";
        $data['description'] = "";
        $data['template'] = "";
        $data['status'] = "";
      endif;

      $data['website_id'] = $this->admin_header->website_id();
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
        $get_users  = $this->Email_blast_model->get_users();

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

            $email_track_data = $this->Email_blast_model->get_email_track($get_user->email);

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
        
            $this->table->add_row($i.' <input type="hidden" class="hidden-user-id" name="row_sort_order[]" value="' . $get_user->id . '">', $get_user->name, $get_user->email, $get_user->visited_date, $txgidocs, $google, $facebook);

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
        
        $this->table->set_heading('S.No', 'Name', 'Email','Visited Date','Txgidocs', 'Google', 'Facebook');
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
  
          $this->Email_blast_model->update_campaign($update_campaign_array);
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
  
          $campaign_id = $this->Email_blast_model->insert_campaign($insert_campaign_array);
        }  

        $records = $this->Email_blast_model->get_existing_campaign_users();
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
          $this->Email_blast_model->insert_campaign_users($insert_array);
          $this->session->set_flashdata('success', 'Successfully Imported.');
          redirect('email_blast/campaign');
        }
        else 
        {
          $this->session->set_flashdata('error', 'Something Went Wrong');
          redirect('email_blast/campaign');
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
      $data['campaign_details'] = $this->Email_blast_model->get_campaign_detials();
      $mail_config = $this->Email_blast_model->get_mail_configuration($website_id );
        
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

          
        // $get_users = $this->Email_blast_model->get_users();
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
       $template = $this->Email_blast_model->get_campaign_template($campaign_id);
       if (!empty($template)) :
        echo $template[0]->template_id;
       else :
        echo '0';
       endif;
     }

     // Send Mail
     function send_mail_based_on_campaign()
     {
       $campaign_id = $this->input->post('campaign');
       $get_users = $this->Email_blast_model->get_campaign_users_by_campaign_id($campaign_id);
        if (!empty($get_users)):
            $this->send_email_blast();
        else:
            $this->session->set_flashdata('error', 'Please enable the users');
            redirect('email_blast');
        endif;
     }

      // Send Email    
    function send_email_blast()
    {
       
        $website_id          = $this->admin_header->website_id();
        $mail_configurations = $this->Email_blast_model->get_mail_configuration($website_id);
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
            $campaign_id = $this->input->post('campaign');
            $from_name = $this->input->post('from_name');
            $from_email = $this->input->post('from_email');
            $email_subject = $this->input->post('subject');

            $get_users = $this->Email_blast_model->get_campaign_users_by_campaign_id($campaign_id);
            $get_template_id = $this->Email_blast_model->get_campaign_template($campaign_id);
            $template_id= $get_template_id[0]->template_id;             
           
            foreach ($get_users as $get_user) :
              
              // if ($get_user->status == '1'):
                
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
                                                            <td class="esd-block-text es-p20t" align="left">
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                Thank you for visiting Digestive & Liver Disease Consultants, P.A . Your
                                                                wellbeing is very important to us. To help serve you and others more
                                                                effectively, please take a moment to let us know about your experience on <strong>'. $get_user->visited_date .'</strong>.
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

                                                             if($template_id=='1'):
                                                           
                                                               $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#660033">
                                                                    <a href="http://txgidocs.desss-portfolio.com/reviews.html?review_user_id='.$get_user->id.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
                                                                    Digestive & Liver Disease Consultants, P.A.  Reviews
                                                                    </a>
                                                                 </td>';
                                                             elseif($template_id=='2'):
                                                              $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
                                                              <a href="http://txgidocs.desss-portfolio.com/reviews.html?review_user_id='.$get_user->id.'&type=google" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
                                                                Google
                                                              </a>
                                                           </td>';
                                                              else:
                                                                $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#3b5998">
                                                                <a href="http://txgidocs.desss-portfolio.com/reviews.html?review_user_id='.$get_user->id.'&type=facebook" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
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
                    <img src="' . base_url() . 'email_blast/track_mail/track_mail_update/' . $track_code . '" width="1" height="1" style="display: none;"/>
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

                        $this->Email_blast_model->insert_track($campaign_id, $get_user->id, $get_user->name, $get_user->email, $get_user->visited_date, $track_code, $email_subject, $from_name, $from_email);
                    }
                    $this->session->set_flashdata('success', 'Mail sent Successfully.');
                // else:
                //     $this->session->set_flashdata('error', 'Please enable user status !');
                // endif;
            endforeach;
        }
        redirect('email_blast');
    }

    // Email Tracking Reports
    function email_tracking()
    {
        $data['website_id'] = $this->admin_header->website_id();
        $data['table']      = $this->get_email_track();
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
        $email_tracks = $this->Email_blast_model->get_email_track_data();
        
        foreach (($email_tracks ? $email_tracks : array()) as $email_track) {
            
            if ($email_track->status === '1') {
                $status = '<span class="label label-success">Open</span>';
            } else {
                $status = '<span class="label label-danger">Not Open</span>';
            }
            $reviews_entry= $this->Email_blast_model->get_review_comments($email_track->track_id);
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

            $this->table->add_row($email_track->name, $email_track->email, $txgidocs, $google, $facebook ,$comment, $status);
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
        
        $this->table->set_heading('Name', 'Email', 'Txgidocs', 'Google', 'Facebook', 'Comments','Status');
        return $this->table->generate();
    }

     //Resend Mail
     function resend_mail()
     {
        $website_id          = $this->admin_header->website_id();
        $mail_configurations = $this->Email_blast_model->get_mail_configuration($website_id);
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

            $get_users = $this->Email_blast_model->get_email_track_users();   
          
            foreach ($get_users as $get_user) :

              $template = $this->Email_blast_model->get_template_id_by_campaign($get_user->campaign_id);

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
                                                            <td class="esd-block-text es-p20t" align="left">
                                                              <p
                                                                style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
                                                                Thank you for visiting Digestive & Liver Disease Consultants, P.A . Your
                                                                wellbeing is very important to us. To help serve you and others more
                                                                effectively, please take a moment to let us know about your experience on <strong>'. $get_user->visited_date .'</strong>.
                                                              </pre>
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

                                                            if($template_id == '1'):
                                                          
                                                              $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#660033">
                                                                    <a href="http://txgidocs.desss-portfolio.com/reviews.html?review_user_id='.$get_user->id.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
                                                                    Digestive & Liver Disease Consultants, P.A.  Reviews
                                                                    </a>
                                                                </td>';
                                                            elseif($template_id == '2'):
                                                              $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
                                                              <a href="http://txgidocs.desss-portfolio.com/reviews.html?review_user_id='.$get_user->id.'&type=google" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
                                                                Google
                                                              </a>
                                                          </td>';
                                                              else:
                                                                $mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#3b5998">
                                                                <a href="http://txgidocs.desss-portfolio.com/reviews.html?review_user_id='.$get_user->id.'&type=facebook" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
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
                        
                        //$this->Email_blast_model->insert_track($get_user->id,$get_user->name, $get_user->email, $track_code);
                    }
                    $this->session->set_flashdata('success', 'Mail sent Successfully.');
                // else:
                //     $this->session->set_flashdata('error', 'Please enable user status !');
                // endif;
            endforeach;
        }
        redirect('email_blast/email_tracking');              
     }




























    
    // Import users 
    function import_users()
    {
        $data['website_id'] = $this->admin_header->website_id();
        $data['campaign_details'] = $this->Email_blast_model->get_campaign_detials();
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
      $records = $this->Email_blast_model->get_existing_users();
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
            $this->Email_blast_model->insert($data);
            $this->session->set_flashdata('success', 'Successfully Imported.');
            redirect('email_blast');
          }
          else 
          {
            $this->session->set_flashdata('error', 'Users already exists');
            redirect('email_blast');
          }

          
      }
        
    }

    //delete
    function delete_user()
    {
        $this->Email_blast_model->delete_user_data();
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
            redirect('email_blast');
        } else {
            $this->Email_blast_model->delete_multiple_user_data();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('email_blast');
        }
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
      $comments_posted = array();
      $comments_not_posted = array();

      $data['website_id'] = $this->admin_header->website_id();

      $get_email_track = $this->Email_blast_model->get_email_track_data();
      
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
        $reviews_entry = $this->Email_blast_model->get_review_comments($email_track->track_id);
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
			  $this->Email_blast_model->insert_update_campaign();
			   $this->session->set_flashdata('success', 'Campaign details successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'email_blast/add_edit_campaign';
				}
				else
				{
					$url = 'email_blast/campaign';
				}
			}
			else
			{
        
				$this->Email_blast_model->insert_update_campaign($id);
				$this->session->set_flashdata('success', 'Campaign details Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'email_blast/add_edit_campaign/' . $id;
				}
				else
				{
					$url = 'email_blast/campaign';
				}
      }
      redirect($url);
    }

    function delete_campaign()
    {
      $this->Email_blast_model->delete_campaign_data();
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
			redirect('email_blast/campaign');
		}
		else
		{
			$this->Email_blast_model->delete_multiple_campaign_data();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('email_blast/campaign');
		}
   }

   

   // Insert Master File
   function insert_import_master_users()
   {
     $existing_users = [];
      $records = $this->Email_blast_model->get_existing_users();
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
          $this->Email_blast_model->insert($data);
          $this->session->set_flashdata('success', 'Successfully Imported.');
          redirect('email_blast');
      }     
   }

   //Campaign Type
   
   function campaign_type()
   {
	    $data['website_id'] = $this->admin_header->website_id();
        $data['table']      = $this->get_campaign_type_table($data['website_id']);
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
   function get_campaign_type_table($website_id)
   {
	   $get_campaign_type_data = $this->Email_blast_model->get_campaign_type($website_id);   
      
      foreach (($get_campaign_type_data ? $get_campaign_type_data : array()) as $get_campaign_type)
      {
          
        $anchor_edit = anchor(site_url('email_blast/add_edit_campaign_type/' . $get_campaign_type->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
          'data-toggle' => 'tooltip',
          'data-placement' => 'left',
            'data-original-title' => 'Edit'
        ));
          
        $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
          'data-toggle' => 'tooltip',
          'data-placement' => 'right',
          'data-original-title' => 'Delete',
          'onclick' => 'return delete_record(' . $get_campaign_type->id . ', \'' . base_url('email_blast/delete_campaign_type/' . $website_id) . '\')'
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
        $campaign_type = $this->Email_blast_model->get_campaign_type_by_id($id);
        $data['id'] = $campaign_type[0]->id;
        $data['campaign_type'] = $campaign_type[0]->campaign_type;
        $data['status'] = $campaign_type[0]->status;
      else:
        $data['id'] = "";
        $data['campaign_type'] = "";
        $data['status'] = "";
      endif;

      $data['website_id'] = $this->admin_header->website_id();
      $data['title'] = ($id != null) ? 'Edit Campaign type' : 'Add Campaign type' . ' | Administrator';
      $data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Campaign Type';
 
      $this->load->view('template/meta_head', $data);
      $this->load->view('email_blast_header');
      $this->admin_header->index();
      $this->load->view('add_edit_campaign_type', $data);
      $this->load->view('template/footer_content');
      $this->load->view('script');
      $this->load->view('template/footer');
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
   
   function get_email_template()
   {
       
     $website_id = $this->admin_header->website_id();
     $get_template_data = $this->Email_blast_model->get_email_template();   
     
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
         
       $cell = array(
         'class' => 'last',
         'data' =>  $anchor_edit.' '.$anchor_delete
       );

      
     
       $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_template->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $get_template->id . '">', $get_template->campaign_name,  $status, $cell);
     }
           
     $template = array(
       'table_open' => '<table
       id="datatable-responsive"
       class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
       width="100%" cellspacing="0">'
       );

     $this->table->set_template($template);
     
     // Table heading row
     
     $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Name', 'Status', 'Action');
     return $this->table->generate();
   }

     // Add/Edit Campaign
     function add_edit_email_template($id = null)
     {
      
        if ($id != null):
         $template = $this->Email_blast_model->get_email_template_by_id($id);
         $data['id'] = $template[0]->id;
         $data['template_name'] = $template[0]->template_name;
         $data['template'] = $campaign[0]->template;
         $data['status'] = $template[0]->status;
       else:
         $data['id'] = "";
         $data['template_name'] = "";
         $data['template'] = "";
        $data['status'] = "";
       endif;
 
       $data['website_id'] = $this->admin_header->website_id();
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
     function insert_update_email_template()
     {
       $id = $this->input->post('id');
       $continue = $this->input->post('btn_continue');
       if (empty($id))
       {
         $this->Email_blast_model->insert_update_email_template();
          $this->session->set_flashdata('success', 'Eamil Teemplate details successfully Created');
         if (isset($continue) && $continue === "Add & Continue")
         {
           $url = 'email_blast/add_edit_email_template';
         }
         else
         {
           $url = 'email_blast/email_template';
         }
       }
       else
       {
         
         $this->Email_blast_model->insert_update_email_template($id);
         $this->session->set_flashdata('success', 'Email Template details Successfully Updated.');
         if (isset($continue) && $continue === "Update & Continue")
         {
           $url = 'email_blast/add_edit_email_template/' . $id;
         }
         else
         {
           $url = 'email_blast/email_template';
         }
       }
       redirect($url);
     }
 
     function delete_template()
     {
       $this->Email_blast_model->delete_template_data();
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
       redirect('email_blast/email_template');
     }
     else
     {
       $this->Email_blast_model->delete_multiple_template_data();
       $this->session->set_flashdata('success', 'Successfully Deleted');
       redirect('email_blast/email_template');
     }
    }

}