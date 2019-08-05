<?php
/**
 * Conclusion
 *
 * @category class
 * @package  Conclusion
 * @author   Athi
 * Created at:  25-Apr-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Conclusion extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Conclusion_model');
		$this->load->module('admin_header');
		$this->load->module('color');
    }

    // Get Conclusion Text
    function conclusion_index($page_id)
    {
		$conclusion	= $this->Conclusion_model->get_conclusion($page_id);
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		if ( ! empty ($conclusion) )
		{
			foreach ($conclusion as $conclusions)
			{
				$data['conclusion_id']	= $conclusions->id;
				$data['conclusion_title']	= $conclusions->title;
				$data['title_position']	= $conclusions->title_position;
				$data['text']	= $conclusions->text;
				$data['content_position']	= $conclusions->content_position;
				$data['title_color']	= $conclusions->title_color;
				$data['content_color']	= $conclusions->content_color;
				$data['background'] = $conclusions->background;
			}
		}
		else
		{
			$data['conclusion_id']	= "";
			$data['conclusion_title']	= "";
			$data['title_position']	= "";
			$data['text']	= "";
			$data['content_position']	= "";
			$data['title_color']	= "";
			$data['content_color']	= "";
			$data['background'] = '';
		}
		
		if (!empty($data['background'])) :
			$conclusion_bg = json_decode($data['background']);
			$data['component_background'] = $conclusion_bg->component_background;
			$data['conclusion_background'] = $conclusion_bg->conclusion_background;
		else :
			$data['component_background'] = "";
			$data['conclusion_background'] = "";
		endif;
				
		$data['page_id']  		 = $page_id;
		$data['heading']  		 = 'Conclusion';
		$data['title']		   = "Conclusion | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('conclusion_header');
		$this->admin_header->index();
		$this->load->view('add_edit_conclusion', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Insert & Update Conclusion
	function insert_update_conclusion()
	{
		$conclusion_id	= $this->input->post('conclusion-id');
		$page_id	= $this->input->post('page-id');
		$continue	= $this->input->post('btn_continue');

		$error_config = array(
			array(
				'field'	=> 'text',
				'label'	=> 'Conclusion',
				'rules'	=> 'required'
			)
			);


		$this->form_validation->set_rules($error_config);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('conclusion/conclusion_index/'.$page_id);
		}
		else
		{
			if (empty($conclusion_id))
			{
				$this->Conclusion_model->insert_update_conclusion();
				$this->session->set_flashdata('success', 'Conclusion successfully Added');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'conclusion/conclusion_index/'.$page_id;
				}
				else
				{
					$url = 'page/page_details/'.$page_id;
				}
			}
			else
			{
				$this->Conclusion_model->insert_update_conclusion($conclusion_id);
				$this->session->set_flashdata('success', 'Conclusion Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'conclusion/conclusion_index/'.$page_id;
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
