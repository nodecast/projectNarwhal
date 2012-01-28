<?php
class AccountModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
		$this->load->library("utility");
	}

	/*
	If the login is correct, it will return the record of the user.
	If the login is incorrect, it will return null.
	*/
	function login($username, $password)
	{
	   $salt = $this->mongo->db->users->findOne(array("username" => $username), array('salt'));
	   if($salt == null || !isset($salt['salt']))
	       return null;
	    return $this->mongo->db->users->findOne(array("username" => $username, "password" => $this->utility->make_hash($password, $salt['salt'])));
		//Accessed by $this->templatemodel->somefunction() elsewhere.
	}

	/*
	Registers a user
	*/
	function register($username, $password, $email) {
		$salt = $this->utility->make_secret();
		//todo finish
		$this->mongo->db->users->save(array("username" => $username, "password" => $this->utility->make_hash($password, $salt), "email" => $email, "salt" => $salt));
	}
}
?>
