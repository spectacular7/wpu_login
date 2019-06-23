<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	public $user_table = 'user';
	public $user_token = 'user_token';
    public $email = 'email';
    public $token = 'token';


    function __construct()
    {
        parent::__construct();
    }

    function get_user_by_email($email)
    {
    	$this->db->where($this->email, $email);
        return $this->db->get($this->user_table)->row_array();
    }

    function getusr_by_emailNactive($email)
    {
    	$this->db->where([$this->email => $email, 'is_active' => 1]);
    	return $this->db->get($this->user_table)->row_array();	
    }

    function get_usrtoken_by_token($token)
    {
    	$this->db->where($this->token, $token);
        return $this->db->get($this->user_token)->row_array();
    }

    function insert_user($data)
    {
        $this->db->insert($this->user_table, $data);
    }

    function insert_token($data)
    {
        $this->db->insert($this->user_token, $data);
    }

    function isactive_update($email)
    {	
    	$this->db->set('is_active', 1);
        $this->db->where($this->email, $email);
        $this->db->update($this->user_table);
    }

    function password_update($email, $password)
    {	
    	$this->db->set('password', $password);
        $this->db->where($this->email, $email);
        $this->db->update($this->user_table);
    }

    function delete_token($email)
    {	
    	$this->db->delete('user_token', ['email' => $email]);
	}

	function delete_user($email)
    {	
    	$this->db->delete('user_table', ['email' => $email]);
	}
}