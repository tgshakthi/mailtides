<?php
/**
 * Admin User Profile
 *
 * @category class
 * @package  Admin User Profile
 * @author   Saravana
 * Created at:  14-May-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_user_profile extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_user_profile_model');
		$this->load->module('admin_header');
		$this->load->library('upload');
	}

	// Display Admin User Profile Details by @param

	function profile($user_id)
	{
		$get_profile_details = $this->Admin_user_profile_model->get_profile($user_id);

		if (!empty($get_profile_details))
		{
			foreach($get_profile_details as $get_profile_detail)
			{
				$data['email'] = $get_profile_detail->email;
				$data['role_name'] = $get_profile_detail->user_role_name;
				$data['website_ids'] = explode(',', $get_profile_detail->website_id);
			}
		}
		else
		{
			$data['email'] = '';
			$data['role_name'] = '';
			$data['website_ids'] = '';
		}

		$user = $this->Admin_user_profile_model->get_admin_userby_id($user_id);
		if (!empty($user))
		{
			$data['id'] = $user[0]->id;
			$data['firstName'] = $user[0]->first_name;
			$data['lastName'] = $user[0]->last_name;
			$data['username'] = $user[0]->username;
			$data['password'] = $user[0]->password;
			$data['email'] = $user[0]->email;
			$data['user_image'] = $user[0]->user_image;
			$data['gender'] = $user[0]->gender;
			$data['user_role_id'] = $user[0]->user_role_id;
			$data['website_id'] = $user[0]->website_id;
		}
		else
		{
			$data['id'] = '';
			$data['firstName'] = '';
			$data['lastName'] = '';
			$data['username'] = '';
			$data['password'] = '';
			$data['email'] = '';
			$data['user_image'] = '';
			$data['gender'] = '';
			$data['user_role_id'] = '';
			$data['website_id'] = '';
		}

		$data['table'] = $this->get_table($user_id);
		$data['profile_heading'] = 'Edit User';
		$data['ImageUrl'] = $this->admin_header->image_url();
		$data['user_role_options'] = $this->Admin_user_profile_model->get_user_role();
		$data['website_options'] = $this->Admin_user_profile_model->get_websites();
		$data['heading'] = 'User Profile';
		$data['title'] = "Admin User Profile | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('admin_user_profile_header');
		$this->admin_header->index();
		$this->load->view('profile', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table
	function get_table($user_id)
	{
		$user_recent_activities = $this->Admin_user_profile_model->user_recent_activity($user_id);
		if (!empty($user_recent_activities))
		{
			$i = 1;
			foreach ($user_recent_activities as $user_recent_activity)
			{
				if ($user_id != 1) :
					$website_name = $user_recent_activity->website_name;
				else :
					$website_name = ' - ';
				endif;

				$this->table->add_row(
					$i,
					$user_recent_activity->login_at,
					$user_recent_activity->ip_address,
					$website_name
				);

				$i++;
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
			'S.No',
			'Last login at',
			'Ip Address',
			'Website'
		));

		return $this->table->generate();
	}

	// Insert & Update Admin User Profile

	function insert_update_user()
	{
		$id = $this->input->post('id');
		$error_config = array(
			array(
				'field' => 'first-name',
				'label' => 'First Name',
				'rules' => 'required'
			) ,
			array(
				'field' => 'last-name',
				'label' => 'Last Name',
				'rules' => 'required'
			) ,
			array(
				'field' => 'user-name',
				'label' => 'Username',
				'rules' => 'required'
			) ,
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			) ,
			array(
				'field' => 'email',
				'label' => 'User Role',
				'rules' => 'required'
			) ,
			array(
				'field' => 'user-role',
				'label' => 'User Role',
				'rules' => 'required'
			) ,
			array(
				'field' => 'websites[]',
				'label' => 'Website',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('admin_user_profile/profile/' . $id);
		}
		else
		{
			if (empty($id))
			{
				$this->Admin_user_profile_model->insert_update_user_data();
				$this->session->set_flashdata('success', 'User successfully Created.');
				$url = 'admin_user_profile/profile/' . $id;
			}

			else
			{
				$this->Admin_user_profile_model->insert_update_user_data($id);
				$this->session->set_flashdata('success', 'User Successfully Updated.');
				$url = 'admin_user_profile/profile/' . $id;
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

	// Delete multiple Admin users

	function delete_selected_user()
	{
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('admin_user');
		}
		else
		{
			$this->Admin_user_profile_model->delete_multiple_user();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('admin_user');
		}
	}

	// User Recent Activity

	function user_recent_activity()
	{
	}
}
