<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('accountmodel');
	}

	public function index()
	{  
		if($this->utility->logged_in()) {
			//they shouldn't be registering!
			redirect("/");
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'username', 'trim|required|min_length[1]|max_length[20]|callback_check_username');
		$this->form_validation->set_rules('password', 'password', 'required|matches[passconf]|min_length[6]|max_length[40]');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_check_email');
		$this->form_validation->set_rules('rules', 'you will read the rules', 'callback_checkbox');
		$this->form_validation->set_rules('age', 'you are 13 or older', 'callback_checkbox');
		
		$this->form_validation->set_message('checkbox', 'You must check the box that says %s.');

		if($this->form_validation->run() == false) {
			$this->load->view('register/register');
		} else {
			$u = trim($this->input->post('username'));
			$p = $this->input->post('password');
			$e = $this->input->post('email');
			$this->accountmodel->register($u, $p, $e);
			$this->load->view('register/success');
		}
		/*
		//SERIOUSLY START CHECKING THIS TODO
		if($this->input->post('submit')) {
			$u = $this->input->post('username');
			$p = $this->input->post('password');
			if(!$u || !$p) {
				$data['error'] = "You must enter a username and password!";
			} else {
				$this->loginmodel->register($u, $p, "");
				redirect('/login');
			}
		}
		$this->load->view('register/register');
		*/
	}

	public function checkbox($d) {
		return !($d == false);
	}
	public function check_username($name) {
		// { "tag" : { "$regex" : "C#", "$options" : "-i" } }
		if(!preg_match('/^[a-z0-9_]+$/iD', $name)) {
			$this->form_validation->set_message('check_username', 'You did not enter a valid username.');
			return false;
		}
		if(!preg_match('/^[^0-9]/', $name)) {
			$this->form_validation->set_message('check_username', 'Your username may not start with a number.');
			return false;
		}
		// TODO make this more efficient
		if(count($this->mongo->db->users->findOne(array("username"=> new MongoRegex('/^'.preg_quote($name).'$/i'))))) {
			$this->form_validation->set_message('check_username', 'That username is taken.');
			return false;
		}
		return true;
	}
	public function check_email($email) {
		if(count($this->mongo->db->users->findOne(array("email"=> new MongoRegex('/^'.preg_quote($email).'$/i'))))) {
			$this->form_validation->set_message('check_email', 'There is already someone registered with that email address.');
			return false;
		}
		return true;
	}
}
