<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Email_link_open_model extends MX_Controller
{
	function update_feedback($id, $route)
    {
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
        // Update Email Blast
		$this->db->where('id', $id);
        $this->db->update('email_sms_blast_users', array('email_link_open'=>'1', 'email_open_date'=> $date->format('m/d/Y')));		
        return $this->db->insert_id();
    }
	
	function update_sms_feedback($id,$provider_name)
    {
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
        // Update Email Blast
		$this->db->where('id', $id);
        $this->db->update('email_sms_blast_users', array('sms_link_open'=> '1', 'sms_open_date'=> $date->format('m/d/Y')));
        return $this->db->insert_id();
    }
	// Get Users
	function get_users($id)
	{
		$this->db->select('*');
		$this->db->where(
			array(
				'track_id' => $id
			)
		);
		$query = $this->db->get('email_tracks');
		$records = array();
		if ($query->num_rows() > 0 ) :
		   $records = $query->result();
		endif;
		return $records;		
	}
	
	function update_fb_sms_feedback($id)
    {
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
        // Update Email Blast
		$this->db->where('id', $id);
        $this->db->update('email_sms_blast_users', array('fb_link_open'=> '1', 'fb_open_date'=> $date->format('m/d/Y')));
        return $this->db->insert_id();
    }
	
	function update_fb_email_feedback($id)
    {
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
        // Update Email Blast
		$this->db->where('id', $id);
        $this->db->update('email_sms_blast_users', array('fb_email_link_open'=> '1', 'fb_email_link_open_date'=> $date->format('m/d/Y')));
        return $this->db->insert_id();
    }
	
	function update_dldc_email_feedback($id)
    {
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
        // Update Email Blast
		$this->db->where('id', $id);
        $this->db->update('email_sms_blast_users', array('dldc_email_link_open'=> '1', 'dldc_email_open_date'=> $date->format('m/d/Y')));
        return $this->db->insert_id();
    }
	
	function update_dldc_sms_feedback($id)
    {
		$date = new DateTime("now", new DateTimeZone('America/New_York') );
        // Update Email Blast
		$this->db->where('id', $id);
        $this->db->update('email_sms_blast_users', array('dldc_sms_open_link'=> '1', 'dldc_sms_open_date'=> $date->format('m/d/Y')));
        return $this->db->insert_id();
    }
	
	function get_campaign_category($website_id, $campaign_category_id)
	{
		$this->db->select('*');
        $this->db->where(array(
			'website_id' => $website_id,
			'id' => $campaign_category_id,
            'is_deleted' => '0'
        ));
        $query   = $this->db->get('campaign_category');
        $records = array();
        if ($query->num_rows() > 0):
            $records = $query->result_array();
        endif;
        return $records;
	}
}