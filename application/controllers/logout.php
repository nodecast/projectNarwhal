<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{  
		$this->utility->enforce_login();
		$this->session->sess_destroy();
		redirect("/");
	}
}
