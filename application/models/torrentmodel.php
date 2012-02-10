<?php
class TorrentModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}
	
	function getTorrents($limit = 25, $skip = 0, $query = null) {
		if(!$query)
			$query = array();
		$result = $this->mongo->db->torrents->find()->sort(array('time'=>-1))->limit($limit)->skip($skip);
		return iterator_to_array($result);
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
}
?>
