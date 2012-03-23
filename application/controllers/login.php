<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('accountmodel');
		$this->load->model('authtokenmodel');
		$this->utility->page_title('Login');
	}

	public function index()
	{  
		if($this->utility->logged_in()) {
			// they shouldn't be doing that!
			redirect("/");
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'username', 'required|callback__check_login|callback__check_enabled');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
		
		if($this->form_validation->run() == false) {
			$data['redirect'] = $this->session->flashdata('login_redirect'); // redirect on success, defaults to private index
			$this->load->view('login/login', $data);
		} else {
			$expiretime = ($this->input->post('remember_me'))? time() + (60 * 60 * 24 * 7 * 2): time() + (60 * 60 * 24);

			$authtoken = $this->authtokenmodel->createTokenForUser($this->user_data['_id'], $expiretime);

			$this->session->set_userdata('authtoken', $authtoken);
			$this->session->set_userdata('logged_in', true);
			$redir = $this->input->post('redirect');
			redirect($redir ? $redir : "");
		}
	}
	
	public function _check_login($name) {
		$this->user_data = $this->accountmodel->login($this->input->post('username'), $this->input->post('password'));
		if($this->user_data) {
			return true;
		}
		$this->form_validation->set_message('_check_login', 'Invalid username or password');
		return false;
	}
	public function _check_enabled($name) {
		$this->form_validation->set_message('_check_enabled', 'Your account is disabled.');
		return ($this->user_data['enabled'] == true);
	}
}
