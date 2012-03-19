<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('messagesmodel');
		$this->utility->enforce_login();
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
		
		$data = array();
		$data['box'] = array('this' => ($inbox ? 'Inbox' : 'Sent'), 'other' => ($inbox ? 'Sent' : 'Inbox'), 'other_url' => '/messages/browse/'.($inbox ? 'sent' : 'inbox'));
		$this->load->view('messages/browse', $data);
	}
}
