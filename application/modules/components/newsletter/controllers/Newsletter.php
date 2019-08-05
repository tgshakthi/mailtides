<?php
/**
 * Newsletter
 * Created at : 27-10-2018
 * Author : Karthika
 * 
 * Modified Date : 01-March-2019
 * Modified By : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Newsletter extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Newsletter_model');
		$this->load->module('setting');
		$this->load->module('mail');
	}

	/* Get Newsletter */
	function view($page_id)
	{
		$data['page_url'] = $this->setting->page_url(); 
		$data['image_url'] = $this->setting->image_url();
		$newsletter_customization = $this->setting->get_setting('page_id', $page_id, 'newsletter-customization');
		
		if (!empty($newsletter_customization)) :
			$data['newsletter_title'] = $newsletter_customization['newsletter_title'];
			$data['newsletter_content'] = $newsletter_customization['newsletter_content'];
			$data['newsletter_title_color'] = $newsletter_customization['newsletter_title_color'];
			$data['newsletter_title_position'] = $newsletter_customization['newsletter_title_position'];
			$data['newsletter_content_color'] = $newsletter_customization['newsletter_content_color'];
			$data['newsletter_content_position'] = $newsletter_customization['newsletter_content_position'];
			$data['label_color'] = $newsletter_customization['label_color'];
			$data['button_type'] = $newsletter_customization['button_type'];
			$data['btn_background_color'] = $newsletter_customization['btn_background_color'];
			$data['component_background'] = $newsletter_customization['component_background'];
			$data['newsletter_background'] = $newsletter_customization['newsletter_background'];
			$data['status'] = $newsletter_customization['status'];
		else :
			$data['newsletter_title'] = "";
			$data['newsletter_content'] = "";
			$data['newsletter_title_color'] = "";
			$data['newsletter_title_position'] = "";
			$data['newsletter_content_color'] = "";
			$data['newsletter_content_position'] = "";
			$data['label_color'] = "";
			$data['button_type'] = "";
			$data['btn_background_color'] = "";
			$data['component_background'] = "";
			$data['newsletter_background'] = "";
			$data['status'] = "";
		endif;
		
		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['newsletter_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['newsletter_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;	

		$this->load->view('newsletter', $data);
	}

	// Insert Newsletter
	function insert()
	{
		$website_id = $this->setting->website_id();
		$page_url = $this->input->post('page-url');
		$email = $this->input->post('newsletter-email');
		$newsletter_mail_config = $this->setting->get_setting('website_id', $website_id, 'newsletter-mail-config');

		$this->Newsletter_model->insert_newsletter($website_id);

		if (!empty($newsletter_mail_config)) :
			$send_mail = $this->mail->send_newsletter_mail($website_id, $email, $newsletter_mail_config);
			if ($send_mail == '')
			{
				$data['title'] = $newsletter_mail_config['success_title'];
				$data['message'] = $newsletter_mail_config['success_message'];
				$data['type'] = 'success';
				$data['code'] = 1;
				$data['page_url'] = $page_url;
				echo json_encode($data);
			}
			else
			{
				echo $page_url;
			}
		endif;		
	}
}

?>
