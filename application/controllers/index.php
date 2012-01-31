<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{  
		if($this->utility->logged_in()) {
			$this->load->model('newsmodel');

			$data = array();
			$data['user'] = $this->session->all_userdata();
			$data['news'] = $this->newsmodel->getNews();

			$this->load->view('index/privateindex', $data);
		} else {
			$this->load->view('index/publicindex');
		}
	}
}
