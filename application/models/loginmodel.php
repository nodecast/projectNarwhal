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
	   $salt = $this->mongo->db->users->findOne(array("username" => $username), array('salt'));
	   if($salt == null || !isset($salt['salt']))
	       return null;
	    return $this->mongo->db->users->findOne(array("username" => $username, "password" => $this->hashPassword($password, $salt['salt'])));
		//Accessed by $this->templatemodel->somefunction() elsewhere.
	}
	
	/*
	Returns the password hash for a given password
	*/
	function hashPassword($password, $usersalt)
	{
		//Mimics gazelle's hashing
		return sha1(md5($usersalt) . $password . sha1($usersalt) . $this->config->item("site_salt"));
	}
}
?>
