<?php

	function is_logged_in()
	{
		$ci = get_instance();
		if (!$ci->session->userdata('email')) {
			$ci->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You must log in to continue!</div>');
			redirect('auth');
		}else{
			$role_id = $ci->session->userdata('role_id');
			$menu = $ci->uri->segment(1);

			$queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
			$menu_id = $queryMenu['id'];

			$userAccess = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);

			if ($userAccess->num_rows() < 1) {
				redirect('auth/blocked');
			}
		}
	}

	function check_access($role_id, $menu_id)
	{
		$ci = get_instance();
		$result = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id ]);
		if ($result->num_rows() > 0) {
			return "checked = 'checked'";
		}
	}

?>