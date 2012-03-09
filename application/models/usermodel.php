<?php
class UserModel extends CI_Model {

	function __construct()
	{	
		parent::__construct();
	}

	/*
	Gets the data for a given username.
	*/
	function getData($id, $cache = true) {
		if(new MongoId($id) === new MongoId(0)) { //system
			return array('_id' => new MongoId(0), 'username' => 'System', 'title' => 'Totally Not Self-Aware', 'avatar' => $this->config->item('system_avatar'));
		}
		
		if($cache) {
			if(!($data = $this->mcache->get('user_'.$id.'_data'))) {
				$data = $this->mongo->db->users->findOne(array('_id' => new MongoId($id)));
				$this->mcache->set('user_'.$id.'_data', $data, $this->config->item('userdata_cache'));
			}
			return $data;
		} else {
			return $this->mongo->db->users->findOne(array('_id' => new MongoId($id)));
		}
	}
	
	/*
	Builds percentile tables
	*/
	function buildPercentile($w) {
		if(($data = $this->mcache->get('percentile_table_'.$w)) === FALSE) {
			// TODO alright really? this is probably very inefficient
			$field = 'value';
			switch($w) {
				case 0: //uploaded
					$res = $this->mongo->db->users->find()->sort(array("upload"=>1));
					$field = 'upload';
					break;
				case 1: //downloaded
					$res = $this->mongo->db->users->find()->sort(array("download"=>1));
					$field = 'download';
					break;
				case 2: //torrents uploaded
					$map = new MongoCode('function() {emit(this.owner, 1);}');
					$reduce = new MongoCode('function(key,values){var num=0;values.forEach(function(value){num+=value;});return num;}');
					$r = $this->mongo->db->command(array('mapreduce' => 'torrents', 'map' => $map, 'reduce' => $reduce, 'out' => array('replace' => 'tmp')));
					$res = $this->mongo->db->tmp->find()->sort(array("value"=>1));
					break;
				case 3: //requests filled
					$map = new MongoCode('function() {emit(this.filledby, 1);}');
					$reduce = new MongoCode('function(key,values){var num=0;values.forEach(function(value){num+=value;});return num;}');
					$r = $this->mongo->db->command(array('mapreduce' => 'requests', 'map' => $map, 'reduce' => $reduce, 'out' => array('replace' => 'tmp')));
					$res = $this->mongo->db->tmp->find()->sort(array("value"=>1));
					break;
				case 4: // TODO posts made
					break;
				default:
					return null;
					break;
			}
			
			$this->mongo->db->tmp->drop();
			$i = 0;
			foreach ($res as $doc) {
				$doc['order'] = $i;
				$this->mongo->db->tmp->insert($doc);
				$i++;
			}
			$map = new MongoCode('function() {emit(Math.ceil(this.order/('.$i.'/100)), this.'.$field.');}');
			$reduce = new MongoCode('function(key,values){var num=0;return values[0];}');
			$r = $this->mongo->db->command(array('mapreduce' => 'tmp', 'map' => $map, 'reduce' => $reduce, 'out' => array('replace' => 'tmp')));
			$this->mongo->db->tmp->drop();
			
			$data = iterator_to_array($this->mongo->db->tmp->find());
			
			$this->mcache->set('percentile_table_'.$w, $data, $this->config->item('stats_cache'));
		}
		return $data;
	}
	
	function getPercentile($what, $value) {
		if($what == 4) // TODO ^^
			return 0;
		$t = $this->buildPercentile($what);
		$LastPercentile = 0;
		$Percentile = 0;
		foreach($t as $p) {
			if($p['value'] >= $value) {
				return $LastPercentile;
			}
			$LastPercentile++;
		}
		return 100; // 100th percentile
	}
	
	function overallPercentile($ul, $dl, $uploads, $req, $posts, $uploaded, $downloaded) {
		if($uploaded == 0 && $downloaded == 0)
			$ratio = 0;
		else if($uploaded > 0 && $downloaded == 0)
			$ratio = 1;
		else if($uploaded == 0 && $downloaded > 0)
			$ratio = 0;
		else
			$ratio = min($uploaded / $downloaded, 1);
			
		$score = 0;
		$score += $ul * 15;
		$score += $dl * 8;
		$score += $uploads * 25;
		$score += $req * 2;
		$score += $posts * 1;
		$score /= (15+8+25+2+1);
		$score *= $ratio;
		return ceil($score);
	}
	
	function numUploads($id) {
		return $this->mongo->db->torrents->find(array('owner' => new MongoId($id)))->count();
	}
	
	function numRequests($id) {
		return $this->mongo->db->requests->find(array('owner' => new MongoId($id)))->count();
	}
	
	function numPosts($id) {
		// TODO this
		return 0;
	}
	
	function getPermissions($id) {
		if(($data = $this->mcache->get('permissions_'.$id)) === FALSE) {
				$user = $this->getData($id);
				$data = $this->mongo->db->permissions->findOne(array('id' => $user['class']));
				$this->mcache->set('permissions_'.$id, $data, $this->config->item('config_cache'));
		}
		return $data;
	}
	
	function isStaff($id)  {
		$p = $this->getPermissions($id);
		return $p['staff'];
	}
}
?>
