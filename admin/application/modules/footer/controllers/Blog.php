<?php
/**
 * Blog
 *
 * @category class
 * @package  Blog
 * @author   Athi
 * Created at:  20-Jul-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Blog_model');
		$this->load->module('admin_header');
		$this->load->module('Color');
	}

	/**
	 * Footer Blog
	 * get table data from get table method
	 */

	function index()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['blogs_unselected'] = $this->Blog_model->get_blog_unselected($data['website_id']);
		$blogs = $this->Blog_model->get_blog_setting($data['website_id'], 'footer_blog');
		if (!empty($blogs))
		{
			$data['setting_id'] = $blogs[0]->id;
			$keys = json_decode($blogs[0]->key);
			$values = json_decode($blogs[0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
			$data['blogs_unselected'] = $this->Blog_model->get_blog_unselected($data['website_id'], $data['blog_id']);
			$data['blogs_selected'] = ($data['blog_id'] != '') ? $this->Blog_model->get_blog_selected($data['website_id'], $data['blog_id']): array();
		}
		else
		{
			$data['setting_id'] = '';
			$data['blog_id'] 	= '';
			$data['status']	= '';
		}

		$data['heading']	= 'Footer Blog';
		$data['title']	= "Footer Blog | Administrator";
		
		$this->load->view('template/meta_head', $data);
		$this->load->view('blog_header');
		$this->admin_header->index();
		$this->load->view('blog', $data);
		$this->load->view('template/footer_content');
		$this->load->view('blog_script');
		$this->load->view('template/footer');
	}


	/**
	 *	Blog insert and Update
	 *  get table data from get table method
	 */

	function insert_update_footer_blog()
	{
		$setting_id	= $this->input->post('setting_id');
		$website_id	= $this->input->post('website_id');

		$continue	= $this->input->post('btn_continue');

		if (empty($setting_id))
		{
			$insert_id	= $this->Blog_model->insert_update_footer_blog($website_id);
			$this->session->set_flashdata('success', 'Footer Blog Successfully Created.');
		}
		else
		{
			$this->Blog_model->insert_update_footer_blog($website_id , $setting_id);
			$this->session->set_flashdata('success', 'Footer Blog Successfully Updated.');
		}
		if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue"))
		{
			$url = 'footer/blog';
		}
		else
		{
			$url = 'footer';
		}
		redirect($url);
	}
}
