<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Smsgateway extends MX_Controller
{
	function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->module('admin_header');
        $this->load->module('color');
    }
	function index()
	{
		$data['heading'] = 'Sms Gateway';
        $data['title']   = "Sms Gateway | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->admin_header->index();
        $this->load->view('view', $data);
        $this->load->view('template/footer_content');
        $this->load->view('template/footer');
	}
}