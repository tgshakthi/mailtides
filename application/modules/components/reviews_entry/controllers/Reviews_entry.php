<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reviews_entry extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();	
		$this->load->library('session');
		$this->load->model('Review_entry_model');
		$this->load->module('setting');
		$this->load->module('mail');
	  }
	  
	function view($page_id)
	{
		$url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$parse_url = parse_url($url);
		if(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'google')
		{
			$this->update_feedback($_GET['review_user_id'], 'google');
			redirect("https://www.google.com/search?q=Digestive+%26+Liver+Disease+Consultants%2C+P.A&rlz=1C1CHBF_enUS841US841&oq=Digestive+%26+Liver+Disease+Consultants%2C+P.A&aqs=chrome..69i57j35i39l2j0.502j0j4&sourceid=chrome&ie=UTF-8#lrd=0x8640cae00551d8a1:0xf056fad3123b2851,1");
		}
		elseif(isset($_GET['review_user_id']) && isset($_GET['type']) && $_GET['type'] == 'facebook')
		{
			$this->update_feedback($_GET['review_user_id'], 'facebook');
			redirect("https://www.facebook.com/TxGIDocs/");
		}
		elseif(isset($_GET['review_user_id']) && !isset($_GET['type']))
		{
			$this->update_feedback($_GET['review_user_id'], 'txgidocs');
		}
		if (isset($parse_url['query'])) 
		{			
			$data['query_string'] = str_replace('review_user_id=', '', $parse_url['query']);
		} 
		else 
		{
			$data['query_string'] = "";
		}
		$data['website_id'] = $this->setting->website_id();
		$data['page_id'] = $page_id;
		$data['page_url'] = $this->setting->page_url();
	
		$data['reviews_entries'] = $this->Review_entry_model->get_review_entry($data['website_id'], $data['page_id']);
		$this->load->view('reviews_entry',$data);
	}
	
	function update_feedback($id, $route)
	{
		$this->Review_entry_model->update_feedback($id, $route);
	}
	
	function insert_reviews_entry()
	{
	
		$url = $this->input->post('page_url');
		$website_id = $this->input->post('website_id');
		$page_id = $this->input->post('page_id');
		$email = $this->input->post('review_email');
		$name = $this->input->post('review_name');
		$reviews = $this->input->post('comments');
		$ratings = $this->input->post('ratings');
		$review_entry_mail_config = $this->setting->get_setting('website_id', $website_id, 'review_entry_mail_config');

		$this->Review_entry_model->insert_update_review_entry_data();

		if (!empty($review_entry_mail_config)) :

			$send_mail = $this->mail->send_review_entry_mail($website_id, $name, $email,$reviews,$ratings, $review_entry_mail_config);
			if ($send_mail == '')
			{
				$data['title'] = $review_entry_mail_config['success_title'];
				$data['message'] = $review_entry_mail_config['success_message'];
				$data['type'] = 'success';
				$data['code'] = 1;
				$data['page_url'] = $url;
				echo json_encode($data);
			}
			else
			{
				echo $url;
			}
		endif;
		redirect($url);
	}

	// get users
	function get_users()
	{
		$id = $this->input->post('id');
		$get_users = $this->Review_entry_model->get_users($id);
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
}