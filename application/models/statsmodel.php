<?php
class StatsModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}

	function getEnabledUsers()
	{
		return $this->mongo->db->users->find(array('enabled'=>1))->count();
	}

	function getActiveUsers($time)
	{
		$time = time() - $time;
		return $this->mongo->db->users->find(array('enabled'=>1, 'lastaccess'=>array('$gt'=>$time)))->count();
	}

	function lastAccess($id)
	{
		$this->mongo->db->users->update(array('id'=> $id), array('$set' => array('lastaccess'=>time())));
	}
	
	function getTorrents()
	{
		return $this->mongo->db->torrents->count();
	}
	
	function getRequests()
	{
		return $this->mongo->db->requests->count();
	}
	
	function getRequestsFilled()
	{
		return $this->mongo->db->requests->find(array('filled' => array('$gt' => 0)))->count();
	}

	function getSnatches()
	{
		$map = new MongoCode('function() { emit("snatches", this.snatched); }');
		$reduce = new MongoCode('function(k, v) { var sum = 0; for (var i in v) { sum += v[i]; } return sum; }');
		$res = $this->mongo->db->command(array('mapreduce' => 'torrents', 'map' => $map, 'reduce' => $reduce));
		
		$snatches = $this->mongo->db->selectCollection($res['result'])->findOne();
		return $snatches['value'];
	}
}
?>
