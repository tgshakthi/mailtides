<?php
/**
 * ErrorDbconnect
 *
 * @category class
 * @package  ErrorDbconnect
 * @author   Saravana
 * Created at:  13-Mar-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Error_dbconnect extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library('session');
  }

  function index()
  {
    $data['title'] = "Error Database Connection | Administrator";
		$this->load->view('template/meta_head', $data);
    $this->load->view('errordbconnect_header');
		$this->load->view('errordbconnect');
    $this->load->view('script');
		$this->load->view('template/footer');
  }
}
