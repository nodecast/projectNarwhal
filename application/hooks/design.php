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
		// TODO no!
		$this->utility->update_user_data();

		$data['user'] = $this->session->all_userdata();
		$data['display']['ul'] = $this->utility->format_bytes($data['user']['ul']);
		$data['display']['dl'] = $this->utility->format_bytes($data['user']['dl']);
		$data['display']['ratio'] = $this->utility->ratio($data['user']['ul'], $data['user']['dl']);

		$this->load->view("design/privateheader", $data);
	}

	function publicfooter() {
		$data['email'] = $this->config->item("contact_email");
		$this->load->view("design/publicfooter", $data);
	}

	function privatefooter() {
		$data['email'] = $this->config->item("contact_email");
		$this->load->view("design/privatefooter", $data);
	}
}

