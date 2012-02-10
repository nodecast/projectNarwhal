<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Torrents extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->utility->enforce_login();
		$this->load->model('torrentmodel');
	}

	public function index()
	{
		redirect('/torrents/browse/');
	}

	public function browse() {
		$data = array();
		$data['torrents'] = $this->torrentmodel->getTorrents();
		$data['caticons'] = $this->config->item('category_icons');
		$data['categories'] = $this->config->item('categories');
		$data['ci'] =& get_instance();
		
		$this->load->view('torrents/browse', $data);
	}
}
