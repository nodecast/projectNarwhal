<?php
class AccountModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
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
	function register($username, $password, $email, $invitedby) {
		//TODO finish
		$data = array();
		$data['username'] = $username;
		$data['salt'] = $this->utility->make_secret();
		$data['password'] = $this->utility->make_hash($password, $data['salt']);
		$data['email'] = $email;
		$data['invitedby'] = $invitedby;
		$data['upload'] = 0;
		$data['download'] = 0;
		$data['points'] = $this->config->item('free_points');
		$data['invites'] = 0;
		$data['enabled'] = 1;
		$data['torrent_pass'] = $this->utility->make_secret();
		$data['irc_key'] = $this->utility->make_secret(8);
		$data['freeleeches'] = array();
		$data['can_leech'] = 1;
		$data['lastaccess'] = 0;
		$data['avatar'] =  $this->config->item('default_avatar');
		$data['title'] = "";
		$data['joined'] = time();
		$data['paranoia'] = 0;
		$data['stylesheet'] = $this->config->item('stylesheets');
		$data['stylesheet'] = $data['stylesheet'][0];
		$classes = $this->config->item('classes');
		$data['class'] = $classes['USER'];
		$data['profile'] = "";
		$data['settings'] = $this->config->item('default_user_settings');
		$data['ratiohistory'] = array(array('time' => time(), 'ratio' => 0.0, 'required' => 0.0));
		$data['alerts'] = array();
		$data['catchuptime'] = 0;
		
		$this->mongo->db->users->save($data);
		
		return $data['_id'];
	}

	/*
	Checks to see if an invite exists, if so, returns row
	*/
	function invite_exists($code) {
		return $this->mongo->db->invites->findOne(array('code'=>$code));
	}

	/*
	Deletes an invite code
	*/
	function delete_invite($code) {
		$this->mongo->db->invites->remove(array('code'=>$code));
	}

	/*
	Checks to see if a username belongs to a user, if so, returns the data.
	*/
	function user_exists($name) {
		$data = $this->mongo->db->users->findOne(array("username"=> new MongoRegex('/^'.preg_quote($name).'$/i')));
		if($data)
			return $data;
		return false;
	}
	
	/*
	Checks to see if an email is in use, if so, returns the data of the user.
	*/
	function email_exists($email) {
		$data = $this->mongo->db->users->findOne(array("email"=> new MongoRegex('/^'.preg_quote($email).'$/i')));
		if($data)
			return $data;
		return false;
	}
}
?>
