<?php
/**
 * Social_media_feed
 *
 * @category class
 * @package  Social Media Feed
 * @author   Siva
 * Created at:  27-11-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Social_media_feed extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Social_media_feed_model');
		$this->load->module('admin_header');
    }

    // Display all social Media Feed           
    function index()
    {
		$data['table'] = $this->get_table();
		$data['title'] = "Social Media_feed | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('social_media_feed_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table
	function get_table()
	{
		$social_media_feed = $this->Social_media_feed_model->get_social_media_feed();
		if (isset($social_media_feed) && $social_media_feed != "")
		{
			foreach ($social_media_feed as $social_media_feeds)
			{
				$anchor_edit = anchor(
					'social_media_feed/edit_social_media_feed/'.$social_media_feeds->id,
					'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
					array(
						'data-toggle'         => 'tooltip',
						'data-placement'      => 'left',
						'data-original-title' => 'Edit'
					)
				);

				$anchor_delete = anchor(
					'',
					'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
					array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record('.$social_media_feeds->id.', \''.base_url('social_media_feed/delete_feed').'\')'
				));

				/* $anchor_menu = anchor(
					'admin_menu/assign_menu/'.$social_media_feeds->user_role_id,
					'<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>',
					array(
						'data-toggle'			=> 'tooltip',
						'data-placement'		=> 'right',
						'data-original-title'	=> 'Menu'
					)
				); */

				$cell = array(
					'class' => 'last',
					'data'  => $anchor_edit.' '.$anchor_delete //.' '.$anchor_menu
				);

				if ($social_media_feeds->status === '1' )
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="'.$social_media_feeds->id.'">',
					ucwords($social_media_feeds->media_name),
					$status,
					$cell
				);
			}
		}

		// Table open
		$template = array(
			'table_open' => '<table
			id="datatable-checkbox"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">'
		);

		$this->table->set_template($template);
		// Table heading row
		$this->table->set_heading(array(
			'<input type="checkbox" id="check-all" class="flat">',
			'Social Media',
			
			'Status',
			'Action'
		));

		return $this->table->generate();
	}

	// Add & Edit Social media Feed
	 function edit_social_media_feed($id = null)
	{
		if ($id != null)
		{
			$Social_media_feeds = $this->Social_media_feed_model->get_social_media_us_id($id);

			$data['feed_id']			= $Social_media_feeds[0]->id;
			$data['media_name']			= $Social_media_feeds[0]->media_name;
			$data['media_url'] 	   		= $Social_media_feeds[0]->media_url;
			$data['media_feed_text'] 	= $Social_media_feeds[0]->media_feed_text;
			$data['status']      		= $Social_media_feeds[0]->status;
		
		}
		else
		{
			$data['feed_id']			= '';
			$data['media_name']			= '';
			$data['media_url'] 	   		= '';
			$data['media_feed_text'] 	= '';
			$data['status']      		= '';
			
		}
		$data['heading']	= ($id != null) ? 'Edit Social Feed' : 'Add Social Feed'.' | Administrator';
		$data['title']	= ($id != null) ? 'Edit Social Feed' : 'Add Social Feed'.' | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('social_media_feed_header');
		$this->admin_header->index();
		$this->load->view('edit_social_feed', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	} 

	// Insert & Update Admin User Role
	function insert_update_social_media_feed()
	{
		$social_mediafeed_id = $this->input->post('feed_id');
		$continue = $this->input->post('btn_continue');

		/* $error_config = array(
			array(
				'field' => 'user-role-name',
				'label'	=> 'User Role Name',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'user-role',
				'label'	=> 'User Role',
				'rules'	=> 'required'
			)
		);

		$this->form_validation->set_rules($error_config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('social_media_feed/edit_social_media_feed');
		}
		else
		{ */
			if (empty($social_mediafeed_id))
			{
				$this->Social_media_feed_model->insert_update_social_media_feed();
				$this->session->set_flashdata('success', 'Social Media Feed successfully Created.');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'Social_media_feed/edit_social_media_feed';
				}
				else
				{
					$url = 'Social_media_feed';
				}
			}
			else
			{
				$this->Social_media_feed_model->insert_update_social_media_feed($social_mediafeed_id);
				$this->session->set_flashdata('success', 'Social Media Feed Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'Social_media_feed/edit_social_media_feed/'.$social_mediafeed_id;
				}
				else
				{
					$url = 'Social_media_feed';
				}
			}
			redirect($url);
		//}
	}

	// Delete Admin User Role
	/* function delete_user_role()
	{
		$this->User_role_model->delete_user_role();
		$this->session->set_flashdata('success', 'User Role Successfully Deleted.');
	}

	// Delete multiple Admin user role
	function delete_selected_user_role()
	{
		$this->form_validation->set_rules(
			'table_records[]',
			'Row',
			'required',
			array(
				'required' => 'You must select at least one row!'
			)
		);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('user_role');
		}
		else
		{
			$this->User_role_model->delete_multiple_user_role();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('user_role');
		}
	} */
}
