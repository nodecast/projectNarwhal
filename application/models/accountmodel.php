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
		//autoincrement, also, ewww
		$c = $this->mongo->db->command(array('findandmodify'=>'counters', 'query'=>array('name'=>'userid'), 'update'=>array('$inc'=>array('c'=>1))));
		//TODO finish
		$data = array();
		$data['id'] = $c['value']['c'];
		$data['username'] = $username;
		$data['salt'] = $this->utility->make_secret();
		$data['password'] = $this->utility->make_hash($password, $data['salt']);
		$data['email'] = $email;
		$data['ul'] = 0;
		$data['dl'] = 0;
		$data['points'] = $this->config->item('free_points');
		$data['invites'] = 0;
		$data['enabled'] = 0;
		$data['torrent_pass'] = $this->utility->make_secret();
		$data['irc_key'] = "";
		$data['freeleeches'] = array();
		$data['can_leech'] = 1;
		
		$this->mongo->db->users->save($data);
	}
}
?>
