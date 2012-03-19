<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alerts extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('alertmodel');
		$this->utility->enforce_login();
	}

	public function index()
	{
		redirect('/');
	}
	
	public function delete($id = '') {
		if($id == '')
			redirect('/');
		
		$this->alertmodel->deleteAlert($this->session->userdata('_id'), $id);
		redirect('/');
	}
}
