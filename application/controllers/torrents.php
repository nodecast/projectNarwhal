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

	public function browse($page = 1) {
		if($page < 1)
			$page = 1;
		$off = ($page - 1) * 50;
	
		$data = array();
		$t = $this->torrentmodel->getTorrents(50, $off, null);
		$data['torrents'] = $t['data'];
		$data['results'] = $t['count'];
		$data['caticons'] = $this->config->item('category_icons');
		$data['categories'] = $this->config->item('categories');
		$data['ci'] =& get_instance();
		$data['page'] = $page;
		$data['off'] = $off;
		
		$this->load->view('torrents/browse', $data);
	}
}
