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
	
	public function view_forum($forum, $page = 1)
	{
		if($page < 1)
			$page = 1;
		$off = ($page - 1) * $this->config->item('threads_perpage');
	
		$forum = $this->forumsmodel->getForum($forum);
		if(!$forum)
			show_404();

		$data = array();
		$data['forum'] = $forum;
		$data['perpage'] = $this->config->item('threads_perpage');
		$data['posts_pp'] = $this->config->item('posts_perpage');
		$data['off'] = $off;
		$data['page'] = $page;
		$return = $this->forumsmodel->getThreads($forum['_id'], $data['perpage'], $off);
		$data['threads'] = $return['data'];
		$data['results'] = $return['count'];
		$data['userid'] = $this->utility->current_user('_id');
		$this->load->view('forums/viewforum', $data);
	}
	
	public function view_thread($thread, $page = 1) {
		if($page < 1)
			$page = 1;
		$off = ($page - 1) * $this->config->item('posts_perpage');
		
		$thread = $this->forumsmodel->getThread($thread);
		if(!$thread)
			show_404();
	}
	
	public function catchup()
	{
		//TODO
	}
	
	public function newthread()
	{
		//TODO
	}
}
