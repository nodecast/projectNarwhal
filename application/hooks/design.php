<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Design extends CI_Controller {
	function __construct()
	{	
		parent::__construct();
	}

	function header() {
		if($this->utility->logged_in())
			$this->privateheader();
		else
			$this->publicheader();
	}

	function footer() {
		if($this->utility->logged_in())
			$this->privatefooter();
		else
			$this->publicfooter();
	}

	function publicheader() {
		$this->load->view("design/publicheader");
	}

	function privateheader() {
		$this->load->view("design/privateheader");
	}

	function publicfooter() {
		$data['email'] = $this->config->item("contact_email");
		$this->load->view("design/publicfooter", $data);
	}

	function privatefooter() {
		$this->load->view("design/privatefooter");
	}
}

