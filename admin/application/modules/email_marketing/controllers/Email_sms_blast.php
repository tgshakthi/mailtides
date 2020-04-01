<?php
/**
 * Email SMS Blast
 * Created at : 09-Jan-2020
 * Author : Velusamy
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
	use Twilio\Rest\Client;
	
class Email_sms_blast extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('Email_sms_blast_model');
        //$this->load->module('admin_header');
      //  $this->load->module('color');
       // $this->load->library('csvimport');
       // $this->load->library('email');
		//$this->session_data = $this->session->userdata('logged_in');
    }
	
	function index()
	{	
		$data['page_status'] = 1;
		$data['website_id'] = 1;
		$data['heading'] = 'Patients Import';      
		$data['title'] = "Import Patient Master File | Administrator";
		/**
		* Step 1 : Upload CSV File
		* Step 2 : Field Mapping
		*/
		if (isset($_POST['import-csv-file'])) 
		{
			$config['upload_path']   = './patient-master-file/';
			$config['allowed_types'] = 'csv';
			$config['max_size']      = '1024';
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('users'))
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());        
			} else 
			{
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
			$records = $this->Email_sms_blast_model->get_existing_users();
			foreach ($records as $record) :
			  $existing_users[] = $record->email;
			endforeach;
			// Get CSV File Data
			$file_datas = $this->csvimport->get_array($_POST['file'], "", TRUE);
			foreach (($file_datas ? $file_datas : array()) as $file_data) 
			{
				$values = array_values($file_data);
				$i = 0;
				foreach (array_keys($file_data) as $key) 
				{            
					// Assign CSV col value to Selected Mapping Field
					foreach($_POST as $k => $v) 
					{			
						if ($key == $v) 
						{
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
				$this->Email_sms_blast_model->insert($insert_array);
				$this->session->set_flashdata('success', 'Successfully Imported.');
				redirect('email_sms_blast');
			}
			else 
			{
				$this->session->set_flashdata('error', 'Patients already exists');
				redirect('email_sms_blast');
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
	
	
	//Dynamic Email Template Generate
	function email_template_generate()
	{
		$data['website_id'] = 1;
		$data['table']      = $this->get_dynamic_email_template();
		$data['heading']    = 'Email Template';
		$data['title']      = "Email Template | Administrator";
		//$this->load->view('template/meta_head', $data);
		//$this->load->view('email_blast_header');
		//$this->admin_header->index();
		$this->load->view('email_template_generate', $data);
		//$this->load->view('template/footer_content');
		//$this->load->view('script');
		//$this->load->view('template/footer');
	}
	
	function get_dynamic_email_template()
	{       
		
		$get_template_data = $this->Email_sms_blast_model->get_dynamic_email_template();   
     
		foreach (($get_template_data ? $get_template_data : array()) as $get_template)
		{        
			$anchor_edit = anchor(site_url('email_sms_blast/add_edit_email_template_generate/' . $get_template->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
								 'data-toggle' => 'tooltip',
								 'data-placement' => 'left',
								 'data-original-title' => 'Edit'
							   ));
         
			$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
								 'data-toggle' => 'tooltip',
								 'data-placement' => 'right',
								 'data-original-title' => 'Delete',
								 'onclick' => 'return delete_record(' . $get_template->id . ', \'' . base_url('email_sms_blast/delete_email_template/' . $website_id) . '\')'
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
		$data['id'] = $id;
		//$data['website_id'] = $this->admin_header->website_id();
		$data['get_email_template'] = $this->Email_sms_blast_model->get_email_template_by_id($data['id']);
		$data['heading']    = 'Add Edit Email Template';
		$data['title']      = "Add Edit Email Template | Administrator";
		//$this->load->view('template/meta_head', $data);
		//$this->load->view('email_blast_header');
		//$this->admin_header->index();
		$this->load->view('add_edit_email_template_generate', $data);
		// $this->load->view('template/footer_content');
		//$this->load->view('script');
		//$this->load->view('template/footer');
	}
	function test_email()
	{
		$email_template = $this->input->post('template');
		$id = $this->input->post('id');
		$template_name = $this->input->post('template_name');
		if(!empty($id)){
			$insert_email = $this->Email_sms_blast_model->insert_update_email_templates($id);
		}else{
			$insert_email = $this->Email_sms_blast_model->insert_update_email_templates();	
		}	
	}
	
	function send_test_email()
	{
		$send_mail  = $this->input->post('mail');
		$template  = $this->input->post('template');
		$website_id = $this->admin_header->website_id();
		//$mail_configurations = $this->Email_sms_blast_model->get_mail_configuration($website_id);
		require_once APPPATH.'third_party/PHPMailer/vendor/autoload.php';
		$track_code = md5(rand());
		$mail = new PHPMailer;
		$mail->SMTPDebug = 0;
		// SMTP configuration
		$mail->isSMTP();
		//$mail->Host     = $mail_configurations[0]->host;
		$mail->SMTPAuth = true;
		//$mail->Username = $mail_configurations[0]->email;
		//$mail->Password = $mail_configurations[0]->password;
		//$mail->Port     = $mail_configurations[0]->port;						 							
		$mail->setFrom('info@desss.com','Test');                    
		$mail->Subject= 'Test';
		// Set email format to HTML
		$mail->isHTML(true);
		// Email body content
		$mailContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							<html>
							<head>
								<meta charset="UTF-8">
								<meta content="width=device-width, initial-scale=1" name="viewport">
								<meta name="x-apple-disable-message-reformatting">
								<meta http-equiv="X-UA-Compatible" content="IE=edge">
								<meta content="telephone=no" name="format-detection">
								<title></title>
								<style>
									 #copy{
										 display : none; 
									  }	
									 #save-remove{
										 display : none; 
									  }						 
								</style>
							</head>
							<body>
							<div class="es-wrapper-color">
								'.$template.'
							</div>
						</body>                  
					</html>';
		
		$mail->Body = $mailContent;
		$mail->clearAddresses();
		// Add a recipient		
		$mail->addAddress($send_mail);

		if(!$mail->send()){
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {				
			echo 'Message sent.';
		}
	}
	
	function delete_email_template()
	{
	   $this->Email_sms_blast_model->delete_template_data();
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
		   redirect('email_sms_blast/email_template_generate');
		}
		else
		{
		   $this->Email_sms_blast_model->delete_multiple_template_data();
		   $this->session->set_flashdata('success', 'Successfully Deleted');
		   redirect('email_sms_blast/email_template_generate');
		}
    }
	
	function campaign_import($id)
	{
		$data['id'] = $id;
		$data['website_id'] = $this->admin_header->website_id();
		$data['get_campaign_category'] = $this->Email_sms_blast_model->get_campaign_category_by_id($data['id']);
		if(!empty($data['get_campaign_category'])){
			$heading = $data['get_campaign_category'][0]->category;
			$provider_name = $data['get_campaign_category'][0]->provider_name;
			$facility_name = $data['get_campaign_category'][0]->facility_name;
		}
		$data['table']      = $this->get_table_exixts_users($id, $provider_name, $facility_name);
		$data['heading']    = $heading;
		$data['title']  = "Add Campaign | Administrator";
		//$this->load->view('template/meta_head', $data);
		//$this->load->view('email_blast_header');
		//$this->admin_header->index();
		$this->load->view('import_campaign_data', $data);
		// $this->load->view('template/footer_content');
		//$this->load->view('script');
		//$this->load->view('template/footer');
	}
	
	//Get all patients
	function get_table_exixts_users($id, $provider_name, $facility_name)
	{
		$website_id = $this->admin_header->website_id();
		$get_user_data  = $this->Email_sms_blast_model->get_users_data($provider_name, $facility_name);	
		$get_user_exist_data = $this->Email_sms_blast_model->get_import_send_data($id);
		$heading=array();
		$get_users= $this->Email_sms_blast_model->check_diff_multi($get_user_data,$get_user_exist_data);
		foreach (($get_users ? $get_users : array()) as $get_user) 
		{  
			$get_user_details = $this->Email_sms_blast_model->get_users_by_id($get_user);
			$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
				  'data-toggle' => 'tooltip',
				  'data-placement' => 'right',
				  'data-original-title' => 'Delete',
				  'onclick' => 'return delete_record(' . $get_user_details[0]->id . ', \'' . base_url('email_sms_blast/delete_user/' . $website_id) . '\')'
			  ));
			$cell = array(
				'class' => 'last',
				'data' => $anchor_delete
			  );
			$campaign_name = array();
			$heading_data = array();
			$heading_data = array('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_user_details[0]->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' .$get_user_details[0]->id . '">', $get_user_details[0]->name, $get_user_details[0]->email, $get_user_details[0]->facility_name ,$get_user_details[0]->provider_name, $get_user_details[0]->phone_number, $get_user_details[0]->visited_date);
			$heading_data = array_merge($heading_data,array($cell));
			$this->table->add_row($heading_data);
		}
		$heading = array('<input type="checkbox" id="check-all" class="flat">', 'Name', 'Email', 'Facility Name', 'Provider Name' , 'Phone Number', 'Visited Date','Action');
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
	
	function import_send_email_sms_filter_data()
	{
		$website_id = $this->admin_header->website_id();
		$user_ids_data = $this->input->post('user_id');	
		$campaign_category_id = $this->input->post('campaign_category_id');	
		$campaign_category = $this->Email_sms_blast_model->get_campaign_category_by_id($campaign_category_id);
		$get_mail_template = $this->Email_sms_blast_model->get_email_template_by_id($campaign_category[0]->template);
		$mail_template = $get_mail_template[0]->template;
		
		if(!empty($user_ids))
		{
			$patient_user_count = count($user_ids);
			if($patient_user_count >90){
				$patient_count = '90';
			}else{
				$patient_count = $patient_user_count;
			}
			for($patient_user =0; $patient_user < $patient_count; $patient_user++)
			{	
				$get_user = $this->Email_sms_blast_model->get_users_by_id($user_ids[$patient_user]);
				if(!empty($get_user))
				{
					// Patient Name
					if(!empty($get_user[0]->name)):
						$patient_names = explode(",",$get_user[0]->name);
						$patient_name = $patient_names[1];
						$patient = explode(" ",trim($patient_name));
						$patient_first_name = $patient[0];
					endif;
					
					// Patient Email
					if(!empty($get_user[0]->email)):
						$patient_email = $get_user[0]->email;
					endif;
					// Patient Phone Number
					if(!empty($get_user[0]->phone_number)):
						$phone_numbers = str_replace("-","",$get_user[0]->phone_number);
						$phone_id = "+1";
						$phone_number = $phone_id.''.$phone_numbers;
					endif;
					
					//$mail_configurations = $this->Email_sms_blast_model->get_mail_configuration($website_id);
					require_once APPPATH.'third_party/PHPMailer/vendor/autoload.php';
					$track_code = md5(rand());
					$mail = new PHPMailer;
					$mail->SMTPDebug = 0;
					// SMTP configuration
					$mail->isSMTP();
					//$mail->Host     = $mail_configurations[0]->host;
					$mail->SMTPAuth = true;
					//$mail->Username = $campaign_category[0]->send_email;
					//$mail->Password = $campaign_category[0]->password;
					//$mail->Port     = $mail_configurations[0]->port;						 							
					$mail->setFrom('reviewsdldc@gmail.com', 'Digestive & Liver Disease Consultants , P.A');              
					
					// Set email format to HTML
					$mail->isHTML(true);
					// Email body content
					
					//Replace this Link
					// print_r('http://txgidocs.mailtides.com/admin/email_link_open/sms_email_status/'.$user_ids[$patient_user].'/'.$campaign_category[0]->id.'/'.$track_code.'');
					// print_r($mail_template);die;
					if($campaign_category[0]->campaign_type == 'email'){
						$mail->Subject= 'Digestive & Liver Disease Consultants , P.A';
						$mailContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							<html>
							<head>
								<meta charset="UTF-8">
								<meta content="width=device-width, initial-scale=1" name="viewport">
								<meta name="x-apple-disable-message-reformatting">
								<meta http-equiv="X-UA-Compatible" content="IE=edge">
								<meta content="telephone=no" name="format-detection">
								<title></title>
								<style>
									 #copy{
										 display : none; 
									  }	
									 #save-remove{
										 display : none; 
									  }						 
								</style>
							</head>
							<body>
							<div class="es-wrapper-color">
								'.$mail_template.'
							</div>
						</body>                  
					</html>';																						
					}
					
					$mail->Body = $mailContent;
					$mail->clearAddresses();
					// Add a recipient
					if($campaign_category[0]->campaign_type == 'email'){
						$mail->addAddress($patient_email);
					}
					if(!$mail->send()){
						// echo 'Message could not be sent.';
						// echo 'Mailer Error: ' . $mail->ErrorInfo;
						echo '0';
					} else {
						// echo 'Message sent.';
						echo '1';
					}	
				}			
			}
		}
	}
}