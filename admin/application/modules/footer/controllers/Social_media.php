<?php
/**
 * Social Media
 *
 * @category class
 * @package  Social Media
 * @author   Saravana
 * Created at:  27-Sep-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Social_media extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Footer_social_media_model');
		$this->load->module('admin_header');
		$this->form_validation->CI =& $this;
	}

	//Get Footer social Media info
	function index()
	{
		$data['website_id'] = $this->admin_header->website_id();

		$data['footer_social_media'] = $this->Footer_social_media_model->get_setting_footer($data['website_id'], 'footer_social_media_info');
		if(!empty($data['footer_social_media'])) :
			$keys = json_decode($data['footer_social_media'][0]->key);
			$values = json_decode($data['footer_social_media'][0]->value);
			$i = 0;
			foreach($keys as $key) :

				$data[$key] = $values[$i];
				$i++;

			endforeach;
		else:
			$data['footer_social_info_position'] = '';
			$data['footer_social_info_status'] = '';
		endif;

		$data['heading'] = 'Social Media';
		$data['title'] = 'Footer | Social Media | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('footer');
		$this->admin_header->index();
		$this->load->view('social_media', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// insert update footer social media info
	function insert_update_footer_social_info()
	{
		$continue = $this->input->post('btn_continue');
		$this->Footer_social_media_model->insert_update_footer_social_info_data();

		if (isset($continue) && $continue === "Add & Continue")
		{
			$url = 'footer/social_media';
		}
		else if (isset($continue) && $continue === "Update & Continue")
		{
			$url = 'footer/social_media';
		}
		else
		{
			$url = 'footer';
		}
		redirect($url);
	}

}
