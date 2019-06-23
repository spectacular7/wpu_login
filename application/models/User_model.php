<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	public $user_table = 'user';
	public $email = 'email';

	function get_email_by_session($email)
	{	
    	$this->db->where($this->email, $email);
        return $this->db->get($this->user_table)->row_array();
	}

	function update($email, $data)
    {
        $this->db->where($this->email, $email);
        $this->db->update($this->user_table, $data);
    }

    function update_password($email, $data)
    {
        $this->db->where($this->email, $email);
        $this->db->update($this->user_table, $data);
    }
}