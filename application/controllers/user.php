<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('usermodel');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->utility->enforce_login();
	}

	public function index()
	{
		redirect('/');
	}

	public function view($id = -1) {
		$this->usermodel->buildpercentile(0);
		if($id <= 0)
			$id = $this->utility->current_user('_id'); 

		$data['user'] = $this->usermodel->getData($id, false); //don't cache user view

		if(!$data['user']) {
			show_404();
		}
		
		$data['view'] = $data['user']['paranoia'];
		if($id == $this->utility->current_user('_id'))
			$data['view'] = -1;
		if($this->usermodel->isStaff($this->utility->current_user('_id')))
			$data['view'] = -2;
		$data['display']['upload'] = $this->utility->format_bytes($data['user']['upload']);
		$data['display']['download'] = $this->utility->format_bytes($data['user']['download']);
		$data['display']['ratio'] = $this->utility->ratio($data['user']['upload'], $data['user']['download']);
		$data['display']['class'] = $this->usermodel->getPermissions($id);
		$data['display']['class'] = $data['display']['class']['name'];
		
		$data['user']['uploads'] = $this->usermodel->numUploads($id);
		$data['user']['requests'] = $this->usermodel->numRequests($id); //filled
		$data['user']['posts'] = $this->usermodel->numPosts($id);
		
		$data['display']['join_date'] = $this->utility->format_datetime($data['user']['joined']);
		$data['display']['join_ago'] = $this->utility->time_diff_string($data['user']['joined']);
		$data['display']['seen_date'] = $this->utility->format_datetime($data['user']['lastaccess']);
		$data['display']['seen_ago'] = $this->utility->time_diff_string($data['user']['lastaccess']);
		
		$data['percent']['upload'] = $this->usermodel->getPercentile(0, $data['user']['upload']);
		$data['percent']['download'] = $this->usermodel->getPercentile(1, $data['user']['download']);
		$data['percent']['uploads'] = $this->usermodel->getPercentile(2, $data['user']['uploads']);
		$data['percent']['requests'] = $this->usermodel->getPercentile(3, $data['user']['requests']);
		$data['percent']['posts'] = $this->usermodel->getPercentile(4, $data['user']['posts']);
		$data['percent']['overall'] = $this->usermodel->overallPercentile($data['percent']['upload'], $data['percent']['download'], $data['percent']['uploads'], $data['percent']['requests'], $data['percent']['posts'], $data['user']['upload'], $data['user']['download']);
		$data['display']['ratiohistory'] = $data['user']['ratiohistory'];
		
		$this->utility->page_title($data['user']['username']);

		$this->load->view('user/view', $data);
	}

	function edit($id = -1) {
		$current_user = $this->utility->current_user();
		if (!(new MongoId($id) === $current_user['_id']))
			$this->utility->enforce_perm('site_users_edit');

		if (!$user = $this->usermodel->getData($id, false)) {
			$this->utility->page_title('User not found');
			$this->load->view('user/view_dne');
		} else {
			$this->form_validation->set_error_delimiters('<div class="error_message">', '</div>');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('avatar', 'Avatar', 'callback__avatar_check');

			if ($this->input->post('download_as_txt'))
				$user['settings']['download_as_txt'] = true;

			if ($this->input->post('email'))
				$user['email'] = $this->input->post('email');

			if ($this->input->post('irc_key'))
				$user['irc_key'] = $this->input->post('irc_key');

			if ($this->input->post('paranoia'))
				$user['paranoia'] = $this->input->post('paranoia');

			if ($this->input->post('avatar'))
				$user['avatar'] = $this->input->post('avatar');

			if ($this->form_validation->run() == FALSE) {
				$data = array();
				$data['user'] = $user;
				$this->load->view('user/edit', $data);
			} else {
				if (!$this->input->post('download_as_txt'))
					$user['settings']['download_as_txt'] = false;

				$this->mongo->db->users->save($user);
				redirect('user/view/'.$user['_id']);
			}
		}
	}

	function _avatar_check($avatar) {
		if ($this->utility->is_valid_image($avatar)) {
			return true;
		} else {
			$this->form_validation->set_message('_avatar_check', 'The %s field must contain a valid URL to a whitelisted image host.');
			return false;
		}
	}
}
