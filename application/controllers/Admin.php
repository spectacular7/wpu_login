<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Admin_model');
		is_logged_in();
	}

	public function index()
	{
		$sEmail = $this->session->userdata('email');
		$data['title'] = 'Dashboard';
		$data['user'] = $this->Admin_model->get_email_by_session($sEmail);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer');
	}

	public function role()
	{
		$sEmail = $this->session->userdata('email');
		
		$data['title'] = 'Role';
		$data['user'] = $this->Admin_model->get_email_by_session($sEmail);
		$data['role'] = $this->Admin_model->get_all_user_role();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/role', $data);
		$this->load->view('templates/footer');
	}

	public function roleAccess($role_id)
	{
		$sEmail = $this->session->userdata('email');

		$data['title'] = 'Role Access';
		$data['user'] = $this->Admin_model->get_email_by_session($sEmail);
		$data['role'] = $this->Admin_model->get_role_by_id($role_id);
		$data['menu'] = $this->Admin_model->get_usrmenu();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/role_Access', $data);
		$this->load->view('templates/footer');
	}

	public function changeaccess()
	{
		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];

		$result = $this->Admin_model->get_user_access_menu($data);
		if ($result<1) {
			$this->Admin_model->insert_user_access_menu($data);
		}else{
			$this->Admin_model->delete_user_access_menu($data);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
	}

}