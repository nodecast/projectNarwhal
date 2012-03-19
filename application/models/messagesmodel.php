<?php
class MessagesModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}
	
	/*
	Creates a new conversation between $from and the users in $to. Supply 0 as $from to send it from the system.
	$subject is well, the subject, and $body is the body of the first message in the conversation.
	*/
	function createConversation($to, $from, $subject, $body) {
		if(!is_array($to))
			$to = array($to);
		$message = array('owner' => $from, 'time' => time(), 'body' => $body);
		
		$conversation = array('owner' => $from, 'subject' => $subject, 'time' => time(), 'participants' => $to, 'messages' => array($message));
		$this->mongo->db->conversations->save($conversation);
		
		$this->load->model('alertmodel');
		foreach($to as $user) {
			$this->alertmodel->createAlert($user, "You have one or more unread messages.", 5);
		}
	}
}
?>
