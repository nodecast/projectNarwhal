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

		$data['error'] = "";
		$data['redirect'] = $this->session->flashdata('login_redirect'); // redirect on success, defaults to private index
		if($this->input->post('submit')) {
			$u = $this->input->post('username');
			$p = $this->input->post('password');
			if(!$u || !$p) {
				$data['error'] = "You must enter a username and password!";
			} else {
				if(($user = $this->accountmodel->login($u, $p))) {
					$this->session->set_userdata($user);
					$this->session->set_userdata('logged_in', true);
					$redir = $this->input->post('redirect');
					redirect($redir ? $redir : "/");
					return;
				} else {
					$data['error'] = "Invalid username or password.";
				}
			}
		}
		$this->load->view('login/login', $data);
	}
}
