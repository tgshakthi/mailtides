<?php
/**
 * Admin User
 *
 * @category class
 * @package  Admin User
 * @author   Saravana
 * Created at:  13-Mar-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_user_model');
		$this->load->module('admin_header');
		$this->load->library('upload');
	}

	// Display all Admin Users in a table
	function index()
	{
		$data['table'] = $this->get_table();
		$data['title'] = "Admin User | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('admin_user_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table
	function get_table()
	{
		$users = $this->Admin_user_model->get_admin_users();
		if (isset($users) && $users != "")
		{
			foreach ($users as $user)
			{
				$anchor_edit = anchor(
					site_url('admin_user/add_edit_user/'.$user->id),
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
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record('.$user->id.', \''.base_url('admin_user/delete_user').'\')'
				));

				$cell = array(
					'class' => 'last',
					'data'  => $anchor_edit.' '.$anchor_delete
				);

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="'.$user->id.'">',
					ucwords($user->first_name),
					ucwords($user->last_name),
					$user->email,
					$cell
				);
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
			'First name',
			'Last name',
			'Email',
			'Action'
		));

		return $this->table->generate();
	}

	// Add & Edit Admin User
	function add_edit_user($id = null)
	{
		if ($id != null)
		{
			$user = $this->Admin_user_model->get_admin_userby_id($id);

			$data['heading']		= 'Edit User';
			$data['id']       	   	= $user[0]->id;
			$data['firstName'] 	   	= $user[0]->first_name;
			$data['lastName'] 	   	= $user[0]->last_name;
			$data['username'] 	   	= $user[0]->username;
			$data['password']      	= $user[0]->password;
			$data['email']         	= $user[0]->email;
			$data['user_image']    	= $user[0]->user_image;
			$data['gender']       	= $user[0]->gender;
			$data['user_role_id']	= $user[0]->user_role_id;
			$data['website_id']    	= $user[0]->website_id;
		}
		else
		{
			$data['heading']		= 'Add User';
			$data['id']       	   	= '';
			$data['firstName'] 	   	= '';
			$data['lastName'] 	   	= '';
			$data['username'] 	   	= '';
			$data['password']      	= '';
			$data['email']         	= '';
			$data['user_image']    	= '';
			$data['gender']        	= '';
			$data['user_role_id']	= '';
			$data['website_id']    	= '';
		}

		$data['httpUrl']						= $this->admin_header->host_url();
		$data['ImageUrl']          	= $this->admin_header->image_url();
		$data['user_role_options']	= $this->Admin_user_model->get_user_role();
		$data['website_options']   	= $this->Admin_user_model->get_websites();
		$data['title']             	= ($id != null) ? 'Edit User | Administrator' : 'Add User | Administrator';
		$this->load->view('template/meta_head', $data);
    	$this->load->view('admin_user_header');
		$this->admin_header->index();
		$this->load->view('add_edit_user', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Admin User
	function insert_update_user()
	{
		$id = $this->input->post('id');
		$continue = $this->input->post('btn_continue');

		$error_config = array(
			array(
				'field' => 'first-name',
				'label'	=> 'First Name',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'last-name',
				'label'	=> 'Last Name',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'user-name',
				'label'	=> 'Username',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'password',
				'label'	=> 'Password',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'email',
				'label'	=> 'User Role',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'user-role',
				'label'	=> 'User Role',
				'rules'	=> 'required'
			),
			array(
				'field'	=> 'websites[]',
				'label'	=> 'Website',
				'rules'	=> 'required'
			)
		);

		$this->form_validation->set_rules($error_config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('admin_user/add_edit_user');
		}
		else
		{
			if (empty($id))
			{
				$this->Admin_user_model->insert_update_user_data();
				$this->session->set_flashdata('success', 'User successfully Created.');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'admin_user/add_edit_user';
				}
				else
				{
					$url = 'admin_user';
				}
			}
			else
			{
				$this->Admin_user_model->insert_update_user_data($id);
				$this->session->set_flashdata('success', 'User Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'admin_user/add_edit_user/'.$id;
				}
				else
				{
					$url = 'admin_user';
				}
			}
			redirect($url);
		}
	}

	// Delete Admin user By Id
	function delete_user()
	{
		$this->Admin_user_model->delete_admin_user();
		$this->session->set_flashdata('success', 'User Successfully Deleted.');
	}

	// Remove Admin User Image
	function remove_admin_user_image()
	{
		$this->Admin_user_model->remove_image();
		echo '1';
	}

	// Delete multiple Admin users
	function delete_selected_user()
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
			redirect('admin_user');
		}
		else
		{
			$this->Admin_user_model->delete_multiple_user();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('admin_user');
		}
	}
}
