<?php
/**
 * Text Background Image
 * Created at : 30-mar-2019
 * Author : Velu Samy
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Text_background_image extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Text_background_image_model');
		$this->load->module('Setting');
	}

	/* Get Text Image */
	function view($page_id)
	{
		$data['text_background_images'] = $this->Text_background_image_model->get_text_background_image($page_id);		
		
		$data['image_url'] = $this->setting->image_url();
		
		
		
		$this->load->view('text_background_image', $data);
	}
}

?>
