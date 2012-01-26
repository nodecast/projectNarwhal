<?php
class LoginModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
		//Initialization code stuff here. Probably not really that needed
	}

	/*
	If the login is correct, it will return the record of the user.
	If the login is incorrect, it will return null.
	*/
	function login($username, $password)
	{
		return $this->mongo->db->users->findOne(array("username" => $username, "password" => $this->hashPassword($password)));
		//Accessed by $this->templatemodel->somefunction() elsewhere.
	}
	
	/*
	Returns the password hash for a given password
	*/
	// TODO change this
	function hashPassword($password)
    {
		return md5($password);
	}
}
?>
