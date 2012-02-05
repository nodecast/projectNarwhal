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
		if($id == -1)
			$id = $this->session->userdata('id');

		$data['user'] = $this->usermodel->getData(intval($id), true);
		$data['display']['upload'] = $this->utility->format_bytes($data['user']['upload']);
		$data['display']['download'] = $this->utility->format_bytes($data['user']['download']);
		$data['display']['ratio'] = $this->utility->ratio($data['user']['upload'], $data['user']['download']);
		
		if($data['user'])
			$this->load->view('user/view', $data);
		else
			$this->load->view('user/view_dne');
	}
}
