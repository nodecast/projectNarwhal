<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->utility->enforce_login();
		$this->load->model('messagesmodel');
		$this->load->helper('form');
	}

	public function index()
	{
		redirect('/messages/browse/');
	}
	
	public function browse($box = 'inbox', $page = 1) {
		if($box != 'inbox' && $box != 'sent')
			show_404();
		$inbox = $box == 'inbox';
		$this->utility->page_title($inbox ? 'Inbox' : 'Sent');
		if($page < 1)
			$page = 1;
		$off = ($page - 1) * $this->config->item('messages_perpage');
		
		$messages = $this->messagesmodel->getMessages($this->utility->current_user('_id'), $inbox, $this->config->item('messages_perpage'), $off);

		$data = array();
		$data['results'] = $messages['count'];
		$data['messages'] = $messages['data'];
		$data['perpage'] = $this->config->item('messages_perpage');
		$data['page'] = $page;
		$data['box'] = array('this' => ($inbox ? 'Inbox' : 'Sent'), 'other' => ($inbox ? 'Sent' : 'Inbox'), 'other_url' => '/messages/browse/'.($inbox ? 'sent' : 'inbox'));
		$this->load->view('messages/browse', $data);
	}
	
	public function delete() {
		$messages = $this->input->post('messages');
		$id = $this->session->userdata('_id');
		if($messages) {
			foreach($messages as $m) {
				$this->messagesmodel->removeUserFromConversation($m, $id);
			}
		}
		redirect('/messages/browse/');
	}
	
	public function send($_id = '') {
		$this->load->model('usermodel');
		$this->load->model('accountmodel');
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
		$this->form_validation->set_rules('to', 'to', 'required|callback__check_to');
		$this->form_validation->set_rules('subject', 'subject', 'required|max_length[50]');
		$this->form_validation->set_rules('body', 'body', 'required|max_length['.$this->config->item('max_bytes_per_message').']');
		
		if(!$this->form_validation->run()) {
			$user = false;
			if($_id) {
				$user = $this->usermodel->getData($_id);
				if($user)
					$user = $user['username'];
			}
			$this->utility->page_title('New Message');
			$data = array();
			$data['user'] = $user;
			$this->load->view('messages/new', $data);
		} else {
			$this->messagesmodel->createConversation($this->recipients, $this->session->userdata('_id'), $this->input->post('subject'), $this->input->post('body'));
			redirect('/messages/browse');
		}
	}
	
	public function _check_to($to) {
		$this->form_validation->set_message('_check_to', 'You need to enter at least one valid recipient.');
		$to = array_filter(explode(',', $to), 'trim');
		$this->recipients = array();
		foreach($to as $t) {
			$data = $this->accountmodel->user_exists(trim($t));
			if($data && ($this->session->userdata('_id') != $data['_id']))
				$this->recipients[] = $data['_id'];
		}
		return (count($this->recipients) > 0);
	}
}
