
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		//Code, such as making sure they're logged in. Will be run before any other function is accessed
		
	}

	public function index()
	{
		$this->load->library('utility');
		$this->utility->enforce_login();
		$this->mongo->db->users->insert(array("username"=>"Eskimo", "password"=>"weaksauce"));
		$user = $this->mongo->db->users->findOne(array("username"=>"Eskimo")); echo $user['password'];
	}
}
