<?php
/**
 * Admin User Activity Models
 *
 * @category Model
 * @package  Admin User Activity
 * @author   Saravana
 * Created at:  14-May-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_activity_model extends CI_Model
{
	/**
	 * Store Admin User logged in details
	 */
	 
	function logged_in_at($user_id)
	{
		$this->db->select('user_id');
		$this->db->where(array(
			'user_id' => $user_id,
			'session_id' => session_id()
		));
		$query = $this->db->get('admin_user_log');
		if ($query->num_rows() == 0)
		{
			$insert_data = array(
				'user_id' => $user_id,
				'session_id' => session_id() ,
				'ip_address' => $this->input->ip_address() ,
				'login_at' => date("F d, Y h:i:s A") ,
				'created_at' => date('m-d-Y H:i:s')
			);
			$this->db->insert('admin_user_log', $insert_data);
		}
	}

	function website_log($web_id)
	{
		$user_details = $this->session->userdata('logged_in');
		$user_id = $user_details['id'];
		$this->db->select('user_id');
		$this->db->where(array('session_id' => session_id(), 'user_id' => $user_id));
		$query = $this->db->get('admin_user_log');

		if ($query->num_rows() > 0)
		{
			$update_data = array('website_id' => $web_id);
			$this->db->where(array('session_id' => session_id(), 'user_id' => $user_id));
			$this->db->update('admin_user_log', $update_data);
		}
	}
}
