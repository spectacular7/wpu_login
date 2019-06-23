<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Menu_model');
		is_logged_in();
	}
	
	public function index()
	{	
		$sEmail = $this->session->userdata('email');

		$data['title'] = 'Menu Management';
		$data['user'] = $this->Menu_model->get_email_by_session($sEmail);
		$data['menu'] = $this->Menu_model->get_all_user_menu();

		$this->form_validation->set_rules('menu', 'Menu', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('menu/index', $data);
			$this->load->view('templates/footer');	
		}else{
			$data = [
				'menu' => $this->input->post('menu')
			];

			$this->Menu_model->insert_user_menu($data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
			redirect('menu');
		}
	}

	public function subMenu()
	{
		$this->load->model('Menu_model', 'menu');
		$sEmail = $this->session->userdata('email');
		
		$data['title'] = 'Submenu Management';
		$data['user'] = $this->Menu_model->get_email_by_session($sEmail);
		$data['subMenu'] = $this->menu->getSubmenu();
		$data['menu'] = $this->Menu_model->get_all_user_menu();

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('menu_id', 'Menu_id', 'required');
		$this->form_validation->set_rules('url', 'Url', 'required');
		$this->form_validation->set_rules('icon', 'Icon', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('menu/submenu', $data);
			$this->load->view('templates/footer');
		}else{
			$data = [
				'title' => $this->input->post('title'),
				'menu_id' => $this->input->post('menu_id'),
				'url' => $this->input->post('url'),
				'icon' => $this->input->post('icon'),
				'is_active' => $this->input->post('is_active')
			];
			$this->Menu_model->insert_sub_user_menu($data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Submenu added!</div>');
			redirect('menu/subMenu');
		}
	}


}