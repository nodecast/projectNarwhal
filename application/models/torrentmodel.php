<?php
class TorrentModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}
	
	function getTorrents($limit = 50, $skip = 0, $query = null, $order = 'time', $way = -1) {
		if(!$query)
			$query = array();
		$key = 'torrent_search_'.md5(serialize($query).$limit.$skip.$order.$way);
		
		if(($data = $this->mcache->get($key)) === FALSE) {
			$result = $this->mongo->db->torrents->find($query)->sort(array($order => $way));
			$count = $result->count();
			$result = $result->limit($limit)->skip($skip);
			$result = iterator_to_array($result);
			$data = array('data' => $result, 'count' => $count);
			$this->mcache->set($key, $data, $this->config->item('torrent_cache'));
		}
		return $data;
	}
	
	/*
	Gets torrent comments
	*/
	function getComments($id, $limit = 10, $skip = 0, $cache = true) {
		$data = $this->getData($id, $cache);
		$data = $data['comments'];
		$l = count($data);
		$data = array_slice($data, $skip, $limit);
		return array('data' => $data, 'length' => $l);
	}

	/*
	Gets the data for a given torrent
	*/
	function getData($id, $cache = true) {
		$id = intval($id);
		if($cache) {
			if(($data = $this->mcache->get('torrent_'.$id.'_data')) === FALSE) {
				$data = $this->mongo->db->torrents->findOne(array('id'=>$id));
				$this->mcache->set('torrent_'.$id.'_data', $data, $this->config->item('torrent_cache'));
			}
			return $data;
		} else {
			return $this->mongo->db->torrents->findOne(array('id' => $id));
		}
	}
	
	/*
	Gets the torrent based on an infohash
	*/
	function getByInfohash($hash) {
		return $this->mongo->db->torrents->findOne(array('info_hash' => new MongoBinData($hash)));
	}
	
	/*
	Adds a new tag to a torrent
	*/
	function addTag($id, $tag) {
		$data = $this->getData($id, false);
		$data = $data['tags'];
		$data[] = $tag;
		$data = array_unique($data);
		$this->mongo->db->torrents->update(array('id' => $id), array('$set' => array('tags' => $data)));
	}
	
	/*
	Removes a tag from a torrent
	*/
	function removeTag($id, $tag) {
		$data = $this->getData($id, false);
		$data = $data['tags'];
		foreach($data as $key => $value) {
			if($value == $tag)
				unset($data[$key]);
		}
		$data = array_values($data);
		$this->mongo->db->torrents->update(array('id' => $id), array('$set' => array('tags' => $data)));
	}
	
	/*
	Adds a comment to a torrent
	*/
	function addComment($id, $owner, $body) {
		$c = $this->mongo->db->command(array('findandmodify'=>'counters', 'query'=>array('name'=>'torrentcommentid'), 'update'=>array('$inc'=>array('c'=>1))));
		$push = array('comments' => array('id' => $c['value']['c'], 'time' => time(), 'owner' => $owner, 'body' => $body));
		$this->mongo->db->torrents->update(array('id' => $id), array('$push' => $push));
	}
}
?>
