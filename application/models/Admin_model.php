<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	public $user_table = 'user';
	public $email = 'email';

	function __construct()
    {
        parent::__construct();
    }

    function get_email_by_session($email)
    {	
    	$this->db->where($this->email, $email);
        return $this->db->get($this->user_table)->row_array();
    }

    function get_user_access_menu($data)
    {	
    	$this->db->where($data);
        return $this->db->get('user_access_menu')->num_rows();
    }

    function get_role_by_id($role_id)
    {	
    	$this->db->where('role_id', $role_id);
        return $this->db->get('user_role')->row_array();
    }

	function get_usrmenu()
    {	
    	$this->db->where('id !=', 1);
        return $this->db->get('user_menu')->result_array();
    }

    function get_all_user_role()
    {	
    	return $this->db->get('user_role')->result_array();
    }

    function insert_user_access_menu($data)
    {	
    	$this->db->insert('user_access_menu', $data);
    } 

    function delete_user_access_menu($data)
    {	
    	$this->db->delete('user_access_menu', $data);
    }    


}