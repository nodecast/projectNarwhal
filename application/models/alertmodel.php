<?php
class AlertModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}

	/*
	Creates a new alert for user '$id'
	
	Note about types:
		Type 0 is the default.
		If you specify a type != 0, if an alert with that type already exists, this one will not be added
		(Useful so you don't have 300000 pm messages)
		
	Reserved Types:
		1 - PM alert
	*/
	function createAlert($id, $body, $type = 0) {
		if($type != 0) {
			$alerts = $this->getAlerts($id);
			foreach($alerts as $alert) {
				if($alert['type'] == $type)
					return;
			}
		}
		
		$alert = array('_id' => new MongoId(), 'body' => $body, 'type' => $type);
		$data = $this->mongo->db->users->update(array('_id' => new MongoId($id)), array('$push' => array('alerts' => $alert)));
		$this->mcache->delete('user_'.$id.'_alerts');
		//TODO ping user on IRC
	}
	
	/*
	Gets alerts for user '$id'
	*/
	function getAlerts($id, $cache = true) {
		if($cache) {
			if(!($alerts = $this->mcache->get('user_'.$id.'_alerts'))) {
				$data = $this->mongo->db->users->findOne(array('_id' => new MongoId($id)));
				$alerts = $data['alerts'];
				$this->mcache->set('user_'.$id.'_alerts', $alerts, $this->config->item('alert_cache'));
			}
			return $alerts;
		} else {
			$data = $this->mongo->db->users->findOne(array('_id' => new MongoId($id)));
			return $data['alerts'];
		}
	}
}
?>
