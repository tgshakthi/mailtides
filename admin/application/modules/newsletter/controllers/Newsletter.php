<?php
/**
 * Introduction
 *
 * @category class
 * @package  Introduction
 * @author   Karthika
 * Created at:  27-10-2018
 * 
 * Modified Date : 01-March-2019
 * Modified By : Saravana
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Newsletter extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Newsletter_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	// Get Newsletter Customization
	function newsletter_index($page_id)
	{
		$website_id = $this->admin_header->website_id();
		$data['newsletter'] = $this->Newsletter_model->get_newsletter_customiztion($website_id, $page_id, 'newsletter-customization');		
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
		if (!empty($data['newsletter']))
		{
			$keys   = json_decode($data['newsletter'][0]->key);
            $values = json_decode($data['newsletter'][0]->value);
            $i      = 0;
            foreach ($keys as $key):
                $data[$key] = $values[$i];
                $i++;
            endforeach;
		}
		else
		{
			$data['newsletter_title'] = "";
			$data['newsletter_content'] = "";			
			$data['newsletter_title_color'] = "";
			$data['newsletter_title_position'] = "";
			$data['newsletter_content_color'] = "";
			$data['newsletter_content_position'] = "";			
			$data['label_color'] = "";
			$data['button_type'] = "";
			$data['btn_background_color'] = "";
			$data['component_background'] = "";
			$data['newsletter_background'] = "";
			$data['status'] = "";
		}
		/* if (!empty($data['background'])) :
			$newsletter_bg = json_decode($data['background']);
			$data['component_background'] = $newsletter_bg->component_background;
			$data['newsletter_background'] = $newsletter_bg->newsletter_background;
		else :
			$data['component_background'] = "";
			$data['newsletter_background'] = "";
		endif; */

		$data['page_id'] = $page_id;
		$data['heading'] = 'Newsletter';
		$data['title'] = "Newsletter | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('newsletter_header');
		$this->admin_header->index();
		$this->load->view('add_edit_newsletter', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert Update Newsletter Customization
	function insert_update_newsletter()
	{
		$continue = $this->input->post('btn_continue');
		$page_id = $this->input->post('page-id');
		$website_id = $this->admin_header->website_id();

		$this->Newsletter_model->insert_update_newsletter_data($website_id);
		if (isset($continue) && $continue === "Add & Continue" || $continue === "Update & Continue") : 
			$url = 'newsletter/newsletter_index/' . $page_id;
		else :
			$url = 'page/page_details/' . $page_id;
		endif;
		redirect($url);		
	}

	// Get newsletter data
	function index()
	{
		$website_id = $this->admin_header->website_id();
		$data['table'] = $this->get_table($website_id);
		$data['heading'] = 'Newsletter';
		$data['title'] = "Newsletter | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('newsletter_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');

	}

	// Get Table Grid
	function get_table($website_id) 
	{
		$newsletter_contents = $this->Newsletter_model->get_newsletter($website_id);
		if (isset($newsletter_contents) && $newsletter_contents != "")
		{
			foreach($newsletter_contents as $newsletter_content)
			{
				$newsletter_data = json_decode($newsletter_content->value);

				$anchor_delete = anchor(
					'',
					'<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>',
					array(
						'data-toggle' => 'tooltip',
						'data-placement' => 'right',
						'data-original-title' => 'Delete',
						'onclick' => 'return delete_record(' . $newsletter_content->id . ', \'' . base_url('newsletter/delete_newsletter/' . $website_id) . '\')'
					)
				);

				$cell = array(
					'class' => 'last',
					'data' => $anchor_delete
				);

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $newsletter_content->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $newsletter_content->id . '">',
					ucwords($newsletter_data->name) ,
					$newsletter_data->email ,
					$cell
				);
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
			id="datatable-checkbox"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">',
			//'tbody_open' => '<tbody id = "table_row_sortable">'
		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading(array(
			'<input type="checkbox" id="check-all" class="flat">',
			'Name',
			'Email',			
			'Action'
		));
		return $this->table->generate();
	}

	// Delete Newsletter

	function delete_newsletter($website_id)
	{
		$this->Newsletter_model->delete_newsletter($website_id);
		$this->session->set_flashdata('success', 'Successfully Deleted');
	}

	// Delete multiple newsletter

	function delete_multiple_newsletter()
	{
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('newsletter');
		}
		else
		{
			$this->Newsletter_model->delete_multiple_newsletter();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('newsletter');
		}
	}

	// Mail Config
	function mail_config()
	{
		$data['website_id']   = $this->admin_header->website_id();
        $data['newsletter_mail_config'] = $this->Newsletter_model->get_newsletter_mail_config($data['website_id'], 'newsletter-mail-config');
        
        if (!empty($data['newsletter_mail_config'])):
            $keys = json_decode($data['newsletter_mail_config'][0]->key);
			$values = json_decode($data['newsletter_mail_config'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
        else:
            $data['mail_subject']    = "";
            $data['from_name']       = "";
			$data['message_content'] = "";
			$data['success_title'] = "";
			$data['success_message'] = "";
            $data['to_address']      = "";
            $data['cc']              = "";
            $data['bcc']             = "";
            $data['status']          = "";
        endif;
        
        $data['heading'] = 'Newsletter - Mail Configuration';
        $data['title']   = 'Newsletter - Mail Configuration | Administrator';
        $this->load->view('template/meta_head', $data);
        $this->load->view('newsletter_header');
        $this->admin_header->index();
        $this->load->view('mail_config');
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
	}

	// Insert Update Newsletter Mail config
	function insert_update_newsletter_mail_configure()
	{
		$btn_continue = $this->input->post('btn_continue');
		$this->Newsletter_model->insert_update_newsletter_mail_config();
		if (!empty($btn_continue) && $btn_continue === 'Save & Continue' || $btn_continue === 'Update & Continue') :
			$url = 'newsletter/mail_config';
		else :
			$url = 'newsletter';
		endif;
		redirect($url);
	}
}