<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_link_open extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();	
		$this->load->model('Email_link_open_model');
		// $this->load->module('admin_header');
	}
	function index()
	{
		$website_id = $this->admin_header->website_id();
		if(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google')
		{
			// DLDC Google Email Link
			// $campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'1');
			$this->update_feedback($_GET['review_user_id'], 'google');
			//redirect("https://www.google.com/search?q=Digestive+%26+Liver+Disease+Consultants%2C+P.A&rlz=1C1CHBF_enUS841US841&oq=Digestive+%26+Liver+Disease+Consultants%2C+P.A&aqs=chrome..69i57j35i39l2j0.502j0j4&sourceid=chrome&ie=UTF-8#lrd=0x8640cae00551d8a1:0xf056fad3123b2851,1");
			redirect("https://www.google.com/search?q=digestive%2B%26%2Bliver%2Bdisease%2Bconsultants%2C%2Bpa.%2C%2B275%2Blantern%2Bbend%2Bdr%2B200%2C%2Bhouston%2C%2Btx%2B77090&rlz=1C1SQJL_enUS816US816&oq=dig&aqs=chrome.0.69i59j69i57j0l4j69i61j69i60.1844j0j7&sourceid=chrome&ie=UTF-8#lrd=0x8640cae00551d8a1:0xf056fad3123b2851,1,,,");
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google-hamat')
		{
			//Google Hamat Email Link
			$this->update_feedback($_GET['review_user_id'], 'google');
			redirect("https://www.google.com/search?rlz=1C1SQJL_enUS816US816&ei=v30WXoahG8HusQXs352QAw&q=dr+hamat&oq=dr+hamat&gs_l=psy-ab.3..0j46i199i175l2j0j46i199i175l2j0j46i199i175j0j46i199i175.2602.2869..3059...0.0..0.194.627.2j3....3..0....1..gws-wiz.......46i199i175i67i275j0i30j0i10i30j0i8i30j0i22i30j0i22i10i30j46i199i175i67.asYvTwiwbjI&ved=0ahUKEwjG_ImCq_XmAhVBd6wKHexvBzIQ4dUDCAs&uact=5#lrd=0x8640b3ae3b684b07:0x722f40416802a512,1,,,");
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google-reddy')
		{
			//Google Reddy Email Link
			// $this->Email_link_open_model->get_campaign_category($website_id,'3');
			$this->update_feedback($_GET['review_user_id'], 'google');
			redirect("https://www.google.com/search?safe=active&rlz=1C1SQJL_enUS816US816&sxsrf=ACYBGNSqpw9OEoRjx8pflA-SrHAq3jkMPQ%3A1578530034499&ei=8nQWXo6HHsmntQa09qXICw&q=dr+guru+reddy&oq=Dr+guru&gs_l=psy-ab.3.0.35i39j0i20i263j0l8.44427.48774..50102...1.2..0.95.847.10......0....1..gws-wiz.......0i71j0i131j0i67j0i273j0i10j0i131i67.Dv33L_DZgTk#lrd=0x8640cae00551d941:0x865083c49754c6f8,1,,,");
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google-hamat')
		{
			//Google Hamat Email Link
			// $this->Email_link_open_model->get_campaign_category($website_id,'5');
			$this->update_feedback($_GET['review_user_id'], 'google');
			redirect("https://www.google.com/search?rlz=1C1SQJL_enUS816US816&ei=v30WXoahG8HusQXs352QAw&q=dr+hamat&oq=dr+hamat&gs_l=psy-ab.3..0j46i199i175l2j0j46i199i175l2j0j46i199i175j0j46i199i175.2602.2869..3059...0.0..0.194.627.2j3....3..0....1..gws-wiz.......46i199i175i67i275j0i30j0i10i30j0i8i30j0i22i30j0i22i10i30j46i199i175i67.asYvTwiwbjI&ved=0ahUKEwjG_ImCq_XmAhVBd6wKHexvBzIQ4dUDCAs&uact=5#lrd=0x8640b3ae3b684b07:0x722f40416802a512,1,,,");
		}
	}
	// SMS Status
	function sms_status($user_id,$provider_name)
	{
		// $website_id = $this->admin_header->website_id();
		if(isset($user_id) && isset($provider_name) && $provider_name == 'DLDC')
		{
			//DLDC SMS Link
			// $this->Email_link_open_model->get_campaign_category($website_id,'2');
			$this->update_sms_feedback($user_id,$provider_name);			
			redirect("https://tinyurl.com/vj4mjvg");
		}
		elseif($provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy')
		{
			//Reddy Google SMS Link
			// $this->Email_link_open_model->get_campaign_category($website_id,'4');
			$this->update_sms_feedback($user_id,$provider_name);
			redirect("https://tinyurl.com/uy6da6c");
		}
		elseif($provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard')
		{
			//Hamat Google SMS Link
			// $this->Email_link_open_model->get_campaign_category($website_id,'6');
			$this->update_sms_feedback($user_id,$provider_name);
			redirect("https://tinyurl.com/sw9d3g9");
		}
	}

	//DLDC Facebook SMS
	function fb_sms_status($user_id)
	{
		// $website_id = $this->admin_header->website_id();
		if(isset($user_id))
		{
			//DLDC Fb SMS Link
			// $this->Email_link_open_model->get_campaign_category($website_id,'8');
			$this->update_fb_sms_feedback($user_id);			
			redirect("https://tinyurl.com/uudc8yg");
		}
	}

	//DLDC Facebook  Email
	function fb_email_status($user_id)
	{
		// $website_id = $this->admin_header->website_id();
		if(isset($user_id))
		{
			//DLDC Fb Email Link
			// $this->Email_link_open_model->get_campaign_category($website_id,'7');
			$this->update_fb_email_feedback($user_id);			
			redirect("https://tinyurl.com/uudc8yg");
		}
	}

	//DLDC Email 
	function dldc_email_status($user_id)
	{
		// $website_id = $this->admin_header->website_id();
		if(isset($user_id))
		{
			//DLDC Email Link
			// $this->Email_link_open_model->get_campaign_category($website_id,'9');
			$this->update_dldc_email_feedback($user_id);			
			redirect("https://tinyurl.com/rl8opbq");
		}
	}
	//DLDC SMS  
	function dldc_sms_status($user_id)
	{
		// $website_id = $this->admin_header->website_id();
		if(isset($user_id))
		{
			//DLDC SMS Link
			// $campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'10');
			// print_r($campaign_tiny_urls);die;
			$this->update_dldc_sms_feedback($user_id);			
			redirect("https://tinyurl.com/rl8opbq");
		}
	}
}