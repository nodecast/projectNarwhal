<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requests extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->utility->enforce_login();
	}

	public function index()
	{
		redirect('/requests/browse');
	}
	
	public function browse()
	{
		$this->load->view('requests/browse');
	}
}
