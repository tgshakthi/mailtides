<?php
/**
 * Social Media
 *
 * @category class
 * @package Social Media
 * @author   Karthika
 * Created at:  18-Sep-18
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

		$this->load->model('Social_media_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	// Display all Social Media's in a table

	function index()
	{
		$data['table'] = $this->get_table();
		$data['heading'] = 'Social Media';
		$data['title'] = "Social Media | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('social_media_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table

	function get_table()
	{
		$website_id = $this->admin_header->website_id();
		$medias = $this->Social_media_model->get_social_medias($website_id);
	   if (isset($medias) && $medias != "")
		{
			foreach($medias as $media)
			{
				$anchor_edit = anchor('social_media/add_edit_social_media/' . $media->media_id, '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));
				$anchor_delete = anchor('', '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record(' . $media->media_id . ', \'' . base_url('social_media/delete_social_media') . '\')'
				));
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit . ' ' . $anchor_delete
				);
				if ($media->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($media->icon != "")
				{
					$icon = '<i class="fa ' . $media->icon . '"></i>';
				}
				else
				{
					$icon = '';
				}

				$this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $media->media_id . '">', ucwords($media->media_name) , $icon, $status, $cell);
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
			id="datatable-responsive"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">'
		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading(array(
			'<input type="checkbox" id="check-all" class="flat">',
			'Title',
			'Media Icon',
			'Status',
			'Action'
		));
		return $this->table->generate();
	}

	// Add & Edit Social media

	function add_edit_social_media($id = null)
	{
		if ($id != null)
		{
			$media = $this->Social_media_model->get_media_by_id($id);
			$data['media_id'] = $media[0]->media_id;
			$data['media_title'] = $media[0]->media_name;
			$data['media_url'] = $media[0]->media_url;
			$data['icon'] = $media[0]->icon;
			$data['media_icon_color'] = $media[0]->icon_color;
			$data['media_icon_hover_color'] = $media[0]->icon_hover_color;
			$data['background_color'] = $media[0]->background_color;
			$data['background_hover_color'] = $media[0]->background_hover_color;
			$data['sort_order'] = $media[0]->sort_order;
			$data['status'] = $media[0]->status;
		}
		else
		{
			$data['media_id'] = '';
			$data['media_title'] = '';
			$data['media_url'] = '';
			$data['icon'] = '';
			$data['media_icon_color'] = '';
			$data['media_icon_hover_color'] = '';
			$data['background_color'] = "";
			$data['background_hover_color'] = "";
			$data['sort_order'] = '';
			$data['status'] = '';
		}

		$data['website_id'] = $this->admin_header->website_id();
		$data['title'] = ($id != null) ? 'Edit media' : 'Add media' . ' | Administrator';
		$data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Social Media';
		$this->load->view('template/meta_head', $data);
		$this->load->view('social_media_header');
		$this->admin_header->index();
		$this->load->view('add_edit_social_media', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Social Media

	function insert_update_social_media()
	{
	  $media_id = $this->input->post('media_id');
		$continue = $this->input->post('btn_continue');
		$error_config = array(
			array(
				'field' => 'media_title',
				'label' => 'Media Title',
				'rules' => 'required'
			) ,
			array(
				'field' => 'media_url',
				'label' => 'Media Url',
				'rules' => 'required'
			)
		);
	   $this->form_validation->set_rules($error_config);
	 if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('social_media/add_edit_social_media');
		}
		else
		{
			if (empty($media_id))
			{
			  $this->Social_media_model->insert_update_media_data();
			   $this->session->set_flashdata('success', 'Social media menu successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'social_media/add_edit_social_media';
				}
				else
				{
					$url = 'social_media';
				}
			}
			else
			{
				$this->Social_media_model->insert_update_media_data($media_id);
				$this->session->set_flashdata('success', 'Socail media Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'social_media/add_edit_social_media/' . $media_id;
				}
				else
				{
					$url = 'social_media';
				}
			}

			redirect($url);
		}
	}

	function delete_social_media()
	{
		$this->Social_media_model->delete_social_media_data();
		 $this->session->set_flashdata('success', 'Successfully Deleted');
	}

	function delete_multiple_social_media()
	{
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('social_media');
		}
		else
		{
			$this->Social_media_model->delete_multiple_social_data();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('social_media');
		}
	}
}
