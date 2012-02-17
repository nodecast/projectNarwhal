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
	Gets the data for a given torrent
	*/
	function getData($id, $cache = true) {
		if($cache) {
			if(($data = $this->mcache->get('torrent_'.$id.'_data')) === FALSE) {
				$data = $this->mongo->db->torrents->findOne(array('id'=>$id));
				$this->mcache->set('torrent_'.$id.'_data', $data, $this->config->item('torrent_cache'));
			}
			return $data;
		} else {
			return $this->mongo->db->users->findOne(array('id'=>$id));
		}
	}
	
	/*
	Gets the torrent based on an infohash
	*/
	function getByInfohash($hash) {
		return $this->mongo->db->torrents->findOne(array('info_hash' => new MongoBinData($hash)));
	}
}
?>
