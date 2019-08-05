<?php
/**
 * Text Image
 * Created at : 08-June-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Text_image extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Text_image_model');
		$this->load->module('Setting');
	}

	/* Get Text Image */
	function view($page_id)
	{
		$data['image_url'] = $this->setting->image_url();
		$data['text_images'] = $this->Text_image_model->get_text_image($page_id);
		$this->load->view('text_image', $data);
	}
}

?>
