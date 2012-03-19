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
		if(!is_array($to)) {
			$to = array(new MongoId($to));
		} else {
			for($i = 0; $i < count($to); $i++) {
				$to[$i] = new MongoId($to[$i]);
			}
		}
		$message = array('owner' => $from, 'time' => time(), 'body' => $body);
		
		$conversation = array('owner' => $from, 'subject' => $subject, 'time' => time(), 'participants' => $to, 'messages' => array($message));
		$this->mongo->db->conversations->save($conversation);
		
		$this->load->model('alertmodel');
		foreach($to as $user) {
			$this->alertmodel->createAlert($user, '<a href="/messages/">You have one or more unread messages.</a>', 5);
		}
	}
	
	function getMessages($user, $inbox = true, $limit = 25, $skip = 0) {
		$key = 'messages_'.$user.'_'.$limit.'_'.$skip;
		
		if(($data = $this->mcache->get($key)) === FALSE) {
			if($inbox) {
				$query = array('participants' => new MongoId($user));
			} else {
				$query = array('owner' => new MongoId($user));
			}
			$result = $this->mongo->db->conversations->find($query)->sort(array('time' => -1));
			$count = $result->count();
			$result = $result->limit($limit)->skip($skip);
			$result = iterator_to_array($result);
			$data = array('data' => $result, 'count' => $count);
			$this->mcache->set($key, $data, $this->config->item('message_cache'));
		}
		return $data;
	}
}
?>
