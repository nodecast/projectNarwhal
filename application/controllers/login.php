<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('accountmodel');
	}

	public function index()
	{  
		if($this->utility->logged_in()) {
			// they shouldn't be doing that!
			redirect("/");
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'username', 'required|callback_check_login');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
		
		if($this->form_validation->run() == false) {
			$data['redirect'] = $this->session->flashdata('login_redirect'); // redirect on success, defaults to private index
			$this->load->view('login/login', $data);
		} else {
			$this->session->set_userdata($this->user_data);
			$this->session->set_userdata('logged_in', true);
			$redir = $this->input->post('redirect');
			redirect($redir ? $redir : "");
		}
	}
	
	public function check_login($name) {
		$this->user_data = $this->accountmodel->login($this->input->post('username'), $this->input->post('password'));
		if($this->user_data) {
			return true;
		}
		$this->form_validation->set_message('check_login', 'Invalid username or password');
		return false;
	}
}
