<?php
/**
 * Admin User Profile Models
 *
 * @category Model
 * @package  Admin User Profile
 * @author   Saravana
 * Created at:  14-MaY-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_user_profile_model extends CI_Model

{
	/**
	 * Get User Profile
	 * return output as stdClass Object array
	 */
	function get_profile($id)
	{
		$sql_data = "SELECT a.id, a.email, b.user_role_name, GROUP_CONCAT(c.id) as website_id
		 	FROM " . $this->db->dbprefix('admin_user') . " a, " . $this->db->dbprefix('admin_user_role') . " b, " . $this->db->dbprefix('websites') . " c
		 	WHERE a.id = $id AND FIND_IN_SET(c.id, a.website_id)
		 	AND a.user_role_id = b.user_role_id";

		$query = $this->db->query($sql_data);
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get Admin user by id

	function get_admin_userby_id($id)
	{
		$this->db->select('*');
		$this->db->where(array(
			'id' => $id,
			'is_deleted' => '0'
		));
		$query = $this->db->get('admin_user');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get User Role

	function get_user_role()
	{
		$this->db->select(array(
			'user_role_id',
			'user_role_name'
		));
		$this->db->where_not_in('user_role_id', '1');
		$this->db->where(
			array('active'=> '1',
			  'is_deleted'=>'0' )
			);
		$this->db->order_by('user_role_name', 'ASC');
		$query = $this->db->get('admin_user_role');
	    $records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get Website details

	function get_websites()
	{
		$this->db->select(array(
			'id',
			'website_name'
		));
		$this->db->where(array(
			'status' => '1',
			'is_deleted' => '0'
		));
		$this->db->order_by('website_name', 'ASC');
		$query = $this->db->get('websites');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Inser Update user

	function insert_update_user_data($id = NULL)
	{

		$profile = $this->input->post('profile');

		// Configure Folder path for image upload for respective websites.
		$app_path = APPPATH;
		$find_path = 'admin' . DIRECTORY_SEPARATOR . 'application';
		$replace_path = 'assets' . DIRECTORY_SEPARATOR . 'images';
		$file_path = str_ireplace($find_path, $replace_path, $app_path);
		// Folder name
		$folder_name = 'admin-profile';

		// Create Folder
		if (!file_exists($file_path . $folder_name)) :
			mkdir($file_path . $folder_name);
			$upload_path = $file_path . $folder_name;
		else :
			$upload_path = $file_path . $folder_name;
		endif;

		if (empty($profile)) :
			// Configure Upload library
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'jpeg|jpg|png';	
			$this->upload->initialize($config);
			
			if ($this->upload->do_upload('profile')) :
				$user_image_name = $this->upload->data('file_name');
				// Admin user Profile folder path					
				$userImage = 'images' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $user_image_name;
			endif;
		else :
			$userImage = $profile;
		endif;

		$password = $this->input->post('password');
		$hiddenPass = $this->input->post('password-hidden');
		$websites = $this->input->post('websites');
		$httpUrl = $this->input->post('httpUrl');
		$website_id = implode(',', $websites);

		// New Password

		if ($hiddenPass == $password):
			$passwordNew = $password;
		else:
			$passwordNew = md5($password);
		endif;


		if ($id == NULL):

			// insert data

			$insert_data = array(
				'first_name' => $this->input->post('first-name') ,
				'last_name' => $this->input->post('last-name') ,
				'username' => $this->input->post('user-name') ,
				'password' => $passwordNew,
				'email' => $this->input->post('email') ,
				'gender' => $this->input->post('gender') ,
				'user_image' => $userImage,
				'user_role_id' => $this->input->post('user-role') ,
				'website_id' => $website_id,
				'created_at' => date('m-d-Y')
			);

			// Insert into Admin user

			return $this->db->insert('admin_user', $insert_data);
		else:

			// Update data

			$update_data = array(
				'first_name' => $this->input->post('first-name') ,
				'last_name' => $this->input->post('last-name') ,
				'username' => $this->input->post('user-name') ,
				'password' => $passwordNew,
				'email' => $this->input->post('email') ,
				'gender' => $this->input->post('gender') ,
				'user_image' => $userImage,
				'user_role_id' => $this->input->post('user-role') ,
				'website_id' => $website_id
			);

			// Update into Admin User

			$this->db->where('id', $id);
			return $this->db->update('admin_user', $update_data);
		endif;
	}

	// Delete Admin user

	function delete_admin_user()
	{
		$id = $this->input->post('id');
		$data = array(
			'is_deleted' => '1'
		);
		$this->db->where('id', $id);
		return $this->db->update('admin_user', $data);
	}

	// Delete mulitple Admin user

	function delete_multiple_user()
	{
		$users_id = $this->input->post('table_records');
		foreach($users_id as $user_id):
			$data = array(
				'is_deleted' => '1'
			);
			$this->db->where('id', $user_id);
			$this->db->update('admin_user', $data);
		endforeach;
	}

	// User Recent Activity

	function user_recent_activity($user_id)
	{
		if ($user_id != 1):
			$this->db->select(array(
				'ip_address',
				'login_at',
				'website_name'
			));
			$this->db->join('websites', 'websites.id = admin_user_log.website_id');
			$this->db->order_by('admin_user_log.id', 'DESC');
		else:
			$this->db->select(array(
				'ip_address',
				'login_at'
			));
			$this->db->order_by('id', 'DESC');
		endif;

		$this->db->from('admin_user_log');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}

	// Get Website details

	function get_website_by_id($website_id)
	{
		$this->db->select(array(
			'id',
			'website_name',
			'website_url'
		));
		$this->db->where(array(
			'status' => '1',
			'is_deleted' => '0',
			'id' => $website_id
		));
		$this->db->order_by('website_name', 'ASC');
		$query = $this->db->get('websites');
		$records = array();
		if ($query->num_rows() > 0):
			foreach($query->result() as $row):
				$records[] = $row;
			endforeach;
		endif;
		return $records;
	}
}
