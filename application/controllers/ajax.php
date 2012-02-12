<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
	}

	public function upload_form($id = -1)
	{
		if($id < 0 || $id > count($this->config->item('categories')))
			return;
			
		$data = array();
		$data['categories'] = $this->config->item('categories');
		$data['categoryID'] = $id;
		$data['category'] = $data['categories'][$id];
		$data['metadata'] = $this->config->item('metadata');
		
		$this->load->view('ajax/upload_form.php', $data);
	}
}
