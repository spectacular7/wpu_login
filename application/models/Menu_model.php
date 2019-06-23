<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Menu_model extends CI_Model
	{
		public $user_table = 'user';
		public $email = 'email';

		public function getSubmenu()
		{
			// $query = "SELECT user_sub_menu.*, user_menu.menu  from user_sub_menu join user_menu on user_sub_menu.menu_id = user_menu.id ";
			// return $this->db->query($query)->result_array();
			$this->db->join('user_menu', 'user_sub_menu.menu_id=user_menu.id');
			$this->db->select('user_menu.menu, user_sub_menu.*');
			return $this->db->get('user_sub_menu')->result_array();
		}

		function get_email_by_session($email)
    	{	
	    	$this->db->where($this->email, $email);
	        return $this->db->get($this->user_table)->row_array();
    	}

    	function get_all_user_menu()
    	{	
	    	return $this->db->get('user_menu')->result_array();
    	}

    	function insert_user_menu($data)
		{	
			$this->db->insert('user_menu', $data);
		}

		function insert_sub_user_menu($data)
		{	
			$this->db->insert('user_sub_menu', $data);
		}
	}

?>