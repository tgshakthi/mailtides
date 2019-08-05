<?php
/**
 * Admin User Role
 *
 * @category class
 * @package  Admin User Role
 * @author   Saravana
 * Created at:  09-Apr-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class User_role extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('User_role_model');
		$this->load->module('admin_header');
    }

    // Display all Admin Groups in a table
    function index()
    {
		$data['table'] = $this->get_table();
		$data['title'] = "Admin User Role | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('user_role_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table
	function get_table()
	{
		$user_roles = $this->User_role_model->get_all_admin_user_roles();
		if (isset($user_roles) && $user_roles != "")
		{
			foreach ($user_roles as $user_role)
			{
				$anchor_edit = anchor(
					'user_role/add_edit_user_role/'.$user_role->user_role_id,
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
					'onclick' => 'return delete_record('.$user_role->user_role_id.', \''.base_url('user_role/delete_user_role').'\')'
				));

				$anchor_menu = anchor(
					'admin_menu/assign_menu/'.$user_role->user_role_id,
					'<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>',
					array(
						'data-toggle'			=> 'tooltip',
						'data-placement'		=> 'right',
						'data-original-title'	=> 'Menu'
					)
				);

				$cell = array(
					'class' => 'last',
					'data'  => $anchor_edit.' '.$anchor_delete.' '.$anchor_menu
				);

				if ($user_role->active === '1' )
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="'.$user_role->user_role_id.'">',
					ucwords($user_role->user_role_name),
					$status,
					$cell
				);
			}
		}

		// Table open
		$template = array(
			'table_open' => '<table
			id="datatable-responsive"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" cellspacing="0">'
		);

		$this->table->set_template($template);
		// Table heading row
		$this->table->set_heading(array(
			'<input type="checkbox" id="check-all" class="flat">',
			'User Role',
			'Status',
			'Action'
		));

		return $this->table->generate();
	}

	// Add & Edit Admin User Role
	function add_edit_user_role($id = null)
	{
		if ($id != null)
		{
			$user_role = $this->User_role_model->get_user_role_by_id($id);

			$data['user_role_id']	= $user_role[0]->user_role_id;
			$data['user_role_name']	= $user_role[0]->user_role_name;
			$data['user_role'] 	   	= $user_role[0]->user_role;
			$data['add'] 	   		= $user_role[0]->add;
			$data['edit']      		= $user_role[0]->edit;
			$data['view']         	= $user_role[0]->view;
			$data['delete']    		= $user_role[0]->delete;
			$data['publish']       	= $user_role[0]->publish;
			$data['active']			= $user_role[0]->active;
		}
		else
		{
			$data['user_role_id']	= '';
			$data['user_role_name']	= '';
			$data['user_role'] 	   	= '';
			$data['add'] 	   		= '';
			$data['edit']      		= '';
			$data['view']         	= '';
			$data['delete']    		= '';
			$data['publish']       	= '';
			$data['active']			= '';
		}
		$data['heading']	= ($id != null) ? 'Edit User Role' : 'Add User Role'.' | Administrator';
		$data['title']	= ($id != null) ? 'Edit User Role' : 'Add User Role'.' | Administrator';
		$this->load->view('template/meta_head', $data);
		$this->load->view('user_role_header');
		$this->admin_header->index();
		$this->load->view('add_edit_user_role', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Admin User Role
	function insert_update_user_role()
	{
		$user_role_id = $this->input->post('user_role_id');
		$continue = $this->input->post('btn_continue');

		$error_config = array(
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
			redirect('user_role/add_edit_user_role');
		}
		else
		{
			if (empty($user_role_id))
			{
				$this->User_role_model->insert_update_user_role_data();
				$this->session->set_flashdata('success', 'User Role successfully Created.');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'user_role/add_edit_user_role';
				}
				else
				{
					$url = 'user_role';
				}
			}
			else
			{
				$this->User_role_model->insert_update_user_role_data($user_role_id);
				$this->session->set_flashdata('success', 'User Role Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'user_role/add_edit_user_role/'.$user_role_id;
				}
				else
				{
					$url = 'user_role';
				}
			}
			redirect($url);
		}
	}

	// Delete Admin User Role
	function delete_user_role()
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
	}
}
