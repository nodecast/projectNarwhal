<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file'));
		$this->load->model('usermodel');
		$this->utility->enforce_login();
	}

	public function index()
	{
		redirect('/');
	}

	public function view($id = -1) {
		$this->usermodel->buildpercentile(0);
		if($id == -1)
			$id = $this->session->userdata('id'); 

		$data['user'] = $this->usermodel->getData(intval($id), false); //don't cache user view
		$data['view'] = $data['user']['paranoia'];
		if($id == $this->session->userdata('id'))
			$data['view'] = -1;
		if($this->usermodel->isStaff($this->session->userdata('id')))
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
		
		
		if($data['user'])
			$this->load->view('user/view', $data);
		else
			$this->load->view('user/view_dne');
	}
}
