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
}