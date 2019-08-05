<?php
/**
 * Introduction
 *
 * @category class
 * @package  Introduction
 * @author   Athi
 * Created at:  23-Apr-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class h1andh2  extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Introduction_model');
		$this->load->module('admin_header');
		$this->load->module('color');
    }

    // Get Introduction Text
    function introduction_index($page_id)
    {
		$introduction	= $this->Introduction_model->get_introduction($page_id);
		if ( ! empty ($introduction) )
		{
			foreach ($introduction as $introductions)
			{
				$data['introduction_id']	= $introductions->id;
				$data['introduction_title']	= $introductions->title;
				$data['title_position']	= $introductions->title_position;
				$data['text']	= $introductions->text;
				$data['content_position']	= $introductions->content_position;
				$data['title_color']	= $introductions->title_color;
				$data['content_color']	= $introductions->content_color;
				$data['background_color']	= $introductions->background_color;
			}
		}
		else
		{
			$data['introduction_id']	= "";
			$data['introduction_title']	= "";
			$data['title_position']	= "";
			$data['text']	= "";
			$data['content_position']	= "";
			$data['title_color']	= "";
			$data['content_color']	= "";
			$data['background_color']	= "";
		}
		
		// Check SEO Title
		//$mainpage = $this->Introduction_model->check_seo_title($page_id);
		
		$data['page_id']  		 = $page_id;
		$data['heading']  		 = 'Introduction';
		$data['title']		   = "Introduction | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('introduction_header');
		$this->admin_header->index();
		$this->load->view('add_edit_introduction', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Insert & Update Introduction
	function insert_update_introduction()
	{
		$introduction_id	= $this->input->post('introduction-id');
		$page_id	= $this->input->post('page-id');
		$continue	= $this->input->post('btn_continue');

		$error_config = array(
				array(
				'field'	=> 'text',
				'label'	=> 'Content',
				'rules'	=> 'required'
			)
			);

		$this->form_validation->set_rules($error_config);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('introduction/introduction_index/'.$page_id);
		}
		else
		{
			if (empty($introduction_id))
			{
				$this->Introduction_model->insert_update_introduction();
				$this->session->set_flashdata('success', 'Introduction successfully Added');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'introduction/introduction_index/'.$page_id;
				}
				else
				{
					$url = 'page/page_details/'.$page_id;
				}
			}
			else
			{
				$this->Introduction_model->insert_update_introduction($introduction_id);
				$this->session->set_flashdata('success', 'Introduction Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'introduction/introduction_index/'.$page_id;
				}
				else
				{
					$url = 'page/page_details/'.$page_id;
				}
			}
			redirect($url);
		}		
	}
}
