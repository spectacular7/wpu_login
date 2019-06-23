<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('User_model');
		is_logged_in();
	}

	public function index()
	{
		$sEmail = $this->session->userdata('email');
		
		$data['title'] = 'My Profile';
		$data['user'] = $this->User_model->get_email_by_session($sEmail);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('user/index', $data);
		$this->load->view('templates/footer');
	}

	public function edit()
	{	
		$sEmail = $this->session->userdata('email');

		$data['title'] = 'Edit Profile';
		$data['user'] = $this->User_model->get_email_by_session($sEmail);
		
		$this->form_validation->set_rules('name', 'Name', 'required|trim');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer');	
		}else{
			$name = $this->input->post('name');
			$email = $this->input->post('email');

			//cek jika ada gambar yang akan diupload
			$upload_image = $_FILES['image']['name'];
			if ($upload_image) {
				$config['upload_path'] = './assets/img/profile/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']     = '2048';

				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) {
					$old_image = $data['user']['image'];
					if ($old_image != 'default.jpg') {
						$hapus = 'assets/img/profile/'. $old_image;
						$unlink = unlink(FCPATH .  'assets/img/profile/'. $old_image);
						if ($hapus == $unlink) {
							unlink(FCPATH .  'assets/img/profile/'. $old_image);
						}
					}

					$new_image = $this->upload->data('file_name');
					$datainsert['image'] =$new_image;
				}else{
					echo $this->upload->display_errors();
				}
			}

			$datainsert['name'] = $name;
			
			$this->User_model->update($email, $datainsert);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
			redirect('user');
		}
		
	}

	public function changepassword()
	{
		$sEmail = $this->session->userdata('email');

		$data['title'] = 'Change Password';
		$data['user'] = $this->User_model->get_email_by_session($sEmail);
		
		$this->form_validation->set_rules('current_password', 'Current password', 'required|trim');
		$this->form_validation->set_rules('newpassword1', 'New password', 'required|trim|min_length[3]|matches[newpassword2]');
		$this->form_validation->set_rules('newpassword2', 'Confirm New password', 'required|trim|min_length[3]|matches[newpassword1]');
		if ($this->form_validation->run() == false) {

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('user/changepassword', $data);
			$this->load->view('templates/footer');
		}else{
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('newpassword1');
			if (!password_verify($current_password, $data['user']['password'])) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
				redirect('user/changepassword');
			}else{
				if ($current_password == $new_password) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
					redirect('user/changepassword');	
				}else{
					$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

					$passdata['password'] = $password_hash;
					$sEmail = $this->session->userdata('email');
					$this->User_model->update_password($sEmail, $passdata);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed!</div>');
					redirect('user/changepassword');
				}
			}
		}
		
	}

}