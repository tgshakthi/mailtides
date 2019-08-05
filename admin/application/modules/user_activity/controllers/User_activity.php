<?php
/**
 * Admin User Activity
 *
 * @category class
 * @package  Admin User Activity
 * @author   Saravana
 * Created at:  14-May-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_activity extends MX_Controller
{

	// Constructor

	function __construct()
	{
		parent::__construct();
		$this->load->model('User_activity_model');
	}

	/**
	 * Store user logged in details
	 * @param user_id
	 */

	 function user_login($user_id)
	 {
		 $this->User_activity_model->logged_in_at($user_id);
	 }

	 /**
	 * Store user website
	 * @param web_id
	 */

	 function website_id($web_id)
	 {
		 $this->User_activity_model->website_log($web_id);
	 }
}
