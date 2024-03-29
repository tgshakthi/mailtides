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
		// print_r($get_users);die;
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
			  id="datatable-button-data"
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
		
        $this->form_validation->set_rules('product_records[]', 'Row', 'required', array(
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
	// Reports
	function reports()
	{
		$data['website_id'] = $this->admin_header->website_id();        
        $data['heading']    = 'Reports';
        $data['title']      = "Reports | Administrator";
		$data['campaign_datas'] = $this->Email_sms_blast_model->get_campaign_category($data['website_id']);
        $this->load->view('template/meta_head', $data);
        $this->load->view('email_blast_header');
        $this->admin_header->index();
        $this->load->view('reports', $data);
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
		
		if(!empty($first_name)):
			$patient = explode(" ",trim($first_name));
			$patient_first_name = $patient[0];
		endif;
  
		if(!empty($sms_address)):
			$mail_config = $this->Email_sms_blast_model->get_mail_configuration($website_id );
			
			require_once "application/third_party/PHPMailer/vendor/autoload.php"; //PHPMailer Object			
			require_once 'application/third_party/PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
			require_once 'application/third_party/PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
			require_once 'application/third_party/PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';
				
			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;
			$mail->CharSet = "UTF-8";
			$mail->SMTPSecure = 'tls';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = '587';				
			$mail->Encoding = '7bit';
			$mail->SMTPAuth = true;			
			$mail->Username = 'reviewsdldc@gmail.com';	
			$mail->Password = 'Houston77090';		
			$mail->setFrom('reviewsdldc@gmail.com', 'Digestive & Liver Disease Consultants , P.A');
			$mail->AddAddress($sms_address);
			$mail->addBCC('velusamy@desss.com'); 
			$mail->IsHTML(true);
			$mail->Subject = "";
			if($provider_name == 'dldc'):							 
				//Others DLDC
				$tiny_url = 'tinyurl.com/vj4mjvg';
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of DLDC!  Pls click our link for a quick review! tinyurl.com/vj4mjvg";
				// $mail->Body    = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/yy98b7u3';
			
			elseif($provider_name == 'reddy'):
				// Dr.Reddy
				$tiny_url = 'tinyurl.com/uy6da6c';
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Reddy and Laura!  Pls click our link for a quick review! tinyurl.com/uy6da6c";
				// $mail->Body   = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y2g3w5du';
			elseif($provider_name == 'hamat'):
				// Dr.Hamat
				$tiny_url = 'tinyurl.com/sw9d3g9';
				$mail->Body = "".$patient_first_name.", Thanks for being a patient of Dr. Hamat!  Pls click our link for a quick review! tinyurl.com/sw9d3g9";
				// $mail->Body  = ''.$patient_first_name.', Thanks for visiting DLDC. We value your opinion & look forward to serving you. Click the link to leave a review https://tinyurl.com/y2g3w5du';			
			endif;
			
					
			if(!$mail->Send())
			{	
			    // echo "Mailer Error: " . $mail->ErrorInfo;
				echo "<script type='text/javascript'>alert('Message not sent!');window.location='email_sms_blast/new_patient';</script>";
			}
			else
			{
				$patient_carrires = $this->Email_sms_blast_model->get_carrier_247data($phone_number);
				if(empty($patient_carrires)):
					$this->Email_sms_blast_model->insert_sms_data('',$patient_first_name,$patient_email,$phone_number,$sms_address);					
				endif;
				$get_patient_users = $this->Email_sms_blast_model->check_patient_phone_number();
				$get_new_patient_users = $this->Email_sms_blast_model->check_new_patient_phone_number($phone_number);
				if(empty($get_patient_users)){
					$new_patients = $this->Email_sms_blast_model->insert_new_patients_master_table($tiny_url);
				}
				if(empty($get_new_patient_users)){
					$new_patient_user = $this->Email_sms_blast_model->insert_new_patients();
				}
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
			$data['campaign_location'] = $campaign_category[0]->campaign_location;
			$data['category'] = $campaign_category[0]->category;
			$data['web_url'] = $campaign_category[0]->web_url;
			$data['tiny_url'] = $campaign_category[0]->tiny_url;
			$data['mail_content'] = $campaign_category[0]->mail_content;
			$data['campaign_type'] = $campaign_category[0]->campaign_type;
			$data['email'] = $campaign_category[0]->send_email;
			$data['password'] = $campaign_category[0]->password;
			$data['email_template'] = $campaign_category[0]->template;
			$data['provider_name'] = $campaign_category[0]->provider_name;
			$data['facility_name'] = $campaign_category[0]->facility_name;
			$data['selected_template'] = $campaign_category[0]->template;
			$data['status'] = $campaign_category[0]->status;
			$data['sort_order'] = $campaign_category[0]->sort_order;
		else:
			$data['campaign_category_id'] = "";
			$data['campaign_location'] = "";
			$data['category'] = "";
			$data['web_url'] = "";
			$data['tiny_url'] = "";
			$data['mail_content'] = "";
			$data['campaign_type'] =  "";
			$data['email'] = "";
			$data['password'] = "";
			$data['email_template'] =  "";
			$data['provider_name'] = "";
			$data['facility_name'] = "";
			$data['selected_template'] = "";
			$data['status'] = "";
			$data['sort_order'] = "";
		endif;
		
		$data['admin_user_id'] = $this->session_data['id'];
        $data['website_id'] = $this->admin_header->website_id();
        $data['templates'] = $this->Email_sms_blast_model->get_dynamic_email_template();
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
		$campaign_id = $this->input->post('campaign_category_id');
		$get_users = $this->Email_sms_blast_model->get_import_send_user_data($campaign_id);
		if(!empty($get_users)){
			foreach($get_users as $get_user)		
			{
				if(!empty($get_users)){
					$sent = count($get_users);
				}
				if($get_user->link_open == '1'){
					$link[] = $get_user->link_open;
				}			
			}
			$data['link_open'] = count($link); 
			$data['sent'] = $sent; 
			echo json_encode($data);
		}else{
			$data['link_open'] = ''; 
			$data['sent'] = '';
			echo json_encode($data);
		}
	}

	function campaign_data()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['heading']    = 'Campaign';
		$data['title']      = "Campaign | Administrator";
		$data['campaign_datas'] = $this->Email_sms_blast_model->get_campaign_category($data['website_id']);
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('campaign_data', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
	    $this->load->view('template/footer');
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
		$data['website_id'] = $this->admin_header->website_id();
		$data['get_email_template'] = $this->Email_sms_blast_model->get_email_template_by_id($data['id']);
		$data['heading']    = 'Add Edit Email Template';
		$data['title']      = "Add Edit Email Template | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('add_edit_email_template_generate', $data);
		// $this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
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
		$mail_configurations = $this->Email_sms_blast_model->get_mail_configuration($website_id);
		require_once APPPATH.'third_party/PHPMailer/vendor/autoload.php';
		$track_code = md5(rand());
		$mail = new PHPMailer;
		$mail->SMTPDebug = 0;
		// SMTP configuration
		$mail->isSMTP();
		$mail->Host     = $mail_configurations[0]->host;
		$mail->SMTPAuth = true;
		$mail->Username = $mail_configurations[0]->email;
		$mail->Password = $mail_configurations[0]->password;
		$mail->Port     = $mail_configurations[0]->port;						 							
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
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('import_campaign_data', $data);
		// $this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
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
		
		$data = array(
					'0'=>'4813'
				);
		/* $user_data_bcc = array(
					'0' => '4816'
		); */
		$user_ids = array_merge($user_ids_data,$data);
		// $user_ids = array_merge($user_id,$user_data_bcc);
		
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
					
					$mail_configurations = $this->Email_sms_blast_model->get_mail_configuration($website_id);
					require_once APPPATH.'third_party/PHPMailer/vendor/autoload.php';
					$track_code = md5(rand());
					$mail = new PHPMailer;
					$mail->SMTPDebug = 0;
					// SMTP configuration
					$mail->isSMTP();
					$mail->Host     = $mail_configurations[0]->host;
					$mail->SMTPAuth = true;
					$mail->Username = $campaign_category[0]->send_email;
					$mail->Password = $campaign_category[0]->password;
					$mail->Port     = $mail_configurations[0]->port;						 							
					$mail->setFrom('reviewsdldc@gmail.com', 'Digestive & Liver Disease Consultants , P.A');              
					
					// Set email format to HTML
					$mail->isHTML(true);
					// Email body content
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
																	
																$mailContent .= '<tr>
																					<td class="esd-block-text es-p20t" align="left">
																					  <p
																						style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																							'.$campaign_category[0]->mail_content.'
																					  </pre>
																					</td>
																				  </tr>';
																$mailContent .= ' <tr>
																					  </tr>
																					  <tr>
																						<td align="center" esd-links-color="#ffffff" class="esd-block-text">
																						<br>
																						<table cellspacing="0" cellpadding="0">
																						<tr>';								
																$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#660033">
																					<a href="http://txgidocs.mailtides.com/admin/email_link_open/sms_email_status/'.$user_ids[$patient_user].'/'.$campaign_category[0]->id.'/'.$track_code.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																					'.$campaign_category[0]->category.'
																					</a>
																				 </td>';
																	
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
					}elseif($campaign_category[0]->campaign_type == 'sms'){
						$mail->Subject= '';
						$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_email_status/'.$user_ids[$patient_user].'/'.$campaign_category[0]->id.'/'.$track_code.'';
						$ch = curl_init();  
						$timeout = '5';  
						curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
						curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
						curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
						$data = curl_exec($ch);
						$mailContent = 'Dear '.$patient_first_name.','.$campaign_category[0]->mail_content .' '. $data;
					}
					
					$mail->Body = $mailContent;
					$mail->clearAddresses();
					// Add a recipient
					if($campaign_category[0]->campaign_type == 'email'){
						$mail->addAddress($patient_email);
						$mail->addBCC('velusamy@desss.com');
					}elseif($campaign_category[0]->campaign_type == 'sms'){
						$mail->addAddress($sms_data_email);
						$mail->addBCC('velusamy@desss.com');
					}						
					if(!$mail->send()){
						// echo 'Message could not be sent.';
						// echo 'Mailer Error: ' . $mail->ErrorInfo;
						echo '0';
					} else {
						if(empty($get_check_sms_data))
						{
							$this->Email_sms_blast_model->insert_sms_data($user_ids[$patient_user],$patient_first_name,$patient_email,$get_user[0]->phone_number,$sms_data_email);
						}					
						$this->Email_sms_blast_model->insert_send_email_sms_filter_data($user_ids[$patient_user],$campaign_category[0]->id,$track_code);
						// echo 'Message sent.';
						echo '1';
					}	
				}			
			}
		}
	}
	
	function campaign_report_import($id)
	{
		$data['id'] = $id;
		$data['website_id'] = $this->admin_header->website_id();
		
		$data['get_campaign_category'] = $this->Email_sms_blast_model->get_campaign_category_by_id($data['id']);
		if(!empty($data['get_campaign_category'])){
			$heading = $data['get_campaign_category'][0]->category;
			$provider_name = $data['get_campaign_category'][0]->provider_name;
			$facility_name = $data['get_campaign_category'][0]->facility_name;
		}
		$data['table']  = $this->get_import_send_data_users_id($id,$provider_name,$facility_name);
		$data['heading']  = $heading;
		$data['title']  = "Add Campaign | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('import_campaign_user_data', $data);
		// $this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	function get_import_send_data_users_id($id,$provider_name,$facility_name)
	{
		$website_id = $this->admin_header->website_id();
		$get_user_id = $this->Email_sms_blast_model->get_import_send_user_datass($id,$provider_name,$facility_name);
		foreach (($get_user_id ? $get_user_id : array()) as $get_user) 
		{  
			$get_user_details = $this->Email_sms_blast_model->get_users_by_id($get_user->user_id);
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
			if ($get_user->link_open === '1') {
				$link_open_status = '<span class="label label-success">Open</span>';
				$resend_sms = '<span class="label label-danger"></span>';
			} else {
				$link_open_status = '<span class="label label-danger">Not Open</span>';
				$resend_sms = '<span class="label label-success"><a href="'.base_url().'email_sms_blast/resend_email_sms_user_data/'.$get_user->user_id.'/'.$get_user->campaign_category_id.'/'.$get_user->track_code.'">Resend</a></span>';
			}
			$campaign_name = array();
			$heading_data = array();
			$heading_data = array('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $get_user_details[0]->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' .$get_user_details[0]->id . '">', $get_user_details[0]->name, $get_user_details[0]->email,$get_user_details[0]->phone_number,$get_user->sent_date);
			$heading_data = array_merge($heading_data,array($link_open_status));
			$heading_data = array_merge($heading_data,array($get_user->open_date));
			$heading_data = array_merge($heading_data,array($resend_sms));
			$this->table->add_row($heading_data);
		}
		$heading = array('<input type="checkbox" id="check-all" class="flat">', 'Name', 'Email','Phone Number','Sent Date','Link Open','Open Date','Resend');
		$template = array(
			  'table_open' => '<table
			  id="datatable-buttons-import-data"
			  class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			  width="100%" cellspacing="0">'
		  );
		$this->table->set_template($template);
      
		// Table heading row
		$this->table->set_heading($heading);
		return $this->table->generate();
	}
	
	function resend_email_sms_user_data($user_id,$campaign_category_id,$track_code)
	{
		$website_id = $this->admin_header->website_id();
		$campaign_category = $this->Email_sms_blast_model->get_campaign_category_by_id($campaign_category_id);		
		if(!empty($user_id))
		{				
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
				// Patient Phone Number
				if(!empty($get_user[0]->phone_number)):
					$phone_numbers = str_replace("-","",$get_user[0]->phone_number);
					$phone_id = "+1";
					$phone_number = $phone_id.''.$phone_numbers;
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
				$mail_configurations = $this->Email_sms_blast_model->get_mail_configuration($website_id);
				require_once APPPATH.'third_party/PHPMailer/vendor/autoload.php';
				$mail = new PHPMailer;
				$mail->SMTPDebug = 0;
				// SMTP configuration
				$mail->isSMTP();
				$mail->Host     = $mail_configurations[0]->host;
				$mail->SMTPAuth = true;
				$mail->Username = $mail_configurations[0]->email;
				$mail->Password = $mail_configurations[0]->password;
				$mail->Port     = $mail_configurations[0]->port;						 								            				
				// Set email format to HTML
				$mail->isHTML(true);
				// Email body content
				if($campaign_category[0]->campaign_type == 'email'){
					$mail->setFrom('reviewsdldc@gmail.com', 'Digestive & Liver Disease Consultants , P.A');  
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
																
															$mailContent .= '<tr>
																				<td class="esd-block-text es-p20t" align="left">
																				  <p
																					style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																						'.$campaign_category[0]->mail_content.'
																				  </pre>
																				</td>
																			  </tr>';
															$mailContent .= ' <tr>
																				  </tr>
																				  <tr>
																					<td align="center" esd-links-color="#ffffff" class="esd-block-text">
																					<br>
																					<table cellspacing="0" cellpadding="0">
																					<tr>';								
															$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#660033">
																				<a href="http://txgidocs.mailtides.com/admin/email_link_open/sms_email_status/'.$user_id.'/'.$campaign_category_id.'/'.$track_code.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																				'.$campaign_category[0]->category.'
																				</a>
																			 </td>';
																
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
				}elseif($campaign_category[0]->campaign_type == 'sms'){
					$mail->Subject= '';
					$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_email_status/'.$user_id.'/'.$campaign_category_id.'/'.$track_code.'';
					$ch = curl_init();  
					$timeout = '5';  
					curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
					curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
					$data = curl_exec($ch);
					$mailContent = 'Dear '.$patient_first_name.','.$campaign_category[0]->mail_content .' '. $data;
				}
				$mail->Body = $mailContent;
				$mail->clearAddresses();
				// Add a recipient
				if($campaign_category[0]->campaign_type == 'email'){
					$mail->addAddress($patient_email);
					$mail->addBCC('velusamy@desss.com');
				}elseif($campaign_category[0]->campaign_type == 'sms'){
					$mail->addAddress($sms_data_email);
					$mail->addBCC('velusamy@desss.com');
				}
				if(!$mail->send()){
					// echo 'Message could not be sent.';
					// echo 'Mailer Error: ' . $mail->ErrorInfo;
					echo "<script type='text/javascript'> alert('Message not sent!');location.replace('".base_url()."email_sms_blast/campaign_report_import/".$campaign_category_id."');</script>";
				} else {
					if(empty($get_check_sms_data))
					{
						$this->Email_sms_blast_model->insert_sms_data($user_id,$patient_first_name,$patient_email,$get_user[0]->phone_number,$sms_data_email);
					}					
					$this->Email_sms_blast_model->update_send_email_sms_filter_data($user_id,$campaign_category_id,$track_code);
					echo "<script type='text/javascript'> alert('Message sent!');location.replace('".base_url()."email_sms_blast/campaign_report_import/".$campaign_category_id."');</script>";
				}	
			}						
		}
	}
	
	function get_graphics_data()
	{
		$campaign_type = $this->input->post('value');		
		$campaign_datas = $this->Email_sms_blast_model->get_graphics_data($campaign_type);
		if(!empty($campaign_datas)){
			$data[] = "<option value=''>Select Campaign</option>";
			foreach($campaign_datas as $campaign_data){
				$data[] = "<option value=".$campaign_data->id.">".$campaign_data->category."</option>";
			}			
		}else{
			$data[] = "<option value=''>Select Campaign</option>";
		}
		print_r($data);
	}
	
	function test_datatable()
	{
		$website_id = $this->admin_header->website_id();
		$placed_status = '';
        $requestData = $_REQUEST;
        $get_data = $this->Email_sms_blast_model->get_patient_user_data(); 
		$columns = array(
            0 => 'id',
            1 => 'name',
			2 => 'email',
			3 => 'phone_number',
            4 => 'provider_name',
            5 => 'facility_name',
			6 => 'visited_date'
        );
        $totalFiltered = $get_data;  
		$can = 0; 
		for($c=0;$c<count($requestData['columns']);$c++)
		{		
			if (!empty($requestData['columns'][$c]['order']['search']['value']))
			{
				$sql = "SELECT *";
				$sql .= " FROM zcms_email_sms_blast_users";
				if($placed_status != '')
				{
					$sql .= " WHERE is_deleted = 0 AND ".$columns[$c]." LIKE '%" . $requestData['columns'][$c]['search']['value'] . "%'";  
				}
				else
				{
					$sql .= " WHERE is_deleted = 0 AND ".$columns[$c]." LIKE '%" . $requestData['columns'][$c]['search']['value'] . "%'";  
				}
				$query = $this->db->query($sql);
				$totalFiltered = $query->num_rows(); 
	
				$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   ASC   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " "; 
				$query = $this->db->query($sql); 
				$can++;				
			}
		} 
		if($can == 0)
		{
			if (!empty($requestData['search']['value']))
			{
				$sql = "SELECT *";
				$sql .= " FROM zcms_email_sms_blast_users";
				if($placed_status != '')
				{
					$sql .= " WHERE is_deleted = 0 AND name LIKE '%" . $requestData['search']['value'] . "%' ";  
				}
				else
				{
					$sql .= " WHERE is_deleted = 0 AND name LIKE '%" . $requestData['search']['value'] . "%' ";    
				}
				$query = $this->db->query($sql);
				$totalFiltered = $query->num_rows(); 
	
				$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . ""; 
				$query = $this->db->query($sql); 
			}
			else
			{
				$sql = "SELECT *";
				$sql .= " FROM zcms_email_sms_blast_users WHERE is_deleted = 0";
				$sql .= " ORDER BY name ASC LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "";
				$query = $this->db->query($sql);
			}
		}
        $data = array();
        $i = $requestData['start'] + 1;
        foreach ($query->result_array() as $row)
		{
			$i;
			$nestedData = array();			
            $nestedData[] = '<p><input type="checkbox" class="flat" id="table_records" name="table_records[]" value="" . $row["id"] . ""><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="" . $row["id"] . ""></p>';
            $nestedData[] = '<p>'.$row["name"].'</p>';
            $nestedData[] = '<p>'.$row["email"].'</p>';
			$nestedData[] = '<p>'.$row["phone_number"].'</p>';
            $nestedData[] = '<p>'.$row['provider_name'].'</p>';
            $nestedData[] = '<p>'.$row['facility_name'].'</p>';
			$nestedData[] = '<p>'.$row['visited_date'].'</p>';
            $nestedData[] = '<div class="action_btn_container">
			<div class="action_btn preview_bt">onclick="return delete_record(' .$row["id"]. ', \'' . base_url('email_sms_blast/delete_user/' . $website_id) . '\')"<i class="fa  fa-trash"></i></div>';
            $data[] = $nestedData;
            $i++;
        }

       $json_data = array(
            "draw" => intval($requestData['draw']),   
            "recordsTotal" => intval($get_data),  
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data   
        );

        echo json_encode($json_data);
	}
	public function get_table() {    
	 
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phone_number = $this->input->post('phone_number');
        $provider_name = $this->input->post('provider_name'); 
		$facility_name = $this->input->post('facility_name');
		$visited_date = $this->input->post('visited_date');   		
           
        if(!empty($name)){
            $this->Email_sms_blast_model->setName($name);
        }                
        if(!empty($visited_date)) {
			$start_date = date("m/d/Y", strtotime($visited_date));
            $this->Email_sms_blast_model->setStartDate($start_date);
            
        }        
        $getOrderInfo = $this->Email_sms_blast_model->getOrders();
        $data = array();
        foreach ($getOrderInfo as $element) {   
            $nestedData = array();			
            $nestedData[] = '<p><input type="checkbox" class="flat" id="table_records" name="product_records[]" value='.$element["id"].'"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value='.$element["id"].'"></p>';
            $nestedData[] = '<p>'.$element["name"].'</p>';
            $nestedData[] = '<p>'.$element["email"].'</p>';
            $nestedData[] = '<p>'.$element["phone_number"].'</p>';
            $nestedData[] = '<p>'.$element["provider_name"].'</p>';
            $nestedData[] = '<p>'.$element['facility_name'].'</p>';
			$nestedData[] = '<p>'.$element['visited_date'].'</p>';
            $nestedData[] = '<div class="action_btn_container"></div>';
            $data[] = $nestedData;
        }
        echo json_encode(array("data" => $data));
    }
	
	 // get Orders List
    public function getOrderList() {    
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phone_number = $this->input->post('phone_number');
        $provider_name = $this->input->post('provider_name'); 
		$facility_name = $this->input->post('facility_name');
		$visited_date = $this->input->post('visited_date'); 
             
        $getOrderInfo = $this->Email_sms_blast_model->get_users();
        $dataArray = array();
        foreach ($getOrderInfo as $element) { 		
            $dataArray[] = array(
                $element->name,                
                $element->email,
                $element->phone_number,
                $element->provider_name,
                $element->facility_name,
				$element->visited_date
            );
        }
        echo json_encode(array("data" => $dataArray));
    }
	function date_range_graphical_report(){
		$graphics_min = $this->input->post('graphics_min');
		$graphics_max = $this->input->post('graphics_max');
		$campaign_name_data_id = $this->input->post('campaign_name_data_id');		 		
		$get_graphical_datas = $this->Email_sms_blast_model->get_date_range_graphical_report($campaign_name_data_id,$graphics_min,$graphics_max);
		if(!empty($get_graphical_datas)){
			foreach($get_graphical_datas as $get_graphical_data)		
			{
				if(!empty($get_graphical_datas)){
					$sent = count($get_graphical_datas);
				}
				if($get_graphical_data->link_open == '1'){
					$link[] = $get_graphical_data->link_open;
				}			
			}
			$data['link_open'] = count($link); 
			$data['sent'] = $sent; 
			echo json_encode($data);
		}else{
			$data['link_open'] = ''; 
			$data['sent'] = '';
			echo json_encode($data);
		}
	}
	
	function send_sms_email_blast()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['heading']    = 'Add SMS Email Patient';
		$data['title']      = "Add SMS Email New Patient | Administrator";
		
		$this->load->view('template/meta_head', $data);
		$this->load->view('email_blast_header');
		$this->admin_header->index();
		$this->load->view('send_sms_email_msg_blast', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	function insert_sms_email_blast_msg_patients(){
		$website_id = $this->input->post('website_id');
		$first_name = $this->input->post('first_name');
		//$last_name = $this->input->post('last_name');
		$patient_email = $this->input->post('patient_email');
		$phone_number = $this->input->post('phone_number');
		$campaign  = $this->input->post('campaign');
		$location  = $this->input->post('campaign_location');
		$carrier_data  = $this->input->post('carrier_data');
		$status  = $this->input->post('status');
		$status              = (isset($status)) ? '1' : '0';
		
		$campaign_category = $this->Email_sms_blast_model->get_campaign_category_by_id($campaign);
		$patient_first_name = $first_name;
		
		$mail_configurations = $this->Email_sms_blast_model->get_mail_configuration($website_id);
		require_once APPPATH.'third_party/PHPMailer/vendor/autoload.php';
		$track_code = md5(rand());
		$mail = new PHPMailer;
		$mail->SMTPDebug = 0;
		// SMTP configuration
		$mail->isSMTP();
		$mail->Host     = "smtp.1and1.com";
		$mail->SMTPAuth = true;
		$mail->Username = "velusamy@desss.com";
		$mail->Password = "Houston@77042";
		$mail->Port     = '587';						 							
		$mail->setFrom('reviewsdldc@gmail.com', 'Digestive & Liver Disease Consultants , P.A');			
		// Set email format to HTML
		$mail->isHTML(true);
		
		$email_send = '0';
		if($status == 1){
		if(!empty($patient_email)){
			
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
														
													$mailContent .= '<tr>
																		<td class="esd-block-text es-p20t" align="left">
																		  <p
																			style="font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; line-height:24px; font-size:15px;">
																				'.$campaign_category[0]->mail_content.'
																		  </pre>
																		</td>
																	  </tr>';
													$mailContent .= ' <tr>
																		  </tr>
																		  <tr>
																			<td align="center" esd-links-color="#ffffff" class="esd-block-text">
																			<br>
																			<table cellspacing="0" cellpadding="0">
																			<tr>';								
													$mailContent .=' <td style="border-radius:4px; padding:10px" bgcolor="#660033">
																		<a href="'.$campaign_category[0]->tiny_url.'" target="_blank" style="padding: 8px 12px; border-radius: 2px; font-family: roboto, \'helvetica neue\', helvetica, arial, sans-serif; font-size: 14px; color: #ffffff;text-decoration: none; display: inline-block;">
																		'.$campaign_category[0]->category.'
																		</a>
																	 </td>';
														
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
				echo '0';
			} else {
				$email_send = '1';
				echo 'Message sent.';
				echo '1';
			}	
		}
		}
		
		if(!empty($phone_number)){
			$phone_numbers = str_replace("-","",$phone_number);
			$phone_id = "+1";
			$phone_number_data = $phone_id.''.$phone_numbers;
			
			$get_check_sms_data = $this->Email_sms_blast_model->get_sms_data247_data($phone_number);
			if(!empty($get_check_sms_data))
			{
				$sms_data_email = $get_check_sms_data[0]['sms_data_email'];						
			}else
			{
				// Replace key value with your own api key					
				$url = 'https://api.data247.com/v3.0?key=262385da4166dc1dc5&api=MT&phone='.$phone_number_data.'';
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
			
			$sms_send = '0';
			if(!empty($sms_data_email)){
				$mail->Subject= '';
				//$url = 'http://txgidocs.mailtides.com/admin/email_link_open/sms_email_status/'.$user_id.'/'.$campaign_category_id.'/'.$track_code.'';
				/* $ch = curl_init();  
				$timeout = '5';  
				curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
				$data = curl_exec($ch); */
				$mailContent = 'Dear '.$patient_first_name.','.$campaign_category[0]->mail_content .' '. $campaign_category[0]->tiny_url;
				$mail->Body = $mailContent;
				$mail->clearAddresses();
				// Add a recipient
				$mail->addAddress($sms_data_email);	
				$mail->addBCC('velusamy@desss.com');
				if(!$mail->send()){
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
					echo '00';
				} else {
					$sms_send = '1';
					$carrier_data  = $this->input->post('carrier_data');
					$get_carrier_data = $this->Email_sms_blast_model->get_exist_carrier_data($carrier_data);
					if(empty($get_carrier_data))
					{
						$this->Email_sms_blast_model->insert_sms_data('',$patient_first_name,$patient_email,$phone_number,$sms_data_email);
					}
					echo 'Sms Message sent.';
					echo '11';
					
				}	
			}
		}
		
		$this->Email_sms_blast_model->insert_sms_email_blast_msg_patients($email_send ,$sms_send);
		$this->session->set_flashdata('success', 'Successfully Send Email And Sms Message');
		redirect('email_sms_blast/send_sms_email_blast');
	}
	
	function get_campaign_based_on_location()
	{
		$campaign_location = $this->input->post('value');		
		$campaign_datas = $this->Email_sms_blast_model->get_campaign_based_on_location($campaign_location);
		if(!empty($campaign_datas)){
			$data[] = "<option value=''>Select Campaign</option>";
			foreach($campaign_datas as $campaign_data){
				$data[] = "<option value=".$campaign_data->id.">".$campaign_data->category."</option>";
			}			
		}else{
			$data[] = "<option value=''>Select Campaign</option>";
		}
		print_r($data);
	}
}