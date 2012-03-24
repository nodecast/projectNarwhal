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
			$to = array($to);
		}
		$message = array('owner' => $from, 'time' => time(), 'body' => $body);
		$to[] = $from;
		
		$conversation = array('owner' => $from, 'subject' => $subject, 'time' => time(), 'participants' => $to, 'messages' => array($message), 'read' => array($from));
		$this->mongo->db->conversations->save($conversation);
		
		$this->load->model('alertmodel');
		foreach($to as $user) {
			if($user != $from)
				$this->alertmodel->createAlert($user, '<a href="/messages/">You have one or more unread messages.</a>', 5);
		}
	}
	
	/*
	Removes a user from a conversations ---- basically deletes it for that person
	*/
	function removeUserFromConversation($convo, $user) {
		$this->mongo->db->conversations->update(array('_id' => new MongoId($convo)), array('$pull' => array('participants' => new MongoId($user))));
	}
	
	/*
	Gets the messages for a given user. If $inbox is false, it'll return the sentbox.
	*/
	function getMessages($user, $inbox = true, $limit = 25, $skip = 0) {
		$key = 'messages_'.$user.'_'.$limit.'_'.$skip.'_'.$inbox;
		
		if(($data = $this->mcache->get($key)) === FALSE) {
			if($inbox) {
				$query = array('participants' => new MongoId($user));
			} else {
				$query = array('owner' => new MongoId($user), 'participants' => new MongoId($user));
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
	
	/*
	Gets a specific message by id. If '$to' is given, it will only return the message if the user given in $to is participating in the message.
	*/
	function getMessage($_id, $to = '', $cache = true) {
		$query = array('_id' => new MongoId($_id));
		if($to)
			$query['participants'] = new MongoId($to);
			
		if($cache) {
			if(($data = $this->mcache->get('messages_view_'.$_id.'_'.$to)) === FALSE) {
				$data = $this->mongo->db->conversations->findOne($query);
				$this->mcache->set('messages_view_'.$_id.'_'.$to, $data, $this->config->item('message_cache'));
			}
		} else {
			$data = $this->mongo->db->conversations->findOne($query);
		}
		
		return $data;
	}
}
?>
