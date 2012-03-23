<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->CI =& get_instance();
	}

	public function index()
	{
		$this->CI->load->model('authtokenmodel');
		$this->utility->enforce_login();
		$this->session->sess_destroy();
		$this->CI->authtokenmodel->delete($this->CI->session->userdata('authtoken'));
		redirect("/");
	}
}
