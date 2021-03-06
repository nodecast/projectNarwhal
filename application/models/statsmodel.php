<?php
class StatsModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}

	function getEnabledUsers()
	{
		if(($data = $this->mcache->get('stats_enabled')) === FALSE) {
			$data = $this->mongo->db->users->find(array('enabled'=>1))->count();
			$this->mcache->set('stats_enabled', $data, $this->config->item('stats_cache'));
		}
		return $data;
	}

	function getActiveUsers($timeD)
	{
		$time = time() - $timeD;
		if(($data = $this->mcache->get('stats_active_'.$timeD)) === FALSE) {
			$data = $this->mongo->db->users->find(array('enabled'=>1, 'lastaccess'=>array('$gt'=>$time)))->count();
			$this->mcache->set('stats_active_'.$timeD, $data, $timeD);
		}
		return $data;
	}

	function lastAccess($id)
	{
		$this->mongo->db->users->update(array('_id'=> new MongoId($id)), array('$set' => array('lastaccess'=>time())));
	}
	
	function getTorrents()
	{
		if(($data = $this->mcache->get('stats_torrents')) === FALSE) {
			$data = $this->mongo->db->torrents->count();
			$this->mcache->set('stats_torrents', $data, $this->config->item('stats_cache'));
		}
		return $data;
	}
	
	function getRequests()
	{
		if(($data = $this->mcache->get('stats_requests')) === FALSE) {
			$data = $this->mongo->db->requests->count();
			$this->mcache->set('stats_requests', $data, $this->config->item('stats_cache'));
		}
		return $data;
	}
	
	function getRequestsFilled()
	{
		if(($data = $this->mcache->get('stats_requests_filled')) === FALSE) {
			$data = $this->mongo->db->requests->find(array('filled' => array('$gt' => 0)))->count();
			$this->mcache->set('stats_requests_filled', $data, $this->config->item('stats_cache'));
		}
		return $data;
	}

	function getSnatches()
	{
		if(($data = $this->mcache->get('stats_snatches')) === FALSE) {
			if($this->mongo->db->torrents->count() == 0)
				return 0;
			$map = new MongoCode('function() { emit("snatches", this.snatched); }');
			$reduce = new MongoCode('function(k, v) { var sum = 0; for (var i in v) { sum += v[i]; } return sum; }');
			$res = $this->mongo->db->command(array('mapreduce' => 'torrents', 'map' => $map, 'reduce' => $reduce, 'out' => array('replace' => 'tmp')));
		
			$snatches = $this->mongo->db->tmp->findOne();
			$data = $snatches['value'];
			$this->mcache->set('stats_snatches', $data, $this->config->item('stats_cache'));
		}
		return $data;
	}
}
?>
