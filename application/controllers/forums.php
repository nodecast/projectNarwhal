<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forums extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->utility->enforce_login();
		$this->load->model('forumsmodel');
	}

	public function index()
	{
		$data = array();
		$data['forums'] = $this->forumsmodel->getForums();
		$data['userid'] = $this->utility->current_user('_id');
		$this->load->view('forums/list', $data);
	}
	
	public function view($forum, $thread = null)
	{
		$forum = $this->forumsmodel->getForum($forum);
		if(!$forum)
			show_404();
		if($thread) {
			$thread = $this->forumsmodel->getThread($thread);
			if(!$thread)
				show_404();
		}

		if($thread) {
			$data = array();
			$this->load->view('forums/viewthread', $data);
		} else {
			$data = array();
			$this->load->view('forums/viewforum', $data);
		}
	}
	
	public function catchup()
	{
		//TODO
	}
}
