<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('loginmodel');
	}

	public function index()
	{  
		$data['error'] = "";
		$data['redirect'] = $this->input->post('redirect', true); // redirect on success, defaults to private index
		if($this->input->post('submit')) {
			$u = $this->input->post('username');
			$p = $this->input->post('password');
			if(!$u || !$p) {
				$data['error'] = "You must enter a username and password!";
			} else {
				if(($user = $this->loginmodel->login($u, $p))) {
					$this->session->set_userdata($user);
					redirect('/');
					return;
				} else {
					$data['error'] = "Invalid username or password.";
				}
			}
		}
		$this->load->view('login/login', $data);
	}
}
