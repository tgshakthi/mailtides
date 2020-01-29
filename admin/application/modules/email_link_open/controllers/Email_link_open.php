<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_link_open extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();	
		$this->load->model('Email_link_open_model');
		$this->load->module('admin_header');
	}
	function index()
	{
		$website_id = $this->admin_header->website_id();
		if(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google')
		{
			// DLDC Google Email Link
			$campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'1');
			$this->update_feedback($_GET['review_user_id'], 'google');
			//redirect("https://www.google.com/search?q=Digestive+%26+Liver+Disease+Consultants%2C+P.A&rlz=1C1CHBF_enUS841US841&oq=Digestive+%26+Liver+Disease+Consultants%2C+P.A&aqs=chrome..69i57j35i39l2j0.502j0j4&sourceid=chrome&ie=UTF-8#lrd=0x8640cae00551d8a1:0xf056fad3123b2851,1");
			redirect($campaign_tiny_urls[0]['web_url']);
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google-reddy')
		{
			//Google Reddy Email Link
			$campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'3');
			$this->update_feedback($_GET['review_user_id'], 'google');
			redirect($campaign_tiny_urls[0]['web_url']);
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google-hamat')
		{
			//Google Hamat Email Link
			$campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'5');
			$this->update_feedback($_GET['review_user_id'], 'google');
			redirect($campaign_tiny_urls[0]['web_url']);
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'facebook')
		{
			//Txgidocs Facebook Email Link
			$this->update_feedback($_GET['review_user_id'], 'facebook');
			redirect("https://www.facebook.com/TxGIDocs/");
		}
		elseif(isset($_GET['review_user_id']) && !isset($_GET['type']))
		{ 
			//Txgidocs Email Link
			$this->update_feedback($_GET['review_user_id'], 'txgidocs');
			//redirect('https://www.txgidocs.com/reviews.html?review_user_id='.$_GET['review_user_id'].''); 
			redirect("https://www.google.com/search?sxsrf=ACYBGNR9c2rQOGlodOqz5GvLUJa8JMXTQw%3A1569510244007&source=hp&ei=Y9OMXd7dOo_YtAW1zIyYCQ&q=digestive%2B%26%2Bliver%2Bdisease%2Bconsultants%2C%2Bpa.%2C%2B275%2Blantern%2Bbend%2Bdr%2B200%2C%2Bhouston%2C%2Btx%2B77090&oq=&gs_l=psy-ab.3.1.35i362i39l10.0.0..5134...0.0..0.95.95.1......0......gws-wiz.....10.wu3eOlLJNGE#lkt=LocalPoiReviews&lrd=0x8640cae00551d8a1:0xf056fad3123b2851,1,,,&trex=m_t:lcl_akp,rc_f:nav,rc_ludocids:17318305201550731345,rc_q:Digestive%2520%2526%2520Liver%2520Disease%2520Consultants%252C%2520P.A.,ru_q:Digestive%2520%2526%2520Liver%2520Disease%2520Consultants%252C%2520P.A");
		}
	}
	// Update Feedback Email 
	function update_feedback($id, $route)
	{
		$this->Email_link_open_model->update_feedback($id, $route);
	}
	
	// get users
	function get_users()
	{
		$id = $this->input->post('id');
		$get_users = $this->Email_link_open_model->get_users($id);
		if (!empty($get_users)) 
		{
			$users = array(
				'name' => $get_users[0]->name,
				'email' => $get_users[0]->email
			);
			echo json_encode($users);
		}
		else 
		{
			echo '0';
		}
	}
	
	// SMS Status
	function sms_status($user_id,$provider_name)
	{
		$website_id = $this->admin_header->website_id();
		if(isset($user_id) && isset($provider_name) && $provider_name == 'DLDC')
		{
			//DLDC SMS Link
			$campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'2');
			$this->update_sms_feedback($user_id,$provider_name);			
			redirect($campaign_tiny_urls[0]['tiny_url']);
		}
		elseif(isset($user_id) && isset($provider_name) && $provider_name == 'Reddy')
		{
			if($provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy')
			{
				//Reddy Google SMS Link
				$campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'4');
				$this->update_sms_feedback($user_id,$provider_name);
				redirect($campaign_tiny_urls[0]['tiny_url']);
			}
			
		}
		elseif(isset($user_id) && isset($provider_name))
		{
			if($provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard')
			{
				//Hamat Google SMS Link
				$campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'6');
				$this->update_sms_feedback($user_id,$provider_name);
				redirect($campaign_tiny_urls[0]['tiny_url']);
			}
		}		
	}
	
	// Update SMS Feedback
	function update_sms_feedback($id, $provider_name)
	{
		$this->Email_link_open_model->update_sms_feedback($id, $provider_name);
	}
	
	//DLDC Facebook SMS
	function fb_sms_status($user_id)
	{
		$website_id = $this->admin_header->website_id();
		if(isset($user_id))
		{
			//DLDC Fb SMS Link
			$campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'8');
			$this->update_fb_sms_feedback($user_id);			
			redirect($campaign_tiny_urls[0]['tiny_url']);
		}
	}
	
	// Update Facebook SMS Feedback
	function update_fb_sms_feedback($id)
	{
		$this->Email_link_open_model->update_fb_sms_feedback($id);
	}
	
	//DLDC Facebook  Email
	function fb_email_status($user_id)
	{
		$website_id = $this->admin_header->website_id();
		if(isset($user_id))
		{
			//DLDC Fb Email Link
			$campaign_tiny_urls =  $this->Email_link_open_model->get_campaign_category($website_id,'7');
			$this->update_fb_email_feedback($user_id);			
			redirect($campaign_tiny_urls[0]['tiny_url']);
		}
	}
	
	// Update Facebook Email Feedback
	function update_fb_email_feedback($id)
	{
		$this->Email_link_open_model->update_fb_email_feedback($id);
	}
	
	//DLDC Email 
	function dldc_email_status($user_id)
	{
		$website_id = $this->admin_header->website_id();
		if(isset($user_id))
		{
			//DLDC Email Link
			$campaign_tiny_urls =  $this->Email_link_open_model->get_campaign_category($website_id,'9');
			$this->update_dldc_email_feedback($user_id);			
			redirect($campaign_tiny_urls[0]['tiny_url']);
		}
	}
	//Update DLDC Email Feedback
	function update_dldc_email_feedback($id)
	{
		$this->Email_link_open_model->update_dldc_email_feedback($id);
	}
	
	//DLDC SMS  
	function dldc_sms_status($user_id)
	{
		$website_id = $this->admin_header->website_id();
		if(isset($user_id))
		{
			//DLDC SMS Link
			$campaign_tiny_urls = $this->Email_link_open_model->get_campaign_category($website_id,'10');
			// print_r($campaign_tiny_urls);die;
			$this->update_dldc_sms_feedback($user_id);			
			redirect($campaign_tiny_urls[0]['tiny_url']);
		}
	}
	
	// Update DLDC SMS Feedback
	function update_dldc_sms_feedback($id)
	{
		$this->Email_link_open_model->update_dldc_sms_feedback($id);
	}
}