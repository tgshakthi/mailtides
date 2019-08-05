<?php
/**
 * Banner
 * Created at : 07-June-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Banner extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();		
		$this->load->model('Banner_model');
		$this->load->module('Setting');
  	}
	
	/* Get Banner */
  	function view($page_id)
  	{
		$data['image_url'] = $this->setting->image_url();
		$data['banners'] = $this->Banner_model->get_banner($page_id);		
		$this->load->view('banner', $data);
  	}
}
?>
