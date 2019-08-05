<?php
/**
 * Admin VerifyLogin
 *
 * @category class
 * @package  Admin VerifyLogin
 * @author   Saravana
 * Created at:  09-Mar-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Verifylogin extends MX_Controller
{

	// Constructor

	function __construct()
	{
		parent::__construct();
		$this->load->model('UserAuthentication');
		$this->load->module('user_activity');
		$this->form_validation->CI = & $this;
	}

	/**
	 * Validate login informations
	 * return validation errors
	 * Check with Database
	 * Checks for multiple websites
	 * if success redirects to Dashboard
	 */

	function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_user');
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'Login - Administrator';
			$this->load->view('template/meta_head', $data);
			$this->load->view('login/login');
			$this->load->view('template/footer');
		}
		else
		{
			$login_id = $this->session->userdata['logged_in']['id'];
			if ($login_id == 1)
			{
				$this->session->set_userdata('website_id', '0');
				redirect('dashboard', 'refresh');
			}
			else
			{
				$website_ids = $this->UserAuthentication->getWebsit_id($login_id);
				if ($website_ids)
				{
					$website_id = explode(",", $website_ids[0]->website_id);
					
					if (isset($website_id[1]) && !empty($website_id[1]))
					{
						for ($i = 0; $i < count($website_id); $i++)
						{
							$websites[] = $this->UserAuthentication->get_websites($website_id[$i]);
						}

						$data['websites'] = $websites;
						$data['title'] = "Choose Website | Administrator";
						$this->load->view('template/meta_head', $data);
						$this->load->view('login/login', $data);
						$this->load->view('template/footer');
					}
					else
					{
						$this->user_activity->website_id($website_id[0]);
						$this->session->set_userdata('website_id', $website_id[0]);
						redirect('dashboard', 'refresh');
					}
				}
			}
		}
	}

	/**
	 * Check user with Database
	 * @param password
	 * @param username
	 * Stores id, firstName, lastName, userName, UserRole in session
	 * if not throws errors
	 */
	
	function check_user($password)
	{
		$username = $this->input->post('username');
		$result = $this->UserAuthentication->login($username, $password);
		if (!empty($result))
		{
			$admin_user_details = $this->UserAuthentication->get_admin_user_details($result[0]->id);
			if ($admin_user_details)
			{
				$sess_array = array();
				foreach($admin_user_details as $row)
				{
					$this->user_activity->user_login($row->id);
					$sess_array = array(
						'id' => $row->id,
						'ImageUrl' => str_replace('admin/', 'assets/', base_url())
					);
				}
				$this->session->set_userdata('logged_in', $sess_array);
				return true;
			}
		}
		else
		{
			$this->form_validation->set_message('check_user', 'Invalid Username or Password');
			return false;
		}
	}

	/**
	 * Store website id in session
	 * @param website id
	 * redirects to dashboard
	 */
	function webid_session($web_id)
	{
		if ($web_id)
		{
			$this->user_activity->website_id($web_id);
			$this->session->set_userdata('website_id', $web_id);
			redirect('dashboard', 'refresh');
		}
	}

	/**
	 * Choose other website
	 * redirects to dashboard
	 */

	function another_website()
	{
		$login_id = $this->session->userdata['logged_in']['id'];
		if ($login_id == 1)
		{
			$this->session->set_userdata('website_id', '0');
			redirect('dashboard', 'refresh');
		}
		else
		{
			$website_ids = $this->UserAuthentication->getWebsit_id($login_id);
			if ($website_ids)
			{
				$website_id = explode(",", $website_ids[0]->website_id);
				if (isset($website_id[1]) && !empty($website_id[1]))
				{
					for ($i = 0; $i < count($website_id); $i++)
					{
						$websites[] = $this->UserAuthentication->get_websites($website_id[$i]);
					}

					$data['websites'] = $websites;
					$data['title'] = "Choose Website | Administrator";
					$this->load->view('template/meta_head', $data);
					$this->load->view('login/login', $data);
					$this->load->view('template/footer');
				}
				else
				{
					$this->user_activity->website_id($website_id[0]);
					$this->session->set_userdata('website_id', $website_id[0]);
					redirect('dashboard', 'refresh');
				}
			}
		}
	}
}
