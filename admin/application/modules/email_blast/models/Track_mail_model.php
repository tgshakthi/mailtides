<?php
/**
 * Email Blast Model
 * Created at : 23-July-2019
 * Author : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Track_mail_model extends CI_Model
{
    private $table_name = 'email_blast_users';
    private $table_track = 'email_track';

    // Update Track Code
    function update_track_code($track_code)
    {
        $update_data = array(
            'status' => '1'
        );

        
        $this->db->where('track_code', $track_code);
        $this->db->update($this->table_track, $update_data);
    }

}
