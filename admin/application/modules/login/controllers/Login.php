<?php
/**
 * Admin Login
 *
 * @category class
 * @package  Admin Login
 * @author   Saravana
 * Created at:  09-Mar-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->module('user_activity');
	}

	// Login
	function index()
	{
		$data['title'] = "Login | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('login');
		$this->load->view('template/footer');
	}

	// Log off
	function signoff()
	{
		$this->session->unset_userdata('logged_in');
		$data['title'] = "Login | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('login');
		$this->load->view('template/footer');
	}
}
