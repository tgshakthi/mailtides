<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_link_open extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();	
		$this->load->model('Email_link_open_model');
	}
	function index()
	{
		if(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google')
		{
			$this->update_feedback($_GET['review_user_id'], 'google');
			//redirect("https://www.google.com/search?q=Digestive+%26+Liver+Disease+Consultants%2C+P.A&rlz=1C1CHBF_enUS841US841&oq=Digestive+%26+Liver+Disease+Consultants%2C+P.A&aqs=chrome..69i57j35i39l2j0.502j0j4&sourceid=chrome&ie=UTF-8#lrd=0x8640cae00551d8a1:0xf056fad3123b2851,1");
			redirect("https://www.google.com/search?q=digestive%2B%26%2Bliver%2Bdisease%2Bconsultants%2C%2Bpa.%2C%2B275%2Blantern%2Bbend%2Bdr%2B200%2C%2Bhouston%2C%2Btx%2B77090&rlz=1C1SQJL_enUS816US816&oq=dig&aqs=chrome.0.69i59j69i57j0l4j69i61j69i60.1844j0j7&sourceid=chrome&ie=UTF-8#lrd=0x8640cae00551d8a1:0xf056fad3123b2851,1,,,");
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google-hamat')
		{
			$this->update_feedback($_GET['review_user_id'], 'google');
			redirect("https://www.google.com/search?rlz=1C1SQJL_enUS816US816&ei=v30WXoahG8HusQXs352QAw&q=dr+hamat&oq=dr+hamat&gs_l=psy-ab.3..0j46i199i175l2j0j46i199i175l2j0j46i199i175j0j46i199i175.2602.2869..3059...0.0..0.194.627.2j3....3..0....1..gws-wiz.......46i199i175i67i275j0i30j0i10i30j0i8i30j0i22i30j0i22i10i30j46i199i175i67.asYvTwiwbjI&ved=0ahUKEwjG_ImCq_XmAhVBd6wKHexvBzIQ4dUDCAs&uact=5#lrd=0x8640b3ae3b684b07:0x722f40416802a512,1,,,");
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google-reddy')
		{
			$this->update_feedback($_GET['review_user_id'], 'google');
			redirect("https://www.google.com/search?safe=active&rlz=1C1SQJL_enUS816US816&sxsrf=ACYBGNSqpw9OEoRjx8pflA-SrHAq3jkMPQ%3A1578530034499&ei=8nQWXo6HHsmntQa09qXICw&q=dr+guru+reddy&oq=Dr+guru&gs_l=psy-ab.3.0.35i39j0i20i263j0l8.44427.48774..50102...1.2..0.95.847.10......0....1..gws-wiz.......0i71j0i131j0i67j0i273j0i10j0i131i67.Dv33L_DZgTk#lrd=0x8640cae00551d941:0x865083c49754c6f8,1,,,");
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'facebook')
		{
			$this->update_feedback($_GET['review_user_id'], 'facebook');
			redirect("https://www.facebook.com/TxGIDocs/");
		}
		elseif(isset($_GET['review_user_id']) && !isset($_GET['type']))
		{ 
			$this->update_feedback($_GET['review_user_id'], 'txgidocs');
			//redirect('https://www.txgidocs.com/reviews.html?review_user_id='.$_GET['review_user_id'].''); 
			redirect("https://www.google.com/search?sxsrf=ACYBGNR9c2rQOGlodOqz5GvLUJa8JMXTQw%3A1569510244007&source=hp&ei=Y9OMXd7dOo_YtAW1zIyYCQ&q=digestive%2B%26%2Bliver%2Bdisease%2Bconsultants%2C%2Bpa.%2C%2B275%2Blantern%2Bbend%2Bdr%2B200%2C%2Bhouston%2C%2Btx%2B77090&oq=&gs_l=psy-ab.3.1.35i362i39l10.0.0..5134...0.0..0.95.95.1......0......gws-wiz.....10.wu3eOlLJNGE#lkt=LocalPoiReviews&lrd=0x8640cae00551d8a1:0xf056fad3123b2851,1,,,&trex=m_t:lcl_akp,rc_f:nav,rc_ludocids:17318305201550731345,rc_q:Digestive%2520%2526%2520Liver%2520Disease%2520Consultants%252C%2520P.A.,ru_q:Digestive%2520%2526%2520Liver%2520Disease%2520Consultants%252C%2520P.A");
		}
	}
	
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
	
	function sms_status($user_id,$provider_name)
	{
		if(isset($user_id) && isset($provider_name) && $provider_name == 'DLDC')
		{
			//DLDC
			$this->update_sms_feedback($user_id,$provider_name);			
			redirect("https://tinyurl.com/vj4mjvg");
		}
		elseif(isset($user_id) && isset($provider_name) && $provider_name == 'Reddy')
		{
			if($provider_name == 'Reddy' || $provider_name == 'REDDY' || $provider_name == 'Dr Guru N Reddy' || $provider_name == 'REDDY, GURUNATH T' || $provider_name == 'Guru N Reddy')
			{
				//Reddy
				$this->update_sms_feedback($user_id,$provider_name);
				redirect("https://tinyurl.com/uy6da6c");
			}
			
		}
		elseif(isset($user_id) && isset($provider_name))
		{
			if($provider_name == 'HAMAT' || $provider_name == 'Hamat' || $provider_name == 'HAMAT, HOWARD' || $provider_name == 'Howard' || $provider_name == 'Dr. Hamat' || $provider_name == 'Dr. Howard')
			{
				//Hamat
				$this->update_sms_feedback($user_id,$provider_name);
				redirect("https://tinyurl.com/sw9d3g9");
			}
		}		
	}
	
	function update_sms_feedback($id, $provider_name)
	{
		$this->Email_link_open_model->update_sms_feedback($id, $provider_name);
	}
}