<?php
/**
 * Track Mail
 * Created at : 24-July-2019
 * Author : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Track_mail extends MX_Controller
{
	function __construct()
  	{
        parent::__construct();		
		$this->load->model('Track_mail_model');		
    }

//update track Mail
    function track_mail_update($track_code)
    {
        $this->Track_mail_model->update_track_code($track_code);
    }
}