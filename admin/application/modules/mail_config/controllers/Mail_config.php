<?php
/**
 * Mail config 
 *
 * @category class
 * @package  Mail Configuration
 * @author   shiva
 * Created at:  12-JUN-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Mail_config extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Mail_config_model');
		$this->load->module('admin_header');
	}

	// Display all Admin Menu in a table
	function index()
	{
		$data['website_id']   = $this->session->userdata('website_id');
		$mail_configurations = $this->Mail_config_model->get_mail_config_details($data['website_id']);
		if(!empty($mail_configurations))
		{
			foreach($mail_configurations as $mail_configuration)
			{
				$data['id']	= $mail_configuration->id;
				$data['website_id']	= $mail_configuration->website_id;
				$data['host']	= $mail_configuration->host;
				$data['port']	= $mail_configuration->port;
				$data['email']	= $mail_configuration->email;
				$data['password']	= $mail_configuration->password;
				$data['mail_from']	= $mail_configuration->mail_from;
				$data['status']	= $mail_configuration->status;		
			}	
		}
		else
		{
			$data['id']	= "";
			$data['host']	= "";
			$data['port']	= "";
			$data['email']	= "";
			$data['password']	= "";
			$data['mail_from']	= "";
			$data['status']	= "";
		}
		
		$data['heading']	= 'Mail Configuration';
		$data['title'] = "Mail Configuration | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('mail_config_header');
		$this->admin_header->index();
		$this->load->view('mail_config', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Insert Update Mail Config
	function insert_update_Mail_config()
	{
		$mail_config_id = $this->input->post('id');
		
		if (empty($mail_config_id))
		{
			$insert_id	= $this->Mail_config_model->insert_update_mail_config();
			$this->session->set_flashdata('success', 'Successfully Mail Configuration Created.');
		}
		else
		{
			$this->Mail_config_model->insert_update_mail_config($mail_config_id);
			$this->session->set_flashdata('success', 'Mail Configuration Successfully Updated.');
		}
		redirect('mail_config');
	}
}
