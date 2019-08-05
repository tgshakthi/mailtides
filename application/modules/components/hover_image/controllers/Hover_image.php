<?php
/**
 * Hover Image
 * Created at : 05-Apr-2019
 * Author : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Hover_image extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Hover_image_model');
	}

	/* Get Hover Image */
	function view($page_id)
	{
		$data['image_url'] = $this->setting->image_url();		
		$data['hover_images'] = $this->Hover_image_model->get_hover_image($page_id);

		$hover_image_customization = $this->setting->get_setting('page_id', $page_id, 'hover_image_customize');
		if (!empty($hover_image_customization)) :
			$data['row_count'] = $hover_image_customization['hover_image_row_count'];
		else :
			$data['row_count'] = 'over-one-col';
		endif;
		$this->load->view('hover_image', $data);
	}
}

?>