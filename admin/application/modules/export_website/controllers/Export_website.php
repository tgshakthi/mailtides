<?php
/**
 * Export Website
 * 
 * @category class
 * @package Export Website
 * @author Saravana
 * Created at : 13-Feb-2019
 */

 defined('BASEPATH') OR exit('No direct access allowed!');
 class Export_website extends MX_Controller
 {
     function __construct()
     {
         parent::__construct();
         $this->load->module('admin_header');
         $this->load->model('Export_website_model');
     }

     function index()
     {
        $website_id = $this->admin_header->website_id();
        $this->Export_website_model->export($website_id);
     }

     function test()
     {
        $website_id = $this->admin_header->website_id();
        $this->Export_website_model->export_test($website_id);
     }
 }