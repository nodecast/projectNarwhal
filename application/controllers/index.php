<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{  
		if($this->utility->logged_in()) {
			$this->load->view('index/privateindex');
		} else {
			$this->load->view('index/publicindex');
		}
	}
}
