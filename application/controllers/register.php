<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('accountmodel');
		$this->utility->page_title('Register');
	}

	public function index()
	{  
		$this->load->helper('form');
		$this->load->library('form_validation');

		if($this->utility->logged_in()) {
			//they shouldn't be registering!
			redirect("/");
		}

		if($this->input->post('invite_submit')) {
			$this->form_validation->set_rules('code', 'code', 'trim|required|exact_length[32]|callback__check_invite');
		} else {
		$this->form_validation->set_rules('username', 'username', 'trim|required|min_length[1]|max_length[20]|callback__check_username');
		$this->form_validation->set_rules('password', 'password', 'required|matches[passconf]|min_length[6]|max_length[40]');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback__check_email');
		$this->form_validation->set_rules('rules', 'you will read the rules', 'callback__checkbox');
		$this->form_validation->set_rules('age', 'you are 13 or older', 'callback__checkbox');
		
		$this->form_validation->set_message('_checkbox', 'You must check the box that says %s.');
		$this->form_validation->set_message('matches', 'Your passwords do not match.');
		}
		$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');	

		if($this->form_validation->run() == false) {
			if(!$this->input->post('reg_submit') && !$this->config->item('open_registration')) {
				$this->load->view('register/closed');
			} else {
				$data['code'] = $this->input->post('code');
				$this->load->view('register/register', $data);
			}
		} else {
			if(!$this->input->post('reg_submit')) {
				$data['code'] = $this->input->post('code');
				$this->load->view('register/register', $data);
			} else {
				$u = trim($this->input->post('username'));
				$p = $this->input->post('password');
				$e = $this->input->post('email');
				if(!$this->config->item('open_registration')) {
					$i = $this->accountmodel->invite_exists($this->input->post('code'));
					$i = $this->accountmodel->delete_invite($i['code']);
				} else {
					$i = array('owner' => 0);
				}
				$id = $this->accountmodel->register($u, $p, $e, $i['owner']);
				$this->load->view('register/success');
				
				$this->utility->log($u.' ('.$id.') has registered.');
			}
		}
	}

	public function _checkbox($d) {
		return !($d == false);
	}
	public function _check_username($name) {
		// { "tag" : { "$regex" : "C#", "$options" : "-i" } }
		if(!preg_match('/^[a-z0-9_]+$/iD', $name)) {
			$this->form_validation->set_message('_check_username', 'You did not enter a valid username.');
			return false;
		}
		if(!preg_match('/^[^0-9]/', $name)) {
			$this->form_validation->set_message('_check_username', 'Your username may not start with a number.');
			return false;
		}
		// TODO make this more efficient
		if($this->accountmodel->user_exists($name)) {
			$this->form_validation->set_message('_check_username', 'That username is taken.');
			return false;
		}
		return true;
	}
	public function _check_email($email) {
		if($this->accountmodel->email_exists($email)) {
			$this->form_validation->set_message('_check_email', 'There is already someone registered with that email address.');
			return false;
		}
		return true;
	}
	public function _check_invite($code) {
		if(!$this->accountmodel->invite_exists($code)) {
			$this->form_validation->set_message('_check_invite', 'Invite not found.');
			return false;
		}
		return true;
	}
}
