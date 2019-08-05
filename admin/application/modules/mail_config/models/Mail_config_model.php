<?php
/**
 * Mail Configuration Models
 *
 * @category Model
 * @package  Mail Configuration
 * @author   shiva
 * Created at:  12-jun-2018
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mail_config_model extends CI_Model
{
	/**
   	* Get Mail Configration
   	* return output as stdClass Object array
   	*/

  	function get_mail_config_details($website_id)
  	{
    	$this->db->select('*');
		$this->db->where('website_id', $website_id);
		$query = $this->db->get('mail_configuration');
    	$records = array();
		if ($query->num_rows() > 0) :
      		foreach ($query->result() as $row) :
        		$records[] = $row;
      		endforeach;
    	endif;
		return $records;
  	}

	//Inser Update Mail Config
  	function insert_update_mail_config($id = NULL)
  	{
		$website_id   	  = $this->input->post('website_id');
		$mail_status	 = $this->input->post('menu-status');
		$mail_status 	 = (isset($mail_status)) ? '1': '0';

    	if ($id == NULL) :

      		// insert data
  			$insert_data = array(
				'website_id' => $website_id,
  				'host' 	   => htmlspecialchars_decode(trim(htmlentities($this->input->post('host_name')))),
  				'port'  	   => htmlspecialchars_decode(trim(htmlentities($this->input->post('port_no')))),
  				'email'   	  => htmlspecialchars_decode(trim(htmlentities($this->input->post('user_email')))),
  				'password'   => htmlspecialchars_decode(trim(htmlentities($this->input->post('password')))),
  				'mail_from'  => htmlspecialchars_decode(trim(htmlentities($this->input->post('mail_from')))),
  				'status'     => $mail_status,
  				'created_at' => date('m-d-Y')
  			);

      		// Insert into Mail Configration 
      		return $this->db->insert('mail_configuration', $insert_data);

    	else :

      		// Update data
  			$update_data = array(
  				'host' 	  => htmlspecialchars_decode(trim(htmlentities($this->input->post('host_name')))),
  				'port'      => htmlspecialchars_decode(trim(htmlentities($this->input->post('port_no')))),
  				'email'   	 => htmlspecialchars_decode(trim(htmlentities($this->input->post('user_email')))),
  				'password'  => htmlspecialchars_decode(trim(htmlentities($this->input->post('password')))),
  				'mail_from' => htmlspecialchars_decode(trim(htmlentities($this->input->post('mail_from')))),
  				'status'    => $mail_status
  			);

      		// Update into Mail Configration 
			$this->db->where(array('id' => $id, 'website_id' => $website_id));
			return $this->db->update('mail_configuration', $update_data);
	
    	endif;
  	}
}
