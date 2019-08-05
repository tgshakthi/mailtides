<?php
/**
 * Text Full Width
 *
 * @category class
 * @package  Text Full Width
 * @author   Athi
 * Created at:  24-Apr-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Text_full_width extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Text_full_width_model');
		$this->load->module('admin_header');
		$this->load->module('color');
    }

    // Get Text Full Width
    function text_full_width_index($page_id)
    {
		$text_full_width	= $this->Text_full_width_model->get_text_full_width($page_id);
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		if ( ! empty ($text_full_width) )
		{
			foreach ($text_full_width as $text_full_widths)
			{
				$data['text_full_width_id']	= $text_full_widths->id;
				$data['text_full_width_title']	= $text_full_widths->title;
				$data['full_text']	= $text_full_widths->full_text;
				$data['title_color']	= $text_full_widths->title_color;
				$data['title_position']	= $text_full_widths->title_position;
				$data['content_title_color']	= $text_full_widths->content_title_color;
				$data['content_title_position']	= $text_full_widths->content_title_position;
				$data['content_color']	= $text_full_widths->content_color;
				$data['content_position']	= $text_full_widths->content_position;
				$data['background'] = $text_full_widths->background;
			}
		}
		else
		{
			$data['text_full_width_id']	= "";
			$data['text_full_width_title']	= "";
			$data['full_text']	= "";
			$data['title_color']	= "";
			$data['title_position']	= "";
			$data['content_title_color']	= "";
			$data['content_title_position']	= "";
			$data['content_color']	= "";
			$data['content_position']	= "";
			$data['background'] = '';
		}
		if (!empty($data['background'])) :
			$text_full_width_bg = json_decode($data['background']);
			$data['component_background'] = $text_full_width_bg->component_background;
			$data['text_full_width_background'] = $text_full_width_bg->text_full_width_background;
		else :
			$data['component_background'] = "";
			$data['text_full_width_background'] = "";
		endif;
				
		$data['page_id']  		 = $page_id;
		$data['heading']  		 = 'Text Full Width';
		$data['title']		   = "Text Full Width | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('text_full_width_header');
		$this->admin_header->index();
		$this->load->view('add_edit_text_full_width', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	// Insert & Update Text Full Width
	function insert_update_text_full_width()
	{
		$text_full_width_id	= $this->input->post('text-full-width-id');
		$page_id	= $this->input->post('page-id');
		$continue	= $this->input->post('btn_continue');

		$error_config = array(
			array(
				'field'	=> 'full-text',
				'label'	=> 'Content',
				'rules'	=> 'required'
			));

		$this->form_validation->set_rules($error_config);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('text_full_width/text_full_width_index/'.$page_id);
		}
		else
		{
			if (empty($text_full_width_id))
			{
				$this->Text_full_width_model->insert_update_text_full_width();
				$this->session->set_flashdata('success', 'Text Full Width successfully Added');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'text_full_width/text_full_width_index/'.$page_id;
				}
				else
				{
					$url = 'page/page_details/'.$page_id;
				}
			}
			else
			{
				$this->Text_full_width_model->insert_update_text_full_width($text_full_width_id);
				$this->session->set_flashdata('success', 'Text Full Width Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'text_full_width/text_full_width_index/'.$page_id;
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
