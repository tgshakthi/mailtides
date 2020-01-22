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
        $this->load->module('admin_header');
        $this->load->module('color');
        $this->load->library('csvimport');
        $this->load->library('email');
		$this->session_data = $this->session->userdata('logged_in');
    }
	
	function index()
	{		
		$data['page_status'] = 1;
		$data['website_id'] = $this->admin_header->website_id();
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
	
	//Get patient User
	function get_all_patients()
	{
		$data['admin_user_id'] = $this->session_data['id'];
        $data['website_id'] = $this->admin_header->website_id();
		$data['table']      = $this->get_table_users();
        $data['heading']    = 'Email Sms Blast';
        $data['title']      = "Email Sms Blast | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('patient_users', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
	}
	
	//Get all patients
	function get_table_users()
	{
		$website_id = $this->admin_header->website_id();
		$get_users  = $this->Email_sms_blast_model->get_users();
		$heading=array();
      
		foreach (($get_users ? $get_users : array()) as $get_user) 
		{  
			$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
				  'data-toggle' => 'tooltip',
				  'data-placement' => 'right',
				  'data-original-title' => 'Delete',
				  'onclick' => 'return delete_record(' . $get_user->id . ', \'' . base_url('email_sms_blast/delete_user/' . $website_id) . '\')'
			  ));
			$cell = array(
				'class' => 'last',
				'data' => $anchor_delete
			  );
			$campaign_name = array();
			$heading_data = array();
			$heading_data = array('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_user->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $get_user->id . '">', $get_user->name, $get_user->email, $get_user->facility_name ,$get_user->provider_name, $get_user->phone_number, $get_user->visited_date);
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
	
	//delete
    function delete_user()
    {
        $this->Email_sms_blast_model->delete_user_data();
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
            redirect('email_sms_blast/get_all_patients');
        } else {
            $this->Email_sms_blast_model->delete_multiple_user_data();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('email_sms_blast/get_all_patients');
        }
    }
	
	
	// Campaign
	function campaign()
	{
		$data['website_id'] = $this->admin_header->website_id();
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
	//Email Campaign
	function email_campaign()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['table']      = $this->get_campaign_table();
		$data['heading']    = 'Campaign';
		$data['title']      = "Campaign | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('email_campaign', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	function get_campaign_table()
	{
		$website_id = $this->admin_header->website_id();
        $get_users  = $this->Email_sms_blast_model->get_not_send_email_users();

        $i = 1;
        foreach (($get_users ? $get_users : array()) as $get_user) {
           
            $this->table->add_row($i.' <input type="hidden"  id="email_blast_user" class="hidden-user-id" name="row_sort_order[]" value="' . $get_user->id . '">', $get_user->name, $get_user->email, $get_user->visited_date, $get_user->phone_number, $get_user->provider_name);

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
        
        $this->table->set_heading('S.No', 'Name', 'Email','Visited Date', 'Cell Phone', 'Provider Name');
        return $this->table->generate();
	}
	
	// Import Filter Data
    function import_filter_data()
    {
       $import_campaign_data = $this->Email_sms_blast_model->insert_import_campaign_data();
       echo $import_campaign_data;
    }
	 
	//Send Email
	function send_email_blast_status()
	{
		$website_id = $this->admin_header->website_id();   
		$mail_config = $this->Email_sms_blast_model->get_mail_configuration($website_id );
        
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
	}

	function send_email()
	{
		$website_id = $this->admin_header->website_id();	
		$from_name = $this->input->post('from_name');
		$from_email = $this->input->post('from_email');
		$email_subject = $this->input->post('subject');
		$get_patient_users = $this->Email_sms_blast_model->get_email_patient_users();
		$mail_configurations = $this->Email_sms_blast_model->get_mail_configuration($website_id);
		$patient_user = array(
							array(
								'id' => '4813',
								'name' => 'Chandler,Chandler',
								'email' => 'dev@desss.com',
								'phone_number' => '7135578001',
								'provider_name' => 'DLDC',
								'facility_name' => 'DLDC'          
							),array
							(
								'id' => '4814',
								'name' => 'Chandler,Chandler',
								'email' => 'dev@desss.com',
								'phone_number' => '7135578001',
								'provider_name' => 'REDDY',
								'facility_name' => 'REDDY'          
							),array
							(
								'id' => '4815',
								'name' => 'Chandler,Chandler',
								'email' => 'dev@desss.com',
								'phone_number' => '7135578001',
								'provider_name' => 'HAMAT',
								'facility_name' => 'HAMAT'          
							),array
							(
								'id' => '4816',
								'name' => 'Sheena, Sheena',
								'email' => 'sorn@gimed.net',
								'phone_number' => '2818131292',
								'provider_name' => 'DLDC',
								'facility_name' => 'DLDC'
							),array
							(
								'id' => '4817',
								'name' => 'Sheena, Sheena',
								'email' => 'sorn@gimed.net',
								'phone_number' => '2818131292',
								'provider_name' => 'REDDY',
								'facility_name' => 'REDDY'
							),array
							(
								'id' => '4818',
								'name' => 'Sheena, Sheena',
								'email' => 'sorn@gimed.net',
								'phone_number' => '2818131292',
								'provider_name' => 'HAMAT',
								'facility_name' => 'HAMAT'
							));
		$patient_user_data = array_merge($get_patient_users,$patient_user);	
		
		if(!empty($patient_user_data))
		{
			foreach($patient_user_data as $get_patient_user)
			{
				// User Id
				if(!empty($get_patient_user['id'])):
					$user_id = $get_patient_user['id'];
				endif;
				// Patient Name
				if(!empty($get_patient_user['name'])):
					$patient_names = explode(",",$get_patient_user['name']);
					$patient_name = $patient_names[1];
					$patient = explode(" ",trim($patient_name));
					$patient_first_name = $patient[0];
				endif;
				// Patient Email
				if(!empty($get_patient_user['email'])):
					$patient_email = $get_patient_user['email'];
				endif;
				// Provider Name
				if(!empty($get_patient_user['provider_name'])):
					$provider_name = $get_patient_user['provider_name'];
				endif;
				
				if($provider_name == 'DLDC' || $provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy' || $provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard')
				{
					if (!empty($mail_configurations)) 
					{
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
						$mailContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
																		if($provider_name == 'DLDC'):
																			 $mailContent .= '<tr>
																								<td class="esd-block-text es-p20t" align="left">
																								  <p
																									style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																									    Thanks for being a patient of DLDC! Pls click our link for a quick review!
																								  </pre>
																								</td>
																							  </tr>';
																		elseif($provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy'):
																			$mailContent .= '<tr>
																								<td class="esd-block-text es-p20t" align="left">
																								  <p
																									style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																									   Thanks for being a patient of Dr. Reddy and Laura! Pls click our link for a quick review!
																								  </pre>
																								</td>
																							  </tr>';
																		elseif($provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard') :
																			$mailContent .= '<tr>
																								<td class="esd-block-text es-p20t" align="left">
																								  <p
																									style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																									   Thanks for being a patient of Dr. Hamat! Pls click our link for a quick review!
																								  </pre>
																								</td>
																							  </tr>';
																		
																		endif;
																	 
																	  
																	  $mailContent .= ' <tr>
																	  </tr>
																	  <tr>
																		<td align="center" esd-links-color="#ffffff" class="esd-block-text">
																		<br>
																		<table cellspacing="0" cellpadding="0">
																		<tr>';

																		if($provider_name == 'DLDC'):
																			$tiny_url = 'tinyurl.com/us7z2qv';
																			$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#660033">
																								<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																								Digestive & Liver Disease Consultants, P.A.  Google Reviews
																								</a>
																							 </td>';
																		elseif($provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy'):
																			$tiny_url = 'tinyurl.com/uy6da6c';
																			$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																						  <a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																							Dr. Reddy Google Reviews
																						  </a>
																					   </td>';
																		elseif($provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard') :
																			$tiny_url = 'tinyurl.com/w3epyt6';
																			$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																								<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google-hamat" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																								Dr. Hamat Google Reviews
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
							$this->Email_sms_blast_model->update_email_sent_in_master_table($user_id,$tiny_url);						
							echo 'Message sent.';
						}
						$this->session->set_flashdata('success', 'Mail sent Successfully.');              
					}
				}
			}
		}
		redirect('email_sms_blast');
	}
	
	function email_tracking()
	{
		$data['website_id'] = $this->admin_header->website_id();
        $data['email_tracks'] = $this->Email_sms_blast_model->get_email_track_data();
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
	
	function sms_campaign()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['table']      = $this->get_sms_campaign_table();
		$data['heading']    = 'Campaign';
		$data['title']      = "Campaign | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('sms_campaign', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	function send_sms_blast()
	{
		$website_id = $this->admin_header->website_id();   
		$mail_config = $this->Email_sms_blast_model->get_mail_configuration($website_id );
        
		if(!empty($mail_config)):
			$data['email'] = $mail_config[0]->mail_from;
		else:
			$data['email']='';
		endif;       
        
		$data['website_id'] = $this->admin_header->website_id();
		$data['title'] = 'Send SMS' . ' | Administrator';
		$data['heading'] = 'SMS ';
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('send_sms_blast', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	function get_sms_campaign_table()
	{
		$website_id = $this->admin_header->website_id();
        $get_users  = $this->Email_sms_blast_model->get_not_send_sms_users();

        $i = 1;
        foreach (($get_users ? $get_users : array()) as $get_user) {
           
            $this->table->add_row($i.' <input type="hidden"  id="email_blast_user" class="hidden-user-id" name="row_sort_order[]" value="' . $get_user->id . '">', $get_user->name, $get_user->email, $get_user->visited_date, $get_user->phone_number, $get_user->provider_name);

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
        
        $this->table->set_heading('S.No', 'Name', 'Email','Visited Date', 'Cell Phone', 'Provider Name');
        return $this->table->generate();
	}
	
	// Import Filter Data
    function import_filter_sms_data()
    {
       $import_campaign_data = $this->Email_sms_blast_model->insert_import_sms_campaign_data();
       echo $import_campaign_data;
    }
	
	// Send Sms
	
	function send_sms()
	{
		$website_id = $this->admin_header->website_id();	
		$from_name = $this->input->post('from_name');
		$from_email = $this->input->post('from_email');
		
		$get_sms_patient_users = $this->Email_sms_blast_model->get_sms_patient_users();
		$mail_config = $this->Email_sms_blast_model->get_mail_configuration($website_id );
		$patient_user = array(
							array(
								'id' => '4813',
								'name' => 'Chandler,Chandler',
								'email' => 'dev@desss.com',
								'phone_number' => '7135578001',
								'provider_name' => 'DLDC',
								'facility_name' => 'DLDC'          
							),array
							(
								'id' => '4814',
								'name' => 'Chandler,Chandler',
								'email' => 'dev@desss.com',
								'phone_number' => '7135578001',
								'provider_name' => 'REDDY',
								'facility_name' => 'REDDY'          
							),array
							(
								'id' => '4815',
								'name' => 'Chandler,Chandler',
								'email' => 'dev@desss.com',
								'phone_number' => '7135578001',
								'provider_name' => 'HAMAT',
								'facility_name' => 'HAMAT'          
							),array
							(
								'id' => '4816',
								'name' => 'Sheena, Sheena',
								'email' => 'sorn@gimed.net',
								'phone_number' => '2818131292',
								'provider_name' => 'DLDC',
								'facility_name' => 'DLDC'
							),array
							(
								'id' => '4817',
								'name' => 'Sheena, Sheena',
								'email' => 'sorn@gimed.net',
								'phone_number' => '2818131292',
								'provider_name' => 'REDDY',
								'facility_name' => 'REDDY'
							),array
							(
								'id' => '4818',
								'name' => 'Sheena, Sheena',
								'email' => 'sorn@gimed.net',
								'phone_number' => '2818131292',
								'provider_name' => 'HAMAT',
								'facility_name' => 'HAMAT'
							));	
		$patient_user_data = array_merge($get_sms_patient_users,$patient_user);
		if(!empty($patient_user_data))
		{
			$sms_address = '';
			foreach($patient_user_data as $get_sms_patient_user)
			{				
				if(!empty($get_sms_patient_user['phone_number']))
				{
					$phone_numbers = str_replace("-","",$get_sms_patient_user['phone_number']);
					$phone_id = "+1";
					$phone_number = $phone_id.''.$phone_numbers;					
				
					// User Id
					if(!empty($get_sms_patient_user['id'])):
						$user_id = $get_sms_patient_user['id'];
					endif;
					// Patient Name
					if(!empty($get_sms_patient_user['name'])):
						$patient_names = explode(",",$get_sms_patient_user['name']);
						$patient_name = $patient_names[1];
						$patient = explode(" ",trim($patient_name));
						$patient_first_name = $patient[0];
					endif;
					// Patient Email
					if(!empty($get_sms_patient_user['email'])):
						$patient_email = $get_sms_patient_user['email'];
					endif;
					// Provider Name
					if(!empty($get_sms_patient_user['provider_name'])):
						$provider_name = $get_sms_patient_user['provider_name'];
					endif;
					
					$sms_data247_datas = $this->Email_sms_blast_model->get_sms_data247_data($get_sms_patient_user['phone_number']);
					
					if(!empty($sms_data247_datas))
					{
						$sms_address = $sms_data247_datas[0]['sms_data_email'];						
					}else
					{
						// Replace key value with your own api key					
						$url = 'https://api.data247.com/v3.0?key=262385da4166dc1dc5&api=MT&phone='.$phone_number.'';
						$result = @file_get_contents($url);						
						if ($result)
						{
							$result = @json_decode($result, true);
							if (!empty($result['response']['status']) && $result['response']['status'] == 'OK')
							{	
								$sms_address = $result['response']['results'][0]['sms_address'];
							}
						}
					}
					if(!empty($sms_address) && $provider_name == 'DLDC' || $provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy' || $provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard')
					{
						$email_subject = "";
						$track_code = md5(rand());					
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
						$mail->IsHTML(true);
												
						if($provider_name == 'DLDC' || $provider_name == 'dldc'):
							$tiny_url = 'https://tinyurl.com/vj4mjvg';
							$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_status/'.$user_id.'/DLDC';
							$ch = curl_init();  
							$timeout = '5';  
							curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
							curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
							curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
							$data = curl_exec($ch);
							//Others DLDC
							$mail->Body = "".$patient_first_name.", Thanks for being a patient of DLDC!  Pls click our link for a quick review! ".$data."";
						
						elseif($provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy'):	
							$tiny_url = 'https://tinyurl.com/uy6da6c';
							$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_status/'.$user_id.'/Reddy';
							$ch = curl_init();  
							$timeout = '5';  
							curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
							curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
							curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
							$data = curl_exec($ch);	
							//Dr.Reddy
							$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Reddy and Laura!  Pls click our link for a quick review! ".$data."";
						
						elseif($provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard'):						
							$tiny_url = 'https://tinyurl.com/sw9d3g9';
							$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_status/'.$user_id.'/HAMAT';
							$ch = curl_init();  
							$timeout = '5';  
							curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
							curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
							curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
							$data = curl_exec($ch);					
							// Dr.Hamat
							$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Hamat!  Pls click our link for a quick review! ".$data."";
						
						endif;
						
						$mail->AddAddress($sms_address);						
						$mail->addBCC('velusamy@desss.com');	
										
						if(!$mail->Send())
						{
						  echo "Mailer Error: " . $mail->ErrorInfo;
						}
						else
						{
							if(empty($sms_data247_datas))
							{
								$this->Email_sms_blast_model->insert_sms_data($user_id,$patient_first_name,$patient_email,$get_sms_patient_user['phone_number'],$sms_address);
							}
							$this->Email_sms_blast_model->update_sms_sent_in_master_table($user_id, $tiny_url);
							echo "Message sent!";
						}
					}
				}
			}
		}	
		redirect('email_sms_blast');
	}
	
	function sms_tracking()
	{
		$data['website_id'] = $this->admin_header->website_id();
        $data['sms_tracks'] = $this->Email_sms_blast_model->get_sms_track_data();
		
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
	
	//Single Patient Insert 
	function new_patient()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['heading']    = 'Add New Patient';
		$data['title']      = "Add New Patient | Administrator";
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
			$patient_phone_numbers = $this->Email_sms_blast_model->check_patient_phone_number();	
			// $patient_phone_numbers = $this->Email_sms_blast_model->check_patient_phone_number_sms_data($phone_number);		
			// Replace key value with your own api key					
			
			if(!empty($patient_phone_numbers))
			{	
					$patient_name = $patient_phone_numbers[0]->name;
					$patient_names = explode(',',$patient_name);
					$data['last_name'] = $patient_names[0];
					$data['first_name'] = trim($patient_names[1]);
								
					$data['patient_email'] = $patient_phone_numbers[0]->email;
					
					$patient_carrires = $this->Email_sms_blast_model->get_carrier_247data($phone_number);
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
		$provider_name  = $this->input->post('provider_name');
		
		$get_patient_users = $this->Email_sms_blast_model->check_patient_phone_number();
		$get_new_patient_users = $this->Email_sms_blast_model->check_new_patient_phone_number($phone_number);
		if(empty($get_patient_users)){
			$new_patients = $this->Email_sms_blast_model->insert_new_patients_master_table();
		}
		if(empty($get_new_patient_users)){
			$new_patient_user = $this->Email_sms_blast_model->insert_new_patients();
		}

		if(!empty($first_name)):
			$patient = explode(" ",trim($first_name));
			$patient_first_name = $patient[0];
		endif;
  
		if(!empty($sms_address)):
			$mail_config = $this->Email_sms_blast_model->get_mail_configuration($website_id );
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
			
			$mail->IsHTML(true);

			if($provider_name == 'dldc'):							 
				//Others DLDC
				$tiny_url = 'tinyurl.com/vj4mjvg';
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of DLDC!  Pls click our link for a quick review! ".$tiny_url."";
				// $mail->Body    = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/yy98b7u3';
				// $mail->Body = 'Test Content DLDC';
			elseif($provider_name == 'reddy'):
				// Dr.Reddy
				$tiny_url = 'tinyurl.com/uy6da6c';
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Reddy and Laura! Pls click our link for a quick review! ".$tiny_url."";
				// $mail->Body   = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y2g3w5du';
			elseif($provider_name == 'hamat'):
				// Dr.Hamat
				$tiny_url = 'tinyurl.com/sw9d3g9';
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Hamat!  Pls click our link for a quick review! ".$tiny_url."";
				// $mail->Body  = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y2g3w5du';
			
			endif;
			
			$mail->AddAddress($sms_address);
			$mail->addBCC('velusamy@desss.com');						
			
			if(!$mail->Send())
			{	
			    echo "Mailer Error: " . $mail->ErrorInfo;
				echo "<script type='text/javascript'>alert('Message not sent!');window.location='email_sms_blast/new_patient';</script>";
			}
			else
			{
				$patient_carrires = $this->Email_sms_blast_model->get_carrier_247data($phone_number);
				if(empty($patient_carrires)):
					$this->Email_sms_blast_model->insert_sms_data($patient_first_name,$patient_email,$phone_number,$sms_address);					
				endif;
				echo "<script type='text/javascript'> alert('Message sent!');window.location='email_sms_blast/new_patient';</script>";
			}
		endif; 
		// redirect('email_blasts/new_patient');
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
	   $campaign_categorys = $this->Email_sms_blast_model->get_campaign_category($website_id);
	    if (!empty($campaign_categorys)) {
            foreach ($campaign_categorys as $campaign_category) {
                $anchor_edit = anchor(site_url('email_sms_blast/add_edit_campaign_category/' . $campaign_category->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left',
                    'data-original-title' => 'Edit'
                ));
                
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $campaign_category->id . ', \'' . base_url('email_sms_blast/delete_campaign_category') . '\')'
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
			$campaign_category = $this->Email_sms_blast_model->get_campaign_category_by_id($id);
			$data['campaign_category_id'] = $campaign_category[0]->id;
			$data['category'] = $campaign_category[0]->category;
			$data['web_url'] = $campaign_category[0]->web_url;
			$data['tiny_url'] = $campaign_category[0]->tiny_url;
			$data['status'] = $campaign_category[0]->status;
			$data['sort_order'] = $campaign_category[0]->sort_order;
		else:
			$data['campaign_category_id'] = "";
			$data['category'] = "";
			$data['web_url'] = "";
			$data['tiny_url'] = "";
			$data['status'] = "";
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
			$this->Email_sms_blast_model->insert_update_campaign_category();
			$this->session->set_flashdata('success', 'Campaign Category details successfully Created');
			if (isset($continue) && $continue === "Add & Continue")
			{
			   $url = 'email_sms_blast/add_edit_campaign_category';
			}
			else
			{
			   $url = 'email_sms_blast/campaign_category';
			}
		}
		else
		{
         
			$this->Email_sms_blast_model->insert_update_campaign_category($campaign_category_id);
			$this->session->set_flashdata('success', 'Campaign Category details successfully Created.');
			if (isset($continue) && $continue === "Update & Continue")
			{
				$url = 'email_sms_blast/add_edit_campaign_category/'.$campaign_category_id;
			}
			else
			{
				$url = 'email_sms_blast/campaign_category';
			}
		}
		redirect($url);
	}
	
	//delete
    function delete_campaign_category()
    {
        $this->Email_sms_blast_model->delete_campaign_category();
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
            redirect('email_sms_blast/campaign_category');
        } else {
            $this->Email_sms_blast_model->delete_multiple_campaign_category();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('email_sms_blast/campaign_category');
        }
    }
	
	// Graphical Reports
    function graphical_reports()
    {     
       $data['website_id'] = $this->admin_header->website_id();
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
	
	function graphical_campaign_id()
	{
		$provider_name = $this->input->post('provider_name');
		$campaign_type = $this->input->post('campaign_type');
		$get_users = $this->Email_sms_blast_model->get_provider_name_by_user($provider_name);
		
		foreach($get_users as $get_user){				
			if($campaign_type == 'email'):
				if($get_user->email_sent == '1'){
					$email_sent = $get_user->email_sent;
				}
				
				if($get_user->email_link_open == '1'){
					$link[] = $get_user->email_link_open;
				}
				
				if(!empty($get_users)){
					$sent = count($get_users);
				}
				
				$email_link_open = $get_user->email_link_open;
			elseif($campaign_type == 'sms'):
				
				if($get_user->sms_link_open == '1'){
					$link[] = $get_user->sms_link_open;
				}
				if(!empty($get_users)){
					$sent = count($get_users);
				}
			endif;
		}
		$data['link_open'] = count($link); 
		$data['sent'] = $sent; 
		$data['type'] = $campaign_type;
		echo json_encode($data);
	}
	
	//Resend SMS 
	function resend_sms($user_id)
	{
		$get_user = $this->Email_sms_blast_model->get_users_by_id($user_id);
		if(!empty($get_user))
		{
			$phone_numbers = str_replace("-","",$get_user[0]->phone_number);
			$phone_id = "+1";
			$phone_number = $phone_id.''.$phone_numbers;					
		
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
			
			// Provider Name
			if(!empty($get_user[0]->provider_name)):
				$provider_name = $get_user[0]->provider_name;
			endif;	
			
			$get_check_sms_data = $this->Email_sms_blast_model->get_sms_data247_data($get_user[0]->phone_number);
			if(!empty($get_check_sms_data))
			{
				$sms_data_email = $get_check_sms_data[0]['sms_data_email'];						
			}else
			{
				// Replace key value with your own api key					
				$url = 'https://api.data247.com/v3.0?key=262385da4166dc1dc5&api=MT&phone='.$phone_number.'';
				$result = @file_get_contents($url);						
				if ($result)
				{
					$result = @json_decode($result, true);
					if (!empty($result['response']['status']) && $result['response']['status'] == 'OK')
					{	
						$sms_data_email = $result['response']['results'][0]['sms_address'];
					}
				}
			}
			
			if(!empty($sms_data_email))
			{
				$website_id = $this->admin_header->website_id();
				$mail_config = $this->Email_sms_blast_model->get_mail_configuration($website_id );
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
				
				$mail->IsHTML(true);

				if($provider_name == 'DLDC' || $provider_name == 'dldc'):
					$tiny_url = 'https://tinyurl.com/vj4mjvg';
					$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_status/'.$user_id.'/DLDC';
					$ch = curl_init();  
					$timeout = '5';  
					curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
					curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
					$data = curl_exec($ch);
					//Others DLDC
					$mail->Body = "".$patient_first_name.", Thanks for being a patient of DLDC!  Pls click our link for a quick review! ".$data."";
				
				elseif($provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy'):	
					$tiny_url = 'https://tinyurl.com/uy6da6c';
					$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_status/'.$user_id.'/Reddy';
					$ch = curl_init();  
					$timeout = '5';  
					curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
					curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
					$data = curl_exec($ch);	
					//Dr.Reddy
					$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Reddy and Laura!  Pls click our link for a quick review! ".$data."";
				
				elseif($provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard'):						
					$tiny_url = 'https://tinyurl.com/sw9d3g9';
					$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_status/'.$user_id.'/HAMAT';
					$ch = curl_init();  
					$timeout = '5';  
					curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
					curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
					$data = curl_exec($ch);					
					// Dr.Hamat
					$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Hamat!  Pls click our link for a quick review! ".$data."";
			
				endif;
				
				$mail->AddAddress($sms_data_email);
				$mail->addBCC('velusamy@desss.com');
				
				if(!$mail->Send())
				{	
					echo "Mailer Error: " . $mail->ErrorInfo;
					echo "<script type='text/javascript'>alert('Message not sent!');location.replace('".base_url()."email_sms_blast/sms_tracking');</script>";
				}
				else
				{
					$this->Email_sms_blast_model->insert_master_resend_table_sms_data($user_id,$tiny_url);					
					echo "<script type='text/javascript'> alert('Message sent!');location.replace('".base_url()."email_sms_blast/sms_tracking');</script>";
				}
			}
		}
	}
	
	//Resend Email 
	function resend_email($user_id)
	{
		$website_id = $this->admin_header->website_id();
		$mail_configurations = $this->Email_sms_blast_model->get_mail_configuration($website_id);
		$get_user = $this->Email_sms_blast_model->get_users_by_id($user_id);
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
			
			// Provider Name
			if(!empty($get_user[0]->provider_name)):
				$provider_name = $get_user[0]->provider_name;
			endif;
			if($provider_name == 'DLDC' || $provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy' || $provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard')
			{
				if (!empty($mail_configurations)) 
				{
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
					$mail->From = $mail_configurations[0]->mail_from;
					$mail->FromName = 'Digestive & Liver Disease Consultants , P.A';
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
																	if($provider_name == 'DLDC' || $provider_name == 'dldc'):
																		 $mailContent .= '<tr>
																							<td class="esd-block-text es-p20t" align="left">
																							  <p
																								style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																									Thanks for being a patient of DLDC! Pls click our link for a quick review!
																							  </pre>
																							</td>
																						  </tr>';
																	elseif($provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy'):
																		$mailContent .= '<tr>
																							<td class="esd-block-text es-p20t" align="left">
																							  <p
																								style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																								   Thanks for being a patient of Dr. Reddy and Laura! Pls click our link for a quick review!
																							  </pre>
																							</td>
																						  </tr>';
																	elseif($provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard') :
																		$mailContent .= '<tr>
																							<td class="esd-block-text es-p20t" align="left">
																							  <p
																								style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																								   Thanks for being a patient of Dr. Hamat! Pls click our link for a quick review!
																							  </pre>
																							</td>
																						  </tr>';
																	
																	endif;
																 
																  
																  $mailContent .= ' <tr>
																  </tr>
																  <tr>
																	<td align="center" esd-links-color="#ffffff" class="esd-block-text">
																	<br>
																	<table cellspacing="0" cellpadding="0">
																	<tr>';

																	if($provider_name == 'DLDC' || $provider_name == 'dldc'):
																		$tiny_url = 'tinyurl.com/us7z2qv';
																		$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#660033">
																							<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																							Digestive & Liver Disease Consultants, P.A.  Google Reviews
																							</a>
																						 </td>';
																	elseif($provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy'):
																		$tiny_url = 'tinyurl.com/uy6da6c';
																		$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																					  <a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																						Dr. Reddy Google Reviews
																					  </a>
																				   </td>';
																	elseif($provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard') :
																		$tiny_url = 'tinyurl.com/w3epyt6';
																		$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#DB4437">
																							<a href="http://txgidocs.mailtides.com/admin/email_link_open?review_user_id='.$user_id.'&type=google-hamat" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																							Dr. Hamat Google Reviews
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
						$this->Email_sms_blast_model->update_email_resend_in_master_table($user_id,$tiny_url);						
						echo 'Message sent.';
					}
					$this->session->set_flashdata('success', 'Mail sent Successfully.');              
				}
			}
		}
		
	}
}