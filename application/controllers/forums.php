<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forums extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->utility->enforce_login();
		$this->load->model('forumsmodel');
		$this->load->library('textformat');
	}

	public function index()
	{
		$this->utility->page_title('Forums');
		
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
		$this->forumsmodel->markForumAsRead($forum['_id'], $this->utility->current_user('_id'));
		$this->utility->page_title('Forums > '.$forum['name']);

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
		$data['catchuptime'] = $this->utility->current_user('catchuptime');
		$this->load->view('forums/viewforum', $data);
	}
	
	public function view_thread($thread, $page = 1) {
		if($page < 1)
			$page = 1;
		$off = ($page - 1) * $this->config->item('posts_perpage');
		
		$thread = $this->forumsmodel->getThread($thread);
		if(!$thread)
			show_404();
		$this->forumsmodel->markForumAsRead($thread['forum'], $this->utility->current_user('_id'));
		
		$forum = $this->forumsmodel->getForum($thread['forum']);
		$posts = $this->forumsmodel->getPosts($thread['_id']);
		$this->utility->page_title('Forums > '.$forum['name'].' > '.$thread['name']);
		
		$data = array();
		$data['forum'] = $forum;
		$data['thread'] = $thread;
		$data['perpage'] = $this->config->item('posts_perpage');
		$data['page'] = $page;
		$data['posts'] = $posts['data'];
		$data['count'] = $posts['count'];
		$this->load->view('forums/viewthread', $data);
	}
	
	public function catchup() {
		$this->forumsmodel->catchup($this->utility->current_user('_id'));
		redirect('/forums/');
	}
	
	public function new_thread($forum) {
		$forum = $this->forumsmodel->getForum($forum);
		if(!$forum)
			show_404();
		$this->utility->page_title('New Thread');
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
		$this->form_validation->set_rules('title', 'title', 'required|max_length[60]');
		$this->form_validation->set_rules('body', 'body', 'required|max_length['.$this->config->item('max_bytes_per_post').']');
		
		if(!$this->form_validation->run()) {
			$data = array();
			$data['forum'] = $forum;
			$data['preview'] = false;
			$this->load->view('forums/newthread', $data);
		} else {
			$thread = $this->forumsmodel->createThread($forum['_id'], $this->utility->current_user('_id'), $this->input->post('title'), $this->input->post('body'));
			redirect('/forums/view_thread/'.$thread);
		}
	}
}
